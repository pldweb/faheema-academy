<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function getIndex()
    {
        $params = ['title' => nama_perusahaan()];

        return view('board', $params);
    }
}
