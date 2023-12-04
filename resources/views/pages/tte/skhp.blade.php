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
                    <h1 class="fw-bolder text-gray-900 mb-10">DOKUMEN SKHP ASLI</h1>
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
                            <input type="text" class="form-control bg-light-info text-center fs-3" name="nomor_order" id="nomor_order2" value="{{ $pdp->nomor_order }}" readonly />
                            <label for="nomor_order">Nomor Order</label>
                        </div>
                        {{-- end::nomor_order --}}
                        {{-- begin::nama_perusahaan --}}
                        <div class="form-floating mb-5">
                            <input type="text" class="form-control bg-light-info text-center fs-3" name="nama_perusahaan" id="nama_perusahaan2" value="{{ $perusahaan->nama_perusahaan }}" readonly />
                            <label for="nama_perusahaan">Nama Perusahaan/Pemilik UTTP</label>
                        </div>
                        {{-- end::nama_perusahaan --}}
                        {{-- begin::tanggal_expired --}}
                        <div class="form-floating mb-5">
                            <input type="text" class="form-control bg-light-info text-center fs-3" name="tanggal_expired" id="tanggal_expired2" value="{{ \CID::tglBlnThn($data->tanggal_expired) }}" readonly />
                            <label for="tanggal_expired">Tanggal Expired</label>
                        </div>
                        {{-- end::tanggal_expired --}}
                        {{-- begin::status --}}
                        @php
                            $tanggal_expired = $data->tanggal_expired;
                            $masa_aktif = \CID::hitungMasaAktif($tanggal_expired);
                            // background tr
                            if ($masa_aktif == 'Expired') {
                                $tr_masa_aktif = 'bg-danger text-white';
                            } elseif ($masa_aktif <= '90') {
                                $tr_masa_aktif = 'bg-light-warning bg-hover-warning text-dark';
                            } else {
                                $tr_masa_aktif = '';
                            }
                        @endphp
                        @if ($masa_aktif == '0')
                            <div class="py-8 flex-fill bg-warning text-white text-center fs-5">
                                Masa Aktif: {{ \CID::hitungMasaAktifLengkap($tanggal_expired) }}
                            </div>
                        @elseif($masa_aktif == 'Expired')
                            <div class="p-3 bg-danger text-center text-dark rounded-3">
                                SERTIFIKAT EXPIRED
                            </div>
                        @else
                            <div class="py-8 flex-fill bg-primary text-white text-center fs-2">
                                Masa Aktif: {{ $masa_aktif }} Hari
                            </div>
                        @endif
                        {{-- end::status --}}
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
