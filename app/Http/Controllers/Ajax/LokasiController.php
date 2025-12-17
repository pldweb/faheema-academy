<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LokasiController extends Controller
{
    public function getSearch(Request $request)
    {
        $search = $request->input('term'); // Choices.js biasanya kirim parameter 'term'

        if (empty($search) || strlen($search) < 3) {
            return response()->json([]);
        }

        // Query Join 4 Tingkat (Kel -> Kec -> Kab -> Prov)
        $data = DB::table('kelurahans as kel')
            ->join('kecamatans as kec', 'kel.kode_kecamatan', '=', 'kec.kode')
            ->join('kabupatens as kab', 'kec.kode_kabupaten', '=', 'kab.kode')
            ->join('provinsis as prov', 'kab.kode_provinsi', '=', 'prov.kode')
            ->select(
                'kel.kode as value', // Kita simpan KODE WILAYAH-nya (bukan ID auto increment)
                'kel.nama as kelurahan',
                'kel.kode_pos',
                'kec.nama as kecamatan',
                'kab.nama as kabupaten',
                'prov.nama as provinsi'
            )
            ->where('kel.nama', 'LIKE', "%$search%")
            ->orWhere('kel.kode_pos', 'LIKE', "$search%") // Cari kode pos dari depan
            ->orWhere('kec.nama', 'LIKE', "%$search%")
            ->limit(20) // Batasi 20 hasil biar ringan
            ->get();

        // Format JSON sesuai selera Choices.js
        $results = $data->map(function ($item) {
            $pos = $item->kode_pos ? "({$item->kode_pos})" : '';

            return [
                'value' => $item->value, // Contoh: 11.01.01.2001
                'label' => "{$item->kelurahan}, {$item->kecamatan}, {$item->kabupaten}, {$item->provinsi} {$pos}",
            ];
        });

        return response()->json($results);
    }
}
