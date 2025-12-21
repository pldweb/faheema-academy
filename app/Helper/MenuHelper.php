<?php

namespace App\Helper;

class MenuHelper
{
    public static function userDropdown()
    {
        return [
            [
                'type' => 'link',
                'label' => 'Profile',
                'url' => url('admin/profile'),
                'icon' => 'mdi-account-circle',
            ],
            [
                'type' => 'link',
                'label' => 'Halaman Depan',
                'url' => web_url(''),
                'icon' => 'mdi-cog-outline',
            ],
        ];
    }

    public static function sidebar()
    {
        return [
            [
                'type' => 'header',
                'label' => 'Dashboard',
            ],
            [
                'type' => 'link',
                'label' => 'Dashboard',
                'url' => url('dashboard'),
                'icon' => 'bx bx-home-alt',
                'active_check' => 'dashboard*', // Pola URL buat cek aktif
            ],
            [
                'type' => 'link',
                'label' => 'Log Aktivitas',
                'url' => url('admin/log-aktivitas'),
                'icon' => 'bx bx-time-five',
                'active_check' => 'log-aktivitas*',
            ],
            [
                'type' => 'header',
                'label' => 'Administration',
            ],
            [
                'type' => 'link',
                'label' => 'Data Kantor',
                'url' => url('admin/kantor'),
                'icon' => 'bx bx-building',
                'active_check' => 'kantor*',
            ],
            [
                'type' => 'link',
                'label' => 'Hak Akses',
                'url' => url('admin/role'),
                'icon' => 'bx bx-lock',
                'active_check' => 'kantor*',
            ],
            [
                'type' => 'link',
                'label' => 'Data User',
                'url' => url('admin/user'),
                'icon' => 'bx bx-user',
                'active_check' => 'kantor*',
            ],
            [
                'type' => 'dropdown', // Tipe Dropdown
                'label' => 'Email',
                'icon' => 'bx bx-envelope',
                'active_check' => ['setting*', 'info*'], // Array pola URL
                'items' => [
                    [
                        'label' => 'Setting',
                        'url' => url('setting'),
                        'active_check' => 'setting*',
                    ],
                    [
                        'label' => 'Info',
                        'url' => url('info'),
                        'active_check' => 'info*',
                    ],
                ],
            ],
            [
                "type" => "header",
                'label' => 'Produk Kelas',
            ],
            [
                'type' => 'link',
                'label' => 'Kategori Kelas',
                'url' => url('admin/kategori-produk'),
                'icon' => 'bx bx-layer',
                'active_check' => 'kelas*',
            ],
            [
                'type' => 'link',
                'label' => 'Produk Kelas',
                'url' => url('admin/produk-kelas'),
                'icon' => 'bx bx-store-alt',
                'active_check' => 'produk-kelas*',
            ],
            [
                'type' => 'link',
                'label' => 'Transaksi Kelas',
                'url' => url('admin/transaksi-kelas'),
                'icon' => 'bx bx-money',
                'active_check' => 'kantor*',
            ],
            [
                "type" => "header",
                'label' => 'Manajemen Tim',
            ],
            [
                'type' => 'link',
                'label' => 'Laporan Kinerja',
                'url' => url('admin/laporan-kinerja'),
                'icon' => 'bx bxs-report',
                'active_check' => 'kantor*',
            ],
        ];
    }
}
