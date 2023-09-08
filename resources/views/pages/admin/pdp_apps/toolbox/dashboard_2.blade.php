{{-- begin::Toolbar --}}
<div class="toolbar py-5 py-lg-5" id="kt_toolbar">
    {{-- begin::Container --}}
    <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap">
        {{-- begin::Page title --}}
        <div class="page-title d-flex flex-column me-3">
            {{-- begin::Title --}}
            <h1 class="d-flex text-dark fw-bold my-1 fs-3">Dashboard</h1>
            {{-- end::Title --}}
        </div>
        {{-- end::Page title --}}
        {{-- begin::Actions --}}
        <div class="d-flex align-items-center py-2 py-md-1">
            {{-- begin::Wrapper --}}
            <div class="me-3">
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
            {{-- end::Wrapper --}}
            {{-- begin::Button --}}
            <a href="{{ route('pdp.apps.reqpeneraan.create') }}" class="btn btn-info fw-bold">Ajukan Permohonan</a>
            {{-- end::Button --}}
        </div>
        {{-- end::Actions --}}
    </div>
    {{-- end::Container --}}
</div>
{{-- end::Toolbar --}}
