{{-- begin:::Tab pane --}}
<div class="tab-pane fade" id="profile_tab_path_hak_akses" role="tabpanel">
    {{-- begin::Card --}}
    <div class="card pt-4 mb-6 mb-xl-9">
        {{-- begin::Card header --}}
        <div class="card-header border-0">
            {{-- begin::Card title --}}
            <div class="card-title flex-column">
                <h2>Hak Akses Akun</h2>
                <div class="fs-6 fw-semibold text-muted">Halaman untuk mengubah data hak akses login pengguna.</div>
            </div>
            {{-- end::Card title --}}
        </div>
        {{-- end::Card header --}}
        {{-- begin::Card body --}}
        <div class="card-body">
            {{-- begin::Form --}}
            <form action="{{ route('set.apps.pegawai.update', [$enc_uuid]) }}" class="form" enctype="multipart/form-data" method="POST">
                @csrf
                @method('put')
                @php
                    $sub_role = $data->RelUser->sub_role;
                    $exsub_role = \explode(',', $sub_role);
                    $sub_sub_role = $data->RelUser->sub_sub_role;
                    $exsub_sub_role = \explode(',', $sub_sub_role);
                @endphp
                {{-- hidden --}}
                <input type="hidden" name="path_form" id="path_form" value="hak_akses">

                {{-- begin::Admin Portal --}}
                <div class="form-check mb-5">
                    <input class="form-check-input @error('sub_role') is-invalid @enderror" type="checkbox" value="Admin Portal" name="sub_role[]" id="admin_portal" @if (in_array('Admin Portal', $exsub_role)) checked @endif />
                    <label class="form-check-label" for="admin_portal">
                        Admin Portal
                    </label>
                </div>
                {{-- end::Admin Portal --}}

                {{-- begin::Admin Aplikasi --}}
                <div class="form-check mb-5">
                    <input class="form-check-input @error('sub_role') is-invalid @enderror" type="checkbox" value="Admin Aplikasi" name="sub_role[]" id="admin_aplikasi" @if (in_array('Admin Aplikasi', $exsub_role)) checked @endif />
                    <label class="form-check-label" for="admin_aplikasi">
                        Admin Aplikasi
                    </label>
                </div>
                {{-- end::Admin Aplikasi --}}

                {{-- begin::Petugas --}}
                <div class="form-check mb-5">
                    <input class="form-check-input @error('sub_role') is-invalid @enderror" type="checkbox" value="Petugas" name="sub_role[]" id="petugas" @if (in_array('Petugas', $exsub_role)) checked @endif />
                    <label class="form-check-label" for="petugas">
                        Petugas
                    </label>
                </div>
                {{-- end::Petugas --}}

                {{-- begin::Kasi --}}
                <div class="form-check mb-5">
                    <input class="form-check-input @error('sub_role') is-invalid @enderror" type="checkbox" value="Kasi" name="sub_role[]" id="kasi" @if (in_array('Kasi', $exsub_role)) checked @endif />
                    <label class="form-check-label" for="kasi">
                        Kasi
                    </label>
                </div>
                {{-- end::Kasi --}}

                @error('sub_role')
                    <div id="sub_roleFeedback" class="text-danger">Hak Akses Wajib Dipilih Minimal 1.</div>
                @enderror

                <div class="d-none" id="sub_role_kasi">
                    <div class='separator separator-dashed my-5'></div>
                    <h4>Hak Akses Kasi</h4>
                    <div class="ps-5 pt-3">
                        {{-- begin::Kasi UAPV --}}
                        <div class="form-check form-check-custom form-check-solid mb-4">
                            <input class="form-check-input @error('sub_role_kasi') is-invalid @enderror" type="radio" value="Kasi UAPV" name="sub_role_kasi" id="UAPV" @if (in_array('Kasi UAPV', $exsub_sub_role)) checked @endif />
                            <label class="form-check-label" for="UAPV">
                                Kasi UAPV
                            </label>
                        </div>
                        {{-- end::Kasi UAPV --}}

                        {{-- begin::Kasi MASSA --}}
                        <div class="form-check form-check-custom form-check-solid mb-4">
                            <input class="form-check-input @error('sub_role_kasi') is-invalid @enderror" type="radio" value="Kasi MASSA" name="sub_role_kasi" id="MASSA" @if (in_array('Kasi MASSA', $exsub_sub_role)) checked @endif />
                            <label class="form-check-label" for="MASSA">
                                Kasi MASSA
                            </label>
                        </div>
                        {{-- end::Kasi MASSA --}}

                        {{-- begin::Kasi BDKT --}}
                        <div class="form-check form-check-custom form-check-solid mb-4">
                            <input class="form-check-input @error('sub_role_kasi') is-invalid @enderror" type="radio" value="Kasi BDKT" name="sub_role_kasi" id="BDKT" @if (in_array('Kasi BDKT', $exsub_sub_role)) checked @endif />
                            <label class="form-check-label" for="BDKT">
                                Kasi BDKT
                            </label>
                        </div>
                        {{-- end::Kasi BDKT --}}

                        @error('sub_role_kasi')
                            <div id="sub_role_kasiFeedback" class="text-danger">Hak Akses Kasi Wajib Dipilih Salah Satu.</div>
                        @enderror
                    </div>
                </div>

                {{-- begin::Action buttons --}}
                <div class="d-flex justify-content-end align-items-center mt-12">
                    {{-- begin::Button --}}
                    <button type="submit" class="btn btn-info"><i class="fa-solid fa-save"></i>Simpan</button>
                    {{-- end::Button --}}
                </div>
                {{-- begin::Action buttons --}}

            </form>
            {{-- end::Form --}}
        </div>
        {{-- end::Card body --}}
        {{-- begin::Card footer --}}
        {{-- end::Card footer --}}
    </div>
    {{-- end::Card --}}
</div>
{{-- end:::Tab pane --}}

@push('scripts')
    @if (in_array('Kasi', $exsub_role))
        {{-- sub role kasi --}}
        <script>
            $(document).ready(function() {
                $("#sub_role_kasi").removeClass("d-none");
            });
        </script>
    @endif
    @error('sub_role_kasi')
        {{-- sub role kasi --}}
        <script>
            $(document).ready(function() {
                $('#kasi').prop("checked", true);
                $("#sub_role_kasi").removeClass("d-none");
            });
        </script>
    @enderror
    {{-- sub role kasi --}}
    <script>
        $(document).ready(function() {
            $('#kasi').change(function() {
                if (this.checked) {
                    $(this).prop("checked", true);
                    $("#sub_role_kasi").removeClass("d-none");
                } else {
                    $("#sub_role_kasi").addClass("d-none");
                }
            });
        });
    </script>
@endpush
