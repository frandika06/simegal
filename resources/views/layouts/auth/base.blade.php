<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-layout="twocolumn" data-sidebar="light" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">

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
    {{-- CSS --}}
    {{-- Layout config Js --}}
    <script src="{{ asset('assets/js/layout.js') }}"></script>
    {{-- Bootstrap Css --}}
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    {{-- Icons Css --}}
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    {{-- App Css --}}
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    {{-- custom Css --}}
    <link href="{{ asset('assets/css/custom.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/cid.css') }}" rel="stylesheet" type="text/css" />
</head>

<body>
    {{-- wrapper::start --}}
    @yield('wrapper')
    {{-- wrapper::end --}}
    {{-- JAVASCRIPT --}}
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('assets/libs/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
    <script src="{{ asset('assets/js/plugins.js') }}"></script>
    {{-- particles js --}}
    <script src="{{ asset('assets/libs/particles.js/particles.js') }}"></script>
    {{-- particles app js --}}
    <script src="{{ asset('assets/js/pages/particles.app.js') }}"></script>
    {{-- password-addon init --}}
    <script src="{{ asset('assets/js/pages/password-addon.init.js') }}"></script>
    {{-- sweer alert --}}
    @include('sweetalert::alert')
</body>

</html>
