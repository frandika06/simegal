{{-- begin:::Tab pane --}}
<div class="tab-pane fade" id="profile_tab_path_profile" role="tabpanel">
    {{-- begin::Card --}}
    <div class="card pt-4 mb-6 mb-xl-9">
        {{-- begin::Card header --}}
        <div class="card-header border-0">
            {{-- begin::Card title --}}
            <div class="card-title flex-column">
                <h2>Data Profile</h2>
                <div class="fs-6 fw-semibold text-muted">Halaman untuk mengubah data profile pegawai.</div>
            </div>
            {{-- end::Card title --}}
        </div>
        {{-- end::Card header --}}
        {{-- begin::Card body --}}
        <div class="card-body">
            {{-- begin::Form --}}
            <form action="{{ route('set.apps.pegawai.update', [$enc_uuid]) }}" class="form" enctype="multipart/form-data" method="POST">
                @csrf
                @method('put')
                {{-- hidden --}}
                <input type="hidden" name="path_form" id="path_form" value="profile">

                {{-- begin::nama_lengkap --}}
                <div class="form-floating mb-5">
                    <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror" name="nama_lengkap" id="nama_lengkap2" placeholder="Nama Lengkap" autocomplete="off" maxlength="100" value="{{ old('nama_lengkap', $data->nama_lengkap) }}" required />
                    <label for="nama_lengkap">Nama Lengkap</label>
                    @error('nama_lengkap')
                        <div id="nama_lengkapFeedback" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                {{-- end::nama_lengkap --}}

                {{-- begin::nip --}}
                <div class="form-floating mb-5">
                    <input type="number" class="form-control @error('nip') is-invalid @enderror" name="nip" id="nip2" placeholder="NIP" autocomplete="off" maxlength="100" value="{{ old('nip', $data->nip) }}" required />
                    <label for="nip">NIP</label>
                    @error('nip')
                        <div id="nipFeedback" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                {{-- end::nip --}}

                {{-- begin::pangkat_golongan --}}
                <div class="form-floating mb-5">
                    <input type="text" class="form-control @error('pangkat_golongan') is-invalid @enderror" name="pangkat_golongan" id="pangkat_golongan2" placeholder="Pangkat/Golongan" autocomplete="off" maxlength="100" value="{{ old('pangkat_golongan', $data->pangkat_golongan) }}" required />
                    <label for="pangkat_golongan">Pangkat/Golongan</label>
                    @error('pangkat_golongan')
                        <div id="pangkat_golonganFeedback" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                {{-- end::pangkat_golongan --}}

                {{-- begin::jabatan --}}
                <div class="form-floating mb-5">
                    <input type="text" class="form-control @error('jabatan') is-invalid @enderror" name="jabatan" id="jabatan2" placeholder="Jabatan" autocomplete="off" maxlength="100" value="{{ old('jabatan', $data->jabatan) }}" required />
                    <label for="jabatan">Jabatan</label>
                    @error('jabatan')
                        <div id="jabatanFeedback" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                {{-- end::jabatan --}}

                {{-- begin::jenis_kelamin --}}
                <div class="form-floating mb-5">
                    <select class="form-control @error('jenis_kelamin') is-invalid @enderror" name="jenis_kelamin" id="jenis_kelamin" required>
                        <option value="" selected disabled>-Pilih Jenis Kelamin</option>
                        <option value="L" @if (old('jenis_kelamin', isset($data) ? $data->jenis_kelamin : '') == 'L') selected @endif>Laki-laki</option>
                        <option value="P" @if (old('jenis_kelamin', isset($data) ? $data->jenis_kelamin : '') == 'P') selected @endif>Perempuan</option>
                    </select>
                    <label for="jenis_kelamin">jenis_kelamin</label>
                    @error('jenis_kelamin')
                        <div id="jenis_kelaminFeedback" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                {{-- end::jenis_kelamin --}}

                {{-- begin::email --}}
                <div class="form-floating mb-5">
                    <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email2" placeholder="Email" autocomplete="off" maxlength="100" value="{{ old('email', $data->email) }}" required />
                    <label for="email">Email</label>
                    @error('email')
                        <div id="emailFeedback" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                {{-- end::email --}}

                {{-- begin::no_telp --}}
                <div class="form-floating mb-5">
                    <input type="number" class="form-control @error('no_telp') is-invalid @enderror" name="no_telp" id="no_telp2" placeholder="No. Telp/HP" autocomplete="off" maxlength="15" value="{{ old('no_telp', $data->no_telp) }}" required />
                    <label for="no_telp">No. Telp/HP</label>
                    @error('no_telp')
                        <div id="no_telpFeedback" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                {{-- end::no_telp --}}

                {{-- begin::foto --}}
                <div class="form-floating mb-5">
                    <input type="file" class="form-control @error('foto') is-invalid @enderror" name="foto" id="foto2" accept=".png,.jpg,.jpeg" />
                    <label for="foto">Foto</label>
                    <div class="form-text">File yang diizinkan: png, jpg, jpeg. | Maksimal: 1 MB</div>
                    @error('foto')
                        <div id="fotoFeedback" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    @if ($data->foto !== null && $data->foto != '')
                        <div class="d-flex justify-content-end align-items-center mt-2">
                            <a target="_BLANK" href="{{ \CID::urlImg($data->foto) }}" class="btn btn-sm btn-secondary btn-icon-info btn-text-info">
                                <i class="fas fa-search"></i>
                                Lihat File
                            </a>
                        </div>
                    @endif
                </div>
                {{-- end::foto --}}

                {{-- begin::Action buttons --}}
                <div class="d-flex justify-content-end align-items-center mt-12">
                    {{-- begin::Button --}}
                    <button type="submit" class="btn btn-info"><i class="fa-solid fa-save"></i>Simpan</button>
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
{{-- end:::Tab pane --}}

@push('scripts')
@endpush
