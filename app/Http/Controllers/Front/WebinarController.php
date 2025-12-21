<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Webinar;

class WebinarController extends Controller
{
    /**
     * Halaman List Webinar
     * URL: /webinar
     */
    public function getIndex()
    {
        // Hanya tampilkan yang aktif dan tanggalnya belum lewat (opsional)
        $webinars = Webinar::aktif()
            ->orderBy('tanggal_mulai', 'asc')
            ->get();

        return view('front.webinar.index', compact('webinars'));
    }

    /**
     * Halaman Detail Webinar
     * URL: /webinar/detail/{slug}
     */
    public function getDetail($slug)
    {
        $webinar = Webinar::aktif()->where('slug', $slug)->firstOrFail();

        return view('front.webinar.detail', compact('webinar'));
    }
}
