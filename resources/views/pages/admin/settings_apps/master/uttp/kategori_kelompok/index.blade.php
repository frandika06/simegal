@extends('layouts.admin.settings')
@push('apps')
    SIMEGAL
@endpush
@push('title')
    Kategori Kelompok | Pengaturan Aplikasi | SIMEGAL
@endpush
@push('description')
    Kategori Kelompok | Pengaturan Aplikasi | Sistem Informasi Metrologi Legal Pemerintah Kabupaten Tangerang
@endpush
@push('header-title')
    Kategori Kelompok | Pengaturan Aplikasi
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
                <h1 class="d-flex text-dark fw-bold my-1 fs-3">Kategori Kelompok</h1>
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
                    <li class="breadcrumb-item text-dark">Kategori Kelompok</li>
                    {{-- end::Item --}}
                </ul>
                {{-- end::Breadcrumb --}}
            </div>
            {{-- end::Page title --}}
            @if (\CID::subRoleAdmin() == true)
                {{-- begin::Actions --}}
                <div class="d-flex align-items-center py-2 py-md-1">
                    <a href="javascript:void(0);" class="btn btn-info fw-bold" data-bs-toggle="modal" data-bs-target="#add_uttp_tags_kelompok" data-mode="add"><i class="fa-solid fa-plus"></i>Tambah Kategori Kelompok</a>
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
                                    <th>Jenis Pelayanan</th>
                                    <th>Kode</th>
                                    <th>Kategori</th>
                                    <th>Item</th>
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
    <div class="modal fade add" tabindex="-1" id="add_uttp_tags_kelompok">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('set.apps.mst.uttp.tags.klpk.store') }}" method="POST" id="formTagsKelompok" enctype="multipart/form-data">
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
                        {{-- begin::jenis_pelayanan --}}
                        <div class="form-floating mb-5">
                            <select class="form-control @error('jenis_pelayanan') is-invalid @enderror" name="jenis_pelayanan" id="jenis_pelayanan" required>
                                <option value="" selected disabled>-Pilih Jenis Pelayanan</option>
                                @foreach ($getJP as $item)
                                    <option value="{{ $item->uuid }}" @if (old('jenis_pelayanan') == $item->uuid) selected @endif>{{ $item->nama_pelayanan }}</option>
                                @endforeach
                            </select>
                            <label for="jenis_pelayanan">Jenis Pelayanan</label>
                            @error('jenis_pelayanan')
                                <div id="jenis_pelayananFeedback" class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        {{-- end::jenis_pelayanan --}}

                        {{-- begin::nama_kelompok --}}
                        <div class="form-floating mb-5">
                            <select class="form-control @error('nama_kelompok') is-invalid @enderror" name="nama_kelompok" id="nama_kelompok" required>
                                <option value="" selected disabled>-Pilih Nama Kelompok</option>
                            </select>
                            <label for="nama_kelompok">Nama Kelompok</label>
                            @error('nama_kelompok')
                                <div id="nama_kelompokFeedback" class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        {{-- end::nama_kelompok --}}

                        {{-- begin::kategori --}}
                        <div class="form-floating mb-5">
                            <select class="form-control @error('kategori') is-invalid @enderror" name="kategori" id="kategori" required>
                                <option value="" selected disabled>-Pilih Ketegori</option>
                                <option value="0" @if (old('kategori') == '0') selected @endif>Jenis UTTP</option>
                                <option value="1" @if (old('kategori') == '1') selected @endif>Alat Standar & Perlengkapannya</option>
                                <option value="2" @if (old('kategori') == '2') selected @endif>CTT</option>
                            </select>
                            <label for="kategori">Ketegori</label>
                            @error('kategori')
                                <div id="kategoriFeedback" class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        {{-- end::kategori --}}

                        {{-- begin::nama_kategori --}}
                        <div class="form-floating mb-5">
                            <input type="text" class="form-control @error('nama_kategori') is-invalid @enderror" name="nama_kategori" id="nama_kategori2" placeholder="Nama Kategori/Item" autocomplete="off" maxlength="100" value="{{ old('nama_kategori') }}" required />
                            <label for="nama_kategori">Nama Kategori/Item</label>
                            @error('nama_kategori')
                                <div id="nama_kategoriFeedback" class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        {{-- end::nama_kategori --}}
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
    {{-- get data kelompok --}}
    <script>
        $('select[name="jenis_pelayanan"]').change(function() {
            var jenis_pelayanan = $(this).val();
            var urlKelompokUttp = "{!! route('ajax.set.apps.get.klpk.uttp') !!}";
            $.post(urlKelompokUttp, {
                    uuid: jenis_pelayanan,
                    _token: "{{ csrf_token() }}"
                })
                .done(function(res) {
                    $('select[name="nama_kelompok"]').empty();
                    $.each(res.data, function(key, value) {
                        $('select[name="nama_kelompok"]').append('<option value="' + value.uuid + '">' + value.nama_kelompok + '</option>');
                    });
                });
        });
    </script>

    {{-- datatable --}}
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
            "ajax": "{!! route('set.apps.mst.uttp.tags.klpk.data') !!}",
            "columns": [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'no_urut',
                    name: 'no_urut'
                },
                {
                    data: 'nama_pelayanan',
                    name: 'nama_pelayanan'
                },
                {
                    data: 'kode',
                    name: 'kode'
                },
                {
                    data: 'kategori',
                    name: 'kategori'
                },
                {
                    data: 'nama_kategori',
                    name: 'nama_kategori'
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
                    targets: [0, 7]
                },
                {
                    className: "text-center w-80px",
                    targets: [1]
                },
                {
                    className: "w-80px",
                    targets: [3, 6]
                },
                {
                    className: "text-end",
                    targets: [7]
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
                        url: "{!! route('set.apps.mst.uttp.tags.klpk.destroy') !!}",
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
                url: "{!! route('set.apps.mst.uttp.tags.klpk.status') !!}",
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
        $('a[data-bs-target^="#add_uttp_tags_kelompok"]').click(function() {
            var mode = $(this).data("mode");
            if (mode == "add") {
                $("#modal_title").html("Form Tambah Kategori Kelompok");
                $("#formTagsKelompok").trigger("reset");
            }
        });
    </script>
@endpush
