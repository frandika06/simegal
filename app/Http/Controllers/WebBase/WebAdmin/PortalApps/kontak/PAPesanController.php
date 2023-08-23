<?php

namespace App\Http\Controllers\WebBase\WebAdmin\PortalApps\kontak;

use App\Helpers\CID;
use App\Http\Controllers\Controller;
use App\Models\PortalPesan;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PAPesanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // auth
        $auth = Auth::user();

        // cek filter
        if ($request->session()->exists('filter_status_pesan')) {
            $status = $request->session()->get('filter_status_pesan');
        } else {
            $request->session()->put('filter_status_pesan', 'Published');
            $status = "Unread";
        }

        if ($request->ajax()) {
            if (isset($_GET['filter'])) {
                $status = $_GET['filter']['status'];
                $request->session()->put('filter_status_pesan', $status);
            } else {
                $status = $request->session()->get('filter_status_pesan');
            }

            $data = PortalPesan::whereStatus($status)->orderBy("created_at", "DESC")->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->setRowId('uuid')
                ->addColumn('nama_lengkap', function ($data) {
                    $uuid_enc = CID::encode($data->uuid);
                    $read = route('prt.apps.pesan.read', $uuid_enc);
                    $nama_lengkap = '<a class="text-underline" href="' . $read . '">' . $data->nama_lengkap . '</a>';
                    return $nama_lengkap;
                })
                ->addColumn('subjek', function ($data) {
                    $uuid_enc = CID::encode($data->uuid);
                    $read = route('prt.apps.pesan.read', $uuid_enc);
                    $subjek = '<a class="text-underline" href="' . $read . '">' . $data->subjek . '</a>';
                    return $subjek;
                })
                ->addColumn('tanggal', function ($data) {
                    $tanggal = $data->created_at;
                    return $tanggal;
                })
                ->addColumn('aksi', function ($data) {
                    $uuid_enc = CID::encode($data->uuid);
                    $aksi = '
                        <div class="d-flex">
                            <a href="javascript:void(0);" class="btn btn-danger shadow btn-xs sharp" data-delete="' . $uuid_enc . '"><i class="fa fa-trash"></i></a>
                        </div>
                    ';
                    return $aksi;
                })
                ->escapeColumns([''])
                ->make(true);
        }
        return view('pages.admin.portal_apps.pesan.index', compact(
            'status'
        ));

    }

    // read
    public function read($uuid_enc)
    {
        // uuid
        $uuid = CID::decode($uuid_enc);
        $data = PortalPesan::findOrFail($uuid);
        $title = "Baca Pesan dari " . $data->nama_lengkap;
        // update status
        $value_1 = ["status" => "Readed"];
        // update
        $data->update($value_1);
        return view('pages.admin.portal_apps.pesan.read', compact(
            'uuid_enc',
            'title',
            'data'
        ));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        // uuid
        $uuid = CID::decode($request->uuid);

        // data
        $data = PortalPesan::findOrFail($uuid);

        // save
        $save_1 = $data->delete();
        if ($save_1) {
            // create log
            $aktifitas = [
                "tabel" => array("portal_pesan"),
                "uuid" => array($uuid),
                "value" => array($data),
            ];
            $log = [
                "apps" => "SIMEGAL",
                "subjek" => "Portal Apps | Menghapus Data Pesan UUID= " . $uuid,
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
