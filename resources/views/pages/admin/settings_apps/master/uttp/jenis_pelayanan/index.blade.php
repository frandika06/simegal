@extends('layouts.admin.settings')
@push('apps')
    SIMEGAL
@endpush
@push('title')
    Jenis Pelayanan | Pengaturan Aplikasi | SIMEGAL
@endpush
@push('description')
    Jenis Pelayanan | Pengaturan Aplikasi | Sistem Informasi Metrologi Legal Pemerintah Kabupaten Tangerang
@endpush
@push('header-title')
    Jenis Pelayanan | Pengaturan Aplikasi
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
                <h1 class="d-flex text-dark fw-bold my-1 fs-3">Jenis Pelayanan</h1>
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
                    <li class="breadcrumb-item text-dark">Jenis Pelayanan</li>
                    {{-- end::Item --}}
                </ul>
                {{-- end::Breadcrumb --}}
            </div>
            {{-- end::Page title --}}
            @if (\CID::subRoleAdmin() == true)
                {{-- begin::Actions --}}
                <div class="d-flex align-items-center py-2 py-md-1">
                    <a href="javascript:void(0);" class="btn btn-info fw-bold" data-bs-toggle="modal" data-bs-target="#add_uttp_jenis_pelayanan" data-mode="add"><i class="fa-solid fa-plus"></i>Tambah Jenis Pelayanan</a>
                </div>
                {{-- end::Actions --}}
            @endif
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
                                    <th>Nama Pelayanan</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
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

{{-- modal::begin --}}
@push('modals')
    {{-- begin::modal-add-alamat --}}
    <div class="modal fade add" tabindex="-1" id="add_uttp_jenis_pelayanan">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('set.apps.mst.uttp.jp.store') }}" method="POST" id="formSuperAdmin" enctype="multipart/form-data">
                    @csrf

                    <div class="modal-header">
                        <h3 class="modal-title" id="modal_title"></h3>
                        {{-- begin::Close --}}
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                            <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                        {{-- end::Close --}}
                    </div>

                    <div class="modal-body">
                        {{-- begin::nama_pelayanan --}}
                        <div class="form-floating mb-5">
                            <input type="text" class="form-control @error('nama_pelayanan') is-invalid @enderror" name="nama_pelayanan" id="nama_pelayanan2" placeholder="Nama Pelayanan" autocomplete="off" maxlength="100" value="{{ old('nama_pelayanan') }}" required />
                            <label for="nama_pelayanan">Nama Pelayanan</label>
                            @error('nama_pelayanan')
                                <div id="nama_pelayananFeedback" class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        {{-- end::nama_pelayanan --}}
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal"><i class="fa-solid fa-times"></i>Batal</button>
                        <button type="submit" class="btn btn-info"><i class="fa-solid fa-save"></i>Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- end::modal-add-alamat --}}
@endpush
{{-- modal::end --}}

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
            "ajax": "{!! route('set.apps.mst.uttp.jp.data') !!}",
            "columns": [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'nama_pelayanan',
                    name: 'nama_pelayanan'
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
                    targets: [0, 3]
                },
                {
                    className: "min-w-500px",
                    targets: [1]
                },
                {
                    className: "text-end",
                    targets: [3]
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

        $(document).on('click', "[data-delete]", function() {
            let uuid = $(this).attr('data-delete');
            Swal.fire({
                title: "Hapus Data",
                text: "Apakah Anda Yakin?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Iya, Hapus Data!",
                cancelButtonText: 'Tidak, Batalkan!',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{!! route('set.apps.mst.uttp.jp.destroy') !!}",
                        type: 'POST',
                        data: {
                            uuid: uuid,
                            _method: 'delete',
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(res) {
                            Swal.fire({
                                title: "Success",
                                text: res.message,
                                icon: "success",
                            }).then((result) => {
                                location.reload();
                            });
                        },
                        error: function(xhr) {
                            Swal.fire({
                                title: "Error",
                                text: xhr.responseJSON.message,
                                icon: "error",
                            }).then((result) => {
                                location.reload();
                            });
                        }
                    });
                }
            });
        });

        $(document).on('click', "[data-status]", function() {
            let uuid = $(this).attr("data-status");
            let status = $(this).attr("data-status-value");
            $.ajax({
                url: "{!! route('set.apps.mst.uttp.jp.status') !!}",
                type: 'POST',
                data: {
                    uuid: uuid,
                    status: status,
                    _method: 'put',
                    _token: "{{ csrf_token() }}"
                },
                success: function(res) {
                    Swal.fire({
                        title: "Success",
                        text: res.message,
                        icon: "success",
                    }).then((result) => {
                        $('#datatable').DataTable().ajax.reload();
                    });
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

    {{-- edit form --}}
    <script>
        $('a[data-bs-target^="#add_uttp_jenis_pelayanan"]').click(function() {
            var mode = $(this).data("mode");
            if (mode == "add") {
                $("#modal_title").html("Form Tambah Jenis Pelayanan");
                $("#formSuperAdmin").trigger("reset");
            }
        });
    </script>
@endpush
