@extends('layouts.portal.base')
@push('apps')
    SIMEGAL
@endpush
@push('title')
    Search: {{ $UcKeys }} | SIMEGAL
@endpush
@push('description')
    Search: {{ $UcKeys }} | Sistem Informasi Metrologi Legal Pemerintah Kabupaten Tangerang
@endpush
@section('content')
    <div role="main" class="main">
        <section class="page-header page-header-modern page-header page-header-modern bg-color-primary page-header-md m-0">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 align-self-center p-static order-2 text-center">
                        <h1 class="text-light text-10"><strong>Pencarian</strong></h1>
                        <span class="sub-title text-light">Ditemukan 0 hasil: <strong>{{ $UcKeys }}</strong></span>
                    </div>
                    <div class="col-md-12 align-self-center order-1">
                        <ul class="breadcrumb d-block text-center breadcrumb-light">
                            <li><a href="{{ route('prt.home.index') }}">Beranda</a></li>
                            <li class="active">Pencarian</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <div class="container py-5 mt-3">

            <div class="row">
                <div class="col">
                    <h2 class="font-weight-normal text-7 mb-0">Hasil Pencarian: <strong class="font-weight-extra-bold">{{ $UcKeys }}</strong></h2>
                </div>
            </div>
            <div class="row">
                <div class="col pt-2 mt-1">
                    <hr class="my-4">
                </div>
            </div>
            <div class="row">
                <div class="col">

                    <ul class="simple-post-list m-0">
                        <li>
                            <div class="post-info">
                                <a href="blog-post.html">Nullam Vitae Nibh Un Odiosters</a>
                                <div class="post-meta">
                                    <span class="text-dark text-uppercase font-weight-semibold">Page</span> | Nov 10, 2023
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="post-info">
                                <a href="blog-post.html">Vitae Nibh Un Odiosters</a>
                                <div class="post-meta">
                                    <span class="text-dark text-uppercase font-weight-semibold">Post</span> | Nov 10, 2023
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="post-info">
                                <a href="blog-post.html">Odiosters Nullam Vitae</a>
                                <div class="post-meta">
                                    <span class="text-dark text-uppercase font-weight-semibold">Post</span> | Nov 10, 2023
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="post-info">
                                <a href="blog-post.html">Nullam Vitae Nibh Un Odiosters</a>
                                <div class="post-meta">
                                    <span class="text-dark text-uppercase font-weight-semibold">Page</span> | Nov 10, 2023
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="post-info">
                                <a href="blog-post.html">Vitae Nibh Un Odiosters</a>
                                <div class="post-meta">
                                    <span class="text-dark text-uppercase font-weight-semibold">Page</span> | Nov 10, 2023
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="post-info">
                                <a href="blog-post.html">Odiosters Nullam Vitae</a>
                                <div class="post-meta">
                                    <span class="text-dark text-uppercase font-weight-semibold">Page</span> | Nov 10, 2023
                                </div>
                            </div>
                        </li>
                    </ul>

                    <ul class="pagination float-end">
                        <li class="page-item"><a class="page-link" href="#"><i class="fas fa-angle-left"></i></a></li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#"><i class="fas fa-angle-right"></i></a></li>
                    </ul>

                </div>
            </div>
        </div>

        <section class="section section-default border-0 m-0">
            <div class="container py-4">
                <div class="row pb-4">
                    <div class="col">
                        <form action="{{ route('prt.q.index') }}" method="get">
                            <div class="input-group input-group-lg">
                                <input class="form-control h-auto" placeholder="Search..." name="q" id="q" type="text">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>

    </div>
@endsection
