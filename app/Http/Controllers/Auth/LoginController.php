<?php

namespace App\Http\Controllers\Auth;

use App\Helper\TelegramHelper;
use App\Http\Controllers\Controller;
//use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    public function postLoginAction(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            $redirectURL = url('/dashboard');

            TelegramHelper::sendNotification("$email berhasil login");
            return successAlert('Berhasil Login', null, '', $redirectURL);
        }

        return errorAlert('Email atau password salah');
    }
}
