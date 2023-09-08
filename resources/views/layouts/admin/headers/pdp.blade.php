{{-- begin::Header --}}
<div id="kt_header" class="header" data-kt-sticky="true" data-kt-sticky-name="header" data-kt-sticky-offset="{default: '200px', lg: '300px'}">
    {{-- begin::Container --}}
    <div class="container-xxl d-flex flex-grow-1 flex-stack">
        {{-- begin::Header Logo --}}
        <div class="d-flex align-items-center me-5">
            {{-- begin::Heaeder menu toggle --}}
            <div class="d-lg-none btn btn-icon btn-active-color-info w-30px h-30px ms-n2 me-3" id="kt_header_menu_toggle">
                <i class="ki-duotone ki-abstract-14 fs-2">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>
            </div>
            {{-- end::Heaeder menu toggle --}}
            <a href="{{ route('pdp.apps.home.index') }}">
                <img alt="Logo" src="{{ asset('assets-portal/dist/img/logo-color.png') }}" class="theme-light-show h-40px h-lg-50px" />
                <img alt="Logo" src="{{ asset('assets-portal/dist/img/logo-white.png') }}" class="theme-dark-show h-40px h-lg-50px" />
            </a>
        </div>
        {{-- end::Header Logo --}}
        {{-- begin::Topbar --}}
        <div class="d-flex align-items-center flex-shrink-0">
            {{-- begin::Theme mode --}}
            <div class="d-flex align-items-center ms-3 ms-lg-4">
                {{-- begin::Menu toggle --}}
                <a href="#" class="btn btn-icon btn-color-gray-700 btn-active-color-info btn-outline btn-active-bg-light w-30px h-30px w-lg-40px h-lg-40px" data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                    <i class="ki-duotone ki-night-day theme-light-show fs-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                        <span class="path3"></span>
                        <span class="path4"></span>
                        <span class="path5"></span>
                        <span class="path6"></span>
                        <span class="path7"></span>
                        <span class="path8"></span>
                        <span class="path9"></span>
                        <span class="path10"></span>
                    </i>
                    <i class="ki-duotone ki-moon theme-dark-show fs-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </a>
                {{-- begin::Menu toggle --}}
                {{-- begin::Menu --}}
                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-gray-500 menu-active-bg menu-state-color fw-semibold py-4 fs-base w-150px" data-kt-menu="true" data-kt-element="theme-mode-menu">
                    {{-- begin::Menu item --}}
                    <div class="menu-item px-3 my-0">
                        <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="light">
                            <span class="menu-icon" data-kt-element="icon">
                                <i class="ki-duotone ki-night-day fs-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                    <span class="path4"></span>
                                    <span class="path5"></span>
                                    <span class="path6"></span>
                                    <span class="path7"></span>
                                    <span class="path8"></span>
                                    <span class="path9"></span>
                                    <span class="path10"></span>
                                </i>
                            </span>
                            <span class="menu-title">Light</span>
                        </a>
                    </div>
                    {{-- end::Menu item --}}
                    {{-- begin::Menu item --}}
                    <div class="menu-item px-3 my-0">
                        <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="dark">
                            <span class="menu-icon" data-kt-element="icon">
                                <i class="ki-duotone ki-moon fs-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </span>
                            <span class="menu-title">Dark</span>
                        </a>
                    </div>
                    {{-- end::Menu item --}}
                    {{-- begin::Menu item --}}
                    <div class="menu-item px-3 my-0">
                        <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="system">
                            <span class="menu-icon" data-kt-element="icon">
                                <i class="ki-duotone ki-screen fs-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                    <span class="path4"></span>
                                </i>
                            </span>
                            <span class="menu-title">System</span>
                        </a>
                    </div>
                    {{-- end::Menu item --}}
                </div>
                {{-- end::Menu --}}
            </div>
            {{-- end::Theme mode --}}
            {{-- begin::User --}}
            <div class="d-flex align-items-center ms-3 ms-lg-4" id="kt_header_user_menu_toggle">
                {{-- begin::Menu- wrapper --}}
                {{-- begin::User icon(remove this button to use user avatar as menu toggle) --}}
                <div class="btn btn-icon btn-color-gray-700 btn-active-color-info btn-outline btn-active-bg-light w-30px h-30px w-lg-40px h-lg-40px" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                    <i class="ki-duotone ki-user fs-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </div>
                {{-- end::User icon --}}
                {{-- begin::User account menu --}}
                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px" data-kt-menu="true">
                    {{-- begin::Menu item --}}
                    <div class="menu-item px-3">
                        <div class="menu-content d-flex align-items-center px-3">
                            {{-- begin::Avatar --}}
                            <div class="symbol symbol-50px me-5">
                                <img alt="Logo" src="{{ \CID::pp() }}" />
                            </div>
                            {{-- end::Avatar --}}
                            {{-- begin::Username --}}
                            <div class="d-flex flex-column">
                                <div class="fw-bold d-flex align-items-center fs-5">{{ \CID::DataPP()['nama'] }}</div>
                                <p class="fw-semibold text-muted text-hover-info fs-7">Kode: {{ \CID::DataPP()['kode'] }}</p>
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
                        <a href="{{ route('pdp.apps.auth.profile.index') }}" class="menu-link px-5">Profile</a>
                    </div>
                    {{-- end::Menu item --}}
                    {{-- begin::Menu item --}}
                    <div class="menu-item px-5">
                        <a href="{{ route('prt.lgn.logout') }}" class="menu-link px-5">Logout</a>
                    </div>
                    {{-- end::Menu item --}}
                </div>
                {{-- end::User account menu --}}
                {{-- end::Menu wrapper --}}
            </div>
            {{-- end::User  --}}
            {{-- begin::Sidebar Toggler --}}
            {{-- end::Sidebar Toggler --}}
        </div>
        {{-- end::Topbar --}}
    </div>
    {{-- end::Container --}}
    {{-- begin::Separator --}}
    <div class="separator"></div>
    {{-- end::Separator --}}
    {{-- begin::Container --}}
    <div class="header-menu-container container-xxl d-flex flex-stack h-lg-75px w-100" id="kt_header_nav">
        {{-- begin::Menu wrapper --}}
        <div class="header-menu flex-column flex-lg-row" data-kt-drawer="true" data-kt-drawer-name="header-menu" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="start"
            data-kt-drawer-toggle="#kt_header_menu_toggle" data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_body', lg: '#kt_header_nav'}">
            {{-- begin::Menu --}}
            <div class="menu menu-rounded menu-column menu-lg-row menu-root-here-bg-desktop menu-active-bg menu-state-info menu-title-gray-800 menu-arrow-gray-400 align-items-stretch flex-grow-1 my-5 my-lg-0 px-2 px-lg-0 fw-semibold fs-6" id="#kt_header_menu" data-kt-menu="true">
                {{-- begin:Menu item --}}
                <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="bottom-start" class="menu-item here show menu-here-bg menu-lg-down-accordion me-0 me-lg-2">
                    {{-- begin:Menu link --}}
                    <span class="menu-link py-3">
                        <span class="menu-title">MENU</span>
                        <span class="menu-arrow d-lg-none"></span>
                    </span>
                    {{-- end:Menu link --}}
                    {{-- begin:Menu sub --}}
                    <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown p-0 w-100 w-lg-850px">
                        {{-- begin:Dashboards menu --}}
                        <div class="menu-state-bg menu-extended overflow-hidden overflow-lg-visible" data-kt-menu-dismiss="true">
                            {{-- begin:Row --}}
                            <div class="row">
                                {{-- begin:Col --}}
                                <div class="col-lg-8 mb-3 mb-lg-0 py-3 px-3 py-lg-6 px-lg-6">
                                    {{-- begin:Row --}}
                                    <div class="row">
                                        {{-- begin:Col --}}
                                        <div class="col-12 col-lg-12 mb-3">
                                            {{-- begin:Menu item --}}
                                            <div class="menu-item p-0 m-0">
                                                {{-- begin:Menu link --}}
                                                <a href="{{ route('pdp.apps.home.index') }}" class="menu-link">
                                                    <span class="menu-custom-icon d-flex flex-center flex-shrink-0 rounded w-40px h-40px me-3">
                                                        <i class="ki-duotone ki-element-11 text-info fs-1">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                            <span class="path3"></span>
                                                            <span class="path4"></span>
                                                        </i>
                                                    </span>
                                                    <span class="d-flex flex-column">
                                                        <span class="fs-6 fw-bold text-gray-800">Dashboard</span>
                                                        <span class="fs-7 fw-semibold text-muted">Halaman Dashboard/Beranda</span>
                                                    </span>
                                                </a>
                                                {{-- end:Menu link --}}
                                            </div>
                                            {{-- end:Menu item --}}
                                        </div>
                                        {{-- end:Col --}}
                                        {{-- begin:Col --}}
                                        <div class="col-12 col-lg-12 mb-3">
                                            {{-- begin:Menu item --}}
                                            <div class="menu-item p-0 m-0">
                                                {{-- begin:Menu link --}}
                                                <a href="{{ route('pdp.apps.reqpeneraan.index') }}" class="menu-link">
                                                    <span class="menu-custom-icon d-flex flex-center flex-shrink-0 rounded w-40px h-40px me-3">
                                                        <i class="ki-duotone ki-send text-info fs-1">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                            <span class="path3"></span>
                                                            <span class="path4"></span>
                                                        </i>
                                                    </span>
                                                    <span class="d-flex flex-column">
                                                        <span class="fs-6 fw-bold text-gray-800">Permohonan Pengujian</span>
                                                        <span class="fs-7 fw-semibold text-muted">Halaman Permohonan Pengujian</span>
                                                    </span>
                                                </a>
                                                {{-- end:Menu link --}}
                                            </div>
                                            {{-- end:Menu item --}}
                                        </div>
                                        {{-- end:Col --}}
                                        {{-- begin:Col --}}
                                        <div class="col-12 col-lg-12 mb-3">
                                            {{-- begin:Menu item --}}
                                            <div class="menu-item p-0 m-0">
                                                {{-- begin:Menu link --}}
                                                <a href="#" class="menu-link">
                                                    <span class="menu-custom-icon d-flex flex-center flex-shrink-0 rounded w-40px h-40px me-3">
                                                        <i class="ki-duotone ki-tag text-info fs-1">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                            <span class="path3"></span>
                                                            <span class="path4"></span>
                                                        </i>
                                                    </span>
                                                    <span class="d-flex flex-column">
                                                        <span class="fs-6 fw-bold text-gray-800">Tagihan Retribusi</span>
                                                        <span class="fs-7 fw-semibold text-muted">Halaman Tagihan Retribusi</span>
                                                    </span>
                                                </a>
                                                {{-- end:Menu link --}}
                                            </div>
                                            {{-- end:Menu item --}}
                                        </div>
                                        {{-- end:Col --}}
                                        {{-- begin:Col --}}
                                        <div class="col-12 col-lg-12 mb-3">
                                            {{-- begin:Menu item --}}
                                            <div class="menu-item p-0 m-0">
                                                {{-- begin:Menu link --}}
                                                <a href="#" class="menu-link">
                                                    <span class="menu-custom-icon d-flex flex-center flex-shrink-0 rounded w-40px h-40px me-3">
                                                        <i class="ki-duotone ki-bookmark text-info fs-1">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                            <span class="path3"></span>
                                                            <span class="path4"></span>
                                                        </i>
                                                    </span>
                                                    <span class="d-flex flex-column">
                                                        <span class="fs-6 fw-bold text-gray-800">Sertifikat</span>
                                                        <span class="fs-7 fw-semibold text-muted">Halaman Data Sertifikat</span>
                                                    </span>
                                                </a>
                                                {{-- end:Menu link --}}
                                            </div>
                                            {{-- end:Menu item --}}
                                        </div>
                                        {{-- end:Col --}}
                                    </div>
                                    {{-- end:Row --}}
                                </div>
                                {{-- end:Col --}}
                                {{-- begin:Col --}}
                                <div class="menu-more bg-light col-lg-4 py-3 px-3 py-lg-6 px-lg-6 rounded-end">
                                    {{-- begin:Heading --}}
                                    <h4 class="fs-6 fs-lg-4 text-gray-800 fw-bold mt-3 mb-3 ms-4">Pengaturan Profile</h4>
                                    {{-- end:Heading --}}
                                    {{-- begin:Menu item --}}
                                    <div class="menu-item p-0 m-0">
                                        {{-- begin:Menu link --}}
                                        <a href="{{ route('pdp.apps.auth.profile.index') }}" class="menu-link py-2">
                                            <span class="menu-title">Profile</span>
                                        </a>
                                        {{-- end:Menu link --}}
                                        {{-- begin:Menu link --}}
                                        <a href="{{ route('prt.lgn.logout') }}" class="menu-link py-2">
                                            <span class="menu-title">Logout</span>
                                        </a>
                                        {{-- end:Menu link --}}
                                    </div>
                                    {{-- end:Menu item --}}
                                </div>
                                {{-- end:Col --}}
                            </div>
                            {{-- end:Row --}}
                        </div>
                        {{-- end:Dashboards menu --}}
                    </div>
                    {{-- end:Menu sub --}}
                </div>
                {{-- end:Menu item --}}
            </div>
            {{-- end::Menu --}}
            {{-- begin::Actions --}}
            <div class="flex-shrink-0 p-4 p-lg-0 me-lg-2">
                <a href="{{ route('prt.home.index') }}" class="btn btn-sm btn-light-info fw-bold w-100 w-lg-auto" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss-="click" title="Portal Website">Portal Website</a>
            </div>
            {{-- end::Actions --}}
        </div>
        {{-- end::Menu wrapper --}}
    </div>
    {{-- end::Container --}}
</div>
{{-- end::Header --}}
