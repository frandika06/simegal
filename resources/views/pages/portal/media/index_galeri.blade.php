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

        <div id="examples" class="container py-5">
            @php
                $no = 1;
            @endphp
            @foreach ($data as $item1)
                @php
                    $varImg = 'images' . $no;
                    $dataImg = $$varImg;
                    $noImg = 0;
                @endphp
                <div class="row align-items-center py-5 mb-5">
                    <div class="col-sm-9 col-md-7 mx-auto order-2 order-md-1">
                        <div class="cascading-images-wrapper">
                            <div class="cascading-images position-relative">
                                @foreach ($dataImg as $item2)
                                    @if ($noImg == 0)
                                        <img src="{{ $item2->url }}" class="appear-animation" width="500" alt="" data-appear-animation="expandIn" data-appear-animation-duration="600ms" />
                                    @elseif($noImg == 1)
                                        <div class="position-absolute w-100" style="top: 41%; left: -30%;">
                                            <img src="{{ $item2->url }}" class="appear-animation" width="500" alt="" data-appear-animation="expandIn" data-appear-animation-delay="300" data-appear-animation-duration="600ms" />
                                        </div>
                                    @elseif($noImg == 2)
                                        <div class="position-absolute w-100" style="top: 75%; left: 30%;">
                                            <img src="{{ $item2->url }}" class="appear-animation" width="500" alt="" data-appear-animation="expandIn" data-appear-animation-delay="600" data-appear-animation-duration="600ms" />
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
                            <h4 class="mb-2">{{ $item1->title }}</h4>
                            <p class="mb-2">{{ $item1->description }}</p>
                            <a href="{{ route('prt.media.read', [$tags, $item1->id]) }}" class="read-more text-color-dark font-weight-bold text-2">VIEW MORE <i class="fas fa-chevron-right text-1 ms-1"></i></a>
                        </div>
                    </div>
                </div>
                @php
                    $no++;
                @endphp
            @endforeach
        </div>
    </div>
@endsection
