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
                    <h1 class="fw-bolder text-gray-900 mb-5">{{ $title }}</h1>
                    {{-- end::Title --}}
                    {{-- begin::Text --}}
                    <div class="fw-semibold fs-6 text-gray-500 mb-7">
                        {{-- begin::nomor_order --}}
                        <div class="fw-semibold fs-6 text-gray-500 mb-7">Dokumen Yang Anda Scan Tidak Ditemukan di Sistem Kami. <br />Pastikan Anda Memiliki Dokumen Yang Dikeluarkan <strong>RESMI</strong> dari SIMEGAL.
                        </div>
                        {{-- end::nomor_order --}}
                    </div>
                    {{-- end::Text --}}
                    {{-- begin::Illustration --}}
                    <div class="mb-10">
                        <img src="{{ asset('assets-apps/media/custom/404/2.png') }}" class="mw-100 mh-300px theme-light-show" alt="{{ $title }}" />
                    </div>
                    {{-- end::Illustration --}}
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
