<?php

namespace App\Http\Controllers\WebBase\WebAdmin\ScheduleApps\tte;

use App\Helpers\CID;
use App\Http\Controllers\Controller;
use App\Models\PdpPenjadwalan;
use App\Models\PermohonanPeneraan;
use App\Models\TteSkhp;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ScdTteSkhpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // cek filter
        if ($request->session()->exists('filter_tahun')) {
            $tahun = $request->session()->get('filter_tahun');
            $tags = $request->session()->get('filter_tags_tte');
            $status = $request->session()->get('filter_status_tte');
        } else {
            $request->session()->put('filter_tahun', date('Y'));
            $request->session()->put('filter_tags_tte', 'All');
            $request->session()->put('filter_status_tte', '0');
            $tahun = date('Y');
            $tags = "All";
            $status = "0";
        }

        // cek data permohonan
        $tahunPermohonan = PermohonanPeneraan::select(DB::raw("YEAR(created_at) year"))
            ->groupBy("year")
            ->orderBy("year", "DESC")
            ->get();
        return view('pages.admin.schedule_apps.tte_dokumen.skhp.index', compact(
            'tags',
            'tahun',
            'tahunPermohonan',
        ));
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
        $status = CID::decode($request->status);

        // data
        $data = TteSkhp::where("uuid_penjadwalan", $uuid)->firstOrFail();

        // value
        $value_1 = [
            "status_acc" => $status,
            "uuid_updated" => $auth->uuid_profile,
        ];

        // status_aktif
        if ($status == "0") {
            $value_1['status_aktif'] = "0";
            $value_1['tanggal_acc'] = null;
            $status_acc = "Menunggu";
        } elseif ($status == "1") {
            $value_1['status_aktif'] = "1";
            $value_1['tanggal_acc'] = date('Y-m-d H:i:s');
            $status_acc = "Disetujui";
        } elseif ($status == "2") {
            $value_1['status_aktif'] = "0";
            $value_1['tanggal_acc'] = null;
            $status_acc = "Ditolak";
        }

        // save
        $save_1 = $data->update($value_1);
        if ($save_1) {
            // create log
            $aktifitas = [
                "tabel" => array("tte_skhp"),
                "uuid" => array($uuid),
                "value" => array($data),
            ];
            $log = [
                "apps" => "Schedule Apps",
                "subjek" => "Mengubah Status TTE SKHP Menjadi : " . $status_acc . " - " . $uuid,
                "aktifitas" => $aktifitas,
                "device" => "web",
                "dashboard" => "1",
            ];
            CID::addToLogAktifitas($request, $log);
            // alert success
            $msg = "Berhasil Merubah Status TTE SKHP Menjadi: " . $status_acc . "!";
            $response = [
                "status" => true,
                "message" => $msg,
            ];
            return response()->json($response, 200);
        } else {
            // gagal
            $msg = "Gagal Melakukan Perubahan Status TTE SKHP!";
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
        // auth
        $auth = Auth::user();

        if ($request->ajax()) {
            if (isset($_GET['filter'])) {
                $tahun = $_GET['filter']['tahun'];
                $tags = $_GET['filter']['tags'];
                $status = $_GET['filter']['status'];
                $request->session()->put('filter_tahun', $tahun);
                $request->session()->put('filter_tags_tte', $tags);
                $request->session()->put('filter_status_tte', $status);
            } else {
                $tahun = date('Y');
                $tags = "All";
                $status = "0";
            }

            // hak akses
            $subRoleKetuaTimDanPimpinan = CID::subRoleKetuaTimDanPimpinan();
            if ($subRoleKetuaTimDanPimpinan == true) {
                // hanya petugas
                $uuid_profile = $auth->uuid_profile;
                $data = PdpPenjadwalan::join("tte_skhp", "tte_skhp.uuid_penjadwalan", "=", "pdp_penjadwalan.uuid")
                    ->join("permohonan_peneraan", "permohonan_peneraan.uuid", "=", "pdp_penjadwalan.uuid_permohonan")
                    ->select("pdp_penjadwalan.*", "tte_skhp.status_acc", "tte_skhp.file_skhp")
                    ->whereYear("pdp_penjadwalan.tanggal_peneraan", $tahun)
                    ->where("pdp_penjadwalan.status_peneraan", "Selesai")
                    ->where("tte_skhp.uuid_pejabat", $uuid_profile)
                    ->where("tte_skhp.status_acc", $status)
                    ->where("tte_skhp.file_skhp", "!=", null)
                    ->orderBy("tte_skhp.created_at", "ASC");
            } else {
                $data = PdpPenjadwalan::join("tte_skhp", "tte_skhp.uuid_penjadwalan", "=", "pdp_penjadwalan.uuid")
                    ->join("permohonan_peneraan", "permohonan_peneraan.uuid", "=", "pdp_penjadwalan.uuid_permohonan")
                    ->select("pdp_penjadwalan.*", "tte_skhp.status_acc", "tte_skhp.file_skhp")
                    ->whereYear("pdp_penjadwalan.tanggal_peneraan", $tahun)
                    ->where("pdp_penjadwalan.status_peneraan", "Selesai")
                    ->where("tte_skhp.status_acc", $status)
                    ->where("tte_skhp.file_skhp", "!=", null)
                    ->orderBy("tte_skhp.created_at", "ASC");
            }

            // cek tags
            if ($tags == "All") {
                $data = $data->get();
            } else {
                $data = $data->where("permohonan_peneraan.jenis_pengujian", $tags)->get();
            }

            return Datatables::of($data)
                ->addIndexColumn()
                ->setRowId('uuid')
                ->addColumn('detail_permohonan', function ($data) {
                    $relPermohonan = $data->RelPermohonanPeneraan;
                    $relPerusahaan = $data->RelPermohonanPeneraan->RelPerusahaan;
                    $detail_permohonan = '
                    <p class="m-0 p-0"><strong>Kode Permohonan</strong><span>: ' . $relPermohonan->kode_permohonan . '</span></p>
                    <p class="m-0 p-0"><strong>Perusahaan/UTTP</strong><span>: ' . $relPerusahaan->nama_perusahaan . '</span></p>
                    <p class="m-0 p-0"><strong>Jenis</strong><span>: ' . $relPerusahaan->jenis_perusahaan . '</span></p>
                    <p class="m-0 p-0"><strong>Status Permohonan</strong>: <span class="badge badge-secondary">' . $relPermohonan->status . '</span></p>
                ';
                    return $detail_permohonan;
                })
                ->addColumn('detail_tinjut', function ($data) {
                    $detail_tinjut = '
                    <p class="m-0 p-0"><strong>Nomor Order</strong><span>: ' . $data->nomor_order . '</span></p>
                    <p class="m-0 p-0"><strong>Tgl. Peneraan</strong><span>: ' . CID::tglBlnThn($data->tanggal_peneraan) . '</span></p>
                    <p class="m-0 p-0"><strong>Jam Peneraan</strong><span>: ' . CID::jamMenit($data->jam_peneraan) . '</span></p>
                    <p class="m-0 p-0"><strong>Status Peneraan</strong>: <span class="badge badge-info">' . $data->status_peneraan . '</span></p>
                ';
                    return $detail_tinjut;
                })
                ->addColumn('aksi', function ($data) {
                    $enc_uuid = CID::encode($data->uuid);
                    $menunggu = CID::encode('0');
                    $disetujui = CID::encode('1');
                    $ditolak = CID::encode('2');
                    $file_skhp = CID::urlImg($data->file_skhp);
                    $link_action = '';
                    // route action
                    if ($data->status_acc == "0") {
                        $link_action = '<li><a class="dropdown-item bg-hover-success" href="javascript:void(0);" data-disetujui="' . $enc_uuid . '" data-status="' . $disetujui . '"><i class="fa-solid fa-check"></i> Setujui</a></li>';
                        $link_action .= '<li><a class="dropdown-item bg-hover-danger" href="javascript:void(0);" data-ditolak="' . $enc_uuid . '" data-status="' . $ditolak . '"><i class="fa-solid fa-times"></i> Tolak</a></li>';
                    } else {
                        $link_action = '<li><a class="dropdown-item bg-hover-danger" href="javascript:void(0);" data-hapus="' . $enc_uuid . '" data-status="' . $menunggu . '"><i class="fa-solid fa-trash"></i> Hapus</a></li>';
                    }
                    // aksi
                    $aksi = '<div class="dropdown mt-2">
                        <button class="btn btn-light btn-default btn-flex btn-center btn-sm dropdown-toggle" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                            Aksi
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                            ' . $link_action . '
                            <li><a target="_BLANK" class="dropdown-item" href="' . $file_skhp . '"><i class="fa-solid fa-eye"></i> Lihat SKHP</a></li>
                        </ul>
                    </div>';
                    return $aksi;
                })
                ->escapeColumns([''])
                ->make(true);
        }
    }
}
