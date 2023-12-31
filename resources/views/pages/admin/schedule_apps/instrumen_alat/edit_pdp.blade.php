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
                                <h2>Form Edit Instrumen & Alat</h2>
                                <div class="fs-6 fw-semibold text-muted mt-2">Halaman untuk mengedit data Instrumen & Alat dari permohonan dengan Nomor Order: <strong>{{ $data->nomor_order }}</strong>.</div>
                            </div>
                            {{-- end::Card title --}}
                        </div>
                        {{-- end::Card header --}}
                        {{-- begin::Card body --}}
                        <div class="card-body">
                            {{-- begin::Form --}}
                            <form action="{{ route('scd.apps.insalat.update', [$enc_uuid]) }}" class="form" enctype="multipart/form-data" method="POST">
                                @csrf
                                @isset($data)
                                    @method('put')
                                @endisset

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
                                                <input type="date" class="form-control @error('tanggal_peneraan') is-invalid @enderror" name="tanggal_peneraan" id="tanggal_peneraan2" placeholder="Tanggal Peneraan" autocomplete="off"
                                                    value="{{ old('tanggal_peneraan', isset($data) ? $data->tanggal_peneraan : '') }}" required />
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
                                                    value="{{ old('jam_peneraan', isset($data) ? $data->jam_peneraan : '') }}" required />
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

                                @if ($permohonan->lokasi_peneraan == 'Luar Kantor Metrologi')
                                    {{-- begin::Nama Supir --}}
                                    <div class="mt-0">
                                        <label for="">Nama Supir</label>
                                        <div class="row p-2">
                                            <div class="col">
                                                {{-- begin::nama_supir --}}
                                                <div class="form-floating mb-5">
                                                    <input type="text" class="form-control @error('nama_supir') is-invalid @enderror" name="nama_supir" id="nama_supir2" placeholder="Nama Supir" autocomplete="off" maxlength="100" value="{{ old('nama_supir', $data->nama_supir) }}" />
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
                                                    <select class="form-select @error('jenis_kendaraan') is-invalid @enderror" name="jenis_kendaraan" id="jenis_kendaraan" data-control="select2" data-placeholder="Pilih Jenis Kendaraan">
                                                        @if (old('jenis_kendaraan'))
                                                            <option value="Mobil" @if (old('jenis_kendaraan') == 'Mobil') selected @endif>Mobil</option>
                                                            <option value="Motor" @if (old('jenis_kendaraan') == 'Motor') selected @endif>Motor</option>
                                                        @else
                                                            <option value="Mobil" @if ($data->jenis_kendaraan == 'Mobil') selected @endif>Mobil</option>
                                                            <option value="Motor" @if ($data->jenis_kendaraan == 'Motor') selected @endif>Motor</option>
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
                                                        value="{{ old('plat_nomor_kendaraan', $data->plat_nomor_kendaraan) }}" />
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
                                @endif

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
                                                                            <input type="hidden" name="uuid_pdp_instrumen[]" value="{{ $itemData->uuid }}">
                                                                            <label class="form-label">Item UTTP:</label>
                                                                            <select class="form-select mb-2 mb-md-0 select_test2" name="uuid_instrumen[]" id="uuid_instrumen" data-placeholder="Pilih Item UTTP" required>
                                                                                @foreach (\CID::getListInstrumenGByJenisUttp() as $item1)
                                                                                    <optgroup label="{{ $item1->nama_jenis_uttp }}">
                                                                                        @foreach (\CID::getListInstrumenByJenisUttp($item1->uuid) as $item2)
                                                                                            @if ($item2->group_instrumen === null)
                                                                                                <option value="{{ $item2->uuid }}" @if ($item2->uuid == $itemData->uuid_instrumen) selected @endif>{{ $item2->nama_instrumen }}</option>
                                                                                            @else
                                                                                                <option value="{{ $item2->uuid }}" @if ($item2->uuid == $itemData->uuid_instrumen) selected @endif>[{{ $item2->group_instrumen }}] : {{ $item2->nama_instrumen }}</option>
                                                                                            @endif
                                                                                        @endforeach
                                                                                    </optgroup>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                        <div class="col">
                                                                            <label class="form-label">Jumlah Unit:</label>
                                                                            <input type="number" class="form-control mb-2 mb-md-0" name="jumlah_unit_instrumen[]" value="{{ $itemData->jumlah_unit }}" placeholder="Jumlah Unit" min="0" required />
                                                                        </div>
                                                                        <div class="col">
                                                                            <label class="form-label">Volume/Jam:</label>
                                                                            <input type="number" class="form-control mb-2 mb-md-0" name="volume_instrumen[]" value="{{ $itemData->volume }}" placeholder="Volume/Jam" min="0" required />
                                                                        </div>
                                                                        <div class="col-md-2">
                                                                            <a href="javascript:;" class="btn btn-outline btn-light-danger mt-3 mt-md-8 hapus-instrumen" data-del-instrumen="{{ \CID::encode($itemData->uuid) }}">
                                                                                <i class="ki-duotone ki-trash fs-5"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        @endisset
                                                        {{-- EDIT INSTRUMEN::END --}}

                                                        {{-- ADD INSTRUMEN::BEGIN --}}
                                                        <div data-repeater-item>
                                                            <div class="alert alert-secondary">
                                                                <div class="form-group row mb-5">
                                                                    <div class="col-12 mb-5">
                                                                        <label class="form-label">Item UTTP:</label>
                                                                        <select class="form-select mb-2 mb-md-0 select_test2" name="uuid_instrumen" id="uuid_instrumen" data-placeholder="Pilih Item UTTP" required>
                                                                            @foreach (\CID::getListInstrumenGByJenisUttp() as $item1)
                                                                                <optgroup label="{{ $item1->nama_jenis_uttp }}">
                                                                                    @foreach (\CID::getListInstrumenByJenisUttp($item1->uuid) as $item2)
                                                                                        @if ($item2->group_instrumen === null)
                                                                                            <option value="{{ $item2->uuid }}">{{ $item2->nama_instrumen }}</option>
                                                                                        @else
                                                                                            <option value="{{ $item2->uuid }}">[{{ $item2->group_instrumen }}] : {{ $item2->nama_instrumen }}</option>
                                                                                        @endif
                                                                                    @endforeach
                                                                                </optgroup>
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
                                                        {{-- ADD INSTRUMEN::END --}}
                                                    </div>
                                                </div>
                                                {{-- end::Form group --}}

                                                {{-- begin::Form group --}}
                                                <div class="form-group mt-5">
                                                    <a href="javascript:;" data-repeater-create class="btn btn-light-primary">
                                                        <i class="ki-duotone ki-plus fs-3"></i>
                                                        Add
                                                    </a>
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
                                                                            <select class="form-select mb-2 mb-md-0 select_test2" name="uuid_alat[]" id="uuid_alat" data-placeholder="Pilih Alat & CTT" required>
                                                                                <optgroup label="Alat Standar & Perlengkapannya">
                                                                                    @foreach (\CID::getListAlat($permohonan->jenis_pengujian, $data->uuid_kelompok_uttp) as $item)
                                                                                        @if ($item->kategori == '1')
                                                                                            <option value="{{ $item->uuid }}" @if ($item->uuid == $itemData->uuid_alat) selected @endif>{{ $item->nama_kategori }}</option>
                                                                                        @endif
                                                                                    @endforeach
                                                                                </optgroup>
                                                                                <optgroup label="CTT">
                                                                                    @foreach (\CID::getListAlat($permohonan->jenis_pengujian, $data->uuid_kelompok_uttp) as $item)
                                                                                        @if ($item->kategori == '2')
                                                                                            <option value="{{ $item->uuid }}" @if ($item->uuid == $itemData->uuid_alat) selected @endif>{{ $item->nama_kategori }}</option>
                                                                                        @endif
                                                                                    @endforeach
                                                                                </optgroup>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-md-5">
                                                                            <label class="form-label">Jumlah Unit:</label>
                                                                            <input type="number" class="form-control mb-2 mb-md-0" name="jumlah_unit_alat[]" value="{{ $itemData->jumlah_unit }}" placeholder="Jumlah Unit" min="0" required />
                                                                        </div>
                                                                        <div class="col-md-2">
                                                                            <a href="javascript:;" class="btn btn-outline btn-light-danger mt-3 mt-md-8 hapus-alat" data-del-alat="{{ \CID::encode($itemData->uuid) }}">
                                                                                <i class="ki-duotone ki-trash fs-5"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        @endisset
                                                        {{-- EDIT ALAT::END --}}

                                                        {{-- ADD ALAT::BEGIN --}}
                                                        <div data-repeater-item>
                                                            <div class="alert alert-secondary">
                                                                <div class="form-group row mb-5">
                                                                    <div class="col-12 mb-5">
                                                                        <label class="form-label">Alat & CTT:</label>
                                                                        <select class="form-select mb-2 mb-md-0 select_test2" name="uuid_alat" id="uuid_alat" data-placeholder="Pilih Alat & CTT" required>
                                                                            <optgroup label="Alat Standar & Perlengkapannya">
                                                                                @foreach (\CID::getListAlat($permohonan->jenis_pengujian, $data->uuid_kelompok_uttp) as $item)
                                                                                    @if ($item->kategori == '1')
                                                                                        <option value="{{ $item->uuid }}">{{ $item->nama_kategori }}</option>
                                                                                    @endif
                                                                                @endforeach
                                                                            </optgroup>
                                                                            <optgroup label="CTT">
                                                                                @foreach (\CID::getListAlat($permohonan->jenis_pengujian, $data->uuid_kelompok_uttp) as $item)
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
                                                        {{-- ADD ALAT::END --}}
                                                    </div>
                                                </div>
                                                {{-- end::Form group --}}

                                                {{-- begin::Form group --}}
                                                <div class="form-group mt-5">
                                                    <a href="javascript:;" data-repeater-create class="btn btn-light-primary">
                                                        <i class="ki-duotone ki-plus fs-3"></i>
                                                        Add
                                                    </a>
                                                </div>
                                                {{-- end::Form group --}}
                                            </div>
                                            {{-- end::Repeater --}}
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
            initEmpty: true,
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
            initEmpty: true,
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
    {{-- hapus-instrumen --}}
    <script>
        $(document).on('click', ".hapus-instrumen", function() {
            let id = $(this).attr('data-del-instrumen');
            $("#" + id).remove();
        });
    </script>
    {{-- hapus-alat --}}
    <script>
        $(document).on('click', ".hapus-alat", function() {
            let id = $(this).attr('data-del-alat');
            $("#" + id).remove();
        });
    </script>
@endpush
