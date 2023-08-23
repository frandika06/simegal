@extends('layouts.portal.base')
@push('apps')
    SIMEGAL
@endpush
@push('title')
    Home | SIMEGAL
@endpush
@push('description')
    Sistem Informasi Metrologi Legal Pemerintah Kabupaten Tangerang
@endpush
@section('content')
    <div role="main" class="main">
        <div class="owl-carousel owl-carousel-light owl-carousel-light-init-fadeIn owl-theme manual dots-inside dots-horizontal-center show-dots-hover show-dots-xs nav-style-1 nav-inside nav-inside-plus nav-dark nav-lg nav-font-size-lg show-nav-hover mb-0" data-plugin-options="{'autoplayTimeout': 7000}"
            data-dynamic-height="['700px','700px','700px','550px','500px']" style="height: 700px;">
            <div class="owl-stage-outer">
                <div class="owl-stage">
                    {{-- Carousel Slide 1 --}}
                    <div class="owl-item position-relative" style="background-image: url({{ asset('assets-portal/dist/img/parallax/parallax-04.png') }}); background-size: cover; background-position: center;">
                        <div class="container position-relative z-index-1 h-100">
                            <div class="row justify-content-center align-items-center h-100">
                                <div class="col-lg-7">
                                    <div class="d-flex flex-column align-items-center">
                                        <h2 class="text-color-dark font-weight-extra-bold text-10 text-md-12-13 line-height-1 text-center mb-2 appear-animation" data-appear-animation="blurIn" data-appear-animation-delay="500" data-plugin-options="{'minWindowWidth': 0}">SELAMAT DATANG
                                        </h2>
                                        <p class="text-4-5 text-color-dark font-weight-light text-center mb-4" data-plugin-animated-letters data-plugin-options="{'startDelay': 1000, 'minWindowWidth': 0, 'animationSpeed': 30}">Di Website Pelayanan Tera / Tera Ulang dan Pengujian BDKT</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @foreach ($images1 as $item)
                        <div class="owl-item position-relative" style="background-image: url({{ $item->url }}); background-size: cover; background-position: center;">
                            <div class="container position-relative z-index-1 h-100">
                                <div class="row justify-content-center align-items-center h-100">
                                    <div class="col-lg-7">
                                        <div class="d-flex flex-column align-items-center">
                                            <h2 class="text-color-white font-weight-extra-bold text-10 text-md-12-13 line-height-1 text-center mb-2 appear-animation" data-appear-animation="blurIn" data-appear-animation-delay="500" data-plugin-options="{'minWindowWidth': 0}">{{ $item->title }}</h2>
                                            <p class="text-4-5 text-color-white font-weight-light text-center mb-4" data-plugin-animated-letters data-plugin-options="{'startDelay': 1000, 'minWindowWidth': 0, 'animationSpeed': 30}">{{ $item->description }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="owl-nav">
                <button type="button" role="presentation" class="owl-prev" aria-label="Previous"></button>
                <button type="button" role="presentation" class="owl-next" aria-label="Next"></button>
            </div>
        </div>

        <div class="container py-4 my-5">
            <div class="row justify-content-center text-center mb-4 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="400">
                <div class="col-lg-8">
                    <h2 class="font-weight-bold mb-3 mt-3">Layanan SIMEGAL</h2>
                    {{-- <p class="text-6 text-color-dark line-height-7 negative-ls-1 px-5">Sistem Informasi Metrologi Legal</p> --}}
                </div>
            </div>
            <div class="row featured-boxes featured-boxes-style-4">
                <div class="col-md-12 col-lg-6">
                    <div class="featured-box featured-box-primary featured-box-effect-4 appear-animation" data-appear-animation="fadeInLeftShorter" data-appear-animation-delay="200">
                        <div class="box-content px-4">
                            <i class="icon-featured fa-solid fa-mobile-screen-button icons text-12"></i>
                            <h4 class="font-weight-bold text-color-dark pb-1 mb-2">Mobile Apps</h4>
                            <p class="mb-0">SIMEGAL Sudah Support Android</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-6">
                    <div class="featured-box featured-box-primary featured-box-effect-4 appear-animation" data-appear-animation="fadeIn">
                        <div class="box-content px-4">
                            <a href="{{ route('prt.lgn.index') }}">
                                <i class="icon-featured fa-solid fa-microscope icons text-12"></i>
                                <h4 class="font-weight-bold text-color-dark pb-1 mb-2">Tera/Tera Ulang</h4>
                            </a>
                            <p class="mb-0">Pengajuan Permohonan Tera Baru dan Tera Ulang</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <section class="section section-no-background section-height-4 border-0 pb-5 mb-5 appear-animation" data-appear-animation="fadeIn">
            <div class="container">
                <div class="row justify-content-center text-center mb-4 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="400">
                    <div class="col-lg-12">
                        <h2 class="font-weight-bold mb-3">Postingan Terbaru</h2>
                    </div>
                </div>
                <div class="row justify-content-center recent-posts appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="200">
                    @foreach ($posts->blogs as $item)
                        <div class="col-sm-8 col-md-4 mb-4 mb-md-0">
                            <article>
                                <div class="row">
                                    <div class="col">
                                        <a href="{{ route('prt.post.read', ['berita', $item->id]) }}" class="text-decoration-none">
                                            <img src="{{ $item->photo_url }}" class="img-fluid hover-effect-2 mb-3" alt="" />
                                        </a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <p class="text-color-primary text-2 mb-1">{{ \Str::upper($item->category) }}</p>
                                        <h4 class="line-height-5 ls-0"><a href="{{ route('prt.post.read', ['berita', $item->id]) }}" class="text-dark text-decoration-none">{{ $item->title }}</a></h4>
                                        <p class="text-color-dark opacity-7 mb-3">{{ $item->description }}</p>
                                        <a href="{{ route('prt.post.read', ['berita', $item->id]) }}" class="read-more text-color-primary font-weight-semibold text-2">VIEW MORE <i class="fas fa-chevron-right text-3 ms-2"></i></a>
                                    </div>
                                </div>
                            </article>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

    </div>
@endsection
