<?php

namespace App\Http\Controllers\WebBase\WebAdmin\PortalApps\master;

use App\Helpers\CID;
use App\Http\Controllers\Controller;
use App\Models\PortalKategori;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PAKategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // auth
        $auth = Auth::user();

        if ($request->ajax()) {
            $data = PortalKategori::orderBy("nama", "ASC")->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->setRowId('uuid')
                ->addColumn('status', function ($data) use ($auth) {
                    $uuid = CID::encode($data->uuid);
                    if ($data->status == "1") {
                        $toogle = "checked";
                        $text = "Aktif";
                    } else {
                        $toogle = "";
                        $text = "Tidak Aktif";
                    }
                    // role
                    $sub_role = $auth->sub_role;
                    if ($sub_role == "Admin Portal" || $sub_role == "") {
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
                    $uuid_enc = CID::encode($data->uuid);
                    $edit = route('prt.apps.mst.tags.edit', $uuid_enc);
                    $aksi = '
                        <div class="d-flex">
                            <a href="' . $edit . '" class="btn btn-primary shadow btn-xs sharp me-1"><i class="fas fa-pencil-alt"></i></a>
                            <a href="javascript:void(0);" class="btn btn-danger shadow btn-xs sharp" data-delete="' . $uuid_enc . '"><i class="fa fa-trash"></i></a>
                        </div>
                    ';
                    return $aksi;
                })
                ->escapeColumns([''])
                ->make(true);
        }
        return view('pages.admin.portal_apps.kategori.index');

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "Tambah Data Master Kategori";
        $submit = "Simpan";
        return view('pages.admin.portal_apps.kategori.create_edit', compact(
            'title',
            'submit'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // auth
        $auth = Auth::user();

        //validate
        $request->validate([
            "nama" => "required|string|max:100",
            "jenis" => "required|string|max:100",
        ]);

        //uuid
        $uuid = Str::uuid();
        $nama = $request->nama;
        $jenis = $request->jenis;

        // cek kategori
        $cekKategori = PortalKategori::whereNama($nama)->whereJenis($jenis)->first();
        if ($cekKategori !== null) {
            // ada data
            alert()->error('Error!', 'Nama Kategori Sudah Ada!');
            return \back()->withInput($request->all());
        }

        // value
        $value_1 = [
            "uuid" => $uuid,
            "nama" => $nama,
            "slug" => Str::slug($nama),
            "jenis" => $jenis,
            "uuid_created" => $auth->uuid_profile,
        ];

        // save
        $save_1 = PortalKategori::create($value_1);
        if ($save_1) {
            // create log
            $aktifitas = [
                "tabel" => array("portal_kategori"),
                "uuid" => array($uuid),
                "value" => array($value_1),
            ];
            $log = [
                "apps" => "Portal Apps",
                "subjek" => "Menambahkan Data Master Kategori: " . $nama . " - " . $uuid,
                "aktifitas" => $aktifitas,
                "device" => "web",
            ];
            CID::addToLogAktifitas($request, $log);
            // alert success
            alert()->success('Success', "Berhasil Menambahkan Data!");
            return \redirect()->route('prt.apps.mst.tags.index');
        } else {
            alert()->error('Error', "Gagal Menambahkan Data!");
            return \back()->withInput($request->all());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($uuid_enc)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($uuid_enc)
    {
        // uuid
        $uuid = CID::decode($uuid_enc);
        $data = PortalKategori::findOrFail($uuid);
        $title = "Edit Data Master Kategori";
        $submit = "Simpan";
        return view('pages.admin.portal_apps.kategori.create_edit', compact(
            'uuid_enc',
            'title',
            'submit',
            'data'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $uuid_enc)
    {
        // auth
        $auth = Auth::user();

        //validate
        $request->validate([
            "nama" => "required|string|max:100",
            "jenis" => "required|string|max:100",
        ]);

        // uuid
        $uuid = CID::decode($uuid_enc);
        $data = PortalKategori::findOrFail($uuid);
        $nama = $request->nama;
        $jenis = $request->jenis;

        if ($nama != $data->nama || $jenis != $data->jenis) {
            // cek kategori
            $cekKategori = PortalKategori::whereNama($nama)->whereJenis($jenis)->first();
            if ($cekKategori !== null) {
                // ada data
                alert()->error('Error!', 'Nama Kategori Sudah Ada!');
                return \back()->withInput($request->all());
            }
        }

        // value
        $value_1 = [
            "nama" => $nama,
            "slug" => Str::slug($nama),
            "jenis" => $jenis,
            "uuid_created" => $auth->uuid_profile,
        ];

        // save
        $save_1 = $data->update($value_1);
        if ($save_1) {
            // create log
            $aktifitas = [
                "tabel" => array("portal_kategori"),
                "uuid" => array($uuid),
                "value" => array($value_1),
            ];
            $log = [
                "apps" => "Portal Apps",
                "subjek" => "Mengubah Data Master Kategori: " . $nama . " - " . $uuid,
                "aktifitas" => $aktifitas,
                "device" => "web",
            ];
            CID::addToLogAktifitas($request, $log);
            // alert success
            alert()->success('Success', "Berhasil Mengubah Data!");
            return \redirect()->route('prt.apps.mst.tags.index');
        } else {
            alert()->error('Error', "Gagal Mengubah Data!");
            return \back()->withInput($request->all());
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
        $data = PortalKategori::findOrFail($uuid);

        // save
        $save_1 = $data->delete();
        if ($save_1) {
            // create log
            $aktifitas = [
                "tabel" => array("portal_kategori"),
                "uuid" => array($uuid),
                "value" => array($data),
            ];
            $log = [
                "apps" => "Portal Apps",
                "subjek" => "Menghapus Data Master Kategori: " . $data->nama . " - " . $uuid,
                "aktifitas" => $aktifitas,
                "device" => "web",
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
        $data = PortalKategori::findOrFail($uuid);

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
                "tabel" => array("portal_kategori"),
                "uuid" => array($uuid),
                "value" => array($data),
            ];
            $log = [
                "apps" => "Portal Apps",
                "subjek" => "Mengubah Status Master Kategori: " . $data->nama . " - " . $uuid,
                "aktifitas" => $aktifitas,
                "device" => "web",
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
}