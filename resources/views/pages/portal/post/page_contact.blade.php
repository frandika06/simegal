@extends('layouts.portal.base')
@push('apps')
    SIMEGAL
@endpush
@push('title')
    {{ $UcSlug }} | SIMEGAL
@endpush
@push('description')
    {{ $UcSlug }} | Sistem Informasi Metrologi Legal Pemerintah Kabupaten Tangerang
@endpush
@section('content')
    <div role="main" class="main">
        <section class="page-header page-header-modern bg-color-primary page-header-md">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 order-2 order-md-1 align-self-center p-static">
                        <h1 class="">{{ $UcSlug }}</h1>
                    </div>
                    <div class="col-md-4 order-1 order-md-2 align-self-center">
                        <ul class="breadcrumb d-block text-md-end breadcrumb-light">
                            <li><a href="{{ route('prt.home.index') }}">Beranda</a></li>
                            <li class="active">{{ $UcSlug }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <div class="container py-4">

            <div class="row mb-2">
                <div class="col">

                    <h2 class="font-weight-bold text-7 mt-2 mb-0">Kontak Kami</h2>
                    <p class="mb-4">Anda ada pertanyaan / butuh bantuan?. Silahkan hubungi kami melalui form dibawah ini, atau kunjungi kantor kami.</p>

                    <form class="contact-form-recaptcha-v3" action="#" method="POST">
                        <div class="contact-form-success alert alert-success d-none mt-4">
                            <strong>Success!</strong> Your message has been sent to us.
                        </div>

                        <div class="contact-form-error alert alert-danger d-none mt-4">
                            <strong>Error!</strong> There was an error sending your message.
                            <span class="mail-error-message text-1 d-block"></span>
                        </div>

                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label class="form-label mb-1 text-2">Nama Lengkap <span class="wajib">*</span></label>
                                <input type="text" value="" data-msg-required="Masukkan Nama Lengkap." maxlength="100" class="form-control text-3 h-auto py-2" name="name" required>
                            </div>
                            <div class="form-group col-lg-6">
                                <label class="form-label mb-1 text-2">Alamat Email <span class="wajib">*</span></label>
                                <input type="email" value="" data-msg-required="Masukkan Alamat Email." data-msg-email="Please enter a valid email address." maxlength="100" class="form-control text-3 h-auto py-2" name="email" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col">
                                <label class="form-label mb-1 text-2">Subjek <span class="wajib">*</span></label>
                                <input type="text" value="" data-msg-required="Masukkan Subjek." maxlength="100" class="form-control text-3 h-auto py-2" name="subject" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col">
                                <label class="form-label mb-1 text-2">Pesan <span class="wajib">*</span></label>
                                <textarea maxlength="5000" data-msg-required="Masukkan Pesan." rows="5" class="form-control text-3 h-auto py-2" name="message" required></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col">
                                <input type="submit" value="Kirim Pesan" class="btn btn-primary btn-modern" data-loading-text="Loading...">
                            </div>
                        </div>
                    </form>

                </div>
            </div>
            <div class="row mb-5">
                <div class="col-lg-4">
                    <div class="overflow-hidden mb-3">
                        <h4 class="pt-5 mb-0 appear-animation" data-appear-animation="maskUp" data-appear-animation-delay="200" data-plugin-options="{'accY': -200}">Hubungi <strong>Kami</strong></h4>
                    </div>
                    <div class="overflow-hidden">
                        <p class="mb-0 appear-animation" data-appear-animation="maskUp" data-appear-animation-delay="600" data-plugin-options="{'accY': -200}">Kami terbuka untuk membantu permasalahan anda dalam kebutuhan peneraan, silahkan hubungi kami atau datang langsung ke kantor kami untuk
                            berkonsultasi.</p>
                    </div>
                </div>
                <div class="col-lg-4 offset-lg-1 appear-animation" data-appear-animation="fadeIn" data-appear-animation-delay="800" data-plugin-options="{'accY': -200}">

                    <h4 class="pt-5">Kantor <strong>Kami</strong></h4>
                    <ul class="list list-icons list-icons-style-3 mt-2">
                        <li><i class="fas fa-map-marker-alt top-6"></i> <strong>Alamat:</strong> Bidang Metrologi Legal, Balaraja, Kec. Balaraja, Kabupaten Tangerang, Banten 15610</li>
                        <li><i class="fas fa-phone top-6"></i> <strong>Telp:</strong> (021) 456-789</li>
                        <li><i class="fas fa-envelope top-6"></i> <strong>Email:</strong> <a href="mailto:info@example.com">info@example.com</a></li>
                    </ul>

                </div>
                <div class="col-lg-3 appear-animation" data-appear-animation="fadeIn" data-appear-animation-delay="1000" data-plugin-options="{'accY': -200}">

                    <h4 class="pt-5">Jam <strong>Operasional</strong></h4>
                    <ul class="list list-icons list-dark mt-2">
                        <li><i class="far fa-clock top-6"></i> Senin - Jumat : 08.00 - 16.00 WIB</li>
                        <li><i class="far fa-clock top-6"></i> Sabtu & Minggu : Libur</li>
                    </ul>

                </div>
            </div>
        </div>

        <div id="" class="google-map m-0 appear-animation" data-appear-animation="fadeIn" data-appear-animation-delay="300" style="height:450px;">
            <iframe class="embed-responsive-item" src="https://maps.google.com/maps?q=-6.189239,106.464805&z=15&output=embed" width="100%" height="450px"></iframe>
        </div>

    </div>
@endsection
