@extends('layouts.admin.settings')
@push('apps')
    SIMEGAL
@endpush
@push('title')
    Manajemen SKHP | Tindak Lanjut | SIMEGAL
@endpush
@push('description')
    Manajemen SKHP | Tindak Lanjut | Sistem Informasi Metrologi Legal Pemerintah Kabupaten Tangerang
@endpush
@push('header-title')
    Manajemen SKHP | Tindak Lanjut
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
                <h1 class="d-flex text-dark fw-bold my-1 fs-3">Manajemen SKHP</h1>
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
                        <a href="{{ route('scd.apps.tinjut.' . $jenis_uttp . '.index') }}" class="text-muted text-hover-primary">Tindak Lanjut</a>
                    </li>
                    {{-- end::Item --}}
                    {{-- begin::Item --}}
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-200 w-5px h-2px"></span>
                    </li>
                    {{-- end::Item --}}
                    {{-- begin::Item --}}
                    <li class="breadcrumb-item text-dark">Manajemen SKHP</li>
                    {{-- end::Item --}}
                </ul>
                {{-- end::Breadcrumb --}}
            </div>
            {{-- end::Page title --}}
            {{-- begin::Actions --}}
            <div class="d-flex align-items-center py-2 py-md-1">
                {{-- begin::Button --}}
                <a href="{{ route('scd.apps.tinjut.' . $jenis_uttp . '.index') }}" class="btn btn-dark btn-sm btn-icon"><i class="fa-solid fa-chevron-left"></i></a>
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
                            @if (isset($tte))
                                @php
                                    $urlTte = \route('cek.tte.skhp', $tte->kode_tte);
                                @endphp
                                @if ($tte->status_acc == '0')
                                    {{-- begin::Alert --}}
                                    <div class="alert alert-dismissible bg-light-warning border border-dashed border-warning d-flex flex-column flex-sm-row p-5 mb-5">
                                        {{-- begin::Icon --}}
                                        <i class="fa-solid fa-qrcode fs-2hx text-warning me-4 mb-5 mb-sm-0"></i>
                                        {{-- end::Icon --}}
                                        {{-- begin::Wrapper --}}
                                        <div class="d-flex flex-column">
                                            {{-- begin::Title --}}
                                            <h5 class="mb-1">TTE Menunggu Persetujuan</h5>
                                            {{-- end::Title --}}
                                            {{-- begin::Content --}}
                                            <span>Permohonan TTE Sedang Menunggu Disetujui Oleh Pejabat Penandatangan.</span>
                                            {{-- end::Content --}}
                                        </div>
                                        {{-- end::Wrapper --}}
                                    </div>
                                    {{-- end::Alert --}}
                                @endif
                                <div class="text-center mb-5">
                                    @if ($tte->status_acc == '2')
                                        {!! QrCode::size(290)->backgroundColor(255, 55, 0)->generate($urlTte) !!}
                                    @else
                                        {!! QrCode::size(290)->generate($urlTte) !!}
                                    @endif
                                    <div class="mt-5">
                                        <a href="{{ route('scd.apps.tinjut.action.skhp.unduh', [$tags_jp, $enc_uuid, $tte->kode_tte]) }}" class="btn btn-light-info"><i class="fa fa-download"></i> Unduh QR TTE</a>
                                        <a href="javascript:void(0);" class="btn btn-light-danger" data-hapus-tte="{{ \CID::encode($tte->uuid) }}"><i class="fa fa-trash me-0"></i></a>
                                    </div>
                                </div>
                                {{-- begin::Details toggle --}}
                                <div class="d-flex flex-stack fs-4 py-3">
                                    <div class="fw-bold rotate collapsible" data-bs-toggle="collapse" href="#kt_user_view_details" role="button" aria-expanded="false" aria-controls="kt_user_view_details">Informasi TTE
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
                                        <div class="fw-bold mt-5">Kode TTE</div>
                                        <div class="text-gray-600">
                                            {{ $tte->kode_tte }}
                                        </div>
                                        {{-- end::Details item --}}
                                        {{-- begin::Details item --}}
                                        <div class="fw-bold mt-5">Status TTE</div>
                                        @if ($tte->status_acc == '0')
                                            <div class="p-3 bg-warning text-center rounded-3">
                                                TTE Menunggu Persetujuan
                                            </div>
                                        @elseif ($tte->status_acc == '1')
                                            <div class="p-3 bg-success text-center rounded-3">
                                                TTE Disetujui
                                            </div>
                                        @elseif ($tte->status_acc == '2')
                                            <div class="p-3 bg-danger text-center rounded-3">
                                                TTE Ditolak
                                            </div>
                                        @endif
                                        {{-- end::Details item --}}
                                        {{-- begin::Details item --}}
                                        <div class="fw-bold mt-5">Tgl. Generate TTE</div>
                                        <div class="text-gray-600">
                                            {{ \CID::tglBlnThn($tte->tanggal_generate) }}
                                        </div>
                                        {{-- end::Details item --}}
                                        {{-- begin::Details item --}}
                                        <div class="fw-bold mt-5">Tgl. Expired SKHP</div>
                                        <div class="text-gray-600">
                                            {{ \CID::tglBlnThn($tte->tanggal_expired) }}}
                                        </div>
                                        {{-- end::Details item --}}
                                        {{-- begin::Details item --}}
                                        <div class="fw-bold mt-5">Tgl. Acc Pejabat</div>
                                        <div class="text-gray-600">
                                            {{ isset($tte->tanggal_acc) ? \CID::tglBlnThn($tte->tanggal_acc) : '-' }}
                                        </div>
                                        {{-- end::Details item --}}
                                        {{-- begin::Details item --}}
                                        <div class="fw-bold mt-5">Pejabat Penandatangan</div>
                                        <div class="text-gray-600">
                                            @if ($tte->jabatan_pejabat == 'Ketua Tim')
                                                <a target="_BLANK" href="{{ route('set.apps.pegawai.show', [\CID::encode($tte->uuid_pejabat)]) }}" class="text-gray-600 text-hover-info">{{ $tte->RelPegawai->nama_lengkap }}</a>
                                            @elseif($tte->jabatan_pejabat == 'Kepala Dinas')
                                                <a target="_BLANK" href="{{ route('set.apps.kadis.show', [\CID::encode($tte->uuid_pejabat)]) }}" class="text-gray-600 text-hover-info">{{ $tte->RelPegawai->nama_lengkap }}</a>
                                            @elseif($tte->jabatan_pejabat == 'Kepala Bidang')
                                                <a target="_BLANK" href="{{ route('set.apps.kabid.show', [\CID::encode($tte->uuid_pejabat)]) }}" class="text-gray-600 text-hover-info">{{ $tte->RelPegawai->nama_lengkap }}</a>
                                            @endif
                                        </div>
                                        {{-- end::Details item --}}
                                    </div>
                                </div>
                                {{-- end::Details content --}}
                            @else
                                {{-- begin::Alert --}}
                                <div class="alert alert-dismissible bg-light-danger border border-dashed border-danger d-flex flex-column flex-sm-row p-5 mb-5">
                                    {{-- begin::Icon --}}
                                    <i class="fa-solid fa-qrcode fs-2hx text-danger me-4 mb-5 mb-sm-0"></i>
                                    {{-- end::Icon --}}

                                    {{-- begin::Wrapper --}}
                                    <div class="d-flex flex-column">
                                        {{-- begin::Title --}}
                                        <h5 class="mb-1">SKHP Belum Ada TTE</h5>
                                        {{-- end::Title --}}

                                        {{-- begin::Content --}}
                                        <span>Permohonan ini belum memiliki SKHP dan belum memiliki TTE.</span>
                                        {{-- end::Content --}}
                                    </div>
                                    {{-- end::Wrapper --}}
                                </div>
                                {{-- end::Alert --}}
                                <img src="{{ asset('assets-apps/media/custom/qr-1.png') }}" class="img-fluid" alt="QR Not Found!">
                            @endif
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
                        @if (isset($tte))
                            {{-- begin:::Tab item --}}
                            <li class="nav-item">
                                <a class="nav-link text-active-info pb-4 path-tab" data-bs-toggle="tab" href="#profile_tab_path_dokumen">Dokumen SKHP</a>
                            </li>
                            {{-- end:::Tab item --}}
                        @else
                            {{-- begin:::Tab item --}}
                            <li class="nav-item">
                                <a class="nav-link text-active-info pb-4 path-tab" data-bs-toggle="tab" href="#profile_tab_path_generate">Generate Signature</a>
                            </li>
                            {{-- end:::Tab item --}}
                        @endif
                    </ul>
                    {{-- end:::Tabs --}}

                    {{-- begin:::Tab content --}}
                    <div class="tab-content" id="myTabContent">
                        @if (isset($tte))
                            {{-- path-skhp::begin --}}
                            @include('pages.admin.schedule_apps.tindak_lanjut.action.skhp.path_skhp')
                            {{-- path-skhp::end --}}
                        @else
                            {{-- path-qr::begin --}}
                            @include('pages.admin.schedule_apps.tindak_lanjut.action.skhp.path_qr')
                            {{-- path-qr::end --}}
                        @endif
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
    @if (isset($tte))
        <script>
            $(document).ready(function() {
                getTabsProfil();
                $('a[href^="#profile_tab_path_generate"]').removeClass(" active");
                $('#profile_tab_path_generate').removeClass(" show active");
                $(".path-tab").click(function() {
                    var href = "#profile_tab_path_dokumen";
                    localStorage.setItem('tabsSkhpAktip', href);
                })

                function getTabsProfil() {
                    var tabsSkhpAktip = "#profile_tab_path_dokumen";
                    if (tabsSkhpAktip === null) {
                        localStorage.setItem('tabsSkhpAktip', '#profile_tab_path_dokumen');
                        $(".tabs-profile>li").each(function(index) {
                            if ($(this).find('a[href^="#profile_tab_path_dokumen"]')) {
                                $('a[href^="#profile_tab_path_dokumen"]').addClass(" active");
                                $('#profile_tab_path_dokumen').addClass(" show active");
                            }
                        });
                    } else {
                        $(".tabs-profile>li").each(function(index) {
                            if ($(this).find('a[href^="' + tabsSkhpAktip + '"]')) {
                                $('a[href^="' + tabsSkhpAktip + '"]').addClass(" active");
                                $(tabsSkhpAktip).addClass(" show active");
                            }
                        });
                    }
                }
            });
        </script>
        {{-- hapus tte --}}
        <script>
            $(document).on('click', "[data-hapus-tte]", function() {
                let uuid = $(this).attr('data-hapus-tte');
                Swal.fire({
                    title: "Hapus QR TTE",
                    text: "Apakah Anda Yakin?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Iya",
                    cancelButtonText: 'Tidak',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{!! route('scd.apps.tinjut.action.skhp.destroy', [$tags_jp, $enc_uuid]) !!}",
                            type: 'POST',
                            data: {
                                uuid: uuid,
                                _method: 'delete',
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
    @else
        <script>
            $(document).ready(function() {
                getTabsProfil();
                $('a[href^="#profile_tab_path_dokumen"]').removeClass(" active");
                $('#profile_tab_path_dokumen').removeClass(" show active");
                $(".path-tab").click(function() {
                    var href = "#profile_tab_path_generate";
                    localStorage.setItem('tabsSkhpAktip', href);
                })

                function getTabsProfil() {
                    var tabsSkhpAktip = "#profile_tab_path_generate";
                    if (tabsSkhpAktip === null) {
                        localStorage.setItem('tabsSkhpAktip', '#profile_tab_path_generate');
                        $(".tabs-profile>li").each(function(index) {
                            if ($(this).find('a[href^="#profile_tab_path_generate"]')) {
                                $('a[href^="#profile_tab_path_generate"]').addClass(" active");
                                $('#profile_tab_path_generate').addClass(" show active");
                            }
                        });
                    } else {
                        $(".tabs-profile>li").each(function(index) {
                            if ($(this).find('a[href^="' + tabsSkhpAktip + '"]')) {
                                $('a[href^="' + tabsSkhpAktip + '"]').addClass(" active");
                                $(tabsSkhpAktip).addClass(" show active");
                            }
                        });
                    }
                }
            });
        </script>
    @endif
@endpush
