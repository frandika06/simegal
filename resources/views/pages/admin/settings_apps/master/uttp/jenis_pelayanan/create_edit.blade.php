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
                    {{-- begin::Form --}}
                    <form action="{{ route('set.apps.mst.uttp.jp.update', [$enc_uuid]) }}" class="form" enctype="multipart/form-data" method="POST">
                        @csrf
                        @method('put')

                        {{-- begin::no_urut --}}
                        <div class="row form-group mb-5">
                            <div class="col-lg-3">
                                <label for="no_urut" class="required">No. Urut</label>
                            </div>
                            <div class="col-lg-9">
                                <input type="number" class="form-control @error('no_urut') is-invalid @enderror" name="no_urut" id="no_urut" placeholder="No. Urut" autocomplete="off" value="{{ old('no_urut', $data->no_urut) }}" required />
                                @error('no_urut')
                                    <div id="no_urutFeedback" class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        {{-- end::no_urut --}}

                        {{-- begin::nama_pelayanan --}}
                        <div class="row form-group">
                            <div class="col-lg-3">
                                <label for="nama_pelayanan" class="required">Nama Pelayanan</label>
                            </div>
                            <div class="col-lg-9">
                                <input type="text" class="form-control @error('nama_pelayanan') is-invalid @enderror" name="nama_pelayanan" id="nama_pelayanan" placeholder="Nama Pelayanan" autocomplete="off" maxlength="100" value="{{ old('nama_pelayanan', $data->nama_pelayanan) }}" required />
                                @error('nama_pelayanan')
                                    <div id="nama_pelayananFeedback" class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        {{-- end::nama_pelayanan --}}

                        {{-- begin::Action buttons --}}
                        <div class="d-flex justify-content-end align-items-center mt-12">
                            {{-- begin::Button --}}
                            <button type="submit" class="btn btn-info"><i class="fa-solid fa-save"></i>{{ $submit }}</button>
                            {{-- end::Button --}}
                        </div>
                        {{-- begin::Action buttons --}}

                    </form>
                    {{-- end::Form --}}
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
