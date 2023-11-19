{{-- begin:::Tab pane --}}
<div class="tab-pane fade" id="profile_tab_status_selesai" role="tabpanel">
    {{-- begin::Card --}}
    <div class="card pt-4 mb-6 mb-xl-9">
        {{-- begin::Card header --}}
        <div class="card-header border-0">
            {{-- begin::Card title --}}
            <div class="card-title">
                <h2>Status Selesai</h2>
            </div>
            {{-- end::Card title --}}
        </div>
        {{-- end::Card header --}}
        {{-- begin::Card body --}}
        <div class="card-body pt-0 pb-5">
            {{-- begin::Table wrapper --}}
            <div class="table-responsive">
                {{-- begin::Table --}}
                <table id="datatableSelesai" class="table table-striped table-hover table-row-bordered gy-5 gs-7 border rounded">
                    <thead class="border-bottom border-gray-200 fs-7 fw-bold">
                        <tr class="text-start text-muted text-uppercase gs-0">
                            <th>#</th>
                            <th>Detail Permohonan</th>
                            <th>Detail Pemohon</th>
                            <th>Tinjut</th>
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
        $('[name="q_tahun"]').change(function() {
            $('#datatableSelesai tbody').empty();
            tableSelesai.ajax.reload(null, true);
            getStatistikPermohonan();
        });

        var tableSelesai = $('#datatableSelesai').DataTable({
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
                url: "{!! route('scd.apps.pp.data', [$enc_tags]) !!}",
                type: 'GET',
                data: function(data) {
                    data.filter = {
                        'tahun': $('[name="q_tahun"]').val(),
                        'status': 'Selesai',
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
                    data: 'detail_pemohon',
                    name: 'detail_pemohon'
                },
                {
                    data: 'tinjut',
                    name: 'tinjut'
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
                    targets: [0, 4]
                },
                {
                    className: "min-w-200px",
                    targets: [1]
                },
                {
                    className: "min-w-300px",
                    targets: [2]
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

        $(document).on('click', "[data-reproses]", function() {
            let uuid = $(this).attr('data-reproses');
            let status = $(this).attr('data-status');
            Swal.fire({
                title: "Proses Kembali Permohonan",
                text: "Apakah Anda Yakin?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Iya, Proses Kembali Permohonan!",
                cancelButtonText: 'Tidak, Batalkan!',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{!! route('scd.apps.pp.status', [$enc_tags]) !!}",
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
                                    $('#datatableBaru').DataTable().ajax.reload();
                                    $('#datatableDiproses').DataTable().ajax.reload();
                                    $('#datatableSelesai').DataTable().ajax.reload();
                                    $('#datatableDitolak').DataTable().ajax.reload();
                                    getStatistikPermohonan();
                                });
                            } else {
                                Swal.fire({
                                    title: "Error",
                                    text: res.message,
                                    icon: "error",
                                }).then((result) => {
                                    $('#datatableBaru').DataTable().ajax.reload();
                                    $('#datatableDiproses').DataTable().ajax.reload();
                                    $('#datatableSelesai').DataTable().ajax.reload();
                                    $('#datatableDitolak').DataTable().ajax.reload();
                                    getStatistikPermohonan();
                                });
                            }
                        },
                        error: function(xhr) {
                            Swal.fire({
                                title: "Error",
                                text: xhr.responseJSON.message,
                                icon: "error",
                            }).then((result) => {
                                $('#datatableBaru').DataTable().ajax.reload();
                                $('#datatableDiproses').DataTable().ajax.reload();
                                $('#datatableSelesai').DataTable().ajax.reload();
                                $('#datatableDitolak').DataTable().ajax.reload();
                                getStatistikPermohonan();
                            });
                        }
                    });
                }
            });
        });
    </script>
@endpush
