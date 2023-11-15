@extends('layouts.admin.settings')
@push('apps')
    SIMEGAL
@endpush
@push('title')
    Fitur | Pengaturan Aplikasi | SIMEGAL
@endpush
@push('description')
    Fitur | Pengaturan Aplikasi | Sistem Informasi Metrologi Legal Pemerintah Kabupaten Tangerang
@endpush
@push('header-title')
    Fitur | Pengaturan Aplikasi
@endpush

{{-- TOOLBOX::BEGIN --}}
@push('toolbox')
    {{-- begin::Toolbar --}}
    <div class="toolbar py-5 py-lg-5" id="kt_toolbar">
        {{-- begin::Container --}}
        <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap">
            {{-- begin::Page title --}}
            <div class="page-title d-flex flex-column me-3">
                {{-- begin::Title --}}
                <h1 class="d-flex text-dark fw-bold my-1 fs-3">Fitur</h1>
                {{-- end::Title --}}
                {{-- begin::Breadcrumb --}}
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 pt-1">
                    {{-- begin::Item --}}
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('set.apps.home.index') }}" class="text-muted text-hover-primary">Dashboard</a>
                    </li>
                    {{-- end::Item --}}
                    {{-- begin::Item --}}
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-200 w-5px h-2px"></span>
                    </li>
                    {{-- end::Item --}}
                    {{-- begin::Item --}}
                    <li class="breadcrumb-item text-muted">Master Data</li>
                    {{-- end::Item --}}
                    {{-- begin::Item --}}
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-200 w-5px h-2px"></span>
                    </li>
                    {{-- end::Item --}}
                    {{-- begin::Item --}}
                    <li class="breadcrumb-item text-dark">Fitur</li>
                    {{-- end::Item --}}
                </ul>
                {{-- end::Breadcrumb --}}
            </div>
        </div>
        {{-- end::Container --}}
    </div>
    {{-- end::Toolbar --}}
@endpush
{{-- TOOLBOX::END --}}

{{-- CONTENT::BEGIN --}}
@section('content')
    {{-- begin::Post --}}
    <div class="post d-flex flex-column-fluid" id="kt_post">
        {{-- begin::Container --}}
        <div id="kt_content_container" class="container-xxl">
            {{-- begin::card --}}
            <div class="card card-flush">
                {{-- begin::Card body --}}
                <div class="card-body">
                    <div class="table-responsive">
                        {{-- begin::Table --}}
                        <table id="datatable" class="table table-striped table-hover table-row-bordered gy-5 gs-7 border rounded">
                            <thead class="border-bottom border-gray-200 fs-7 fw-bold">
                                <tr class="text-start text-muted text-uppercase gs-0">
                                    <th>#</th>
                                    <th>Nama Fitur</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody class="fs-6 fw-semibold text-gray-600">
                            </tbody>
                        </table>
                        {{-- end::Table --}}
                    </div>
                </div>
                {{-- end::Card body --}}
            </div>
            {{-- end::card --}}
        </div>
        {{-- end::Container --}}
    </div>
    {{-- end::Post --}}
@endsection
{{-- CONTENT::END --}}

@push('scripts')
    {{-- JS CUSTOM --}}
    <script>
        var table = $('#datatable').DataTable({
            "select": false,
            "paging": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "processing": true,
            "serverSide": false,
            "responsive": false,
            "language": {
                "lengthMenu": "Show _MENU_",
            },
            "ajax": "{!! route('set.apps.mst.fitur.data') !!}",
            "columns": [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'nama_fitur',
                    name: 'nama_fitur'
                },
                {
                    data: 'status',
                    name: 'status'
                }
            ],
            "columnDefs": [{
                    className: "min_id text-center",
                    targets: [0, 2]
                },
                {
                    className: "min-w-300px",
                    targets: [1]
                }
            ],
            "dom": "<'row'" +
                "<'col-sm-6 d-flex align-items-center justify-conten-start'l>" +
                "<'col-sm-6 d-flex align-items-center justify-content-end'f>" +
                ">" +

                "<'table-responsive'tr>" +

                "<'row'" +
                "<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
                "<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
                ">",
        });

        $(document).on('click', "[data-status]", function() {
            let uuid = $(this).attr("data-status");
            let status = $(this).attr("data-status-value");
            $.ajax({
                url: "{!! route('set.apps.mst.fitur.status') !!}",
                type: 'POST',
                data: {
                    uuid: uuid,
                    status: status,
                    _method: 'put',
                    _token: "{{ csrf_token() }}"
                },
                success: function(res) {
                    if (res.status == true) {
                        Swal.fire({
                            title: "Success",
                            text: res.message,
                            icon: "success",
                        }).then((result) => {
                            $('#datatable').DataTable().ajax.reload();
                        });
                    } else {
                        Swal.fire({
                            title: "Error",
                            text: "Status Gagal Diubah!",
                            icon: "error",
                        }).then((result) => {
                            $('#datatable').DataTable().ajax.reload();
                        });
                    }
                },
                error: function(xhr) {
                    Swal.fire({
                        title: "Error",
                        text: xhr.responseJSON.message,
                        icon: "error",
                    }).then((result) => {
                        $('#datatable').DataTable().ajax.reload();
                    });
                }
            });
        });
    </script>
@endpush
