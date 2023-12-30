@extends('layouts.admin.settings')
@push('apps')
    SIMEGAL
@endpush
@push('title')
    Manajemen Dokumentasi | Tindak Lanjut | SIMEGAL
@endpush
@push('description')
    Manajemen Dokumentasi | Tindak Lanjut | Sistem Informasi Metrologi Legal Pemerintah Kabupaten Tangerang
@endpush
@push('header-title')
    Manajemen Dokumentasi | Tindak Lanjut
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
                <h1 class="d-flex text-dark fw-bold my-1 fs-3">Manajemen Dokumentasi</h1>
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
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('scd.apps.tinjut.' . $jenis_uttp . '.index') }}" class="text-muted text-hover-primary">Tindak Lanjut</a>
                    </li>
                    {{-- end::Item --}}
                    {{-- begin::Item --}}
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-200 w-5px h-2px"></span>
                    </li>
                    {{-- end::Item --}}
                    {{-- begin::Item --}}
                    <li class="breadcrumb-item text-dark">Manajemen Dokumentasi</li>
                    {{-- end::Item --}}
                </ul>
                {{-- end::Breadcrumb --}}
            </div>
            {{-- end::Page title --}}
            {{-- begin::Actions --}}
            <div class="d-flex align-items-center py-2 py-md-1">
                {{-- begin::Button --}}
                <a href="{{ route('scd.apps.tinjut.' . $jenis_uttp . '.index') }}" class="btn btn-dark btn-sm btn-icon"><i class="fa-solid fa-chevron-left"></i></a>
                {{-- end::Button --}}
            </div>
            {{-- end::Actions --}}
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
            {{-- begin::Layout --}}
            <div class="d-flex flex-column flex-lg-row">

                {{-- begin::Sidebar --}}
                <div class="flex-column flex-lg-row-auto w-lg-250px w-xl-350px mb-10">
                    {{-- begin::Card --}}
                    <div class="card mb-5 mb-xl-8">
                        {{-- begin::Card body --}}
                        <div class="card-body">
                            {{-- begin::Summary --}}
                            {{-- begin::User Info --}}
                            <div class="d-flex flex-center flex-column py-5">
                                {{-- begin::Avatar --}}
                                <div class="symbol symbol-100px symbol-circle mb-7">
                                    <img src="{{ \CID::pp() }}" alt="{{ $profile->nama_perusahaan }}" />
                                </div>
                                {{-- end::Avatar --}}
                                {{-- begin::Name --}}
                                <p class="fs-3 text-gray-800 fw-bold mb-3">{{ $profile->nama_perusahaan }}</p>
                                {{-- end::Name --}}
                                {{-- begin::Position --}}
                                <div class="mb-9">
                                    {{-- begin::Badge --}}
                                    <div class="badge Dokumentasidge-lg Dokumentasidge-light-info d-inline">{{ $profile->jenis_perusahaan }}</div>
                                    {{-- begin::Badge --}}
                                </div>
                                {{-- end::Position --}}
                            </div>
                            {{-- end::User Info --}}
                            {{-- end::Summary --}}
                            {{-- begin::Details toggle --}}
                            <div class="d-flex flex-stack fs-4 py-3">
                                <div class="fw-bold rotate" data-bs-toggle="collapse" href="#kt_informasi" role="button" aria-expanded="false" aria-controls="kt_informasi">Detail Perusahaan
                                    <span class="ms-2 rotate-180">
                                        <i class="ki-duotone ki-down fs-3"></i>
                                    </span>
                                </div>
                            </div>
                            {{-- end::Details toggle --}}
                            <div class="separator"></div>
                            {{-- begin::Details content --}}
                            <div id="kt_informasi" class="collapse">
                                <div class="pb-5 fs-6">
                                    {{-- begin::Details item --}}
                                    <div class="fw-bold mt-5">Kode Akun</div>
                                    <div class="text-gray-600">{{ $profile->kode_perusahaan }}</div>
                                    {{-- begin::Details item --}}
                                    {{-- begin::Details item --}}
                                    <div class="fw-bold mt-5">NPWP</div>
                                    <div class="text-gray-600">{{ $profile->npwp }}</div>
                                    {{-- begin::Details item --}}
                                    {{-- begin::Details item --}}
                                    <div class="fw-bold mt-5">Email</div>
                                    <div class="text-gray-600">{{ $profile->email }}</div>
                                    {{-- begin::Details item --}}
                                    {{-- begin::Details item --}}
                                    <div class="fw-bold mt-5">No. Telp 1</div>
                                    <div class="text-gray-600">{{ $profile->no_telp_1 }}</div>
                                    {{-- begin::Details item --}}
                                    {{-- begin::Details item --}}
                                    <div class="fw-bold mt-5">No. Telp 2</div>
                                    <div class="text-gray-600">{{ $profile->no_telp_2 }}</div>
                                    {{-- begin::Details item --}}
                                    {{-- begin::Details item --}}
                                    <div class="fw-bold mt-5">Nama PIC</div>
                                    <div class="text-gray-600">{{ $profile->nama_pic }}</div>
                                    {{-- begin::Details item --}}
                                    {{-- begin::Details item --}}
                                    <div class="fw-bold mt-5">Terakhir Login</div>
                                    <div class="text-gray-600">{{ \CID::TglJam($profile->RelUser->last_seen) }}</div>
                                    {{-- begin::Details item --}}
                                </div>
                            </div>
                            {{-- end::Details content --}}

                            {{-- begin::Details toggle --}}
                            <div class="d-flex flex-stack fs-4 py-3">
                                <div class="fw-bold rotate" data-bs-toggle="collapse" href="#kt_permohonan" role="button" aria-expanded="false" aria-controls="kt_permohonan">Detail Permohonan
                                    <span class="ms-2 rotate-180">
                                        <i class="ki-duotone ki-down fs-3"></i>
                                    </span>
                                </div>
                            </div>
                            {{-- end::Details toggle --}}
                            <div class="separator"></div>
                            {{-- begin::Details content --}}
                            <div id="kt_permohonan" class="collapse">
                                <div class="pb-5 fs-6">
                                    {{-- begin::Details item --}}
                                    <div class="fw-bold mt-5">Kode Permohonan</div>
                                    <div class="text-gray-600">{{ $permohonan->kode_permohonan }}</div>
                                    {{-- begin::Details item --}}
                                    {{-- begin::Details item --}}
                                    <div class="fw-bold mt-5">Nama Pengujian</div>
                                    <div class="text-gray-600">{{ $permohonan->jenis_pengujian }}</div>
                                    {{-- begin::Details item --}}
                                    {{-- begin::Details item --}}
                                    <div class="fw-bold mt-5">Nomor Surat Permohonan</div>
                                    <div class="text-gray-600">{{ $permohonan->nomor_surat_permohonan }}</div>
                                    {{-- begin::Details item --}}
                                    {{-- begin::Details item --}}
                                    <div class="fw-bold mt-5">Tgl. Permohonan Peneraan</div>
                                    <div class="text-gray-600">{{ \CID::tglSimple($permohonan->tanggal_permohonan) }}</div>
                                    {{-- begin::Details item --}}
                                    {{-- begin::Details item --}}
                                    <div class="fw-bold mt-5">Lokasi Peneraan</div>
                                    <div class="text-gray-600">{{ $permohonan->lokasi_peneraan }}</div>
                                    {{-- begin::Details item --}}
                                    {{-- begin::Details item --}}
                                    <div class="fw-bold mt-5">Alamat Peneraan</div>
                                    <div class="text-gray-600">
                                        @if ($permohonan->lokasi_peneraan == 'Dalam Kantor Metrologi')
                                            Bidang Metrologi Legal, Kec. Dokumentasilaraja, Kabupaten Tangerang, Dokumentasinten, 15610.
                                        @else
                                            {{ $RelAlamat->alamat }}, {{ isset($RelAlamat->rt) ? 'RT. ' . $RelAlamat->rt . ', ' : '' }}
                                            {{ isset($RelAlamat->rw) ? 'RW. ' . $RelAlamat->rw . ', ' : '' }}
                                            {{ \Str::title($RelAlamat->Desa->name) }}, {{ \Str::title($RelAlamat->Kecamatan->name) }},
                                            {{ \Str::title($RelAlamat->Kabupaten->name) }}, {{ \Str::title($RelAlamat->Provinsi->name) }}{{ isset($RelAlamat->kode_pos) ? ', ' . $RelAlamat->kode_pos . '.' : '.' }}
                                        @endif
                                    </div>
                                    {{-- begin::Details item --}}
                                    @if ($permohonan->lokasi_peneraan == 'Luar Kantor Metrologi' && ($RelAlamat->google_maps != '' || ($RelAlamat->lat != '' && $RelAlamat->long != '')))
                                        @if ($RelAlamat->google_maps != '')
                                            @php
                                                $url_maps = $RelAlamat->google_maps;
                                            @endphp
                                        @elseif($RelAlamat->lat != '' && $RelAlamat->long != '')
                                            @php
                                                $url_maps = 'https://www.google.com/maps/search/?api=1&query=' . $RelAlamat->lat . ',' . $RelAlamat->long . '';
                                            @endphp
                                        @endif
                                        {{-- begin::Details item --}}
                                        <div class="fw-bold mt-5">Link Google Maps</div>
                                        <div class="text-gray-600">
                                            <a target="_BLANK" href="{{ $url_maps }}" class="menu-link px-3"><i class="fa-solid fa-map-location-dot me-2"></i> Maps</a>
                                        </div>
                                        {{-- begin::Details item --}}
                                    @endif
                                </div>
                            </div>
                            {{-- end::Details content --}}
                        </div>
                        {{-- end::Card body --}}
                    </div>
                    {{-- end::Card --}}
                </div>
                {{-- end::Sidebar --}}

                {{-- begin::Content --}}
                <div class="flex-lg-row-fluid ms-lg-15">

                    @if ($permohonan->status != 'Selesai' && \CID::subRoleOnlyPetugas() == true)
                        {{-- begin::Card --}}
                        <div class="card pt-4 mb-5 mb-xl-8">
                            {{-- begin::Card header --}}
                            <div class="card-header border-0">
                                {{-- begin::Card title --}}
                                <div class="card-title flex-column">
                                    <h2>Form Upload Dokumentasi</h2>
                                    <div class="fs-6 fw-semibold text-muted mt-2">Halaman untuk upload data Dokumentasi dari permohonan dengan Nomor Order: <strong>{{ $data->nomor_order }}</strong>.</div>
                                </div>
                                {{-- end::Card title --}}
                            </div>
                            {{-- end::Card header --}}
                            {{-- begin::Card body --}}
                            <div class="card-body">
                                {{-- begin::Form --}}
                                <form action="{{ route('scd.apps.tinjut.action.dok.store', [$tags_jp, $enc_uuid]) }}" class="form" enctype="multipart/form-data" method="POST">
                                    @csrf
                                    {{-- hidden --}}
                                    <input type="hidden" name="uuid_update" id="uuid_update" value="">

                                    {{-- begin::nomor_order --}}
                                    <div class="form-floating mb-5">
                                        <input type="text" class="form-control bg-light-info" name="nomor_order" id="nomor_order2" value="{{ $data->nomor_order }}" readonly />
                                        <label for="nomor_order">Nomor Order</label>
                                    </div>
                                    {{-- end::nomor_order --}}

                                    {{-- begin::kelompok_uttp --}}
                                    <div class="form-floating mb-5">
                                        <input type="text" class="form-control bg-light-info" name="kelompok_uttp" id="kelompok_uttp2" value="{{ $data->RelMasterKelompokUttp->nama_kelompok }}" readonly />
                                        <label for="kelompok_uttp">Kelompok UTTP</label>
                                    </div>
                                    {{-- end::kelompok_uttp --}}

                                    {{-- begin::Repeater --}}
                                    <div class="" id="repeat_dokumentasi">
                                        {{-- begin::Form group --}}
                                        <div class="form-group">
                                            <div data-repeater-list="repeat_dokumentasi">
                                                <div data-repeater-item>
                                                    <div class="alert alert-secondary">
                                                        <div class="form-group row mb-5">
                                                            <div class="col-12 mb-5">
                                                                {{-- begin::nama_dokumentasi --}}
                                                                <div class="form-floating mb-3 mt-3">
                                                                    <input type="text" class="form-control nama_dokumentasi @error('nama_dokumentasi') is-invalid @enderror" name="nama_dokumentasi" id="nama_dokumentasi2" placeholder="Nama Dokumentasi" maxlength="300" autocomplete="off"
                                                                        required />
                                                                    <label for="nama_dokumentasi">Nama Dokumentasi</label>
                                                                    @error('nama_dokumentasi')
                                                                        <div id="nama_dokumentasiFeedback" class="invalid-feedback">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                                {{-- end::nama_dokumentasi --}}
                                                            </div>
                                                            <div class="col">
                                                                {{-- begin::file_dokumentasi --}}
                                                                <div class="form-floating">
                                                                    <input type="file" class="form-control file_dokumentasi @error('file_dokumentasi') is-invalid @enderror" name="file_dokumentasi" id="file_dokumentasi2" data-prop="file_dokumentasi" accept=".jpg,.jpeg,.png" required />
                                                                    <label for="file_dokumentasi">File Dokumentasi</label>
                                                                    <div class="form-text">File yang diizinkan: jpg, jpeg, png. | Maksimal: 5 MB</div>
                                                                    @error('file_dokumentasi')
                                                                        <div id="file_dokumentasiFeedback" class="invalid-feedback">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                                {{-- end::file_dokumentasi --}}
                                                            </div>
                                                            <div class="col-md-2">
                                                                <a href="javascript:;" data-repeater-delete class="btn btn-outline btn-light-danger">
                                                                    <i class="ki-duotone ki-trash fs-5"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- begin::Form group --}}
                                            <div class="form-group mt-5">
                                                <a href="javascript:;" data-repeater-create class="btn btn-light-primary">
                                                    <i class="ki-duotone ki-plus fs-3"></i>
                                                    Add
                                                </a>
                                            </div>
                                            {{-- end::Form group --}}
                                        </div>
                                        {{-- end::Form group --}}
                                    </div>
                                    {{-- end::Repeater --}}

                                    {{-- begin::edit --}}
                                    <div class="d-none" id="edit_dokumentasi">
                                        {{-- begin::edit_nama_dokumentasi --}}
                                        <div class="form-floating mb-5">
                                            <input type="text" class="form-control @error('edit_nama_dokumentasi') is-invalid @enderror" name="edit_nama_dokumentasi" id="edit_nama_dokumentasi2" placeholder="Nama Dokumentasi" maxlength="300" autocomplete="off" required />
                                            <label for="edit_nama_dokumentasi">Nama Dokumentasi</label>
                                            @error('edit_nama_dokumentasi')
                                                <div id="edit_nama_dokumentasiFeedback" class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        {{-- end::edit_nama_dokumentasi --}}

                                        {{-- begin::edit_file_dokumentasi --}}
                                        <div class="form-floating">
                                            <input type="file" class="form-control @error('edit_file_dokumentasi') is-invalid @enderror" name="edit_file_dokumentasi" id="edit_file_dokumentasi2" data-prop="edit_file_dokumentasi" accept=".jpg,.jpeg,.png" required />
                                            <label for="edit_file_dokumentasi">File Dokumentasi</label>
                                            <div class="form-text">File yang diizinkan: jpg, jpeg, png. | Maksimal: 5 MB</div>
                                            @error('edit_file_dokumentasi')
                                                <div id="edit_file_dokumentasiFeedback" class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        {{-- end::edit_file_dokumentasi --}}
                                    </div>
                                    {{-- end::edit --}}

                                    {{-- begin::Action buttons --}}
                                    <div class="d-flex justify-content-end align-items-center mt-12">
                                        {{-- begin::Button --}}
                                        <a href="{{ route('scd.apps.tinjut.action.dok.index', [$tags_jp, $enc_uuid]) }}" class="btn btn-secondary d-none me-2" id="batal"><i class="fa-solid fa-times"></i>Batal</a>
                                        <button type="submit" class="btn btn-info"><i class="fa-solid fa-save"></i>Simpan</button>
                                        {{-- end::Button --}}
                                    </div>
                                    {{-- begin::Action buttons --}}
                                </form>
                                {{-- end::Form --}}
                            </div>
                            {{-- end::Card body --}}
                            {{-- begin::Card footer --}}
                            {{-- end::Card footer --}}
                        </div>
                        {{-- end::Card --}}
                    @endif

                    {{-- begin::Card --}}
                    <div class="card pt-4 mb-6 mb-xl-9">
                        {{-- begin::Card header --}}
                        <div class="card-header border-0">
                            {{-- begin::Card title --}}
                            <div class="card-title">
                                <h2>Data File Dokumentasi</h2>
                            </div>
                            {{-- end::Card title --}}
                        </div>
                        {{-- end::Card header --}}
                        {{-- begin::Card body --}}
                        <div class="card-body pt-0 pb-5">
                            {{-- begin::Table wrapper --}}
                            <div class="table-responsive">
                                {{-- begin::Table --}}
                                <table id="datatable" class="table table-striped table-hover table-row-bordered gy-5 gs-7 border rounded">
                                    <thead class="border-bottom border-gray-200 fs-7 fw-bold">
                                        <tr class="text-start text-muted text-uppercase gs-0">
                                            <th>#</th>
                                            <th>Nama Dokumentasi</th>
                                            <th>Size</th>
                                            <th>Tipe</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="fs-6 fw-semibold text-gray-600">
                                        @php
                                            $i = 1;
                                        @endphp
                                        @foreach ($RelFileDokumentasi as $item)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>
                                                    <a target="_BLANK" href="{{ \CID::ViewImg($item->file_dokumentasi) }}">{{ $item->nama_dokumentasi }}</a>
                                                </td>
                                                <td>{{ \CID::SizeDisk($item->size) }}</td>
                                                <td>{{ \Str::upper($item->tipe) }}</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-light btn-info btn-flex btn-center btn-sm dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"></button>
                                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                            <li><a class="dropdown-item" href="{{ route('exdown.unduh.dok', [$item->uuid]) }}"><i class="fa-solid fa-download me-2"></i> Unduh File</a></li>
                                                            @if ($permohonan->status != 'Selesai' && \CID::subRoleOnlyPetugas() == true)
                                                                <li><a class="dropdown-item" href="javascript:void(0);" data-edit="{{ \CID::encode($item->uuid) }}"><i class="fa-solid fa-edit me-2"></i> Edit File</a></li>
                                                                <li><a class="dropdown-item" href="javascript:void(0);" data-hapus="{{ \CID::encode($item->uuid) }}"><i class="fa-solid fa-trash me-2"></i> Hapus File</a></li>
                                                            @else
                                                                <li><a class="dropdown-item" href="javascript:void(0);" data-detail="{{ \CID::encode($item->uuid) }}"><i class="fa-solid fa-eye me-2"></i> Detail File</a></li>
                                                            @endif
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{-- end::Table --}}
                            </div>
                            {{-- end::Table wrapper --}}
                        </div>
                        {{-- end::Card body --}}
                    </div>
                    {{-- end::Card --}}

                    {{-- begin::Card --}}
                    <div class="card pt-4 mb-5 mb-xl-8 d-none" id="detail">
                        {{-- begin::Card header --}}
                        <div class="card-header border-0">
                            {{-- begin::Card title --}}
                            <div class="card-title flex-column">
                                <h2>Detail File Dokumentasi</h2>
                                <div class="fs-6 fw-semibold text-muted mt-2">Lihat detail data Dokumentasi dari permohonan dengan Nomor Order: <strong>{{ $data->nomor_order }}</strong>.</div>
                            </div>
                            {{-- end::Card title --}}
                        </div>
                        {{-- end::Card header --}}
                        {{-- begin::Card body --}}
                        <div class="card-body">
                            {{-- begin::nomor_order --}}
                            <div class="form-floating mb-5">
                                <input type="text" class="form-control bg-light-info" name="nomor_order" id="nomor_order2" value="{{ $data->nomor_order }}" readonly />
                                <label for="nomor_order">Nomor Order</label>
                            </div>
                            {{-- end::nomor_order --}}

                            {{-- begin::kelompok_uttp --}}
                            <div class="form-floating mb-5">
                                <input type="text" class="form-control bg-light-info" name="kelompok_uttp" id="kelompok_uttp2" value="{{ $data->RelMasterKelompokUttp->nama_kelompok }}" readonly />
                                <label for="kelompok_uttp">Kelompok UTTP</label>
                            </div>
                            {{-- end::kelompok_uttp --}}

                            {{-- begin::detail_nama_dokumentasi --}}
                            <div class="form-floating mb-5">
                                <input type="text" class="form-control bg-light-info" name="detail_nama_dokumentasi" id="detail_nama_dokumentasi" value="" readonly />
                                <label for="detail_nama_dokumentasi">Nama Dokumentasi</label>
                            </div>
                            {{-- end::detail_nama_dokumentasi --}}

                            {{-- begin::file_dokumentasi --}}
                            <div class="mb-5">
                                <img id="img_viewer" src="" alt="view-dokumentasi" style="width:100%;height:auto;" draggable="false" />
                            </div>
                            {{-- end::file_dokumentasi --}}

                            {{-- begin::Action buttons --}}
                            <div class="d-flex justify-content-end align-items-center mt-12">
                                {{-- begin::Button --}}
                                <a href="{{ route('scd.apps.tinjut.action.dok.index', [$tags_jp, $enc_uuid]) }}" class="btn btn-secondary me-2" id="detail_dokumentasital"><i class="fa-solid fa-times"></i>Tutup</a>
                                {{-- end::Button --}}
                            </div>
                            {{-- begin::Action buttons --}}
                        </div>
                        {{-- end::Card body --}}
                    </div>
                    {{-- end::Card --}}
                </div>
                {{-- end::Content --}}

            </div>
            {{-- end::Layout --}}
        </div>
        {{-- end::Container --}}
    </div>
    {{-- end::Post --}}
@endsection
{{-- CONTENT::END --}}

@push('scripts')
    {{-- LINK JS --}}
    <script src="{{ asset('assets-apps/plugins/custom/formrepeater/formrepeater.bundle.js') }}"></script>
    {{-- CUTOM JS --}}
    {{-- datatable --}}
    <script>
        $('#datatable').DataTable();
    </script>
    {{-- edit --}}
    <script>
        $(document).on('click', "[data-edit]", function() {
            let uuid = $(this).attr('data-edit');
            $.ajax({
                url: "{!! route('ajax.scd.apps.form.get.file.dok') !!}",
                type: 'POST',
                data: {
                    uuid: uuid,
                    _method: 'post',
                    _token: "{{ csrf_token() }}"
                },
                success: function(res) {
                    console.log(res.data);
                    $('#uuid_update').val(res.data.uuid);
                    $("#edit_nama_dokumentasi2").val(res.data.nama_dokumentasi);
                    $("[data-prop='edit_file_dokumentasi']").prop('required', false);
                    $("#repeat_dokumentasi").addClass("d-none");
                    $("#edit_dokumentasi").removeClass("d-none");
                    $("#batal").removeClass("d-none");
                    $(".nama_dokumentasi").prop('required', false);
                    $(".file_dokumentasi").prop('required', false);
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
        });
    </script>
    {{-- detail --}}
    <script>
        $(document).on('click', "[data-detail]", function() {
            let uuid = $(this).attr('data-detail');
            $.ajax({
                url: "{!! route('ajax.scd.apps.form.get.file.dok') !!}",
                type: 'POST',
                data: {
                    uuid: uuid,
                    _method: 'post',
                    _token: "{{ csrf_token() }}"
                },
                success: function(res) {
                    $('#detail').removeClass("d-none");
                    $('#detail_nama_dokumentasi').val(res.data.nama_dokumentasi);
                    $("#detail_keterangan").val(res.data.keterangan);
                    $('#img_viewer').attr("src", res.data.file_dokumentasi);
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
        });
        $(document).on('click', "#detail_dokumentasital", function() {
            let uuid = $(this).attr('data-detail');
            $('#detail').addClass("d-none");
        });
    </script>
    {{-- hapus --}}
    <script>
        $(document).on('click', "[data-hapus]", function() {
            let uuid = $(this).attr('data-hapus');
            Swal.fire({
                title: "Hapus File Dokumentasi",
                text: "Apakah Anda Yakin?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Iya",
                cancelButtonText: 'Tidak',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{!! route('scd.apps.tinjut.action.dok.destroy', [$tags_jp, $enc_uuid]) !!}",
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
    </script>
    {{-- reapeat alat & CTT --}}
    <script>
        $('#repeat_dokumentasi').repeater({
            initEmpty: false,
            defaultValues: {
                'text-input': 'foo'
            },
            show: function() {
                $(this).slideDown();
                $(this).find('select').each(function() {
                    $('.select_test2').removeAttr("id").removeAttr("data-select2-id");
                    $('.select_test2').select2();
                });
            },
            hide: function(deleteElement) {
                $(this).slideUp(deleteElement);
            }
        });
    </script>
@endpush
