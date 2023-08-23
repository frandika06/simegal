@extends('layouts.admin.portal')
@push('apps')
    SIMEGAL
@endpush
@push('title')
    Dashboard | SIMEGAL
@endpush
@push('description')
    Dashboard | Sistem Informasi Metrologi Legal Pemerintah Kabupaten Tangerang
@endpush
@push('header-title')
    Dashboard
@endpush
@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header border-0 p-3">
                            <h4 class="heading mb-0">Data Publish</h4>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table id="datatable" class="display table" style="min-width: 845px">
                                    <thead>
                                        <tr>
                                            <th width="30px">#</th>
                                            <th width="60%">Kategori</th>
                                            <th width="15%">Draft</th>
                                            <th width="15%">Published</th>
                                            <th width="15%">Unpublish</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th width="30px">#</th>
                                            <th width="60%">Kategori</th>
                                            <th width="15%">Draft</th>
                                            <th width="15%">Published</th>
                                            <th width="15%">Unpublish</th>
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
            "ajax": "{!! route('prt.apps.home.index') !!}",
            "columns": [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'kategori',
                    name: 'kategori'
                },
                {
                    data: 'draft',
                    name: 'draft'
                },
                {
                    data: 'published',
                    name: 'published'
                },
                {
                    data: 'unpublish',
                    name: 'unpublish'
                }
            ],
            "columnDefs": [{
                className: "min_id text-center",
                targets: [0]
            }, {
                className: "text-center",
                targets: [2, 3, 4]
            }]
        });
    </script>
    {{-- custom-js --}}
@endpush
