@extends('layouts.admin.apps')
@push('apps')
    SIMEGAL
@endpush
@push('title')
    List Aplikasi | SIMEGAL
@endpush
@push('description')
    List Aplikasi | Sistem Informasi Metrologi Legal Pemerintah Kabupaten Tangerang
@endpush
@push('header-title')
    List Aplikasi
@endpush
@push('styles')
    <style>
        .page-bg-list-apps {
            background-image: url({!! asset('assets-apps/media/page-bg/page-' . $pageBg . '.jpg') !!});
        }
    </style>
@endpush

{{-- CONTENT::BEGIN --}}
@section('content')
    {{-- begin::Content --}}
    <div class="d-flex flex-row-fluid">
        {{-- begin::Container --}}
        <div class="d-flex flex-column flex-row-fluid align-items-center">
            {{-- begin::Menu --}}
            <div class="d-flex flex-column flex-column-fluid mb-5 mb-lg-10">
                {{-- begin::Brand --}}
                <div class="d-flex flex-center pt-10 pt-lg-0 mb-10 mb-lg-0 h-lg-150px">
                    {{-- begin::Sidebar toggle --}}
                    <div class="btn btn-icon btn-active-color-primary w-30px h-30px d-lg-none me-4 ms-n15" id="kt_sidebar_toggle">
                        <i class="ki-duotone ki-abstract-14 fs-1">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </div>
                    {{-- end::Sidebar toggle --}}
                    {{-- begin::Logo --}}
                    <a href="{{ route('auth.home') }}">
                        <img alt="SIMEGAL" src="{{ asset('assets-portal/dist/img/logo-white.png') }}" class="h-70px" draggable="false">
                    </a>
                    {{-- end::Logo --}}
                </div>
                {{-- end::Brand --}}

                {{-- begin::Row --}}
                <div class="row g-7 w-xxl-850px">
                    {{-- begin::Col --}}
                    <div class="col-xxl-5">
                        {{-- begin::Card --}}
                        <div class="card border-0 shadow-none h-lg-100" style="background-color: #6E16B5">
                            {{-- begin::Card body --}}
                            <div class="card-body d-flex flex-column flex-center pb-0 pt-15">
                                {{-- begin::Wrapper --}}
                                <div class="px-10 mb-5">
                                    {{-- begin::Heading --}}
                                    <h3 class="text-white mb-2 fw-bolder ttext-center text-uppercase mb-6">Portal Web</h3>
                                    {{-- end::Heading --}}
                                    {{-- begin::List --}}
                                    <div class="mb-7">
                                        {{-- begin::Item --}}
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="ki-duotone ki-black-right fs-4 text-white opacity-75 me-3"></i>
                                            <span class="text-white opacity-75">Dashboard</span>
                                        </div>
                                        {{-- begin::Item --}}
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="ki-duotone ki-black-right fs-4 text-white opacity-75 me-3"></i>
                                            <span class="text-white opacity-75">Master Data Portal</span>
                                        </div>
                                        {{-- end::Item --}}
                                        {{-- begin::Item --}}
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="ki-duotone ki-black-right fs-4 text-white opacity-75 me-3"></i>
                                            <span class="text-white opacity-75">Postingan & Page</span>
                                        </div>
                                        {{-- end::Item --}}
                                        {{-- begin::Item --}}
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="ki-duotone ki-black-right fs-4 text-white opacity-75 me-3"></i>
                                            <span class="text-white opacity-75">Media</span>
                                        </div>
                                        {{-- end::Item --}}
                                        {{-- begin::Item --}}
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="ki-duotone ki-black-right fs-4 text-white opacity-75 me-3"></i>
                                            <span class="text-white opacity-75">Kotak Masuk</span>
                                        </div>
                                        {{-- end::Item --}}
                                        {{-- begin::Item --}}
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="ki-duotone ki-black-right fs-4 text-white opacity-75 me-3"></i>
                                            <span class="text-white opacity-75">FAQ</span>
                                        </div>
                                        {{-- end::Item --}}
                                        {{-- begin::Item --}}
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="ki-duotone ki-black-right fs-4 text-white opacity-75 me-3"></i>
                                            <span class="text-white opacity-75">Statistik</span>
                                        </div>
                                        {{-- end::Item --}}
                                    </div>
                                    {{-- end::List --}}
                                    {{-- begin::Link --}}
                                    <a href="{{ route('prt.apps.home.index') }}" class="btn btn-hover-rise text-white bg-white bg-opacity-10 text-uppercase fs-7 fw-bold">Buka Dashboard Portal</a>
                                    {{-- end::Link --}}
                                </div>
                                {{-- end::Wrapper --}}
                                {{-- begin::Illustrations --}}
                                <img class="mw-100 h-150px mx-auto mb-lg-n18" src="{{ asset('assets-apps/media/icon-dashboard/02.svg') }}" draggable="false">
                                {{-- end::Illustrations --}}
                            </div>
                            {{-- end::Card body --}}
                        </div>
                        {{-- end::Card --}}
                    </div>
                    {{-- end::Col --}}

                    {{-- begin::Col --}}
                    <div class="col-xxl-7">

                        {{-- begin::Card --}}
                        <div class="card border-0 shadow-none min-h-200px mb-7" style="background-color: #7bbdff">
                            {{-- begin::Card body --}}
                            <div class="card-body d-flex flex-center flex-wrap">
                                {{-- begin::Illustrations --}}
                                <img class="mw-100 h-200px me-4 mb-5" src="{{ asset('assets-apps/media/icon-dashboard/04.svg') }}" draggable="false">
                                {{-- end::Illustrations --}}
                                {{-- begin::Wrapper --}}
                                <div class="d-flex flex-column align-items-center align-items-md-start flex-grow-1" data-bs-theme="light">
                                    {{-- begin::Heading --}}
                                    <h3 class="text-gray-900 fw-bolder text-uppercase mb-5">Penjadwalan &<br /> Penugasan</h3>
                                    {{-- end::Heading --}}
                                    {{-- begin::List --}}
                                    <div class="mb-5 text-center text-md-start">
                                        Verifikasi pengajuan, <br /> penjadwalan, dan penugasan.
                                    </div>
                                    {{-- end::List --}}
                                    {{-- begin::Link --}}
                                    <a href="{{ route('scd.apps.home.index') }}" class="btn btn-hover-rise text-gray-900 text-uppercase fs-7 fw-bold" style="background-color: #a6d3ff">Buka Aplikasi</a>
                                    {{-- end::Link --}}
                                </div>
                                {{-- end::Wrapper --}}
                            </div>
                            {{-- end::Card body --}}
                        </div>
                        {{-- end::Card --}}

                        {{-- begin::Card --}}
                        <div class="card border-0 shadow-none min-h-200px mb-7" style="background-color: #dfb017">
                            {{-- begin::Card body --}}
                            <div class="card-body d-flex flex-center flex-wrap">
                                {{-- begin::Illustrations --}}
                                <img class="mw-100 h-200px me-4 mb-5" src="{{ asset('assets-apps/media/icon-dashboard/08.svg') }}" draggable="false">
                                {{-- end::Illustrations --}}
                                {{-- begin::Wrapper --}}
                                <div class="d-flex flex-column align-items-center align-items-md-start flex-grow-1" data-bs-theme="light">
                                    {{-- begin::Heading --}}
                                    <h3 class="text-gray-900 fw-bolder text-uppercase mb-5">Pengaturan<br /> Aplikasi</h3>
                                    {{-- end::Heading --}}
                                    {{-- begin::List --}}
                                    <div class="mb-5 text-center text-md-start">

                                    </div>
                                    {{-- end::List --}}
                                    {{-- begin::Link --}}
                                    <a href="{{ route('set.apps.home.index') }}" class="btn btn-hover-rise text-gray-900 text-uppercase fs-7 fw-bold" style="background-color: #f3d572">Buka Aplikasi</a>
                                    {{-- end::Link --}}
                                </div>
                                {{-- end::Wrapper --}}
                            </div>
                            {{-- end::Card body --}}
                        </div>
                        {{-- end::Card --}}

                    </div>
                    {{-- end::Col --}}
                </div>
                {{-- end::Row --}}
            </div>
            {{-- end::Menu --}}
            {{-- begin::Footer --}}
            <div class="d-flex flex-column-auto flex-center">
                {{-- begin::Navs --}}
                <ul class="menu fw-semibold order-1">
                    <li class="menu-item">
                        <a href="{{ route('prt.home.index') }}" class="menu-link text-white opacity-50 opacity-100-hover px-3">Beranda</a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('set.apps.profile.index') }}" class="menu-link text-white opacity-50 opacity-100-hover px-3">Profile</a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('prt.lgn.logout') }}" class="menu-link text-white opacity-50 opacity-100-hover px-3">Logout</a>
                    </li>
                </ul>
                {{-- end::Navs --}}
            </div>
            {{-- end::Footer --}}
        </div>
        {{-- begin::Content --}}
    </div>
    {{-- begin::Content --}}

    {{-- begin::Sidebar --}}
    <div id="kt_sidebar" class="sidebar px-5 py-5 py-lg-8 px-lg-11" data-kt-drawer="true" data-kt-drawer-name="sidebar" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="375px" data-kt-drawer-direction="end"
        data-kt-drawer-toggle="#kt_sidebar_toggle">
        {{-- begin::Header --}}
        <div class="d-flex flex-stack mb-5 mb-lg-8" id="kt_sidebar_header">
            {{-- begin::Title --}}
            <h2 class="text-white">Update Logs</h2>
            {{-- end::Title --}}
        </div>
        {{-- end::Header --}}
        {{-- begin::Body --}}
        <div class="mb-5 mb-lg-8" id="kt_sidebar_body">
            {{-- begin::Scroll --}}
            <div class="hover-scroll-y me-n6 pe-6" id="kt_sidebar_body" data-kt-scroll="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_sidebar_header, #kt_sidebar_footer" data-kt-scroll-wrappers="#kt_page, #kt_sidebar, #kt_sidebar_body" data-kt-scroll-offset="0">
                {{-- begin::Timeline items --}}
                <div class="timeline">
                    @foreach ($dataLogs as $item)
                        {{-- begin::Timeline item --}}
                        <div class="timeline-item">
                            {{-- begin::Timeline line --}}
                            <div class="timeline-line w-40px"></div>
                            {{-- end::Timeline line --}}
                            {{-- begin::Timeline icon --}}
                            <div class="timeline-icon symbol symbol-circle symbol-40px">
                                <div class="symbol-label">
                                    @if ($item->tipe == 'logs')
                                        <i class="fa-solid fa-clock-rotate-left"></i>
                                    @else
                                        <i class="fa-solid fa-right-to-bracket"></i>
                                    @endif
                                </div>
                            </div>
                            {{-- end::Timeline icon --}}
                            {{-- begin::Timeline content --}}
                            <div class="timeline-content mb-10 mt-n2">
                                {{-- begin::Timeline heading --}}
                                <div class="pe-3">
                                    @if ($item->tipe == 'logs')
                                        {{-- begin::Title --}}
                                        <div class="fs-5 text-white fw-semibold mb-2">
                                            {{-- <a class="text-warning" href="#">2 new entries in "Landing Page"</a> --}}
                                            {{ $item->subjek }}
                                            <span class="text-white opacity-50 fs-7"> - {{ \CID::TglJam($item->created_at) }}</span>
                                        </div>
                                        {{-- end::Title --}}
                                        {{-- begin::Description --}}
                                        <div class="d-flex align-items-center mt-1 fs-6">
                                            {{-- begin::Info --}}
                                            {{-- end::Info --}}
                                            @if ($item->role == 'Perusahaan')
                                                <div class="text-success fs-7 fw-bold">{{ $item->RelPerusahaan->nama_perusahaan }}</div>
                                            @else
                                                <div class="text-success fs-7 fw-bold">{{ $item->RelPegawai->nama_lengkap }}</div>
                                            @endif
                                        </div>
                                        {{-- end::Description --}}
                                    @else
                                        {{-- begin::Title --}}
                                        <div class="fs-5 text-white fw-semibold mb-2">
                                            {{ $item->status }}
                                            <span class="text-white opacity-50 fs-7"> - {{ \CID::TglJam($item->created_at) }}</span>
                                        </div>
                                        {{-- end::Title --}}
                                    @endif
                                </div>
                                {{-- end::Timeline heading --}}
                            </div>
                            {{-- end::Timeline content --}}
                        </div>
                        {{-- end::Timeline item --}}
                    @endforeach
                </div>
                {{-- end::Timeline items --}}
            </div>
            {{-- end::Scroll --}}
        </div>
        {{-- end::Body --}}
    </div>
    {{-- end::Sidebar --}}
@endsection
{{-- CONTENT::END --}}

@push('scripts')
@endpush
