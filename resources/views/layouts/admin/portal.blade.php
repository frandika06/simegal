<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    {{-- META --}}
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="ROBOTS" content="noindex, nofollow" />
    <meta name="author" content="Dinas Perindustrian dan Perdagangan Kabupaten Tangerang" />
    <meta name="application-name" content="@stack('apps')" />
    <meta name="description" content="@stack('apps') | @stack('description')" />
    <meta name="keywords" content="@stack('apps') | @stack('description')" />
    <meta property="og:locale" content="{{ app()->getLocale() }}" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="@stack('title')" />
    <meta property="og:url" content="{{ \URL::current() }}" />
    <meta property="og:site_name" content="@stack('title')" />
    <link rel="canonical" href="{{ \URL::current() }}" />
    <title>@stack('title')</title>
    {{-- META --}}
    {{-- FAVICON --}}
    <meta name="msapplication-TileImage" content="{{ asset('assets-portal/dist/css/img/favicon/ms-icon-144x144.png') }}" />
    <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('assets-portal/dist/img/favicon/apple-icon-57x57.png') }}" />
    <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('assets-portal/dist/img/favicon/apple-icon-60x60.png') }}" />
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('assets-portal/dist/img/favicon/apple-icon-72x72.png') }}" />
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets-portal/dist/img/favicon/apple-icon-76x76.png') }}" />
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('assets-portal/dist/img/favicon/apple-icon-114x114.png') }}" />
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('assets-portal/dist/img/favicon/apple-icon-120x120.png') }}" />
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('assets-portal/dist/img/favicon/apple-icon-144x144.png') }}" />
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('assets-portal/dist/img/favicon/apple-icon-152x152.png') }}" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets-portal/dist/img/favicon/apple-icon-180x180.png') }}" />
    <link rel="icon" type="image/png" sizes="36x36" href="{{ asset('assets-portal/dist/img/favicon/android-icon-36x36.png') }}" />
    <link rel="icon" type="image/png" sizes="48x48" href="{{ asset('assets-portal/dist/img/favicon/android-icon-48x48.png') }}" />
    <link rel="icon" type="image/png" sizes="72x72" href="{{ asset('assets-portal/dist/img/favicon/android-icon-72x72.png') }}" />
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('assets-portal/dist/img/favicon/android-icon-96x96.png') }}" />
    <link rel="icon" type="image/png" sizes="144x144" href="{{ asset('assets-portal/dist/img/favicon/android-icon-144x144.png') }}" />
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('assets-portal/dist/img/favicon/android-icon-192x192.png') }}" />
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets-portal/dist/img/favicon/favicon-32x32.png') }}" />
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('assets-portal/dist/img/favicon/favicon-96x96.png') }}" />
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets-portal/dist/img/favicon/favicon-16x16.png') }}" />
    <link rel="manifest" href="{{ asset('assets-portal/dist/img/favicon/manifest.json') }}" />
    {{-- FAVICON --}}

    {{-- css-js::begin --}}
    <link href="{{ asset('assets-admin/plugins/wow-master/css/libs/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('assets-admin/plugins/bootstrap-select/dist/css/bootstrap-select.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets-admin/plugins/bootstrap-select-country/css/bootstrap-select-country.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets-admin/plugins/jquery-nice-select/css/nice-select.css') }}">
    <link href="{{ asset('assets-admin/plugins/datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets-admin/plugins/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    {{-- swiper-slider --}}
    <link rel="stylesheet" href="{{ asset('assets-admin/plugins/swiper/css/swiper-bundle.min.css') }}">
    <!-- Custom Stylesheet -->
    <link href="vendor/jquery-nice-select/css/nice-select.css" rel="stylesheet">
    {{-- Style css --}}
    <link href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet">
    <link href="{{ asset('assets-admin/dist/css/style.css') }}" rel="stylesheet">
    {{-- Internal Sweet-Alert css --}}
    <link href="{{ asset('assets-admin/plugins/sweet-alert/sweetalert.css') }}" rel="stylesheet" />
    {{-- css custom --}}
    <link href="{{ asset('assets-admin/dist/css/cid.css?v=') . date('ymdHis') }}" rel="stylesheet">
    {{-- css-js::end --}}

    {{-- stack css --}}
    @stack('styles')
    {{-- stack css --}}
</head>

<body>
    {{-- preloader::begin --}}
    <div id="preloader">
        <div class="loader">
            <div class="dots">
                <div class="dot mainDot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
            </div>
        </div>
    </div>
    {{-- preloader::end --}}

    {{-- wrapper::start --}}
    <div id="main-wrapper">
        {{-- nav-header::begin --}}
        <div class="nav-header">
            <a href="{{ route('prt.apps.home.index') }}" class="brand-logo">
                <img src="{{ asset('assets-portal/dist/img/logo.png') }}" class="logo-abbr" width="35" height="40" alt="SIMEGAL">
                <div class="brand-title">
                    <img src="{{ asset('assets-portal/dist/img/text-white.png') }}" style="140" height="30" alt="SIMEGAL">
                </div>
            </a>

            <div class="nav-control">
                <div class="hamburger">
                    <span class="line"></span><span class="line"></span><span class="line"></span>
                    <svg width="26" height="26" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="22" y="11" width="4" height="4" rx="2" fill="#2A353A" />
                        <rect x="11" width="4" height="4" rx="2" fill="#2A353A" />
                        <rect x="22" width="4" height="4" rx="2" fill="#2A353A" />
                        <rect x="11" y="11" width="4" height="4" rx="2" fill="#2A353A" />
                        <rect x="11" y="22" width="4" height="4" rx="2" fill="#2A353A" />
                        <rect width="4" height="4" rx="2" fill="#2A353A" />
                        <rect y="11" width="4" height="4" rx="2" fill="#2A353A" />
                        <rect x="22" y="22" width="4" height="4" rx="2" fill="#2A353A" />
                        <rect y="22" width="4" height="4" rx="2" fill="#2A353A" />
                    </svg>
                </div>
            </div>
        </div>
        {{-- nav-header::end --}}

        {{-- header::begin --}}
        @include('layouts.admin.headers.headers')
        {{-- header::end --}}

        {{-- sidebar::begin --}}
        @include('layouts.admin.menus.menus')
        {{-- sidebar::end --}}

        {{-- content::begin --}}
        @yield('content')
        {{-- content::end --}}

        {{-- footer::begin --}}
        <div class="footer out-footer style-2">
            <div class="copyright">
                <p>&copy; 2023 . Dinas Perindustrian dan Perdagangan Kabupaten Tangerang</p>
            </div>
        </div>
        {{-- footer::end --}}

        {{-- modals::begin --}}
        @stack('modals')
        {{-- modals::end --}}
    </div>
    {{-- wrapper::end --}}


    {{-- javascript::begin --}}
    <script src="{{ asset('assets-admin/plugins/global/global.min.js') }}"></script>
    <script src="{{ asset('assets-admin/plugins/chart.js/Chart.bundle.min.js') }}"></script>
    <script src="{{ asset('assets-admin/plugins/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
    {{-- Apex Chart --}}
    <script src="{{ asset('assets-admin/plugins/apexchart/apexchart.js') }}"></script>
    {{-- Chart piety plugin files --}}
    <script src="{{ asset('assets-admin/plugins/peity/jquery.peity.min.js') }}"></script>
    <script src="{{ asset('assets-admin/plugins/jquery-nice-select/js/jquery.nice-select.min.js') }}"></script>
    {{-- swiper-slider --}}
    <script src="{{ asset('assets-admin/plugins/swiper/js/swiper-bundle.min.js') }}"></script>
    {{-- Datatable --}}
    <script src="{{ asset('assets-admin/plugins/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets-admin/dist/js/plugins-init/datatables.init.js') }}"></script>
    {{-- Dashboard 1 --}}
    <script src="{{ asset('assets-admin/dist/js/dashboard/dashboard-1.js') }}"></script>
    <script src="{{ asset('assets-admin/plugins/wow-master/dist/wow.min.js') }}"></script>
    <script src="{{ asset('assets-admin/plugins/bootstrap-datetimepicker/js/moment.js') }}"></script>
    <script src="{{ asset('assets-admin/plugins/datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('assets-admin/plugins/bootstrap-select-country/js/bootstrap-select-country.min.js') }}"></script>
    <script src="{{ asset('assets-admin/dist/js/dlabnav-init.js') }}"></script>
    <script src="{{ asset('assets-admin/dist/js/custom.min.js') }}"></script>
    {{-- Internal Sweet-Alert js --}}
    <script src="{{ asset('assets-admin/plugins/sweet-alert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('assets-admin/plugins/sweet-alert/jquery.sweet-alert.js') }}"></script>
    {{-- input mask jquery --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

    {{-- stack scripts --}}
    @stack('scripts')
    {{-- stack scripts --}}

    {{-- sweer alert --}}
    @include('sweetalert::alert')
    {{-- sweer alert --}}
    {{-- javascript::end --}}
</body>

</html>
