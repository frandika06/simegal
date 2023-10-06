{{-- begin::Aside --}}
<div id="kt_aside" class="aside py-9" data-kt-drawer="true" data-kt-drawer-name="aside" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_aside_toggle">
    {{-- begin::Aside menu --}}
    <div class="aside-menu flex-column-fluid ps-5 pe-3 mb-7" id="kt_aside_menu">
        {{-- begin::Aside Menu --}}
        <div class="w-100 hover-scroll-y d-flex pe-2" id="kt_aside_menu_wrapper" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_aside_footer, #kt_header"
            data-kt-scroll-wrappers="#kt_aside, #kt_aside_menu, #kt_aside_menu_wrapper" data-kt-scroll-offset="102">
            {{-- begin::Menu --}}
            <div class="menu menu-column menu-rounded menu-sub-indention menu-active-bg fw-semibold my-auto" id="#kt_aside_menu" data-kt-menu="true">

                {{-- begin:Menu item --}}
                <div class="menu-item">
                    {{-- begin:Menu link --}}
                    <a class="menu-link" href="{{ route('auth.home') }}">
                        <span class="menu-icon">
                            <i class="fa-solid fa-grip fs-2"></i>
                        </span>
                        <span class="menu-title">Launcher Aplikasi</span>
                    </a>
                    {{-- end:Menu link --}}
                </div>
                {{-- end:Menu item --}}

                {{-- begin:Menu item --}}
                <div class="menu-item">
                    {{-- begin:Menu link --}}
                    <a class="menu-link" href="{{ route('scd.apps.home.index') }}">
                        <span class="menu-icon">
                            <i class="fa fa-home fs-2"></i>
                        </span>
                        <span class="menu-title">Dashboard</span>
                    </a>
                    {{-- end:Menu link --}}
                </div>
                {{-- end:Menu item --}}

                {{-- begin::Permohonan --}}
                {{-- begin:Menu item --}}
                <div class="menu-item pt-5">
                    {{-- begin:Menu content --}}
                    <div class="menu-content">
                        <span class="menu-heading fw-bold text-uppercase fs-7">Permohonan Pengujian</span>
                    </div>
                    {{-- end:Menu content --}}
                </div>
                {{-- end:Menu item --}}

                {{-- begin:Menu item --}}
                <div class="menu-item">
                    {{-- begin:Menu link --}}
                    <a class="menu-link" href="{{ route('scd.apps.pp.index', [\CID::encode('Tera')]) }}">
                        <span class="menu-icon">
                            <i class="fa-solid fa-scale-balanced fs-2"></i>
                        </span>
                        <span class="menu-title">Tera</span>
                    </a>
                    {{-- end:Menu link --}}
                </div>
                {{-- end:Menu item --}}

                {{-- begin:Menu item --}}
                <div class="menu-item">
                    {{-- begin:Menu link --}}
                    <a class="menu-link" href="{{ route('scd.apps.pp.index', [\CID::encode('Tera Ulang')]) }}">
                        <span class="menu-icon">
                            <i class="fa-solid fa-scale-balanced fs-2"></i>
                        </span>
                        <span class="menu-title">Tera Ulang</span>
                    </a>
                    {{-- end:Menu link --}}
                </div>
                {{-- end:Menu item --}}

                {{-- begin:Menu item --}}
                <div class="menu-item">
                    {{-- begin:Menu link --}}
                    <a class="menu-link" href="{{ route('scd.apps.pp.index', [\CID::encode('Pengujian BDKT')]) }}">
                        <span class="menu-icon">
                            <i class="fa-solid fa-scale-balanced fs-2"></i>
                        </span>
                        <span class="menu-title">Pengujian BDKT</span>
                    </a>
                    {{-- end:Menu link --}}
                </div>
                {{-- end:Menu item --}}
                {{-- end::Permohonan --}}

                {{-- begin::Penjadwalan --}}
                {{-- begin:Menu item --}}
                <div class="menu-item pt-5">
                    {{-- begin:Menu content --}}
                    <div class="menu-content">
                        <span class="menu-heading fw-bold text-uppercase fs-7">Penjadwalan & Penugasan</span>
                    </div>
                    {{-- end:Menu content --}}
                </div>
                {{-- end:Menu item --}}

                {{-- begin:Menu item --}}
                <div class="menu-item">
                    {{-- begin:Menu link --}}
                    <a class="menu-link" href="{{ route('scd.apps.tl.index') }}">
                        <span class="menu-icon">
                            <i class="fa-solid fa-calendar-days fs-2"></i>
                        </span>
                        <span class="menu-title">Input Data</span>
                    </a>
                    {{-- end:Menu link --}}
                </div>
                {{-- end:Menu item --}}
                {{-- end::Penjadwalan --}}

                {{-- begin::Tindak Lanjut Kasi --}}
                {{-- begin:Menu item --}}
                <div class="menu-item pt-5">
                    {{-- begin:Menu content --}}
                    <div class="menu-content">
                        <span class="menu-heading fw-bold text-uppercase fs-7">Tindak Lanjut Kasi</span>
                    </div>
                    {{-- end:Menu content --}}
                </div>
                {{-- end:Menu item --}}

                {{-- begin:Menu item --}}
                <div class="menu-item">
                    {{-- begin:Menu link --}}
                    <a class="menu-link" href="#">
                        <span class="menu-icon">
                            <i class="fa-solid fa-chalkboard-user fs-2"></i></i>
                        </span>
                        <span class="menu-title">MASSA</span>
                    </a>
                    {{-- end:Menu link --}}
                </div>
                {{-- end:Menu item --}}

                {{-- begin:Menu item --}}
                <div class="menu-item">
                    {{-- begin:Menu link --}}
                    <a class="menu-link" href="#">
                        <span class="menu-icon">
                            <i class="fa-solid fa-chalkboard-user fs-2"></i></i>
                        </span>
                        <span class="menu-title">UAPV</span>
                    </a>
                    {{-- end:Menu link --}}
                </div>
                {{-- end:Menu item --}}

                {{-- begin:Menu item --}}
                <div class="menu-item">
                    {{-- begin:Menu link --}}
                    <a class="menu-link" href="#">
                        <span class="menu-icon">
                            <i class="fa-solid fa-chalkboard-user fs-2"></i></i>
                        </span>
                        <span class="menu-title">BDKT</span>
                    </a>
                    {{-- end:Menu link --}}
                </div>
                {{-- end:Menu item --}}
                {{-- end::Tindak Lanjut Kasi --}}

                {{-- begin::Pembayaran Retribusi --}}
                {{-- begin:Menu item --}}
                <div class="menu-item pt-5">
                    {{-- begin:Menu content --}}
                    <div class="menu-content">
                        <span class="menu-heading fw-bold text-uppercase fs-7">Pembayaran Retribusi</span>
                    </div>
                    {{-- end:Menu content --}}
                </div>
                {{-- end:Menu item --}}

                {{-- begin:Menu item --}}
                <div class="menu-item">
                    {{-- begin:Menu link --}}
                    <a class="menu-link" href="#">
                        <span class="menu-icon">
                            <i class="fa-regular fa-square fs-2"></i>
                        </span>
                        <span class="menu-title text-danger">Belum Terverifikasi</span>
                    </a>
                    {{-- end:Menu link --}}
                </div>
                {{-- end:Menu item --}}

                {{-- begin:Menu item --}}
                <div class="menu-item">
                    {{-- begin:Menu link --}}
                    <a class="menu-link" href="#">
                        <span class="menu-icon">
                            <i class="fa-regular fa-square-check fs-2"></i>
                        </span>
                        <span class="menu-title text-success">Sudah Terverifikasi</span>
                    </a>
                    {{-- end:Menu link --}}
                </div>
                {{-- end:Menu item --}}
                {{-- end::Pembayaran Retribusi --}}

                {{-- begin::Report --}}
                {{-- begin:Menu item --}}
                <div class="menu-item pt-5">
                    {{-- begin:Menu content --}}
                    <div class="menu-content">
                        <span class="menu-heading fw-bold text-uppercase fs-7">Report</span>
                    </div>
                    {{-- end:Menu content --}}
                </div>
                {{-- end:Menu item --}}

                {{-- begin:Menu item --}}
                <div class="menu-item">
                    {{-- begin:Menu link --}}
                    <a class="menu-link" href="#">
                        <span class="menu-icon">
                            <i class="fa-solid fa-chart-column fs-2"></i>
                        </span>
                        <span class="menu-title">Rekapitulasi</span>
                    </a>
                    {{-- end:Menu link --}}
                </div>
                {{-- end:Menu item --}}

                {{-- begin:Menu item --}}
                <div class="menu-item">
                    {{-- begin:Menu link --}}
                    <a class="menu-link" href="#">
                        <span class="menu-icon">
                            <i class="fa-solid fa-file-export fs-2"></i>
                        </span>
                        <span class="menu-title">Export Data</span>
                    </a>
                    {{-- end:Menu link --}}
                </div>
                {{-- end:Menu item --}}
                {{-- end::Pembayaran Retribusi --}}

            </div>
            {{-- end::Menu --}}
        </div>
        {{-- end::Aside Menu --}}
    </div>
    {{-- end::Aside menu --}}
    {{-- begin::Footer --}}
    <div class="aside-footer flex-column-auto px-9" id="kt_aside_menu">
        {{-- begin::User panel --}}
        <div class="d-flex flex-stack">
            {{-- begin::Wrapper --}}
            <div class="d-flex align-items-center">
                {{-- begin::Avatar --}}
                <div class="symbol symbol-circle symbol-40px">
                    <img src="{{ \CID::pp() }}" alt="{{ \CID::DataPP()['nama'] }}" draggable="false">
                </div>
                {{-- end::Avatar --}}
                {{-- begin::User info --}}
                <div class="ms-2">
                    {{-- begin::Name --}}
                    <a href="{{ route('set.apps.profile.index') }}" class="text-gray-800 text-hover-primary fs-6 fw-bold lh-1">{{ \CID::DataPP()['nama'] }}</a>
                    {{-- end::Name --}}
                    {{-- begin::Major --}}
                    <span class="text-muted fw-semibold d-block fs-7 lh-1">Role: {{ \CID::DataPP()['role'] }}</span>
                    {{-- end::Major --}}
                </div>
                {{-- end::User info --}}
            </div>
            {{-- end::Wrapper --}}
            {{-- begin::User menu --}}
            <div class="ms-1">
                <div class="btn btn-sm btn-icon btn-active-color-primary position-relative me-n2" data-kt-menu-trigger="click" data-kt-menu-overflow="true" data-kt-menu-placement="top-end">
                    <i class="ki-duotone ki-setting-2 fs-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </div>
                {{-- begin::User account menu --}}
                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px" data-kt-menu="true">
                    {{-- begin::Menu item --}}
                    <div class="menu-item px-3">
                        <div class="menu-content d-flex align-items-center px-3">
                            {{-- begin::Avatar --}}
                            <div class="symbol symbol-50px me-5">
                                <img alt="{{ \CID::DataPP()['nama'] }}" src="{{ \CID::pp() }}" draggable="false">
                            </div>
                            {{-- end::Avatar --}}
                            {{-- begin::Username --}}
                            <div class="d-flex flex-column">
                                <div class="fw-bold d-flex align-items-center fs-5">{{ \CID::DataPP()['nama'] }}</div>
                                <p class="fw-semibold text-muted fs-7 m-0">{{ \CID::DataPP()['email'] }}</p>
                            </div>
                            {{-- end::Username --}}
                        </div>
                    </div>
                    {{-- end::Menu item --}}
                    {{-- begin::Menu separator --}}
                    <div class="separator my-2"></div>
                    {{-- end::Menu separator --}}
                    {{-- begin::Menu item --}}
                    <div class="menu-item px-5">
                        <a href="{{ route('set.apps.profile.index') }}" class="menu-link px-5">Profile</a>
                    </div>
                    {{-- end::Menu item --}}
                    {{-- begin::Menu item --}}
                    <div class="menu-item px-5">
                        <a href="{{ route('prt.lgn.logout') }}" class="menu-link px-5">Logout</a>
                    </div>
                    {{-- end::Menu item --}}
                </div>
                {{-- end::User account menu --}}
            </div>
            {{-- end::User menu --}}
        </div>
        {{-- end::User panel --}}
    </div>
    {{-- end::Footer --}}
</div>
{{-- end::Aside --}}
