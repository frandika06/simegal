{{-- begin::Toolbar --}}
<div class="toolbar py-5 py-lg-5" id="kt_toolbar">
    {{-- begin::Container --}}
    <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap">
        {{-- begin::Page title --}}
        <div class="page-title d-flex flex-column me-3">
            {{-- begin::Title --}}
            <h1 class="d-flex text-dark fw-bold my-1 fs-3">Profile</h1>
            {{-- end::Title --}}
            {{-- begin::Breadcrumb --}}
            <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7 my-1">
                {{-- begin::Item --}}
                <li class="breadcrumb-item text-gray-600">
                    <a href="{{ route('pdp.apps.home.index') }}" class="text-gray-600 text-hover-primary">Dashboard</a>
                </li>
                {{-- end::Item --}}
                {{-- begin::Item --}}
                <li class="breadcrumb-item text-gray-600">Profile</li>
                {{-- end::Item --}}
                {{-- begin::Item --}}
                <li class="breadcrumb-item text-gray-500">Detail</li>
                {{-- end::Item --}}
            </ul>
            {{-- end::Breadcrumb --}}
        </div>
        {{-- end::Page title --}}
    </div>
    {{-- end::Container --}}
</div>
{{-- end::Toolbar --}}
