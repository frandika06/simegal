<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-layout="twocolumn" data-sidebar="light" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">

<head>
    {{-- META --}}
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="ROBOTS" content="index, follow" />
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
    <meta name="msapplication-TileImage" content="{{ asset('assets-portal/dist/img/favicon/ms-icon-144x144.png') }}" />
    <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('assets-portal/dist/img/favicon/apple-icon-57x57.png') }}" />
    <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('assets-portal/dist/img/favicon/apple-icon-60x60.png') }}" />
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('assets-portal/dist/img/favicon/apple-icon-72x72.png') }}" />
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets-portal/dist/img/favicon/apple-icon-76x76.png') }}" />
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('assets-portal/dist/img/favicon/apple-icon-114x114.png') }}" />
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('assets-portal/dist/img/favicon/apple-icon-120x120.png') }}" />
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('assets-portal/dist/img/favicon/apple-icon-144x144.png') }}" />
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('assets-portal/dist/img/favicon/apple-icon-152x152.png') }}" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets-portal/dist/img/favicon/apple-icon-180x180.png') }}" />
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('assets-portal/dist/img/favicon/android-icon-192x192.png') }}" />
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets-portal/dist/img/favicon/favicon-32x32.png') }}" />
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('assets-portal/dist/img/favicon/favicon-96x96.png') }}" />
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets-portal/dist/img/favicon/favicon-16x16.png') }}" />
    <link rel="manifest" href="{{ asset('assets-portal/dist/img/favicon/manifest.json') }}" />
    {{-- FAVICON --}}
    {{-- CSS --}}
    {{-- Web Fonts  --}}
    <link id="googleFonts" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800%7CShadows+Into+Light%7CPlayfair+Display:400&display=swap" rel="stylesheet" type="text/css">
    {{-- Vendor CSS --}}
    <link rel="stylesheet" href="{{ asset('assets-portal/plugins/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets-portal/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets-portal/plugins/animate/animate.compat.css') }}">
    <link rel="stylesheet" href="{{ asset('assets-portal/plugins/simple-line-icons/css/simple-line-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets-portal/plugins/owl.carousel/assets/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets-portal/plugins/owl.carousel/assets/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets-portal/plugins/magnific-popup/magnific-popup.min.css') }}">
    {{-- Theme CSS --}}
    <link rel="stylesheet" href="{{ asset('assets-portal/dist/css/theme.css') }}">
    <link rel="stylesheet" href="{{ asset('assets-portal/dist/css/theme-elements.css?v=') . date('ymdHis') }}">
    <link rel="stylesheet" href="{{ asset('assets-portal/dist/css/theme-blog.css') }}">
    <link rel="stylesheet" href="{{ asset('assets-portal/dist/css/theme-shop.css') }}">
    {{-- Skin CSS --}}
    <link id="skinCSS" rel="stylesheet" href="{{ asset('assets-portal/dist/css/skins/skin-corporate-9.css?v=') . date('ymdHis') }}">
    {{-- Theme Custom CSS --}}
    <link rel="stylesheet" href="{{ asset('assets-portal/dist/css/custom.css') }}">
    {{-- Head Libs --}}
    <script src="{{ asset('assets-portal/plugins/modernizr/modernizr.min.js') }}"></script>
    {{-- custom Css --}}
    <link href="{{ asset('assets-portal/dist/css/cid.css?v=') . date('ymdHis') }}" rel="stylesheet" type="text/css" />
    {{-- stack css --}}
    @stack('styles')
    {{-- stack css --}}
</head>

<body data-plugin-page-transition>
    {{-- body::begin --}}
    <div class="body">
        {{-- header::begin --}}
        @include('layouts.portal.headers.headers')
        {{-- header::end --}}

        {{-- content::begin --}}
        @yield('content')
        {{-- content::end --}}

        {{-- footer::begin --}}
        <footer id="footer" class="mt-0">
            <div class="container">
                <div class="row py-5">
                    <div class="col text-center">
                        <ul class="footer-social-icons social-icons social-icons-clean social-icons-big social-icons-opacity-light social-icons-icon-light mt-1">
                            <li class="social-icons-facebook"><a href="http://www.facebook.com/" target="_blank" title="Facebook"><i class="fab fa-facebook-f text-2"></i></a></li>
                            <li class="social-icons-twitter"><a href="http://www.twitter.com/" target="_blank" title="Twitter"><i class="fab fa-twitter text-2"></i></a></li>
                            <li class="social-icons-instagram"><a href="http://www.instagram.com/" target="_blank" title="Instagram"><i class="fab fa-instagram text-2"></i></a></li>
                            <li class="social-icons-youtube"><a href="http://www.youtube.com/" target="_blank" title="YouTube"><i class="fab fa-youtube text-2"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="footer-copyright footer-copyright-style-2">
                <div class="container py-2">
                    <div class="row py-4">
                        <div class="col-lg-6 text-center text-lg-start mb-2 mb-lg-0">
                            <p>
                                <span class="pe-0 pe-md-3 d-block d-md-inline-block"><i class="far fa-dot-circle text-color-white top-1 p-relative"></i><span class="text-color-light opacity-7 ps-1">Jl. Lorem Ipsum Dolor</span></span>
                                <span class="pe-0 pe-md-3 d-block d-md-inline-block"><i class="fab fa-whatsapp text-color-white top-1 p-relative"></i><a href="tel:1234567890" class="text-color-light opacity-7 ps-1">(021) 123-4567</a></span>
                                <span class="pe-0 pe-md-3 d-block d-md-inline-block"><i class="far fa-envelope text-color-white top-1 p-relative"></i><a href="mailto:mail@example.com" class="text-color-light opacity-7 ps-1">info@simegal.com</a></span>
                            </p>
                        </div>
                        <div class="col-lg-6 d-flex align-items-center justify-content-center justify-content-lg-end mb-4 mb-lg-0 pt-4 pt-lg-0">
                            <p>&copy; 2023 . Dinas Perindustrian dan Perdagangan Kabupaten Tangerang</p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        {{-- footer::end --}}
        {{-- modals::begin --}}
        @stack('modals')
        {{-- modals::end --}}
    </div>
    {{-- body::end --}}
    {{-- javascript::begin --}}
    {{-- Vendor --}}
    <script src="{{ asset('assets-portal/plugins//plugins/js/plugins.min.js') }}"></script>
    {{-- Theme Base, Components and Settings --}}
    <script src="{{ asset('assets-portal/dist/js/theme.js') }}"></script>
    {{-- Theme Custom --}}
    <script src="{{ asset('assets-portal/dist/js/custom.js') }}"></script>
    {{-- Theme Initialization Files --}}
    <script src="{{ asset('assets-portal/dist/js/theme.init.js') }}"></script>
    {{-- stack scripts --}}
    {{-- CUSTOM JS --}}
    <script src="{{ asset('assets-portal/dist/js/cid.js?=') . date('ymdHis') }}"></script>
    @stack('scripts')
    {{-- stack scripts --}}
    {{-- sweer alert --}}
    @include('sweetalert::alert')
    {{-- javascript::end --}}
</body>

</html>
