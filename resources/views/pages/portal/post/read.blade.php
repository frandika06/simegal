@extends('layouts.portal.base')
@push('apps')
    SIMEGAL
@endpush
@push('title')
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
            <div class="row">
                <div class="col">
                    <div class="blog-posts single-post">
                        <article class="post post-large blog-single-post border-0 m-0 p-0">
                            <div class="post-image ms-0">
                                <img src="{{ \CID::urlImg($data->thumbnails) }}" class="img-fluid img-thumbnail img-thumbnail-no-borders rounded-0" alt="{{ $data->judul }}" />
                            </div>
                            <div class="post-date ms-0">
                                <span class="day">{{ date('d', strtotime($data->tanggal)) }}</span>
                                <span class="month">{{ date('M', strtotime($data->tanggal)) }}</span>
                            </div>
                            <div class="post-content ms-0">
                                <h2 class="font-weight-semi-bold">{{ $data->judul }}</h2>
                                <div class="post-meta">
                                    <span><i class="far fa-user"></i> By {{ $data->publisher->nama_lengkap }}</span>
                                    <span><i class="far fa-folder"></i>
                                        @php
                                            $tags = \explode(',', $data->kategori);
                                            $ctags = \count($tags);
                                        @endphp
                                        @for ($i = 0; $i < $ctags; $i++)
                                            <a href="{{ route('prt.post.index', [$tags[$i]]) }}">{{ \CID::UcSlug($tags[$i]) }}</a>,
                                        @endfor
                                    </span>
                                </div>
                                {{-- ARTIKEL --}}
                                {!! $data->post !!}
                                {{-- ARTIKEL --}}
                            </div>
                        </article>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
