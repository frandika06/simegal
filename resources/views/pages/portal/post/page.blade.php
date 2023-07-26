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

        <div class="container py-4">
            <div class="row">
                <div class="col">
                    <div class="blog-posts single-post">
                        <article class="post post-large blog-single-post border-0 m-0 p-0">
                            <div class="post-image ms-0">
                                <img src="{{ $dataPosts->photo_url }}" class="img-fluid img-thumbnail img-thumbnail-no-borders rounded-0" alt="{{ $UcSlug }}" />
                            </div>
                            <div class="post-date ms-0">
                                <span class="day">{{ date('d', strtotime($dataPosts->created_at)) }}</span>
                                <span class="month">{{ date('M', strtotime($dataPosts->created_at)) }}</span>
                            </div>
                            <div class="post-content ms-0">
                                <h2 class="font-weight-semi-bold">{{ $UcSlug }}</h2>
                                <div class="post-meta">
                                    <span><i class="far fa-user"></i> By John Doe</span>
                                    <span><i class="far fa-folder"></i> <a href="{{ route('prt.page.index', [$slug]) }}">{{ $UcSlug }}</a></span>
                                    <span><i class="far fa-comments"></i> 0 Comments</span>
                                </div>
                                {{-- ARTIKEL --}}
                                {!! $dataPosts->content_html !!}
                            </div>
                        </article>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
