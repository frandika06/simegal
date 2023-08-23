@extends('layouts.portal.base')
@push('apps')
    SIMEGAL
@endpush
@push('title')
    Login | SIMEGAL
@endpush
@push('description')
    Login | Sistem Informasi Metrologi Legal Pemerintah Kabupaten Tangerang
@endpush
@section('content')
    <div role="main" class="main">
        <section class="page-header page-header-modern bg-color-primary page-header-md">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 order-2 order-md-1 align-self-center p-static">
                        <h1 class="">Login</h1>
                    </div>
                    <div class="col-md-4 order-1 order-md-2 align-self-center">
                        <ul class="breadcrumb d-block text-md-end breadcrumb-light">
                            <li><a href="{{ route('prt.home.index') }}">Beranda</a></li>
                            <li class="active">Login</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <div class="container py-4">
            <div class="row justify-content-center">
                <div class="col-6 mb-5 mb-5">
                    <h2 class="font-weight-bold text-5 mb-0">Login</h2>
                    <form action="{{ route('prt.lgn.post') }}" method="POST">
                        @csrf
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
                        <div class="row justify-content-between">
                            <div class="form-group col-md-auto">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="remember_me" id="remember_me">
                                    <label class="form-label custom-control-label cur-pointer text-2" for="remember_me">Remember Me</label>
                                </div>
                            </div>
                            <div class="form-group col-md-auto">
                                <a class="text-decoration-none text-color-dark text-color-hover-primary font-weight-semibold text-2" href="#">Lupa Password?</a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col">
                                <button type="submit" class="btn btn-primary btn-modern w-100 text-uppercase rounded-0 font-weight-bold text-3 py-3">Login</button>
                            </div>
                            <div class="divider">
                                <span class="bg-light px-4 position-absolute left-50pct top-50pct transform3dxy-n50">atau</span>
                            </div>
                            <div class="form-group col">
                                <a href="#" class="btn btn-success btn-modern w-100 text-uppercase rounded-0 font-weight-bold text-3 py-3">Register</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection
