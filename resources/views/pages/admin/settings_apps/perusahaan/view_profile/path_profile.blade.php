{{-- begin:::Tab pane --}}
<div class="tab-pane fade" id="profile_tab_path_profile" role="tabpanel">
    {{-- begin::Card --}}
    <div class="card pt-4 mb-6 mb-xl-9">
        {{-- begin::Card header --}}
        <div class="card-header border-0">
            {{-- begin::Card title --}}
            <div class="card-title flex-column">
                <h2>Data Profile</h2>
                <div class="fs-6 fw-semibold text-muted">Halaman untuk mengubah data profile {{ $profile->jenis_perusahaan }}.</div>
            </div>
            {{-- end::Card title --}}
        </div>
        {{-- end::Card header --}}
        {{-- begin::Card body --}}
        <div class="card-body">
            {{-- begin::Form --}}
            {{-- begin::nama_perusahaan --}}
            <div class="form-floating mb-5">
                @if ($profile->jenis_perusahaan == 'Perusahaan')
                    <input type="text" class="form-control @error('nama_perusahaan') is-invalid @enderror" name="nama_perusahaan" id="nama_perusahaan2" placeholder="Nama Perusahaan" autocomplete="off" maxlength="100" value="{{ $profile->nama_perusahaan }}" readonly />
                    <label for="nama_perusahaan">Nama Perusahaan</label>
                @else
                    <input type="text" class="form-control @error('nama_perusahaan') is-invalid @enderror" name="nama_perusahaan" id="nama_perusahaan2" placeholder="Nama Pemilik UTTP" autocomplete="off" maxlength="100" value="{{ $profile->nama_perusahaan }}" readonly />
                    <label for="nama_perusahaan">Nama Pemilik UTTP</label>
                @endif
                @error('nama_perusahaan')
                    <div id="nama_perusahaanFeedback" class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            {{-- end::nama_perusahaan --}}

            {{-- begin::nama_pic --}}
            <div class="form-floating mb-5">
                <input type="text" class="form-control @error('nama_pic') is-invalid @enderror" name="nama_pic" id="nama_pic2" placeholder="Nama PIC" autocomplete="off" maxlength="100" value="{{ $profile->nama_pic }}" readonly />
                <label for="nama_pic">Nama PIC</label>
                @error('nama_pic')
                    <div id="nama_picFeedback" class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            {{-- end::nama_pic --}}

            {{-- begin::npwp --}}
            <div class="form-floating mb-5">
                @if ($profile->jenis_perusahaan == 'Perusahaan')
                    <input type="text" class="form-control npwp @error('npwp') is-invalid @enderror" name="npwp" id="npwp2" placeholder="NPWP Perusahaan" autocomplete="off" maxlength="100" value="{{ $profile->npwp }}" readonly />
                    <label for="npwp">NPWP Perusahaan</label>
                @else
                    <input type="text" class="form-control npwp @error('npwp') is-invalid @enderror" name="npwp" id="npwp2" placeholder="NPWP Pemilik UTTP" autocomplete="off" maxlength="100" value="{{ $profile->npwp }}" readonly />
                    <label for="npwp">NPWP Pemilik UTTP</label>
                @endif
                @error('npwp')
                    <div id="npwpFeedback" class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            {{-- end::npwp --}}

            {{-- begin::email --}}
            <div class="form-floating mb-5">
                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email2" placeholder="Email" autocomplete="off" maxlength="100" value="{{ $profile->email }}" readonly />
                <label for="email">Email</label>
                @error('email')
                    <div id="emailFeedback" class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            {{-- end::email --}}

            {{-- begin::no_telp_1 --}}
            <div class="form-floating mb-5">
                <input type="number" class="form-control @error('no_telp_1') is-invalid @enderror" name="no_telp_1" id="no_telp_12" placeholder="Kontak Telp. Pertama" autocomplete="off" maxlength="15" value="{{ $profile->no_telp_1 }}" readonly />
                <label for="no_telp_1">Kontak Telp. Pertama</label>
                @error('no_telp_1')
                    <div id="no_telp_1Feedback" class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            {{-- end::no_telp_1 --}}

            {{-- begin::no_telp_2 --}}
            <div class="form-floating mb-5">
                <input type="number" class="form-control @error('no_telp_2') is-invalid @enderror" name="no_telp_2" id="no_telp_22" placeholder="Kontak Telp. Kedua (Jika Ada)" autocomplete="off" maxlength="15" value="{{ $profile->no_telp_2 }}" readonly />
                <label for="no_telp_2">Kontak Telp. Kedua (Jika Ada)</label>
                @error('no_telp_2')
                    <div id="no_telp_2Feedback" class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            {{-- end::no_telp_2 --}}

            {{-- begin::foto --}}
            <div class="form-floating mb-5">
                @if ($profile->foto !== null && $profile->foto != '')
                    <div class="d-flex justify-content-end align-items-center mt-2">
                        <a target="_BLANK" href="{{ \CID::urlImg($profile->foto) }}" class="btn btn-sm btn-secondary btn-icon-info btn-text-info">
                            <i class="fas fa-search"></i>
                            Lihat Foto
                        </a>
                    </div>
                @endif
            </div>
            {{-- end::foto --}}

            {{-- begin::file_npwp --}}
            <div class="form-floating mb-5">
                @if ($profile->file_npwp !== null && $profile->file_npwp != '')
                    <div class="d-flex justify-content-end align-items-center mt-2">
                        <a target="_BLANK" href="{{ \CID::urlImg($profile->file_npwp) }}" class="btn btn-sm btn-secondary btn-icon-info btn-text-info">
                            <i class="fas fa-search"></i>
                            Lihat File NPWP
                        </a>
                    </div>
                @endif
            </div>
            {{-- end::file_npwp --}}
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
    <script>
        $(document).ready(function() {
            $('.npwp').mask("99.999.999.9-999.999", {
                placeholder: "99.999.999.9-999.999"
            });
        });
    </script>
@endpush