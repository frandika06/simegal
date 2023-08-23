@extends('layouts.admin.portal')
@push('apps')
    SIMEGAL
@endpush
@push('title')
    Halaman | SIMEGAL
@endpush
@push('description')
    Halaman | Sistem Informasi Metrologi Legal Pemerintah Kabupaten Tangerang
@endpush
@push('header-title')
    Halaman
@endpush
@push('styles')
    <link href="{{ asset('assets-admin/plugins/summernote/summernote-lite.css') }}" rel="stylesheet">
@endpush
@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <form action="{{ isset($data) ? route('prt.apps.page.update', [$uuid_enc]) : route('prt.apps.page.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @isset($data)
                    @method('put')
                @endisset

                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-header p-3">
                                <h4 class="heading mb-0">{{ $title }}</h4>
                            </div>
                            <div class="card-body">
                                <div class="basic-form">
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">Judul <span class="wajib">*</span></label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control @error('judul') is-invalid @enderror" name="judul" id="judul" value="{{ old('judul', isset($data) ? $data->judul : '') }}" placeholder="Masukkan Judul." maxlength="300" autocomplete="off" required>
                                            @error('judul')
                                                <div id="judulFeedback" class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- thumbnails --}}
                                    @if (isset($data))
                                        <div class="mb-3 row">
                                            <label class="col-sm-3 col-form-label">Thumbnails</label>
                                            <div class="col-sm-9">
                                                <input type="file" class="form-control @error('thumbnails') is-invalid @enderror" name="thumbnails" id="thumbnails" accept=".png,.jpg,.jpeg">
                                                @error('thumbnails')
                                                    <div id="thumbnailsFeedback" class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                @if ($data->thumbnails != '')
                                                    {{-- ada file --}}
                                                    <div class="text-end">
                                                        <a href="{{ \CID::urlImg($data->thumbnails) }}" target="_BLANK" class="btn btn-sm btn-primary mt-2"><i class="fa fa-image"></i> Lihat File</a>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @else
                                        <div class="mb-3 row">
                                            <label class="col-sm-3 col-form-label">Thumbnails <span class="wajib">*</span></label>
                                            <div class="col-sm-9">
                                                <input type="file" class="form-control @error('thumbnails') is-invalid @enderror" name="thumbnails" id="thumbnails" required accept=".png,.jpg,.jpeg">
                                                @error('thumbnails')
                                                    <div id="thumbnailsFeedback" class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    @endif

                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">Deskripsi</label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control @error('deskripsi') is-invalid @enderror" name="deskripsi" id="deskripsi" cols="5" rows="5" placeholder="Masukkan Deskripsi." maxlength="500" autocomplete="off">{{ old('deskripsi', isset($data) ? $data->deskripsi : '') }}</textarea>
                                            @error('deskripsi')
                                                <div id="deskripsiFeedback" class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">Status <span class="wajib">*</span></label>
                                        <div class="col-sm-9">
                                            <select class="form-control" name="status" id="status" required>
                                                <option @if (old('status', isset($data) ? $data->status : '') == 'Draft') selected @endif value="Draft">Draft</option>
                                                <option @if (old('status', isset($data) ? $data->status : '') == 'Published') selected @endif value="Published">Published</option>
                                                <option @if (old('status', isset($data) ? $data->status : '') == 'Unpublish') selected @endif value="Unpublish">Unpublish</option>
                                            </select>
                                            @error('status')
                                                <div id="statusFeedback" class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="basic-form">
                                    <div class="mb-3 row">
                                        <div class="col-sm-12">
                                            <textarea class="form-control col-md-12 col-xs-12 @error('post') is-invalid @enderror" name="post" id="post" placeholder="Masukkan Halaman." required>{{ old('post') }}</textarea>
                                            @error('post')
                                                <div class="invalid-feedback text-left">
                                                    <label>{{ $message }}</label>
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-5 row">
                    <div class="col-sm-12 text-end">
                        <a href="{{ route('prt.apps.page.index') }}" class="btn btn-light btn-rounded me-2"><i class="fa fa-times"></i> Batal</a>
                        <button type="submit" class="btn btn-primary btn-rounded"><i class="fa-solid fa-save"></i> {{ $submit }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('assets-admin/plugins/summernote/summernote-lite.js') }}"></script>
    <script src="{{ asset('assets-admin/plugins/summernote/lang/summernote-id-ID.js') }}"></script>
    {{--  Summernote  --}}
    <script>
        $(document).ready(function() {
            $('#post').summernote({
                lang: 'id-ID',
                placeholder: 'Isi Post...',
                tabsize: 2,
                height: 500,
            });
        });
    </script>
    @if (isset($data))
        <script>
            $(document).ready(function() {
                var content = {!! json_encode($data->post) !!};
                $('#post').summernote('code', content);
            });
        </script>
    @endif
@endpush
