@extends('layouts.admin.settings')
@push('apps')
    SIMEGAL
@endpush
@push('title')
    {{ $title }} | Manajemen Peneraan | SIMEGAL
@endpush
@push('description')
    {{ $title }} | Manajemen Peneraan | Sistem Informasi Metrologi Legal Pemerintah Kabupaten Tangerang
@endpush
@push('header-title')
    {{ $title }} | Manajemen Peneraan
@endpush
@push('styles')
    {{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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
                        <a href="{{ route('scd.apps.mnj.penera.index') }}" class="text-muted text-hover-primary">Manajemen Peneraan</a>
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
                <a href="{{ route('scd.apps.mnj.penera.index') }}" class="btn btn-dark btn-sm btn-icon"><i class="fa-solid fa-chevron-left"></i></a>
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
                            <div class="d-flex flex-stack fs-4 py-3">
                                <div class="fw-bold rotate" data-bs-toggle="collapse" href="#kt_pdp" role="button" aria-expanded="false" aria-controls="kt_pdp">Detail PDP
                                    <span class="ms-2 rotate-180">
                                        <i class="ki-duotone ki-down fs-3"></i>
                                    </span>
                                </div>
                            </div>
                            {{-- end::Details toggle --}}
                            <div class="separator"></div>
                            {{-- begin::Details content --}}
                            <div id="kt_pdp" class="collapse">
                                <div class="pb-5 fs-6">
                                    {{-- begin::Details item --}}
                                    <div class="fw-bold mt-5">Nomor Order</div>
                                    <div class="text-gray-600">{{ $pdp->nomor_order }}</div>
                                    {{-- begin::Details item --}}
                                    {{-- begin::Details item --}}
                                    <div class="fw-bold mt-5">Kelompok UTTP</div>
                                    <div class="text-gray-600">{{ $pdp->RelMasterKelompokUttp->nama_kelompok }}</div>
                                    {{-- begin::Details item --}}
                                    {{-- begin::Details item --}}
                                    <div class="fw-bold mt-5">Tgl. Peneraan</div>
                                    <div class="text-gray-600">{{ \CID::hariTgl($pdp->tanggal_peneraan) }}</div>
                                    {{-- begin::Details item --}}
                                    {{-- begin::Details item --}}
                                    <div class="fw-bold mt-5">Jam Peneraan</div>
                                    <div class="text-gray-600">{{ \CID::jamMenit($pdp->jam_peneraan) }}</div>
                                    {{-- begin::Details item --}}
                                    {{-- begin::Details item --}}
                                    <div class="fw-bold mt-5">Tenaga Ahli Penera</div>
                                    <div class="text-gray-600 pt-5">
                                        @php
                                            $RelPdpDataPetugas = \CID::getPetugasTAP($pdp->uuid);
                                        @endphp
                                        @foreach ($RelPdpDataPetugas as $item)
                                            {{-- begin::Item --}}
                                            <div class="d-flex align-items-center mb-3">
                                                {{-- begin::Avatar --}}
                                                <div class="symbol symbol-50px me-5">
                                                    <img src="{{ \CID::ppPegawai($item->RelPegawai->foto) }}" class="" alt="{{ $item->RelPegawai->nama_lengkap }}" />
                                                </div>
                                                {{-- end::Avatar --}}
                                                {{-- begin::Text --}}
                                                <div class="flex-grow-1">
                                                    <a href="javascript:void(0);" class="text-dark fw-bold text-hover-primary fs-6">{{ $item->RelPegawai->nama_lengkap }}</a>
                                                    <span class="text-muted d-block fw-bold">NIP. {{ $item->RelPegawai->nip }}</span>
                                                </div>
                                                {{-- end::Text --}}
                                            </div>
                                            {{-- end::Item --}}
                                        @endforeach
                                    </div>
                                    {{-- begin::Details item --}}
                                    {{-- begin::Details item --}}
                                    <div class="fw-bold mt-5">Pendamping Teknis</div>
                                    <div class="text-gray-600 pt-5">
                                        @php
                                            $RelPdpDataPetugas = \CID::getPetugasPT($pdp->uuid);
                                        @endphp
                                        @foreach ($RelPdpDataPetugas as $item)
                                            {{-- begin::Item --}}
                                            <div class="d-flex align-items-center mb-3">
                                                {{-- begin::Avatar --}}
                                                <div class="symbol symbol-50px me-5">
                                                    <img src="{{ \CID::ppPegawai($item->RelPegawai->foto) }}" class="" alt="{{ $item->RelPegawai->nama_lengkap }}" />
                                                </div>
                                                {{-- end::Avatar --}}
                                                {{-- begin::Text --}}
                                                <div class="flex-grow-1">
                                                    <a href="javascript:void(0);" class="text-dark fw-bold text-hover-primary fs-6">{{ $item->RelPegawai->nama_lengkap }}</a>
                                                    {{-- <span class="text-muted d-block fw-bold">{{ $item->RelPegawai->jabatan }}</span> --}}
                                                </div>
                                                {{-- end::Text --}}
                                            </div>
                                            {{-- end::Item --}}
                                        @endforeach
                                    </div>
                                    {{-- begin::Details item --}}
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
                    {{-- begin::Card --}}
                    <div class="card pt-4 mb-5 mb-xl-8">
                        {{-- begin::Card header --}}
                        <div class="card-header border-0">
                            {{-- begin::Card title --}}
                            <div class="card-title flex-column">
                                <h2>Form {{ $title }}</h2>
                                <div class="fs-6 fw-semibold text-muted mt-2">Halaman untuk memanajemen Jadwal, Alat, dan Instrumen Peneraan.</div>
                            </div>
                            {{-- end::Card title --}}
                        </div>
                        {{-- end::Card header --}}
                        {{-- begin::Card body --}}
                        <div class="card-body">
                            {{-- begin::Form --}}
                            <form action="{{ isset($data) ? route('scd.apps.mnj.penera.update', [$enc_uuid]) : route('scd.apps.mnj.penera.store', [$enc_uuid]) }}" class="form" enctype="multipart/form-data" method="POST">
                                @csrf
                                @isset($data)
                                    @method('put')
                                @endisset

                                {{-- begin::Penjadwalan Peneraan --}}
                                <div class="mt-0">
                                    <label for="">Penjadwalan Peneraan</label>
                                    <div class="row p-2">
                                        <div class="col">
                                            {{-- begin::tanggal_peneraan --}}
                                            <div class="form-floating mb-5">
                                                <input type="date" class="form-control @error('tanggal_peneraan') is-invalid @enderror" name="tanggal_peneraan" id="tanggal_peneraan2" placeholder="Tanggal Peneraan" autocomplete="off"
                                                    value="{{ old('tanggal_peneraan', isset($pdp) ? $pdp->tanggal_peneraan : '') }}" required />
                                                <label for="tanggal_peneraan">Tanggal Peneraan</label>
                                                @error('tanggal_peneraan')
                                                    <div id="tanggal_peneraanFeedback" class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            {{-- end::tanggal_peneraan --}}
                                        </div>
                                        <div class="col">
                                            {{-- begin::jam_peneraan --}}
                                            <div class="form-floating mb-5">
                                                <input type="text" class="form-control jam_peneraan @error('jam_peneraan') is-invalid @enderror" name="jam_peneraan" id="jam_peneraan2" placeholder="00:00" autocomplete="off"
                                                    value="{{ old('jam_peneraan', isset($pdp) ? $pdp->jam_peneraan : '') }}" required />
                                                <label for="jam_peneraan">Jam Peneraan</label>
                                                @error('jam_peneraan')
                                                    <div id="jam_peneraanFeedback" class="invalid-feedback">{{ $message }}</div>
                                                @enderror
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
                                                <input type="text" class="form-control @error('nama_supir') is-invalid @enderror" name="nama_supir" id="nama_supir2" placeholder="Nama Supir" autocomplete="off" maxlength="100" value="{{ old('nama_supir', $pdp->nama_supir) }}" required />
                                                <label for="nama_supir">Nama Supir</label>
                                                @error('nama_supir')
                                                    <div id="nama_supirFeedback" class="invalid-feedback">{{ $message }}</div>
                                                @enderror
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
                                            <div class="form-group mb-5">
                                                <select class="form-select @error('jenis_kendaraan') is-invalid @enderror" name="jenis_kendaraan" id="jenis_kendaraan" data-control="select2" data-placeholder="Pilih Jenis Kendaraan" required>
                                                    @if (old('jenis_kendaraan'))
                                                        <option value="Mobil" @if (old('jenis_kendaraan') == 'Mobil') selected @endif>Mobil</option>
                                                        <option value="Motor" @if (old('jenis_kendaraan') == 'Motor') selected @endif>Motor</option>
                                                    @else
                                                        <option value="Mobil" @if ($pdp->jenis_kendaraan == 'Mobil') selected @endif>Mobil</option>
                                                        <option value="Motor" @if ($pdp->jenis_kendaraan == 'Motor') selected @endif>Motor</option>
                                                    @endif
                                                </select>
                                                @error('jenis_kendaraan')
                                                    <div id="jenis_kendaraanFeedback" class="invalid-feedback">{{ $message }}</div>
                                                @enderror
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
                                                <input type="text" class="form-control text-uppercase @error('plat_nomor_kendaraan') is-invalid @enderror" name="plat_nomor_kendaraan" id="plat_nomor_kendaraan2" placeholder="Plat Nomor Kendaraan" autocomplete="off" maxlength="10"
                                                    value="{{ old('plat_nomor_kendaraan', $pdp->plat_nomor_kendaraan) }}" required />
                                                <label for="plat_nomor_kendaraan">Plat Nomor Kendaraan</label>
                                                @error('plat_nomor_kendaraan')
                                                    <div id="plat_nomor_kendaraanFeedback" class="invalid-feedback">{{ $message }}</div>
                                                @enderror
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
                                            <!--begin::Repeater-->
                                            <div id="repeat_instrumen">
                                                <!--begin::Form group-->
                                                <div class="form-group">
                                                    <div data-repeater-list="repeat_instrumen">
                                                        <div data-repeater-item>
                                                            <div class="alert alert-secondary">
                                                                <div class="form-group row mb-5">
                                                                    <div class="col-12 mb-5">
                                                                        <label class="form-label">Item UTTP:</label>
                                                                        <select class="form-select mb-2 mb-md-0 select_test2" name="uuid_instrumen" id="uuid_instrumen" data-placeholder="Pilih Item UTTP" required>
                                                                            @foreach (\CID::getListInstrumen() as $item)
                                                                                <option value="{{ $item->uuid }}">[{{ $item->RelMasterInstrumenJenisUttp->nama_jenis_uttp }}] > {{ $item->nama_instrumen }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="col">
                                                                        <label class="form-label">Jumlah Unit:</label>
                                                                        <input type="number" class="form-control mb-2 mb-md-0" name="jumlah_unit_instrumen" placeholder="Jumlah Unit" min="0" required />
                                                                    </div>
                                                                    <div class="col">
                                                                        <label class="form-label">Volume/Jam:</label>
                                                                        <input type="number" class="form-control mb-2 mb-md-0" name="volume_instrumen" placeholder="Volume/Jam" min="0" required />
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <a href="javascript:;" data-repeater-delete class="btn btn-outline btn-light-danger mt-3 mt-md-8">
                                                                            <i class="ki-duotone ki-trash fs-5"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--end::Form group-->

                                                <!--begin::Form group-->
                                                <div class="form-group mt-5">
                                                    <a href="javascript:;" data-repeater-create class="btn btn-light-primary">
                                                        <i class="ki-duotone ki-plus fs-3"></i>
                                                        Add
                                                    </a>
                                                </div>
                                                <!--end::Form group-->
                                            </div>
                                            <!--end::Repeater-->
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
                                            <!--begin::Repeater-->
                                            <div id="repeat_alat">
                                                <!--begin::Form group-->
                                                <div class="form-group">
                                                    <div data-repeater-list="repeat_alat">
                                                        <div data-repeater-item>
                                                            <div class="alert alert-secondary">
                                                                <div class="form-group row mb-5">
                                                                    <div class="col-12 mb-5">
                                                                        <label class="form-label">Alat & CTT:</label>
                                                                        <select class="form-select mb-2 mb-md-0 select_test2" name="uuid_alat" id="uuid_alat" data-placeholder="Pilih Alat & CTT" required>
                                                                            <optgroup label="Alat Standar & Perlengkapannya">
                                                                                @foreach (\CID::getListAlat($permohonan->jenis_pengujian, $pdp->uuid_kelompok_uttp) as $item)
                                                                                    @if ($item->kategori == '1')
                                                                                        <option value="{{ $item->uuid }}">{{ $item->nama_kategori }}</option>
                                                                                    @endif
                                                                                @endforeach
                                                                            </optgroup>
                                                                            <optgroup label="CTT">
                                                                                @foreach (\CID::getListAlat($permohonan->jenis_pengujian, $pdp->uuid_kelompok_uttp) as $item)
                                                                                    @if ($item->kategori == '2')
                                                                                        <option value="{{ $item->uuid }}">{{ $item->nama_kategori }}</option>
                                                                                    @endif
                                                                                @endforeach
                                                                            </optgroup>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-5">
                                                                        <label class="form-label">Jumlah Unit:</label>
                                                                        <input type="number" class="form-control mb-2 mb-md-0" name="jumlah_unit_alat" placeholder="Jumlah Unit" min="0" required />
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <a href="javascript:;" data-repeater-delete class="btn btn-outline btn-light-danger mt-3 mt-md-8">
                                                                            <i class="ki-duotone ki-trash fs-5"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--end::Form group-->

                                                <!--begin::Form group-->
                                                <div class="form-group mt-5">
                                                    <a href="javascript:;" data-repeater-create class="btn btn-light-primary">
                                                        <i class="ki-duotone ki-plus fs-3"></i>
                                                        Add
                                                    </a>
                                                </div>
                                                <!--end::Form group-->
                                            </div>
                                            <!--end::Repeater-->
                                            {{-- end::intrumen --}}
                                        </div>
                                    </div>
                                </div>
                                {{-- end::Alat & CTT --}}

                                {{-- begin::Action buttons --}}
                                <div class="d-flex justify-content-end align-items-center mt-12">
                                    {{-- begin::Button --}}
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
            $('.select_test2').select2();
        });
    </script>
    {{-- reapeat instrumen --}}
    <script>
        $('#repeat_instrumen').repeater({
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
    {{-- reapeat alat & CTT --}}
    <script>
        $('#repeat_alat').repeater({
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
