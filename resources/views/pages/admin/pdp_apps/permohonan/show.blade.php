@extends('layouts.admin.pdp')
@push('apps')
    SIMEGAL
@endpush
@push('title')
    {{ $title }} | Permohonan Pengujian | SIMEGAL
@endpush
@push('description')
    {{ $title }} | Permohonan Pengujian | Sistem Informasi Metrologi Legal Pemerintah Kabupaten Tangerang
@endpush
@push('header-title')
    {{ $title }} | Permohonan Pengujian
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
        @include('pages.admin.pdp_apps.toolbox.create_edit_peneraan')
    @endif
@endpush
{{-- TOOLBOX::END --}}

{{-- CONTENT::BEGIN --}}
@section('content')
    @if ($profile->file_npwp !== null && $profile->file_npwp != '')
        {{-- begin::Post --}}
        <div class="content flex-row-fluid" id="kt_content">
            {{-- begin::Card --}}
            <div class="card">
                {{-- begin::Card header --}}
                <div class="card-header">
                    {{-- begin::Card title --}}
                    <div class="card-title fs-3 fw-bold">Form {{ $title }}</div>
                    {{-- end::Card title --}}
                </div>
                {{-- end::Card header --}}
                {{-- begin::Form --}}
                {{-- begin::Card body --}}
                <div class="card-body p-9">

                    {{-- begin::Row --}}
                    <div class="row mb-8">
                        {{-- begin::Col --}}
                        <div class="col-xl-3">
                            <div class="fs-6 fw-semibold mt-2 mb-3">Kode Permohonan</div>
                        </div>
                        {{-- end::Col --}}
                        {{-- begin::Col --}}
                        <div class="col-xl-9 fv-row">
                            <input type="text" class="form-control" value="{{ $data->kode_permohonan }}" disabled />
                        </div>
                    </div>
                    {{-- end::Row --}}

                    {{-- begin::Row --}}
                    <div class="row mb-8">
                        {{-- begin::Col --}}
                        <div class="col-xl-3">
                            <div class="fs-6 fw-semibold mt-2 mb-3">Jenis Pengujian</div>
                        </div>
                        {{-- end::Col --}}
                        {{-- begin::Col --}}
                        <div class="col-xl-9 fv-row">
                            <input type="text" class="form-control" value="{{ $data->jenis_pengujian }}" disabled />
                        </div>
                    </div>
                    {{-- end::Row --}}

                    {{-- begin::Row --}}
                    <div class="row mb-8">
                        {{-- begin::Col --}}
                        <div class="col-xl-3">
                            <div class="fs-6 fw-semibold mt-2 mb-3">Nomor Surat Permohonan</div>
                        </div>
                        {{-- end::Col --}}
                        {{-- begin::Col --}}
                        <div class="col-xl-9 fv-row">
                            <input type="text" class="form-control" value="{{ $data->nomor_surat_permohonan }}" disabled />
                        </div>
                    </div>
                    {{-- end::Row --}}

                    {{-- begin::Row --}}
                    <div class="row mb-8">
                        {{-- begin::Col --}}
                        <div class="col-xl-3">
                            <div class="fs-6 fw-semibold mt-2 mb-3">File Surat Permohonan</div>
                        </div>
                        {{-- end::Col --}}
                        {{-- begin::Col --}}
                        <div class="col-xl-9 fv-row">
                            @if ($data->file_surat_permohonan !== null && $data->file_surat_permohonan != '')
                                <div class="d-flex justify-content-end align-items-center mt-2">
                                    <a target="_BLANK" href="{{ \CID::urlImg($data->file_surat_permohonan) }}" class="btn btn-sm btn-secondary btn-icon-info btn-text-info">
                                        <i class="fas fa-search"></i>
                                        Lihat File
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                    {{-- end::Row --}}

                    {{-- begin::Row --}}
                    <div class="row mb-8">
                        {{-- begin::Col --}}
                        <div class="col-xl-3">
                            <div class="fs-6 fw-semibold mt-2 mb-3">Tanggal Permohonan Kunjungan Peneraan</div>
                        </div>
                        {{-- end::Col --}}
                        {{-- begin::Col --}}
                        <div class="col-xl-9 fv-row">
                            <input type="date" class="form-control" value="{{ $data->tanggal_permohonan }}" disabled />
                        </div>
                    </div>
                    {{-- end::Row --}}

                    {{-- begin::Row --}}
                    <div class="row mb-8">
                        {{-- begin::Col --}}
                        <div class="col-xl-3">
                            <div class="fs-6 fw-semibold mt-2 mb-3">Lokasi Pengujian</div>
                        </div>
                        {{-- end::Col --}}
                        {{-- begin::Col --}}
                        <div class="col-xl-9 fv-row">
                            <input type="text" class="form-control" value="{{ $data->lokasi_peneraan }}" disabled />
                        </div>
                    </div>
                    {{-- end::Row --}}

                    @if ($data->lokasi_peneraan == 'Luar Kantor Metrologi')
                        {{-- begin::Row --}}
                        <div class="row mb-8">
                            {{-- begin::Col --}}
                            <div class="col-xl-3">
                                <div class="fs-6 fw-semibold mt-2 mb-3">Alamat {{ $profile->jenis_perusahaan }}</div>
                            </div>
                            {{-- end::Col --}}
                            {{-- begin::Col --}}
                            <div class="col-xl-9 fv-row">
                                <div class="d-flex flex-stack">
                                    {{-- begin::Content --}}
                                    <div class="d-flex flex-column">
                                        <span class="fw-bold">{{ $data->RelAlamatPerusahaan->label_alamat }} - {{ \Str::title($data->RelAlamatPerusahaan->Kecamatan->name) }}</span>
                                        <div class="text-gray-600">
                                            {{ $data->RelAlamatPerusahaan->alamat }}, {{ isset($data->RelAlamatPerusahaan->rt) ? 'RT. ' . $data->RelAlamatPerusahaan->rt . ', ' : '' }}
                                            {{ isset($data->RelAlamatPerusahaan->rw) ? 'RW. ' . $data->RelAlamatPerusahaan->rw . ', ' : '' }}
                                            {{ \Str::title($data->RelAlamatPerusahaan->Desa->name) }}, {{ \Str::title($data->RelAlamatPerusahaan->Kecamatan->name) }},
                                            {{ \Str::title($data->RelAlamatPerusahaan->Kabupaten->name) }}, {{ \Str::title($data->RelAlamatPerusahaan->Provinsi->name) }}{{ isset($data->RelAlamatPerusahaan->kode_pos) ? ', ' . $data->RelAlamatPerusahaan->kode_pos . '.' : '.' }}
                                        </div>
                                    </div>
                                    {{-- end::Content --}}
                                    {{-- begin::Action --}}
                                    <div class="d-flex justify-content-end align-items-center">
                                        {{-- begin::Button --}}
                                        @if ($data->RelAlamatPerusahaan->google_maps != '' || ($data->RelAlamatPerusahaan->lat != '' && $data->RelAlamatPerusahaan->long != ''))
                                            @if ($data->RelAlamatPerusahaan->google_maps != '')
                                                @php
                                                    $url_maps = $data->RelAlamatPerusahaan->google_maps;
                                                @endphp
                                            @elseif($data->RelAlamatPerusahaan->lat != '' && $data->RelAlamatPerusahaan->long != '')
                                                @php
                                                    $url_maps = 'https://www.google.com/maps/search/?api=1&query=' . $data->RelAlamatPerusahaan->lat . ',' . $data->RelAlamatPerusahaan->long . '';
                                                @endphp
                                            @endif
                                            <a target="_BLANK" href="{{ $url_maps }}" class="btn btn-icon btn-active-light-primary w-30px h-30px ms-auto me-5">
                                                <i class="fa-solid fa-map-location-dot"></i>
                                            </a>
                                        @endif
                                        {{-- end::Button --}}
                                    </div>
                                    {{-- end::Action --}}
                                </div>
                            </div>
                        </div>
                        {{-- end::Row --}}
                    @endif

                    {{-- begin::Row --}}
                    <div class="row mb-8">
                        {{-- begin::Col --}}
                        <div class="col-xl-3">
                            <div class="fs-6 fw-semibold mt-2 mb-3">Tanggal Verifikasi</div>
                        </div>
                        {{-- end::Col --}}
                        {{-- begin::Col --}}
                        <div class="col-xl-9 fv-row">
                            <input type="text" class="form-control" value="{{ \CID::TglJam($data->tanggal_verifikasi) }}" disabled />
                        </div>
                    </div>
                    {{-- end::Row --}}

                </div>
                {{-- end::Card body --}}
                {{-- begin::Card footer --}}
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <a href="{{ route('pdp.apps.reqpeneraan.index') }}" class="btn btn-light btn-active-light-primary me-2"><i class="fa-solid fa-times"></i>Tutup</a>
                </div>
                {{-- end::Card footer --}}
                {{-- end:Form --}}
            </div>
            {{-- end::Card --}}
        </div>
        {{-- end::Post --}}
    @endif
@endsection
{{-- CONTENT::END --}}
