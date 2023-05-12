@php
    $containerNav = $containerNav ?? 'container-fluid';
    $navbarDetached = $navbarDetached ?? '';
    
@endphp

<!-- Navbar -->
@if (isset($navbarDetached) && $navbarDetached == 'navbar-detached')
    <nav class="layout-navbar {{ $containerNav }} navbar navbar-expand-xl {{ $navbarDetached }} align-items-center bg-navbar-theme"
        id="layout-navbar">
@endif
@if (isset($navbarDetached) && $navbarDetached == '')
    <nav class="layout-navbar navbar navbar-expand-xl align-items-center bg-navbar-theme" id="layout-navbar">
        <div class="{{ $containerNav }}">
@endif

<!--  Brand demo (display only for navbar-full and hide on below xl) -->
@if (isset($navbarFull))
    <div class="navbar-brand app-brand demo d-none d-xl-flex py-0 me-4">
        <a href="{{ url('/') }}" class="app-brand-link">
            <span class="app-brand-logo demo">
                <img src="{{ asset('assets/img/favicon/2.png') }}" style="width:50px;height:30px" />
            </span>
            <span class="app-brand-text menu-text fw-bolder">{{ config('variables.templateName') }}</span>
        </a>
    </div>
@endif

<!-- ! Not required for layout-without-menu -->
@if (!isset($navbarHideToggle))
    <div
        class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0{{ isset($menuHorizontal) ? ' d-xl-none ' : '' }} {{ isset($contentNavbar) ? ' d-xl-none ' : '' }}">
        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
            <i class="bx bx-menu bx-sm"></i>
        </a>
    </div>
@endif
<div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
    <div class="navbar-nav">
        <div class="nav-item">
          <p class="fs-5 mt-3">{{ $tglnow }}</p>
        </div>
    </div>
    <ul class="navbar-nav flex-row align-items-center ms-auto">
        <!-- User -->
        <li class="nav-item navbar-dropdown dropdown-user dropdown">
            @auth
                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                        <img src="{{ asset('assets/img/avatars/2.png') }}" alt class="w-px-40 h-auto rounded-circle">
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="javascript:void(0);">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar avatar-online">
                                        <img src="{{ asset('assets/img/avatars/2.png') }}" alt
                                            class="w-px-40 h-auto rounded-circle">
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <span class="fw-semibold d-block">{{ auth()->user()->karyawan->nama }}</span>
                                    <small class="text-muted">{{ auth()->user()->jobdesk->jobdesk }} {{ auth()->user()->jobdesk->detail_kerja ?? ''}}</small>
                                </div>
                                <div class="flex-grow-1">
                                  <small class="text-muted">{{  auth()->user()->teamdetail->teamlist->list_tim ?? ''}}</small>
                              </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <div class="dropdown-divider"></div>
                    </li>
                    <li>
                        <div class="dropdown-divider"></div>
                    </li>
                    <li>
                        <form action="{{ route('logout') }}" method='post'>
                            @csrf
                            <button type="submit" class="dropdown-item">
                                <i class='bx bx-power-off me-2'></i>
                                <span class="align-middle">Log Out</span>
                            </button>
                        </form>
                    </li>
                @else
                <ul class="list-unstyled">
                    <li>
                        <form action="{{ route('login') }}" method='get'>
                            @csrf
                            <button type="submit" class="dropdown-item">
                                <i class='bx bx-power-off me-2'></i>
                                <span class="align-middle">Login</span>
                            </button>
                        </form>
                    </li>
                @endauth
            </ul>
        </li>
        <!--/ User -->
    </ul>
</div>

@if (!isset($navbarDetached))
    </div>
@endif
</nav>
<!-- / Navbar -->
