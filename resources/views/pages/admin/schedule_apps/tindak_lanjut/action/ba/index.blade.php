@extends('layouts.admin.settings')
@push('apps')
    SIMEGAL
@endpush
@push('title')
    Manajemen BA | Tindak Lanjut | SIMEGAL
@endpush
@push('description')
    Manajemen BA | Tindak Lanjut | Sistem Informasi Metrologi Legal Pemerintah Kabupaten Tangerang
@endpush
@push('header-title')
    Manajemen BA | Tindak Lanjut
@endpush
@push('styles')
    <link rel="stylesheet" href="{{ asset('assets-portal/plugins/pdf-viewer/css/pdfviewer.jquery.css') }}" />
    {{-- SETTING PDF VIEW --}}
    <style>
        .pdf-container {
            max-width: 100%;
            overflow-x: auto;
        }

        canvas {
            display: block;
            margin: 0 auto;
            max-width: 100%;
        }
    </style>
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
                <h1 class="d-flex text-dark fw-bold my-1 fs-3">Manajemen BA</h1>
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
                    <li class="breadcrumb-item text-dark">Manajemen BA</li>
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
                                    <div class="badge badge-lg badge-light-info d-inline">{{ $profile->jenis_perusahaan }}</div>
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
                                    <div class="fw-bold mt-5">Jenis Pengujian</div>
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
                                            Bidang Metrologi Legal, Kec. Balaraja, Kabupaten Tangerang, Banten, 15610.
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
                                    <h2>Form Upload BA</h2>
                                    <div class="fs-6 fw-semibold text-muted mt-2">Halaman untuk upload data BA dari permohonan dengan Nomor Order: <strong>{{ $data->nomor_order }}</strong>.</div>
                                </div>
                                {{-- end::Card title --}}
                            </div>
                            {{-- end::Card header --}}
                            {{-- begin::Card body --}}
                            <div class="card-body">
                                {{-- begin::Form --}}
                                <form action="{{ route('scd.apps.tinjut.action.ba.store', [$tags_jp, $enc_uuid]) }}" class="form" enctype="multipart/form-data" method="POST">
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

                                    {{-- begin::jenis_ba --}}
                                    <div class="mt-0">
                                        <label for="">Pilih Jenis BA</label>
                                        <div class="row p-2">
                                            <div class="col">
                                                {{-- begin::jenis_ba --}}
                                                <div class="form-group mb-5">
                                                    <select class="form-select @error('jenis_ba') is-invalid @enderror" name="jenis_ba" id="jenis_ba" required data-control="select2" data-placeholder="Pilih Jenis BA" required>
                                                        <option value="" selected disabled></option>
                                                        <option value="Berita Acara Peneraan" @if (old('jenis_ba') == 'Berita Acara Peneraan') selected @endif>Berita Acara Peneraan</option>
                                                        <option value="Berita Acara Hasil Pengawasan" @if (old('jenis_ba') == 'Berita Acara Hasil Pengawasan') selected @endif>Berita Acara Hasil Pengawasan</option>
                                                        <option value="Berita Acara BDKT" @if (old('jenis_ba') == 'Berita Acara BDKT') selected @endif>Berita Acara BDKT</option>
                                                    </select>
                                                    @error('jenis_ba')
                                                        <div id="jenis_baFeedback" class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                {{-- end::jenis_ba --}}
                                            </div>
                                        </div>
                                    </div>
                                    {{-- end::jenis_ba --}}

                                    {{-- begin::file_ba --}}
                                    <div class="form-floating mb-5">
                                        <input type="file" class="form-control @error('file_ba') is-invalid @enderror" name="file_ba" id="file_ba2" data-prop="file_ba" accept=".pdf" required />
                                        <label for="file_ba">File BA</label>
                                        <div class="form-text">File yang diizinkan: pdf. | Maksimal: 50 MB</div>
                                        @error('file_ba')
                                            <div id="file_baFeedback" class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    {{-- end::file_ba --}}

                                    {{-- begin::keterangan --}}
                                    <div class="mt-0">
                                        <label for="">Keterangan</label>
                                        <div class="row p-2">
                                            <div class="col">
                                                {{-- begin::keterangan --}}
                                                <div class="form-group">
                                                    <textarea class="form-control @error('keterangan') is-invalid @enderror" name="keterangan" id="keterangan" rows="5">{{ old('keterangan') }}</textarea>
                                                    @error('keterangan')
                                                        <div id="keteranganFeedback" class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                {{-- end::keterangan --}}
                                            </div>
                                        </div>
                                    </div>
                                    {{-- end::keterangan --}}

                                    {{-- begin::Action buttons --}}
                                    <div class="d-flex justify-content-end align-items-center mt-12">
                                        {{-- begin::Button --}}
                                        <a href="{{ route('scd.apps.tinjut.action.ba.index', [$tags_jp, $enc_uuid]) }}" class="btn btn-secondary d-none me-2" id="batal"><i class="fa-solid fa-times"></i>Batal</a>
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
                                <h2>Data File BA</h2>
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
                                            <th>Jenis BA</th>
                                            <th>Size</th>
                                            <th>Tipe</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="fs-6 fw-semibold text-gray-600">
                                        @php
                                            $i = 1;
                                        @endphp
                                        @foreach ($RelFileBa as $item)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>
                                                    <a target="_BLANK" href="{{ \CID::ViewImg($item->file_ba) }}">{{ $item->jenis_ba }}</a>
                                                </td>
                                                <td>{{ \CID::SizeDisk($item->size) }}</td>
                                                <td>{{ \Str::upper($item->tipe) }}</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-light btn-info btn-flex btn-center btn-sm dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"></button>
                                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                            <li><a class="dropdown-item" href="{{ route('exdown.unduh.ba', [$item->uuid]) }}"><i class="fa-solid fa-download me-2"></i> Unduh File</a></li>
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
                                <h2>Detail File BA</h2>
                                <div class="fs-6 fw-semibold text-muted mt-2">Lihat detail data BA dari permohonan dengan Nomor Order: <strong>{{ $data->nomor_order }}</strong>.</div>
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

                            {{-- begin::detail_jenis_ba --}}
                            <div class="form-floating mb-5">
                                <input type="text" class="form-control bg-light-info" name="detail_jenis_ba" id="detail_jenis_ba" value="" readonly />
                                <label for="detail_jenis_ba">Jenis BA</label>
                            </div>
                            {{-- end::detail_jenis_ba --}}

                            {{-- begin::detail_keterangan --}}
                            <div class="form-floating mb-6">
                                <textarea class="form-control bg-light-info min-h-150px" name="detail_keterangan" id="detail_keterangan" readonly></textarea>
                                <label for="detail_keterangan">Keterangan</label>
                            </div>
                            {{-- end::detail_keterangan --}}

                            {{-- begin::file_ba --}}
                            <div class="mb-5">
                                <div id="pdfviewer" class="pdf-container"></div>
                            </div>
                            {{-- end::file_ba --}}

                            {{-- begin::Action buttons --}}
                            <div class="d-flex justify-content-end align-items-center mt-12">
                                {{-- begin::Button --}}
                                <a href="{{ route('scd.apps.tinjut.action.ba.index', [$tags_jp, $enc_uuid]) }}" class="btn btn-secondary me-2" id="detail_batal"><i class="fa-solid fa-times"></i>Tutup</a>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.6.347/pdf.min.js"></script>
    <script src="{{ asset('assets-portal/plugins/pdf-viewer/js/pdfviewer.jquery.js') }}"></script>
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
                url: "{!! route('ajax.scd.apps.form.get.file.ba') !!}",
                type: 'POST',
                data: {
                    uuid: uuid,
                    _method: 'post',
                    _token: "{{ csrf_token() }}"
                },
                success: function(res) {
                    $('#uuid_update').val(res.data.uuid);
                    $('#jenis_ba').val(res.data.jenis_ba).trigger('change');
                    $("#keterangan").val(res.data.keterangan);
                    $("[data-prop='file_ba']").prop('required', false);
                    $("#batal").removeClass("d-none");
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
                url: "{!! route('ajax.scd.apps.form.get.file.ba') !!}",
                type: 'POST',
                data: {
                    uuid: uuid,
                    _method: 'post',
                    _token: "{{ csrf_token() }}"
                },
                success: function(res) {
                    $('#detail').removeClass("d-none");
                    $('#detail_jenis_ba').val(res.data.jenis_ba);
                    $("#detail_keterangan").val(res.data.keterangan);
                    $('#pdfviewer').pdfViewer(res.data.file_ba);
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
        $(document).on('click', "#detail_batal", function() {
            let uuid = $(this).attr('data-detail');
            $('#detail').addClass("d-none");
        });
    </script>
    {{-- hapus --}}
    <script>
        $(document).on('click', "[data-hapus]", function() {
            let uuid = $(this).attr('data-hapus');
            Swal.fire({
                title: "Hapus File BA",
                text: "Apakah Anda Yakin?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Iya",
                cancelButtonText: 'Tidak',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{!! route('scd.apps.tinjut.action.ba.destroy', [$tags_jp, $enc_uuid]) !!}",
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
@endpush
