<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kantor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function getIndex()
    {
        $users = User::query()->first() ?? new Kantor;
        $params = [
            'user' => $users,
            'title' => 'Pengaturan User',
        ];
        return view('admin.profile.index', $params);
    }
}
