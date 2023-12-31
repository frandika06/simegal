<?php

namespace App\Http\Controllers\WebBase\WebAdmin\SettingsApps\master\uttp;

use App\Helpers\CID;
use App\Http\Controllers\Controller;
use App\Models\MasterJenisPelayanan;
use App\Models\MasterKategoriKelompok;
use App\Models\MasterKelompokUttp;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SetAppsUttpTagsKelompokController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // get master uttp jenis pelayanan
        $getJP = MasterJenisPelayanan::whereStatus("1")
            ->orderBy("no_urut", "ASC")
            ->get();

        return view('pages.admin.settings_apps.master.uttp.kategori_kelompok.index', compact(
            'getJP',
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
            "jenis_pelayanan" => "required|string|max:100",
            "nama_kelompok" => "required|string|max:100",
            "kategori" => "required|string|max:100",
            "nama_kategori" => "required|string|max:100",
        ]);

        // getKlpkUttp
        $uuid_kelompok_uttp = $request->nama_kelompok;
        $getKlpkUttp = MasterKelompokUttp::findOrFail($uuid_kelompok_uttp);

        // nomor urut
        $cekData = MasterKategoriKelompok::first();
        if ($cekData === null) {
            $no_urut = 1;
        } else {
            $last_nomor = MasterKategoriKelompok::where("uuid_kelompok_uttp", $uuid_kelompok_uttp)
                ->max('no_urut');
            $no_urut = $last_nomor + 1;
        }

        // value Pegawai
        $uuid = Str::uuid();
        $value_1 = [
            "uuid" => $uuid,
            "uuid_jenis_pelayanan" => $request->jenis_pelayanan,
            "uuid_kelompok_uttp" => $getKlpkUttp->uuid,
            "no_urut" => $no_urut,
            "nama_kategori" => $request->nama_kategori,
            "kategori" => $request->kategori,
            "uuid_created" => $uuid_profile,
        ];

        // save
        $save_1 = MasterKategoriKelompok::create($value_1);
        if ($save_1) {
            // create log
            $aktifitas = [
                "tabel" => array("master_kategori_kelompok"),
                "uuid" => array($uuid),
                "value" => array($value_1),
            ];
            $log = [
                "apps" => "Settings Apps",
                "subjek" => "Menambahkan Master UTTP - Kategori Kelompok: " . $request->nama_kategori . " - " . $uuid,
                "aktifitas" => $aktifitas,
                "device" => "web",
                "dashboard" => "0",
            ];
            CID::addToLogAktifitas($request, $log);
            // alert success
            alert()->success('Berhasil!', "Berhasil Menambahkan Master UTTP - Kategori Kelompok: " . $request->nama_kategori);
            return back();
        } else {
            alert()->error('Gagal!', "Gagal Menambahkan Master UTTP - Kategori Kelompok: " . $request->nama_kategori);
            return back()->withInput($request->all());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($enc_uuid)
    {
        $uuid = CID::decode($enc_uuid);
        $data = MasterKategoriKelompok::findOrFail($uuid);

        $title = "Detail Ketegori Kelompok";
        return view('pages.admin.settings_apps.master.uttp.kategori_kelompok.view', compact(
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
        $data = MasterKategoriKelompok::findOrFail($uuid);

        $title = "Edit Ketegori Kelompok";
        $submit = "Simpan";
        return view('pages.admin.settings_apps.master.uttp.kategori_kelompok.create_edit', compact(
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
        $data = MasterKategoriKelompok::findOrFail($uuid);

        // validate
        $request->validate([
            "no_urut" => "required|numeric",
            "kategori" => "required|string|max:100",
            "nama_kategori" => "required|string|max:100",
        ]);

        // value Pegawai
        $value_1 = [
            "no_urut" => $request->no_urut,
            "kategori" => $request->kategori,
            "nama_kategori" => $request->nama_kategori,
            "uuid_updated" => $uuid_profile,
        ];

        // save
        $save_1 = $data->update($value_1);
        if ($save_1) {
            // create log
            $aktifitas = [
                "tabel" => array("master_kategori_kelompok"),
                "uuid" => array($uuid),
                "value" => array($value_1),
            ];
            $log = [
                "apps" => "Settings Apps",
                "subjek" => "Mengubah Master UTTP - Kategori Kelompok: " . $request->nama_kategori . " - " . $uuid,
                "aktifitas" => $aktifitas,
                "device" => "web",
                "dashboard" => "0",
            ];
            CID::addToLogAktifitas($request, $log);
            // alert success
            alert()->success('Berhasil!', "Berhasil Mengubah Master UTTP - Kategori Kelompok: " . $request->nama_kategori);
            return back();
        } else {
            alert()->error('Gagal!', "Gagal Mengubah Master UTTP - Kategori Kelompok: " . $request->nama_kategori);
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
        $data = MasterKategoriKelompok::findOrFail($uuid);

        // save
        $save_1 = $data->delete();
        if ($save_1) {
            // create log
            $aktifitas = [
                "tabel" => array("master_kategori_kelompok"),
                "uuid" => array($uuid),
                "value" => array($data),
            ];
            $log = [
                "apps" => "Settings Apps",
                "subjek" => "Berhasil Menghapus Master UTTP - Kategori Kelompok: " . $data->nama_kategori . " - " . $uuid,
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
        $data = MasterKategoriKelompok::findOrFail($uuid);

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
                "tabel" => array("master_kategori_kelompok"),
                "uuid" => array($uuid),
                "value" => array($data),
            ];
            $log = [
                "apps" => "Settings Apps",
                "subjek" => "Mengubah Status Master UTTP - Kategori Kelompok: " . $data->nama_kategori . " - " . $uuid,
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
        $data = MasterKategoriKelompok::join("master_jenis_pelayanan", "master_jenis_pelayanan.uuid", "=", "master_kategori_kelompok.uuid_jenis_pelayanan")
            ->join("master_kelompok_uttp", "master_kelompok_uttp.uuid", "=", "master_kategori_kelompok.uuid_kelompok_uttp")
            ->select("master_kategori_kelompok.*")
            ->orderBy("master_jenis_pelayanan.no_urut", "ASC")
            ->orderBy("master_kelompok_uttp.no_urut", "ASC")
            ->orderBy("master_kategori_kelompok.kategori", "ASC")
            ->orderBy("master_kategori_kelompok.no_urut", "ASC")
            ->get();

        if ($request->ajax()) {
            return Datatables::of($data)
                ->addIndexColumn()
                ->setRowId('uuid')
                ->addColumn('nama_pelayanan', function ($data) {
                    $nama_pelayanan = $data->RelMasterJenisPelayanan->nama_pelayanan;
                    return $nama_pelayanan;
                })
                ->addColumn('kode', function ($data) {
                    $kode = $data->RelMasterKelompokUttp->kode;
                    return $kode;
                })
                ->addColumn('nama_kelompok', function ($data) {
                    $nama_kelompok = $data->RelMasterKelompokUttp->nama_kelompok;
                    return $nama_kelompok;
                })
                ->addColumn('kategori', function ($data) {
                    $kategori = $data->kategori;
                    if ($kategori == "0") {
                        $kategori = "Jenis UTTP";
                    } elseif ($kategori == "1") {
                        $kategori = "Alat Standar & Perlengkapannya";
                    } elseif ($kategori == "2") {
                        $kategori = "CTT";
                    }
                    return $kategori;
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
                    $edit = route('set.apps.mst.uttp.tags.klpk.edit', [$enc_uuid]);
                    $show = route('set.apps.mst.uttp.tags.klpk.show', [$enc_uuid]);
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
