<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-layout="vertical" data-sidebar="light" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="enable">

<head>
    {{-- META --}}
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="ROBOTS" content="noindex, nofollow" />
    <meta name="author" content="BPKAD Kabupaten Tangerang" />
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
    <meta name="msapplication-TileImage" content="{{ asset('assets/images/custom/favicon/ms-icon-144x144.png') }}" />
    <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('assets/images/custom/favicon/apple-icon-57x57.png') }}" />
    <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('assets/images/custom/favicon/apple-icon-60x60.png') }}" />
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('assets/images/custom/favicon/apple-icon-72x72.png') }}" />
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/images/custom/favicon/apple-icon-76x76.png') }}" />
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('assets/images/custom/favicon/apple-icon-114x114.png') }}" />
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('assets/images/custom/favicon/apple-icon-120x120.png') }}" />
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('assets/images/custom/favicon/apple-icon-144x144.png') }}" />
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('assets/images/custom/favicon/apple-icon-152x152.png') }}" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/images/custom/favicon/apple-icon-180x180.png') }}" />
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('assets/images/custom/favicon/android-icon-192x192.png') }}" />
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/images/custom/favicon/favicon-32x32.png') }}" />
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('assets/images/custom/favicon/favicon-96x96.png') }}" />
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/custom/favicon/favicon-16x16.png') }}" />
    <link rel="manifest" href="{{ asset('assets/images/custom/favicon/manifest.json') }}" />
    {{-- FAVICON --}}

    {{-- stack css --}}
    @stack('styles')
    {{-- stack css --}}

    {{-- Layout config Js --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('assets/js/layout.js') }}"></script>
    {{-- Bootstrap Css --}}
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    {{-- Icons Css --}}
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    {{-- App Css --}}
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/custom.min.css') }}" rel="stylesheet" type="text/css" />
    {{-- font-awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    {{-- Internal Sweet-Alert css --}}
    <link href="{{ asset('assets/libs/sweet-alert/sweetalert.css') }}" rel="stylesheet" />
    {{-- custom Css --}}
    <link href="{{ asset('assets/css/cid.css?v=') . date('YmdHis') }}" rel="stylesheet" type="text/css" />
    {{-- menus --}}
    <script src="{{ asset('assets/js/menus.js') }}"></script>
</head>

<body>
    {{-- wrapper::begin --}}
    <div id="layout-wrapper">
        {{-- header::begin --}}
        @include('layouts.admin.headers.headers')
        {{-- header::end --}}

        {{-- app-menu::begin --}}
        @include('layouts.admin.menus.menus')
        {{-- app-menu::end --}}

        {{-- vertical-overlay::begin --}}
        <div class="vertical-overlay"></div>
        {{-- vertical-overlay::end --}}

        {{-- content::begin --}}
        <div class="main-content">
            @yield('content')
        </div>
        {{-- content::end --}}

        {{-- footer::begin --}}
        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">Hak Cipta &copy; {{ date('Y') }} . Sistem JasPel . BPKAD Kabupaten Tangerang</div>
                    <div class="col-sm-6">
                        <div class="text-sm-end d-none d-sm-block">&nbsp;</div>
                    </div>
                </div>
            </div>
        </footer>
        {{-- footer::end --}}
    </div>
    {{-- wrapper::end --}}

    {{-- back-to-top::begin --}}
    <button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
        <i class="ri-arrow-up-line"></i>
    </button>
    {{-- back-to-top::end --}}

    {{-- preloader::begin --}}
    <div id="preloader">
        <div id="status">
            <div class="spinner-border text-primary avatar-sm" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>
    {{-- preloader::end --}}

    {{-- modals::begin --}}
    @stack('modals')
    {{-- modals::end --}}

    {{-- javascript::begin --}}
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('assets/libs/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
    <script src="{{ asset('assets/js/plugins.js?v=') . date('YmdHis') }}"></script>

    {{-- Internal Sweet-Alert js --}}
    <script src="{{ asset('assets/libs/sweet-alert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('assets/libs/sweet-alert/jquery.sweet-alert.js') }}"></script>

    {{-- stack scripts --}}
    @stack('scripts')
    {{-- stack scripts --}}

    {{-- App js --}}
    <script src="{{ asset('assets/js/app.js?v=') . date('YmdHis') }}"></script>
    {{-- font-awesome js --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/fontawesome.min.js"></script>
    {{-- CID js --}}
    <script src="{{ asset('assets/js/cid.js?v=') . date('YmdHis') }}"></script>
    {{-- sweer alert --}}
    @include('sweetalert::alert')
    {{-- javascript::end --}}
</body>

</html>
