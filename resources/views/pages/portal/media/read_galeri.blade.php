@extends('layouts.portal.base')
@push('apps')
    SIMEGAL
@endpush
@push('title')
    {{ $data->title }} | {{ $UcTags }} | SIMEGAL
@endpush
@push('description')
    {{ $data->title }} | {{ $UcTags }} | Sistem Informasi Metrologi Legal Pemerintah Kabupaten Tangerang
@endpush
@section('content')
    <div role="main" class="main">
        <section class="page-header page-header-modern bg-color-primary page-header-md">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 order-2 order-md-1 align-self-center p-static">
                        <h1 class="">{{ $data->title }}</h1>
                    </div>
                    <div class="col-md-4 order-1 order-md-2 align-self-center">
                        <ul class="breadcrumb d-block text-md-end breadcrumb-light">
                            <li><a href="{{ route('prt.home.index') }}">Beranda</a></li>
                            <li class="active">{{ $UcTags }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <div class="container py-4">
            <div class="row">
                <div class="col" style="min-height: 250px;">
                    <div class="row portfolio-list lightbox" data-plugin-options="{'delegate': 'a.lightbox-portfolio', 'type': 'image', 'gallery': {'enabled': true}}">
                        @foreach ($images1 as $item)
                            <div class="col-12 col-sm-6 col-lg-3 appear-animation" data-appear-animation="expandIn" data-appear-animation-delay="200">
                                <div class="portfolio-item">
                                    <span class="thumb-info thumb-info-lighten thumb-info-centered-icons border-radius-0">
                                        <span class="thumb-info-wrapper border-radius-0">
                                            <img src="{{ $item->url }}" class="img-fluid border-radius-0" alt="">
                                            <span class="thumb-info-action">
                                                <a href="{{ $item->url }}" class="lightbox-portfolio">
                                                    <span class="thumb-info-action-icon thumb-info-action-icon-light"><i class="fas fa-search text-dark"></i></span>
                                                </a>
                                            </span>
                                        </span>
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="row pt-4 mt-2 mb-5">
                <div class="col-md-7 mb-4 mb-md-0">
                    <div class="overflow-hidden mb-2">
                        <h2 class="text-color-dark font-weight-normal text-5 mb-0 appear-animation" data-appear-animation="maskUp" data-appear-animation-delay="800">Deskripsi <strong class="font-weight-extra-bold">Galeri</strong></h2>
                    </div>
                    <p class="appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="1000">{{ $data->description }}</p>
                </div>
                <div class="col-md-5 appear-animation" data-appear-animation="fadeIn" data-appear-animation-delay="1400">
                    <h2 class="text-color-dark font-weight-normal text-5 mb-2">Detail <strong class="font-weight-extra-bold">Galeri</strong></h2>
                    <ul class="list list-icons list-primary list-borders text-2">
                        <li><i class="fas fa-caret-right left-10"></i> <strong class="text-color-primary">Diposting Oleh:</strong> Jhon Doe</li>
                        <li><i class="fas fa-caret-right left-10"></i> <strong class="text-color-primary">Tanggal:</strong> {{ \CID::tglSimple($data->created_at) }}</li>
                        <li><i class="fas fa-caret-right left-10"></i> <strong class="text-color-primary">Jumlah Views:</strong> {{ \CID::toDot(rand(0, 5000)) }}</li>
                    </ul>
                </div>
            </div>
        </div>

    </div>
@endsection
