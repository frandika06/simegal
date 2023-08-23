@extends('layouts.admin.portal')
@push('apps')
    SIMEGAL
@endpush
@push('title')
    Master Sosial Media | SIMEGAL
@endpush
@push('description')
    Master Sosial Media | Sistem Informasi Metrologi Legal Pemerintah Kabupaten Tangerang
@endpush
@push('header-title')
    Master Sosial Media
@endpush
@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <form action="{{ route('prt.apps.mst.sosmed.update') }}" method="POST">
                @csrf
                @isset($data)
                    @method('put')
                @endisset
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-header border-0 p-3">
                                <h4 class="heading mb-0">Update Data Sosial Media</h4>
                            </div>
                        </div>
                    </div>
                </div>

                @foreach ($data as $item)
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="basic-form">
                                        <div class="mb-3 row">
                                            <label class="col-sm-3 col-form-label">Nama Sosial Media <span class="wajib">*</span></label>
                                            <div class="col-sm-9">
                                                <input type="hidden" name="uuid[]" id="uuid[]" value="{{ $item->uuid }}">
                                                <input type="text" class="form-control @error('sosmed') is-invalid @enderror" name="sosmed[]" id="sosmed[]" value="{{ $item->sosmed }}" placeholder="Masukkan Sosial Media." maxlength="100" autocomplete="off" required>
                                                @error('sosmed')
                                                    <div id="sosmedFeedback" class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label class="col-sm-3 col-form-label">URL Sosial Media <span class="wajib">*</span></label>
                                            <div class="col-sm-9">
                                                <input type="url" class="form-control @error('url') is-invalid @enderror" name="url[]" id="url[]" value="{{ $item->url }}" placeholder="Masukkan Sosial Media." maxlength="300" autocomplete="off" required>
                                                @error('url')
                                                    <div id="urlFeedback" class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="mb-5 row">
                    <div class="col-sm-12 text-end">
                        <button type="submit" class="btn btn-primary btn-rounded"><i class="fa-solid fa-save"></i> Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('scripts')
@endpush
