<!DOCTYPE html>
<html lang="en" class="layout-menu-fixed layout-compact" dir="ltr" data-theme="theme-default"
    data-assets-path="{{ asset('assets/') }}" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>BKAD - Sistem Laporan Masyarakat</title>

    <meta name="description" content="Manajemen Laporan Masyarakat BKAD" />

    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.ico') }}" />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" />

    <link rel="stylesheet" href="{{ asset('assets/vendor/css/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/theme-default.css') }}"
        class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />

    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css') }}" />

    <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('assets/js/config.js') }}"></script>
</head>

<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">

            {{-- Sidebar Menu --}}
            <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
                <div class="app-brand demo">
                    {{-- <a href="{{ route('dashboard') }}" class="app-brand-link"> --}}
                        <span class="app-brand-logo demo">
                            {{-- Logo BKAD --}}
                            <i class='bx bxs-buildings text-primary' style="font-size: 2rem;"></i>
                        </span>
                        <span class="app-brand-text demo menu-text fw-bold ms-2">BKAD LAPOR</span>
                    </a>

                    <a href="javascript:void(0);"
                        class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                        <i class="bx bx-chevron-left align-middle"></i>
                    </a>
                </div>

                <div class="menu-inner-shadow"></div>

                <ul class="menu-inner py-1">
                    {{-- Dashboard --}}
                    <li class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        {{-- <a href="{{ route('dashboard') }}" class="menu-link"> --}}
                            <i class="menu-icon tf-icons bx bx-home-circle"></i>
                            <div data-i18n="Analytics">Dashboard</div>
                        </a>
                    </li>

                    {{-- Layanan Publik Section --}}
                    <li class="menu-header small text-uppercase">
                        <span class="menu-header-text">Layanan Publik</span>
                    </li>

                    {{-- Manajemen Laporan --}}
                    <li class="menu-item {{ request()->routeIs('laporan.index') ? 'active' : '' }}">
                        <a href="{{ route('laporan.index') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-message-square-detail"></i>
                            <div data-i18n="Laporan">Manajemen Laporan</div>
                        </a>
                    </li>

                    {{-- Portal Publik (API View) --}}
                    <li class="menu-item {{ request()->routeIs('laporan.publik') ? 'active' : '' }}">
                        <a href="{{ route('laporan.publik') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-globe"></i>
                            <div data-i18n="Portal Publik">Portal Publik</div>
                        </a>
                    </li>

                    {{-- Master Data Section --}}
                    <li class="menu-header small text-uppercase">
                        <span class="menu-header-text">Master Data</span>
                    </li>




                </ul>
            </aside>

            <div class="layout-page">
                {{-- Navbar --}}
                <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
                    id="layout-navbar">
                    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                            <i class="bx bx-menu bx-sm"></i>
                        </a>
                    </div>

                    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                        <ul class="navbar-nav flex-row align-items-center ms-auto">
                            {{-- User Profile --}}
                            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);"
                                    data-bs-toggle="dropdown">
                                    <div class="avatar avatar-online">
                                        <span class="avatar-initial rounded-circle bg-label-primary">
                                            {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                                        </span>
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="avatar avatar-online">
                                                        <span class="avatar-initial rounded-circle bg-label-primary">
                                                            {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <span
                                                        class="fw-semibold d-block">{{ Auth::user()->name ?? 'Administrator' }}</span>
                                                    <small
                                                        class="text-muted">{{ ucfirst(Auth::user()->role ?? 'Petugas') }}</small>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li>
                                    <li>
                                        {{-- <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="dropdown-item">
                                                <i class="bx bx-power-off me-2 text-danger"></i>
                                                <span class="align-middle">Log Out</span>
                                            </button>
                                        </form> --}}
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>

                {{-- Content Wrapper --}}
                <div class="content-wrapper">
                    @yield('content')

                    <footer class="content-footer footer bg-footer-theme">
                        <div
                            class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
                            <div class="mb-2 mb-md-0">
                                ©
                                <script>document.write(new Date().getFullYear());</script>
                                , <strong>BKAD Digital System</strong>
                            </div>
                        </div>
                    </footer>
                    <div class="content-backdrop fade"></div>
                </div>
            </div>
        </div>

        <div class="layout-overlay layout-menu-toggle"></div>
    </div>

    {{-- Core Scripts --}}
    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/menu.js') }}"></script>

    <script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>

    @stack('scripts')

</body>

</html>
