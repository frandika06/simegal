@extends('layouts.admin.settings')
@push('apps')
    SIMEGAL
@endpush
@push('title')
    Perusahaan | Pengaturan Aplikasi | SIMEGAL
@endpush
@push('description')
    Perusahaan | Pengaturan Aplikasi | Sistem Informasi Metrologi Legal Pemerintah Kabupaten Tangerang
@endpush
@push('header-title')
    Perusahaan | Pengaturan Aplikasi
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
                <h1 class="d-flex text-dark fw-bold my-1 fs-3">Perusahaan</h1>
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
                    <li class="breadcrumb-item text-muted">Perusahaan</li>
                    {{-- end::Item --}}
                    {{-- begin::Item --}}
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-200 w-5px h-2px"></span>
                    </li>
                    {{-- end::Item --}}
                    {{-- begin::Item --}}
                    <li class="breadcrumb-item text-dark">{{ $tags }}</li>
                    {{-- end::Item --}}
                </ul>
                {{-- end::Breadcrumb --}}
            </div>
            {{-- end::Page title --}}
            @if (\CID::subRoleAdmin() == true)
                {{-- begin::Actions --}}
                <div class="d-flex align-items-center py-2 py-md-1">
                    <a href="javascript:void(0);" class="btn btn-info fw-bold" data-bs-toggle="modal" data-bs-target="#add_perusahaan" data-mode="add"><i class="fa-solid fa-plus"></i>Tambah Perusahaan</a>
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
                                    <th>Kode</th>
                                    <th>Jenis</th>
                                    <th>Nama</th>
                                    <th>NPWP</th>
                                    <th>Kontak</th>
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
    <div class="modal fade add" tabindex="-1" id="add_perusahaan">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('set.apps.perusahaan.store', [$enc_tags]) }}" method="POST" id="formPerusahaan" enctype="multipart/form-data">
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

                        {{-- begin::jenis_perusahaan --}}
                        <div class="form-floating mb-5">
                            <select class="form-control @error('jenis_perusahaan') is-invalid @enderror" name="jenis_perusahaan" id="jenis_perusahaan" required>
                                <option value="" selected disabled>-Pilih Jenis Perusahaan</option>
                                <option value="Perusahaan" @if (old('jenis_perusahaan') == 'Perusahaan') selected @endif>Perusahaan</option>
                                <option value="Pemilik UTTP" @if (old('jenis_perusahaan') == 'Pemilik UTTP') selected @endif>Pemilik UTTP</option>
                            </select>
                            <label for="jenis_perusahaan">Jenis Perusahaan</label>
                            @error('jenis_perusahaan')
                                <div id="jenis_perusahaanFeedback" class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        {{-- end::jenis_perusahaan --}}

                        {{-- begin::nama_perusahaan --}}
                        <div class="form-floating mb-5">
                            <input type="text" class="form-control @error('nama_perusahaan') is-invalid @enderror" name="nama_perusahaan" id="nama_perusahaan2" placeholder="Nama Perusahaan" autocomplete="off" maxlength="100" value="{{ old('nama_perusahaan') }}" required />
                            <label for="nama_perusahaan">Nama Perusahaan</label>
                            @error('nama_perusahaan')
                                <div id="nama_perusahaanFeedback" class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        {{-- end::nama_perusahaan --}}

                        {{-- begin::nama_pic --}}
                        <div class="form-floating mb-5">
                            <input type="text" class="form-control @error('nama_pic') is-invalid @enderror" name="nama_pic" id="nama_pic2" placeholder="Nama PIC" autocomplete="off" maxlength="100" value="{{ old('nama_pic') }}" required />
                            <label for="nama_pic">Nama PIC</label>
                            @error('nama_pic')
                                <div id="nama_picFeedback" class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        {{-- end::nama_pic --}}

                        {{-- begin::npwp --}}
                        <div class="form-floating mb-5">
                            <input type="text" class="form-control npwp @error('npwp') is-invalid @enderror" name="npwp" id="npwp2" placeholder="NPWP Perusahaan" autocomplete="off" maxlength="100" value="{{ old('npwp') }}" required />
                            <label for="npwp">NPWP Perusahaan</label>
                            @error('npwp')
                                <div id="npwpFeedback" class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        {{-- end::npwp --}}

                        {{-- begin::email --}}
                        <div class="form-floating mb-5">
                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email2" placeholder="Email" autocomplete="off" maxlength="100" value="{{ old('email') }}" required />
                            <label for="email">Email</label>
                            @error('email')
                                <div id="emailFeedback" class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        {{-- end::email --}}

                        {{-- begin::no_telp_1 --}}
                        <div class="form-floating mb-5">
                            <input type="number" class="form-control @error('no_telp_1') is-invalid @enderror" name="no_telp_1" id="no_telp_12" placeholder="Kontak Telp. Pertama" autocomplete="off" maxlength="15" value="{{ old('no_telp_1') }}" required />
                            <label for="no_telp_1">Kontak Telp. Pertama</label>
                            @error('no_telp_1')
                                <div id="no_telp_1Feedback" class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        {{-- end::no_telp_1 --}}

                        {{-- begin::no_telp_2 --}}
                        <div class="form-floating mb-5">
                            <input type="number" class="form-control @error('no_telp_2') is-invalid @enderror" name="no_telp_2" id="no_telp_22" placeholder="Kontak Telp. Kedua (Jika Ada)" autocomplete="off" maxlength="15" value="{{ old('no_telp_2') }}" />
                            <label for="no_telp_2">Kontak Telp. Kedua (Jika Ada)</label>
                            @error('no_telp_2')
                                <div id="no_telp_2Feedback" class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        {{-- end::no_telp_2 --}}

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

                        {{-- begin::file_npwp --}}
                        <div class="form-floating mb-5">
                            <input type="file" class="form-control @error('file_npwp') is-invalid @enderror" name="file_npwp" id="file_npwp2" accept=".png,.jpg,.jpeg,.pdf" />
                            <label for="file_npwp">File NPWP</label>
                            <div class="form-text">File yang diizinkan: png, jpg, jpeg, pdf. | Maksimal: 1 MB</div>
                            @error('file_npwp')
                                <div id="file_npwpFeedback" class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        {{-- end::file_npwp --}}

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
            "ajax": "{!! route('set.apps.perusahaan.data', [$enc_tags]) !!}",
            "columns": [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'kode_perusahaan',
                    name: 'kode_perusahaan'
                },
                {
                    data: 'jenis_perusahaan',
                    name: 'jenis_perusahaan'
                },
                {
                    data: 'nama_perusahaan',
                    name: 'nama_perusahaan'
                },
                {
                    data: 'npwp',
                    name: 'npwp'
                },
                {
                    data: 'kontak',
                    name: 'kontak'
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
                    targets: [0, 6]
                },
                {
                    className: "min-w-80px",
                    targets: [1]
                },
                {
                    className: "min-w-200px",
                    targets: [5]
                },
                {
                    className: "text-end",
                    targets: [6]
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
                        url: "{!! route('set.apps.perusahaan.destroy', [$enc_tags]) !!}",
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

        $(document).on('click', "[data-status-aktifkan]", function() {
            let uuid = $(this).attr('data-status-aktifkan');
            Swal.fire({
                title: "Aktifkan Perusahaan",
                text: "Apakah Anda Yakin?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Iya, Aktifkan!",
                cancelButtonText: 'Tidak, Batalkan!',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{!! route('set.apps.perusahaan.status.aktifkan', [$enc_tags]) !!}",
                        type: 'POST',
                        data: {
                            uuid: uuid,
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

        $(document).on('click', "[data-status-tangguhkan]", function() {
            let uuid = $(this).attr('data-status-tangguhkan');
            Swal.fire({
                title: "Tangguhkan Perusahaan",
                text: "Apakah Anda Yakin?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Iya, Tangguhkan!",
                cancelButtonText: 'Tidak, Batalkan!',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{!! route('set.apps.perusahaan.status.tangguhkan', [$enc_tags]) !!}",
                        type: 'POST',
                        data: {
                            uuid: uuid,
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
    </script>

    {{-- input-mask & form --}}
    <script>
        $(document).ready(function() {
            jenisPemohon();
            $('.npwp').mask("99.999.999.9-999.999", {
                placeholder: "99.999.999.9-999.999"
            });
        });

        $("#jenis_perusahaan").change(function() {
            jenisPemohon();
        });

        function jenisPemohon() {
            var jenisPemohon = $("#jenis_perusahaan").val();
            if (jenisPemohon == "Pemilik UTTP") {
                $("label[for='nama_perusahaan']").html("Nama Pemilik UTTP");
                $("label[for='npwp']").html("NPWP Pemilik UTTP");
                $("#nama_perusahaan").attr("placeholder", "Masukkan Nama Pemilik UTTP.");
                $("#npwp").attr("placeholder", "Masukkan NPWP Pemilik UTTP.");
            } else {
                $("label[for='nama_perusahaan']").html("Nama Perusahaan");
                $("label[for='npwp']").html("NPWP Perusahaan");
                $("#nama_perusahaan").attr("placeholder", "Masukkan Nama Perusahaan.");
                $("#npwp").attr("placeholder", "Masukkan NPWP Perusahaan.");
            }
        }
    </script>

    {{-- edit form --}}
    <script>
        $('a[data-bs-target^="#add_perusahaan"]').click(function() {
            var mode = $(this).data("mode");
            if (mode == "add") {
                $("#modal_title").html("Form Tambah Perusahaan");
                $("#formPerusahaan").trigger("reset");
            }
        });
    </script>
@endpush
