<?php

namespace App\Http\Controllers\WebBase\WebAdmin\ScheduleApps\tinjut;

use App\Helpers\CID;
use App\Http\Controllers\Controller;
use App\Models\MasterKelompokUttp;
use App\Models\PdpPenjadwalan;
use App\Models\PermohonanPeneraan;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ScdTinjutMTController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // cek filter
        if ($request->session()->exists('filter_tahun')) {
            $tahun = $request->session()->get('filter_tahun');
            $tags = $request->session()->get('filter_tags_tinjut_mt');
        } else {
            $request->session()->put('filter_tahun', date('Y'));
            $request->session()->put('filter_tags_tinjut_mt', 'Tera');
            $tahun = date('Y');
            $tags = "Tera";
        }

        // cek data permohonan
        $tahunPermohonan = PermohonanPeneraan::select(DB::raw("YEAR(created_at) year"))
            ->groupBy("year")
            ->orderBy("year", "DESC")
            ->get();
        return view('pages.admin.schedule_apps.tindak_lanjut.massa.index', compact(
            'tahun',
            'tahunPermohonan',
        ));
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
                $request->session()->put('filter_tahun', $tahun);
                $request->session()->put('filter_tags_tinjut_mt', $tags);
            } else {
                $tahun = date('Y');
                $tags = "Tera";
            }

            // get kelompok uttp
            $getKelompokUttp = MasterKelompokUttp::join("master_jenis_pelayanan", "master_jenis_pelayanan.uuid", "=", "master_kelompok_uttp.uuid_jenis_pelayanan")
                ->select("master_kelompok_uttp.*")
                ->where("master_jenis_pelayanan.nama_pelayanan", $tags)
                ->where("master_kelompok_uttp.kode", "MT")
                ->firstOrFail();
            $uuid_kelompok_uttp = $getKelompokUttp->uuid;

            // hak akses
            $subRoleOnlyPetugas = CID::subRoleOnlyPetugas();
            if ($subRoleOnlyPetugas == true) {
                // hanya petugas
                $uuid_profile = $auth->uuid_profile;
                $data = PdpPenjadwalan::join("pdp_data_petugas", "pdp_data_petugas.uuid_penjadwalan", "=", "pdp_penjadwalan.uuid")
                    ->select("pdp_penjadwalan.*")
                    ->where("pdp_penjadwalan.uuid_kelompok_uttp", $uuid_kelompok_uttp)
                    ->whereYear("pdp_penjadwalan.tanggal_peneraan", $tahun)
                    ->whereIn("pdp_penjadwalan.status_peneraan", ["Diproses", "Selesai"])
                    ->where("pdp_data_petugas.uuid_pegawai", $uuid_profile)
                    ->orderBy("tanggal_peneraan", "ASC")
                    ->orderBy("jam_peneraan", "ASC")
                    ->get();
            } else {
                $data = PdpPenjadwalan::where("uuid_kelompok_uttp", $uuid_kelompok_uttp)
                    ->whereYear("tanggal_peneraan", $tahun)
                    ->whereIn("status_peneraan", ["Diproses", "Selesai"])
                    ->orderBy("tanggal_peneraan", "ASC")
                    ->orderBy("jam_peneraan", "ASC")
                    ->get();
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
                    $permohonan = $data->RelPermohonanPeneraan;
                    $perusahaan = $permohonan->RelPerusahaan;
                    $tags_jp = CID::encode('mt');
                    // route print
                    $routeSuratJalan = route('print.pdp.sj', [$enc_uuid]);
                    $routeSuratPerintah = route('print.pdp.spt', [$enc_uuid]);
                    $routeDisposisi = route('print.pdp.disposisi', [$enc_uuid]);
                    // route action
                    $routeActionSkhp = route('scd.apps.tinjut.action.skhp.index', [$tags_jp, $enc_uuid]);
                    // route detail
                    $routePerusahaan = route('set.apps.perusahaan.show', [CID::encode('Aktif'), CID::encode($perusahaan->uuid)]);
                    $routePdp = route('scd.apps.data.pdp.show', [$enc_uuid]);
                    $routeInsalat = route('scd.apps.insalat.show', [$enc_uuid]);
                    // aksi
                    $aksi = '<div class="dropdown">
                        <button class="btn btn-light btn-dark btn-flex btn-center btn-sm dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-print"></i>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                            <li><a target="_BLANK" class="dropdown-item" href="' . $routeSuratJalan . '"><i class="fa-solid fa-print"></i> Surat Jalan</a></li>
                            <li><a target="_BLANK" class="dropdown-item" href="' . $routeSuratPerintah . '"><i class="fa-solid fa-print"></i> Surat Perintah</a></li>
                            <li><a target="_BLANK" class="dropdown-item" href="' . $routeDisposisi . '"><i class="fa-solid fa-print"></i> Kartu Penerus Disposisi</a></li>
                        </ul>
                    </div>';
                    $aksi .= '<div class="dropdown mt-2">
                        <button class="btn btn-light btn-primary btn-flex btn-center btn-sm dropdown-toggle" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-gear"></i>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                            <li><a class="dropdown-item" href="' . $routeActionSkhp . '"><i class="fa-solid fa-stamp"></i> Manajemen SKHP</a></li>
                        </ul>
                    </div>';
                    $aksi .= '<div class="dropdown mt-2">
                        <button class="btn btn-light btn-info btn-flex btn-center btn-sm dropdown-toggle" type="button" id="dropdownMenuButton3" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-circle-info"></i>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
                            <li><a target="_BLANK" class="dropdown-item" href="' . $routePerusahaan . '"><i class="fa-solid fa-hotel"></i> Detail Perusahaan</a></li>
                            <li><a target="_BLANK" class="dropdown-item" href="' . $routePdp . '"><i class="fa-solid fa-user-check"></i> Detail Jadwal & Penugasan</a></li>
                            <li><a target="_BLANK" class="dropdown-item" href="' . $routeInsalat . '"><i class="fa-solid fa-scale-balanced"></i> Detail Instrumen & Alat</a></li>
                        </ul>
                    </div>';
                    return $aksi;
                })
                ->escapeColumns([''])
                ->make(true);
        }
    }

    /**
     * Data untuk Datatables
     */
    public function dataX(Request $request)
    {
        // auth
        $auth = Auth::user();

        if ($request->ajax()) {
            if (isset($_GET['filter'])) {
                $tahun = $_GET['filter']['tahun'];
                $tags = $_GET['filter']['tags'];
                $request->session()->put('filter_tahun', $tahun);
                $request->session()->put('filter_tags_tinjut_mt', $tags);
            } else {
                $tahun = date('Y');
                $tags = "Tera";
            }

            // get kelompok uttp
            $getKelompokUttp = MasterKelompokUttp::join("master_jenis_pelayanan", "master_jenis_pelayanan.uuid", "=", "master_kelompok_uttp.uuid_jenis_pelayanan")
                ->select("master_kelompok_uttp.*")
                ->where("master_jenis_pelayanan.nama_pelayanan", $tags)
                ->where("master_kelompok_uttp.kode", "MT")
                ->firstOrFail();
            $uuid_kelompok_uttp = $getKelompokUttp->uuid;

            // hak akses
            $subRoleOnlyPetugas = CID::subRoleOnlyPetugas();
            if ($subRoleOnlyPetugas == true) {
                // hanya petugas
                $uuid_profile = $auth->uuid_profile;
                $data = PdpPenjadwalan::join("pdp_data_petugas", "pdp_data_petugas.uuid_penjadwalan", "=", "pdp_penjadwalan.uuid")
                    ->select("pdp_penjadwalan.*")
                    ->where("pdp_penjadwalan.uuid_kelompok_uttp", $uuid_kelompok_uttp)
                    ->whereYear("pdp_penjadwalan.tanggal_peneraan", $tahun)
                    ->whereIn("pdp_penjadwalan.status_peneraan", ["Diproses", "Selesai"])
                    ->where("pdp_data_petugas.uuid_pegawai", $uuid_profile)
                    ->orderBy("tanggal_peneraan", "ASC")
                    ->orderBy("jam_peneraan", "ASC")
                    ->get();
            } else {
                $data = PdpPenjadwalan::where("uuid_kelompok_uttp", $uuid_kelompok_uttp)
                    ->whereYear("tanggal_peneraan", $tahun)
                    ->whereIn("status_peneraan", ["Diproses", "Selesai"])
                    ->orderBy("tanggal_peneraan", "ASC")
                    ->orderBy("jam_peneraan", "ASC")
                    ->get();
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
                    $permohonan = $data->RelPermohonanPeneraan;
                    $perusahaan = $permohonan->RelPerusahaan;
                    // route print
                    $routeSuratJalan = route('print.pdp.sj', [$enc_uuid]);
                    $routeSuratPerintah = route('print.pdp.spt', [$enc_uuid]);
                    $routeDisposisi = route('print.pdp.disposisi', [$enc_uuid]);
                    // route detail
                    $routePerusahaan = route('set.apps.perusahaan.show', [CID::encode('Aktif'), CID::encode($perusahaan->uuid)]);
                    $routePdp = route('scd.apps.data.pdp.show', [$enc_uuid]);
                    $routeInsalat = route('scd.apps.insalat.show', [$enc_uuid]);
                    // aksi
                    $aksi = '<div class="dropdown">
                        <button class="btn btn-light btn-dark btn-flex btn-center btn-sm dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-print"></i>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                            <li><a target="_BLANK" class="dropdown-item" href="' . $routeSuratJalan . '"><i class="fa-solid fa-print"></i> Surat Jalan</a></li>
                            <li><a target="_BLANK" class="dropdown-item" href="' . $routeSuratPerintah . '"><i class="fa-solid fa-print"></i> Surat Perintah</a></li>
                            <li><a target="_BLANK" class="dropdown-item" href="' . $routeDisposisi . '"><i class="fa-solid fa-print"></i> Kartu Penerus Disposisi</a></li>
                        </ul>
                    </div>';
                    $aksi .= '<div class="dropdown mt-2">
                        <button class="btn btn-light btn-primary btn-flex btn-center btn-sm dropdown-toggle" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-gear"></i>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                            <li><a class="dropdown-item" href="#"><i class="fa-solid fa-table-list"></i> Manajemen Cerapan</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fa-solid fa-money-bill-transfer"></i> Manajemen Retribusi</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fa-solid fa-stamp"></i> Manajemen SKHP</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fa-solid fa-image"></i> Dokumentasi Kegiatan</a></li>
                        </ul>
                    </div>';
                    $aksi .= '<div class="dropdown mt-2">
                        <button class="btn btn-light btn-info btn-flex btn-center btn-sm dropdown-toggle" type="button" id="dropdownMenuButton3" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-circle-info"></i>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
                            <li><a target="_BLANK" class="dropdown-item" href="' . $routePerusahaan . '"><i class="fa-solid fa-hotel"></i> Detail Perusahaan</a></li>
                            <li><a target="_BLANK" class="dropdown-item" href="' . $routePdp . '"><i class="fa-solid fa-user-check"></i> Detail Jadwal & Penugasan</a></li>
                            <li><a target="_BLANK" class="dropdown-item" href="' . $routeInsalat . '"><i class="fa-solid fa-scale-balanced"></i> Detail Instrumen & Alat</a></li>
                        </ul>
                    </div>';
                    return $aksi;
                })
                ->escapeColumns([''])
                ->make(true);
        }
    }

}
