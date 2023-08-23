@extends('layouts.admin.portal')
@push('apps')
    SIMEGAL
@endpush
@push('title')
    Master Setup Portal | SIMEGAL
@endpush
@push('description')
    Master Setup Portal | Sistem Informasi Metrologi Legal Pemerintah Kabupaten Tangerang
@endpush
@push('header-title')
    Master Setup Portal
@endpush
@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row">
                <form action="{{ route('prt.apps.mst.setup.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @isset($data)
                        @method('put')
                    @endisset
                    <div class="col-xl-12 mb-4">
                        <div class="card">
                            <div class="card-header p-3">
                                <h4 class="heading mb-0">Update Data Master Setup Portal</h4>
                            </div>
                            <div class="card-body">
                                <div class="basic-form">
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">Google Maps <span class="wajib">*</span></label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control @error('google_maps') is-invalid @enderror" name="google_maps" id="google_maps" value="{{ old('google_maps', isset($data) ? $data->google_maps : '') }}" placeholder="Masukkan Google Maps." maxlength="300"
                                                autocomplete="off" required>
                                            @error('google_maps')
                                                <div id="google_mapsFeedback" class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">Alamat <span class="wajib">*</span></label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control @error('alamat') is-invalid @enderror" name="alamat" id="alamat" value="{{ old('alamat', isset($data) ? $data->alamat : '') }}" placeholder="Masukkan Alamat." maxlength="300" autocomplete="off" required>
                                            @error('alamat')
                                                <div id="alamatFeedback" class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">No. Telp <span class="wajib">*</span></label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control @error('no_telp') is-invalid @enderror" name="no_telp" id="no_telp" value="{{ old('no_telp', isset($data) ? $data->no_telp : '') }}" placeholder="Masukkan No. Telp." maxlength="100" autocomplete="off" required>
                                            @error('no_telp')
                                                <div id="no_telpFeedback" class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">Email <span class="wajib">*</span></label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" id="email" value="{{ old('email', isset($data) ? $data->email : '') }}" placeholder="Masukkan Email." maxlength="100" autocomplete="off" required>
                                            @error('email')
                                                <div id="emailFeedback" class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">Link Survey <span class="wajib">*</span></label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control @error('link_survey') is-invalid @enderror" name="link_survey" id="link_survey" value="{{ old('link_survey', isset($data) ? $data->link_survey : '') }}" placeholder="Masukkan Link Survey." maxlength="300"
                                                autocomplete="off" required>
                                            @error('link_survey')
                                                <div id="link_surveyFeedback" class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-5 row">
                        <div class="col-sm-12 text-end">
                            <button type="submit" class="btn btn-primary btn-rounded"><i class="fa-solid fa-save"></i> Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
@endpush
