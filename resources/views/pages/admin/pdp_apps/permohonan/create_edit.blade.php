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
                <form class="form" action="{{ isset($data) ? route('pdp.apps.reqpeneraan.update', [$uuid_enc]) : route('pdp.apps.reqpeneraan.store') }}" enctype="multipart/form-data" method="POST">
                    @csrf
                    @isset($data)
                        @method('put')
                    @endisset
                    {{-- begin::Card body --}}
                    <div class="card-body p-9">

                        @if (isset($data))
                            {{-- begin::Row --}}
                            <div class="row mb-8">
                                {{-- begin::Col --}}
                                <div class="col-xl-3">
                                    <div class="fs-6 fw-semibold mt-2 mb-3">Kode Permohonan</div>
                                </div>
                                {{-- end::Col --}}
                                {{-- begin::Col --}}
                                <div class="col-xl-9 fv-row">
                                    <input type="text" class="form-control" value="{{ old('kode_permohonan', isset($data) ? $data->kode_permohonan : '') }}" disabled />
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
                                    <input type="text" class="form-control" value="{{ old('jenis_pengujian', isset($data) ? $data->jenis_pengujian : '') }}" disabled />
                                </div>
                            </div>
                            {{-- end::Row --}}
                        @else
                            {{-- begin::Row --}}
                            <div class="row mb-8">
                                {{-- begin::Col --}}
                                <div class="col-xl-3">
                                    <div class="fs-6 fw-semibold mt-2 mb-3 required">Jenis Pengujian</div>
                                </div>
                                {{-- end::Col --}}
                                {{-- begin::Col --}}
                                <div class="col-xl-9 fv-row">
                                    <select class="form-control" name="jenis_pengujian" id="jenis_pengujian" data-control="select2" data-placeholder="Pilih Jenis Pengujian" data-allow-clear="true" required>
                                        <option></option>
                                        <option @if (old('jenis_pengujian', isset($data) ? $data->jenis_pengujian : '') == 'Tera') selected @endif value="Tera">Tera</option>
                                        <option @if (old('jenis_pengujian', isset($data) ? $data->jenis_pengujian : '') == 'Tera Ulang') selected @endif value="Tera Ulang">Tera Ulang</option>
                                        @if (\CID::getMasterFitur('Pengujian BDKT')->status == '1')
                                            <option @if (old('jenis_pengujian', isset($data) ? $data->jenis_pengujian : '') == 'Pengujian BDKT') selected @endif value="Pengujian BDKT">Pengujian BDKT</option>
                                        @endif
                                    </select>
                                    @error('jenis_pengujian')
                                        <div id="jenis_pengujianFeedback" class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            {{-- end::Row --}}
                        @endif

                        {{-- begin::Row --}}
                        <div class="row mb-8">
                            {{-- begin::Col --}}
                            <div class="col-xl-3">
                                <div class="fs-6 fw-semibold mt-2 mb-3 required">Nomor Surat Permohonan</div>
                            </div>
                            {{-- end::Col --}}
                            {{-- begin::Col --}}
                            <div class="col-xl-9 fv-row">
                                <input type="text" class="form-control @error('nomor_surat_permohonan') is-invalid @enderror" name="nomor_surat_permohonan" id="nomor_surat_permohonan" placeholder="Nomor Surat Permohonan" autocomplete="off" maxlength="100"
                                    value="{{ old('nomor_surat_permohonan', isset($data) ? $data->nomor_surat_permohonan : '') }}" required />
                                @error('nomor_surat_permohonan')
                                    <div id="nomor_surat_permohonanFeedback" class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        {{-- end::Row --}}

                        {{-- begin::Row --}}
                        <div class="row mb-8">
                            {{-- begin::Col --}}
                            <div class="col-xl-3">
                                <div class="fs-6 fw-semibold mt-2 mb-3 required">File Surat Permohonan</div>
                            </div>
                            {{-- end::Col --}}
                            {{-- begin::Col --}}
                            @if (isset($data))
                                <div class="col-xl-9 fv-row">
                                    <input type="file" class="form-control @error('file_surat_permohonan') is-invalid @enderror" name="file_surat_permohonan" id="file_surat_permohonan" accept=".png,.jpg,.jpeg,.pdf" />
                                    <div class="form-text">File yang diizinkan: png, jpg, jpeg, pdf. | Maksimal: 5 MB</div>
                                    @error('file_surat_permohonan')
                                        <div id="file_surat_permohonanFeedback" class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    @if ($data->file_surat_permohonan !== null && $data->file_surat_permohonan != '')
                                        <div class="d-flex justify-content-end align-items-center mt-2">
                                            <a target="_BLANK" href="{{ \CID::urlImg($data->file_surat_permohonan) }}" class="btn btn-sm btn-secondary btn-icon-info btn-text-info">
                                                <i class="fas fa-search"></i>
                                                Lihat File
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            @else
                                <div class="col-xl-9 fv-row">
                                    <input type="file" class="form-control @error('file_surat_permohonan') is-invalid @enderror" name="file_surat_permohonan" id="file_surat_permohonan" accept=".png,.jpg,.jpeg,.pdf" required />
                                    <div class="form-text">File yang diizinkan: png, jpg, jpeg, pdf. | Maksimal: 5 MB</div>
                                    @error('file_surat_permohonan')
                                        <div id="file_surat_permohonanFeedback" class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endif
                        </div>
                        {{-- end::Row --}}

                        {{-- begin::Row --}}
                        <div class="row mb-8">
                            {{-- begin::Col --}}
                            <div class="col-xl-3">
                                <div class="fs-6 fw-semibold mt-2 mb-3 required">Tanggal Permohonan Kunjungan Peneraan</div>
                            </div>
                            {{-- end::Col --}}
                            {{-- begin::Col --}}
                            <div class="col-xl-9 fv-row">
                                <input type="date" class="form-control @error('tanggal_permohonan') is-invalid @enderror" name="tanggal_permohonan" id="tanggal_permohonan" placeholder="Tanggal Peneraan" autocomplete="off" maxlength="10"
                                    value="{{ old('tanggal_permohonan', isset($data) ? $data->tanggal_permohonan : '') }}" required />
                                @error('tanggal_permohonan')
                                    <div id="tanggal_permohonanFeedback" class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        {{-- end::Row --}}

                        {{-- begin::Row --}}
                        <div class="row mb-8">
                            {{-- begin::Col --}}
                            <div class="col-xl-3">
                                <div class="fs-6 fw-semibold mt-2 mb-3 required">Lokasi Pengujian</div>
                            </div>
                            {{-- end::Col --}}
                            {{-- begin::Col --}}
                            <div class="col-xl-9 fv-row">
                                <select class="form-control" name="lokasi_peneraan" id="lokasi_peneraan" data-control="select2" data-placeholder="Pilih Lokasi Pengujian" data-allow-clear="true" required>
                                    <option></option>
                                    <option @if (old('lokasi_peneraan', isset($data) ? $data->lokasi_peneraan : '') == 'Dalam Kantor Metrologi') selected @endif value="Dalam Kantor Metrologi">Dalam Kantor Metrologi</option>
                                    <option @if (old('lokasi_peneraan', isset($data) ? $data->lokasi_peneraan : '') == 'Luar Kantor Metrologi') selected @endif value="Luar Kantor Metrologi">Luar Kantor Metrologi</option>
                                </select>
                                @error('lokasi_peneraan')
                                    <div id="lokasi_peneraanFeedback" class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        {{-- end::Row --}}

                        {{-- begin::Row --}}
                        <div class="row mb-8 d-none" id="divAlamat">
                            {{-- begin::Col --}}
                            <div class="col-xl-3">
                                <div class="fs-6 fw-semibold mt-2 mb-3 required">Alamat {{ $profile->jenis_perusahaan }}</div>
                            </div>
                            {{-- end::Col --}}
                            {{-- begin::Col --}}
                            <div class="col-xl-9 fv-row">
                                <select class="form-control" name="uuid_alamat" id="uuid_alamat" data-control="select2" data-placeholder="Pilih Alamat {{ $profile->jenis_perusahaan }}" data-allow-clear="true">
                                    <option></option>
                                    @foreach ($alamatPerusahaan as $item)
                                        <option @if (old('uuid_alamat', isset($data) ? $data->uuid_alamat : '') == $item->uuid) selected @endif value="{{ $item->uuid }}">
                                            <div class="d-flex flex-column">
                                                [{{ $item->label_alamat }}] - {{ $item->alamat }}, {{ isset($item->rt) ? 'RT. ' . $item->rt . ', ' : '' }}
                                                {{ isset($item->rw) ? 'RW. ' . $item->rw . ', ' : '' }}
                                                {{ \Str::title($item->Desa->name) }}, {{ \Str::title($item->Kecamatan->name) }},
                                                {{ \Str::title($item->Kabupaten->name) }}, {{ \Str::title($item->Provinsi->name) }}{{ isset($item->kode_pos) ? ', ' . $item->kode_pos . '.' : '.' }}
                                            </div>
                                        </option>
                                    @endforeach
                                </select>
                                @error('uuid_alamat')
                                    <div id="uuid_alamatFeedback" class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        {{-- end::Row --}}

                    </div>
                    {{-- end::Card body --}}
                    {{-- begin::Card footer --}}
                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                        <a href="{{ route('pdp.apps.reqpeneraan.index') }}" class="btn btn-light btn-active-light-primary me-2"><i class="fa-solid fa-times"></i>Batal</a>
                        <button type="submit" class="btn btn-info"><i class="fa-solid fa-save"></i>{{ $submit }}</button>
                    </div>
                    {{-- end::Card footer --}}
                </form>
                {{-- end:Form --}}
            </div>
            {{-- end::Card --}}
        </div>
        {{-- end::Post --}}
    @endif
@endsection
{{-- CONTENT::END --}}

@push('scripts')
    {{-- JS CUSTOM --}}
    <script>
        $('[name="lokasi_peneraan"]').change(function() {
            var lokasi_peneraan = $(this).val();
            if (lokasi_peneraan == "Luar Kantor Metrologi") {
                $("#divAlamat").removeClass("d-none");
                $("#uuid_alamat").prop("required", true);
            } else {
                $("#divAlamat").addClass("d-none");
                $("#uuid_alamat").prop("required", false);
            }
        });
    </script>
    @if (isset($data))
        <script>
            var lokasi_peneraan = "{{ $data->lokasi_peneraan }}";
            if (lokasi_peneraan == "Luar Kantor Metrologi") {
                $("#divAlamat").removeClass("d-none");
                $("#uuid_alamat").prop("required", true);
            } else {
                $("#divAlamat").addClass("d-none");
                $("#uuid_alamat").prop("required", false);
            }
        </script>
    @endif
@endpush
