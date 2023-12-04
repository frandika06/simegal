{{-- begin:::Tab pane --}}
<div class="tab-pane fade" id="tab_tte_menunggu" role="tabpanel">
    {{-- begin::Card --}}
    <div class="card pt-4 mb-6 mb-xl-9">
        {{-- begin::Card header --}}
        <div class="card-header border-0">
            {{-- begin::Card title --}}
            <div class="card-title">
                <h2>Menunggu</h2>
            </div>
            {{-- end::Card title --}}
        </div>
        {{-- end::Card header --}}
        {{-- begin::Card body --}}
        <div class="card-body pt-0 pb-5">
            {{-- begin::Table wrapper --}}
            <div class="table-responsive">
                {{-- begin::Table --}}
                <table id="datatableMenunggu" class="table table-striped table-hover table-row-bordered gy-5 gs-7 border rounded">
                    <thead class="border-bottom border-gray-200 fs-7 fw-bold">
                        <tr class="text-start text-muted text-uppercase gs-0">
                            <th>#</th>
                            <th>Detail Permohonan</th>
                            <th>Detail Tinjut</th>
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
        {{-- end::Card body --}}
    </div>
    {{-- end::Card --}}
</div>
{{-- end:::Tab pane --}}

@push('scripts')
    {{-- JS CUSTOM --}}
    <script>
        $(document).ready(function() {
            getStatistikTteSkhp();
        });

        $('[name="q_tahun"]').change(function() {
            var q_tahun = $(this).val();
            var q_tags = $('#q_tags').val();
            $('#datatableMenunggu tbody').empty();
            tableMenunggu.ajax.reload(null, true);
            getStatistikTteSkhp();
        });

        $('[name="q_tags"]').change(function() {
            var q_tags = $(this).val();
            var q_tahun = $('#q_tahun').val();
            $('#datatableMenunggu tbody').empty();
            tableMenunggu.ajax.reload(null, true);
            getStatistikTteSkhp();
        });

        var tableMenunggu = $('#datatableMenunggu').DataTable({
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
                url: "{!! route('scd.apps.tte.skhp.data') !!}",
                type: 'GET',
                data: function(data) {
                    data.filter = {
                        'tahun': $('#q_tahun').val(),
                        'tags': $('#q_tags').val(),
                        'status': "0",
                    };
                }
            },
            "columns": [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'detail_permohonan',
                    name: 'detail_permohonan'
                },
                {
                    data: 'detail_tinjut',
                    name: 'detail_tinjut'
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
                    targets: [0, 3]
                },
                {
                    className: "min-w-200px",
                    targets: [1]
                },
                {
                    className: "text-end",
                    targets: [3]
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

        $(document).on('click', "[data-disetujui]", function() {
            let uuid = $(this).attr('data-disetujui');
            let status = $(this).attr('data-status');
            Swal.fire({
                title: "Setujui TTE SKHP",
                text: "Apakah Anda Yakin?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Iya!",
                cancelButtonText: 'Tidak, Batalkan!',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{!! route('scd.apps.tte.skhp.status') !!}",
                        type: 'POST',
                        data: {
                            uuid: uuid,
                            status: status,
                            _method: 'put',
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(res) {
                            if (res.status == true) {
                                Swal.fire({
                                    title: "Success",
                                    text: res.message,
                                    icon: "success",
                                }).then((result) => {
                                    $('#datatableMenunggu').DataTable().ajax.reload();
                                    $('#datatableDisetujui').DataTable().ajax.reload();
                                    $('#datatableDitolak').DataTable().ajax.reload();
                                    getStatistikTteSkhp();
                                });
                            } else {
                                Swal.fire({
                                    title: "Error",
                                    text: res.message,
                                    icon: "error",
                                }).then((result) => {
                                    $('#datatableMenunggu').DataTable().ajax.reload();
                                    $('#datatableDisetujui').DataTable().ajax.reload();
                                    $('#datatableDitolak').DataTable().ajax.reload();
                                    getStatistikTteSkhp();
                                });
                            }
                        },
                        error: function(xhr) {
                            Swal.fire({
                                title: "Error",
                                text: xhr.responseJSON.message,
                                icon: "error",
                            }).then((result) => {
                                $('#datatableMenunggu').DataTable().ajax.reload();
                                $('#datatableDisetujui').DataTable().ajax.reload();
                                $('#datatableDitolak').DataTable().ajax.reload();
                                $('#datatableDitolak').DataTable().ajax.reload();
                                getStatistikTteSkhp();
                            });
                        }
                    });
                }
            });
        });

        $(document).on('click', "[data-ditolak]", function() {
            let uuid = $(this).attr('data-ditolak');
            let status = $(this).attr('data-status');
            Swal.fire({
                title: "Tolak TTE SKHP",
                text: "Apakah Anda Yakin?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Iya!",
                cancelButtonText: 'Tidak, Batalkan!',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{!! route('scd.apps.tte.skhp.status') !!}",
                        type: 'POST',
                        data: {
                            uuid: uuid,
                            status: status,
                            _method: 'put',
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(res) {
                            if (res.status == true) {
                                Swal.fire({
                                    title: "Success",
                                    text: res.message,
                                    icon: "success",
                                }).then((result) => {
                                    $('#datatableMenunggu').DataTable().ajax.reload();
                                    $('#datatableDisetujui').DataTable().ajax.reload();
                                    $('#datatableDitolak').DataTable().ajax.reload();
                                    getStatistikTteSkhp();
                                });
                            } else {
                                Swal.fire({
                                    title: "Error",
                                    text: res.message,
                                    icon: "error",
                                }).then((result) => {
                                    $('#datatableMenunggu').DataTable().ajax.reload();
                                    $('#datatableDisetujui').DataTable().ajax.reload();
                                    $('#datatableDitolak').DataTable().ajax.reload();
                                    getStatistikTteSkhp();
                                });
                            }
                        },
                        error: function(xhr) {
                            Swal.fire({
                                title: "Error",
                                text: xhr.responseJSON.message,
                                icon: "error",
                            }).then((result) => {
                                $('#datatableMenunggu').DataTable().ajax.reload();
                                $('#datatableDisetujui').DataTable().ajax.reload();
                                $('#datatableDitolak').DataTable().ajax.reload();
                                $('#datatableDitolak').DataTable().ajax.reload();
                                getStatistikTteSkhp();
                            });
                        }
                    });
                }
            });
        });

        function getStatistikTteSkhp() {
            $.ajax({
                url: "{!! route('ajax.scd.apps.sts.tte.skhp') !!}",
                type: 'POST',
                data: {
                    tahun: $('#q_tahun').val(),
                    tags: $('#q_tags').val(),
                    _method: 'post',
                    _token: "{{ csrf_token() }}"
                },
                success: function(res) {
                    $("#statistik_menunggu").html(res.data.jml_menunggu);
                    $("#statistik_disetujui").html(res.data.jml_disetujui);
                    $("#statistik_ditolak").html(res.data.jml_ditolak);
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
    </script>
@endpush
