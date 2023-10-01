{{-- begin:::Tab pane --}}
<div class="tab-pane fade" id="profile_tab_path_alamat" role="tabpanel">
    {{-- begin::Card --}}
    <div class="card pt-4 mb-6 mb-xl-9">
        {{-- begin::Card header --}}
        <div class="card-header border-0">
            {{-- begin::Card title --}}
            <div class="card-title flex-column">
                <h2>Data Alamat</h2>
                <div class="fs-6 fw-semibold text-muted">Halaman untuk mengubah data alamat Perusahaan/Usaha.</div>
            </div>
            {{-- end::Card title --}}
            {{-- begin::Actions --}}
            <div class="d-flex align-items-center py-2 py-md-1">
                {{-- begin::Button --}}
                <a type="button" class="btn btn-sm btn-info fw-bold" data-bs-toggle="modal" data-bs-target="#add_alamat_perusahaan" data-mode="add"><i class="fa-solid fa-plus"></i>Tambah Alamat</a>
                {{-- end::Button --}}
            </div>
            {{-- end::Actions --}}
        </div>
        {{-- end::Card header --}}
        {{-- begin::Card body --}}
        <div class="card-body">
            @if (\count($alamatPerusahaan) > 0)
                {{-- ADA DATA --}}
                @foreach ($alamatPerusahaan as $item)
                    {{-- begin::Item --}}
                    <div class="d-flex flex-stack">
                        {{-- begin::Content --}}
                        <div class="d-flex flex-column">
                            <span data-kt-buttons="true" data-kt-buttons-target=".form-check-flex, .form-check-default">
                                <label class="form-check-flex" data-default-uuid="{{ \CID::encode($item->uuid) }}">
                                    <div class="form-check form-check-custom form-check-solid">
                                        <input class="form-check-default" type="radio" value="{{ $item->uuid }}" name="default" @if ($item->default == '1') checked @endif>
                                        <div class="form-check-label fw-bold">
                                            <strong>{{ $item->Kecamatan->name }}</strong>
                                        </div>
                                    </div>
                                </label>
                            </span>
                            <div class="text-gray-600">
                                {{ $item->alamat }}, RT. {{ $item->rt }}, RW. {{ $item->rw }},
                                {{ \Str::title($item->Desa->name) }}, {{ \Str::title($item->Kecamatan->name) }},
                                {{ \Str::title($item->Kabupaten->name) }}, {{ \Str::title($item->Provinsi->name) }}
                                @if ($item->kode_pos != '')
                                    , {{ $item->kode_pos }}.<br />
                                @endif
                            </div>
                        </div>
                        {{-- end::Content --}}
                        {{-- begin::Action --}}
                        <div class="d-flex justify-content-end align-items-center">
                            {{-- begin::Actions --}}
                            <a href="javascript:void(0);" class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Aksi
                                <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                            {{-- begin::Menu --}}
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                {{-- begin::Menu item --}}
                                <div class="menu-item px-3">
                                    <a href="javascript:void(0);" class="menu-link px-3" data-bs-toggle="modal" data-bs-target="#add_alamat_perusahaan" data-mode="edit" data-uuid-key="{{ \CID::encode($item->uuid) }}"><i class="fa-solid fa-edit me-2"></i> Edit</a>
                                </div>
                                {{-- end::Menu item --}}
                                {{-- begin::Menu item --}}
                                <div class="menu-item px-3">
                                    <a href="javascript:void(0);" class="menu-link px-3 delete" data-uuid-key="{{ \CID::encode($item->uuid) }}"><i class="fa-solid fa-trash me-2"></i> Delete</a>
                                </div>
                                {{-- end::Menu item --}}
                                @if ($item->google_maps != '' || ($item->lat != '' && $item->long != ''))
                                    @if ($item->google_maps != '')
                                        @php
                                            $url_maps = $item->google_maps;
                                        @endphp
                                    @elseif($item->lat != '' && $item->long != '')
                                        @php
                                            $url_maps = 'https://www.google.com/maps/search/?api=1&query=' . $item->lat . ',' . $item->long . '';
                                        @endphp
                                    @endif
                                    {{-- begin::Menu item --}}
                                    <div class="menu-item px-3">
                                        <a target="_BLANK" href="{{ $url_maps }}" class="menu-link px-3"><i class="fa-solid fa-map-location-dot me-2"></i> Maps</a>
                                    </div>
                                @endif
                            </div>
                            {{-- end::Menu --}}
                        </div>
                        {{-- end::Action --}}
                    </div>
                    {{-- end::Item --}}
                    {{-- begin:Separator --}}
                    <div class="separator separator-dashed my-5"></div>
                @endforeach
            @else
                {{-- TIDAK ADA DATA --}}
            @endif
        </div>
        {{-- end::Card body --}}
        {{-- begin::Card footer --}}
        {{-- end::Card footer --}}
    </div>
    {{-- end::Card --}}
</div>
{{-- end:::Tab pane --}}

@push('modals')
    {{-- begin::modal-add-alamat --}}
    <div class="modal fade add" tabindex="-1" id="add_alamat_perusahaan">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('set.apps.perusahaan.update', [$enc_tags, $enc_uuid]) }}" method="POST" id="formAlamat">
                    @csrf
                    @method('put')
                    {{-- hidden --}}
                    <input type="hidden" name="path_form" id="path_form" value="alamat">
                    <input type="hidden" name="uuid_form" id="uuid_form" value="">

                    <div class="modal-header">
                        <h3 class="modal-title" id="modal_title"></h3>
                        {{-- begin::Close --}}
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                            <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                        {{-- end::Close --}}
                    </div>

                    <div class="modal-body">

                        {{-- begin::district_id --}}
                        <div class="mb-5">
                            <label for="" class="form-label required">Kecamatan</label>
                            <select class="form-select" name="district_id" id="district_id" data-control="select2" data-dropdown-parent="#add_alamat_perusahaan" data-placeholder="Pilih Kecamatan" data-allow-clear="true">
                                <option></option>
                                @foreach ($dataKec as $item)
                                    <option value="{{ $item->id }}" @if (old('district_id') == $item->id) selected @endif>{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        {{-- end::district_id --}}

                        {{-- begin::village_id --}}
                        <div class="mb-5">
                            <label for="" class="form-label required">Kelurahan/Desa</label>
                            <select class="form-select" name="village_id" id="village_id" data-control="select2" data-dropdown-parent="#add_alamat_perusahaan" data-placeholder="Pilih Kelurahan/Desa" data-allow-clear="true">
                                <option></option>
                            </select>
                        </div>
                        {{-- end::village_id --}}

                        {{-- begin::alamat --}}
                        <div class="mb-5">
                            <label for="" class="form-label required">Alamat</label>
                            <input type="text" class="form-control @error('alamat') is-invalid @enderror" name="alamat" id="alamat" placeholder="Alamat" autocomplete="off" maxlength="100" value="{{ old('alamat') }}" required />
                            <div class="form-text"><strong>Ket. Alamat:</strong> masukkan nama jalan/ruko/toko, blok dan nomor jika ada.</div>
                            @error('alamat')
                                <div id="alamatFeedback" class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        {{-- end::alamat --}}

                        {{-- begin::rt-rw-kode_pos --}}
                        <div class="row g-9 mb-5">
                            {{-- begin::Col --}}
                            <div class="col-md-4 fv-row">
                                <label for="" class="form-label required">RT</label>
                                <input type="text" class="form-control @error('rt') is-invalid @enderror" name="rt" id="rt" onkeyup="this.value=this.value.replace(/[^\d]/,'')" placeholder="RT" autocomplete="off" maxlength="3" value="{{ old('rt') }}" required />
                                @error('rt')
                                    <div id="rtFeedback" class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            {{-- end::Col --}}
                            {{-- begin::Col --}}
                            <div class="col-md-4 fv-row">
                                <label for="" class="form-label required">RW</label>
                                <input type="text" class="form-control @error('rw') is-invalid @enderror" name="rw" id="rw" onkeyup="this.value=this.value.replace(/[^\d]/,'')" placeholder="RW" autocomplete="off" maxlength="3" value="{{ old('rw') }}" required />
                                @error('rw')
                                    <div id="rwFeedback" class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            {{-- end::Col --}}
                            {{-- begin::Col --}}
                            <div class="col-md-4 fv-row">
                                <label for="" class="form-label">Kode Pos</label>
                                <input type="text" class="form-control @error('kode_pos') is-invalid @enderror" name="kode_pos" id="kode_pos" onkeyup="this.value=this.value.replace(/[^\d]/,'')" placeholder="Kode Pos" autocomplete="off" maxlength="5" value="{{ old('kode_pos') }}" />
                                @error('kode_pos')
                                    <div id="kode_posFeedback" class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            {{-- end::Col --}}
                        </div>
                        {{-- end::rt-rw-kode_pos --}}

                        {{-- begin::lat-long --}}
                        <div class="row g-9 mb-5">
                            {{-- begin::Col --}}
                            <div class="col-md-6 fv-row">
                                <label for="" class="form-label">Latitude</label>
                                <input type="text" class="form-control @error('lat') is-invalid @enderror" name="lat" id="lat" placeholder="Kode Latitude" autocomplete="off" maxlength="100" value="{{ old('lat') }}" />
                                @error('lat')
                                    <div id="latFeedback" class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            {{-- end::Col --}}
                            {{-- begin::Col --}}
                            <div class="col-md-6 fv-row">
                                <label for="" class="form-label">Longitude</label>
                                <input type="text" class="form-control @error('long') is-invalid @enderror" name="long" id="long" placeholder="Kode Longitude" autocomplete="off" maxlength="100" value="{{ old('long') }}" />
                                @error('long')
                                    <div id="longFeedback" class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            {{-- end::Col --}}
                        </div>
                        {{-- end::lat-long --}}

                        {{-- begin::google_maps --}}
                        <div class="mb-5">
                            <label for="" class="form-label">Link Google Maps</label>
                            <input type="url" class="form-control @error('google_maps') is-invalid @enderror" name="google_maps" id="google_maps" placeholder="Link Google Maps" autocomplete="off" maxlength="300" value="{{ old('google_maps') }}" />
                            <div class="form-text"><strong>Ket. Link Google Maps:</strong> link google maps jika anda tidak mengetahui kode latitude dan longitude alamat perusahaan/usaha anda.</div>
                            @error('google_maps')
                                <div id="google_mapsFeedback" class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        {{-- end::google_maps --}}

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal"><i class="fa-solid fa-times"></i>Batal</button>
                        <button type="submit" class="btn btn-info"><i class="fa-solid fa-save"></i>Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- end::modal-add-alamat --}}
@endpush

@push('scripts')
    {{-- get desa - add form --}}
    <script>
        $('select[name="district_id"]').change(function() {
            var district_id = $(this).val();
            var urlDesa = "{!! url('/') !!}/wil-adm/data/desa/" + district_id;
            $.get(urlDesa, function(res) {
                $('select[name="village_id"]').empty();
                $('select[name="village_id"]').append('<option></option>');
                $.each(res.data, function(key, value) {
                    $('select[name="village_id"]').append('<option value="' + value.id + '">' + value.name + '</option>');
                });
            });
        });
    </script>

    {{-- edit form --}}
    <script>
        $('a[data-bs-target^="#add_alamat_perusahaan"]').click(function() {
            var mode = $(this).data("mode");
            if (mode == "add") {
                $("#modal_title").html("Form Tambah Alamat");
                $("#formAlamat").trigger("reset");
                $("#path_form").val("alamat");
            } else if (mode == "edit") {
                $("#modal_title").html("Edit Data Alamat");
                var uuid_form = $(this).data("uuid-key");
                $("#uuid_form").val(uuid_form);
                var urlAlamat = "{!! url('/') !!}/settings-apps/perusahaan/{!! $enc_tags !!}/show-alamat/" + uuid_form;
                $.get(urlAlamat, function(res) {
                    if (res.status === false) {
                        Swal.fire({
                            text: res.message,
                            icon: "error",
                        });
                        exit();
                    } else if (res.status === true) {
                        var urlKec = "{!! url('/') !!}/wil-adm/data/kec/3603";
                        $.get(urlKec, function(resKec) {
                            $('select[name="district_id"]').empty();
                            $('select[name="district_id"]').append('<option></option>');
                            $.each(resKec.data, function(key, value) {
                                if (value.id == res.data.district_id) {
                                    $('select[name="district_id"]').append('<option value="' + value.id + '" selected>' + value.name + '</option>');
                                } else {
                                    $('select[name="district_id"]').append('<option value="' + value.id + '">' + value.name + '</option>');
                                }
                            });
                        });

                        var urlDesa = "{!! url('/') !!}/wil-adm/data/desa/" + res.data.district_id;
                        $.get(urlDesa, function(resDesa) {
                            $('select[name="village_id"]').empty();
                            $('select[name="village_id"]').append('<option></option>');
                            $.each(resDesa.data, function(key, value) {
                                if (value.id == res.data.village_id) {
                                    $('select[name="village_id"]').append('<option value="' + value.id + '" selected>' + value.name + '</option>');
                                } else {
                                    $('select[name="village_id"]').append('<option value="' + value.id + '">' + value.name + '</option>');
                                }
                            });
                        });

                        $("#alamat").val(res.data.alamat);
                        $("#rt").val(res.data.rt);
                        $("#rw").val(res.data.rw);
                        $("#kode_pos").val(res.data.kode_pos);
                        $("#lat").val(res.data.lat);
                        $("#long").val(res.data.long);
                        $("#google_maps").val(res.data.google_maps);
                    }
                });
            }
        });
    </script>

    {{-- delete --}}
    <script>
        $('.delete').click(function() {
            var uuid = $(this).data("uuid-key");
            Swal.fire({
                title: "Hapus Data",
                text: "Apakah Anda Yakin?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: 'No, cancel!',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{!! route('set.apps.perusahaan.alamat.destroy', [$enc_tags]) !!}",
                        type: 'POST',
                        data: {
                            uuid: uuid,
                            _method: 'delete',
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(res) {
                            Swal.fire({
                                title: "Success",
                                text: res.message,
                                icon: "success",
                            }).then((result) => {
                                location.reload();
                            });
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
            });
        });
    </script>

    {{-- ubah default --}}
    <script>
        $(".form-check-flex").click(function() {
            var uuid = $(this).data("default-uuid");
            $.ajax({
                url: "{!! route('set.apps.perusahaan.alamat.default', [$enc_tags]) !!}",
                type: 'POST',
                data: {
                    uuid: uuid,
                    _method: 'post',
                    _token: "{{ csrf_token() }}"
                },
                success: function(res) {
                    Swal.fire({
                        title: "Success",
                        text: res.message,
                        icon: "success",
                    }).then((result) => {
                        location.reload();
                    });
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
        });
    </script>
@endpush
