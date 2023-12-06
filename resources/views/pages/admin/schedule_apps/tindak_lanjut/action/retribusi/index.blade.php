@extends('layouts.admin.settings')
@push('apps')
    SIMEGAL
@endpush
@push('title')
    Manajemen Retribusi | Tindak Lanjut | SIMEGAL
@endpush
@push('description')
    Manajemen Retribusi | Tindak Lanjut | Sistem Informasi Metrologi Legal Pemerintah Kabupaten Tangerang
@endpush
@push('header-title')
    Manajemen Retribusi | Tindak Lanjut
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
                <h1 class="d-flex text-dark fw-bold my-1 fs-3">Manajemen Retribusi</h1>
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
                    <li class="breadcrumb-item text-dark">Manajemen Retribusi</li>
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
                            @if (isset($skrd->tgl_skrd))
                                @if ($skrd->status == 'Unpaid')
                                    {{-- begin::Alert --}}
                                    <div class="alert alert-dismissible bg-light-warning border border-dashed border-warning d-flex flex-column flex-sm-row p-5 mb-5">
                                        {{-- begin::Icon --}}
                                        <i class="fa-solid fa-qrcode fs-2hx text-warning me-4 mb-5 mb-sm-0"></i>
                                        {{-- end::Icon --}}
                                        {{-- begin::Wrapper --}}
                                        <div class="d-flex flex-column">
                                            {{-- begin::Title --}}
                                            <h5 class="mb-1">Belum Dibayar.</h5>
                                            {{-- end::Title --}}
                                            {{-- begin::Content --}}
                                            <span>Retribusi Ini Belum Dibayar Oleh Perusahaan / Pemilik UTTP.</span>
                                            {{-- end::Content --}}
                                        </div>
                                        {{-- end::Wrapper --}}
                                    </div>
                                    {{-- end::Alert --}}
                                @endif

                                <div class="text-center mb-5">
                                    {!! QrCode::size(290)->generate($skrd->kode_bayar_webr) !!}
                                    <div class="mt-5">
                                        <a href="{{ route('scd.apps.tinjut.action.retribusi.unduhkode', [$tags_jp, $enc_uuid, $skrd->kode_bayar_webr]) }}" class="btn btn-light-info btn-sm me-2"><i class="fa fa-download"></i> Unduh Kode</a>
                                        <a target="_BLANK" href="{{ route('print.pdp.skrd', [$enc_uuid]) }}" class="btn btn-light-primary btn-sm mt-2"><i class="fa fa-print"></i> Cetak SKRD</a>
                                    </div>
                                </div>

                                {{-- begin::Details toggle --}}
                                <div class="d-flex flex-stack fs-4 py-3">
                                    <div class="fw-bold rotate collapsible" data-bs-toggle="collapse" href="#kt_user_view_details" role="button" aria-expanded="false" aria-controls="kt_user_view_details">Informasi Retribusi
                                        <span class="ms-2 rotate-180">
                                            <i class="ki-duotone ki-down fs-3"></i>
                                        </span>
                                    </div>
                                </div>
                                {{-- end::Details toggle --}}
                                <div class="separator"></div>
                                {{-- begin::Details content --}}
                                <div id="kt_user_view_details" class="collapse show">
                                    <div class="pb-5 fs-6">
                                        {{-- begin::Details item --}}
                                        <div class="fw-bold mt-5">Kode Bayar WEBR</div>
                                        <div class="text-gray-600">
                                            {{ $skrd->kode_bayar_webr }}
                                        </div>
                                        {{-- end::Details item --}}
                                        {{-- begin::Details item --}}
                                        <div class="fw-bold mt-5 mb-3">Status Bayar Retribusi</div>
                                        @if ($skrd->status == 'Unpaid')
                                            <div class="p-3 bg-warning text-center rounded-3">
                                                BELUM DIBAYAR
                                            </div>
                                        @elseif ($skrd->status == 'Paid')
                                            <div class="p-3 bg-success text-center rounded-3">
                                                SUDAH DIBAYAR
                                            </div>
                                        @elseif ($skrd->status == 'Cancel')
                                            <div class="p-3 bg-danger text-center text-white rounded-3">
                                                DIBATALKAN / JATUH TEMPO
                                            </div>
                                        @endif
                                        {{-- end::Details item --}}
                                        {{-- begin::Details item --}}
                                        <div class="fw-bold mt-5">Di Generate Oleh</div>
                                        <div class="text-gray-600">
                                            <a target="_BLANK" href="{{ route('set.apps.pegawai.show', [\CID::encode($skrd->uuid_verifikasi)]) }}" class="text-gray-600 text-hover-info">{{ $skrd->RelGenerator->nama_lengkap }}</a>
                                        </div>
                                        {{-- end::Details item --}}
                                        {{-- begin::Details item --}}
                                        <div class="fw-bold mt-5">Tgl. Generate SKRD</div>
                                        <div class="text-gray-600">
                                            {{ \CID::tglBlnThn($skrd->tgl_skrd) }}
                                        </div>
                                        {{-- end::Details item --}}
                                        {{-- begin::Details item --}}
                                        <div class="fw-bold mt-5">Tgl. Jatuh Tempo</div>
                                        <div class="text-gray-600">
                                            {{ isset($skrd->tgl_jatuh_tempo) ? \CID::tglBlnThn($skrd->tgl_jatuh_tempo) : '-' }}
                                        </div>
                                        {{-- end::Details item --}}
                                        {{-- begin::Details item --}}
                                        <div class="fw-bold mt-5 mb-3">Total Retribusi</div>
                                        <div class="p-3 bg-success text-center rounded-3 fs-1">
                                            {{ \CID::toRp($skrd->total_retribusi) }}
                                        </div>
                                        {{-- end::Details item --}}
                                    </div>
                                </div>
                                {{-- end::Details content --}}

                                @if (isset($skrd->file_pembayaran))
                                    {{-- begin::Details toggle --}}
                                    <div class="d-flex flex-stack fs-4 py-3 mt-5">
                                        <div class="fw-bold rotate" data-bs-toggle="collapse" href="#kt_pembayaran" role="button" aria-expanded="false" aria-controls="kt_pembayaran">Detail Pembayaran
                                            <span class="ms-2 rotate-180">
                                                <i class="ki-duotone ki-down fs-3"></i>
                                            </span>
                                        </div>
                                    </div>
                                    {{-- end::Details toggle --}}
                                    <div class="separator"></div>
                                    {{-- begin::Details content --}}
                                    <div id="kt_pembayaran" class="collapse">
                                        <div class="pb-5 fs-6">
                                            {{-- begin::Details item --}}
                                            <div class="fw-bold mt-5">Tanggal Upload</div>
                                            <div class="text-gray-600">
                                                {{ isset($skrd->tgl_upload) ? \CID::tglBlnThn($skrd->tgl_upload) : '-' }}
                                            </div>
                                            {{-- begin::Details item --}}
                                            {{-- begin::Details item --}}
                                            <div class="fw-bold mt-5">Tanggal Verifikasi</div>
                                            <div class="text-gray-600">
                                                {{ isset($skrd->tgl_verifikasi) ? \CID::tglBlnThn($skrd->tgl_verifikasi) : '-' }}
                                            </div>
                                            {{-- begin::Details item --}}
                                            {{-- begin::Details item --}}
                                            <div class="fw-bold mt-5">Verifikator</div>
                                            <div class="text-gray-600">
                                                @if (isset($skrd->RelVerifikator->nama_lengkap))
                                                    <a target="_BLANK" href="{{ route('set.apps.pegawai.show', [\CID::encode($skrd->uuid_verifikasi)]) }}" class="text-gray-600 text-hover-info">{{ $skrd->RelVerifikator->nama_lengkap }}</a>
                                                @else
                                                    -
                                                @endif
                                            </div>
                                            {{-- end::Details item --}}
                                            {{-- btn-generate-skrd --}}
                                            <div class="mt-5 text-center">
                                                <a href="{{ \CID::urlImg($skrd->file_pembayaran) }}" class="btn btn-light-info"><i class="fa-solid fa-eye"></i> Lihat Bukti Bayar</a>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- end::Details content --}}
                                @endif
                            @else
                                {{-- begin::Alert --}}
                                <div class="alert alert-dismissible bg-light-danger border border-dashed border-danger d-flex flex-column flex-sm-row p-5 mb-5">
                                    {{-- begin::Icon --}}
                                    <i class="fa-solid fa-money-bill-transfer fs-2hx text-danger me-4 mb-5 mb-sm-0"></i>
                                    {{-- end::Icon --}}

                                    {{-- begin::Wrapper --}}
                                    <div class="d-flex flex-column">
                                        {{-- begin::Title --}}
                                        <h5 class="mb-1">SKRD Belum Di Generate ke WEBR Kabupaten Tangerang</h5>
                                        {{-- end::Title --}}

                                        {{-- begin::Content --}}
                                        <span>Permohonan ini belum memiliki SKRD, silahkan proses Retribusi melalui Generate SKRD dibawah ini.</span>
                                        {{-- end::Content --}}
                                    </div>
                                    {{-- end::Wrapper --}}
                                </div>
                                {{-- end::Alert --}}
                                <img src="{{ asset('assets-apps/media/custom/skrd-1.png') }}" class="img-fluid" alt="SKRD Not Found!">
                                {{-- btn-generate-skrd --}}
                                <div class="mt-5 text-center">
                                    <a href="javascript:void(0);" data-generate="{{ $enc_uuid }}" class="btn btn-light-info"><i class="fa-solid fa-money-bill-transfer"></i> GENERATE SKRD</a>
                                </div>
                            @endif
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
                                <h2>Form Retribusi</h2>
                                <div class="fs-6 fw-semibold text-muted mt-2">Halaman untuk melihat data Retribusi dari permohonan dengan Nomor Order: <strong>{{ $data->nomor_order }}</strong>.</div>
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
                                                                    <div class="col-12 mt-5">
                                                                        <label class="form-label">Jumlah Retribusi:</label>
                                                                        <input type="text" class="form-control text-center bg-light-success mb-2 mb-md-0 fs-3" name="nilai_retribusi[]" value="{{ \CID::toRP($itemData->nilai_retribusi) }}" placeholder="Jumlah Retribusi" readonly />
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

                            {{-- end::Form --}}
                            {{-- begin::Action buttons --}}
                            <div class="d-flex justify-content-end align-items-center mt-12">
                                <a href="{{ route('scd.apps.tinjut.' . $jenis_uttp . '.index') }}" class="btn btn-secondary"><i class="fa-solid fa-times-circle"></i> Tutup</a>
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
    {{-- hapus tte --}}
    <script>
        $(document).on('click', "[data-generate]", function() {
            let uuid = $(this).attr('data-generate');
            Swal.fire({
                title: "Generate SKRD dan Retribusi WEBR",
                text: "Apakah Anda Yakin?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Iya",
                cancelButtonText: 'Tidak',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{!! route('scd.apps.tinjut.action.retribusi.generate', [$tags_jp, $enc_uuid]) !!}",
                        type: 'POST',
                        data: {
                            uuid: uuid,
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
