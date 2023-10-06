@extends('layouts.admin.settings')
@push('apps')
    SIMEGAL
@endpush
@push('title')
    Permohonan Pengujian {{ $tags }} | Permohonan Pengujian | Penjadwalan & Penugasan | SIMEGAL
@endpush
@push('description')
    Permohonan Pengujian {{ $tags }} | Permohonan Pengujian | Penjadwalan & Penugasan | Sistem Informasi Metrologi Legal Pemerintah Kabupaten Tangerang
@endpush
@push('header-title')
    Permohonan Pengujian {{ $tags }} | Permohonan Pengujian | Penjadwalan & Penugasan
@endpush

{{-- TOOLBOX::BEGIN --}}
@push('toolbox')
    {{-- begin::Toolbar --}}
    <div class="toolbar py-5 py-lg-5" id="kt_toolbar">
        {{-- begin::Container --}}
        <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap">
            {{-- begin::Page title --}}
            <div class="page-title d-flex flex-column me-3">
                {{-- begin::Title --}}
                <h1 class="d-flex text-dark fw-bold my-1 fs-3">Permohonan Pengujian {{ \str_replace('Pengujian ', '', $tags) }}</h1>
                {{-- end::Title --}}
                {{-- begin::Breadcrumb --}}
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 pt-1">
                    {{-- begin::Item --}}
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('scd.apps.home.index') }}" class="text-muted text-hover-primary">Dashboard</a>
                    </li>
                    {{-- end::Item --}}
                    {{-- begin::Item --}}
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-200 w-5px h-2px"></span>
                    </li>
                    {{-- end::Item --}}
                    {{-- begin::Item --}}
                    <li class="breadcrumb-item text-muted">Permohonan Pengujian</li>
                    {{-- end::Item --}}
                    {{-- begin::Item --}}
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-200 w-5px h-2px"></span>
                    </li>
                    {{-- end::Item --}}
                    {{-- begin::Item --}}
                    <li class="breadcrumb-item text-dark">{{ $tags }}</li>
                    {{-- end::Item --}}
                </ul>
                {{-- end::Breadcrumb --}}
            </div>
            {{-- end::Page title --}}
            {{-- begin::Actions --}}
            <div class="d-flex align-items-center py-2 py-md-1">
                {{-- begin::Wrapper --}}
                <div class="me-3">
                    {{-- begin::Menu --}}
                    <select class="form-select" name="q_tahun" id="q_tahun">
                        {{-- @if (\count($tahunPermohonan) > 0)
                            @foreach ($tahunPermohonan as $item)
                                <option value="{{ $item->year }}" @if ($tahun == $item->year) selected @endif>{{ $item->year }}</option>
                            @endforeach
                        @else
                            @for ($year = \date('Y') - 5; $year <= \date('Y'); $year++)
                                <option value="{{ $year }}" @if ($tahun == $year) selected @endif>{{ $year }}</option>
                            @endfor
                        @endif --}}
                        @for ($year = \date('Y') - 5; $year <= \date('Y'); $year++)
                            <option value="{{ $year }}" @if ($tahun == $year) selected @endif>{{ $year }}</option>
                        @endfor
                    </select>
                    {{-- end::Menu --}}
                </div>
                {{-- end::Wrapper --}}
            </div>
            {{-- end::Actions --}}
        </div>
        {{-- end::Container --}}
    </div>
    {{-- end::Toolbar --}}
@endpush
{{-- TOOLBOX::END --}}

{{-- CONTENT::BEGIN --}}
@section('content')
    {{-- begin::Post --}}
    <div class="post d-flex flex-column-fluid" id="kt_post">
        {{-- begin::Container --}}
        <div id="kt_content_container" class="container-xxl">
            {{-- begin::Layout --}}
            <div class="d-flex flex-column flex-lg-row">

                {{-- begin::Content --}}
                <div class="flex-lg-row-fluid">
                    {{-- begin:::Tabs --}}
                    <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-semibold mb-8 tabs-profile">
                        {{-- begin:::Tab item --}}
                        <li class="nav-item">
                            <a class="nav-link text-active-info pb-4 path-tab" data-bs-toggle="tab" href="#profile_tab_status_baru">Status Baru <span class="badge badge-info" id="statistik_baru"></span></a>
                        </li>
                        {{-- end:::Tab item --}}
                        {{-- begin:::Tab item --}}
                        <li class="nav-item">
                            <a class="nav-link text-active-info pb-4 path-tab" data-bs-toggle="tab" href="#profile_tab_status_diproses">Status Diproses <span class="badge badge-info" id="statistik_diproses"></span></a>
                        </li>
                        {{-- end:::Tab item --}}
                        {{-- begin:::Tab item --}}
                        <li class="nav-item">
                            <a class="nav-link text-active-info pb-4 path-tab" data-bs-toggle="tab" href="#profile_tab_status_selesai">Status Selesai <span class="badge badge-info" id="statistik_selesai"></span></a>
                        </li>
                        {{-- end:::Tab item --}}
                        {{-- begin:::Tab item --}}
                        <li class="nav-item">
                            <a class="nav-link text-active-info pb-4 path-tab" data-bs-toggle="tab" href="#profile_tab_status_ditolak">Status Ditolak <span class="badge badge-info" id="statistik_ditolak"></span></a>
                        </li>
                        {{-- end:::Tab item --}}
                    </ul>
                    {{-- end:::Tabs --}}

                    {{-- begin:::Tab content --}}
                    <div class="tab-content" id="myTabContent">
                        {{-- path-baru::begin --}}
                        @include('pages.admin.schedule_apps.permohonan.path_datatable.baru')
                        {{-- path-baru::end --}}
                        {{-- path-diproses::begin --}}
                        @include('pages.admin.schedule_apps.permohonan.path_datatable.diproses')
                        {{-- path-diproses::end --}}
                        {{-- path-selesai::begin --}}
                        @include('pages.admin.schedule_apps.permohonan.path_datatable.selesai')
                        {{-- path-selesai::end --}}
                        {{-- path-ditolak::begin --}}
                        @include('pages.admin.schedule_apps.permohonan.path_datatable.ditolak')
                        {{-- path-ditolak::end --}}
                    </div>
                    {{-- end:::Tab content --}}
                </div>
                {{-- end::Content --}}

            </div>
            {{-- end::Layout --}}
        </div>
        {{-- end::Container --}}
    </div>
    {{-- end::Post --}}
@endsection
{{-- CONTENT::END --}}

{{-- modal::begin --}}
@push('modals')
@endpush
{{-- modal::end --}}

@push('scripts')
    {{-- JS CUSTOM --}}
    <script>
        $(document).ready(function() {
            getTabsProfil();
            $(".path-tab").click(function() {
                var href = $(this).attr('href');
                localStorage.setItem('tabsPermohonanPengujian', href);
            })
        });

        function getTabsProfil() {
            var tabsPermohonanPengujian = localStorage.getItem('tabsPermohonanPengujian');
            if (tabsPermohonanPengujian === null) {
                localStorage.setItem('tabsPermohonanPengujian', '#profile_tab_status_baru');
                $(".tabs-profile>li").each(function(index) {
                    if ($(this).find('a[href^="#profile_tab_status_baru"]')) {
                        $('a[href^="#profile_tab_status_baru"]').addClass(" active");
                        $('#profile_tab_status_baru').addClass(" show active");
                    }
                });
            } else {
                $(".tabs-profile>li").each(function(index) {
                    if ($(this).find('a[href^="' + tabsPermohonanPengujian + '"]')) {
                        $('a[href^="' + tabsPermohonanPengujian + '"]').addClass(" active");
                        $(tabsPermohonanPengujian).addClass(" show active");
                    }
                });
            }
        }
    </script>
@endpush
