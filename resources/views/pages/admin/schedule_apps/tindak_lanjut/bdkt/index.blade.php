@extends('layouts.admin.settings')
@push('apps')
    SIMEGAL
@endpush
@push('title')
    Barang Dalam Keadaan Terbungkus (BDKT) | Tindak Lanjut | SIMEGAL
@endpush
@push('description')
    Barang Dalam Keadaan Terbungkus (BDKT) | Tindak Lanjut | Sistem Informasi Metrologi Legal Pemerintah Kabupaten Tangerang
@endpush
@push('header-title')
    Barang Dalam Keadaan Terbungkus (BDKT) | Tindak Lanjut
@endpush

{{-- TOOLBOX::BEGIN --}}
@push('toolbox')
    {{-- begin::Toolbar --}}
    <div class="toolbar py-5 py-lg-5" id="kt_toolbar">
        {{-- begin::Container --}}
        <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap">
            {{-- begin::Page title --}}
            <div class="page-title d-flex flex-column me-3">
                {{-- begin::Title --}}
                <h1 class="d-flex text-dark fw-bold my-1 fs-3">Tindak Lanjut</h1>
                {{-- end::Title --}}
                {{-- begin::Breadcrumb --}}
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 pt-1">
                    {{-- begin::Item --}}
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('scd.apps.home.index') }}" class="text-muted text-hover-primary">Dashboard</a>
                    </li>
                    {{-- end::Item --}}
                    {{-- begin::Item --}}
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-200 w-5px h-2px"></span>
                    </li>
                    {{-- end::Item --}}
                    {{-- begin::Item --}}
                    <li class="breadcrumb-item text-dark">Barang Dalam Keadaan Terbungkus (BDKT)</li>
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
                    <select class="form-select" name="q_tahun" id="q_tahun">
                        @if (\count($tahunPermohonan) > 0)
                            @foreach ($tahunPermohonan as $item)
                                <option value="{{ $item->year }}" @if ($tahun == $item->year) selected @endif>{{ $item->year }}</option>
                            @endforeach
                        @else
                            @for ($year = \date('Y') - 5; $year <= \date('Y'); $year++)
                                <option value="{{ $year }}" @if ($tahun == $year) selected @endif>{{ $year }}</option>
                            @endfor
                        @endif
                    </select>
                    {{-- end::Menu --}}
                </div>
                {{-- end::Wrapper --}}
            </div>
            {{-- end::Actions --}}
        </div>
        {{-- end::Container --}}
    </div>
    {{-- end::Toolbar --}}
@endpush
{{-- TOOLBOX::END --}}

{{-- CONTENT::BEGIN --}}
@section('content')
    {{-- begin::Post --}}
    <div class="post d-flex flex-column-fluid" id="kt_post">
        {{-- begin::Container --}}
        <div id="kt_content_container" class="container-xxl">
            {{-- begin::Layout --}}
            <div class="d-flex flex-column flex-lg-row">

                {{-- begin::Content --}}
                <div class="flex-lg-row-fluid">
                    {{-- begin:::Tabs --}}
                    <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-semibold mb-8 tabs-profile">
                        {{-- begin:::Tab item --}}
                        <li class="nav-item">
                            <a class="nav-link text-active-info pb-4 path-tab" data-bs-toggle="tab" href="#profile_tab_bdkt">Pengujian BDKT <span class="badge badge-info" id="statistik_bdkt"></span></a>
                        </li>
                        {{-- end:::Tab item --}}
                    </ul>
                    {{-- end:::Tabs --}}

                    {{-- begin:::Tab content --}}
                    <div class="tab-content" id="myTabContent">
                        {{-- path-baru::begin --}}
                        @include('pages.admin.schedule_apps.tindak_lanjut.bdkt.path_datatable.bdkt')
                        {{-- path-baru::end --}}
                    </div>
                    {{-- end:::Tab content --}}
                </div>
                {{-- end::Content --}}

            </div>
            {{-- end::Layout --}}
        </div>
        {{-- end::Container --}}
    </div>
    {{-- end::Post --}}
@endsection
{{-- CONTENT::END --}}

{{-- modal::begin --}}
@push('modals')
@endpush
{{-- modal::end --}}

@push('scripts')
    {{-- JS CUSTOM --}}
    <script>
        $(document).ready(function() {
            getTabsProfil();
            $(".path-tab").click(function() {
                var href = $(this).attr('href');
                localStorage.setItem('tabsTinjutBdkt', href);
            })
        });

        function getTabsProfil() {
            var tabsTinjutBdkt = localStorage.getItem('tabsTinjutBdkt');
            if (tabsTinjutBdkt === null) {
                localStorage.setItem('tabsTinjutBdkt', '#profile_tab_bdkt');
                $(".tabs-profile>li").each(function(index) {
                    if ($(this).find('a[href^="#profile_tab_bdkt"]')) {
                        $('a[href^="#profile_tab_bdkt"]').addClass(" active");
                        $('#profile_tab_bdkt').addClass(" show active");
                    }
                });
            } else {
                $(".tabs-profile>li").each(function(index) {
                    if ($(this).find('a[href^="' + tabsTinjutBdkt + '"]')) {
                        $('a[href^="' + tabsTinjutBdkt + '"]').addClass(" active");
                        $(tabsTinjutBdkt).addClass(" show active");
                    }
                });
            }
        }

        function getStatistikPenugasan() {
            $.ajax({
                url: "{!! route('ajax.scd.apps.sts.tinjut.bdkt') !!}",
                type: 'POST',
                data: {
                    tahun: $('#q_tahun').val(),
                    _method: 'post',
                    _token: "{{ csrf_token() }}"
                },
                success: function(res) {
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
