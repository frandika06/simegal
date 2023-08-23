<?php

namespace App\Http\Controllers\WebBase\WebAdmin\PortalApps\posts;

use App\Helpers\CID;
use App\Http\Controllers\Controller;
use App\Models\PortalGaleri;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PAGaleriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // auth
        $auth = Auth::user();

        // cek filter
        if ($request->session()->exists('filter_status_galeri')) {
            $status = $request->session()->get('filter_status_galeri');
        } else {
            $request->session()->put('filter_status_galeri', 'Published');
            $status = "Published";
        }

        if ($request->ajax()) {
            if (isset($_GET['filter'])) {
                $status = $_GET['filter']['status'];
                $request->session()->put('filter_status_galeri', $status);
            } else {
                $status = $request->session()->get('filter_status_galeri');
            }

            $data = PortalGaleri::whereStatus($status)->orderBy("created_at", "DESC")->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->setRowId('uuid')
                ->addColumn('judul', function ($data) {
                    $uuid_enc = CID::encode($data->uuid);
                    $edit = route('prt.apps.gallery.edit', [$uuid_enc]);
                    $judul = '<a class="text-underline" href="' . $edit . '">' . $data->judul . '</a>';
                    return $judul;
                })
                ->addColumn('jml_foto', function ($data) {
                    $uuid_enc = CID::encode($data->uuid);
                    $upload = route('prt.apps.foto.index', [$uuid_enc]);
                    $dataFoto = $data->RelDataGaleri->count();
                    $jml_foto = CID::toDot($dataFoto);
                    $jml_foto = '<a target="_BLANK" href="' . $upload . '">' . $jml_foto . '</a>';
                    return $jml_foto;
                })
                ->addColumn('views', function ($data) {
                    $views = CID::toDot($data->views);
                    return $views;
                })
                ->addColumn('publisher', function ($data) {
                    $publisher = $data->Publisher->nama_lengkap;
                    return $publisher;
                })
                ->addColumn('tanggal', function ($data) {
                    $tanggal = $data->created_at;
                    return $tanggal;
                })
                ->addColumn('aksi', function ($data) {
                    $uuid_enc = CID::encode($data->uuid);
                    $upload = route('prt.apps.foto.index', [$uuid_enc]);
                    $edit = route('prt.apps.gallery.edit', [$uuid_enc]);
                    $aksi = '
                        <div class="d-flex">
                            <a target="_BLANK" href="' . $upload . '" class="btn btn-secondary shadow btn-xs sharp me-1"><i class="fas fa-upload"></i></a>
                            <a href="' . $edit . '" class="btn btn-primary shadow btn-xs sharp me-1"><i class="fas fa-pencil-alt"></i></a>
                            <a href="javascript:void(0);" class="btn btn-danger shadow btn-xs sharp" data-delete="' . $uuid_enc . '"><i class="fa fa-trash"></i></a>
                        </div>
                    ';
                    return $aksi;
                })
                ->escapeColumns([''])
                ->make(true);
        }
        return view('pages.admin.portal_apps.galeri.index', compact(
            'status'
        ));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "Tambah Data Galeri";
        $submit = "Simpan";
        return view('pages.admin.portal_apps.galeri.create_edit', compact(
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
            "judul" => "required|string|max:300",
            "deskripsi" => "required|string|max:1000",
            "status" => "required|string|max:15",
        ]);

        // slug
        $slug = \Str::slug($request->judul);
        $cekslug = PortalGaleri::whereSlug($slug)->count();
        if ($cekslug > 0) {
            $inputslug = $cekslug . "-" . CID::gencode(4);
        } else {
            $inputslug = $slug;
        }

        // value
        $uuid = Str::uuid();
        $value_1 = [
            "uuid" => $uuid,
            "judul" => $request->judul,
            "slug" => $inputslug,
            "deskripsi" => nl2br($request->deskripsi),
            "status" => $request->status,
            "uuid_created" => $auth->uuid_profile,
        ];

        // save
        $save_1 = PortalGaleri::create($value_1);
        if ($save_1) {
            // create log
            $aktifitas = [
                "tabel" => array("portal_galeri"),
                "uuid" => array($uuid),
                "value" => array($value_1),
            ];
            $log = [
                "apps" => "SIMEGAL",
                "subjek" => "Portal Apps | Menambahkan Data Galeri UUID= " . $uuid,
                "aktifitas" => $aktifitas,
                "device" => "web",
            ];
            CID::addToLogAktifitas($request, $log);
            // alert success
            alert()->success('Success', "Berhasil Menambahkan Data!");
            return \redirect()->route('prt.apps.gallery.index');
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
        $data = PortalGaleri::findOrFail($uuid);
        $title = "Edit Data Galeri";
        $submit = "Simpan";
        return view('pages.admin.portal_apps.galeri.create_edit', compact(
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
            "judul" => "required|string|max:300",
            "deskripsi" => "required|string|max:1000",
            "status" => "required|string|max:15",
        ]);

        // $uuid
        $uuid = CID::decode($uuid_enc);
        $data = PortalGaleri::findOrFail($uuid);

        // slug
        $slug = \Str::slug($request->judul);
        $cekslug = PortalGaleri::where('uuid', '!=', $uuid)->whereSlug($slug)->count();
        if ($cekslug > 0) {
            $inputslug = $cekslug . "-" . CID::gencode(4);
        } else {
            $inputslug = $slug;
        }

        // value
        $value_1 = [
            "judul" => $request->judul,
            "slug" => $inputslug,
            "deskripsi" => $request->deskripsi,
            "status" => $request->status,
            "uuid_updated" => $auth->uuid_profile,
        ];

        // save
        $save_1 = $data->update($value_1);
        if ($save_1) {
            // create log
            $aktifitas = [
                "tabel" => array("portal_galeri"),
                "uuid" => array($uuid),
                "value" => array($value_1),
            ];
            $log = [
                "apps" => "SIMEGAL",
                "subjek" => "Portal Apps | Mengubah Data Galeri UUID= " . $uuid,
                "aktifitas" => $aktifitas,
                "device" => "web",
            ];
            CID::addToLogAktifitas($request, $log);
            // alert success
            alert()->success('Success', "Berhasil Mengubah Data!");
            return \redirect()->route('prt.apps.gallery.index');
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
        // uuid
        $uuid = CID::decode($request->uuid);

        // data
        $data = PortalGaleri::findOrFail($uuid);

        // save
        $save_1 = $data->delete();
        if ($save_1) {
            // create log
            $aktifitas = [
                "tabel" => array("portal_galeri"),
                "uuid" => array($uuid),
                "value" => array($data),
            ];
            $log = [
                "apps" => "SIMEGAL",
                "subjek" => "Portal Apps | Menghapus Data Galeri UUID= " . $uuid,
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
}
