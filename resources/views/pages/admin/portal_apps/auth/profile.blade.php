@extends('layouts.admin.portal')
@push('apps')
    SIMEGAL
@endpush
@push('title')
    Profile | SIMEGAL
@endpush
@push('description')
    Profile | Sistem Informasi Metrologi Legal Pemerintah Kabupaten Tangerang
@endpush
@push('header-title')
    Profile
@endpush
@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header p-3">
                            <h4 class="heading mb-0">Update Data Profile</h4>
                        </div>
                        <div class="card-body">
                            <div class="basic-form">
                                <form action="{{ route('prt.apps.auth.profile.update') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @isset($data)
                                        @method('put')
                                    @endisset
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">Nama Lengkap <span class="wajib">*</span></label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror" name="nama_lengkap" id="nama_lengkap" value="{{ old('nama_lengkap', isset($data) ? $data->RelPegawai->nama_lengkap : '') }}" placeholder="Masukkan Nama Lengkap." maxlength="100"
                                                autocomplete="off" required>
                                            @error('nama_lengkap')
                                                <div id="nama_lengkapFeedback" class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">NIP</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control @error('nip') is-invalid @enderror" name="nip" id="nip" value="{{ old('nip', isset($data) ? $data->RelPegawai->nip : '') }}" placeholder="Masukkan Nama Lengkap." maxlength="100"
                                                autocomplete="off">
                                            @error('nip')
                                                <div id="nipFeedback" class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">Pangkat/Golongan</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control @error('pangkat_golongan') is-invalid @enderror" name="pangkat_golongan" id="pangkat_golongan" value="{{ old('pangkat_golongan', isset($data) ? $data->RelPegawai->pangkat_golongan : '') }}" placeholder="Masukkan Nama Lengkap." maxlength="100"
                                                autocomplete="off">
                                            @error('pangkat_golongan')
                                                <div id="pangkat_golonganFeedback" class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <div class="col-sm-12 text-end">
                                            <button type="submit" class="btn btn-primary btn-rounded"><i class="fa-solid fa-save"></i> Update</button>
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
