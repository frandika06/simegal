@extends('layouts.admin.pdp')
@push('apps')
    SIMEGAL
@endpush
@push('title')
    Sertifikat SKHP | SIMEGAL
@endpush
@push('description')
    Sertifikat SKHP | Sistem Informasi Metrologi Legal Pemerintah Kabupaten Tangerang
@endpush
@push('header-title')
    Sertifikat SKHP
@endpush
@push('styles')
    {{-- begin::Vendor Stylesheets(used for this page only) --}}
    <link href="{{ asset('assets-pdp/plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets-pdp/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
    {{-- end::Vendor Stylesheets --}}
@endpush

{{-- TOOLBOX::BEGIN --}}
@push('toolbox')
    @if ($profile->file_npwp === null || $profile->file_npwp == '')
        @include('pages.admin.pdp_apps.toolbox.dashboard_1')
    @else
        @include('pages.admin.pdp_apps.toolbox.index_sertifikat')
    @endif
@endpush
{{-- TOOLBOX::END --}}

{{-- CONTENT::BEGIN --}}
@section('content')
    @if ($profile->file_npwp !== null && $profile->file_npwp != '')
        {{-- begin::Post --}}
        <div class="content flex-row-fluid" id="kt_content">
            {{-- begin::Row --}}
            <div class="row gy-0 gx-10">
                {{-- begin::Col --}}
                <div class="col-xl-12">
                    {{-- begin::General Widget 1 --}}
                    <div class="mb-10">
                        {{-- begin::Table wrapper --}}
                        <div class="table-responsive">
                            {{-- begin::Table --}}
                            <table id="datatable" class="table table-striped table-hover table-row-bordered gy-5 gs-7 border rounded">
                                <thead class="border-bottom border-gray-200 fs-7 fw-bold">
                                    <tr class="text-start text-muted text-uppercase gs-0">
                                        <th>#</th>
                                        <th>Detail Permohonan</th>
                                        <th>Detail Tinjut</th>
                                        <th>Sisa Aktif</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="fs-6 fw-semibold text-gray-600">
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach ($dataSertifikat as $item1)
                                        @php
                                            if ($item1->jenis_pengujian == 'Tera') {
                                                $jenis_pengujian = '<span class="badge badge-info">' . $item1->jenis_pengujian . '</span>';
                                            } elseif ($item1->jenis_pengujian == 'Tera Ulang') {
                                                $jenis_pengujian = '<span class="badge badge-success">' . $item1->jenis_pengujian . '</span>';
                                            } elseif ($item1->jenis_pengujian == 'Pengujian BDKT') {
                                                $jenis_pengujian = '<span class="badge badge-secondary">' . $item1->jenis_pengujian . '</span>';
                                            }
                                            // variabel
                                            $tanggal_expired = $item1->RelPdpPenjadwalan->RelTteSkhp->tanggal_expired;
                                            $masa_aktif = \CID::hitungMasaAktif($tanggal_expired);
                                            // url
                                            $urlViewPermohonan = \route('pdp.apps.reqpeneraan.show', [\CID::encode($item1->uuid)]);
                                            $urlFilePermohonan = \CID::urlImg($item1->file_surat_permohonan);
                                            $urlFileSKHP = \CID::urlImg($item1->RelPdpPenjadwalan->RelTteSkhp->file_skhp);
                                            $urlUnduhFileSKHP = \route('exdown.unduh.skhp', [$item1->RelPdpPenjadwalan->RelTteSkhp->kode_tte]);
                                            // background tr
                                            if ($masa_aktif == 'Expired') {
                                                $tr_masa_aktif = 'bg-danger text-white';
                                            } elseif ($masa_aktif <= '90') {
                                                $tr_masa_aktif = 'bg-light-warning bg-hover-warning text-dark';
                                            } else {
                                                $tr_masa_aktif = '';
                                            }
                                        @endphp
                                        <tr class="{!! $tr_masa_aktif !!}">
                                            <td>{{ $no++ }}</td>
                                            <td>
                                                <p class="m-0 p-0"><strong>Kode Permohonan</strong><a target="_BLANK" href="{{ $urlViewPermohonan }}"><span>: {{ $item1->kode_permohonan }}</span></a></p>
                                                <p class="m-0 p-0"><strong>Nomor Surat</strong><a target="_BLANK" href="{{ $urlFilePermohonan }}"><span>: {{ $item1->nomor_surat_permohonan }}</span></a></p>
                                                <p class="m-0 p-0"><strong>Perusahaan/UTTP</strong><span>: {{ $item1->RelPerusahaan->nama_perusahaan }}</span></p>
                                                <p class="m-0 p-0"><strong>Jenis Pengujian</strong><span>: {!! $jenis_pengujian !!}</span></p>
                                            </td>
                                            <td>
                                                <p class="m-0 p-0"><strong>Nomor Order</strong><span>: {{ $item1->RelPdpPenjadwalan->nomor_order }}</span></p>
                                                <p class="m-0 p-0"><strong>Tgl. Permohonan</strong><span>: {{ \CID::tglBlnThn($item1->tanggal_permohonan) }}</span></p>
                                                <p class="m-0 p-0"><strong>Tgl. Peneraan</strong><span>: {{ \CID::tglBlnThn($item1->RelPdpPenjadwalan->tanggal_peneraan) }}</span></p>
                                                <p class="m-0 p-0"><strong>Tgl. Expired</strong><span>: {{ \CID::tglBlnThn($tanggal_expired) }}</span></p>
                                            </td>
                                            <td>
                                                @if ($masa_aktif == '0')
                                                    <div class="py-8 flex-fill bg-warning text-white text-center fs-5">
                                                        {{ \CID::hitungMasaAktifLengkap($tanggal_expired) }}
                                                    </div>
                                                @elseif($masa_aktif == 'Expired')
                                                    <div class="py-8 flex-fill bg-dark text-white text-center fs-2">
                                                        {{ $masa_aktif }}
                                                    </div>
                                                @else
                                                    <div class="py-8 flex-fill bg-primary text-white text-center fs-2">
                                                        {{ $masa_aktif }} Hari
                                                    </div>
                                                @endif
                                            <td>
                                                <a target="_BLANK" href="{{ $urlFileSKHP }}" class="btn btn-sm btn-secondary mb-2"><i class="fa fa-eye fs-5 m-0"></i></a>
                                                <a target="_BLANK" href="{{ $urlUnduhFileSKHP }}" class="btn btn-sm btn-success"><i class="fa-solid fa-download fs-5 m-0"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{-- end::Table --}}
                        </div>
                        {{-- end::Table wrapper --}}
                    </div>
                    {{-- end::General Widget 1 --}}
                </div>
                {{-- end::Col --}}
            </div>
            {{-- end::Row --}}
        </div>
        {{-- end::Post --}}
    @endif
@endsection
{{-- CONTENT::END --}}

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
            "columnDefs": [{
                    className: "min_id text-center",
                    targets: [0, 4]
                },
                {
                    className: "text-end",
                    targets: [4]
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
    </script>
@endpush
