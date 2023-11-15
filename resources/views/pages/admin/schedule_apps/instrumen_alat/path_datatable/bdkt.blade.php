{{-- begin:::Tab pane --}}
<div class="tab-pane fade" id="profile_tab_bdkt" role="tabpanel">
    {{-- begin::Card --}}
    <div class="card pt-4 mb-6 mb-xl-9">
        {{-- begin::Card header --}}
        <div class="card-header border-0">
            {{-- begin::Card title --}}
            <div class="card-title">
                <h2>Pengujian BDKT</h2>
            </div>
            {{-- end::Card title --}}
        </div>
        {{-- end::Card header --}}
        {{-- begin::Card body --}}
        <div class="card-body pt-0 pb-5">
            {{-- begin::Table wrapper --}}
            <div class="table-responsive">
                {{-- begin::Table --}}
                <table id="datatableBDKT" class="table table-striped table-hover table-row-bordered gy-5 gs-7 border rounded">
                    <thead class="border-bottom border-gray-200 fs-7 fw-bold">
                        <tr class="text-start text-muted text-uppercase gs-0">
                            <th>#</th>
                            <th>Detail Permohonan</th>
                            <th>Data Petugas</th>
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
            getStatistikPenugasan();
        });

        $('[name="q_tahun"]').change(function() {
            var q_tahun = $(this).val();
            var q_status = $('#q_status').val();
            $('#datatableBDKT tbody').empty();
            tableBDKT.ajax.reload(null, true);
            getStatistikPenugasan();
        });

        $('[name="q_status"]').change(function() {
            var q_status = $(this).val();
            var q_tahun = $('#q_tahun').val();
            $('#datatableBDKT tbody').empty();
            tableBDKT.ajax.reload(null, true);
            getStatistikPenugasan();
        });

        var tableBDKT = $('#datatableBDKT').DataTable({
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
                url: "{!! route('scd.apps.insalat.data') !!}",
                type: 'GET',
                data: function(data) {
                    data.filter = {
                        'tahun': $('#q_tahun').val(),
                        'status': $('#q_status').val(),
                        'tags': 'Pengujian BDKT',
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
                    data: 'detail_pdp',
                    name: 'detail_pdp'
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

        function getStatistikPenugasan() {
            $.ajax({
                url: "{!! route('ajax.scd.apps.sts.penugasan') !!}",
                type: 'POST',
                data: {
                    tahun: $('#q_tahun').val(),
                    status: $('#q_status').val(),
                    _method: 'post',
                    _token: "{{ csrf_token() }}"
                },
                success: function(res) {
                    $("#statistik_tera").html(res.data.jml_tera);
                    $("#statistik_tera_ulang").html(res.data.jml_tera_ulang);
                    $("#statistik_bdkt").html(res.data.jml_bdkt);
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
