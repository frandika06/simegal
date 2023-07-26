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

        <div id="examples" class="container py-5 mb-5">
            <div class="row">
                @foreach ($data as $item)
                    <div class="col-lg-6 py-4">
                        <h4>{{ $item->title }}</h4>
                        <div class="ratio ratio-16x9 ratio-borders">
                            <iframe frameborder="0" allowfullscreen="" src="//www.youtube.com/embed/mjAEkO15uNQ?showinfo=0&amp;wmode=opaque"></iframe>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
