@extends('layouts.portal.base')
@push('apps')
    SIMEGAL
@endpush
@push('title')
    Register | SIMEGAL
@endpush
@push('description')
    Register | Sistem Informasi Metrologi Legal Pemerintah Kabupaten Tangerang
@endpush
@section('content')
    <div role="main" class="main">
        <section class="page-header page-header-modern bg-color-primary page-header-md">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 order-2 order-md-1 align-self-center p-static">
                        <h1 class="">Register</h1>
                    </div>
                    <div class="col-md-4 order-1 order-md-2 align-self-center">
                        <ul class="breadcrumb d-block text-md-end breadcrumb-light">
                            <li><a href="{{ route('prt.home.index') }}">Beranda</a></li>
                            <li class="active">Register</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <div class="container py-4">
            <div class="row justify-content-center">
                <div class="col-6 mb-5 mb-5">
                    <h2 class="font-weight-bold text-5 mb-0">Register</h2>
                    <div class="row">
                        <div class="form-group col">
                            <p class="text-2 mb-4">Untuk menggunakan layanan Tera/Tera Ulang, silahkan perusahaan/pemilik UTTP mendaftarkan akun pada halaman ini.</a></p>
                        </div>
                    </div>
                    <form action="{{ route('prt.reg.post') }}" method="POST">
                        @csrf

                        {{-- data-perusahaan --}}
                        <div class="row mb-4">
                            <div class="form-group col">
                                <div class="card border-0 border-radius-0 card-border card-border-top bg-color-grey">
                                    <div class="card-body">
                                        <h4 class="card-title mb-1 text-4 font-weight-bold mb-3">Lengkapi Data</h4>

                                        <div class="row">
                                            <div class="form-group col">
                                                <label class="form-label text-color-dark text-3">Jenis Perusahaan <span class="text-color-danger">*</span></label>
                                                <select class="form-control form-control-lg text-4 @error('jenis_perusahaan') is-invalid @enderror" name="jenis_perusahaan" id="jenis_perusahaan" required>
                                                    <option value="" selected disabled>-Pilih Jenis Perusahaan</option>
                                                    <option value="Perusahaan" @if (old('jenis_perusahaan') == 'Perusahaan') selected @endif>Perusahaan</option>
                                                    <option value="Pemilik UTTP" @if (old('jenis_perusahaan') == 'Pemilik UTTP') selected @endif>Pemilik UTTP</option>
                                                </select>
                                                @error('jenis_perusahaan')
                                                    <div id="jenis_perusahaanFeedback" class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group col">
                                                <label class="form-label text-color-dark text-3"><span id="title_nama_perusahaan"></span> <span class="text-color-danger">*</span></label>
                                                <input type="text" class="form-control form-control-lg text-4 @error('nama_perusahaan') is-invalid @enderror" name="nama_perusahaan" id="nama_perusahaan" value="{{ old('nama_perusahaan') }}" placeholder="Masukkan Nama Perusahaan." maxlength="100"
                                                    autocomplete="off" required>
                                                @error('nama_perusahaan')
                                                    <div id="nama_perusahaanFeedback" class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group col">
                                                <label class="form-label text-color-dark text-3">Nama PIC <span class="text-color-danger">*</span></label>
                                                <input type="text" class="form-control form-control-lg text-4 @error('nama_pic') is-invalid @enderror" name="nama_pic" id="nama_pic" value="{{ old('nama_pic') }}" placeholder="Masukkan Nama PIC." maxlength="100" autocomplete="off" required>
                                                @error('nama_pic')
                                                    <div id="nama_picFeedback" class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group col">
                                                <label class="form-label text-color-dark text-3">NPWP <span id="title_npwp"></span> <span class="text-color-danger">*</span></label>
                                                <input type="text" class="form-control form-control-lg npwp text-4 @error('npwp') is-invalid @enderror" name="npwp" id="npwp" value="{{ old('npwp') }}" placeholder="Masukkan NPWP." maxlength="100" autocomplete="off" required>
                                                @error('npwp')
                                                    <div id="npwpFeedback" class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group col">
                                                <label class="form-label text-color-dark text-3">Email <span class="text-color-danger">*</span></label>
                                                <input type="email" class="form-control form-control-lg text-4 @error('email') is-invalid @enderror" name="email" id="email" value="{{ old('email') }}" placeholder="Masukkan Email." maxlength="100" autocomplete="off" required>
                                                @error('email')
                                                    <div id="emailFeedback" class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group col">
                                                <label class="form-label text-color-dark text-3">No. Telepon/HP/WA <span class="text-color-danger">*</span></label>
                                                <input type="number" class="form-control form-control-lg text-4 @error('no_telp_1') is-invalid @enderror" name="no_telp_1" id="no_telp_1" value="{{ old('no_telp_1') }}" placeholder="Masukkan Telepon/HP/WA." maxlength="15" autocomplete="off"
                                                    required>
                                                @error('no_telp_1')
                                                    <div id="no_telp_1Feedback" class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <h4 class="card-title mb-1 text-4 font-weight-bold mb-3 mt-4">Buat Akun Login</h4>

                                        <div class="row">
                                            <div class="form-group col">
                                                <label class="form-label text-color-dark text-3">Username <span class="text-color-danger">*</span></label>
                                                <input type="text" class="form-control form-control-lg text-4 @error('username') is-invalid @enderror" name="username" id="username" value="{{ old('username') }}" placeholder="Masukkan Username." maxlength="100" autocomplete="off" required>
                                                @error('username')
                                                    <div id="usernameFeedback" class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group col">
                                                <label class="form-label text-color-dark text-3">Password <span class="text-color-danger">*</span></label>
                                                <input type="password" class="form-control form-control-lg text-4 @error('password') is-invalid @enderror" name="password" id="password" placeholder="Masukkan Password." maxlength="100" required>
                                                @error('password')
                                                    <div id="passwordFeedback" class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mt-3">
                                            <div class="form-group col">
                                                <label>Tanda bintang <strong class="text-color-danger">(*)</strong> adalah field yang wajib diisi.</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- data-perusahaan --}}

                        <div class="row">
                            <div class="form-group col">
                                <button type="submit" class="btn btn-primary btn-modern w-100 text-uppercase rounded-0 font-weight-bold text-3 py-3">Register</button>
                            </div>
                            <div class="divider">
                                <span class="bg-light px-4 position-absolute left-50pct top-50pct transform3dxy-n50">atau</span>
                            </div>
                            <div class="form-group col">
                                <a href="{{ route('prt.lgn.index') }}" class="btn btn-default btn-modern w-100 text-uppercase rounded-0 font-weight-bold text-3 py-3">Login</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            jenisPemohon();
            $('.npwp').mask("99.999.999.9-999.999", {
                placeholder: "99.999.999.9-999.999"
            });
        });

        $("#jenis_perusahaan").change(function() {
            jenisPemohon();
        });

        function jenisPemohon() {
            var jenisPemohon = $("#jenis_perusahaan").val();
            if (jenisPemohon == "Pemilik UTTP") {
                $("#title_nama_perusahaan").html("Nama Pemilik UTTP");
                $("#title_npwp").html(" Pemilik UTTP");
                $("#nama_perusahaan").attr("placeholder", "Masukkan Nama Pemilik UTTP.");
                $("#npwp").attr("placeholder", "Masukkan NPWP Pemilik UTTP.");
            } else {
                $("#title_nama_perusahaan").html("Nama Perusahaan");
                $("#title_npwp").html(" Perusahaan");
                $("#nama_perusahaan").attr("placeholder", "Masukkan Nama Perusahaan.");
                $("#npwp").attr("placeholder", "Masukkan NPWP Perusahaan.");
            }
        }
    </script>
@endpush
