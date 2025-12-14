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
                'url' => url('profile'),
                'icon' => 'mdi-account-circle',
            ],
            [
                'type' => 'link',
                'label' => 'Messages',
                'url' => '#',
                'icon' => 'mdi-message-text-outline',
            ],
            [
                'type' => 'link',
                'label' => 'Help',
                'url' => '#',
                'icon' => 'mdi-lifebuoy',
            ],
            [
                'type' => 'link',
                'label' => 'Settings',
                'url' => '#',
                'icon' => 'mdi-cog-outline',
                'badge' => [ // Support badge dinamis
                    'text' => 'New',
                    'class' => 'bg-success-subtle text-success'
                ]
            ],
            [
                'type' => 'link',
                'label' => 'Lock screen',
                'url' => '#', // route('lock-screen')
                'icon' => 'mdi-lock',
            ],
            [
                'type' => 'divider', // Pemisah
            ],
            [
                'type' => 'logout',
                'label' => 'Logout',
                'icon' => 'mdi-logout',
            ],
        ];
    }

    public static function sidebar()
    {
        return [
            // 1. SECTION TITLE
            [
                'type' => 'title',
                'label' => 'Dashboard',
                'key' => 't-menu',
            ],
            // 2. MENU DENGAN SUB-MENU & BADGE
            [
                'type' => 'link',
                'label' => 'Dashboard',
                'icon' => 'bx-home-alt',
                'key' => 't-dashboard',
            ],

            // 3. SECTION TITLE BARU
            [
                'type' => 'title',
                'label' => 'Applications',
                'key' => 't-applications',
            ],

            // 4. MENU TUNGGAL (SINGLE LINK)
            [
                'type' => 'link',
                'label' => 'Calendar',
                'icon' => 'bx-calendar-event',
                'route' => 'calendar.index',
                'key' => 't-calendar',
            ],
            [
                'type' => 'link',
                'label' => 'Chat',
                'icon' => 'bx-chat',
                'route' => 'chat.index',
                'key' => 't-chat',
                'badge' => ['text' => 'Hot', 'class' => 'bg-danger'],
            ],

            // 5. MENU MULTI LEVEL (CONTOH LEVEL 3)
            [
                'type' => 'dropdown',
                'label' => 'Multi Level',
                'icon' => 'bx-share-alt',
                'key' => 't-multi-level',
                'children' => [
                    ['label' => 'Level 1.1', 'url' => '#', 'key' => 't-level-1-1'],
                    [
                        'label' => 'Level 1.2',
                        'key' => 't-level-1-2',
                        'children' => [ // Anak cucu
                            ['label' => 'Level 2.1', 'url' => '#', 'key' => 't-level-2-1'],
                            ['label' => 'Level 2.2', 'url' => '#', 'key' => 't-level-2-2'],
                        ]
                    ],
                ]
            ],
        ];
    }
}
