<!--begin::Toolbar-->
<div class="toolbar py-5 py-lg-5" id="kt_toolbar">
    <!--begin::Container-->
    <div id="kt_toolbar_container" class="container-xxl py-5">
        <!--begin::Row-->
        <div class="row gy-0 gx-10">
            <div class="col-xl-12">
                <!--begin::Engage widget 2-->
                <div class="card card-xl-stretch bg-body border-0 mb-5 mb-xl-0">
                    <!--begin::Body-->
                    <div class="card-body d-flex flex-column flex-lg-row flex-stack p-lg-15">
                        <!--begin::Info-->
                        <div class="d-flex flex-column justify-content-center align-items-center align-items-lg-start me-10 text-center text-lg-start">
                            <!--begin::Title-->
                            <h3 class="fs-2hx line-height-lg mb-5">
                                <span class="fw-bold">Selamat Datang</span>
                                <br />
                                <span class="fw-bold">{{ $profile->nama_perusahaan }}</span>
                            </h3>
                            <!--end::Title-->
                            <div class="fs-4 text-muted mb-7">Untuk menggunakan aplikasi SIMEGAL,
                                <br />silahkan update dan lengkapi profil anda terlebih dahulu.
                            </div>
                            <a href="{{ route('pdp.apps.auth.profile.index') }}" class="btn btn-success fw-semibold px-6 py-3"><i class="fas fa-edit"></i> Update Profile</a>
                        </div>
                        <!--end::Info-->
                        <!--begin::Illustration-->
                        <img src="{{ asset('assets-pdp/media/illustrations/dozzy-1/17.png') }}" alt="" class="mw-200px mw-lg-350px mt-lg-n10" />
                        <!--end::Illustration-->
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Engage widget 2-->
            </div>
        </div>
        <!--end::Row-->
    </div>
    <!--end::Container-->
</div>
<!--end::Toolbar-->
