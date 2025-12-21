<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Midtrans\Config;
use Midtrans\Snap;
use App\Models\Kelas;
use App\Models\Paket;
use App\Models\Webinar;
use App\Models\Transaksi;

class PembayaranController extends Controller
{
    public function __construct()
    {
        // Setup Midtrans di Constructor biar rapi
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    /**
     * Proses Checkout KELAS (Reguler/Privat)
     * URL POST: /pembayaran/checkout-kelas
     */
    public function postCheckoutKelas(Request $request)
    {
        // 1. Validasi
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'paket_id' => 'required|exists:paket,id',
        ]);

        $user = Auth::user();
        $kelas = Kelas::find($request->kelas_id);
        $paket = Paket::find($request->paket_id);

        try {
            DB::beginTransaction();

            // 2. Buat Transaksi
            $kodeUnik = 'INV-CLS-' . time() . rand(100, 999);

            $transaksi = Transaksi::create([
                'kode_transaksi' => $kodeUnik,
                'user_id' => $user->id,
                'tipe_produk' => 'kelas',
                'kelas_id' => $kelas->id,
                'paket_id' => $paket->id,
                'total_bayar' => $paket->harga, // Ambil harga dari paket
                'status_pembayaran' => 'menunggu',
            ]);

            // 3. Request Snap Token
            $params = [
                'transaction_details' => [
                    'order_id' => $transaksi->kode_transaksi,
                    'gross_amount' => (int) $transaksi->total_bayar,
                ],
                'customer_details' => [
                    'first_name' => $user->name,
                    'email' => $user->email,
                ],
                'item_details' => [[
                    'id' => $paket->id,
                    'price' => (int) $paket->harga,
                    'quantity' => 1,
                    'name' => "Kelas " . substr($kelas->nama, 0, 20) . " (" . $paket->nama_paket . ")",
                ]]
            ];

            $snapToken = Snap::getSnapToken($params);
            $transaksi->update(['snap_token' => $snapToken]);

            DB::commit();

            return response()->json(['snap_token' => $snapToken]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Proses Checkout WEBINAR
     * URL POST: /pembayaran/checkout-webinar
     */
    public function postCheckoutWebinar(Request $request)
    {
        $request->validate([
            'webinar_id' => 'required|exists:webinar,id',
        ]);

        $user = Auth::user();
        $webinar = Webinar::find($request->webinar_id);

        // Cek Double Order
        $exists = Transaksi::where('user_id', $user->id)
            ->where('webinar_id', $webinar->id)
            ->where('status_pembayaran', 'lunas')
            ->exists();

        if ($exists) {
            return response()->json(['message' => 'Anda sudah terdaftar.'], 400);
        }

        try {
            DB::beginTransaction();

            $kodeUnik = 'INV-WEB-' . time() . rand(100, 999);

            $transaksi = Transaksi::create([
                'kode_transaksi' => $kodeUnik,
                'user_id' => $user->id,
                'tipe_produk' => 'webinar',
                'webinar_id' => $webinar->id,
                'total_bayar' => $webinar->harga,
                'status_pembayaran' => ($webinar->harga == 0) ? 'lunas' : 'menunggu',
            ]);

            // Kalau Gratis, langsung return success
            if ($webinar->harga == 0) {
                DB::commit();
                return response()->json(['status' => 'gratis']);
            }

            // Kalau Bayar, panggil Midtrans
            $params = [
                'transaction_details' => [
                    'order_id' => $transaksi->kode_transaksi,
                    'gross_amount' => (int) $transaksi->total_bayar,
                ],
                'customer_details' => [
                    'first_name' => $user->name,
                    'email' => $user->email,
                ],
                'item_details' => [[
                    'id' => $webinar->id,
                    'price' => (int) $webinar->harga,
                    'quantity' => 1,
                    'name' => "Webinar: " . substr($webinar->judul, 0, 40),
                ]]
            ];

            $snapToken = Snap::getSnapToken($params);
            $transaksi->update(['snap_token' => $snapToken]);

            DB::commit();
            return response()->json(['snap_token' => $snapToken]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
