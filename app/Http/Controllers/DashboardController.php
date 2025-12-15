<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function getIndex()
    {
        $params = ['title' => nama_perusahaan()];
        return view('board', $params);
    }
}
