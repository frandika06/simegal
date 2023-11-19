@extends('layouts.admin.settings')
@push('apps')
    SIMEGAL
@endpush
@push('title')
    {{ $title }} | Jadwal & Penugasan | Manajemen Peneraan | SIMEGAL
@endpush
@push('description')
    {{ $title }} | Jadwal & Penugasan | Manajemen Peneraan | Sistem Informasi Metrologi Legal Pemerintah Kabupaten Tangerang
@endpush
@push('header-title')
    {{ $title }} | Jadwal & Penugasan | Manajemen Peneraan
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
                <h1 class="d-flex text-dark fw-bold my-1 fs-3">Manajemen Peneraan</h1>
                {{-- end::Title --}}
                {{-- begin::Breadcrumb --}}
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 pt-1">
                    {{-- begin::Item --}}
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('scd.apps.home.index') }}" class="text-muted text-hover-primary">Dashboard</a>
                    </li>
                    {{-- end::Item --}}
                    {{-- begin::Item --}}
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-200 w-5px h-2px"></span>
                    </li>
                    {{-- end::Item --}}
                    {{-- begin::Item --}}
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('scd.apps.data.pdp.index') }}" class="text-muted text-hover-primary">Jadwal & Penugasan</a>
                    </li>
                    {{-- end::Item --}}
                    {{-- begin::Item --}}
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-200 w-5px h-2px"></span>
                    </li>
                    {{-- end::Item --}}
                    {{-- begin::Item --}}
                    <li class="breadcrumb-item text-dark">{{ $title }}</li>
                    {{-- end::Item --}}
                </ul>
                {{-- end::Breadcrumb --}}
            </div>
            {{-- end::Page title --}}
            {{-- begin::Actions --}}
            <div class="d-flex align-items-center py-2 py-md-1">
                {{-- begin::Button --}}
                <a href="{{ route('scd.apps.data.pdp.index') }}" class="btn btn-dark btn-sm btn-icon"><i class="fa-solid fa-chevron-left"></i></a>
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

                            {{-- begin::Details toggle --}}
                            @if ($data->status_peneraan != 'Menunggu')
                                <div class="d-flex flex-stack fs-4 py-3">
                                    <div class="fw-bold rotate" data-bs-toggle="collapse" href="#kt_pdp_proses" role="button" aria-expanded="false" aria-controls="kt_pdp_proses">Detail Pemrosesan
                                        <span class="ms-2 rotate-180">
                                            <i class="ki-duotone ki-down fs-3"></i>
                                        </span>
                                    </div>
                                </div>
                                {{-- end::Details toggle --}}
                                <div class="separator"></div>
                                {{-- begin::Details content --}}
                                <div id="kt_pdp_proses" class="collapse">
                                    <div class="pb-5 fs-6">
                                        {{-- begin::Details item --}}
                                        <div class="fw-bold mt-5">Diproses Oleh:</div>
                                        <div class="text-gray-600">{{ isset($data->uuid_diproses) ? $data->RelDiproses->nama_lengkap : '-' }}</div>
                                        <div class="fw-bold mt-5">Ditunda Oleh:</div>
                                        <div class="text-gray-600">{{ isset($data->uuid_ditunda) ? $data->RelDitunda->nama_lengkap : '-' }}</div>
                                        <div class="fw-bold mt-5">Dibatalkan Oleh:</div>
                                        <div class="text-gray-600">{{ isset($data->uuid_dibatalkan) ? $data->RelDibatalkan->nama_lengkap : '-' }}</div>
                                        <div class="fw-bold mt-5">Diselesaikan Oleh:</div>
                                        <div class="text-gray-600">{{ isset($data->uuid_selesai) ? $data->RelSelesai->nama_lengkap : '-' }}</div>
                                        <div class="fw-bold mt-5">Terakhir Diupdate:</div>
                                        <div class="text-gray-600">{{ \CID::TglJam($data->updated_at) }}</div>
                                        {{-- begin::Details item --}}
                                    </div>
                                </div>
                            @endif
                            {{-- end::Details content --}}
                        </div>
                        {{-- end::Card body --}}
                        {{-- begin::Card footer --}}
                        @if (\CID::subRoleOnlyPetugas() == true)
                            @if ($data->status_peneraan == 'Menunggu')
                                <div class="card-footer border-0 d-grid gap-2 pt-0">
                                    <button class="btn btn-sm btn-light-primary" data-proses="{{ \CID::encode($data->uuid) }}" data-status="{{ \CID::encode('Diproses') }}"><i class="fa-solid fa-check-to-slot"></i> Proses Penugasan</button>
                                </div>
                            @elseif ($data->status_peneraan == 'Diproses')
                                <div class="card-footer border-0 d-grid gap-2 pt-0">
                                    <button class="btn btn-sm btn-light-warning" data-ditunda="{{ \CID::encode($data->uuid) }}" data-status="{{ \CID::encode('Ditunda') }}"><i class="fa-regular fa-circle-pause"></i> Ditunda</button>
                                    <button class="btn btn-sm btn-light-danger" data-dibatalkan="{{ \CID::encode($data->uuid) }}" data-status="{{ \CID::encode('Dibatalkan') }}"><i class="fa-regular fa-circle-xmark"></i> Dibatalkan</button>
                                    <button class="btn btn-sm btn-light-success" data-selesai="{{ \CID::encode($data->uuid) }}" data-status="{{ \CID::encode('Selesai') }}"><i class="fa-solid fa-check"></i> Selesai</button>
                                </div>
                            @elseif ($data->status_peneraan == 'Ditunda')
                                <div class="card-footer border-0 d-grid gap-2 pt-0">
                                    <button class="btn btn-sm btn-light-danger" data-dibatalkan="{{ \CID::encode($data->uuid) }}" data-status="{{ \CID::encode('Dibatalkan') }}"><i class="fa-regular fa-circle-xmark"></i> Dibatalkan</button>
                                    <button class="btn btn-sm btn-light-success" data-selesai="{{ \CID::encode($data->uuid) }}" data-status="{{ \CID::encode('Selesai') }}"><i class="fa-solid fa-check"></i> Selesai</button>
                                </div>
                            @endif
                        @endif
                        {{-- end::Card footer --}}
                    </div>
                    {{-- end::Card --}}
                </div>
                {{-- end::Sidebar --}}

                {{-- begin::Content --}}
                <div class="flex-lg-row-fluid ms-lg-15">
                    {{-- begin::Card --}}
                    <div class="card pt-4 mb-5 mb-xl-8">
                        {{-- begin::Card header --}}
                        <div class="card-header border-0">
                            {{-- begin::Card title --}}
                            <div class="card-title flex-column">
                                <h2>Form Lihat Jadwal dan Penugasan</h2>
                                <div class="fs-6 fw-semibold text-muted mt-2">Halaman untuk melihat data jadwal & penugasan dari permohonan dengan Nomor Order: <strong>{{ $data->nomor_order }}</strong>.</div>
                            </div>
                            {{-- end::Card title --}}
                        </div>
                        {{-- end::Card header --}}
                        {{-- begin::Card body --}}
                        <div class="card-body">
                            {{-- begin::Form --}}

                            {{-- begin::nomor_order --}}
                            <div class="form-floating mb-5">
                                <input type="text" class="form-control" name="nomor_order" id="nomor_order2" value="{{ $data->nomor_order }}" readonly />
                                <label for="nomor_order">Nomor Order</label>
                            </div>
                            {{-- end::nomor_order --}}

                            {{-- begin::kelompok_uttp --}}
                            <div class="form-floating mb-5">
                                <input type="text" class="form-control" name="kelompok_uttp" id="kelompok_uttp2" value="{{ $data->RelMasterKelompokUttp->nama_kelompok }}" readonly />
                                <label for="kelompok_uttp">Kelompok UTTP</label>
                            </div>
                            {{-- end::kelompok_uttp --}}

                            {{-- begin::Penjadwalan Peneraan --}}
                            <div class="mt-0">
                                <label for="">Penjadwalan Peneraan</label>
                                <div class="row p-2">
                                    <div class="col">
                                        {{-- begin::tanggal_peneraan --}}
                                        <div class="form-floating mb-5">
                                            <input type="date" class="form-control" name="tanggal_peneraan" id="tanggal_peneraan2" value="{{ $data->tanggal_peneraan }}" readonly />
                                            <label for="tanggal_peneraan">Tanggal Peneraan</label>
                                        </div>
                                        {{-- end::tanggal_peneraan --}}
                                    </div>
                                    <div class="col">
                                        {{-- begin::jam_peneraan --}}
                                        <div class="form-floating mb-5">
                                            <input type="text" class="form-control jam_peneraan" name="jam_peneraan" id="jam_peneraan2" placeholder="00:00" value="{{ $data->jam_peneraan }}" readonly />
                                            <label for="jam_peneraan">Jam Peneraan</label>
                                        </div>
                                        {{-- end::jam_peneraan --}}
                                    </div>
                                </div>
                            </div>
                            {{-- end::Penjadwalan Peneraan --}}

                            {{-- begin::Tenaga Ahli Penera --}}
                            <div class="mt-0">
                                <label for="">Tenaga Ahli Penera</label>
                                <div class="row p-2">
                                    <div class="col">
                                        {{-- begin::tenaga_ahli_penera --}}
                                        <div class="form-group mb-5">
                                            <ul>
                                                @php
                                                    $getPetugasTAP = \CID::getPetugasTAP($data->uuid);
                                                @endphp
                                                @foreach ($getPetugasTAP as $itemTAP)
                                                    <li>{{ $itemTAP->RelPegawai->nama_lengkap }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        {{-- end::tenaga_ahli_penera --}}
                                    </div>
                                </div>
                            </div>
                            {{-- end::Tenaga Ahli Penera --}}

                            {{-- begin::Pendamping Teknis --}}
                            <div class="mt-0">
                                <label for="">Pendamping Teknis</label>
                                <div class="row p-2">
                                    <div class="col">
                                        {{-- begin::pendamping_teknis --}}
                                        <div class="form-group mb-5">
                                            <ul>
                                                @php
                                                    $getPetugasPT = \CID::getPetugasPT($data->uuid);
                                                @endphp
                                                @foreach ($getPetugasPT as $itemPT)
                                                    <li>{{ $itemPT->RelPegawai->nama_lengkap }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        {{-- end::pendamping_teknis --}}
                                    </div>
                                </div>
                            </div>
                            {{-- end::Pendamping Teknis --}}

                            {{-- begin::Status Peneraan --}}
                            <div class="mt-0">
                                {{-- begin::Alert --}}
                                <div class="alert alert-dismissible bg-light-info d-flex flex-column flex-sm-row p-5">
                                    {{-- begin::Icon --}}
                                    <i class="ki-duotone ki-notification-bing fs-2hx text-info me-4 mb-5 mb-sm-0"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                                    {{-- end::Icon --}}

                                    {{-- begin::Wrapper --}}
                                    <div class="d-flex flex-column pe-0 pe-sm-10">
                                        {{-- begin::Title --}}
                                        <h4 class="fw-semibold">Status Peneraan</h4>
                                        {{-- end::Title --}}

                                        {{-- begin::Content --}}
                                        <span>Penjadwalan dan Penugasan dengan Nomor Order <strong>{{ $data->nomor_order }}</strong> saat ini berstatus: <span class="badge badge-info">{{ \Str::upper($data->status_peneraan) }}</span></span>
                                        {{-- end::Content --}}
                                    </div>
                                    {{-- end::Wrapper --}}

                                    {{-- begin::Close --}}
                                    <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
                                        <i class="ki-duotone ki-cross fs-1 text-info"><span class="path1"></span><span class="path2"></span></i>
                                    </button>
                                    {{-- end::Close --}}
                                </div>
                                {{-- end::Alert --}}
                            </div>
                            {{-- end::Status Peneraan --}}
                            {{-- end::Form --}}
                        </div>
                        {{-- end::Card body --}}
                        {{-- begin::Card footer --}}
                        {{-- end::Card footer --}}
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
    <script>
        $(document).ready(function() {
            $('.jam_peneraan').mask("00:00", {
                placeholder: "00:00"
            });
        });
    </script>

    {{-- Diproses --}}
    <script>
        $(document).on('click', "[data-proses]", function() {
            let uuid = $(this).attr('data-proses');
            let status = $(this).attr('data-status');
            Swal.fire({
                title: "Proses Penugasan",
                text: "Apakah Anda Yakin?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Iya",
                cancelButtonText: 'Tidak',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{!! route('scd.apps.data.pdp.status') !!}",
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

    {{-- Ditunda --}}
    <script>
        $(document).on('click', "[data-ditunda]", function() {
            let uuid = $(this).attr('data-ditunda');
            let status = $(this).attr('data-status');
            Swal.fire({
                title: "Tunda Peneraan",
                text: "Apakah Anda Yakin?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Iya",
                cancelButtonText: 'Tidak',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{!! route('scd.apps.data.pdp.status') !!}",
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

    {{-- Dibatalkan --}}
    <script>
        $(document).on('click', "[data-dibatalkan]", function() {
            let uuid = $(this).attr('data-dibatalkan');
            let status = $(this).attr('data-status');
            Swal.fire({
                title: "Batalkan Peneraan",
                text: "Apakah Anda Yakin?, membatalkan sama dengan MENOLAK Permohonan!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Iya",
                cancelButtonText: 'Tidak',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{!! route('scd.apps.data.pdp.status') !!}",
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

    {{-- Selesai --}}
    <script>
        $(document).on('click', "[data-selesai]", function() {
            let uuid = $(this).attr('data-selesai');
            let status = $(this).attr('data-status');
            Swal.fire({
                title: "Selesaikan Peneraan",
                text: "Apakah Anda Yakin?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Iya",
                cancelButtonText: 'Tidak',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{!! route('scd.apps.data.pdp.status') !!}",
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
