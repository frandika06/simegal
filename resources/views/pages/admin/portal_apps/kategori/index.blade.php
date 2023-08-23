@extends('layouts.admin.portal')
@push('apps')
    SIMEGAL
@endpush
@push('title')
    Master Kategori | SIMEGAL
@endpush
@push('description')
    Master Kategori | Sistem Informasi Metrologi Legal Pemerintah Kabupaten Tangerang
@endpush
@push('header-title')
    Master Kategori
@endpush
@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header border-0 p-3">
                            <h4 class="heading mb-0">Data Master Kategori</h4>
                        </div>
                        <div class="card-header flex-wrap border-0">
                            <a href="{{ route('prt.apps.mst.tags.create') }}" class="btn btn-primary btn-sm"><i class="fa-solid fa-plus me-2"></i>Tambah Data</a>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table id="datatable" class="display table" style="min-width: 845px">
                                    <thead>
                                        <tr>
                                            <th width="30px">#</th>
                                            <th>Nama</th>
                                            <th>Slug</th>
                                            <th>Tipe</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th width="30px">#</th>
                                            <th>Nama</th>
                                            <th>Slug</th>
                                            <th>Tipe</th>
                                            <th>Status</th>
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
        $(document).ready(function() {
            loadData();
        });

        function loadData() {
            $('#datatable').DataTable({
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
                "ajax": "{!! route('prt.apps.mst.tags.index') !!}",
                "columns": [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'slug',
                        name: 'slug'
                    },
                    {
                        data: 'jenis',
                        name: 'jenis'
                    },
                    {
                        data: 'status',
                        name: 'status'
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
                    targets: [0, 4, 5]
                }]
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
                        url: "{!! route('prt.apps.mst.tags.destroy') !!}",
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

        $(document).on('click', "[data-status]", function() {
            let uuid = $(this).attr("data-status");
            let status = $(this).attr("data-status-value");
            $.ajax({
                url: "{!! route('prt.apps.mst.tags.status') !!}",
                type: 'POST',
                data: {
                    uuid: uuid,
                    status: status,
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
    </script>
    {{-- custom-js --}}
@endpush
