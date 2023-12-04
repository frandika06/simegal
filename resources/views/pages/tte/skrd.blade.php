@extends('layouts.admin.tte')
@push('apps')
    SIMEGAL
@endpush
@push('title')
    {{ $title }} | SIMEGAL
@endpush
@push('description')
    {{ $title }} | Sistem Informasi Metrologi Legal Pemerintah Kabupaten Tangerang
@endpush
@push('header-title')
    {{ $title }}
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
    {{-- begin::Authentication - Signup Welcome Message  --}}
    <div class="d-flex flex-column flex-center flex-column-fluid">
        {{-- begin::Content --}}
        <div class="d-flex flex-column flex-center text-center p-10">
            {{-- begin::Wrapper --}}
            <div class="card card-flush w-md-650px py-5">
                <div class="card-body py-5 py-lg-10">
                    {{-- begin::Logo --}}
                    <div class="mb-10">
                        <a href="{{ route('prt.home.index') }}" class="">
                            <img alt="Logo" src="{{ \CID::logoSimegal() }}" class="h-100px" />
                        </a>
                    </div>
                    {{-- end::Logo --}}
                    {{-- begin::Title --}}
                    <h1 class="fw-bolder text-gray-900 mb-10">DOKUMEN SKRD ASLI</h1>
                    {{-- end::Title --}}
                    {{-- begin::Text --}}
                    <div class="fw-semibold fs-6 text-gray-500 mb-7">
                        {{-- begin::kode_permohonan --}}
                        <div class="form-floating mb-5">
                            <input type="text" class="form-control bg-light-info text-center fs-3" name="kode_permohonan" id="kode_permohonan2" value="{{ $permohonan->kode_permohonan }}" readonly />
                            <label for="kode_permohonan">Kode Permohonan</label>
                        </div>
                        {{-- end::kode_permohonan --}}
                        {{-- begin::nomor_order --}}
                        <div class="form-floating mb-5">
                            <input type="text" class="form-control bg-light-info text-center fs-3" name="nomor_order" id="nomor_order2" value="{{ $data->nomor_order }}" readonly />
                            <label for="nomor_order">Nomor Order</label>
                        </div>
                        {{-- end::nomor_order --}}
                        {{-- begin::nama_perusahaan --}}
                        <div class="form-floating mb-5">
                            <input type="text" class="form-control bg-light-info text-center fs-3" name="nama_perusahaan" id="nama_perusahaan2" value="{{ $perusahaan->nama_perusahaan }}" readonly />
                            <label for="nama_perusahaan">Nama Perusahaan/Pemilik UTTP</label>
                        </div>
                        {{-- end::nama_perusahaan --}}
                        {{-- begin::tangal_skrd --}}
                        <div class="form-floating mb-5">
                            <input type="text" class="form-control bg-light-info text-center fs-3" name="tangal_skrd" id="tangal_skrd2" value="{{ \CID::tglBlnThn($retribusi->tgl_skrd) }}" readonly />
                            <label for="tangal_skrd">Tanggal SKRD</label>
                        </div>
                        {{-- end::tangal_skrd --}}
                    </div>
                    {{-- end::Text --}}
                    {{-- begin::Link --}}
                    <div class="mb-0">
                        <a href="{{ route('prt.home.index') }}" class="btn btn-sm btn-primary">Beranda</a>
                    </div>
                    {{-- end::Link --}}
                </div>
            </div>
            {{-- end::Wrapper --}}
        </div>
        {{-- end::Content --}}
    </div>
    {{-- end::Authentication - Signup Welcome Message --}}
@endsection
{{-- CONTENT::END --}}

@push('scripts')
@endpush
