@extends('layouts.admin.portal')
@push('apps')
    SIMEGAL
@endpush
@push('title')
    {{ $title }} | SIMEGAL
@endpush
@push('description')
    {{ $title }} | Sistem Informasi Metrologi Legal Pemerintah Kabupaten Tangerang
@endpush
@push('header-title')
    {{ $title }}
@endpush
@push('styles')
@endpush
@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="right-box-padding border-start p-0">
                        <div class="read-content">
                            <div class="card">
                                <div class="card-body">
                                    <div class="media pt-3 d-sm-flex d-block justify-content-between">
                                        <div class="clearfix mb-3 d-flex">
                                            <div class="media-body me-2">
                                                <h5 class="text-primary mb-0 mt-1">{{ $data->nama_lengkap }}</h5>
                                                <p class="mb-0">{{ \CID::hariTgl($data->created_at) }}</p>
                                            </div>
                                        </div>
                                        <div class="clearfix mb-3">
                                            <a href="{{ route('prt.apps.pesan.index') }}" class="btn btn-primary px-3 my-1 light me-2"><i class="fa fa-reply"></i></a>
                                            {{-- <a href="javascript:void(0);" class="btn btn-primary px-3 my-1 light me-2"><i class="fa fa-trash"></i></a> --}}
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="media mb-2 mt-3">
                                        <div class="media-body"><span class="pull-end">{{ date('H:i', strtotime($data->created_at)) }}</span>
                                            <h5 class="my-1 text-primary">{{ $data->subjek }}</h5>
                                            <p class="read-content-email">No. Telp: {{ $data->no_telp }} | Email: {{ $data->email }}</p>
                                        </div>
                                    </div>
                                    <div class="read-content-body">
                                        <p class="mb-2">{!! $data->pesan !!}</p>
                                        <hr>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
@endpush
