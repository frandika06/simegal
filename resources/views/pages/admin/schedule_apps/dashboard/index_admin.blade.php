@extends('layouts.admin.schedule')
@push('apps')
    SIMEGAL
@endpush
@push('title')
    Penjadwalan & Penugasan | SIMEGAL
@endpush
@push('description')
    Penjadwalan & Penugasan | Sistem Informasi Metrologi Legal Pemerintah Kabupaten Tangerang
@endpush
@push('header-title')
    Penjadwalan & Penugasan
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
                <h1 class="d-flex text-dark fw-bold my-1 fs-3">Dashboard</h1>
                {{-- end::Title --}}
            </div>
            {{-- end::Page title --}}
            {{-- begin::Actions --}}
            <div class="d-flex align-items-center py-2 py-md-1">
                {{-- begin::Wrapper --}}
                <div class="me-3">
                    {{-- begin::Menu --}}
                    {{-- <select class="form-select" name="q_tahun" id="q_tahun">
                        @if (\count($tahunPermohonan) > 0)
                            @foreach ($tahunPermohonan as $item)
                                <option value="{{ $item->year }}" @if ($tahun == $item->year) selected @endif>{{ $item->year }}</option>
                            @endforeach
                        @else
                            <option value="{{ $tahun }}">{{ $tahun }}</option>
                        @endif
                    </select> --}}
                    {{-- end::Menu --}}
                </div>
                {{-- end::Wrapper --}}
                {{-- begin::Button --}}
                {{-- <a href="{{ route('pdp.apps.reqpeneraan.create') }}" class="btn btn-info fw-bold">Ajukan Permohonan</a> --}}
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
    <div class="post d-flex flex-column-fluid" id="kt_post">
        {{-- begin::Container --}}
        <div id="kt_content_container" class="container-xxl">
            {{-- begin::Card --}}
            <div class="card">
                {{-- begin::Card body --}}
                <div class="card-body">
                    {{-- begin::Heading --}}
                    <div class="card-px text-center pt-15 pb-15">
                        {{-- begin::Title --}}
                        <h2 class="fs-2x fw-bold mb-0">{{ \CID::welcomeBack() }}</h2>
                        {{-- end::Title --}}
                        {{-- begin::Description --}}
                        <p class="text-gray-400 fs-4 fw-semibold py-7">Selamat datang di Penjadwalan & Penugasan.
                            <br />Anda bisa memanajemen pengguna dan lain sebagainya.
                        </p>
                        {{-- end::Description --}}
                        {{-- begin::Action --}}
                        {{-- <a href="#" class="btn btn-primary er fs-6 px-8 py-4" data-bs-toggle="modal" data-bs-target="#kt_modal_users_search">Search Users</a> --}}
                        {{-- end::Action --}}
                    </div>
                    {{-- end::Heading --}}
                    {{-- begin::Illustration --}}
                    <div class="text-center pb-15 px-5">
                        <img src="{{ asset('assets-apps/media/icon-dashboard/04.svg') }}" alt="" class="mw-100 h-200px h-sm-325px" />
                    </div>
                    {{-- end::Illustration --}}
                </div>
                {{-- end::Card body --}}
            </div>
            {{-- end::Card --}}
        </div>
        {{-- end::Container --}}
    </div>
@endsection
{{-- CONTENT::END --}}

@push('scripts')
@endpush
