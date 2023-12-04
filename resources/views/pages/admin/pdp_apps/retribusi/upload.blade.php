@extends('layouts.admin.pdp')
@push('apps')
    SIMEGAL
@endpush
@push('title')
    {{ $title }} | Retribusi | SIMEGAL
@endpush
@push('description')
    {{ $title }} | Retribusi | Sistem Informasi Metrologi Legal Pemerintah Kabupaten Tangerang
@endpush
@push('header-title')
    {{ $title }} | Retribusi
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
        @include('pages.admin.pdp_apps.toolbox.create_edit_retribusi')
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
                <form class="form" action="{{ route('pdp.apps.retribusi.store', [$enc_uuid]) }}" enctype="multipart/form-data" method="POST">
                    @csrf
                    {{-- begin::Card body --}}
                    <div class="card-body p-9">
                        {{-- begin::Row --}}
                        <div class="row mb-8">
                            {{-- begin::Col --}}
                            <div class="col-xl-3">
                                <div class="fs-6 fw-semibold mt-2 mb-3 required">File Bukti Bayar</div>
                            </div>
                            {{-- end::Col --}}
                            {{-- begin::Col --}}
                            @if (isset($data))
                                <div class="col-xl-9 fv-row">
                                    <input type="file" class="form-control @error('file_pembayaran') is-invalid @enderror" name="file_pembayaran" id="file_pembayaran" accept=".png,.jpg,.jpeg,.pdf" />
                                    <div class="form-text">File yang diizinkan: png, jpg, jpeg, pdf. | Maksimal: 5 MB</div>
                                    @error('file_pembayaran')
                                        <div id="file_pembayaranFeedback" class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    @if ($data->file_pembayaran !== null && $data->file_pembayaran != '')
                                        <div class="d-flex justify-content-end align-items-center mt-2">
                                            <a target="_BLANK" href="{{ \CID::urlImg($data->file_pembayaran) }}" class="btn btn-sm btn-secondary btn-icon-info btn-text-info">
                                                <i class="fas fa-search"></i>
                                                Lihat File
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            @else
                                <div class="col-xl-9 fv-row">
                                    <input type="file" class="form-control @error('file_pembayaran') is-invalid @enderror" name="file_pembayaran" id="file_pembayaran" accept=".png,.jpg,.jpeg,.pdf" required />
                                    <div class="form-text">File yang diizinkan: png, jpg, jpeg, pdf. | Maksimal: 5 MB</div>
                                    @error('file_pembayaran')
                                        <div id="file_pembayaranFeedback" class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endif
                        </div>
                        {{-- end::Row --}}

                    </div>
                    {{-- end::Card body --}}
                    {{-- begin::Card footer --}}
                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                        <a href="{{ route('pdp.apps.retribusi.index') }}" class="btn btn-light btn-active-light-primary me-2"><i class="fa-solid fa-times"></i>Batal</a>
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
@endpush
