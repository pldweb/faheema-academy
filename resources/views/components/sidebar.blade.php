@php use Illuminate\Support\Facades\Request; @endphp
<div class="vertical-menu">

    <!-- LOGO -->
    <div class="navbar-brand-box">
        <a href="{{url('dashboard')}}" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{favicon_url()}}" alt="" height="26">
            </span>
            <span class="logo-lg">
                <img src="{{logo_utama_url()}}" alt="" height="28">
            </span>
        </a>

        <a href="{{url('dashboard')}}" class="logo logo-light">
            <span class="logo-lg">
                <img src="{{logo_utama_url()}}" alt="" height="30">
            </span>
            <span class="logo-sm">
                <img src="{{logo_utama_url()}}" alt="" height="26">
            </span>
        </a>
    </div>

    <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect vertical-menu-btn">
        <i class="bx bx-menu align-middle"></i>
    </button>

    <div data-simplebar class="sidebar-menu-scroll">
        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <ul class="metismenu list-unstyled" id="side-menu">

                @foreach(\App\Helper\MenuHelper::sidebar() as $menu)

                    {{-- 1. HEADER --}}
                    @if($menu['type'] == 'header')
                        <li class="menu-title" data-key="t-menu">{{ $menu['label'] }}</li>

                        {{-- 2. LINK BIASA --}}
                    @elseif($menu['type'] == 'link')
                        {{-- Cek Aktif --}}
                        <li class="{{ Request::is($menu['active_check']) ? 'mm-active' : '' }}">
                            <a href="{{ $menu['url'] }}">
                                <i class="{{ $menu['icon'] }} icon nav-icon"></i>
                                <span class="menu-item">{{ $menu['label'] }}</span>
                            </a>
                        </li>

                        {{-- 3. DROPDOWN --}}
                    @elseif($menu['type'] == 'dropdown')
                        {{-- Cek apakah salah satu anak aktif --}}
                        @php
                            $isActive = false;
                            foreach ($menu['active_check'] as $pattern) {
                                if (Request::is($pattern)) { $isActive = true; break; }
                            }
                        @endphp

                        <li class="{{ $isActive ? 'mm-active' : '' }}">
                            <a href="javascript: void(0);" class="has-arrow">
                                <i class="{{ $menu['icon'] }} icon nav-icon"></i>
                                <span class="menu-item">{{ $menu['label'] }}</span>
                            </a>

                            <ul class="sub-menu {{ $isActive ? 'mm-show' : '' }}" aria-expanded="false">
                                @foreach($menu['items'] as $subItem)
                                    <li class="{{ Request::is($subItem['active_check']) ? 'mm-active' : '' }}">
                                        <a href="{{ $subItem['url'] }}"
                                           class="{{ Request::is($subItem['active_check']) ? 'active' : '' }}">
                                            {{ $subItem['label'] }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>
</div>
