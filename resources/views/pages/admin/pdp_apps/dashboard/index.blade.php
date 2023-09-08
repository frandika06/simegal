@extends('layouts.admin.pdp')
@push('apps')
    SIMEGAL
@endpush
@push('title')
    Dashboard | SIMEGAL
@endpush
@push('description')
    Dashboard | Sistem Informasi Metrologi Legal Pemerintah Kabupaten Tangerang
@endpush
@push('header-title')
    Dashboard
@endpush
@push('styles')
    {{-- begin::Vendor Stylesheets(used for this page only) --}}
    <link href="{{ asset('assets-pdp/plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets-pdp/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
    {{-- end::Vendor Stylesheets --}}
@endpush

{{-- TOOLBOX::BEGIN --}}
@push('toolbox')
    @if ($profile->file_npwp === null || $profile->file_npwp == '')
        @include('pages.admin.pdp_apps.toolbox.dashboard_1')
    @else
        @include('pages.admin.pdp_apps.toolbox.dashboard_2')
    @endif
@endpush
{{-- TOOLBOX::END --}}

{{-- CONTENT::BEGIN --}}
@section('content')
    @if ($profile->file_npwp !== null && $profile->file_npwp != '')
        {{-- begin::Post --}}
        <div class="content flex-row-fluid" id="kt_content">
            {{-- begin::Row --}}
            <div class="row gy-0 gx-10">
                {{-- begin::Col --}}
                <div class="col-xl-12">
                    {{-- begin::General Widget 1 --}}
                    <div class="mb-10">
                        {{-- begin::Tabs --}}
                        <ul class="nav row mb-10 tabs-dashboard">
                            <li class="nav-item col-12 col-lg mb-5 mb-lg-0">
                                <a class="nav-link btn btn-flex btn-color-gray-400 btn-outline btn-active-info d-flex flex-grow-1 flex-column flex-center py-5 h-1250px h-lg-175px path-tab" data-bs-toggle="tab" href="#kt_general_widget_1_1">
                                    <i class="ki-duotone ki-click fs-2x mb-5 mx-0">
                                        <i class="path1"></i>
                                        <i class="path2"></i>
                                        <i class="path3"></i>
                                        <i class="path4"></i>
                                        <i class="path5"></i>
                                    </i>
                                    <span class="fs-6 fw-bold">Status Baru</span>
                                </a>
                            </li>
                            <li class="nav-item col-12 col-lg mb-5 mb-lg-0">
                                <a class="nav-link btn btn-flex btn-color-gray-400 btn-outline btn-active-info d-flex flex-grow-1 flex-column flex-center py-5 h-1250px h-lg-175px path-tab" data-bs-toggle="tab" href="#kt_general_widget_1_2">
                                    <i class="ki-duotone ki-loading fs-2x mb-5 mx-0">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    <span class="fs-6 fw-bold">Status Diproses</span>
                                </a>
                            </li>
                            <li class="nav-item col-12 col-lg mb-5 mb-lg-0">
                                <a class="nav-link btn btn-flex btn-color-gray-400 btn-outline btn-active-info d-flex flex-grow-1 flex-column flex-center py-5 h-1250px h-lg-175px path-tab" data-bs-toggle="tab" href="#kt_general_widget_1_3">
                                    <i class="ki-duotone ki-archive-tick fs-2x mb-5 mx-0">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    <span class="fs-6 fw-bold">Status Selesai</span>
                                </a>
                            </li>
                            <li class="nav-item col-12 col-lg mb-5 mb-lg-0">
                                <a class="nav-link btn btn-flex btn-color-gray-400 btn-outline btn-active-info d-flex flex-grow-1 flex-column flex-center py-5 h-1250px h-lg-175px path-tab" data-bs-toggle="tab" href="#kt_general_widget_1_4">
                                    <i class="ki-duotone ki-tag-cross fs-2x mb-5 mx-0">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                    </i>
                                    <span class="fs-6 fw-bold">Status Ditolak</span>
                                </a>
                            </li>
                        </ul>
                        {{-- begin::Tab content --}}
                        <div class="tab-content">
                            {{-- path-baru::begin --}}
                            @include('pages.admin.pdp_apps.dashboard.path_baru')
                            {{-- path-baru::end --}}
                            {{-- path-diproses::begin --}}
                            @include('pages.admin.pdp_apps.dashboard.path_diproses')
                            {{-- path-diproses::end --}}
                            {{-- path-selesai::begin --}}
                            @include('pages.admin.pdp_apps.dashboard.path_selesai')
                            {{-- path-selesai::end --}}
                            {{-- path-ditolak::begin --}}
                            @include('pages.admin.pdp_apps.dashboard.path_ditolak')
                            {{-- path-ditolak::end --}}
                        </div>
                        {{-- end::Tab content --}}
                    </div>
                    {{-- end::General Widget 1 --}}
                </div>
                {{-- end::Col --}}
            </div>
            {{-- end::Row --}}
        </div>
        {{-- end::Post --}}
    @endif
@endsection
{{-- CONTENT::END --}}

@push('scripts')
    {{-- begin::Vendors Javascript(used for this page only) --}}
    {{-- end::Vendors Javascript --}}
    {{-- begin::Custom Javascript(used for this page only) --}}
    {{-- end::Custom Javascript --}}
    {{-- CUTOM JS --}}
    <script>
        $(document).ready(function() {
            getTabsDashboard();
            $(".path-tab").click(function() {
                var href = $(this).attr('href');
                localStorage.setItem('tabsDashboardlAktif', href);
            })
        });

        function getTabsDashboard() {
            var tabsDashboardlAktif = localStorage.getItem('tabsDashboardlAktif');
            if (tabsDashboardlAktif === null) {
                localStorage.setItem('tabsDashboardlAktif', '#kt_general_widget_1_1');
                $(".tabs-dashboard>li").each(function(index) {
                    if ($(this).find('a[href^="#kt_general_widget_1_1"]')) {
                        $('a[href^="#kt_general_widget_1_1"]').addClass(" active");
                        $('#kt_general_widget_1_1').addClass(" show active");
                    }
                });
            } else {
                $(".tabs-dashboard>li").each(function(index) {
                    if ($(this).find('a[href^="' + tabsDashboardlAktif + '"]')) {
                        $('a[href^="' + tabsDashboardlAktif + '"]').addClass(" active");
                        $(tabsDashboardlAktif).addClass(" show active");
                    }
                });
            }
        }
    </script>
@endpush
