<?php

namespace App\Http\Controllers\Front\Kelas;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\Kelas;
use App\Models\Paket;
use App\Models\Program;

class QuranController extends Controller
{
    public function getIndex()
    {
        // Ambil kategori 'Quran' (sesuaikan slug dengan db kamu)
        $kategori = Kategori::where('slug', 'quran')->firstOrFail();

        // Ambil program di bawahnya
        $programs = Program::where('kategori_id', $kategori->id)->get();

        return view('front.quran.index', compact('kategori', 'programs'));
    }

    /**
     * Halaman List Kelas dalam satu Program
     * URL: /quran/program/{slug}
     */
    public function getProgram($slug)
    {
        $program = Program::where('slug', $slug)->firstOrFail();
        $kelases = Kelas::aktif()->where('program_id', $program->id)->get();

        return view('front.quran.program', compact('program', 'kelases'));
    }

    /**
     * Halaman Detail Kelas & Pilihan Harga (Paket)
     * URL: /quran/kelas/{slug}
     */
    public function getKelas($slug)
    {
        $kelas = Kelas::aktif()->where('slug', $slug)->firstOrFail();

        // Ambil semua paket harga (Regular & Privat)
        // Nanti di view dipisah pakai if($paket->tipe == 'reguler')
        $pakets = Paket::all();

        return view('front.quran.detail', compact('kelas', 'pakets'));
    }
}
