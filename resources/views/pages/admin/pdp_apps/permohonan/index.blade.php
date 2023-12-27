@extends('layouts.admin.pdp')
@push('apps')
    SIMEGAL
@endpush
@push('title')
    Permohonan Pengujian | SIMEGAL
@endpush
@push('description')
    Permohonan Pengujian | Sistem Informasi Metrologi Legal Pemerintah Kabupaten Tangerang
@endpush
@push('header-title')
    Permohonan Pengujian
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
        @include('pages.admin.pdp_apps.toolbox.index_peneraan')
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
                                        <th>Kode Permohonan</th>
                                        <th>Jenis Pengujian</th>
                                        <th>Nomor Surat</th>
                                        <th>Tanggal Permohonan</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="fs-6 fw-semibold text-gray-600">
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
        $('[name="q_tahun"]').change(function() {
            var q_tahun = $(this).val();
            var q_status = $('[name="q_status"]').val();
            $('#datatable tbody').empty();
            table.ajax.reload(null, true);
        });

        $('[name="q_status"]').change(function() {
            var q_status = $(this).val();
            var q_tahun = $('[name="q_tahun"]').val();
            $('#datatable tbody').empty();
            table.ajax.reload(null, true);
        });

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
            "ajax": {
                url: "{!! route('pdp.apps.reqpeneraan.data') !!}",
                type: 'GET',
                data: function(data) {
                    data.filter = {
                        'tahun': $('[name="q_tahun"]').val(),
                        'status': $('[name="q_status"]').val(),
                    };
                }
            },
            "columns": [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'kode_permohonan',
                    name: 'kode_permohonan'
                },
                {
                    data: 'jenis_pengujian',
                    name: 'jenis_pengujian'
                },
                {
                    data: 'nomor_surat_permohonan',
                    name: 'nomor_surat_permohonan'
                },
                {
                    data: 'tanggal_permohonan',
                    name: 'tanggal_permohonan'
                },
                {
                    data: 'status',
                    name: 'status'
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
                    className: "text-center",
                    targets: [4]
                },
                {
                    className: "w-300px",
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
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: 'No, cancel!',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{!! route('pdp.apps.reqpeneraan.destroy') !!}",
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
