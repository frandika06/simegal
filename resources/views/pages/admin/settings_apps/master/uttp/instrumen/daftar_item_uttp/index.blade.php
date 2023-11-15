@extends('layouts.admin.settings')
@push('apps')
    SIMEGAL
@endpush
@push('title')
    Daftar Item UTTP | Pengaturan Aplikasi | SIMEGAL
@endpush
@push('description')
    Daftar Item UTTP | Pengaturan Aplikasi | Sistem Informasi Metrologi Legal Pemerintah Kabupaten Tangerang
@endpush
@push('header-title')
    Daftar Item UTTP | Pengaturan Aplikasi
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
                <h1 class="d-flex text-dark fw-bold my-1 fs-3">Daftar Item UTTP</h1>
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
                    <li class="breadcrumb-item text-dark">Daftar Item UTTP</li>
                    {{-- end::Item --}}
                </ul>
                {{-- end::Breadcrumb --}}
            </div>
            {{-- end::Page title --}}
            @if (\CID::subRoleAdmin() == true)
                {{-- begin::Actions --}}
                <div class="d-flex align-items-center py-2 py-md-1">
                    <a href="javascript:void(0);" class="btn btn-success fw-bold me-2" data-bs-toggle="modal" data-bs-target="#import" data-mode="import"><i class="fa-solid fa-arrow-up-from-bracket"></i>Import</a>
                    <a href="javascript:void(0);" class="btn btn-info fw-bold" data-bs-toggle="modal" data-bs-target="#add_jenis_uttp" data-mode="add"><i class="fa-solid fa-plus"></i>Tambah Item UTTP</a>
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
                                    <th>Instrumen</th>
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
    {{-- begin::modal-import --}}
    <div class="modal fade import" tabindex="-1" id="import">
        <div class="modal-dialog min-w-550px">
            <div class="modal-content">
                <form action="{{ route('eximp.set.mst.item.uttp') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="modal-header">
                        <h3 class="modal-title">Form Import Daftar Item UTTP</h3>
                        {{-- begin::Close --}}
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                            <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                        {{-- end::Close --}}
                    </div>

                    <div class="modal-body">
                        {{-- begin::file_import --}}
                        <div class="form-floating mb-5">
                            <input type="file" class="form-control @error('file_import') is-invalid @enderror" name="file_import" id="file_import2" accept=".xls,.xlsx" required />
                            <label for="file_import">Import File Excel</label>
                            @error('file_import')
                                <div id="file_importFeedback" class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        {{-- end::file_import --}}
                    </div>

                    <div class="modal-footer">
                        <a href="{{ route('exdown.set.mst.item.uttp') }}" class="btn btn-light-success btn-xs me-auto"><i class="fa-solid fa-file-arrow-down"></i> Format</a>
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal"><i class="fa-solid fa-times"></i>Batal</button>
                        <button type="submit" class="btn btn-info"><i class="fa-solid fa-save"></i>Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- end::modal-import --}}

    {{-- begin::modal-add --}}
    <div class="modal fade add" tabindex="-1" id="add_jenis_uttp">
        <div class="modal-dialog">
            <div class="modal-content min-w-600px">
                <form action="{{ route('set.apps.mst.ins.uttp.item.store') }}" method="POST" id="formSuperAdmin" enctype="multipart/form-data">
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
                        {{-- begin::jenis_uttp --}}
                        <div class="form-group mb-5">
                            <select class="form-select @error('jenis_uttp') is-invalid @enderror" name="jenis_uttp" id="jenis_uttp" required data-control="select2" data-placeholder="Pilih Jenis UTTP" data-dropdown-parent="#add_jenis_uttp">
                                <option value="" selected disabled></option>
                                @foreach ($getMstJenisUttp as $item)
                                    <option value="{{ $item->uuid }}" @if (old('jenis_uttp') == $item->uuid) selected @endif>{{ $item->nama_jenis_uttp }}</option>
                                @endforeach
                            </select>
                            {{-- <label for="jenis_uttp">Jenis UTTP</label> --}}
                            @error('jenis_uttp')
                                <div id="jenis_uttpFeedback" class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        {{-- end::jenis_uttp --}}
                        {{-- begin::group_instrumen --}}
                        <div class="form-floating mb-5">
                            <input type="text" class="form-control @error('group_instrumen') is-invalid @enderror" name="group_instrumen" id="group_instrumen2" placeholder="Group Instrumen" autocomplete="off" maxlength="100" value="{{ old('group_instrumen') }}" />
                            <label for="group_instrumen">Group Instrumen</label>
                            @error('group_instrumen')
                                <div id="group_instrumenFeedback" class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        {{-- end::group_instrumen --}}
                        {{-- begin::nama_instrumen --}}
                        <div class="form-floating mb-5">
                            <input type="text" class="form-control @error('nama_instrumen') is-invalid @enderror" name="nama_instrumen" id="nama_instrumen2" placeholder="Nama Instrumen" autocomplete="off" maxlength="100" value="{{ old('nama_instrumen') }}" required />
                            <label for="nama_instrumen">Nama Instrumen</label>
                            @error('nama_instrumen')
                                <div id="nama_instrumenFeedback" class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        {{-- end::nama_instrumen --}}

                        {{-- begin:: Detail Volume --}}
                        <div class="mt-2">
                            <label for="">Detail Volume</label>
                            <div class="row p-2">
                                <div class="col">
                                    {{-- begin::volume_from --}}
                                    <div class="form-floating mb-5">
                                        <input type="number" class="form-control @error('volume_from') is-invalid @enderror" name="volume_from" id="volume_from2" placeholder="Volume From" autocomplete="off" maxlength="100" value="{{ old('volume_from') }}" />
                                        <label for="volume_from">Volume From</label>
                                        @error('volume_from')
                                            <div id="volume_fromFeedback" class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    {{-- end::volume_from --}}
                                </div>
                                <div class="col">
                                    {{-- begin::volume_to --}}
                                    <div class="form-floating mb-5">
                                        <input type="number" class="form-control @error('volume_to') is-invalid @enderror" name="volume_to" id="volume_to2" placeholder="Volume To" autocomplete="off" maxlength="100" value="{{ old('volume_to') }}" />
                                        <label for="volume_to">Volume To</label>
                                        @error('volume_to')
                                            <div id="volume_toFeedback" class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    {{-- end::volume_to --}}
                                </div>
                                <div class="col">
                                    {{-- begin::volume_per --}}
                                    <div class="form-floating mb-5">
                                        <input type="number" class="form-control @error('volume_per') is-invalid @enderror" name="volume_per" id="volume_per2" placeholder="Volume Per" autocomplete="off" maxlength="100" value="{{ old('volume_per') }}" />
                                        <label for="volume_per">Volume Per</label>
                                        @error('volume_per')
                                            <div id="volume_perFeedback" class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    {{-- end::volume_per --}}
                                </div>
                                <div class="col">
                                    {{-- begin::satuan --}}
                                    <div class="form-floating mb-5">
                                        <input type="text" class="form-control @error('satuan') is-invalid @enderror" name="satuan" id="satuan2" placeholder="Satuan" autocomplete="off" maxlength="100" value="{{ old('satuan') }}" />
                                        <label for="satuan">Satuan</label>
                                        @error('satuan')
                                            <div id="satuanFeedback" class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    {{-- end::satuan --}}
                                </div>
                            </div>
                        </div>
                        {{-- end:: Detail Volume --}}

                        {{-- begin:: Tera Baru --}}
                        <div class="mt-2">
                            <label for="">Tera Baru</label>
                            <div class="row p-2">
                                <div class="col">
                                    {{-- begin::tera_baru_pengujian --}}
                                    <div class="form-floating mb-5">
                                        <input type="number" class="form-control @error('tera_baru_pengujian') is-invalid @enderror" name="tera_baru_pengujian" id="tera_baru_pengujian2" placeholder="Pengujian" value="{{ old('tera_baru_pengujian') }}" min="0" required />
                                        <label for="tera_baru_pengujian">Pengujian</label>
                                        @error('tera_baru_pengujian')
                                            <div id="tera_baru_pengujianFeedback" class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    {{-- end::tera_baru_pengujian --}}
                                </div>
                                <div class="col">
                                    {{-- begin::tera_baru_pejustiran --}}
                                    <div class="form-floating mb-5">
                                        <input type="number" class="form-control @error('tera_baru_pejustiran') is-invalid @enderror" name="tera_baru_pejustiran" id="tera_baru_pejustiran2" placeholder="Pejustiran" value="{{ old('tera_baru_pejustiran') }}" min="0" required />
                                        <label for="tera_baru_pejustiran">Pejustiran</label>
                                        @error('tera_baru_pejustiran')
                                            <div id="tera_baru_pejustiranFeedback" class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    {{-- end::tera_baru_pejustiran --}}
                                </div>
                            </div>
                        </div>
                        {{-- end:: Tera Baru --}}

                        {{-- begin:: Tera Ulang --}}
                        <div class="mt-2">
                            <label for="">Tera Ulang</label>
                            <div class="row p-2">
                                <div class="col">
                                    {{-- begin::tera_ulang_pengujian --}}
                                    <div class="form-floating mb-5">
                                        <input type="number" class="form-control @error('tera_ulang_pengujian') is-invalid @enderror" name="tera_ulang_pengujian" id="tera_ulang_pengujian2" placeholder="Pengujian" value="{{ old('tera_ulang_pengujian') }}" min="0" required />
                                        <label for="tera_ulang_pengujian">Pengujian</label>
                                        @error('tera_ulang_pengujian')
                                            <div id="tera_ulang_pengujianFeedback" class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    {{-- end::tera_ulang_pengujian --}}
                                </div>
                                <div class="col">
                                    {{-- begin::tera_ulang_pejustiran --}}
                                    <div class="form-floating mb-5">
                                        <input type="number" class="form-control @error('tera_ulang_pejustiran') is-invalid @enderror" name="tera_ulang_pejustiran" id="tera_ulang_pejustiran2" placeholder="Pejustiran" value="{{ old('tera_ulang_pejustiran') }}" min="0" required />
                                        <label for="tera_ulang_pejustiran">Pejustiran</label>
                                        @error('tera_ulang_pejustiran')
                                            <div id="tera_ulang_pejustiranFeedback" class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    {{-- end::tera_ulang_pejustiran --}}
                                </div>
                            </div>
                        </div>
                        {{-- end:: Tera Ulang --}}

                        {{-- begin::tarif_per_jam --}}
                        <div class="form-floating mb-5">
                            <input type="number" class="form-control @error('tarif_per_jam') is-invalid @enderror" name="tarif_per_jam" id="tarif_per_jam2" placeholder="Tarif Per Jam" value="{{ old('tarif_per_jam') }}" min="0" required />
                            <label for="tarif_per_jam">Tarif Per Jam</label>
                            @error('tarif_per_jam')
                                <div id="tarif_per_jamFeedback" class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        {{-- end::tarif_per_jam --}}
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal"><i class="fa-solid fa-times"></i>Batal</button>
                        <button type="submit" class="btn btn-info"><i class="fa-solid fa-save"></i>Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- end::modal-add --}}
@endpush
{{-- modal::end --}}

@push('scripts')
    {{-- JS CUSTOM --}}
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
            "ajax": "{!! route('set.apps.mst.ins.uttp.item.data') !!}",
            "columns": [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'no_urut',
                    name: 'no_urut'
                },
                {
                    data: 'nama_instrumen',
                    name: 'nama_instrumen'
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
                    className: "text-center w-80px",
                    targets: [1]
                },
                {
                    className: "min-w-400px",
                    targets: [2]
                },
                {
                    className: "text-end",
                    targets: [4]
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
                        url: "{!! route('set.apps.mst.ins.uttp.item.destroy') !!}",
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
                url: "{!! route('set.apps.mst.ins.uttp.item.status') !!}",
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
                $("#modal_title").html("Form Tambah Item UTTP");
                $("#formTagsKelompok").trigger("reset");
            }
        });
    </script>
@endpush
