@extends('layouts.portal.base')
@push('apps')
    SIMEGAL
@endpush
@push('title')
    Video | SIMEGAL
@endpush
@push('description')
    Video | Sistem Informasi Metrologi Legal Pemerintah Kabupaten Tangerang
@endpush
@section('content')
    <div role="main" class="main">
        <section class="page-header page-header-modern bg-color-primary page-header-md">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 order-2 order-md-1 align-self-center p-static">
                        <h1 class="">Video</h1>
                    </div>
                    <div class="col-md-4 order-1 order-md-2 align-self-center">
                        <ul class="breadcrumb d-block text-md-end breadcrumb-light">
                            <li><a href="{{ route('prt.home.index') }}">Beranda</a></li>
                            <li class="active">Video</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        @if (!empty($data))
            <div class="container py-2">
                <div class="row">
                    @foreach ($data as $item)
                        <div class="col-lg-4 mb-4">
                            <article class="post post-large pb-5">
                                <div class="post-image">
                                    <a href="{{ route('prt.media.video.read', [$item->slug]) }}">
                                        @if (isset($item->thumbnails))
                                            <img src="{{ \CID::urlImg($item->thumbnails) }}" class="img-fluid img-thumbnail img-thumbnail-no-borders rounded-0" alt="{{ $item->judul }}" />
                                        @else
                                            <img src="https://img.youtube.com/vi/{!! $item->url !!}/maxresdefault.jpg" class="img-fluid img-thumbnail img-thumbnail-no-borders rounded-0" alt="{{ $item->judul }}" />
                                        @endif
                                    </a>
                                </div>
                                <div class="post-date">
                                    <span class="day">{{ date('d', strtotime($item->created_at)) }}</span>
                                    <span class="month">{{ date('M', strtotime($item->created_at)) }}</span>
                                </div>
                                <div class="post-content">
                                    <h4><a href="{{ route('prt.media.video.read', [$item->slug]) }}" class="text-decoration-none">{{ $item->judul }}</a></h4>
                                    <p class="mb-1">{{ \Str::limit($item->deskripsi, 50, '...') }}</p>
                                    <a href="{{ route('prt.media.video.read', [$item->slug]) }}" class="read-more text-color-dark font-weight-bold text-2">Read More <i class="fas fa-chevron-right text-1 ms-1"></i></a>
                                </div>
                            </article>
                        </div>
                    @endforeach
                </div>

                {{-- pagination --}}
                <div class="text-center mb-5">
                    @if ($data->currentPage() > 1)
                        <a href="{{ $data->previousPageUrl() }}" class="btn btn-outline btn-gradient mb-2">Previous</a>
                    @endif

                    @if ($data->hasMorePages())
                        <a href="{{ $data->nextPageUrl() }}" class="btn btn-outline btn-gradient mb-2">Next</a>
                    @endif
                </div>
            </div>
        @else
            <div class="container">
                <section class="http-error">
                    <div class="row justify-content-center py-3">
                        <div class="col-md-12 text-center">
                            <div class="http-error-main">
                                <h2>404!</h2>
                                <p>We're sorry, but the page you were looking for doesn't exist.</p>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        @endif

        {{-- <div id="examples" class="container py-5 mb-5">
            <div class="row">
                @foreach ($data as $item)
                    <div class="col-lg-6 py-4">
                        <h4>{{ $item->judul }}</h4>
                        <div class="ratio ratio-16x9 ratio-borders">
                            <iframe frameborder="0" allowfullscreen="" src="//www.youtube.com/embed/mjAEkO15uNQ?showinfo=0&amp;wmode=opaque"></iframe>
                        </div>
                    </div>
                @endforeach
            </div>
        </div> --}}
    </div>
@endsection
