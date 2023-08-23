@extends('layouts.portal.base')
@push('apps')
    SIMEGAL
@endpush
@push('judul')
    {{ $data->judul }} | {{ $UcTags }} | SIMEGAL
@endpush
@push('description')
    {{ $data->judul }} | {{ $UcTags }} | Sistem Informasi Metrologi Legal Pemerintah Kabupaten Tangerang
@endpush
@section('content')
    <div role="main" class="main">
        <section class="page-header page-header-modern bg-color-primary page-header-md">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 order-2 order-md-1 align-self-center p-static">
                        <h1 class="">{{ $data->judul }}</h1>
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
            <div class="row pt-4 mt-2 mb-5">
                <div class="col-md-7 mb-4 mb-md-0">
                    <div class="overflow-hidden mb-2">
                        <h2 class="text-color-dark font-weight-normal text-5 mb-0 appear-animation" data-appear-animation="maskUp" data-appear-animation-delay="800">Deskripsi <strong class="font-weight-extra-bold">Unduhan</strong></h2>
                    </div>
                    <p class="appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="1000">{!! $data->deskripsi !!}</p>
                    @if ($data->tipe == 'pdf')
                        <div class="row">
                            <div class="col mb-5">
                                <iframe src="{{ \CID::urlImg($data->url) }}#toolbar=0" frameborder="0" width="100%" height="560px"></iframe>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="col-md-5 appear-animation" data-appear-animation="fadeIn" data-appear-animation-delay="1400">
                    <h2 class="text-color-dark font-weight-normal text-5 mb-2">Detail <strong class="font-weight-extra-bold">Unduhan</strong></h2>
                    <ul class="list list-icons list-primary list-borders text-2">
                        <li><i class="fas fa-caret-right left-10"></i> <strong class="text-color-primary">Diposting Oleh:</strong> {{ $data->Publisher->nama_lengkap }}</li>
                        @if ($data->nomor != '')
                            <li><i class="fas fa-caret-right left-10"></i> <strong class="text-color-primary">Nomor:</strong> {{ $data->nomor }}</li>
                        @endif
                        <li><i class="fas fa-caret-right left-10"></i> <strong class="text-color-primary">Tanggal:</strong> {{ \CID::hariTgl($data->tanggal) }}</li>
                        <li><i class="fas fa-caret-right left-10"></i> <strong class="text-color-primary">Jumlah Views:</strong> {{ \CID::toDot($data->views) }}</li>
                        <li><i class="fas fa-caret-right left-10"></i> <strong class="text-color-primary">Jumlah Downloads:</strong> {{ \CID::toDot($data->downloads) }}</li>
                        <li><i class="fas fa-caret-right left-10"></i> <strong class="text-color-primary">Ukuran File:</strong> {{ \CID::SizeDisk($data->size) }}</li>
                        <li><a target="_BLANK" href="{{ route('exdown.unduh', [\CID::encode($data->uuid)]) }}" class="btn btn-outline btn-rounded btn-primary  btn-with-arrow mb-2">Download<span><i class="fa-solid fa-cloud-arrow-down"></i></span></a></li>
                    </ul>
                </div>
            </div>
        </div>

    </div>
@endsection
