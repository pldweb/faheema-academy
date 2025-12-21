<?php

namespace App\Http\Controllers\Admin;

use App\Helper\SendLogAktivitasHelper;
use App\Helper\TelegramHelper;
use App\Http\Controllers\Controller;
use App\Models\Kategoriproduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KategoriProdukController extends Controller
{
    public function getIndex()
    {
        $params = [
            'data' => DB::table('kategori_produk')->orderBy('created_at')->get(),
            'title' => 'List Data Master Kategori produk',
            'subtitle' => 'Seluruh data master kategori produk',
            'slug' => 'ini slug',
        ];

        return view('admin.kategori-produk.index', $params);
    }

    // reload data table
    public function postLoadData()
    {
        $data = KategoriProdukController::all();

        return view('admin.kategori-produk.data', ['data' => $data]);
    }

    // Menampilkan modal
    public function getShowCreate()
    {
        return view('admin.kategori-produk.create');
    }

    // simpan data kategoriproduk
    public function postSimpanData(Request $request)
    {
        $id = $request->input('id');
        $kategoriprodukId = KategoriProdukController::find($id);

        $kategoriproduk = $request->input('kategori-produk');
        if (strlen(strval($kategoriproduk)) == 0) {
            return errorAlert('Judul Kategori produk Tidak Boleh Kosong');
        }

        $data = ['nama' => $kategoriproduk];

        DB::beginTransaction();
        try {
            if (! $kategoriprodukId) {
                KategoriProdukController::create($data);
                $msg = "📕📕 *Kategori produk Baru Sudah Ditambahkan* 📕📕\n\n";
                $msg .= "Nama Kategori produk: *{$kategoriproduk}*\n";
                $new = true;
                TelegramHelper::sendNotification($msg, 'Markdown');
                SendLogAktivitasHelper::sendLogAktivitas("Kategori produk baru dengan nama $kategoriproduk ditambahkan oleh");
            } else {
                $kategoriprodukId->update($data);
                $msg = "📕📕 *Kategori produk Berhasil Diupdate* 📕📕\n\n";
                $msg .= "Nama Kategori produk: *{$kategoriproduk}*\n";
                $new = false;
                TelegramHelper::sendNotification($msg, 'Markdown');
                SendLogAktivitasHelper::sendLogAktivitas("Kategori produk diupdate dengan nama $kategoriproduk ditambahkan oleh");
            }
            DB::commit();
            if ($new == true) {
                return successAlert('Kategori produk Berhasil ditambahkan ', '/kategori-produk/load-data');
            } else {
                return successAlert('Kategori produk Berhasil diupdate ', '/kategori-produk/load-data');
            }

        } catch (\Exception $exception) {
            DB::rollBack();

            return errorAlert('Kategori produk gagal ditambahkan'.$exception);
        }
    }

    public function postEditData(Request $request)
    {
        $id = $request->input('id');
        $check = KategoriProdukController::find($id);
        if ($check == null) {
            return errorAlert('Tidak ada data dengan ID ini');
        }

        return view('admin.kategori-produk.edit', ['data' => $check]);
    }

    public function postDeleteData(Request $request)
    {
        $id = $request->input('id');
        $kategoriproduk = KategoriProdukController::find($id);
        if ($kategoriproduk == null) {
            return errorAlert('Tidak ada data dengan ID ini');
        } else {
            $msg = "📕📕 *Kategori produk dihapus* 📕📕\n\n";
            $msg .= "Nama Kategori produk: *{$kategoriproduk->nama}*\n";
            SendLogAktivitasHelper::sendLogAktivitas("Kategori produk dengan nama $kategoriproduk->nama dihapus oleh");
            TelegramHelper::sendNotification($msg, 'Markdown');
            $kategoriproduk->delete();

            return successAlert('Berhasil hapus data', '/kategori-produk/load-data');
        }
    }
}
