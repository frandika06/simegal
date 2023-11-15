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
                <h1 class="d-flex text-dark fw-bold my-1 fs-3">Daftar Item UTTP</h1>
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
                        <a href="{{ route('set.apps.mst.ins.uttp.item.index') }}" class="text-muted text-hover-primary">Daftar Item UTTP</a>
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
                <a href="{{ route('set.apps.mst.ins.uttp.item.index') }}" class="btn btn-dark btn-sm btn-icon"><i class="fa-solid fa-chevron-left"></i></a>
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
                    <form action="{{ route('set.apps.mst.ins.uttp.item.update', [$enc_uuid]) }}" class="form" enctype="multipart/form-data" method="POST">
                        @csrf
                        @method('put')

                        {{-- begin::nama_jenis_uttp --}}
                        <div class="row form-group">
                            <div class="col-lg-3">
                                <label for="nama_jenis_uttp" class="required">Nama Jenis UTTP</label>
                            </div>
                            <div class="col-lg-9">
                                <input type="text" class="form-control" value="{{ $data->RelMasterInstrumenJenisUttp->nama_jenis_uttp }}" disabled />
                            </div>
                        </div>
                        {{-- end::nama_jenis_uttp --}}

                        {{-- begin::status_volume --}}
                        <div class="row form-group mb-5">
                            <div class="col-lg-3">
                                <label for="status_volume" class="required">Status Volume</label>
                            </div>
                            <div class="col-lg-9">
                                {{-- begin::Volume --}}
                                <div class="form-check form-check-custom form-check-solid mb-4 mt-5">
                                    <input class="form-check-input @error('status_volume') is-invalid @enderror" type="radio" value="1" name="status_volume" id="volume" @if ($data->RelMasterInstrumenJenisUttp->status_volume == '1') checked @endif disabled />
                                    <label class="form-check-label" for="volume">
                                        Volume
                                    </label>
                                </div>
                                {{-- end::Volume --}}

                                {{-- begin::Non Volume --}}
                                <div class="form-check form-check-custom form-check-solid mb-4">
                                    <input class="form-check-input @error('status_volume') is-invalid @enderror" type="radio" value="0" name="status_volume" id="non_volume" @if ($data->RelMasterInstrumenJenisUttp->status_volume == '0') checked @endif disabled />
                                    <label class="form-check-label" for="non_volume">
                                        Non Volume
                                    </label>
                                </div>
                                {{-- end::Non Volume --}}
                                @error('status_volume')
                                    <div id="status_volumeFeedback" class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        {{-- end::status_volume --}}

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

                        {{-- begin::group_instrumen --}}
                        <div class="row form-group mb-5">
                            <div class="col-lg-3">
                                <label for="group_instrumen">Group Instrumen</label>
                            </div>
                            <div class="col-lg-9">
                                <input type="text" class="form-control @error('group_instrumen') is-invalid @enderror" name="group_instrumen" id="group_instrumen" placeholder="Group Instrumen" autocomplete="off" maxlength="100" value="{{ old('group_instrumen', $data->group_instrumen) }}" />
                                @error('group_instrumen')
                                    <div id="group_instrumenFeedback" class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        {{-- end::group_instrumen --}}

                        {{-- begin::nama_instrumen --}}
                        <div class="row form-group mb-5">
                            <div class="col-lg-3">
                                <label for="nama_instrumen" class="required">Nama Instrumen</label>
                            </div>
                            <div class="col-lg-9">
                                <input type="text" class="form-control @error('nama_instrumen') is-invalid @enderror" name="nama_instrumen" id="nama_instrumen" placeholder="Nama Instrumen" autocomplete="off" maxlength="100" value="{{ old('nama_instrumen', $data->nama_instrumen) }}"
                                    required />
                                @error('nama_instrumen')
                                    <div id="nama_instrumenFeedback" class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        {{-- end::nama_instrumen --}}

                        {{-- begin::detail_volume --}}
                        <div class="row form-group">
                            <div class="col-lg-3">
                                <label for="detail_volume" class="@if ($data->RelMasterInstrumenJenisUttp->status_volume == '1') required @endif">Volume</label>
                            </div>
                            <div class="col-lg-9">
                                <div class="row">
                                    <div class="col">
                                        {{-- begin::volume_from --}}
                                        <div class="form-floating mb-5">
                                            <input type="number" class="form-control @error('volume_from') is-invalid @enderror" name="volume_from" id="volume_from2" placeholder="Volume From" autocomplete="off" maxlength="100" value="{{ old('volume_from', $data->volume_from) }}" />
                                            <label for="volume_from">Volume From</label>
                                            @error('volume_from')
                                                <div id="volume_fromFeedback" class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        {{-- end::volume_from --}}
                                    </div>
                                    <div class="col">
                                        {{-- begin::volume_to --}}
                                        <div class="form-floating mb-5">
                                            <input type="number" class="form-control @error('volume_to') is-invalid @enderror" name="volume_to" id="volume_to2" placeholder="Volume To" autocomplete="off" maxlength="100" value="{{ old('volume_to', $data->volume_to) }}" />
                                            <label for="volume_to">Volume To</label>
                                            @error('volume_to')
                                                <div id="volume_toFeedback" class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        {{-- end::volume_to --}}
                                    </div>
                                    <div class="col">
                                        {{-- begin::volume_per --}}
                                        <div class="form-floating mb-5">
                                            <input type="number" class="form-control @error('volume_per') is-invalid @enderror" name="volume_per" id="volume_per2" placeholder="Volume Per" autocomplete="off" maxlength="100" value="{{ old('volume_per', $data->volume_per) }}" />
                                            <label for="volume_per">Volume Per</label>
                                            @error('volume_per')
                                                <div id="volume_perFeedback" class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        {{-- end::volume_per --}}
                                    </div>
                                    <div class="col">
                                        {{-- begin::satuan --}}
                                        <div class="form-floating mb-5">
                                            <input type="text" class="form-control @error('satuan') is-invalid @enderror" name="satuan" id="satuan2" placeholder="Satuan" autocomplete="off" maxlength="100" value="{{ old('satuan', $data->satuan) }}" />
                                            <label for="satuan">Satuan</label>
                                            @error('satuan')
                                                <div id="satuanFeedback" class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        {{-- end::satuan --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- end::detail_volume --}}

                        {{-- begin::tera_baru --}}
                        <div class="row form-group">
                            <div class="col-lg-3">
                                <label for="tera_baru" class="required">Tera Baru</label>
                            </div>
                            <div class="col-lg-9">
                                <div class="row">
                                    <div class="col">
                                        {{-- begin::tera_baru_pengujian --}}
                                        <div class="form-floating mb-5">
                                            <input type="number" class="form-control @error('tera_baru_pengujian') is-invalid @enderror" name="tera_baru_pengujian" id="tera_baru_pengujian2" placeholder="Pengujian" value="{{ old('tera_baru_pengujian', $data->tera_baru_pengujian) }}"
                                                min="0" required />
                                            <label for="tera_baru_pengujian">Pengujian</label>
                                            @error('tera_baru_pengujian')
                                                <div id="tera_baru_pengujianFeedback" class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        {{-- end::tera_baru_pengujian --}}
                                    </div>
                                    <div class="col">
                                        {{-- begin::tera_baru_pejustiran --}}
                                        <div class="form-floating mb-5">
                                            <input type="number" class="form-control @error('tera_baru_pejustiran') is-invalid @enderror" name="tera_baru_pejustiran" id="tera_baru_pejustiran2" placeholder="Pejustiran" value="{{ old('tera_baru_pejustiran', $data->tera_baru_pejustiran) }}"
                                                min="0" required />
                                            <label for="tera_baru_pejustiran">Pejustiran</label>
                                            @error('tera_baru_pejustiran')
                                                <div id="tera_baru_pejustiranFeedback" class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        {{-- end::tera_baru_pejustiran --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- end::tera_baru --}}

                        {{-- begin::tera_ulang --}}
                        <div class="row form-group">
                            <div class="col-lg-3">
                                <label for="tera_ulang" class="required">Tera Ulang</label>
                            </div>
                            <div class="col-lg-9">
                                <div class="row">
                                    <div class="col">
                                        {{-- begin::tera_ulang_pengujian --}}
                                        <div class="form-floating mb-5">
                                            <input type="number" class="form-control @error('tera_ulang_pengujian') is-invalid @enderror" name="tera_ulang_pengujian" id="tera_ulang_pengujian2" placeholder="Pengujian" value="{{ old('tera_ulang_pengujian', $data->tera_ulang_pengujian) }}"
                                                min="0" required />
                                            <label for="tera_ulang_pengujian">Pengujian</label>
                                            @error('tera_ulang_pengujian')
                                                <div id="tera_ulang_pengujianFeedback" class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        {{-- end::tera_ulang_pengujian --}}
                                    </div>
                                    <div class="col">
                                        {{-- begin::tera_ulang_pejustiran --}}
                                        <div class="form-floating mb-5">
                                            <input type="number" class="form-control @error('tera_ulang_pejustiran') is-invalid @enderror" name="tera_ulang_pejustiran" id="tera_ulang_pejustiran2" placeholder="Pejustiran" value="{{ old('tera_ulang_pejustiran', $data->tera_ulang_pejustiran) }}"
                                                min="0" required />
                                            <label for="tera_ulang_pejustiran">Pejustiran</label>
                                            @error('tera_ulang_pejustiran')
                                                <div id="tera_ulang_pejustiranFeedback" class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        {{-- end::tera_ulang_pejustiran --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- end::tera_ulang --}}

                        {{-- begin::tarif_per_jam --}}
                        <div class="row form-group mb-5">
                            <div class="col-lg-3">
                                <label for="tarif_per_jam" class="required">Tarif Per Jam</label>
                            </div>
                            <div class="col-lg-9">
                                <input type="number" class="form-control @error('tarif_per_jam') is-invalid @enderror" name="tarif_per_jam" id="tarif_per_jam" placeholder="Tarif Per Jam" autocomplete="off" value="{{ old('tarif_per_jam', $data->tarif_per_jam) }}" required />
                                @error('tarif_per_jam')
                                    <div id="tarif_per_jamFeedback" class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        {{-- end::tarif_per_jam --}}

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
