{{-- begin:::Tab pane --}}
<div class="tab-pane fade" id="profile_tab_path_alamat" role="tabpanel">
    {{-- begin::Card --}}
    <div class="card pt-4 mb-6 mb-xl-9">
        {{-- begin::Card header --}}
        <div class="card-header border-0">
            {{-- begin::Card title --}}
            <div class="card-title flex-column">
                <h2>Data Alamat</h2>
                <div class="fs-6 fw-semibold text-muted">Halaman untuk mengubah data alamat Perusahaan/Usaha.</div>
            </div>
            {{-- end::Card title --}}
        </div>
        {{-- end::Card header --}}
        {{-- begin::Card body --}}
        <div class="card-body">
            @if (\count($alamatPerusahaan) > 0)
                {{-- ADA DATA --}}
                @foreach ($alamatPerusahaan as $item)
                    {{-- begin::Item --}}
                    <div class="d-flex flex-stack">
                        {{-- begin::Content --}}
                        <div class="d-flex flex-column">
                            <span data-kt-buttons="true" data-kt-buttons-target=".form-check-flex, .form-check-default">
                                <label class="form-check-flex" data-default-uuid="{{ \CID::encode($item->uuid) }}">
                                    <div class="form-check form-check-custom form-check-solid">
                                        <input class="form-check-default" type="radio" value="{{ $item->uuid }}" name="default" @if ($item->default == '1') checked @endif disabled>
                                        <div class="form-check-label fw-bold">
                                            <strong>{{ $item->label_alamat }} - {{ \Str::title($item->Kecamatan->name) }}</strong>
                                        </div>
                                    </div>
                                </label>
                            </span>
                            <div class="text-gray-600">
                                {{ $item->alamat }}, {{ isset($item->rt) ? 'RT. ' . $item->rt . ', ' : '' }}
                                {{ isset($item->rw) ? 'RW. ' . $item->rw . ', ' : '' }}
                                {{ \Str::title($item->Desa->name) }}, {{ \Str::title($item->Kecamatan->name) }},
                                {{ \Str::title($item->Kabupaten->name) }}, {{ \Str::title($item->Provinsi->name) }}{{ isset($item->kode_pos) ? ', ' . $item->kode_pos . '.' : '.' }}
                            </div>
                        </div>
                        {{-- end::Content --}}
                        {{-- begin::Action --}}
                        @if ($item->google_maps != '' || ($item->lat != '' && $item->long != ''))
                            <div class="d-flex justify-content-end align-items-center">
                                {{-- begin::Actions --}}
                                <a href="javascript:void(0);" class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Aksi
                                    <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                                {{-- begin::Menu --}}
                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                    @if ($item->google_maps != '')
                                        @php
                                            $url_maps = $item->google_maps;
                                        @endphp
                                    @elseif($item->lat != '' && $item->long != '')
                                        @php
                                            $url_maps = 'https://www.google.com/maps/search/?api=1&query=' . $item->lat . ',' . $item->long . '';
                                        @endphp
                                    @endif
                                    {{-- begin::Menu item --}}
                                    <div class="menu-item px-3">
                                        <a target="_BLANK" href="{{ $url_maps }}" class="menu-link px-3"><i class="fa-solid fa-map-location-dot me-2"></i> Maps</a>
                                    </div>
                                </div>
                                {{-- end::Menu --}}
                            </div>
                            {{-- end::Action --}}
                        @endif
                    </div>
                    {{-- end::Item --}}
                    {{-- begin:Separator --}}
                    <div class="separator separator-dashed my-5"></div>
                @endforeach
            @else
                {{-- TIDAK ADA DATA --}}
            @endif
        </div>
        {{-- end::Card body --}}
        {{-- begin::Card footer --}}
        {{-- end::Card footer --}}
    </div>
    {{-- end::Card --}}
</div>
{{-- end:::Tab pane --}}

@push('scripts')
@endpush
