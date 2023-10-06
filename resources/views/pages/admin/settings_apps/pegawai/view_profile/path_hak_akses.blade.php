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
            @php
                $sub_role = $data->RelUser->sub_role;
                $exsub_role = \explode(',', $sub_role);
                $sub_sub_role = $data->RelUser->sub_sub_role;
                $exsub_sub_role = \explode(',', $sub_sub_role);
            @endphp

            {{-- begin::Admin Portal --}}
            <div class="form-check mb-5">
                <input class="form-check-input @error('sub_role') is-invalid @enderror"" type="checkbox" value="Admin Portal" name="sub_role[]" id="admin_portal" @if (in_array('Admin Portal', $exsub_role)) checked @endif disabled />
                <label class="form-check-label" for="admin_portal">
                    Admin Portal
                </label>
            </div>
            {{-- end::Admin Portal --}}

            {{-- begin::Admin Aplikasi --}}
            <div class="form-check mb-5">
                <input class="form-check-input @error('sub_role') is-invalid @enderror"" type="checkbox" value="Admin Aplikasi" name="sub_role[]" id="admin_aplikasi" @if (in_array('Admin Aplikasi', $exsub_role)) checked @endif disabled />
                <label class="form-check-label" for="admin_aplikasi">
                    Admin Aplikasi
                </label>
            </div>
            {{-- end::Admin Aplikasi --}}

            {{-- begin::Verifikator --}}
            <div class="form-check mb-5">
                <input class="form-check-input @error('sub_role') is-invalid @enderror"" type="checkbox" value="Verifikator" name="sub_role[]" id="verifikator" @if (in_array('Verifikator', $exsub_role)) checked @endif disabled />
                <label class="form-check-label" for="verifikator">
                    Verifikator
                </label>
            </div>
            {{-- end::Verifikator --}}

            {{-- begin::Petugas --}}
            <div class="form-check mb-5">
                <input class="form-check-input @error('sub_role') is-invalid @enderror"" type="checkbox" value="Petugas" name="sub_role[]" id="petugas" @if (in_array('Petugas', $exsub_role)) checked @endif disabled />
                <label class="form-check-label" for="petugas">
                    Petugas
                </label>
            </div>
            {{-- end::Petugas --}}

            {{-- begin::Kepala Tim --}}
            <div class="form-check mb-5">
                <input class="form-check-input @error('sub_role') is-invalid @enderror" type="checkbox" value="Kepala Tim" name="sub_role[]" id="kepala_tim" @if (in_array('Kepala Tim', $exsub_role)) checked @endif />
                <label class="form-check-label" for="kepala_tim">
                    Kepala Tim
                </label>
            </div>
            {{-- end::Kepala Tim --}}

            @error('sub_role')
                <div id="sub_roleFeedback" class="text-danger">Hak Akses Wajib Dipilih Minimal 1.</div>
            @enderror

            <div class="d-none" id="sub_role_kepala_tim">
                <div class='separator separator-dashed my-5'></div>
                <h4>Hak Akses Kepala Tim</h4>
                <div class="ps-5 pt-3">
                    {{-- begin::Kepala Tim Pelayanan --}}
                    <div class="form-check form-check-custom form-check-solid mb-4">
                        <input class="form-check-input @error('sub_role_kepala_tim') is-invalid @enderror" type="radio" value="Kepala Tim Pelayanan" name="sub_role_kepala_tim" id="Pelayanan" @if (in_array('Kepala Tim Pelayanan', $exsub_sub_role)) checked @endif />
                        <label class="form-check-label" for="Pelayanan">
                            Kepala Tim Pelayanan
                        </label>
                    </div>
                    {{-- end::Kepala Tim Pelayanan --}}

                    {{-- begin::Kepala Tim Pengawasa --}}
                    <div class="form-check form-check-custom form-check-solid mb-4">
                        <input class="form-check-input @error('sub_role_kepala_tim') is-invalid @enderror" type="radio" value="Kepala Tim Pengawasa" name="sub_role_kepala_tim" id="Pengawasan" @if (in_array('Kepala Tim Pengawasa', $exsub_sub_role)) checked @endif />
                        <label class="form-check-label" for="Pengawasan">
                            Kepala Tim Pengawasan
                        </label>
                    </div>
                    {{-- end::Kepala Tim Pengawasa --}}

                    {{-- begin::Kepala Tim Bina SDM --}}
                    <div class="form-check form-check-custom form-check-solid mb-4">
                        <input class="form-check-input @error('sub_role_kepala_tim') is-invalid @enderror" type="radio" value="Kepala Tim Bina SDM" name="sub_role_kepala_tim" id="SDM" @if (in_array('Kepala Tim Bina SDM', $exsub_sub_role)) checked @endif />
                        <label class="form-check-label" for="SDM">
                            Kepala Tim Bina SDM
                        </label>
                    </div>
                    {{-- end::Kepala Tim Bina SDM --}}

                    @error('sub_role_kepala_tim')
                        <div id="sub_role_kepala_timFeedback" class="text-danger">Hak Akses Kasi Wajib Dipilih Salah Satu.</div>
                    @enderror
                </div>
            </div>

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
    @if (in_array('Kepala Tim', $exsub_role))
        {{-- sub role kepala_tim --}}
        <script>
            $(document).ready(function() {
                $("#sub_role_kepala_tim").removeClass("d-none");
            });
        </script>
    @endif
@endpush
