@extends('layouts.portal.base')
@push('apps')
    SIMEGAL
@endpush
@push('title')
    {{ $UcTags }} | SIMEGAL
@endpush
@push('description')
    {{ $UcTags }} | Sistem Informasi Metrologi Legal Pemerintah Kabupaten Tangerang
@endpush
@section('content')
    <div role="main" class="main">
        <section class="section section-concept section-no-border section-dark section-angled section-angled-reverse pt-5 m-0" style="background-image: url({{ asset('assets-portal/dist/img/bg/bg-03.jpg') }}); background-size: cover; background-position: center; min-height: 645px;">
            <div class="section-angled-layer-bottom section-angled-layer-increase-angle bg-light" style="padding: 8rem 0;"></div>
            <div class="container pt-lg-5 mt-5">
                <div class="row pt-3 pb-lg-0 pb-xl-0">
                    <div class="col-lg-6 pt-4 mb-5 mb-lg-0">
                        <ul class="breadcrumb font-weight-semibold text-4 negative-ls-1">
                            <li><a href="{{ route('prt.home.index') }}">Beranda</a></li>
                            <li class="active text-color-primary"><a href="{{ route('prt.post.index', 'tags') }}">{{ $UcTags }}</a></li>
                        </ul>
                        <h1 class="font-weight-bold text-10 text-xl-12 line-height-2 mb-3">{{ $UcTags }}</h1>
                        <p class="opacity-7 text-4 negative-ls-05 pb-2 mb-4">Halaman Postingan {{ $UcTags }}</p>
                    </div>

                </div>
            </div>
        </section>
        <div class="container py-2">
            <div class="row mb-5">
                @foreach ($posts->blogs as $item)
                    <div class="col-lg-4 mb-4">
                        <article class="post post-large pb-5">
                            <div class="post-image">
                                <a href="{{ route('prt.post.read', [$tags, $item->id]) }}">
                                    <img src="{{ $item->photo_url }}" class="img-fluid img-thumbnail img-thumbnail-no-borders rounded-0" alt="{{ $item->title }}" />
                                </a>
                            </div>
                            <div class="post-date">
                                <span class="day">{{ date('d', strtotime($item->created_at)) }}</span>
                                <span class="month">{{ date('M', strtotime($item->created_at)) }}</span>
                            </div>
                            <div class="post-content">
                                <h4><a href="{{ route('prt.post.read', [$tags, $item->id]) }}" class="text-decoration-none">{{ $item->title }}</a></h4>
                                <p class="mb-1">{{ $item->description }}</p>
                                <a href="{{ route('prt.post.read', [$tags, $item->id]) }}" class="read-more text-color-dark font-weight-bold text-2">READ MORE <i class="fas fa-chevron-right text-1 ms-1"></i></a>
                            </div>
                        </article>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
