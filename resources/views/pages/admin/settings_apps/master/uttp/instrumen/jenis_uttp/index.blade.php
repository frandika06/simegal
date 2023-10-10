@extends('layouts.admin.settings')
@push('apps')
    SIMEGAL
@endpush
@push('title')
    Jenis UTTP | Pengaturan Aplikasi | SIMEGAL
@endpush
@push('description')
    Jenis UTTP | Pengaturan Aplikasi | Sistem Informasi Metrologi Legal Pemerintah Kabupaten Tangerang
@endpush
@push('header-title')
    Jenis UTTP | Pengaturan Aplikasi
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
                <h1 class="d-flex text-dark fw-bold my-1 fs-3">Jenis UTTP</h1>
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
                    <li class="breadcrumb-item text-dark">Jenis UTTP</li>
                    {{-- end::Item --}}
                </ul>
                {{-- end::Breadcrumb --}}
            </div>
            {{-- end::Page title --}}
            @if (\CID::subRoleAdmin() == true)
                {{-- begin::Actions --}}
                <div class="d-flex align-items-center py-2 py-md-1">
                    <a href="javascript:void(0);" class="btn btn-info fw-bold" data-bs-toggle="modal" data-bs-target="#add_jenis_uttp" data-mode="add"><i class="fa-solid fa-plus"></i>Tambah Jenis UTTP</a>
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
                                    <th>No. Urut</th>
                                    <th>Jenis UTTP</th>
                                    <th>Volume</th>
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
    <div class="modal fade add" tabindex="-1" id="add_jenis_uttp">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('set.apps.mst.ins.uttp.jenis.store') }}" method="POST" id="formSuperAdmin" enctype="multipart/form-data">
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
                        {{-- begin::nama_jenis_uttp --}}
                        <div class="form-floating mb-5">
                            <input type="text" class="form-control @error('nama_jenis_uttp') is-invalid @enderror" name="nama_jenis_uttp" id="nama_jenis_uttp2" placeholder="Nama Jenis UTTP" autocomplete="off" maxlength="100" value="{{ old('nama_jenis_uttp') }}" required />
                            <label for="nama_jenis_uttp">Nama Jenis UTTP</label>
                            @error('nama_jenis_uttp')
                                <div id="nama_jenis_uttpFeedback" class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        {{-- end::nama_jenis_uttp --}}

                        {{-- begin::status_volume --}}
                        <div class="form-group mb-5">
                            <label class="required mb-3">Status Volume</label>
                            <div class="ps-2">
                                <div class="form-check form-check-custom form-check-solid mb-3">
                                    <input class="form-check-input @error('status_volume') is-invalid @enderror" type="radio" value="1" name="status_volume" id="volume" @if (old('status_volume') == '1') checked @endif />
                                    <label class="form-check-label" for="volume">
                                        Volume
                                    </label>
                                </div>
                                <div class="form-check form-check-custom form-check-solid mb-3">
                                    <input class="form-check-input @error('status_volume') is-invalid @enderror" type="radio" value="0" name="status_volume" id="non_volume" @if (old('status_volume') == '0') checked @endif />
                                    <label class="form-check-label" for="non_volume">
                                        Non Volume
                                    </label>
                                </div>
                            </div>
                            @error('status_volume')
                                <div id="status_volumeFeedback" class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        {{-- end::status_volume --}}
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
            "ajax": "{!! route('set.apps.mst.ins.uttp.jenis.data') !!}",
            "columns": [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'no_urut',
                    name: 'no_urut'
                },
                {
                    data: 'nama_jenis_uttp',
                    name: 'nama_jenis_uttp'
                },
                {
                    data: 'status_volume',
                    name: 'status_volume'
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
                    targets: [0, 4]
                },
                {
                    className: "text-center w-80px",
                    targets: [1]
                },
                {
                    className: "min-w-400px",
                    targets: [2]
                },
                {
                    className: "text-end",
                    targets: [5]
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
                        url: "{!! route('set.apps.mst.ins.uttp.jenis.destroy') !!}",
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
                }
            });
        });

        $(document).on('click', "[data-status]", function() {
            let uuid = $(this).attr("data-status");
            let status = $(this).attr("data-status-value");
            $.ajax({
                url: "{!! route('set.apps.mst.ins.uttp.jenis.status') !!}",
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
        $('a[data-bs-target^="#add_jenis_uttp"]').click(function() {
            var mode = $(this).data("mode");
            if (mode == "add") {
                $("#modal_title").html("Form Tambah Jenis UTTP");
                $("#formSuperAdmin").trigger("reset");
            }
        });
    </script>
@endpush
