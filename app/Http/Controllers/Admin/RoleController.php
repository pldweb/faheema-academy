<?php

namespace App\Http\Controllers\Admin;

use App\Helper\TelegramHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function getIndex()
    {
        $params = [
            'data' => Role::withCount('permissions')->orderBy('id', 'DESC')->paginate(10),
            'title' => 'List Data Role',
            'subtitle' => 'Manajemen Hak Akses User',
        ];

        return view('admin.role.index', $params);
    }

    public function postLoadData()
    {
        $data = Role::withCount('permissions')->orderBy('id', 'DESC')->paginate(10);

        return view('admin.role.data', ['data' => $data]);
    }

    public function getShowCreate()
    {
        // Ambil permission & Kelompokkan berdasarkan prefix (user.create -> user)
        $permissions = Permission::all()->groupBy(function ($perm) {
            return explode('.', $perm->name)[0];
        });

        return view('admin.role.create', compact('permissions'));
    }

    public function postEditData(Request $request)
    {
        $id = $request->input('id');
        $role = Role::findById($id);

        if (! $role) {
            return errorAlert('Data tidak ditemukan');
        }

        // Ambil permission & Grouping
        $permissions = Permission::all()->groupBy(function ($perm) {
            return explode('.', $perm->name)[0];
        });

        // Ambil permission yang SUDAH DIMILIKI role ini (untuk auto-checked)
        $rolePermissions = $role->permissions->pluck('name')->toArray();

        return view('admin.role.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    public function postSimpanData(Request $request)
    {
        $id = $request->input('id');
        $name = $request->input('name');

        if (empty($name)) {
            return errorAlert('Nama Role wajib diisi');
        }

        DB::beginTransaction();
        try {
            $role = Role::updateOrCreate(
                ['id' => $id],
                ['name' => $name, 'guard_name' => 'web']
            );

            // Sync Permission (Fitur Spatie)
            // Ini otomatis menghapus yang lama dan memasukkan yang baru dicentang
            if (strtolower($request->name) === 'administrator') {
                $role->syncPermissions(Permission::all());
            } else {
                // Kalau bukan admin, sesuai checkbox
                $permissions = $request->input('permissions') ?? [];
                $role->syncPermissions($permissions);
            }

            DB::commit();

            return successAlert('Role berhasil disimpan', '/admin/role/load-data');

        } catch (\Exception $e) {
            DB::rollBack();

            return errorAlert('Gagal menyimpan: '.$e->getMessage());
        }
    }

    public function postDeleteData(Request $request)
    {
        $id = $request->input('id');
        $role = Role::find($id);

        if (! $role) {
            return errorAlert('Role tidak ditemukan');
        }

        // Proteksi Role Dewa
        if ($role->name === 'administrator' || $role->name === 'super-admin') {
            return errorAlert('Role Administrator tidak boleh dihapus!');
        }

        $role->delete();

        return successAlert('Role berhasil dihapus', '', null, '/admin/role/load-data');
    }

    public function postSyncPermissions()
    {
        try {
            Artisan::call('app:sync-permissions');
            TelegramHelper::sendNotification('Permissions berhasil disinkronisasi');
            //            SendLogAktivitasHelper::sendLogAktivitas('Sinkronisasi Permissions berhasil dilakukan');

            return successAlert('Permissions berhasil disinkronisasi', '', '#message', '/admin/role');

        } catch (\Exception $e) {
            return errorAlert('Gagal sinkronisasi: '.$e->getMessage());
        }
    }
}
