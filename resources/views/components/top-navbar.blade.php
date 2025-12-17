<header id="page-topbar" class="isvertical-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="{{url('dashboard')}}" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{asset('images/logo-dark-sm.png')}}" alt="" height="26">
                    </span>
                    <span class="logo-lg">
                        <img src="{{asset('images/logo-dark-sm.png')}}" alt="" height="26">
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

            <!-- start page title -->
            <div class="page-title-box align-self-center d-none d-md-block">
                <h4 class="page-title mb-0">Hi, Selamat Datang!</h4>
            </div>
            <!-- end page title -->

        </div>

        <div class="d-flex">
            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item noti-icon"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="bx bx-search icon-sm align-middle"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0">
                    <form class="p-2">
                        <div class="search-box">
                            <div class="position-relative">
                                <input type="text" class="form-control rounded bg-light border-0" placeholder="Search...">
                                <i class="bx bx-search search-icon"></i>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item user text-start d-flex align-items-center" id="page-header-user-dropdown-v"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-user" src="{{asset('images/users/avatar-3.jpg')}}"
                         alt="Header Avatar">
                    <span class="d-none d-xl-inline-block ms-2 fw-medium font-size-15">{{Auth::user()->nama ?? ''}}</span>
                </button>
                @php
                    $listMenu = \App\Helper\MenuHelper::userDropdown();
                    $user = auth()->user();
                @endphp
                <div class="dropdown-menu dropdown-menu-end pt-0">
                    <div class="p-3 border-bottom">
                        <h6 class="mb-0">{{ $user->nama ?? 'Guest User' }}</h6>
                        <p class="mb-0 font-size-11 text-muted">{{ $user->email ?? '' }}</p>
                    </div>
                    @foreach($listMenu as $menu)
                        {{-- Jika tipe Divider --}}
                        @if(isset($menu['type']) && $menu['type'] === 'divider')
                            <div class="dropdown-divider"></div>
                            @continue
                        @endif
                        {{-- Menu Link Biasa --}}
                        <a class="dropdown-item d-flex align-items-center" href="{{ $menu['url'] }}">
                            <i class="mdi {{ $menu['icon'] }} text-muted font-size-16 align-middle me-2"></i>
                            <span class="align-middle me-3">{{ $menu['label'] }}</span>
                        </a>
                    @endforeach
                    <a id="post-logout" class="dropdown-item text-danger" href="#">
                        <i class="mdi mdi-logout font-size-16 align-middle me-2"></i>
                        <span class="align-middle">Logout</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <script>
        $('#post-logout').click(function(e){
            e.preventDefault();
            $.ajax({
                url: "/auth/logout/logout-action",
                type: "POST",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                },
                success: function (response) {
                    $('#message').html(response);
                    window.location.href = "/login";
                },
                error: function () {
                    alert("Gagal logout!");
                }
            });
        })
    </script>
</header>
