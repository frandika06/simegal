<!--begin:::Tab pane-->
<div class="tab-pane fade" id="profile_tab_path_log" role="tabpanel">
    <!--begin::Card-->
    <div class="card pt-4 mb-6 mb-xl-9">
        <!--begin::Card header-->
        <div class="card-header border-0">
            <!--begin::Card title-->
            <div class="card-title">
                <h2>Log Login</h2>
            </div>
            <!--end::Card title-->
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body pt-0 pb-5">
            <!--begin::Table wrapper-->
            <div class="table-responsive">
                <!--begin::Table-->
                <table class="table align-middle table-row-dashed gy-5" id="kt_table_users_login_session">
                    <thead class="border-bottom border-gray-200 fs-7 fw-bold">
                        <tr class="text-start text-muted text-uppercase gs-0">
                            <th>Status</th>
                            <th>IP</th>
                            <th>Device</th>
                            <th>Media</th>
                        </tr>
                    </thead>
                    <tbody class="fs-6 fw-semibold text-gray-600">
                        @foreach ($logs_login as $item)
                            <tr>
                                <td>{{ $item->status }}</td>
                                <td>{{ $item->ip }}</td>
                                <td>{{ $item->agent }}</td>
                                <td>{{ $item->device }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <!--end::Table-->
            </div>
            <!--end::Table wrapper-->
        </div>
        <!--end::Card body-->
    </div>
    <!--end::Card-->
    <!--begin::Card-->
    <div class="card pt-4 mb-6 mb-xl-9">
        <!--begin::Card header-->
        <div class="card-header border-0">
            <!--begin::Card title-->
            <div class="card-title">
                <h2>Log Aktifitas</h2>
            </div>
            <!--end::Card title-->
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body py-0">
            <!--begin::Table wrapper-->
            <div class="table-responsive">
                <!--begin::Table-->
                <table class="table align-middle table-row-dashed gy-5" id="kt_table_users_login_session">
                    <thead class="border-bottom border-gray-200 fs-7 fw-bold">
                        <tr class="text-start text-muted text-uppercase gs-0">
                            <th>Subjek</th>
                            <th>IP</th>
                            <th>Method</th>
                            <th>Media</th>
                            <th class="min-w-125px">Waktu</th>
                        </tr>
                    </thead>
                    <tbody class="fs-6 fw-semibold text-gray-600">
                        @foreach ($logs_aktifitas as $item)
                            <tr>
                                <td>{{ $item->subjek }}</td>
                                <td>{{ $item->ip }}</td>
                                <td>{{ $item->method }}</td>
                                <td>{{ $item->device }}</td>
                                <td>{{ \CID::TglJam($item->created_at) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <!--end::Table-->
            </div>
            <!--end::Table wrapper-->
        </div>
        <!--end::Card body-->
    </div>
    <!--end::Card-->
</div>
<!--end:::Tab pane-->
