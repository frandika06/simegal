@extends('layouts.admin.portal')
@push('apps')
    SIMEGAL
@endpush
@push('title')
    Video | SIMEGAL
@endpush
@push('description')
    Video | Sistem Informasi Metrologi Legal Pemerintah Kabupaten Tangerang
@endpush
@push('header-title')
    Video
@endpush
@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header border-0 p-3">
                            <h4 class="heading mb-0">Data Video</h4>
                        </div>
                        <div class="card-header flex-wrap border-0">
                            <div>
                                <a href="{{ route('prt.apps.video.create') }}" class="btn btn-primary btn-sm"><i class="fa-solid fa-plus me-2"></i>Tambah Data</a>
                            </div>
                            <div>
                                <select class="form-control" name="q_status_post" id="q_status_post">
                                    <option value="Draft" @if ($status == 'Draft') selected @endif>Draft</option>
                                    <option value="Published" @if ($status == 'Published') selected @endif>Published</option>
                                    <option value="Unpublish" @if ($status == 'Unpublish') selected @endif>Unpublish</option>
                                </select>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table id="datatable" class="display table" style="min-width: 845px">
                                    <thead>
                                        <tr>
                                            <th width="30px">#</th>
                                            <th width="60%">Judul</th>
                                            <th width="10%">Publisher</th>
                                            <th width="10%">Tanggal</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th width="30px">#</th>
                                            <th width="60%">Judul</th>
                                            <th width="10%">Publisher</th>
                                            <th width="10%">Tanggal</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    {{-- datatable js --}}

    {{-- custom-js --}}
    <script>
        $('[name="q_status_post"]').change(function() {
            var q_status_post = $(this).val();
            $('#datatable tbody').empty();
            table.ajax.reload(null, true);
        });

        var table = $('#datatable').DataTable({
            "select": true,
            "paging": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "processing": true,
            "serverSide": false,
            "responsive": false,
            "language": {
                "searchPlaceholder": 'Search...',
                "sSearch": '',
                "lengthMenu": '_MENU_ ',
                "processing": "<i class='fas fa-spinner fa-pulse'></i> Mohon tunggu...",
                "paginate": {
                    next: '<i class="fa-solid fa-angle-right"></i>',
                    previous: '<i class="fa-solid fa-angle-left"></i>'
                }
            },
            "ajax": {
                url: "{!! route('prt.apps.video.index') !!}",
                type: 'GET',
                data: function(data) {
                    data.filter = {
                        'status': $('[name="q_status_post"]').val(),
                    };
                }
            },
            "columns": [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'judul',
                    name: 'judul'
                },
                {
                    data: 'publisher',
                    name: 'publisher'
                },
                {
                    data: 'tanggal',
                    name: 'tanggal'
                },
                {
                    data: 'aksi',
                    name: 'aksi',
                    orderable: false,
                    searchable: false
                }
            ],
            "columnDefs": [{
                    className: "min_id text-center",
                    targets: [0, 4]
                },
                {
                    className: "text-center",
                    targets: [3]
                }
            ]
        });

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
                        url: "{!! route('prt.apps.video.destroy') !!}",
                        type: 'POST',
                        data: {
                            uuid: uuid,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(res) {
                            $('#datatable').DataTable().ajax.reload();
                            swal({
                                title: "Success",
                                text: res.message,
                                type: "success",
                            });
                        },
                        error: function(xhr) {
                            $('#datatable').DataTable().ajax.reload();
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
