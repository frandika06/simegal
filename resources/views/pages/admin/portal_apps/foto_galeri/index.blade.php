@extends('layouts.admin.portal')
@push('apps')
    SIMEGAL
@endpush
@push('title')
    Foto | SIMEGAL
@endpush
@push('description')
    Foto | Sistem Informasi Metrologi Legal Pemerintah Kabupaten Tangerang
@endpush
@push('header-title')
    Foto
@endpush
@push('styles')
    {{-- lightgallery --}}
    <link href="{{ asset('assets-admin/plugins/lightgallery/css/lightgallery.min.css') }}" rel="stylesheet">
    {{-- toast --}}
    <link href="{{ asset('assets-admin/plugins/jquery-toast-plugin/dist/jquery.toast.min.css') }}" rel="stylesheet" />
    {{-- dropzone --}}
    <link href="{{ asset('assets-admin/plugins/dropzone/dropzone.css') }}" rel="stylesheet" />
@endpush
@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Form Upload Foto Galeri</h4>
                        </div>
                        <div class="card-body pb-1">
                            <div class="pb-4">
                                <form method="POST" action="{{ route('prt.apps.foto.upload', [$uuid_encgaleri]) }}" class="dropzone" id="dzgallery">
                                    @csrf
                                </form>
                                <div class="text-end">
                                    <button type="button" class="btn btn-secondary mt-2" id="dropzoneReset"><i class="fas fa-eraser"></i>Reset</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Data Foto Galeri</h4>
                        </div>
                        <div class="card-body pb-1">
                            <div class="row" id="LoadFoto">
                                {{-- @foreach ($data as $item)
                                    <div class="col-lg-3 col-6 mb-4">
                                        <div class="mb-2">
                                            <a target="_BLANK" href="{{ \CID::urlImg($item->url) }}">
                                                <img src="{{ \CID::urlImg($item->url) }}" style="width:100%;">
                                            </a>
                                        </div>
                                        <button class="btn btn-sm btn-danger mt-2 btn-block" data-delete="{{ \CID::encode($item->uuid) }}"><i class="fa fa-trash"></i> Hapus Foto</button>
                                    </div>
                                @endforeach --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    {{-- lightgallery --}}
    <script src="{{ asset('assets-admin/plugins/lightgallery/js/lightgallery-all.min.js') }}"></script>
    {{-- toast --}}
    <script src="{{ asset('assets-admin/plugins/jquery-toast-plugin/dist/jquery.toast.min.js') }}"></script>
    {{-- dropzone --}}
    <script src="{{ asset('assets-admin/plugins/dropzone/dropzone.js') }}"></script>

    {{-- custom-js --}}
    <script>
        $(document).ready(function() {
            loadFoto();
        });
    </script>
    <script>
        Dropzone.autoDiscover = false;
        $('#dzgallery').dropzone({
            maxFilesize: 100,
            addRemoveLinks: true,
            acceptedFiles: ".jpeg,.jpg,.png,.svg",
            success: function(file, res) {
                loadFoto();
                $.toast({
                    heading: 'Success',
                    text: res.message.text,
                    position: 'top-right',
                    icon: 'success',
                    stack: false,
                    loaderBg: '#f96868'
                });
            },
            error: function(file, res) {
                loadFoto();
                $.toast({
                    heading: 'Error',
                    text: res.message,
                    position: 'bottom-right',
                    icon: 'error',
                    stack: false,
                    loaderBg: '#f96868'
                });
            }
        });
        $("#dropzoneReset").on('click', function() {
            loadFoto();
            Dropzone.forElement('#dzgallery').removeAllFiles(true);
        });
    </script>
    <script>
        function loadFoto() {
            $.ajax({
                url: "{!! route('prt.apps.foto.index', [$uuid_encgaleri]) !!}",
                type: "GET",
                dataType: "json",
                success: function(data) {
                    $('#LoadFoto').html('');
                    $.each(data, function(key, value) {
                        $('#LoadFoto').append(value);
                    });
                }
            });
        }

        $(document).on('click', "[data-delete]", function() {
            let uuid = $(this).attr('data-delete');
            swal({
                    title: "Hapus Data",
                    text: "Apakah Anda Yakin?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn btn-danger",
                    confirmButtonText: "Yes, delete it!",
                    closeOnConfirm: false
                },
                function() {
                    $.ajax({
                        url: "{!! route('prt.apps.foto.destroy', [$uuid_encgaleri]) !!}",
                        type: 'POST',
                        data: {
                            uuid: uuid,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(res) {
                            loadFoto();
                            swal({
                                title: "Success",
                                text: res.message,
                                type: "success",
                            });
                        },
                        error: function(xhr) {
                            loadFoto();
                            swal({
                                title: "Error",
                                text: xhr.responseJSON.message,
                                type: "error",
                            });
                        }
                    });
                });
        });
    </script>
    {{-- custom-js --}}
@endpush
