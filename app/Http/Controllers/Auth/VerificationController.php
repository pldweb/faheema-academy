<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
// use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class VerificationController extends Controller
{
    //    use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function postSendEmail(Request $request)
    {
        $email = $request->input('email');
        $nama = $request->input('nama', 'Pinjam Buku');

        Mail::raw("Halo $nama, ini testing dari Perpustakaan Rinkweb!", function ($message) use ($email) {
            $message->to($email)
                ->subject('Queue Mail Rinkweb Studio');
        });

        return successAlert('Silakan Cek Email Anda', null, '', '/test-queue');
    }
}
