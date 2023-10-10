<?php

namespace App\Http\Controllers\WebBase\WebAdmin\SettingsApps\master\uttp;

use App\Helpers\CID;
use App\Http\Controllers\Controller;
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
        return view('pages.admin.settings_apps.master.uttp.instrumen.daftar_item_uttp.index');
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
            "nama_jenis_uttp" => "required|string|max:100",
            "status_volume" => "required|numeric|max:1",
        ]);

        // nomor urut
        $cekData = MasterInstrumenJenisUttp::first();
        if ($cekData === null) {
            $no_urut = 1;
        } else {
            $last_nomor = MasterInstrumenJenisUttp::max('no_urut');
            $no_urut = $last_nomor + 1;
        }

        // value Pegawai
        $uuid = Str::uuid();
        $value_1 = [
            "uuid" => $uuid,
            "no_urut" => $no_urut,
            "nama_jenis_uttp" => $request->nama_jenis_uttp,
            "status_volume" => $request->status_volume,
            "uuid_created" => $uuid_profile,
        ];

        // save
        $save_1 = MasterInstrumenJenisUttp::create($value_1);
        if ($save_1) {
            // create log
            $aktifitas = [
                "tabel" => array("master_instrumen_jenis_uttp"),
                "uuid" => array($uuid),
                "value" => array($value_1),
            ];
            $log = [
                "apps" => "Settings Apps",
                "subjek" => "Menambahkan Master Instrumen UTTP - Jenis UTTP: " . $request->nama_jenis_uttp . " - " . $uuid,
                "aktifitas" => $aktifitas,
                "device" => "web",
                "dashboard" => "0",
            ];
            CID::addToLogAktifitas($request, $log);
            // alert success
            alert()->success('Berhasil!', "Berhasil Menambahkan Master Instrumen UTTP - Jenis UTTP: " . $request->nama_jenis_uttp);
            return back();
        } else {
            alert()->error('Gagal!', "Gagal Menambahkan Master Instrumen UTTP - Jenis UTTP: " . $request->nama_jenis_uttp);
            return back()->withInput($request->all());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($enc_uuid)
    {
        $uuid = CID::decode($enc_uuid);
        $data = MasterInstrumenJenisUttp::findOrFail($uuid);

        $title = "Detail Jenis UTTP";
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
        $data = MasterInstrumenJenisUttp::findOrFail($uuid);

        $title = "Edit Jenis UTTP";
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
        $data = MasterInstrumenJenisUttp::findOrFail($uuid);

        // validate
        $request->validate([
            "no_urut" => "required|numeric",
            "nama_jenis_uttp" => "required|string|max:100",
            "status_volume" => "required|numeric|max:1",
        ]);

        // value Pegawai
        $value_1 = [
            "no_urut" => $request->no_urut,
            "nama_jenis_uttp" => $request->nama_jenis_uttp,
            "status_volume" => $request->status_volume,
            "uuid_updated" => $uuid_profile,
        ];

        // save
        $save_1 = $data->update($value_1);
        if ($save_1) {
            // create log
            $aktifitas = [
                "tabel" => array("master_instrumen_jenis_uttp"),
                "uuid" => array($uuid),
                "value" => array($value_1),
            ];
            $log = [
                "apps" => "Settings Apps",
                "subjek" => "Mengubah Master Instrumen UTTP - Jenis UTTP: " . $request->nama_jenis_uttp . " - " . $uuid,
                "aktifitas" => $aktifitas,
                "device" => "web",
                "dashboard" => "0",
            ];
            CID::addToLogAktifitas($request, $log);
            // alert success
            alert()->success('Berhasil!', "Berhasil Mengubah Master Instrumen UTTP - Jenis UTTP: " . $request->nama_jenis_uttp);
            return back();
        } else {
            alert()->error('Gagal!', "Gagal Mengubah Master Instrumen UTTP - Jenis UTTP: " . $request->nama_jenis_uttp);
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
        $data = MasterInstrumenJenisUttp::findOrFail($uuid);

        // save
        $save_1 = $data->delete();
        if ($save_1) {
            // create log
            $aktifitas = [
                "tabel" => array("master_instrumen_jenis_uttp"),
                "uuid" => array($uuid),
                "value" => array($data),
            ];
            $log = [
                "apps" => "Settings Apps",
                "subjek" => "Berhasil Menghapus Master Instrumen UTTP - Jenis UTTP: " . $data->nama_jenis_uttp . " - " . $uuid,
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
        $data = MasterInstrumenJenisUttp::findOrFail($uuid);

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
                "tabel" => array("master_instrumen_jenis_uttp"),
                "uuid" => array($uuid),
                "value" => array($data),
            ];
            $log = [
                "apps" => "Settings Apps",
                "subjek" => "Mengubah Status Master Instrumen UTTP - Jenis UTTP: " . $data->nama_jenis_uttp . " - " . $uuid,
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
        $data = MasterInstrumenJenisUttp::orderBy("no_urut", "ASC")->get();

        if ($request->ajax()) {
            return Datatables::of($data)
                ->addIndexColumn()
                ->setRowId('uuid')
                ->addColumn('status_volume', function ($data) {
                    if ($data->status_volume == "1") {
                        $status_volume = '<span class="badge badge-info">Volume</span>';
                    } else {
                        $status_volume = '<span class="badge badge-secondary">Non Volume</span>';
                    }
                    return $status_volume;
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
                    $edit = route('set.apps.mst.ins.uttp.jenis.edit', [$enc_uuid]);
                    $show = route('set.apps.mst.ins.uttp.jenis.show', [$enc_uuid]);
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