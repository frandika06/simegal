<?php

namespace App\Http\Controllers\WebBase\WebAdmin\SettingsApps\master\uttp;

use App\Helpers\CID;
use App\Http\Controllers\Controller;
use App\Models\MasterInstrumenDaftarItemUttp;
use App\Models\MasterInstrumenJenisUttp;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SetAppsInsUttpDaftarItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $getMstJenisUttp = MasterInstrumenJenisUttp::whereStatus("1")->orderBy("no_urut", "ASC")->get();
        return view('pages.admin.settings_apps.master.uttp.instrumen.daftar_item_uttp.index', compact(
            'getMstJenisUttp'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // auth
        $auth = Auth::user();
        $uuid_profile = $auth->uuid_profile;

        // validate
        $request->validate([
            "jenis_uttp" => "required|string|max:100",
            "group_instrumen" => "sometimes|nullable|string|max:100",
            "nama_instrumen" => "required|string|max:100",
            "volume_from" => "sometimes|nullable|numeric|min:0",
            "volume_to" => "sometimes|nullable|numeric|min:0",
            "volume_per" => "sometimes|nullable|numeric|min:0",
            "satuan" => "sometimes|nullable|string|max:5",
            "tera_baru_pengujian" => "required|numeric|min:0",
            "tera_baru_pejustiran" => "required|numeric|min:0",
            "tera_ulang_pengujian" => "required|numeric|min:0",
            "tera_ulang_pejustiran" => "required|numeric|min:0",
            "tarif_per_jam" => "required|numeric|min:0",
        ]);

        // get jenis utto
        $uuid_instrumen_jenis_uttp = $request->jenis_uttp;
        $cekJenisUttp = MasterInstrumenJenisUttp::findOrFail($uuid_instrumen_jenis_uttp);
        if ($cekJenisUttp->status_volume == "1") {
            // volume wajib
            // validate
            $request->validate([
                "volume_from" => "required|numeric|min:0",
                "volume_to" => "required|numeric|min:0",
                "volume_per" => "required|numeric|min:0",
                "satuan" => "required|string|max:5",
            ]);
        }

        // nomor urut
        $cekData = MasterInstrumenDaftarItemUttp::where("uuid_instrumen_jenis_uttp", $uuid_instrumen_jenis_uttp)->first();
        if ($cekData === null) {
            $no_urut = 1;
        } else {
            $last_nomor = MasterInstrumenDaftarItemUttp::where("uuid_instrumen_jenis_uttp", $uuid_instrumen_jenis_uttp)->max('no_urut');
            $no_urut = $last_nomor + 1;
        }

        // value
        $uuid = Str::uuid();
        $value_1 = [
            "uuid" => $uuid,
            "uuid_instrumen_jenis_uttp" => $uuid_instrumen_jenis_uttp,
            "no_urut" => $no_urut,
            "group_instrumen" => $request->group_instrumen,
            "nama_instrumen" => $request->nama_instrumen,
            "volume_from" => $request->volume_from,
            "volume_to" => $request->volume_to,
            "volume_per" => $request->volume_per,
            "satuan" => $request->satuan,
            "tera_baru_pengujian" => $request->tera_baru_pengujian,
            "tera_baru_pejustiran" => $request->tera_baru_pejustiran,
            "tera_ulang_pengujian" => $request->tera_ulang_pengujian,
            "tera_ulang_pejustiran" => $request->tera_ulang_pejustiran,
            "tarif_per_jam" => $request->tarif_per_jam,
            "uuid_created" => $uuid_profile,
        ];

        // save
        $save_1 = MasterInstrumenDaftarItemUttp::create($value_1);
        if ($save_1) {
            // create log
            $aktifitas = [
                "tabel" => array("master_instrumen_daftar_item_uttp"),
                "uuid" => array($uuid),
                "value" => array($value_1),
            ];
            $log = [
                "apps" => "Settings Apps",
                "subjek" => "Menambahkan Master Instrumen UTTP - Daftar Item UTTP: " . $request->nama_instrumen . " - " . $uuid,
                "aktifitas" => $aktifitas,
                "device" => "web",
                "dashboard" => "0",
            ];
            CID::addToLogAktifitas($request, $log);
            // alert success
            alert()->success('Berhasil!', "Berhasil Menambahkan Master Instrumen UTTP - Daftar Item UTTP: " . $request->nama_instrumen);
            return back();
        } else {
            alert()->error('Gagal!', "Gagal Menambahkan Master Instrumen UTTP - Daftar Item UTTP: " . $request->nama_instrumen);
            return back()->withInput($request->all());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($enc_uuid)
    {
        $uuid = CID::decode($enc_uuid);
        $data = MasterInstrumenDaftarItemUttp::findOrFail($uuid);

        $title = "Detail Daftar Item UTTP";
        return view('pages.admin.settings_apps.master.uttp.instrumen.daftar_item_uttp.view', compact(
            'enc_uuid',
            'title',
            'data',
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($enc_uuid)
    {
        $uuid = CID::decode($enc_uuid);
        $data = MasterInstrumenDaftarItemUttp::findOrFail($uuid);

        $title = "Edit Daftar Item UTTP";
        $submit = "Simpan";
        return view('pages.admin.settings_apps.master.uttp.instrumen.daftar_item_uttp.create_edit', compact(
            'enc_uuid',
            'title',
            'submit',
            'data',
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $enc_uuid)
    {
        // auth
        $auth = Auth::user();
        $uuid_profile = $auth->uuid_profile;

        // uuid
        $uuid = CID::decode($enc_uuid);
        $data = MasterInstrumenDaftarItemUttp::findOrFail($uuid);

        // validate
        $request->validate([
            "no_urut" => "required|numeric|min:1",
            "group_instrumen" => "sometimes|nullable|string|max:100",
            "nama_instrumen" => "required|string|max:100",
            "volume_from" => "sometimes|nullable|numeric|min:0",
            "volume_to" => "sometimes|nullable|numeric|min:0",
            "volume_per" => "sometimes|nullable|numeric|min:0",
            "satuan" => "sometimes|nullable|string|max:5",
            "tera_baru_pengujian" => "required|numeric|min:0",
            "tera_baru_pejustiran" => "required|numeric|min:0",
            "tera_ulang_pengujian" => "required|numeric|min:0",
            "tera_ulang_pejustiran" => "required|numeric|min:0",
            "tarif_per_jam" => "required|numeric|min:0",
        ]);

        // get jenis utto
        $uuid_instrumen_jenis_uttp = $data->uuid_instrumen_jenis_uttp;
        $cekJenisUttp = MasterInstrumenJenisUttp::findOrFail($uuid_instrumen_jenis_uttp);
        if ($cekJenisUttp->status_volume == "1") {
            // volume wajib
            // validate
            $request->validate([
                "volume_from" => "required|numeric|min:0",
                "volume_to" => "required|numeric|min:0",
                "volume_per" => "required|numeric|min:0",
                "satuan" => "required|string|max:5",
            ]);
        }

        // value
        $value_1 = [
            "no_urut" => $request->no_urut,
            "group_instrumen" => $request->group_instrumen,
            "nama_instrumen" => $request->nama_instrumen,
            "volume_from" => $request->volume_from,
            "volume_to" => $request->volume_to,
            "volume_per" => $request->volume_per,
            "satuan" => $request->satuan,
            "tera_baru_pengujian" => $request->tera_baru_pengujian,
            "tera_baru_pejustiran" => $request->tera_baru_pejustiran,
            "tera_ulang_pengujian" => $request->tera_ulang_pengujian,
            "tera_ulang_pejustiran" => $request->tera_ulang_pejustiran,
            "tarif_per_jam" => $request->tarif_per_jam,
            "uuid_updated" => $uuid_profile,
        ];

        // save
        $save_1 = $data->update($value_1);
        if ($save_1) {
            // create log
            $aktifitas = [
                "tabel" => array("master_instrumen_daftar_item_uttp"),
                "uuid" => array($uuid),
                "value" => array($value_1),
            ];
            $log = [
                "apps" => "Settings Apps",
                "subjek" => "Mengubah Master Instrumen UTTP - Daftar Item UTTP: " . $request->nama_instrumen . " - " . $uuid,
                "aktifitas" => $aktifitas,
                "device" => "web",
                "dashboard" => "0",
            ];
            CID::addToLogAktifitas($request, $log);
            // alert success
            alert()->success('Berhasil!', "Berhasil Mengubah Master Instrumen UTTP - Daftar Item UTTP: " . $request->nama_instrumen);
            return back();
        } else {
            alert()->error('Gagal!', "Gagal Mengubah Master Instrumen UTTP - Daftar Item UTTP: " . $request->nama_instrumen);
            return back()->withInput($request->all());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        // auth
        $auth = Auth::user();

        // uuid
        $uuid = CID::decode($request->uuid);

        // data
        $data = MasterInstrumenDaftarItemUttp::findOrFail($uuid);

        // save
        $save_1 = $data->delete();
        if ($save_1) {
            // create log
            $aktifitas = [
                "tabel" => array("master_instrumen_daftar_item_uttp"),
                "uuid" => array($uuid),
                "value" => array($data),
            ];
            $log = [
                "apps" => "Settings Apps",
                "subjek" => "Berhasil Menghapus Master Instrumen UTTP - Daftar Item UTTP: " . $data->nama_jenis_uttp . " - " . $uuid,
                "aktifitas" => $aktifitas,
                "device" => "web",
                "dashboard" => "1",
            ];
            CID::addToLogAktifitas($request, $log);
            // alert success
            $msg = "Data Berhasil Dihapus!";
            $response = [
                "status" => true,
                "message" => $msg,
            ];
            return response()->json($response, 200);
        } else {
            // success
            $msg = "Data Gagal Dihapus!";
            $response = [
                "status" => false,
                "message" => $msg,
            ];
            return response()->json($response, 422);
        }
    }

    /**
     * Status Aktif
     */
    public function status(Request $request)
    {
        // auth
        $auth = Auth::user();

        // uuid
        $uuid = CID::decode($request->uuid);
        $status = $request->status;
        if ($status == "0") {
            $status_update = "1";
        } else {
            $status_update = "0";
        }

        // data
        $data = MasterInstrumenDaftarItemUttp::findOrFail($uuid);

        // value
        $value_1 = [
            "status" => $status_update,
            "uuid_updated" => $auth->uuid_profile,
        ];

        // save
        $save_1 = $data->update($value_1);
        if ($save_1) {
            // create log
            $aktifitas = [
                "tabel" => array("master_instrumen_daftar_item_uttp"),
                "uuid" => array($uuid),
                "value" => array($data),
            ];
            $log = [
                "apps" => "Settings Apps",
                "subjek" => "Mengubah Status Master Instrumen UTTP - Daftar Item UTTP: " . $data->nama_jenis_uttp . " - " . $uuid,
                "aktifitas" => $aktifitas,
                "device" => "web",
                "dashboard" => "1",
            ];
            CID::addToLogAktifitas($request, $log);
            // alert success
            $msg = "Status Berhasil Diubah!";
            $response = [
                "status" => true,
                "message" => $msg,
            ];
            return response()->json($response, 200);
        } else {
            // success
            $msg = "Status Gagal Diubah!";
            $response = [
                "status" => false,
                "message" => $msg,
            ];
            return response()->json($response, 422);
        }
    }

    /**
     * Data untuk Datatables
     */
    public function data(Request $request)
    {
        $data = MasterInstrumenDaftarItemUttp::join("master_instrumen_jenis_uttp", "master_instrumen_jenis_uttp.uuid", "=", "master_instrumen_daftar_item_uttp.uuid_instrumen_jenis_uttp")
            ->select("master_instrumen_daftar_item_uttp.*")
            ->orderBy("master_instrumen_jenis_uttp.no_urut", "ASC")
            ->orderBy("master_instrumen_daftar_item_uttp.no_urut", "ASC")
            ->get();

        if ($request->ajax()) {
            return Datatables::of($data)
                ->addIndexColumn()
                ->setRowId('uuid')
                ->addColumn('nama_jenis_uttp', function ($data) {
                    $nama_jenis_uttp = $data->RelMasterInstrumenJenisUttp->nama_jenis_uttp;
                    return $nama_jenis_uttp;
                })
                ->addColumn('nama_instrumen', function ($data) {
                    $nama_jenis_uttp = $data->RelMasterInstrumenJenisUttp->nama_jenis_uttp;
                    if ($data->group_instrumen === null) {
                        $group = '';
                    } else {
                        $group = $data->group_instrumen . '<i class="fa-solid fa-chevron-right m-2"></i>';
                    }
                    $nama_instrumen = '
                    <p class="p-0 m-0"><strong>' . $nama_jenis_uttp . '</strong></p>
                    <p class="p-0 m-0"><i class="fa-solid fa-chevron-right me-2"></i>' . $group . $data->nama_instrumen . '</p>
                    ';
                    return $nama_instrumen;
                })
                ->addColumn('status', function ($data) {
                    $uuid = CID::encode($data->uuid);
                    $subRoleAdmin = CID::subRoleAdmin();
                    if ($data->status == "1") {
                        $toogle = "checked";
                        $text = "Aktif";
                    } else {
                        $toogle = "";
                        $text = "Tidak Aktif";
                    }
                    if ($subRoleAdmin == true) {
                        $status = '
                            <div class="form-check form-switch form-switch-custom form-switch-primary mb-3">
                                <input class="form-check-input" type="checkbox" role="switch" id="status" data-onclick="ubah-status" data-status="' . $uuid . '" data-status-value="' . $data->status . '" ' . $toogle . '>
                                <label class="form-check-label" for="status">' . $text . '</label>
                            </div>
                        ';
                    } else {
                        $status = '<label class="form-check-label" for="status">' . $text . '</label>';
                    }
                    return $status;
                })
                ->addColumn('aksi', function ($data) {
                    $enc_uuid = CID::encode($data->uuid);
                    $subRoleAdmin = CID::subRoleAdmin();
                    $edit = route('set.apps.mst.ins.uttp.item.edit', [$enc_uuid]);
                    $show = route('set.apps.mst.ins.uttp.item.show', [$enc_uuid]);
                    if ($subRoleAdmin == true) {
                        $aksi = '<div class="dropdown">
                            <button class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                Aksi
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <li><a class="dropdown-item" href="' . $edit . '"><i class="fa-solid fa-edit me-2"></i> Edit</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0);" data-delete="' . $enc_uuid . '"><i class="fa-solid fa-trash me-2"></i> Hapus</a></li>
                            </ul>
                            </div>';
                    } else {
                        $aksi = '<div class="dropdown">
                            <button class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                Aksi
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <li><a class="dropdown-item" href="' . $show . '"><i class="fa-solid fa-info-circle me-2"></i> Detail</a></li>
                            </ul>
                            </div>';
                    }
                    return $aksi;
                })
                ->escapeColumns([''])
                ->make(true);
        }
    }
}
