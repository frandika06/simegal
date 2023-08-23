@extends('layouts.portal.base')
@push('apps')
    SIMEGAL
@endpush
@push('title')
    Galeri | SIMEGAL
@endpush
@push('description')
    Galeri | Sistem Informasi Metrologi Legal Pemerintah Kabupaten Tangerang
@endpush
@section('content')
    <div role="main" class="main">
        <section class="page-header page-header-modern bg-color-primary page-header-md">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 order-2 order-md-1 align-self-center p-static">
                        <h1 class="">Galeri</h1>
                    </div>
                    <div class="col-md-4 order-1 order-md-2 align-self-center">
                        <ul class="breadcrumb d-block text-md-end breadcrumb-light">
                            <li><a href="{{ route('prt.home.index') }}">Beranda</a></li>
                            <li class="active">Galeri</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        @if (!empty($data))
            <div class="container py-5">
                <div id="examples" class="container py-5">
                    @php
                        $no = 1;
                    @endphp
                    @foreach ($data as $item1)
                        @php
                            $noImg = 0;
                        @endphp
                        <div class="row align-items-center py-5 mb-5">
                            <div class="col-sm-9 col-md-7 mx-auto order-2 order-md-1">
                                <div class="cascading-images-wrapper">
                                    <div class="cascading-images position-relative">
                                        @foreach ($item1->RelDataGaleri as $item2)
                                            @if ($noImg == 0)
                                                <img src="{{ \CID::urlImg($item2->url) }}" class="appear-animation" width="500" alt="" data-appear-animation="expandIn" data-appear-animation-duration="600ms" />
                                            @elseif($noImg == 1)
                                                <div class="position-absolute w-100" style="top: 41%; left: -30%;">
                                                    <img src="{{ \CID::urlImg($item2->url) }}" class="appear-animation" width="500" alt="" data-appear-animation="expandIn" data-appear-animation-delay="300" data-appear-animation-duration="600ms" />
                                                </div>
                                            @elseif($noImg == 2)
                                                <div class="position-absolute w-100" style="top: 75%; left: 30%;">
                                                    <img src="{{ \CID::urlImg($item2->url) }}" class="appear-animation" width="500" alt="" data-appear-animation="expandIn" data-appear-animation-delay="600" data-appear-animation-duration="600ms" />
                                                </div>
                                            @endif
                                            @php
                                                $noImg++;
                                            @endphp
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 py-lg-5 my-lg-5 mb-4 order-1 order-md-2">
                                <div class="pe-3 ps-md-5 pb-3 pb-sm-0 py-lg-5 my-lg-4 border-left-light border-sm-none">
                                    <h4 class="mb-2">{{ $item1->judul }}</h4>
                                    <p class="mb-2">{{ \Str::limit($item1->deskripsi, 50, '...') }}</p>
                                    <a href="{{ route('prt.media.gallery.read', [$item1->slug]) }}" class="read-more text-color-dark font-weight-bold text-2">Read More <i class="fas fa-chevron-right text-1 ms-1"></i></a>
                                </div>
                            </div>
                        </div>
                        @php
                            $no++;
                        @endphp
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
    </div>
@endsection
