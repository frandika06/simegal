@extends('layouts.admin.settings')
@push('apps')
    SIMEGAL
@endpush
@push('title')
    {{ $title }} | Instrumen & Alat | Manajemen Peneraan | SIMEGAL
@endpush
@push('description')
    {{ $title }} | Instrumen & Alat | Manajemen Peneraan | Sistem Informasi Metrologi Legal Pemerintah Kabupaten Tangerang
@endpush
@push('header-title')
    {{ $title }} | Instrumen & Alat | Manajemen Peneraan
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
                        <a href="{{ route('scd.apps.insalat.index') }}" class="text-muted text-hover-primary">Instrumen & Alat</a>
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
                <a href="{{ route('scd.apps.insalat.index') }}" class="btn btn-dark btn-sm btn-icon"><i class="fa-solid fa-chevron-left"></i></a>
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
                                <h2>Form Lihat Instrumen & Alat</h2>
                                <div class="fs-6 fw-semibold text-muted mt-2">Halaman untuk melihat data Instrumen & Alat dari permohonan dengan Nomor Order: <strong>{{ $data->nomor_order }}</strong>.</div>
                            </div>
                            {{-- end::Card title --}}
                        </div>
                        {{-- end::Card header --}}
                        {{-- begin::Card body --}}
                        <div class="card-body">
                            {{-- begin::Form --}}

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

                            {{-- begin::Penjadwalan Peneraan --}}
                            <div class="mt-0">
                                <label for="">Penjadwalan Peneraan</label>
                                <div class="row p-2">
                                    <div class="col">
                                        {{-- begin::tanggal_peneraan --}}
                                        <div class="form-floating mb-5">
                                            <input type="date" class="form-control bg-light-info" name="tanggal_peneraan" id="tanggal_peneraan2" value="{{ $data->tanggal_peneraan }}" readonly />
                                            <label for="tanggal_peneraan">Tanggal Peneraan</label>
                                        </div>
                                        {{-- end::tanggal_peneraan --}}
                                    </div>
                                    <div class="col">
                                        {{-- begin::jam_peneraan --}}
                                        <div class="form-floating mb-5">
                                            <input type="text" class="form-control bg-light-info jam_peneraan" name="jam_peneraan" id="jam_peneraan2" placeholder="00:00" value="{{ $data->jam_peneraan }}" readonly />
                                            <label for="jam_peneraan">Jam Peneraan</label>
                                        </div>
                                        {{-- end::jam_peneraan --}}
                                    </div>
                                </div>
                            </div>
                            {{-- end::Penjadwalan Peneraan --}}

                            {{-- begin::Nama Supir --}}
                            <div class="mt-0">
                                <label for="">Nama Supir</label>
                                <div class="row p-2">
                                    <div class="col">
                                        {{-- begin::nama_supir --}}
                                        <div class="form-floating mb-5">
                                            <input type="text" class="form-control bg-light-info" name="nama_supir" id="nama_supir2" placeholder="Nama Supir" autocomplete="off" maxlength="100" value="{{ $data->nama_supir }}" readonly />
                                            <label for="nama_supir">Nama Supir</label>
                                        </div>
                                        {{-- end::nama_supir --}}
                                    </div>
                                </div>
                            </div>
                            {{-- end::Nama Supir --}}

                            {{-- begin::Jenis Kendaraan --}}
                            <div class="mt-0">
                                <label for="">Jenis Kendaraan</label>
                                <div class="row p-2">
                                    <div class="col">
                                        {{-- begin::jenis_kendaraan --}}
                                        <div class="form-floating mb-5">
                                            <input type="text" class="form-control bg-light-info" name="jenis_kendaraan" id="jenis_kendaraan2" placeholder="Nama Supir" autocomplete="off" maxlength="100" value="{{ $data->jenis_kendaraan }}" readonly />
                                            <label for="jenis_kendaraan">Jenis Kendaraan</label>
                                        </div>
                                        {{-- end::jenis_kendaraan --}}
                                    </div>
                                </div>
                            </div>
                            {{-- end::Jenis Kendaraan --}}

                            {{-- begin::Plat Nomor Kendaraan --}}
                            <div class="mt-0">
                                <label for="">Plat Nomor Kendaraan</label>
                                <div class="row p-2">
                                    <div class="col">
                                        {{-- begin::plat_nomor_kendaraan --}}
                                        <div class="form-floating mb-5">
                                            <input type="text" class="form-control bg-light-info text-uppercase" name="plat_nomor_kendaraan" id="plat_nomor_kendaraan2" placeholder="Plat Nomor Kendaraan" autocomplete="off" maxlength="10" value="{{ $data->plat_nomor_kendaraan }}" readonly />
                                            <label for="plat_nomor_kendaraan">Plat Nomor Kendaraan</label>
                                        </div>
                                        {{-- end::plat_nomor_kendaraan --}}
                                    </div>
                                </div>
                            </div>
                            {{-- end::Plat Nomor Kendaraan --}}

                            {{-- begin::Instrumen --}}
                            <div class="mt-0">
                                <label for="">Instrumen</label>
                                <div class="row p-2">
                                    <div class="col">
                                        {{-- begin::intrumen --}}
                                        {{-- begin::Repeater --}}
                                        <div id="repeat_instrumen">
                                            {{-- begin::Form group --}}
                                            <div class="form-group">
                                                <div data-repeater-list="repeat_instrumen">
                                                    {{-- EDIT INSTRUMEN::BEGIN --}}
                                                    @isset($data->RelPdpInstrumen)
                                                        @foreach ($data->RelPdpInstrumenOrder as $itemData)
                                                            <div class="alert alert-secondary" id="{{ \CID::encode($itemData->uuid) }}">
                                                                <div class="form-group row mb-5">
                                                                    <div class="col-12 mb-5">
                                                                        <label class="form-label">Item UTTP:</label>
                                                                        <input type="text" class="form-control bg-light-info mb-2 mb-md-0" name="uuid_instrumen[]" value="{{ $itemData->RelMasterInstrumenDaftarItemUttp->nama_instrumen }}" placeholder="Item UTTP" readonly />
                                                                    </div>
                                                                    <div class="col">
                                                                        <label class="form-label">Jumlah Unit:</label>
                                                                        <input type="number" class="form-control bg-light-info mb-2 mb-md-0" name="jumlah_unit_instrumen[]" value="{{ $itemData->jumlah_unit }}" placeholder="Jumlah Unit" min="0" readonly />
                                                                    </div>
                                                                    <div class="col">
                                                                        <label class="form-label">Volume/Jam:</label>
                                                                        <input type="number" class="form-control bg-light-info mb-2 mb-md-0" name="volume_instrumen[]" value="{{ $itemData->volume }}" placeholder="Volume/Jam" min="0" readonly />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @endisset
                                                    {{-- EDIT INSTRUMEN::END --}}
                                                </div>
                                            </div>
                                            {{-- end::Form group --}}
                                        </div>
                                        {{-- end::Repeater --}}
                                        {{-- end::intrumen --}}
                                    </div>
                                </div>
                            </div>
                            {{-- end::Instrumen --}}

                            {{-- begin::Alat & CTT --}}
                            <div class="mt-5">
                                <label for="">Alat & CTT</label>
                                <div class="row p-2">
                                    <div class="col">
                                        {{-- begin::intrumen --}}
                                        {{-- begin::Repeater --}}
                                        <div id="repeat_alat">
                                            {{-- begin::Form group --}}
                                            <div class="form-group">
                                                <div data-repeater-list="repeat_alat">
                                                    {{-- EDIT ALAT::BEGIN --}}
                                                    @isset($data->RelPdpAlat)
                                                        @foreach ($data->RelPdpAlatOrder as $itemData)
                                                            <div class="alert alert-secondary" id="{{ \CID::encode($itemData->uuid) }}">
                                                                <div class="form-group row mb-5">
                                                                    <div class="col-12 mb-5">
                                                                        <input type="hidden" name="uuid_pdp_alat[]" value="{{ $itemData->uuid }}">
                                                                        <label class="form-label">Alat & CTT:</label>
                                                                        <input type="text" class="form-control bg-light-info mb-2 mb-md-0" name="uuid_alat[]" value="{{ $itemData->RelMasterKategoriKelompok->nama_kategori }}" placeholder="Alat & CTT:" readonly />
                                                                    </div>
                                                                    <div class="col-md-5">
                                                                        <label class="form-label">Jumlah Unit:</label>
                                                                        <input type="number" class="form-control bg-light-info mb-2 mb-md-0" name="jumlah_unit_alat[]" value="{{ $itemData->jumlah_unit }}" placeholder="Jumlah Unit" min="0" readonly />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @endisset
                                                    {{-- EDIT ALAT::END --}}
                                                </div>
                                            </div>
                                            {{-- end::Form group --}}
                                        </div>
                                        {{-- end::Repeater --}}
                                        {{-- end::intrumen --}}
                                    </div>
                                </div>
                            </div>
                            {{-- end::Alat & CTT --}}

                            {{-- end::Form --}}
                            {{-- begin::Action buttons --}}
                            <div class="d-flex justify-content-end align-items-center mt-12">
                                <a href="{{ route('scd.apps.insalat.index') }}" class="btn btn-secondary"><i class="fa-solid fa-times-circle"></i> Tutup</a>
                            </div>
                            {{-- begin::Action buttons --}}
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
@endpush
