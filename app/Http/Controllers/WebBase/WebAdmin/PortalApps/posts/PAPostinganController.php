<?php

namespace App\Http\Controllers\WebBase\WebAdmin\PortalApps\posts;

use App\Helpers\CID;
use App\Http\Controllers\Controller;
use App\Models\PortalKategori;
use App\Models\PortalPost;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PAPostinganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // auth
        $auth = Auth::user();

        // cek filter
        if ($request->session()->exists('filter_status_postingan')) {
            $status = $request->session()->get('filter_status_postingan');
        } else {
            $request->session()->put('filter_status_postingan', 'Published');
            $status = "Published";
        }

        if ($request->ajax()) {
            if (isset($_GET['filter'])) {
                $status = $_GET['filter']['status'];
                $request->session()->put('filter_status_postingan', $status);
            } else {
                $status = $request->session()->get('filter_status_postingan');
            }

            $data = PortalPost::whereStatus($status)->orderBy("tanggal", "DESC")->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->setRowId('uuid')
                ->addColumn('judul', function ($data) {
                    $uuid_enc = CID::encode($data->uuid);
                    $edit = route('prt.apps.post.edit', $uuid_enc);
                    $judul = '<a class="text-underline" href="' . $edit . '">' . $data->judul . '</a>';
                    return $judul;
                })
                ->addColumn('publisher', function ($data) {
                    $publisher = $data->Publisher->nama_lengkap;
                    return $publisher;
                })
                ->addColumn('aksi', function ($data) {
                    $uuid_enc = CID::encode($data->uuid);
                    $edit = route('prt.apps.post.edit', $uuid_enc);
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
        return view('pages.admin.portal_apps.postingan.index', compact(
            'status'
        ));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "Tambah Data Postingan";
        $submit = "Simpan";

        // ketegori
        $kategori = PortalKategori::whereJenis("Postingan")->whereStatus("1")->orderBy("nama")->get();
        return view('pages.admin.portal_apps.postingan.create_edit', compact(
            'title',
            'submit',
            'kategori'
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
            "deskripsi" => "sometimes|nullable|string|max:500",
            "post" => "required",
            "kategori" => "required",
            "thumbnails" => "required|image|mimes:png,jpg,jpeg|max:1000",
            "tanggal" => "required",
            "status" => "required|string|max:15",
        ]);

        // slug
        $slug = \Str::slug($request->judul);
        $cekslug = PortalPost::whereSlug($slug)->count();
        if ($cekslug > 0) {
            $inputslug = $cekslug . "-" . CID::gencode(4);
        } else {
            $inputslug = $slug;
        }

        // value
        $uuid = Str::uuid();
        $path = "postingan/" . date('Y') . "/" . $uuid;
        $tanggal = date('Y-m-d H:i:s', strtotime($request->tanggal));
        $value_1 = [
            "uuid" => $uuid,
            "judul" => $request->judul,
            "slug" => $inputslug,
            "deskripsi" => $request->deskripsi,
            "kategori" => implode(",", $request->kategori),
            "tanggal" => $tanggal,
            "status" => $request->status,
            "uuid_created" => $auth->uuid_profile,
        ];

        // thumbnails
        if ($request->hasFile('thumbnails')) {
            $img = CID::UpImg($request, "thumbnails", $path);
            if ($img == "0") {
                alert()->error('Error!', 'Gagal Menyimpan Data, Thumbnails Tidak Sesuai Format!');
                return \back();
            }
            $value_1['thumbnails'] = $img;
        }
        // post
        $imgpost = CID::UpImgPost($request, "post", $path);
        $value_1['post'] = $imgpost;

        // save
        $save_1 = PortalPost::create($value_1);
        if ($save_1) {
            // create log
            $aktifitas = [
                "tabel" => array("portal_post"),
                "uuid" => array($uuid),
                "value" => array($value_1),
            ];
            $log = [
                "apps" => "Portal Apps",
                "subjek" => "Menambahkan Data Postingan UUID= " . $uuid,
                "aktifitas" => $aktifitas,
                "device" => "web",
            ];
            CID::addToLogAktifitas($request, $log);
            // alert success
            alert()->success('Success', "Berhasil Menambahkan Data!");
            return \redirect()->route('prt.apps.post.index');
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
        $data = PortalPost::findOrFail($uuid);
        $title = "Edit Data Postingan";
        $submit = "Simpan";

        // ketegori
        $kategori = PortalKategori::whereJenis("Postingan")->whereStatus("1")->orderBy("nama")->get();
        return view('pages.admin.portal_apps.postingan.create_edit', compact(
            'uuid_enc',
            'title',
            'submit',
            'kategori',
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
            "deskripsi" => "sometimes|nullable|string|max:500",
            "post" => "required",
            "kategori" => "required",
            "thumbnails" => "sometimes|nullable|image|mimes:png,jpg,jpeg|max:1000",
            "tanggal" => "required",
            "status" => "required|string|max:15",
        ]);

        // $uuid
        $uuid = CID::decode($uuid_enc);
        $data = PortalPost::findOrFail($uuid);

        // slug
        $slug = \Str::slug($request->judul);
        $cekslug = PortalPost::where('uuid', '!=', $uuid)->whereSlug($slug)->count();
        if ($cekslug > 0) {
            $inputslug = $cekslug . "-" . CID::gencode(4);
        } else {
            $inputslug = $slug;
        }

        // value
        $thn = date("Y", \strtotime($data->created_at));
        $path = "postingan/" . $thn . "/" . $uuid;
        $tanggal = date('Y-m-d H:i:s', strtotime($request->tanggal));
        $value_1 = [
            "judul" => $request->judul,
            "slug" => $inputslug,
            "deskripsi" => $request->deskripsi,
            "kategori" => implode(",", $request->kategori),
            "tanggal" => $tanggal,
            "status" => $request->status,
            "uuid_updated" => $auth->uuid_profile,
        ];

        // thumbnails
        if ($request->hasFile('thumbnails')) {
            $img = CID::UpImg($request, "thumbnails", $path);
            if ($img == "0") {
                alert()->error('Error!', 'Gagal Menyimpan Data, Thumbnails Tidak Sesuai Format!');
                return \back();
            }
            $value_1['thumbnails'] = $img;
        }
        // post
        $imgpost = CID::UpdateImgPost($request, "post", $path);
        $value_1['post'] = $imgpost;

        // save
        $save_1 = $data->update($value_1);
        if ($save_1) {
            // create log
            $aktifitas = [
                "tabel" => array("portal_post"),
                "uuid" => array($uuid),
                "value" => array($value_1),
            ];
            $log = [
                "apps" => "Portal Apps",
                "subjek" => "Mengubah Data Postingan UUID= " . $uuid,
                "aktifitas" => $aktifitas,
                "device" => "web",
            ];
            CID::addToLogAktifitas($request, $log);
            // alert success
            alert()->success('Success', "Berhasil Mengubah Data!");
            return \redirect()->route('prt.apps.post.index');
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
        $data = PortalPost::findOrFail($uuid);

        // save
        $save_1 = $data->delete();
        if ($save_1) {
            // create log
            $aktifitas = [
                "tabel" => array("portal_post"),
                "uuid" => array($uuid),
                "value" => array($data),
            ];
            $log = [
                "apps" => "Portal Apps",
                "subjek" => "Menghapus Data Postingan UUID= " . $uuid,
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
