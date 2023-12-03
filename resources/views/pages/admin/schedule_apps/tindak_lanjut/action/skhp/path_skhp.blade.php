{{-- begin:::Tab pane --}}
<div class="tab-pane fade" id="profile_tab_path_dokumen" role="tabpanel">
    {{-- begin::Card --}}
    <div class="card pt-4 mb-6 mb-xl-9">
        {{-- begin::Card header --}}
        <div class="card-header border-0">
            {{-- begin::Card title --}}
            <div class="card-title flex-column">
                <h2>Dokumen SKHP</h2>
                <div class="fs-6 fw-semibold text-muted">Halaman untuk melihat dan upload dokumen SKHP.</div>
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
                <input type="hidden" name="path_form" id="path_form" value="upload_skhp">

                {{-- begin::tanggal_expired --}}
                <div class="form-floating mb-5">
                    <input type="date" class="form-control @error('tanggal_expired') is-invalid @enderror" name="tanggal_expired" id="tanggal_expired2" placeholder="Tanggal Expired SKHP" autocomplete="off"
                        value="{{ old('tanggal_expired', isset($tte) ? date('Y-m-d', strtotime($tte->tanggal_expired)) : '') }}" required />
                    <label for="tanggal_expired">Tanggal Expired SKHP</label>
                    @error('tanggal_expired')
                        <div id="tanggal_expiredFeedback" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                {{-- end::tanggal_expired --}}

                {{-- begin::file_skhp --}}
                <div class="form-floating mb-5">
                    <input type="file" class="form-control @error('file_skhp') is-invalid @enderror" name="file_skhp" id="file_skhp2" accept=".pdf" />
                    <label for="file_skhp">File SKHP</label>
                    <div class="form-text">File yang diizinkan: pdf. | Maksimal: 50 MB</div>
                    @error('file_skhp')
                        <div id="file_skhpFeedback" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    @if ($tte->file_skhp !== null && $tte->file_skhp != '')
                        <div class="d-flex justify-content-end align-items-center mt-2">
                            <a target="_BLANK" href="{{ \CID::urlImg($tte->file_skhp) }}" class="btn btn-sm btn-secondary btn-icon-info btn-text-info">
                                <i class="fas fa-search"></i>
                                Lihat File
                            </a>
                        </div>
                    @endif
                </div>
                {{-- end::file_skhp --}}

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
