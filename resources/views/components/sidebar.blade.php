@php use Illuminate\Support\Facades\Route; @endphp
<div class="vertical-menu">

    <!-- LOGO -->
    <div class="navbar-brand-box">
        <a href="{{url('dashboard')}}" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{asset('images/logo-dark-sm.png')}}" alt="" height="26">
            </span>
            <span class="logo-lg">
                <img src="{{asset('images/logo-dark.png')}}" alt="" height="28">
            </span>
        </a>

        <a href="{{url('dashboard')}}" class="logo logo-light">
            <span class="logo-lg">
                <img src="{{asset('images/logo-light.png')}}" alt="" height="30">
            </span>
            <span class="logo-sm">
                <img src="{{asset('images/logo-light-sm.png')}}" alt="" height="26">
            </span>
        </a>
    </div>

    <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect vertical-menu-btn">
        <i class="bx bx-menu align-middle"></i>
    </button>

    <div data-simplebar class="sidebar-menu-scroll">
        @php
            $menus = \App\Helper\MenuHelper::sidebar();
            // Fungsi kecil untuk cek active state (Biar kodingan bersih)
            function isActive($route = null) {
                if ($route && \Illuminate\Support\Facades\Route::has($route)) {
                    return request()->routeIs($route) ? 'mm-active' : ''; // Class active bawaan template
                }
                return '';
            }

            // Fungsi cek jika child ada yang active (untuk parent)
            function isParentActive($children) {
                foreach ($children as $child) {
                    if (isset($child['route']) && isActive($child['route'])) return 'mm-active';
                    if (isset($child['children'])) {
                        if (isParentActive($child['children'])) return 'mm-active';
                    }
                }
                return '';
            }
        @endphp

        <div id="sidebar-menu">
            <ul class="metismenu list-unstyled" id="side-menu">
                @foreach($menus as $menu)
                    {{-- CASE 1: JUDUL (TITLE) --}}
                    @if(isset($menu['type']) && $menu['type'] === 'title')
                        <li class="menu-title" data-key="{{ $menu['key'] ?? '' }}">{{ $menu['label'] }}</li>
                        @continue
                    @endif

                    {{-- Setup Variabel Umum --}}
                    @php
                        $hasChildren = isset($menu['children']) && count($menu['children']) > 0;
                        $url = isset($menu['route']) && Route::has($menu['route']) ? route($menu['route']) : ($menu['url'] ?? 'javascript: void(0);');
                        $activeClass = $hasChildren ? isParentActive($menu['children']) : (isset($menu['route']) ? isActive($menu['route']) : '');
                    @endphp

                    <li class="{{ $activeClass }}">
                        <a href="{{ $url }}" class="{{ $hasChildren ? 'has-arrow' : '' }}" aria-expanded="{{ $activeClass ? 'true' : 'false' }}">
                            <i class="bx {{ $menu['icon'] }} icon nav-icon"></i>
                            <span class="menu-item" data-key="{{ $menu['key'] ?? '' }}">{{ $menu['label'] }}</span>

                            {{-- Badge Logic --}}
                            @if(isset($menu['badge']))
                                <span class="badge rounded-pill {{ $menu['badge']['class'] }}" data-key="{{ $menu['key'] ?? '' }}">
                            {{ $menu['badge']['text'] }}
                        </span>
                            @endif
                        </a>

                        {{-- CASE 2: PUNYA ANAK (DROPDOWN) --}}
                        @if($hasChildren)
                            <ul class="sub-menu" aria-expanded="{{ $activeClass ? 'true' : 'false' }}">
                                @foreach($menu['children'] as $child)
                                    @php
                                        $hasGrandChildren = isset($child['children']) && count($child['children']) > 0;
                                        $childUrl = isset($child['route']) && Route::has($child['route']) ? route($child['route']) : ($child['url'] ?? 'javascript: void(0);');
                                        $childActive = $hasGrandChildren ? isParentActive($child['children']) : (isset($child['route']) ? isActive($child['route']) : '');
                                    @endphp

                                    <li class="{{ $childActive }}">
                                        <a href="{{ $childUrl }}" class="{{ $hasGrandChildren ? 'has-arrow' : '' }}" data-key="{{ $child['key'] ?? '' }}" aria-expanded="{{ $childActive ? 'true' : 'false' }}">
                                            {{ $child['label'] }}
                                        </a>

                                        {{-- CASE 3: PUNYA CUCU (MULTI LEVEL) --}}
                                        @if($hasGrandChildren)
                                            <ul class="sub-menu" aria-expanded="{{ $childActive ? 'true' : 'false' }}">
                                                @foreach($child['children'] as $grandChild)
                                                    <li>
                                                        <a href="{{ isset($grandChild['route']) ? route($grandChild['route']) : ($grandChild['url'] ?? '#') }}"
                                                           data-key="{{ $grandChild['key'] ?? '' }}">
                                                            {{ $grandChild['label'] }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
