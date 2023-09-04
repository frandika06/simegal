@extends('layouts.admin.pdp')
@push('apps')
    SIMEGAL
@endpush
@push('title')
    Dashboard | SIMEGAL
@endpush
@push('description')
    Dashboard | Sistem Informasi Metrologi Legal Pemerintah Kabupaten Tangerang
@endpush
@push('header-title')
    Dashboard
@endpush
@push('styles')
    <!--begin::Vendor Stylesheets(used for this page only)-->
    <link href="{{ asset('assets-pdp/plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets-pdp/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Vendor Stylesheets-->
@endpush

{{-- TOOLBOX::BEGIN --}}
@push('toolbox')
    @if ($profile->file_npwp === null || $profile->file_npwp == '')
        @include('pages.admin.pdp_apps.toolbox.dashboard_1')
    @else
        @include('pages.admin.pdp_apps.toolbox.dashboard_2')
    @endif
@endpush
{{-- TOOLBOX::END --}}

@section('content')
    <!--begin::Post-->
    <div class="content flex-row-fluid" id="kt_content">
        <!--begin::Row-->
        <div class="row gy-0 gx-10">
            <!--begin::Col-->
            <div class="col-xl-12">
                <!--begin::General Widget 1-->
                <div class="mb-10">
                    <!--begin::Tabs-->
                    <ul class="nav row mb-10">
                        <li class="nav-item col-12 col-lg mb-5 mb-lg-0">
                            <a class="nav-link btn btn-flex btn-color-gray-400 btn-outline btn-active-info d-flex flex-grow-1 flex-column flex-center py-5 h-1250px h-lg-175px active" data-bs-toggle="tab" href="#kt_general_widget_1_1">
                                <i class="ki-duotone ki-click fs-2x mb-5 mx-0">
                                    <i class="path1"></i>
                                    <i class="path2"></i>
                                    <i class="path3"></i>
                                    <i class="path4"></i>
                                    <i class="path5"></i>
                                </i>
                                <span class="fs-6 fw-bold">Status Baru</span>
                            </a>
                        </li>
                        <li class="nav-item col-12 col-lg mb-5 mb-lg-0">
                            <a class="nav-link btn btn-flex btn-color-gray-400 btn-outline btn-active-info d-flex flex-grow-1 flex-column flex-center py-5 h-1250px h-lg-175px" data-bs-toggle="tab" href="#kt_general_widget_1_2">
                                <i class="ki-duotone ki-loading fs-2x mb-5 mx-0">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                <span class="fs-6 fw-bold">Status Diproses</span>
                            </a>
                        </li>
                        <li class="nav-item col-12 col-lg mb-5 mb-lg-0">
                            <a class="nav-link btn btn-flex btn-color-gray-400 btn-outline btn-active-info d-flex flex-grow-1 flex-column flex-center py-5 h-1250px h-lg-175px" data-bs-toggle="tab" href="#kt_general_widget_1_3">
                                <i class="ki-duotone ki-archive-tick fs-2x mb-5 mx-0">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                <span class="fs-6 fw-bold">Status Selesai</span>
                            </a>
                        </li>
                        <li class="nav-item col-12 col-lg mb-5 mb-lg-0">
                            <a class="nav-link btn btn-flex btn-color-gray-400 btn-outline btn-active-info d-flex flex-grow-1 flex-column flex-center py-5 h-1250px h-lg-175px" data-bs-toggle="tab" href="#kt_general_widget_1_4">
                                <i class="ki-duotone ki-tag-cross fs-2x mb-5 mx-0">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                </i>
                                <span class="fs-6 fw-bold">Status Ditolak</span>
                            </a>
                        </li>
                    </ul>
                    <!--begin::Tab content-->
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="kt_general_widget_1_1">
                            <!--begin::Products-->
                            <div class="card card-flush">
                                <!--begin::Card header-->
                                <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                                    <!--begin::Card title-->
                                    <div class="card-title">
                                        <!--begin::Search-->
                                        <div class="d-flex align-items-center position-relative my-1">
                                            <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-4">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                            <input type="text" data-kt-ecommerce-product-filter="search" class="form-control form-control-solid w-250px ps-12" placeholder="Search Product" />
                                        </div>
                                        <!--end::Search-->
                                    </div>
                                    <!--end::Card title-->
                                    <!--begin::Card toolbar-->
                                    <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                                        <div class="w-100 mw-150px">
                                            <!--begin::Select2-->
                                            <select class="form-select form-select-solid" data-control="select2" data-hide-search="true" data-placeholder="Status" data-kt-ecommerce-product-filter="status">
                                                <option></option>
                                                <option value="all">All</option>
                                                <option value="published">Published</option>
                                                <option value="scheduled">Scheduled</option>
                                                <option value="inactive">Inactive</option>
                                            </select>
                                            <!--end::Select2-->
                                        </div>
                                        <!--begin::Add product-->
                                        <a href="../../demo11/dist/apps/ecommerce/catalog/add-product.html" class="btn btn-primary">Add Product</a>
                                        <!--end::Add product-->
                                    </div>
                                    <!--end::Card toolbar-->
                                </div>
                                <!--end::Card header-->
                                <!--begin::Card body-->
                                <div class="card-body pt-0">
                                    <!--begin::Table-->
                                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_products_table">
                                        <thead>
                                            <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                                <th class="w-10px pe-2">
                                                    <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                                        <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_ecommerce_products_table .form-check-input" value="1" />
                                                    </div>
                                                </th>
                                                <th class="min-w-200px">Product</th>
                                                <th class="text-end min-w-100px">SKU</th>
                                                <th class="text-end min-w-70px">Qty</th>
                                                <th class="text-end min-w-100px">Price</th>
                                                <th class="text-end min-w-100px">Rating</th>
                                                <th class="text-end min-w-100px">Status</th>
                                                <th class="text-end min-w-70px">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody class="fw-semibold text-gray-600">
                                            <tr>
                                                <td>
                                                    <div class="form-check form-check-sm form-check-custom form-check-solid">
                                                        <input class="form-check-input" type="checkbox" value="1" />
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <!--begin::Thumbnail-->
                                                        <a href="../../demo11/dist/apps/ecommerce/catalog/edit-product.html" class="symbol symbol-50px">
                                                            <span class="symbol-label" style="background-image:url(assets/media//stock/ecommerce/1.png);"></span>
                                                        </a>
                                                        <!--end::Thumbnail-->
                                                        <div class="ms-5">
                                                            <!--begin::Title-->
                                                            <a href="../../demo11/dist/apps/ecommerce/catalog/edit-product.html" class="text-gray-800 text-hover-primary fs-5 fw-bold" data-kt-ecommerce-product-filter="product_name">Product 1</a>
                                                            <!--end::Title-->
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-end pe-0">
                                                    <span class="fw-bold">03188007</span>
                                                </td>
                                                <td class="text-end pe-0" data-order="46">
                                                    <span class="fw-bold ms-3">46</span>
                                                </td>
                                                <td class="text-end pe-0">278</td>
                                                <td class="text-end pe-0" data-order="rating-4">
                                                    <div class="rating justify-content-end">
                                                        <div class="rating-label checked">
                                                            <i class="ki-duotone ki-star fs-6"></i>
                                                        </div>
                                                        <div class="rating-label checked">
                                                            <i class="ki-duotone ki-star fs-6"></i>
                                                        </div>
                                                        <div class="rating-label checked">
                                                            <i class="ki-duotone ki-star fs-6"></i>
                                                        </div>
                                                        <div class="rating-label checked">
                                                            <i class="ki-duotone ki-star fs-6"></i>
                                                        </div>
                                                        <div class="rating-label">
                                                            <i class="ki-duotone ki-star fs-6"></i>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-end pe-0" data-order="Scheduled">
                                                    <!--begin::Badges-->
                                                    <div class="badge badge-light-primary">Scheduled</div>
                                                    <!--end::Badges-->
                                                </td>
                                                <td class="text-end">
                                                    <a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                                                        <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                                                    <!--begin::Menu-->
                                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                                        <!--begin::Menu item-->
                                                        <div class="menu-item px-3">
                                                            <a href="../../demo11/dist/apps/ecommerce/catalog/edit-product.html" class="menu-link px-3">Edit</a>
                                                        </div>
                                                        <!--end::Menu item-->
                                                        <!--begin::Menu item-->
                                                        <div class="menu-item px-3">
                                                            <a href="#" class="menu-link px-3" data-kt-ecommerce-product-filter="delete_row">Delete</a>
                                                        </div>
                                                        <!--end::Menu item-->
                                                    </div>
                                                    <!--end::Menu-->
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="form-check form-check-sm form-check-custom form-check-solid">
                                                        <input class="form-check-input" type="checkbox" value="1" />
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <!--begin::Thumbnail-->
                                                        <a href="../../demo11/dist/apps/ecommerce/catalog/edit-product.html" class="symbol symbol-50px">
                                                            <span class="symbol-label" style="background-image:url(assets/media//stock/ecommerce/2.png);"></span>
                                                        </a>
                                                        <!--end::Thumbnail-->
                                                        <div class="ms-5">
                                                            <!--begin::Title-->
                                                            <a href="../../demo11/dist/apps/ecommerce/catalog/edit-product.html" class="text-gray-800 text-hover-primary fs-5 fw-bold" data-kt-ecommerce-product-filter="product_name">Product 2</a>
                                                            <!--end::Title-->
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-end pe-0">
                                                    <span class="fw-bold">03128001</span>
                                                </td>
                                                <td class="text-end pe-0" data-order="41">
                                                    <span class="fw-bold ms-3">41</span>
                                                </td>
                                                <td class="text-end pe-0">163</td>
                                                <td class="text-end pe-0" data-order="rating-5">
                                                    <div class="rating justify-content-end">
                                                        <div class="rating-label checked">
                                                            <i class="ki-duotone ki-star fs-6"></i>
                                                        </div>
                                                        <div class="rating-label checked">
                                                            <i class="ki-duotone ki-star fs-6"></i>
                                                        </div>
                                                        <div class="rating-label checked">
                                                            <i class="ki-duotone ki-star fs-6"></i>
                                                        </div>
                                                        <div class="rating-label checked">
                                                            <i class="ki-duotone ki-star fs-6"></i>
                                                        </div>
                                                        <div class="rating-label checked">
                                                            <i class="ki-duotone ki-star fs-6"></i>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-end pe-0" data-order="Inactive">
                                                    <!--begin::Badges-->
                                                    <div class="badge badge-light-danger">Inactive</div>
                                                    <!--end::Badges-->
                                                </td>
                                                <td class="text-end">
                                                    <a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                                                        <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                                                    <!--begin::Menu-->
                                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                                        <!--begin::Menu item-->
                                                        <div class="menu-item px-3">
                                                            <a href="../../demo11/dist/apps/ecommerce/catalog/edit-product.html" class="menu-link px-3">Edit</a>
                                                        </div>
                                                        <!--end::Menu item-->
                                                        <!--begin::Menu item-->
                                                        <div class="menu-item px-3">
                                                            <a href="#" class="menu-link px-3" data-kt-ecommerce-product-filter="delete_row">Delete</a>
                                                        </div>
                                                        <!--end::Menu item-->
                                                    </div>
                                                    <!--end::Menu-->
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="form-check form-check-sm form-check-custom form-check-solid">
                                                        <input class="form-check-input" type="checkbox" value="1" />
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <!--begin::Thumbnail-->
                                                        <a href="../../demo11/dist/apps/ecommerce/catalog/edit-product.html" class="symbol symbol-50px">
                                                            <span class="symbol-label" style="background-image:url(assets/media//stock/ecommerce/3.png);"></span>
                                                        </a>
                                                        <!--end::Thumbnail-->
                                                        <div class="ms-5">
                                                            <!--begin::Title-->
                                                            <a href="../../demo11/dist/apps/ecommerce/catalog/edit-product.html" class="text-gray-800 text-hover-primary fs-5 fw-bold" data-kt-ecommerce-product-filter="product_name">Product 3</a>
                                                            <!--end::Title-->
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-end pe-0">
                                                    <span class="fw-bold">03847006</span>
                                                </td>
                                                <td class="text-end pe-0" data-order="35">
                                                    <span class="fw-bold ms-3">35</span>
                                                </td>
                                                <td class="text-end pe-0">218</td>
                                                <td class="text-end pe-0" data-order="rating-3">
                                                    <div class="rating justify-content-end">
                                                        <div class="rating-label checked">
                                                            <i class="ki-duotone ki-star fs-6"></i>
                                                        </div>
                                                        <div class="rating-label checked">
                                                            <i class="ki-duotone ki-star fs-6"></i>
                                                        </div>
                                                        <div class="rating-label checked">
                                                            <i class="ki-duotone ki-star fs-6"></i>
                                                        </div>
                                                        <div class="rating-label">
                                                            <i class="ki-duotone ki-star fs-6"></i>
                                                        </div>
                                                        <div class="rating-label">
                                                            <i class="ki-duotone ki-star fs-6"></i>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-end pe-0" data-order="Published">
                                                    <!--begin::Badges-->
                                                    <div class="badge badge-light-success">Published</div>
                                                    <!--end::Badges-->
                                                </td>
                                                <td class="text-end">
                                                    <a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                                                        <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                                                    <!--begin::Menu-->
                                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                                        <!--begin::Menu item-->
                                                        <div class="menu-item px-3">
                                                            <a href="../../demo11/dist/apps/ecommerce/catalog/edit-product.html" class="menu-link px-3">Edit</a>
                                                        </div>
                                                        <!--end::Menu item-->
                                                        <!--begin::Menu item-->
                                                        <div class="menu-item px-3">
                                                            <a href="#" class="menu-link px-3" data-kt-ecommerce-product-filter="delete_row">Delete</a>
                                                        </div>
                                                        <!--end::Menu item-->
                                                    </div>
                                                    <!--end::Menu-->
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="form-check form-check-sm form-check-custom form-check-solid">
                                                        <input class="form-check-input" type="checkbox" value="1" />
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <!--begin::Thumbnail-->
                                                        <a href="../../demo11/dist/apps/ecommerce/catalog/edit-product.html" class="symbol symbol-50px">
                                                            <span class="symbol-label" style="background-image:url(assets/media//stock/ecommerce/4.png);"></span>
                                                        </a>
                                                        <!--end::Thumbnail-->
                                                        <div class="ms-5">
                                                            <!--begin::Title-->
                                                            <a href="../../demo11/dist/apps/ecommerce/catalog/edit-product.html" class="text-gray-800 text-hover-primary fs-5 fw-bold" data-kt-ecommerce-product-filter="product_name">Product 4</a>
                                                            <!--end::Title-->
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-end pe-0">
                                                    <span class="fw-bold">03928006</span>
                                                </td>
                                                <td class="text-end pe-0" data-order="35">
                                                    <span class="fw-bold ms-3">35</span>
                                                </td>
                                                <td class="text-end pe-0">150</td>
                                                <td class="text-end pe-0" data-order="rating-4">
                                                    <div class="rating justify-content-end">
                                                        <div class="rating-label checked">
                                                            <i class="ki-duotone ki-star fs-6"></i>
                                                        </div>
                                                        <div class="rating-label checked">
                                                            <i class="ki-duotone ki-star fs-6"></i>
                                                        </div>
                                                        <div class="rating-label checked">
                                                            <i class="ki-duotone ki-star fs-6"></i>
                                                        </div>
                                                        <div class="rating-label checked">
                                                            <i class="ki-duotone ki-star fs-6"></i>
                                                        </div>
                                                        <div class="rating-label">
                                                            <i class="ki-duotone ki-star fs-6"></i>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-end pe-0" data-order="Published">
                                                    <!--begin::Badges-->
                                                    <div class="badge badge-light-success">Published</div>
                                                    <!--end::Badges-->
                                                </td>
                                                <td class="text-end">
                                                    <a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                                                        <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                                                    <!--begin::Menu-->
                                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                                        <!--begin::Menu item-->
                                                        <div class="menu-item px-3">
                                                            <a href="../../demo11/dist/apps/ecommerce/catalog/edit-product.html" class="menu-link px-3">Edit</a>
                                                        </div>
                                                        <!--end::Menu item-->
                                                        <!--begin::Menu item-->
                                                        <div class="menu-item px-3">
                                                            <a href="#" class="menu-link px-3" data-kt-ecommerce-product-filter="delete_row">Delete</a>
                                                        </div>
                                                        <!--end::Menu item-->
                                                    </div>
                                                    <!--end::Menu-->
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="form-check form-check-sm form-check-custom form-check-solid">
                                                        <input class="form-check-input" type="checkbox" value="1" />
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <!--begin::Thumbnail-->
                                                        <a href="../../demo11/dist/apps/ecommerce/catalog/edit-product.html" class="symbol symbol-50px">
                                                            <span class="symbol-label" style="background-image:url(assets/media//stock/ecommerce/5.png);"></span>
                                                        </a>
                                                        <!--end::Thumbnail-->
                                                        <div class="ms-5">
                                                            <!--begin::Title-->
                                                            <a href="../../demo11/dist/apps/ecommerce/catalog/edit-product.html" class="text-gray-800 text-hover-primary fs-5 fw-bold" data-kt-ecommerce-product-filter="product_name">Product 5</a>
                                                            <!--end::Title-->
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-end pe-0">
                                                    <span class="fw-bold">02515002</span>
                                                </td>
                                                <td class="text-end pe-0" data-order="1">
                                                    <span class="badge badge-light-warning">Low stock</span>
                                                    <span class="fw-bold text-warning ms-3">1</span>
                                                </td>
                                                <td class="text-end pe-0">22</td>
                                                <td class="text-end pe-0" data-order="rating-3">
                                                    <div class="rating justify-content-end">
                                                        <div class="rating-label checked">
                                                            <i class="ki-duotone ki-star fs-6"></i>
                                                        </div>
                                                        <div class="rating-label checked">
                                                            <i class="ki-duotone ki-star fs-6"></i>
                                                        </div>
                                                        <div class="rating-label checked">
                                                            <i class="ki-duotone ki-star fs-6"></i>
                                                        </div>
                                                        <div class="rating-label">
                                                            <i class="ki-duotone ki-star fs-6"></i>
                                                        </div>
                                                        <div class="rating-label">
                                                            <i class="ki-duotone ki-star fs-6"></i>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-end pe-0" data-order="Published">
                                                    <!--begin::Badges-->
                                                    <div class="badge badge-light-success">Published</div>
                                                    <!--end::Badges-->
                                                </td>
                                                <td class="text-end">
                                                    <a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                                                        <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                                                    <!--begin::Menu-->
                                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                                        <!--begin::Menu item-->
                                                        <div class="menu-item px-3">
                                                            <a href="../../demo11/dist/apps/ecommerce/catalog/edit-product.html" class="menu-link px-3">Edit</a>
                                                        </div>
                                                        <!--end::Menu item-->
                                                        <!--begin::Menu item-->
                                                        <div class="menu-item px-3">
                                                            <a href="#" class="menu-link px-3" data-kt-ecommerce-product-filter="delete_row">Delete</a>
                                                        </div>
                                                        <!--end::Menu item-->
                                                    </div>
                                                    <!--end::Menu-->
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <!--end::Table-->
                                </div>
                                <!--end::Card body-->
                            </div>
                            <!--end::Products-->
                        </div>
                        <div class="tab-pane fade" id="kt_general_widget_1_2">
                            <!--begin::Tables Widget 3-->
                            <!--end::Tables Widget 3-->
                        </div>
                        <div class="tab-pane fade" id="kt_general_widget_1_3">
                            <!--begin::Tables Widget 5-->
                            <!--end::Tables Widget 5-->
                        </div>
                        <div class="tab-pane fade" id="kt_general_widget_1_4">
                            <!--begin::Tables Widget 4-->
                            <!--end::Tables Widget 4-->
                        </div>
                    </div>
                    <!--end::Tab content-->
                </div>
                <!--end::General Widget 1-->
            </div>
            <!--end::Col-->
        </div>
        <!--end::Row-->
    </div>
    <!--end::Post-->
@endsection

@push('scripts')
    <!--begin::Vendors Javascript(used for this page only)-->
    <script src="{{ asset('assets-pdp/plugins/custom/fullcalendar/fullcalendar.bundle.js') }}"></script>
    <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/radar.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/map.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/worldLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/continentsLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/usaLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZonesLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZoneAreasLow.js"></script>
    <script src="{{ asset('assets-pdp/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <!--end::Vendors Javascript-->
    <!--begin::Custom Javascript(used for this page only)-->
    <script src="{{ asset('assets-pdp/js/custom/apps/ecommerce/catalog/products.js') }}"></script>
    <script src="{{ asset('assets-pdp/js/widgets.bundle.js') }}"></script>
    <script src="{{ asset('assets-pdp/js/custom/widgets.js') }}"></script>
    <script src="{{ asset('assets-pdp/js/custom/apps/chat/chat.js') }}"></script>
    <script src="{{ asset('assets-pdp/js/custom/utilities/modals/create-campaign.js') }}"></script>
    <script src="{{ asset('assets-pdp/js/custom/utilities/modals/users-search.js') }}"></script>
    <!--end::Custom Javascript-->
@endpush
