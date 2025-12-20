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
                'label' => 'Settings',
                'url' => url('admin/setting'),
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
        ];
    }
}
