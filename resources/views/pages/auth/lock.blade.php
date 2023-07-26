@extends('layouts.auth.base')
@push('apps')
    Sistem JasPel
@endpush
@push('title')
    Layar Terkunci | Sistem JasPel
@endpush
@push('description')
    Sistem Informasi Jasa Pelayanan
@endpush
@section('wrapper')
    <div class="auth-page-wrapper pt-5">
        {{-- auth page bg --}}
        <div class="auth-one-bg-position auth-one-bg" id="auth-particles">
            <div class="bg-overlay"></div>
            <div class="shape">
                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1440 120">
                    <path d="M 0,36 C 144,53.6 432,123.2 720,124 C 1008,124.8 1296,56.8 1440,40L1440 140L0 140z">
                    </path>
                </svg>
            </div>
        </div>
        {{-- auth page content --}}
        <div class="auth-page-content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center mt-sm-5 mb-4 text-white-50">
                            <div>
                                <a href="{{ route('prt.lgn.index') }}" class="d-inline-block auth-logo">
                                    <img src="{{ asset('assets/images/custom/new_kapitasi_light.png') }}" alt="" height="80">
                                </a>
                            </div>
                            {{-- <p class="mt-3 fs-15 fw-semibold">&nbsp;</p> --}}
                        </div>
                    </div>
                </div>
                {{-- end row --}}
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card mt-4">
                            <div class="card-body p-4">
                                <div class="text-center mt-2">
                                    <h5 class="text-primary">Layar Terkunci</h5>
                                    <p class="text-muted">Masukkan Password Untuk Membuka Layar</p>
                                    {{-- <lord-icon src="https://cdn.lordicon.com/moscwhoj.json" trigger="loop" colors="primary:#0ab39c" class="avatar-xl"></lord-icon> --}}

                                    <lord-icon src="https://cdn.lordicon.com/ivhjpjsw.json" trigger="loop" colors="primary:#0ab39c" class="avatar-xl"></lord-icon>
                                </div>
                                {{-- <div class="user-thumb text-center">
                                    <img src="{{ \CID::pp() }}" class="rounded-circle img-thumbnail avatar-lg" alt="thumbnail">
                                    <h5 class="font-size-15 mt-3">{{ \Auth::user()->RelAdministrator->nama_lengkap }}</h5>
                                </div> --}}
                                <div class="p-2 mt-2">
                                    <form action="{{ route('prt.lock.post') }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            {{-- <div class="float-end">
                                                <a href="{{ route('prt.rst.index') }}" class="text-muted">Lupa password?</a>
                                            </div> --}}
                                            <label class="form-label" for="password-input">Password</label>
                                            <div class="position-relative auth-pass-inputgroup mb-3">
                                                <input type="password" class="form-control pe-5 password-input" name="password" id="password-input" placeholder="Masukkan password" autocomplete="off" autofocus="on" maxlength="100" required>
                                                <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                                            </div>
                                        </div>
                                        <div class="mt-4">
                                            <button class="btn btn-success w-100" type="submit"><i class="ri-lock-2-line"></i> Buka Kunci</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            {{-- end card body --}}
                        </div>
                        {{-- end card --}}
                        <div class="mt-4 text-center">
                            <p class="mb-0">Lupa Password? <a href="{{ route('prt.lgn.logout') }}" class="fw-bold text-primary text-decoration-underline"> Logout</a></p>
                        </div>
                    </div>
                </div>
                {{-- end row --}}
            </div>
            {{-- end container --}}
        </div>
        {{-- end auth page content --}}
        {{-- footer --}}
        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center">
                            <p class="mb-0 text-muted">Hak Cipta &copy; {{ date('Y') }} . Sistem JasPel . BPKAD Kabupaten Tangerang</p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        {{-- end Footer --}}
    </div>
@endsection
