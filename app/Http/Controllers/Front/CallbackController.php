<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi;

class CallbackController extends Controller
{
    /**
     * Handle Notifikasi dari Midtrans
     * URL POST: /callback/handle
     */
    public function postHandle(Request $request)
    {
        $serverKey = config('services.midtrans.server_key');

        // 1. Validasi Signature Key
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        if ($hashed !== $request->signature_key) {
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        // 2. Cari Transaksi
        $transaksi = Transaksi::where('kode_transaksi', $request->order_id)->first();
        if (!$transaksi) {
            return response()->json(['message' => 'Transaksi tidak ditemukan'], 404);
        }

        // 3. Update Status
        $status = $request->transaction_status;
        $type = $request->payment_type;
        $fraud = $request->fraud_status;

        if ($status == 'capture') {
            if ($type == 'credit_card') {
                if ($fraud == 'challenge') {
                    $transaksi->update(['status_pembayaran' => 'menunggu']);
                } else {
                    $transaksi->update(['status_pembayaran' => 'lunas']);
                }
            }
        } else if ($status == 'settlement') {
            $transaksi->update(['status_pembayaran' => 'lunas']);
        } else if ($status == 'pending') {
            $transaksi->update(['status_pembayaran' => 'menunggu']);
        } else if ($status == 'deny' || $status == 'expire' || $status == 'cancel') {
            $transaksi->update(['status_pembayaran' => 'gagal']);
        }

        return response()->json(['status' => 'oke']);
    }
}
