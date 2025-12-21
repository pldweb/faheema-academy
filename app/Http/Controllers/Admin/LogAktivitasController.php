<?php

namespace App\Http\Controllers\Admin;

use App\Helper\TelegramHelper;
use App\Http\Controllers\Controller;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;

class LogAktivitasController extends Controller
{
    public function getIndex()
    {
        $query = LogAktivitas::latest('waktu')->get();

        $params = [
            'data' => $query,
            'title' => 'List Data Master Log Aktivitas',
            'subtitle' => 'Seluruh data master Log Aktivitas',
        ];

        return view('admin.log-aktivitas.index', $params);
    }

    // reload data table
    public function postLoadData()
    {
        $data = LogAktivitas::all();

        return view('admin.log-aktivitas.data', ['data' => $data]);
    }

    public function postEditData(Request $request)
    {
        $id = $request->input('id');
        $check = LogAktivitas::find($id);
        if ($check == null) {
            return errorAlert('Tidak ada data dengan ID ini');
        }

        return view('admin.log-aktivitas.edit', ['data' => $check]);
    }

    public function postDeleteData(Request $request)
    {
        $id = $request->input('id');
        $logAktivitas = LogAktivitas::find($id);
        if ($logAktivitas == null) {
            return errorAlert('Tidak ada data dengan ID ini');
        } else {
            $msg = "📕📕 *Log Aktivitas dihapus* 📕📕\n\n";
            $msg .= "Nama LogAktivitas: *{$logAktivitas->nama}*\n";
            $logAktivitas->delete();

            TelegramHelper::sendNotification($msg, 'Markdown');

            return successAlert('Berhasil hapus data', '/logAktivitas/load-data');
        }
    }
}
