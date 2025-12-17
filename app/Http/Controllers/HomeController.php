<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function getIndex()
    {
        if (Auth::check()) {
            return redirect('/dashboard');
        }

        $params = ['title' => nama_perusahaan()];

        return view('auth.login', $params);
    }

    public function getLogin()
    {
        if (Auth::check()) {
            return redirect('/dashboard');
        }

        $params = ['title' => nama_perusahaan()];

        return view('auth.login', $params);
    }

    public function getRegister()
    {
        $params = ['title' => nama_perusahaan()];

        return view('auth.register', $params);
    }
}
