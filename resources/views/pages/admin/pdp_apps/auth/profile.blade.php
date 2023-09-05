@extends('layouts.admin.pdp')
@push('apps')
    SIMEGAL
@endpush
@push('title')
    Profile | SIMEGAL
@endpush
@push('description')
    Profile | Sistem Informasi Metrologi Legal Pemerintah Kabupaten Tangerang
@endpush
@push('header-title')
    Profile
@endpush
@push('styles')
    {{-- begin::Vendor Stylesheets(used for this page only) --}}
    {{-- end::Vendor Stylesheets --}}
@endpush

{{-- TOOLBOX::BEGIN --}}
@push('toolbox')
    @include('pages.admin.pdp_apps.toolbox.profile')
@endpush
{{-- TOOLBOX::END --}}

{{-- CONTENT::BEGIN --}}
@section('content')
    {{-- begin::Post --}}
    <div class="content flex-row-fluid" id="kt_content">
        {{-- begin::Layout --}}
        <div class="d-flex flex-column flex-lg-row">

            {{-- begin::Sidebar --}}
            <div class="flex-column flex-lg-row-auto w-lg-250px w-xl-350px mb-10">
                {{-- begin::Card --}}
                <div class="card mb-5 mb-xl-8">
                    {{-- begin::Card body --}}
                    <div class="card-body">
                        {{-- begin::Summary --}}
                        {{-- begin::User Info --}}
                        <div class="d-flex flex-center flex-column py-5">
                            {{-- begin::Avatar --}}
                            <div class="symbol symbol-100px symbol-circle mb-7">
                                <img src="{{ \CID::pp() }}" alt="{{ $profile->nama_perusahaan }}" />
                            </div>
                            {{-- end::Avatar --}}
                            {{-- begin::Name --}}
                            <p class="fs-3 text-gray-800 fw-bold mb-3">{{ $profile->nama_perusahaan }}</p>
                            {{-- end::Name --}}
                            {{-- begin::Position --}}
                            <div class="mb-9">
                                {{-- begin::Badge --}}
                                <div class="badge badge-lg badge-light-info d-inline">{{ $profile->jenis_perusahaan }}</div>
                                {{-- begin::Badge --}}
                            </div>
                            {{-- end::Position --}}
                        </div>
                        {{-- end::User Info --}}
                        {{-- end::Summary --}}
                        {{-- begin::Details toggle --}}
                        <div class="d-flex flex-stack fs-4 py-3">
                            <div class="fw-bold rotate collapsible" data-bs-toggle="collapse" href="#kt_user_view_details" role="button" aria-expanded="false" aria-controls="kt_user_view_details">Informasi
                                <span class="ms-2 rotate-180">
                                    <i class="ki-duotone ki-down fs-3"></i>
                                </span>
                            </div>
                        </div>
                        {{-- end::Details toggle --}}
                        <div class="separator"></div>
                        {{-- begin::Details content --}}
                        <div id="kt_user_view_details" class="collapse show">
                            <div class="pb-5 fs-6">
                                {{-- begin::Details item --}}
                                <div class="fw-bold mt-5">Kode Akun</div>
                                <div class="text-gray-600">{{ $profile->kode_perusahaan }}</div>
                                {{-- begin::Details item --}}
                                {{-- begin::Details item --}}
                                <div class="fw-bold mt-5">Email</div>
                                <div class="text-gray-600">
                                    <a href="#" class="text-gray-600 text-hover-info">{{ $profile->email }}</a>
                                </div>
                                {{-- begin::Details item --}}
                                {{-- begin::Details item --}}
                                {{-- <div class="fw-bold mt-5">Address</div>
                                <div class="text-gray-600">101 Collin Street,
                                    <br />Melbourne 3000 VIC
                                    <br />Australia
                                </div> --}}
                                {{-- begin::Details item --}}
                                {{-- begin::Details item --}}
                                <div class="fw-bold mt-5">Terakhir Login</div>
                                <div class="text-gray-600">{{ \CID::TglJam($auth->last_seen) }}</div>
                                {{-- begin::Details item --}}
                            </div>
                        </div>
                        {{-- end::Details content --}}
                    </div>
                    {{-- end::Card body --}}
                </div>
                {{-- end::Card --}}
            </div>
            {{-- end::Sidebar --}}

            {{-- begin::Content --}}
            <div class="flex-lg-row-fluid ms-lg-15">
                {{-- begin:::Tabs --}}
                <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-semibold mb-8 tabs-profile">
                    {{-- begin:::Tab item --}}
                    <li class="nav-item">
                        <a class="nav-link text-active-info pb-4 path-tab" data-bs-toggle="tab" href="#profile_tab_path_profile">Profile</a>
                    </li>
                    {{-- end:::Tab item --}}
                    {{-- begin:::Tab item --}}
                    <li class="nav-item">
                        <a class="nav-link text-active-info pb-4 path-tab" data-bs-toggle="tab" href="#profile_tab_path_alamat">Alamat</a>
                    </li>
                    {{-- end:::Tab item --}}
                    {{-- begin:::Tab item --}}
                    <li class="nav-item">
                        <a class="nav-link text-active-info pb-4 path-tab" data-bs-toggle="tab" href="#profile_tab_path_keamanan">Keamanan</a>
                    </li>
                    {{-- end:::Tab item --}}
                    {{-- begin:::Tab item --}}
                    <li class="nav-item">
                        <a class="nav-link text-active-info pb-4 path-tab" data-bs-toggle="tab" href="#profile_tab_path_log">Logs</a>
                    </li>
                    {{-- end:::Tab item --}}
                </ul>
                {{-- end:::Tabs --}}

                {{-- begin:::Tab content --}}
                <div class="tab-content" id="myTabContent">
                    {{-- path-profile::begin --}}
                    @include('pages.admin.pdp_apps.auth.path_profile')
                    {{-- path-profile::end --}}
                    {{-- path-keamanan::begin --}}
                    @include('pages.admin.pdp_apps.auth.path_alamat')
                    {{-- path-keamanan::end --}}
                    {{-- path-keamanan::begin --}}
                    @include('pages.admin.pdp_apps.auth.path_keamanan')
                    {{-- path-keamanan::end --}}
                    {{-- path-keamanan::begin --}}
                    @include('pages.admin.pdp_apps.auth.path_log')
                    {{-- path-keamanan::end --}}
                </div>
                {{-- end:::Tab content --}}

            </div>
            {{-- end::Content --}}
        </div>
        {{-- end::Layout --}}
    </div>
    {{-- end::Post --}}
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
            getTabsProfil();
            $(".path-tab").click(function() {
                var href = $(this).attr('href');
                localStorage.setItem('tabsProfilAktif', href);
            })
        });

        function getTabsProfil() {
            var tabsProfilAktif = localStorage.getItem('tabsProfilAktif');
            if (tabsProfilAktif === null) {
                localStorage.setItem('tabsProfilAktif', '#profile_tab_path_profile');
                $(".tabs-profile>li").each(function(index) {
                    if ($(this).find('a[href^="#profile_tab_path_profile"]')) {
                        $('a[href^="#profile_tab_path_profile"]').addClass(" active");
                        $('#profile_tab_path_profile').addClass(" show active");
                    }
                });
            } else {
                $(".tabs-profile>li").each(function(index) {
                    if ($(this).find('a[href^="' + tabsProfilAktif + '"]')) {
                        $('a[href^="' + tabsProfilAktif + '"]').addClass(" active");
                        $(tabsProfilAktif).addClass(" show active");
                    }
                });
            }
        }
    </script>
@endpush
