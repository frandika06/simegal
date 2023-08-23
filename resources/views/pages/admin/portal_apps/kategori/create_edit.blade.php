@extends('layouts.admin.portal')
@push('apps')
    SIMEGAL
@endpush
@push('title')
    Master Kategori | SIMEGAL
@endpush
@push('description')
    Master Kategori | Sistem Informasi Metrologi Legal Pemerintah Kabupaten Tangerang
@endpush
@push('header-title')
    Master Kategori
@endpush
@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header p-3">
                            <h4 class="heading mb-0">{{ $title }}</h4>
                        </div>
                        <div class="card-body">
                            <div class="basic-form">
                                <form action="{{ isset($data) ? route('prt.apps.mst.tags.update', [$uuid_enc]) : route('prt.apps.mst.tags.store') }}" method="POST">
                                    @csrf
                                    @isset($data)
                                        @method('put')
                                    @endisset
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">Nama Kategori <span class="wajib">*</span></label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" id="nama" value="{{ old('nama', isset($data) ? $data->nama : '') }}" placeholder="Masukkan Nama Kategori." maxlength="100" autocomplete="off" required>
                                            @error('nama')
                                                <div id="namaFeedback" class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    @if (isset($data))
                                        <fieldset class="mb-5">
                                            <div class="row">
                                                <label class="col-form-label col-sm-3 pt-0">Jenis <span class="wajib">*</span></label>
                                                <div class="col-sm-9">
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="radio" name="jenis" id="jenis" value="Postingan" @if ($data->jenis == 'Postingan') checked @endif>
                                                        <label class="form-check-label ms-2">
                                                            Postingan
                                                        </label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="radio" name="jenis" id="jenis" value="Unduhan" @if ($data->jenis == 'Unduhan') checked @endif>
                                                        <label class="form-check-label ms-2">
                                                            Unduhan
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>
                                    @else
                                        <fieldset class="mb-5">
                                            <div class="row">
                                                <label class="col-form-label col-sm-3 pt-0">Jenis</label>
                                                <div class="col-sm-9">
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="radio" name="jenis" id="jenis" value="Postingan" checked>
                                                        <label class="form-check-label ms-2">
                                                            Postingan
                                                        </label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="radio" name="jenis" id="jenis" value="Unduhan">
                                                        <label class="form-check-label ms-2">
                                                            Unduhan
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>
                                    @endif
                                    <div class="mb-3 row">
                                        <div class="col-sm-12 text-end">
                                            <a href="{{ route('prt.apps.mst.tags.index') }}" class="btn btn-light btn-rounded me-2"><i class="fa fa-times"></i> Batal</a>
                                            <button type="submit" class="btn btn-primary btn-rounded"><i class="fa-solid fa-save"></i> {{ $submit }}</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
@endpush
