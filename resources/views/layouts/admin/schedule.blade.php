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
    {{-- begin::Fonts(mandatory for all pages) --}}
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    {{-- end::Fonts --}}
    {{-- begin::Global Stylesheets Bundle(mandatory for all pages) --}}
    <link href="{{ asset('assets-apps/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets-apps/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets-apps/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
    {{-- end::Global Stylesheets Bundle --}}

    {{-- Internal Sweet-Alert css --}}
    <link href="{{ asset('assets-admin/plugins/sweet-alert/sweetalert.css') }}" rel="stylesheet" />

    {{-- css custom --}}
    <link href="{{ asset('assets-admin/dist/css/cid.css?v=') . date('ymdHis') }}" rel="stylesheet">
    {{-- css-js::end --}}

    <style>
        .header-bg-list-apps {
            background-image: url({!! asset('assets-apps/media/page-bg/page-' . \CID::genPageBg() . '.jpg') !!});
        }
    </style>

    {{-- stack css --}}
    @stack('styles')
    {{-- stack css --}}
</head>

<body id="kt_body" class="header-tablet-and-mobile-fixed aside-enabled">
    {{-- begin::Theme mode setup on page load --}}
    <script>
        var defaultThemeMode = "light";
        var themeMode;
        if (document.documentElement) {
            if (document.documentElement.hasAttribute("data-bs-theme-mode")) {
                themeMode = document.documentElement.getAttribute("data-bs-theme-mode");
            } else {
                if (localStorage.getItem("data-bs-theme") !== null) {
                    themeMode = localStorage.getItem("data-bs-theme");
                } else {
                    themeMode = defaultThemeMode;
                }
            }
            if (themeMode === "system") {
                themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
            }
            document.documentElement.setAttribute("data-bs-theme", themeMode);
        }
    </script>
    {{-- end::Theme mode setup on page load --}}

    {{-- begin::Root --}}
    <div class="d-flex flex-column flex-root">
        {{-- begin::Page --}}
        <div class="page d-flex flex-row flex-column-fluid">
            {{-- begin::Aside --}}
            @include('layouts.admin.menus.menus')
            {{-- end::Aside --}}
            {{-- begin::Wrapper --}}
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                {{-- begin::Header --}}
                @include('layouts.admin.headers.headers')
                {{-- end::Header --}}
                {{-- begin::Content --}}
                <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                    {{-- toolbox::begin --}}
                    @stack('toolbox')
                    {{-- toolbox::end --}}
                    {{-- begin::Post --}}
                    @yield('content')
                    {{-- end::Post --}}
                </div>
                {{-- end::Content --}}
                {{-- begin::Footer --}}
                <div class="footer py-4 d-flex flex-lg-column" id="kt_footer">
                    {{-- begin::Container --}}
                    <div class="container-fluid d-flex flex-column flex-md-row align-items-center justify-content-between">
                        {{-- begin::Copyright --}}
                        <div class="text-dark order-2 order-md-1">
                            <span class="text-muted fw-semibold me-1">&copy; 2023 . Dinas Perindustrian dan Perdagangan Kabupaten Tangerang</span>
                        </div>
                        {{-- end::Copyright --}}
                    </div>
                    {{-- end::Container --}}
                </div>
                {{-- end::Footer --}}
            </div>
            {{-- end::Wrapper --}}
        </div>
        {{-- end::Page --}}
    </div>
    {{-- end::Root --}}

    {{-- begin::Scrolltop --}}
    <div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
        <i class="ki-duotone ki-arrow-up">
            <span class="path1"></span>
            <span class="path2"></span>
        </i>
    </div>
    {{-- end::Scrolltop --}}

    {{-- modals::begin --}}
    @stack('modals')
    {{-- modals::end --}}

    {{-- javascript::begin --}}
    <script>
        var hostUrl = "{{ asset('assets-apps') }}/";
    </script>
    {{-- begin::Global Javascript Bundle(mandatory for all pages) --}}
    <script src="{{ asset('assets-apps/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('assets-apps/js/scripts.bundle.js') }}"></script>
    <script src="{{ asset('assets-apps/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    {{-- end::Global Javascript Bundle --}}
    {{-- input mask jquery --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

    {{-- active-menu::begin --}}
    <script>
        $(document).ready(function() {
            var pageUrl = window.location.href.split(/[?#]/)[0];
            $(".menu-item a.menu-link").each(function() {
                if (this.href == pageUrl) {
                    $(this).addClass("active");
                }
            });
            $(".menu-accordion").each(function() {
                var menuLink = $(this).find('a[href="' + pageUrl + '"]');
                if (menuLink != "undefined") {
                    menuLink.addClass("active");
                    menuLink.parent().parent().parent().addClass("hover show");
                }
            });
        });
    </script>
    {{-- active-menu::end --}}

    {{-- scripts::begin --}}
    @stack('scripts')
    {{-- scripts::end --}}
    {{-- sweetalert::begin --}}
    @include('sweetalert::alert')
    {{-- sweetalert::end --}}
    {{-- javascript::end --}}
</body>

</html>
