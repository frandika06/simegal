@extends('layouts.admin.settings')
@push('apps')
    SIMEGAL
@endpush
@push('title')
    {{ $title }} | Pengaturan Aplikasi | SIMEGAL
@endpush
@push('description')
    {{ $title }} | Pengaturan Aplikasi | Sistem Informasi Metrologi Legal Pemerintah Kabupaten Tangerang
@endpush
@push('header-title')
    {{ $title }} | Pengaturan Aplikasi
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
                <h1 class="d-flex text-dark fw-bold my-1 fs-3">Jenis Pelayanan</h1>
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
                    <li class="breadcrumb-item text-muted">Master Data</li>
                    {{-- end::Item --}}
                    {{-- begin::Item --}}
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-200 w-5px h-2px"></span>
                    </li>
                    {{-- end::Item --}}
                    {{-- begin::Item --}}
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('set.apps.mst.uttp.jp.index') }}" class="text-muted text-hover-primary">Jenis Pelayanan</a>
                    </li>
                    {{-- end::Item --}}
                    {{-- begin::Item --}}
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-200 w-5px h-2px"></span>
                    </li>
                    {{-- end::Item --}}
                    {{-- begin::Item --}}
                    <li class="breadcrumb-item text-dark">{{ $title }}</li>
                    {{-- end::Item --}}
                </ul>
                {{-- end::Breadcrumb --}}
            </div>
            {{-- end::Page title --}}
            {{-- begin::Actions --}}
            <div class="d-flex align-items-center py-2 py-md-1">
                {{-- begin::Button --}}
                <a href="{{ route('set.apps.mst.uttp.jp.index') }}" class="btn btn-dark btn-sm btn-icon"><i class="fa-solid fa-chevron-left"></i></a>
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
            {{-- begin::Card --}}
            <div class="card pt-4 mb-6 mb-xl-9">
                {{-- begin::Card header --}}
                <div class="card-header border-0">
                    {{-- begin::Card title --}}
                    <div class="card-title flex-column">
                        <h2>{{ $title }}</h2>
                    </div>
                    {{-- end::Card title --}}
                </div>
                {{-- end::Card header --}}
                {{-- begin::Card body --}}
                <div class="card-body">
                    <div class="row form-group">
                        <div class="col-lg-3">
                            <label for="nama_pelayanan" class="required">Nama Pelayanan</label>
                        </div>
                        <div class="col-lg-9">
                            {{-- begin::nama_pelayanan --}}
                            <input type="text" class="form-control" value="{{ $data->nama_pelayanan }}" readonly />
                            {{-- end::nama_pelayanan --}}
                        </div>
                    </div>

                    {{-- begin::Action buttons --}}
                    <div class="d-flex justify-content-end align-items-center mt-12">
                        <a href="{{ route('set.apps.mst.uttp.jp.index') }}" class="btn btn-secondary"><i class="fa-solid fa-times-circle"></i> Tutup</a>
                    </div>
                    {{-- begin::Action buttons --}}
                </div>
                {{-- end::Card body --}}
                {{-- begin::Card footer --}}
                {{-- end::Card footer --}}
            </div>
            {{-- end::Card --}}
        </div>
        {{-- end::Container --}}
    </div>
    {{-- end::Post --}}
@endsection
{{-- CONTENT::END --}}

@push('scripts')
    {{-- CUTOM JS --}}
@endpush
