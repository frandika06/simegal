@extends('layouts.portal.base')
@push('apps')
    SIMEGAL
@endpush
@push('title')
    Unduhan | SIMEGAL
@endpush
@push('description')
    Unduhan | Sistem Informasi Metrologi Legal Pemerintah Kabupaten Tangerang
@endpush
@section('content')
    <div role="main" class="main">
        <section class="page-header page-header-modern bg-color-primary page-header-md">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 order-2 order-md-1 align-self-center p-static">
                        <h1 class="">Unduhan</h1>
                    </div>
                    <div class="col-md-4 order-1 order-md-2 align-self-center">
                        <ul class="breadcrumb d-block text-md-end breadcrumb-light">
                            <li><a href="{{ route('prt.home.index') }}">Beranda</a></li>
                            <li class="active">Unduhan</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <div class="container py-5">
            <div class="row my-5">
                @foreach ($data as $item)
                    <div class="col-lg-6 mb-6 mb-lg-0">
                        <div class="recent-posts mb-5">
                            <article class="post">
                                <div class="row">
                                    <div class="col-auto pe-0">
                                        <div class="post-date">
                                            <span class="day text-color-dark font-weight-extra-bold">{{ date('d', strtotime($item->created_at)) }}</span>
                                            <span class="month">{{ date('M', strtotime($item->created_at)) }}</span>
                                        </div>
                                    </div>
                                    <div class="col ps-1">
                                        <h4 class="line-height-3"><a href="{{ route('prt.media.read', [$tags, $item->id]) }}" class="text-decoration-none">{{ $item->description }}</a></h4>
                                        <div class="post-meta">
                                            <span><i class="fa-solid fa-eye"></i> {{ \CID::toDot(rand(0, 5000)) }}</span>
                                            <span><i class="fa-solid fa-cloud-arrow-down"></i> {{ \CID::toDot(rand(0, 5000)) }}</span>
                                        </div>
                                        <a href="{{ route('prt.media.read', [$tags, $item->id]) }}" class="btn btn-light text-uppercase text-primary text-1 py-2 px-3 mb-1 mt-2"><strong>VIEW MORE</strong><i class="fas fa-chevron-right text-2 ps-2"></i></a>
                                    </div>
                                </div>
                            </article>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
@endsection
