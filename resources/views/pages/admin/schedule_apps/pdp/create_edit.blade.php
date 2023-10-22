@extends('layouts.admin.settings')
@push('apps')
    SIMEGAL
@endpush
@push('title')
    {{ $title }} | Penjadwalan & Penugasan | SIMEGAL
@endpush
@push('description')
    {{ $title }} | Penjadwalan & Penugasan | Sistem Informasi Metrologi Legal Pemerintah Kabupaten Tangerang
@endpush
@push('header-title')
    {{ $title }} | Penjadwalan & Penugasan
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
                <h1 class="d-flex text-dark fw-bold my-1 fs-3">Penjadwalan & Penugasan</h1>
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
                        <a href="{{ route('scd.apps.input.pdp.index') }}" class="text-muted text-hover-primary">Penjadwalan & Penugasan</a>
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
                <a href="{{ route('scd.apps.input.pdp.index') }}" class="btn btn-dark btn-sm btn-icon"><i class="fa-solid fa-chevron-left"></i></a>
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
                                <h2>Form Penjadwalan & Penugasan</h2>
                                <div class="fs-6 fw-semibold text-muted mt-2">Halaman untuk menginput data perjadwalan & penugasan dari permohonan dengan Kode Permohonan: <strong>{{ $permohonan->kode_permohonan }}</strong>.</div>
                            </div>
                            {{-- end::Card title --}}
                        </div>
                        {{-- end::Card header --}}
                        {{-- begin::Card body --}}
                        <div class="card-body">
                            {{-- begin::Form --}}
                            <form action="{{ isset($data) ? route('scd.apps.input.pdp.update', [$enc_uuid]) : route('scd.apps.input.pdp.store', [$enc_uuid]) }}" class="form" enctype="multipart/form-data" method="POST">
                                @csrf
                                @isset($data)
                                    @method('put')
                                @endisset

                                {{-- begin::kelompok_uttp --}}
                                <div class="form-floating mb-5">
                                    <select class="form-control @error('kelompok_uttp') is-invalid @enderror" name="kelompok_uttp" id="kelompok_uttp" required>
                                        <option value="" selected disabled>-Pilih Kelompok UTTP</option>
                                        @foreach ($kelompokUttp as $item)
                                            <option value="{{ $item->uuid }}" @if (old('kelompok_uttp', isset($data) ? $data->uuid_kelompok_uutp : '') == $item->uuid) selected @endif>{{ $item->nama_kelompok }}</option>
                                        @endforeach
                                    </select>
                                    <label for="kelompok_uttp">Kelompok UTTP</label>
                                    @error('kelompok_uttp')
                                        <div id="kelompok_uttpFeedback" class="invalid-feedback">{{ $message }}</div>
                                    @enderror
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

                                {{-- begin::Tenaga Ahli Penera --}}
                                <div class="mt-0">
                                    <label for="">Tenaga Ahli Penera</label>
                                    <div class="row p-2">
                                        <div class="col">
                                            {{-- begin::tenaga_ahli_penera --}}
                                            <div class="form-group mb-5">
                                                <select class="form-select @error('tenaga_ahli_penera') is-invalid @enderror" name="tenaga_ahli_penera[]" id="tenaga_ahli_penera" required data-control="select2" data-placeholder="Pilih Tenaga Ahli Penera" data-allow-clear="true" multiple="multiple"
                                                    required>
                                                    @foreach ($listTa as $item)
                                                        @if (old('tenaga_ahli_penera'))
                                                            <option value="{{ $item->uuid }}" @if (in_array($item->uuid, old('tenaga_ahli_penera'))) selected @endif>NIP. {{ $item->nip }} | {{ $item->nama_lengkap }}</option>
                                                        @else
                                                            <option value="{{ $item->uuid }}">NIP. {{ $item->nip }} | {{ $item->nama_lengkap }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                                @error('tenaga_ahli_penera')
                                                    <div id="tenaga_ahli_peneraFeedback" class="invalid-feedback">{{ $message }}</div>
                                                @enderror
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
                                                <select class="form-select @error('pendamping_teknis') is-invalid @enderror" name="pendamping_teknis[]" id="pendamping_teknis" required data-control="select2" data-placeholder="Pilih Pendamping Teknis" data-allow-clear="true" multiple="multiple"
                                                    required>
                                                    @foreach ($listPendamping as $item)
                                                        @if (old('tenaga_ahli_penera'))
                                                            <option value="{{ $item->uuid }}" @if (in_array($item->uuid, old('pendamping_teknis'))) selected @endif>{{ $item->nama_lengkap }}</option>
                                                        @else
                                                            <option value="{{ $item->uuid }}">{{ $item->nama_lengkap }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                                @error('pendamping_teknis')
                                                    <div id="pendamping_teknisFeedback" class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            {{-- end::pendamping_teknis --}}
                                        </div>
                                    </div>
                                </div>
                                {{-- end::Pendamping Teknis --}}

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
        });
    </script>
@endpush
