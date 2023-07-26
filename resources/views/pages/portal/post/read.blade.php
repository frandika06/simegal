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
                <div class="col">
                    <div class="blog-posts single-post">
                        <article class="post post-large blog-single-post border-0 m-0 p-0">
                            <div class="post-image ms-0">
                                <img src="{{ $data->photo_url }}" class="img-fluid img-thumbnail img-thumbnail-no-borders rounded-0" alt="{{ $data->title }}" />
                            </div>
                            <div class="post-date ms-0">
                                <span class="day">{{ date('d', strtotime($data->created_at)) }}</span>
                                <span class="month">{{ date('M', strtotime($data->created_at)) }}</span>
                            </div>
                            <div class="post-content ms-0">
                                <h2 class="font-weight-semi-bold">{{ $data->title }}</h2>
                                <div class="post-meta">
                                    <span><i class="far fa-user"></i> By John Doe</span>
                                    <span><i class="far fa-folder"></i> <a href="{{ route('prt.post.index', [$tags]) }}">{{ $UcTags }}</a></span>
                                    <span><i class="far fa-comments"></i> 0 Comments</span>
                                </div>
                                {{-- ARTIKEL --}}
                                {!! $data->content_html !!}
                                {{-- ARTIKEL --}}
                                {{-- <div class="post-block mt-5 post-share">
                                    <h4 class="mb-3">Share this Post</h4>
                                    <!-- Go to www.addthis.com/dashboard to customize your tools -->
                                    <div class="addthis_inline_share_toolbox"></div>
                                    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-60ba220dbab331b0"></script>
                                </div> --}}
                            </div>
                        </article>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
