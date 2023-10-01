{{-- begin::Toolbar --}}
<div class="toolbar py-5 py-lg-5" id="kt_toolbar">
    {{-- begin::Container --}}
    <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap">
        {{-- begin::Page title --}}
        <div class="page-title d-flex flex-column me-3">
            {{-- begin::Title --}}
            <h1 class="d-flex text-dark fw-bold my-1 fs-3">Permohonan Pengujian</h1>
            {{-- end::Title --}}
            {{-- begin::Breadcrumb --}}
            <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7 my-1">
                {{-- begin::Item --}}
                <li class="breadcrumb-item text-gray-600">
                    <a href="{{ route('pdp.apps.home.index') }}" class="text-gray-600 text-hover-info">Dashboard</a>
                </li>
                {{-- end::Item --}}
                {{-- begin::Item --}}
                <li class="breadcrumb-item text-gray-600">Data Permohonan</li>
                {{-- end::Item --}}
            </ul>
            {{-- end::Breadcrumb --}}
        </div>
        {{-- end::Page title --}}
        {{-- begin::Actions --}}
        <div class="d-flex align-items-center py-2 py-md-1">
            {{-- begin::Wrapper --}}
            <div class="me-3">
                {{-- begin::Menu --}}
                <a href="#" class="btn btn-light-info fw-bold" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                    <i class="ki-duotone ki-filter fs-5 text-gray-500 me-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>Filter</a>
                {{-- begin::Menu 1 --}}
                <div class="menu menu-sub menu-sub-dropdown w-250px w-md-300px" data-kt-menu="true" id="kt_menu_64b776c906de4">
                    {{-- begin::Header --}}
                    <div class="px-7 py-5">
                        <div class="fs-5 text-dark fw-bold">Filter Options</div>
                    </div>
                    {{-- end::Header --}}
                    {{-- begin::Menu separator --}}
                    <div class="separator border-gray-200"></div>
                    {{-- end::Menu separator --}}
                    {{-- begin::Form --}}
                    <div class="px-7 py-5">
                        {{-- begin::Input group --}}
                        <div class="mb-5">
                            {{-- begin::Label --}}
                            <label class="form-label fw-semibold">Status:</label>
                            {{-- end::Label --}}
                            {{-- begin::Input --}}
                            <div>
                                {{-- begin::Menu --}}
                                <select class="form-select" name="q_status" id="q_status">
                                    <option value="Baru" @if ($status == 'Baru') selected @endif>Baru</option>
                                    <option value="Diproses" @if ($status == 'Diproses') selected @endif>Diproses</option>
                                    <option value="Selesai" @if ($status == 'Selesai') selected @endif>Selesai</option>
                                    <option value="Ditolak" @if ($status == 'Ditolak') selected @endif>Ditolak</option>
                                    <option value="Semua Data" @if ($status == 'Semua Data') selected @endif>Semua Data</option>
                                </select>
                                {{-- end::Menu --}}
                            </div>
                            {{-- end::Input --}}
                        </div>
                        {{-- end::Input group --}}
                        {{-- begin::Input group --}}
                        <div class="mb-5">
                            {{-- begin::Label --}}
                            <label class="form-label fw-semibold">Tahun:</label>
                            {{-- end::Label --}}
                            {{-- begin::Input --}}
                            <div>
                                {{-- begin::Menu --}}
                                <select class="form-select" name="q_tahun" id="q_tahun">
                                    @if (\count($tahunPermohonan) > 0)
                                        @foreach ($tahunPermohonan as $item)
                                            <option value="{{ $item->year }}" @if ($tahun == $item->year) selected @endif>{{ $item->year }}</option>
                                        @endforeach
                                    @else
                                        <option value="{{ $tahun }}">{{ $tahun }}</option>
                                    @endif
                                </select>
                                {{-- end::Menu --}}
                            </div>
                            {{-- end::Input --}}
                        </div>
                        {{-- end::Input group --}}
                    </div>
                    {{-- end::Form --}}
                </div>
                {{-- end::Menu 1 --}}
                {{-- end::Menu --}}
            </div>
            {{-- end::Wrapper --}}
            {{-- begin::Button --}}
            <a href="{{ route('pdp.apps.reqpeneraan.create') }}" class="btn btn-info fw-bold"><i class="fa-solid fa-plus"></i>Ajukan Permohonan</a>
            {{-- end::Button --}}
        </div>
        {{-- end::Actions --}}
    </div>
    {{-- end::Container --}}
</div>
{{-- end::Toolbar --}}
