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

        <div class="container py-4 mb-5">
            <div class="row">
                <div class="col">
                    <h2 class="font-weight-normal text-7 mb-2">Frequently Asked <strong class="font-weight-extra-bold">Questions</strong></h2>
                    <p class="lead">Halaman ini memuat informasi tentang pertanyaan dan jawaban yang sering muncul kepada kami tentang SIMEGAL (Sistem Informasi Metrologi Legal) untuk membantu menjawab pertanyaan-pertanyaan dari masyarakat.</p>
                    <hr class="solid my-5">
                    <div class="toggle toggle-primary m-0" data-plugin-toggle>
                        @php
                            $no = 1;
                        @endphp
                        @foreach ($data as $item)
                            <section class="toggle @if ($no == '1') active @endif">
                                <a class="toggle-title">{{ $item->judul }}</a>
                                <div class="toggle-content">
                                    <p>{!! $item->post !!}</p>
                                </div>
                            </section>
                            @php
                                $no++;
                            @endphp
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
