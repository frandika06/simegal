@extends('layouts.admin.settings')
@push('apps')
    SIMEGAL
@endpush
@push('title')
    Super Admin | Pengaturan Aplikasi | SIMEGAL
@endpush
@push('description')
    Super Admin | Pengaturan Aplikasi | Sistem Informasi Metrologi Legal Pemerintah Kabupaten Tangerang
@endpush
@push('header-title')
    Super Admin | Pengaturan Aplikasi
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
                <h1 class="d-flex text-dark fw-bold my-1 fs-3">Super Admin</h1>
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
                    <li class="breadcrumb-item text-dark">Super Admin</li>
                    {{-- end::Item --}}
                </ul>
                {{-- end::Breadcrumb --}}
            </div>
            {{-- end::Page title --}}
            @if (\CID::subRoleAdmin() == true)
                {{-- begin::Actions --}}
                <div class="d-flex align-items-center py-2 py-md-1">
                    <a href="javascript:void(0);" class="btn btn-info fw-bold" data-bs-toggle="modal" data-bs-target="#add_super_admin" data-mode="add"><i class="fa-solid fa-plus"></i>Tambah Super Admin</a>
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
                                    <th>Nama</th>
                                    <th>Jabatan</th>
                                    <th>Kontak</th>
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
    <div class="modal fade add" tabindex="-1" id="add_super_admin">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('set.apps.mst.sa.store') }}" method="POST" id="formSuperAdmin" enctype="multipart/form-data">
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

                        {{-- begin::nama_lengkap --}}
                        <div class="form-floating mb-5">
                            <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror" name="nama_lengkap" id="nama_lengkap2" placeholder="Nama Lengkap" autocomplete="off" maxlength="100" value="{{ old('nama_lengkap') }}" required />
                            <label for="nama_lengkap">Nama Lengkap</label>
                            @error('nama_lengkap')
                                <div id="nama_lengkapFeedback" class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        {{-- end::nama_lengkap --}}

                        {{-- begin::nip --}}
                        <div class="form-floating mb-5">
                            <input type="number" class="form-control @error('nip') is-invalid @enderror" name="nip" id="nip2" placeholder="NIP" autocomplete="off" maxlength="100" value="{{ old('nip') }}" required />
                            <label for="nip">NIP</label>
                            <div class="form-text">Masukkan angka nol (0) jika Non ASN.</div>
                            @error('nip')
                                <div id="nipFeedback" class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        {{-- end::nip --}}

                        {{-- begin::pangkat_golongan --}}
                        <div class="form-floating mb-5">
                            <input type="text" class="form-control @error('pangkat_golongan') is-invalid @enderror" name="pangkat_golongan" id="Pangkat/Golongan" placeholder="pangkat_golongan" autocomplete="off" maxlength="100" value="{{ old('pangkat_golongan') }}" required />
                            <label for="pangkat_golongan">Pangkat/Golongan</label>
                            @error('pangkat_golongan')
                                <div id="pangkat_golonganFeedback" class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        {{-- end::pangkat_golongan --}}

                        {{-- begin::jabatan --}}
                        <div class="form-floating mb-5">
                            <input type="text" class="form-control @error('jabatan') is-invalid @enderror" name="jabatan" id="Jabatan" placeholder="jabatan" autocomplete="off" maxlength="100" value="{{ old('jabatan') }}" required />
                            <label for="jabatan">Jabatan</label>
                            @error('jabatan')
                                <div id="jabatanFeedback" class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        {{-- end::pangkat_golongan --}}

                        {{-- begin::jenis_kelamin --}}
                        <div class="form-floating mb-5">
                            <select class="form-control @error('jenis_kelamin') is-invalid @enderror" name="jenis_kelamin" id="jenis_kelamin" required>
                                <option value="" selected disabled>-Pilih Jenis Kelamin</option>
                                <option value="L" @if (old('jenis_kelamin') == 'L') selected @endif>Laki-laki</option>
                                <option value="P" @if (old('jenis_kelamin') == 'P') selected @endif>Perempuan</option>
                            </select>
                            <label for="jenis_kelamin">Jenis Kelamin</label>
                            @error('jenis_kelamin')
                                <div id="jenis_kelaminFeedback" class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        {{-- end::jenis_kelamin --}}

                        {{-- begin::email --}}
                        <div class="form-floating mb-5">
                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email2" placeholder="Email" autocomplete="off" maxlength="100" value="{{ old('email') }}" required />
                            <label for="email">Email</label>
                            @error('email')
                                <div id="emailFeedback" class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        {{-- end::email --}}

                        {{-- begin::no_telp --}}
                        <div class="form-floating mb-5">
                            <input type="number" class="form-control @error('no_telp') is-invalid @enderror" name="no_telp" id="no_telp2" placeholder="No. Telp/HP" autocomplete="off" maxlength="15" value="{{ old('no_telp') }}" required />
                            <label for="no_telp">No. Telp/HP</label>
                            @error('no_telp')
                                <div id="no_telpFeedback" class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        {{-- end::no_telp --}}

                        {{-- begin::foto --}}
                        <div class="form-floating mb-5">
                            <input type="file" class="form-control @error('foto') is-invalid @enderror" name="foto" id="foto2" accept=".png,.jpg,.jpeg" />
                            <label for="foto">Foto</label>
                            <div class="form-text">File yang diizinkan: png, jpg, jpeg. | Maksimal: 1 MB</div>
                            @error('foto')
                                <div id="fotoFeedback" class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        {{-- end::foto --}}

                        <div class='separator separator-dashed my-10'></div>
                        <h3>Buat Akun Login</h3>

                        {{-- begin::username --}}
                        <div class="form-floating mb-5">
                            <input type="text" class="form-control @error('username') is-invalid @enderror" name="username" id="username2" placeholder="Username" autocomplete="off" maxlength="100" value="{{ old('username') }}" required />
                            <label for="username">Username</label>
                            @error('username')
                                <div id="usernameFeedback" class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        {{-- end::username --}}

                        {{-- begin::password --}}
                        <div class="form-floating mb-5">
                            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password2" placeholder="Password" autocomplete="off" maxlength="100" value="{{ old('password') }}" required />
                            <label for="password">Password</label>
                            @error('password')
                                <div id="passwordFeedback" class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        {{-- end::password --}}
                        @error('sub_role')
                            <div id="sub_roleFeedback" class="text-danger">Hak Akses Wajib Dipilih Minimal 1.</div>
                        @enderror
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
            "ajax": "{!! route('set.apps.mst.sa.data') !!}",
            "columns": [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'nama_lengkap',
                    name: 'nama_lengkap'
                },
                {
                    data: 'jabatan',
                    name: 'jabatan'
                },
                {
                    data: 'kontak',
                    name: 'kontak'
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
                    className: "min-w-80px",
                    targets: [1]
                },
                {
                    className: "min-w-200px",
                    targets: [3]
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
                        url: "{!! route('set.apps.mst.sa.destroy') !!}",
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
                url: "{!! route('set.apps.mst.sa.status') !!}",
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
        $('a[data-bs-target^="#add_super_admin"]').click(function() {
            var mode = $(this).data("mode");
            if (mode == "add") {
                $("#modal_title").html("Form Tambah Super Admin");
                $("#formSuperAdmin").trigger("reset");
            }
        });
    </script>
@endpush
