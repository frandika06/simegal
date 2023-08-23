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
                <form action="{{ route('prt.apps.auth.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @isset($data)
                        @method('put')
                    @endisset
                    <div class="col-xl-12 mb-4">
                        <div class="card">
                            <div class="card-header p-3">
                                <h4 class="heading mb-0">Update Data Profile</h4>
                            </div>
                            <div class="card-body">
                                <div class="basic-form">
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">Nama Lengkap <span class="wajib">*</span></label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror" name="nama_lengkap" id="nama_lengkap" value="{{ old('nama_lengkap', isset($data) ? $data->RelPegawai->nama_lengkap : '') }}" placeholder="Masukkan Nama Lengkap."
                                                maxlength="100" autocomplete="off" required>
                                            @error('nama_lengkap')
                                                <div id="nama_lengkapFeedback" class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">NIP</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control @error('nip') is-invalid @enderror" name="nip" id="nip" value="{{ old('nip', isset($data) ? $data->RelPegawai->nip : '') }}" placeholder="Masukkan NIP." maxlength="100" autocomplete="off">
                                            @error('nip')
                                                <div id="nipFeedback" class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">Pangkat/Golongan</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control @error('pangkat_golongan') is-invalid @enderror" name="pangkat_golongan" id="pangkat_golongan" value="{{ old('pangkat_golongan', isset($data) ? $data->RelPegawai->pangkat_golongan : '') }}"
                                                placeholder="Masukkan Pangkat/Golongan." maxlength="100" autocomplete="off">
                                            @error('pangkat_golongan')
                                                <div id="pangkat_golonganFeedback" class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">Jabatan <span class="wajib">*</span></label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control @error('jabatan') is-invalid @enderror" name="jabatan" id="jabatan" value="{{ old('jabatan', isset($data) ? $data->RelPegawai->jabatan : '') }}" placeholder="Masukkan Jabatan." maxlength="100" autocomplete="off"
                                                required>
                                            @error('jabatan')
                                                <div id="jabatanFeedback" class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">Jenis Kelamin <span class="wajib">*</span></label>
                                        <div class="col-sm-9">
                                            <select class="form-control" name="jenis_kelamin" id="jenis_kelamin" required>
                                                <option @if (old('jenis_kelamin', isset($data) ? $data->RelPegawai->jenis_kelamin : '') == 'L') selected @endif value="L">Laki-laki</option>
                                                <option @if (old('jenis_kelamin', isset($data) ? $data->RelPegawai->jenis_kelamin : '') == 'P') selected @endif value="P">Perempuan</option>
                                            </select>
                                            @error('jenis_kelamin')
                                                <div id="jenis_kelaminFeedback" class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">Email <span class="wajib">*</span></label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" id="email" value="{{ old('email', isset($data) ? $data->RelPegawai->email : '') }}" placeholder="Masukkan Email." maxlength="100" autocomplete="off" required>
                                            @error('email')
                                                <div id="emailFeedback" class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">No. HP/Telp <span class="wajib">*</span></label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control @error('no_telp') is-invalid @enderror" name="no_telp" id="no_telp" value="{{ old('no_telp', isset($data) ? $data->RelPegawai->no_telp : '') }}" placeholder="Masukkan No. HP/Telp." maxlength="100"
                                                autocomplete="off" required>
                                            @error('no_telp')
                                                <div id="no_telpFeedback" class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">Foto</label>
                                        <div class="col-sm-9">
                                            <input type="file" class="form-control @error('foto') is-invalid @enderror" name="foto" id="foto" accept=".png,.jpg,.jpeg">
                                            <p class="text-danger">Ukuran File Maksimal 1MB.</p>
                                            @error('foto')
                                                <div id="fotoFeedback" class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            @if ($data->RelPegawai->foto != '')
                                                {{-- ada file --}}
                                                <div class="text-end">
                                                    <a href="{{ \CID::urlImg($data->RelPegawai->foto) }}" target="_BLANK" class="btn btn-sm btn-primary mt-2"><i class="fa fa-image"></i> Lihat File</a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- update akun login --}}
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-header p-3">
                                <h4 class="heading mb-0">Update Akun Login</h4>
                            </div>
                            <div class="card-body">
                                <div class="basic-form">
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">Username <span class="wajib">*</span></label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control @error('username') is-invalid @enderror" name="username" id="username" value="{{ old('username', isset($data) ? $data->username : '') }}" placeholder="Masukkan Username." maxlength="100" autocomplete="off"
                                                required>
                                            @error('username')
                                                <div id="usernameFeedback" class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">Password</label>
                                        <div class="col-sm-9">
                                            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password" value="{{ old('password') }}" placeholder="Masukkan Password." maxlength="100" autocomplete="off">
                                            <p class="text-danger">Masukkan Password Baru Jika Ingin Diganti!</p>
                                            @error('password')
                                                <div id="passwordFeedback" class="invalid-feedback">{{ $message }}</div>
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
