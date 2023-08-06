<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    @php
        use Illuminate\Support\Facades\DB;
    @endphp

    <!-- ! Hide app brand if navbar-full -->
    <div class="app-brand demo">
        <a href="{{ url('/') }}" class="app-brand-link">
            <span class="app-brand-logo demo">
                <img src="{{ asset('assets/img/favicon/logo.png') }}" style="width:50px;height:30px" />
            </span>
            <span class="app-brand-text demo menu-text fw-bold ms-2">{{ config('variables.templateName') }}</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-autod-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>
    @auth
        @if (auth()->user()->jobdesk->jobdesk == 'Master')
            <ul class="menu-inner py-1">
                @foreach ($menuData[0]->menu as $menu)
                    {{-- adding active and open class if child is active --}}

                    {{-- menu headers --}}
                    @if (isset($menu->menuHeader))
                        <li class="menu-header small text-uppercase">
                            <span class="menu-header-text">{{ $menu->menuHeader }}</span>
                        </li>
                    @else
                        {{-- active menu method --}}
                        @php
                            $activeClass = null;
                            $currentRouteName = Route::currentRouteName();
                            
                            if (empty($nickname)) {
                                if ($currentRouteName === $menu->slug) {
                                    $activeClass = 'active';
                                } elseif (isset($menu->submenu)) {
                                    if (gettype($menu->slug) === 'array') {
                                        foreach ($menu->slug as $slug) {
                                            if (str_contains($currentRouteName, $slug) and strpos($currentRouteName, $slug) === 0) {
                                                $activeClass = 'active open';
                                            }
                                        }
                                    } else {
                                        if (str_contains($currentRouteName, $menu->slug) and strpos($currentRouteName, $menu->slug) === 0) {
                                            $activeClass = 'active open';
                                        }
                                    }
                                }
                            } else {
                                if ($currentRouteName === $menu->slug || $menu->slug == $nickname) {
                                    $activeClass = 'active';
                                } elseif (isset($menu->submenu)) {
                                    if (gettype($menu->slug) === 'array') {
                                        foreach ($menu->slug as $slug) {
                                            if (str_contains($currentRouteName, $slug) and strpos($currentRouteName, $slug) === 0) {
                                                $activeClass = 'active open';
                                            }
                                        }
                                    } else {
                                        if (str_contains($currentRouteName, $menu->slug) and strpos($currentRouteName, $menu->slug) === 0) {
                                            $activeClass = 'active open';
                                        }
                                    }
                                }
                            }
                        @endphp

                        {{-- main menu --}}
                        <li class="menu-item {{ $activeClass }}">
                            <a href="{{ isset($menu->url) ? url($menu->url) : 'javascript:void(0);' }}"
                                class="{{ isset($menu->submenu) ? 'menu-link menu-toggle' : 'menu-link' }}"
                                @if (isset($menu->target) and !empty($menu->target)) target="_blank" @endif>
                                @isset($menu->icon)
                                    <i class="{{ $menu->icon }}"></i>
                                @endisset
                                <div class="me-auto">{{ isset($menu->name) ? __($menu->name) : '' }}</div>
                                @if ($menu->name == 'Tiket Pasang Baru')
                                    <div class="badge bg-primary rounded-pill">0</div>
                                @endif
                                @if ($menu->name == 'Tiket Gangguan')
                                    <div class="badge bg-primary rounded-pill">0</div>
                                @endif
                                @if ($menu->name == 'Tiket Maintenance')
                                    <div class="badge bg-primary rounded-pill">0</div>
                                @endif
                            </a>

                            {{-- submenu --}}
                            @isset($menu->submenu)
                                @include('layouts.sections.menu.submenu', ['menu' => $menu->submenu])
                            @endisset
                        </li>
                    @endif
                @endforeach
            </ul>
        @endif

        @if (auth()->user()->jobdesk->jobdesk == 'Teknisi')
            <ul class="menu-inner py-1">
                @foreach ($menuData[1]->menu as $menu)
                    {{-- adding active and open class if child is active --}}

                    {{-- menu headers --}}
                    @if (isset($menu->menuHeader))
                        <li class="menu-header small text-uppercase">
                            <span class="menu-header-text">{{ $menu->menuHeader }}</span>
                        </li>
                    @else
                        {{-- active menu method --}}
                        @php
                            $activeClass = null;
                            $currentRouteName = Route::currentRouteName();
                            
                            if (empty($nickname)) {
                                if ($currentRouteName === $menu->slug) {
                                    $activeClass = 'active';
                                } elseif (isset($menu->submenu)) {
                                    if (gettype($menu->slug) === 'array') {
                                        foreach ($menu->slug as $slug) {
                                            if (str_contains($currentRouteName, $slug) and strpos($currentRouteName, $slug) === 0) {
                                                $activeClass = 'active open';
                                            }
                                        }
                                    } else {
                                        if (str_contains($currentRouteName, $menu->slug) and strpos($currentRouteName, $menu->slug) === 0) {
                                            $activeClass = 'active open';
                                        }
                                    }
                                }
                            } else {
                                if ($currentRouteName === $menu->slug || $menu->slug == $nickname) {
                                    $activeClass = 'active';
                                } elseif (isset($menu->submenu)) {
                                    if (gettype($menu->slug) === 'array') {
                                        foreach ($menu->slug as $slug) {
                                            if (str_contains($currentRouteName, $slug) and strpos($currentRouteName, $slug) === 0) {
                                                $activeClass = 'active open';
                                            }
                                        }
                                    } else {
                                        if (str_contains($currentRouteName, $menu->slug) and strpos($currentRouteName, $menu->slug) === 0) {
                                            $activeClass = 'active open';
                                        }
                                    }
                                }
                            }
                        @endphp

                        {{-- main menu --}}
                        <li class="menu-item {{ $activeClass }}">
                            <a href="{{ isset($menu->url) ? url($menu->url) : 'javascript:void(0);' }}"
                                class="{{ isset($menu->submenu) ? 'menu-link menu-toggle' : 'menu-link' }}"
                                @if (isset($menu->target) and !empty($menu->target)) target="_blank" @endif>
                                @isset($menu->icon)
                                    <i class="{{ $menu->icon }}"></i>
                                @endisset
                                <div class="me-auto">{{ isset($menu->name) ? __($menu->name) : '' }}</div>
                                @if (auth()->user()->jobdesk->jenistiket->nama_tiket == 'Pasang Baru')
                                    @if ($menu->name == 'Rekap Tiket')
                                        <div class="badge bg-primary rounded-pill">
                                            @php
                                                $count = DB::table('tiket_tim')
                                                    ->whereMonth('created_at', date('m'))
                                                    ->where('status', 'Revisi')
                                                    ->where('id_j_tiket', '2')
                                                    ->count();
                                            @endphp
                                            {{ $count }}
                                        </div>
                                    @endif
                                @endif
                            </a>

                            {{-- submenu --}}
                            @isset($menu->submenu)
                                @include('layouts.sections.menu.submenu', ['menu' => $menu->submenu])
                            @endisset
                        </li>
                    @endif
                @endforeach
            </ul>
        @endif

        @if (auth()->user()->jobdesk->jobdesk == 'Admin')
            <ul class="menu-inner py-1">
                
                @foreach ($menuData[2]->menu as $menu)
                    {{-- adding active and open class if child is active --}}

                    {{-- menu headers --}}
                    @if (isset($menu->menuHeader))
                        <li class="menu-header small text-uppercase">
                            <span class="menu-header-text">{{ $menu->menuHeader }}</span>
                        </li>
                    @else
                        {{-- active menu method --}}
                        @php
                            $activeClass = null;
                            $currentRouteName = Route::currentRouteName();

                            if (empty($nickname)) {
                                if ($currentRouteName === $menu->slug) {
                                    $activeClass = 'active';
                                } elseif (isset($menu->submenu)) {
                                    if (gettype($menu->slug) === 'array') {
                                        foreach ($menu->slug as $slug) {
                                            if (str_contains($currentRouteName, $slug) and strpos($currentRouteName, $slug) === 0) {
                                                $activeClass = 'active open';
                                            }
                                        }
                                    } else {
                                        if (str_contains($currentRouteName, $menu->slug) and strpos($currentRouteName, $menu->slug) === 0) {
                                            $activeClass = 'active open';
                                        }
                                    }
                                }
                            } else {
                                if ($currentRouteName === $menu->slug || $menu->slug == $nickname) {
                                    $activeClass = 'active';
                                } elseif (isset($menu->submenu)) {
                                    if (gettype($menu->slug) === 'array') {
                                        foreach ($menu->slug as $slug) {
                                            if (str_contains($currentRouteName, $slug) and strpos($currentRouteName, $slug) === 0) {
                                                $activeClass = 'active open';
                                            }
                                        }
                                    } else {
                                        if (str_contains($currentRouteName, $menu->slug) and strpos($currentRouteName, $menu->slug) === 0) {
                                            $activeClass = 'active open';
                                        }
                                    }
                                }
                            }
                            
                        @endphp

                        {{-- main menu --}}
                        <li class="menu-item {{ $activeClass }}">
                            <a href="{{ isset($menu->url) ? url($menu->url) : 'javascript:void(0);' }}"
                                class="{{ isset($menu->submenu) ? 'menu-link menu-toggle' : 'menu-link' }}"
                                @if (isset($menu->target) and !empty($menu->target)) target="_blank" @endif>
                                @isset($menu->icon)
                                    <i class="{{ $menu->icon }}"></i>
                                @endisset
                                <div class="me-auto">{{ isset($menu->name) ? __($menu->name) : '' }}</div>
                                @if ($menu->name == 'Tiket Pasang Baru')
                                    <div class="badge bg-primary rounded-pill">
                                        @php
                                            $count = DB::table('tiket_tim')
                                                ->whereMonth('created_at', date('m'))
                                                ->where('status', 'Belum di cek')
                                                ->where('id_j_tiket', '2')
                                                ->count();
                                        @endphp
                                        {{ $count }}</div>
                                @endif
                                @if ($menu->name == 'Tiket Gangguan')
                                    <div class="badge bg-primary rounded-pill">
                                        @php
                                            $count = DB::table('tiket_tim')
                                                ->whereMonth('created_at', date('m'))
                                                ->where('status', 'input baru')
                                                ->count();
                                        @endphp
                                        {{ $count }}
                                    </div>
                                @endif
                                @if ($menu->name == 'Tiket Maintenance')
                                    <div class="badge bg-primary rounded-pill">0</div>
                                @endif
                            </a>

                            {{-- submenu --}}
                            @isset($menu->submenu)
                                @include('layouts.sections.menu.submenu', ['menu' => $menu->submenu])
                            @endisset
                        </li>
                    @endif
                @endforeach
            </ul>
        @endif
    @endauth

</aside>
