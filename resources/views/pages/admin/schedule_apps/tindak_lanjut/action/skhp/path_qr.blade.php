{{-- begin:::Tab pane --}}
<div class="tab-pane fade" id="profile_tab_path_generate" role="tabpanel">
    {{-- begin::Card --}}
    <div class="card pt-4 mb-6 mb-xl-9">
        {{-- begin::Card header --}}
        <div class="card-header border-0">
            {{-- begin::Card title --}}
            <div class="card-title flex-column">
                <h2>Generate QR TTE</h2>
                <div class="fs-6 fw-semibold text-muted">Halaman untuk manajemen TTE.</div>
            </div>
            {{-- end::Card title --}}
        </div>
        {{-- end::Card header --}}
        {{-- begin::Card body --}}
        <div class="card-body">
            {{-- begin::Form --}}
            <form action="{{ route('scd.apps.tinjut.action.skhp.store', [$tags_jp, $enc_uuid]) }}" class="form" enctype="multipart/form-data" method="POST">
                @csrf
                {{-- hidden --}}
                <input type="hidden" name="path_form" id="path_form" value="generate_qr">

                {{-- begin::jabatan --}}
                <div class="form-floating mb-5">
                    <select class="form-control @error('jabatan') is-invalid @enderror" name="jabatan" id="jabatan" required>
                        <option value="" selected disabled>-Pilih Jabatan Pejabat</option>
                        <option value="Kepala Dinas" @if (old('jabatan', isset($tte) ? $tte->jabatan_pejabat : '') == 'Kepala Dinas') selected @endif>Kepala Dinas</option>
                        <option value="Kepala Bidang" @if (old('jabatan', isset($tte) ? $tte->jabatan_pejabat : '') == 'Kepala Bidang') selected @endif>Kepala Bidang</option>
                        <option value="Ketua Tim" @if (old('jabatan', isset($tte) ? $tte->jabatan_pejabat : '') == 'Ketua Tim') selected @endif>Ketua Tim</option>
                    </select>
                    <label for="jabatan">jabatan</label>
                    @error('jabatan')
                        <div id="jabatanFeedback" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                {{-- end::jabatan --}}

                {{-- begin::Pilih Pejabat Penandatangan --}}
                <div class="mt-0">
                    <label for="">Pilih Pejabat Penandatangan</label>
                    <div class="row p-2">
                        <div class="col">
                            {{-- begin::nama_pejabat --}}
                            <div class="form-group mb-5">
                                <select class="form-select @error('nama_pejabat') is-invalid @enderror" name="nama_pejabat" id="nama_pejabat" required data-control="select2" data-placeholder="Pilih Pejabat Penandatangan" required>
                                </select>
                                @error('nama_pejabat')
                                    <div id="nama_pejabatFeedback" class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            {{-- end::nama_pejabat --}}
                        </div>
                    </div>
                </div>
                {{-- end::Pilih Pejabat Penandatangan --}}

                {{-- begin::Action buttons --}}
                <div class="d-flex justify-content-end align-items-center mt-12">
                    {{-- begin::Button --}}
                    <a href="{{ route('scd.apps.tinjut.' . $jenis_uttp . '.index') }}" class="btn btn-secondary me-2"><i class="fa-solid fa-times"></i>Batal</a>
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
    {{-- get pejabat --}}
    <script>
        $('select[name="jabatan"]').change(function() {
            var jabatan = $(this).val();
            var urlGetPejabat = "{!! route('ajax.scd.apps.tte.get.pejabat') !!}";
            $.post(urlGetPejabat, {
                    jabatan: jabatan,
                    _token: "{{ csrf_token() }}"
                })
                .done(function(res) {
                    $('select[name="nama_pejabat"]').empty();
                    $.each(res.data, function(key, value) {
                        $('select[name="nama_pejabat"]').append('<option value="' + value.uuid + '">' + value.nama_lengkap + '</option>');
                    });
                });
        });
    </script>
@endpush
