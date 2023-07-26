@extends('layouts.portal.base')
@push('apps')
    SIMEGAL
@endpush
@push('title')
    {{ $UcSlug }} | SIMEGAL
@endpush
@push('description')
    {{ $UcSlug }} | Sistem Informasi Metrologi Legal Pemerintah Kabupaten Tangerang
@endpush
@section('content')
    <div role="main" class="main">
        <section class="page-header page-header-modern bg-color-primary page-header-md">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 order-2 order-md-1 align-self-center p-static">
                        <h1 class="">{{ $UcSlug }}</h1>
                    </div>
                    <div class="col-md-4 order-1 order-md-2 align-self-center">
                        <ul class="breadcrumb d-block text-md-end breadcrumb-light">
                            <li><a href="{{ route('prt.home.index') }}">Beranda</a></li>
                            <li class="active">{{ $UcSlug }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <div class="container">
            <div class="row pt-5">
                <div class="col">
                    <div class="row text-center pb-5">
                        <div class="col-md-9 mx-md-auto">
                            <div class="overflow-hidden mb-3">
                                <h1 class="word-rotator slide font-weight-bold text-8 mb-0 appear-animation" data-appear-animation="maskUp">
                                    <span>Selamat Datang di SIMEGAL</span>
                                </h1>
                            </div>
                            <div class="overflow-hidden mb-3">
                                <p class="lead mb-0 appear-animation" data-appear-animation="maskUp" data-appear-animation-delay="200">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce elementum, nulla vel pellentesque consequat, ante nulla hendrerit arcu, ac tincidunt mauris lacus sed leo.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3 mb-5">
                        <div class="col-md-6 appear-animation" data-appear-animation="fadeInLeftShorter" data-appear-animation-delay="800">
                            <h3 class="font-weight-bold text-4 mb-2">Misi Kami</h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce elementum, nulla vel pellentesque consequat, ante nulla hendrerit arcu.</p>
                        </div>
                        <div class="col-md-6 appear-animation" data-appear-animation="fadeIn" data-appear-animation-delay="600">
                            <h3 class="font-weight-bold text-4 mb-2">Visi Kami</h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce nulla vel pellentesque consequat, ante nulla hendrerit arcu.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <section class="section section-primary border-0 mb-0 appear-animation" data-appear-animation="fadeIn" data-plugin-options="{'accY': -150}">
            <div class="container">
                <div class="row counters counters-sm pb-4 pt-3">
                    <div class="col-sm-12 col-lg-4 mb-5 mb-lg-0">
                        <div class="counter">
                            <i class="icons fa-solid fa-microscope text-color-light"></i>
                            <strong class="text-color-light font-weight-extra-bold" data-to="300">0</strong>
                            <label class="text-4 mt-1 text-color-light">Tera</label>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-4 mb-5 mb-lg-0">
                        <div class="counter">
                            <i class="icons fa-solid fa-repeat text-color-light"></i>
                            <strong class="text-color-light font-weight-extra-bold" data-to="20">0</strong>
                            <label class="text-4 mt-1 text-color-light">Tera Ulang</label>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-4">
                        <div class="counter">
                            <i class="icons fa-solid fa-gifts text-color-light"></i>
                            <strong class="text-color-light font-weight-extra-bold" data-to="100">0</strong>
                            <label class="text-4 mt-1 text-color-light">Pengujian BDKT</label>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="container appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="300">
            <div class="row pt-5 pb-4 my-5">
                <div class="col-md-6 order-2 order-md-1 text-center text-md-start">
                    <div class="owl-carousel owl-theme nav-style-1 nav-center-images-only stage-margin mb-0" id="ourTim">
                        @foreach ($dataUsers as $item)
                            @php
                                $namaTim = $item->firstName . ' ' . $item->maidenName . ' ' . $item->lastName;
                            @endphp
                            <div>
                                <img class="img-fluid rounded-0 mb-4" src="{{ $item->image }}" alt="{{ $namaTim }}" />
                                <h3 class="font-weight-bold text-color-dark text-4 mb-0">{{ $namaTim }}</h3>
                                <p class="text-2 mb-0">{{ $item->company->title }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-md-6 order-1 order-md-2 text-center text-md-start mb-5 mb-md-0">
                    <h2 class="text-color-dark font-weight-normal text-6 mb-2 pb-1">Data <strong class="font-weight-extra-bold">Tim Kami</strong></h2>
                    <p class="lead">Kami memiliki tim yang sudah berpengalam dalam melakukan peneraaan.</p>
                    {{-- <p class="mb-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit massa enim. Nullam id varius nunc. Vivamus bibendum magna ex, et faucibus lacus venenatis eget.</p> --}}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $('#ourTim').owlCarousel({
            margin: 25,
            loop: true,
            lazyLoad: true,
            animateOut: 'fadeOut',
            stagePadding: 40,
            nav: false,
            dots: true,
            responsive: {
                576: {
                    items: 1
                },
                768: {
                    items: 1
                },
                992: {
                    items: 2
                },
                1200: {
                    items: 2
                }
            }
        });
    </script>
@endpush
