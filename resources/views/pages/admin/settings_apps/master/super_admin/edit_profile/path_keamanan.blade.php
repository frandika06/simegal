{{-- begin:::Tab pane --}}
<div class="tab-pane fade" id="profile_tab_path_keamanan" role="tabpanel">
    {{-- begin::Card --}}
    <div class="card pt-4 mb-6 mb-xl-9">
        {{-- begin::Card header --}}
        <div class="card-header border-0">
            {{-- begin::Card title --}}
            <div class="card-title flex-column">
                <h2>Keamanan Akun</h2>
                <div class="fs-6 fw-semibold text-muted">Halaman untuk mengubah data username dan password login pengguna.</div>
            </div>
            {{-- end::Card title --}}
        </div>
        {{-- end::Card header --}}
        {{-- begin::Card body --}}
        <div class="card-body">
            {{-- begin::Form --}}
            <form action="{{ route('set.apps.mst.sa.update', [$enc_uuid]) }}" class="form" enctype="multipart/form-data" method="POST">
                @csrf
                @method('put')
                {{-- hidden --}}
                <input type="hidden" name="path_form" id="path_form" value="keamanan">

                {{-- begin::username --}}
                <div class="form-floating mb-5">
                    <input type="text" class="form-control @error('username') is-invalid @enderror" name="username" id="username2" placeholder="Username" autocomplete="off" maxlength="100" value="{{ old('username', $data->RelUser->username) }}" required />
                    <label for="username">Username</label>
                    @error('username')
                        <div id="usernameFeedback" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                {{-- end::username --}}

                {{-- begin::new_password --}}
                <div class="form-floating mb-5">
                    <input type="password" class="form-control @error('new_password') is-invalid @enderror" name="new_password" id="new_password2" placeholder="Password" autocomplete="off" maxlength="100" value="{{ old('old_password') }}" required />
                    <label for="new_password">Password Baru</label>
                    @error('new_password')
                        <div id="new_passwordFeedback" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                {{-- end::password --}}

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
