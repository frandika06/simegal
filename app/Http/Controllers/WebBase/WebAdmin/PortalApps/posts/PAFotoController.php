<?php

namespace App\Http\Controllers\WebBase\WebAdmin\PortalApps\posts;

use App\Helpers\CID;
use App\Http\Controllers\Controller;
use App\Models\PortalDataGaleri;
use App\Models\PortalGaleri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Storage;

class PAFotoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $uuid_encgaleri)
    {
        // data foto
        $uuid_galeri = CID::decode($uuid_encgaleri);
        $galeri = PortalGaleri::findOrFail($uuid_galeri);
        if ($request->ajax()) {
            $data = [];
            $foto = PortalDataGaleri::whereUuidGaleri($uuid_galeri)->orderBy("created_at", "DESC");
            $cekFoto = $foto->count();
            if ($cekFoto > 0) {
                $data = $foto->get();
                // ada foto
                foreach ($data as $item) {
                    $data[] = '<div class="col-lg-3 col-6 mb-4"><div class="mb-2"><a target="_BLANK" href="' . CID::urlImg($item->url) . '"><img src="' . CID::urlImg($item->url) . '" style="width:100%;"></a></div><button class="btn btn-sm btn-danger mt-2 btn-block" data-delete="' . CID::encode($item->uuid) . '"><i class="fa fa-trash"></i> Hapus Foto</button></div>';
                }
            } else {
                // tidak ada foro
                $data[] = '<div class="col-md-12 text-center mb-4"><h4>-Tidak Ada Data-</h4></div>';
            }
            return $data;
        }
        return view('pages.admin.portal_apps.foto_galeri.index', compact(
            'uuid_encgaleri',
            'galeri'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function upload(Request $request, $uuid_encgaleri)
    {
        // user
        $user = Auth::user();

        // data
        $uuid_galeri = CID::decode($uuid_encgaleri);
        $cekGaleri = PortalGaleri::find($uuid_galeri);
        if ($cekGaleri === null) {
            $msg = [
                "text" => "UUID Galeri Tidak Valid!",
            ];
            return response()->json(['message' => $msg], 422);
        }
        // Upload File
        $thn = date('Y');
        $file = $request->file('file');
        $filename = $file->getClientOriginalName();
        $name = Str::ucfirst(pathinfo($filename, PATHINFO_FILENAME));
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        $size = $file->getSize();
        $path = "galeri/" . $thn . "/" . $uuid_galeri . "/";
        $file_name = Str::slug($name);
        $file_name = CID::gencode(6) . date('YmdHis') . rand(1000, 9999999) . "-[SIMEGAL]." . Str::lower($ext);
        $url = $path . $file_name;
        if ($file->isValid()) {
            // Cek Ekstensi
            $ext_array = array('jpeg', 'jpg', 'png', 'svg');
            if (!in_array($ext, $ext_array)) {
                // Blokir Exstension
                $msg = [
                    "text" => "Ektensi " . Str::upper($ext) . " Di Blokir!",
                ];
                return response()->json(['message' => $msg], 422);
            }
            // Buat Folder
            if (!is_dir(storage_path('app/public/' . $path))) {
                Storage::disk('public')->makeDirectory($path);
            }
            // upload file
            $file->move(storage_path('app/public/') . $path, $file_name);
            // Value
            $uuid = Str::uuid();
            $value_1 = [
                "uuid" => $uuid,
                "uuid_galeri" => $uuid_galeri,
                "url" => $url,
                "size" => $size,
                "uuid_created" => $user->uuid_profile,
            ];
            $save_1 = PortalDataGaleri::create($value_1);
            if ($save_1) {
                // create log
                $aktifitas = [
                    "tabel" => array("portal_data_galeri"),
                    "uuid" => array($uuid),
                    "value" => array($value_1),
                ];
                $log = [
                    "apps" => "SIMEGAL",
                    "subjek" => "Portal Apps | Menambahkan Data Foto Galeri UUID= " . $uuid,
                    "aktifitas" => $aktifitas,
                    "device" => "web",
                ];
                CID::addToLogAktifitas($request, $log);
                $msg = [
                    "text" => $name . " Berhasil Di Upload Ke Server!",
                ];
                return response()->json(['message' => $msg], 200);
            } else {
                $msg = [
                    "text" => $name . " Gagal Di Upload!",
                ];
                return response()->json(['message' => $msg], 422);
            }
        } else {
            $msg = [
                "text" => "File Tidak Valid!",
            ];
            return response()->json(['message' => $msg], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $uuid_encgaleri)
    {
        // uuid
        $uuid = CID::decode($request->uuid);

        // data
        $uuid_galeri = CID::decode($uuid_encgaleri);
        PortalGaleri::findOrFail($uuid_galeri);
        $data = PortalDataGaleri::findOrFail($uuid);

        // save
        $save_1 = $data->delete();
        if ($save_1) {
            // create log
            $aktifitas = [
                "tabel" => array("portal_data_galeri"),
                "uuid" => array($uuid),
                "value" => array($data),
            ];
            $log = [
                "apps" => "Portal Apps",
                "subjek" => "Menghapus Data Foto Galeri UUID= " . $uuid,
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
