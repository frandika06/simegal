@extends('layouts.admin.settings')
@push('apps')
    SIMEGAL
@endpush
@push('title')
    Edit {{ $profile->nama_perusahaan }} | SIMEGAL
@endpush
@push('description')
    Edit {{ $profile->nama_perusahaan }} | Sistem Informasi Metrologi Legal Pemerintah Kabupaten Tangerang
@endpush
@push('header-title')
    Edit {{ $profile->nama_perusahaan }}
@endpush
@push('styles')
    {{-- begin::Vendor Stylesheets(used for this page only) --}}
    {{-- end::Vendor Stylesheets --}}
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
                <h1 class="d-flex text-dark fw-bold my-1 fs-3">Perusahaan</h1>
                {{-- end::Title --}}
                {{-- begin::Breadcrumb --}}
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 pt-1">
                    {{-- begin::Item --}}
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('set.apps.home.index') }}" class="text-muted text-hover-primary">Dashboard</a>
                    </li>
                    {{-- end::Item --}}
                    {{-- begin::Item --}}
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-200 w-5px h-2px"></span>
                    </li>
                    {{-- end::Item --}}
                    {{-- begin::Item --}}
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('set.apps.perusahaan.index', [$enc_tags]) }}" class="text-muted text-hover-primary">Perusahaan</a>
                    </li>
                    {{-- end::Item --}}
                    {{-- begin::Item --}}
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-200 w-5px h-2px"></span>
                    </li>
                    {{-- end::Item --}}
                    {{-- begin::Item --}}
                    <li class="breadcrumb-item text-dark">Edit Perusahaan</li>
                    {{-- end::Item --}}
                </ul>
                {{-- end::Breadcrumb --}}
            </div>
            {{-- end::Page title --}}
            {{-- begin::Actions --}}
            <div class="d-flex align-items-center py-2 py-md-1">
                {{-- begin::Button --}}
                <a href="{{ route('set.apps.perusahaan.index', [$enc_tags]) }}" class="btn btn-dark btn-sm btn-icon"><i class="fa-solid fa-chevron-left"></i></a>
                {{-- end::Button --}}
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
                                    <img src="{{ \CID::pp($profile->foto) }}" alt="{{ $profile->nama_perusahaan }}" />
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
                                    <div class="text-gray-600">{{ \CID::TglJam($profile->RelUser->last_seen) }}</div>
                                    {{-- begin::Details item --}}
                                </div>
                            </div>
                            {{-- end::Details content --}}
                        </div>
                        {{-- end::Card body --}}
                        {{-- begin::Card footer --}}
                        @if ($tags == 'Baru Daftar')
                            @if ($profile->file_npwp !== null && $profile->verifikasi == '0' && $profile->status == '1')
                                <div class="card-footer border-0 d-grid gap-2 pt-0">
                                    <button class="btn btn-sm btn-light-success" data-status-aktifkan="{{ $enc_uuid }}"><i class="fa-solid fa-check-double"></i>AKTIFKAN</button>
                                </div>
                            @endif
                        @elseif($tags == 'Perlu Verifikasi')
                            @if ($profile->file_npwp !== null && $profile->verifikasi == '0' && $profile->status == '1')
                                <div class="card-footer border-0 d-grid gap-2 pt-0">
                                    <button class="btn btn-sm btn-light-success" data-status-aktifkan="{{ $enc_uuid }}"><i class="fa-solid fa-check-double"></i>AKTIFKAN</button>
                                </div>
                            @endif
                        @elseif($tags == 'Aktif')
                            @if ($profile->file_npwp !== null && $profile->verifikasi == '1' && $profile->status == '1')
                                <div class="card-footer border-0 d-grid gap-2 pt-0">
                                    <button class="btn btn-sm btn-light-danger" data-status-tangguhkan="{{ $enc_uuid }}"><i class="fa-solid fa-lock"></i>TANGGUHKAN</button>
                                </div>
                            @endif
                        @elseif($tags == 'Ditangguhkan')
                            @if ($profile->file_npwp !== null && $profile->verifikasi == '1' && $profile->status == '0')
                                <div class="card-footer border-0 d-grid gap-2 pt-0">
                                    <button class="btn btn-sm btn-light-success" data-status-aktifkan="{{ $enc_uuid }}"><i class="fa-solid fa-check-double"></i>AKTIFKAN</button>
                                </div>
                            @endif
                        @endif
                        {{-- end::Card footer --}}
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
                        @include('pages.admin.settings_apps.perusahaan.edit_profile.path_profile')
                        {{-- path-profile::end --}}
                        {{-- path-keamanan::begin --}}
                        @include('pages.admin.settings_apps.perusahaan.edit_profile.path_alamat')
                        {{-- path-keamanan::end --}}
                        {{-- path-keamanan::begin --}}
                        @include('pages.admin.settings_apps.perusahaan.edit_profile.path_keamanan')
                        {{-- path-keamanan::end --}}
                        {{-- path-keamanan::begin --}}
                        @include('pages.admin.settings_apps.perusahaan.edit_profile.path_log')
                        {{-- path-keamanan::end --}}
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

@push('scripts')
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

    {{-- BUTTON:: AKTIF & TANGGUHKAN --}}
    <script>
        $(document).on('click', "[data-status-aktifkan]", function() {
            let uuid = $(this).attr('data-status-aktifkan');
            Swal.fire({
                title: "Aktifkan Perusahaan",
                text: "Apakah Anda Yakin?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Iya, Aktifkan!",
                cancelButtonText: 'Tidak, Batalkan!',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{!! route('set.apps.perusahaan.status.aktifkan', [$enc_tags]) !!}",
                        type: 'POST',
                        data: {
                            uuid: uuid,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(res) {
                            Swal.fire({
                                title: "Success",
                                text: res.message,
                                icon: "success",
                            }).then((result) => {
                                location.reload();
                            });
                        },
                        error: function(xhr) {
                            Swal.fire({
                                title: "Error",
                                text: xhr.responseJSON.message,
                                icon: "error",
                            }).then((result) => {
                                location.reload();
                            });
                        }
                    });
                }
            });
        });

        $(document).on('click', "[data-status-tangguhkan]", function() {
            let uuid = $(this).attr('data-status-tangguhkan');
            Swal.fire({
                title: "Tangguhkan Perusahaan",
                text: "Apakah Anda Yakin?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Iya, Tangguhkan!",
                cancelButtonText: 'Tidak, Batalkan!',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{!! route('set.apps.perusahaan.status.tangguhkan', [$enc_tags]) !!}",
                        type: 'POST',
                        data: {
                            uuid: uuid,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(res) {
                            Swal.fire({
                                title: "Success",
                                text: res.message,
                                icon: "success",
                            }).then((result) => {
                                location.reload();
                            });
                        },
                        error: function(xhr) {
                            Swal.fire({
                                title: "Error",
                                text: xhr.responseJSON.message,
                                icon: "error",
                            }).then((result) => {
                                location.reload();
                            });
                        }
                    });
                }
            });
        });
    </script>
@endpush
