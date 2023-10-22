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

            {{-- begin::Admin Pengawasan --}}
            <div class="form-check mb-5">
                <input class="form-check-input @error('sub_role') is-invalid @enderror"" type="checkbox" value="Admin Pengawasan" name="sub_role[]" id="admin_pengawasan" @if (in_array('Admin Pengawasan', $exsub_role)) checked @endif disabled />
                <label class="form-check-label" for="admin_pengawasan">
                    Admin Pengawasan
                </label>
            </div>
            {{-- end::Admin Pengawasan --}}

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

            {{-- begin::Ketua Tim --}}
            <div class="form-check mb-5">
                <input class="form-check-input @error('sub_role') is-invalid @enderror" type="checkbox" value="Ketua Tim" name="sub_role[]" id="ketua_tim" @if (in_array('Ketua Tim', $exsub_role)) checked @endif disabled />
                <label class="form-check-label" for="ketua_tim">
                    Ketua Tim
                </label>
            </div>
            {{-- end::Ketua Tim --}}

            @error('sub_role')
                <div id="sub_roleFeedback" class="text-danger">Hak Akses Wajib Dipilih Minimal 1.</div>
            @enderror

            <div class="d-none" id="sub_role_ketua_tim">
                <div class='separator separator-dashed my-5'></div>
                <h4>Hak Akses Ketua Tim</h4>
                <div class="ps-5 pt-3">
                    {{-- begin::Ketua Tim Pelayanan --}}
                    <div class="form-check form-check-custom form-check-solid mb-4">
                        <input class="form-check-input @error('sub_role_ketua_tim') is-invalid @enderror" type="radio" value="Ketua Tim Pelayanan" name="sub_role_ketua_tim" id="Pelayanan" @if (in_array('Ketua Tim Pelayanan', $exsub_sub_role)) checked @endif disabled />
                        <label class="form-check-label" for="Pelayanan">
                            Ketua Tim Pelayanan
                        </label>
                    </div>
                    {{-- end::Ketua Tim Pelayanan --}}

                    {{-- begin::Ketua Tim Pengawasa --}}
                    <div class="form-check form-check-custom form-check-solid mb-4">
                        <input class="form-check-input @error('sub_role_ketua_tim') is-invalid @enderror" type="radio" value="Ketua Tim Pengawasa" name="sub_role_ketua_tim" id="Pengawasan" @if (in_array('Ketua Tim Pengawasa', $exsub_sub_role)) checked @endif disabled />
                        <label class="form-check-label" for="Pengawasan">
                            Ketua Tim Pengawasan
                        </label>
                    </div>
                    {{-- end::Ketua Tim Pengawasa --}}

                    {{-- begin::Ketua Tim Bina SDM --}}
                    <div class="form-check form-check-custom form-check-solid mb-4">
                        <input class="form-check-input @error('sub_role_ketua_tim') is-invalid @enderror" type="radio" value="Ketua Tim Bina SDM" name="sub_role_ketua_tim" id="SDM" @if (in_array('Ketua Tim Bina SDM', $exsub_sub_role)) checked @endif disabled />
                        <label class="form-check-label" for="SDM">
                            Ketua Tim Bina SDM
                        </label>
                    </div>
                    {{-- end::Ketua Tim Bina SDM --}}

                    @error('sub_role_ketua_tim')
                        <div id="sub_role_ketua_timFeedback" class="text-danger">Hak Akses Kasi Wajib Dipilih Salah Satu.</div>
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
    @if (in_array('Ketua Tim', $exsub_role))
        {{-- sub role ketua_tim --}}
        <script>
            $(document).ready(function() {
                $("#sub_role_ketua_tim").removeClass("d-none");
            });
        </script>
    @endif
@endpush
