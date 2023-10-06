<?php

namespace App\Http\Controllers\WebBase\WebAdmin\ScheduleApps\permohonan;

use App\Helpers\CID;
use App\Http\Controllers\Controller;
use App\Models\PermohonanPeneraan;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ScdTindakLanjutController extends Controller
{
    // index
    public function index(Request $request)
    {
        // cek filter
        if ($request->session()->exists('filter_tahun')) {
            $tahun = $request->session()->get('filter_tahun');
        } else {
            $request->session()->put('filter_tahun', date('Y'));
            $tahun = date('Y');
        }

        // cek data permohonan
        $tahunPermohonan = PermohonanPeneraan::select(DB::raw("YEAR(created_at) year"))
            ->groupBy("year")
            ->orderBy("year", "DESC")
            ->get();
        return view('pages.admin.schedule_apps.pdp.index', compact(
            'tahun',
            'tahunPermohonan',
        ));
    }

    // create
    public function create()
    {
        // return view('');
    }

    /**
     * Data untuk Datatables
     */
    public function data(Request $request)
    {
        // cek filter
        if ($request->session()->exists('filter_tahun')) {
            $tahun = $request->session()->get('filter_tahun');
        } else {
            $request->session()->put('filter_tahun', date('Y'));
            $tahun = date('Y');
        }

        // if ($request->ajax()) {
        if (isset($_GET['filter'])) {
            $tahun = $_GET['filter']['tahun'];
            $tags = $_GET['filter']['tags'];
            $request->session()->put('filter_tahun', $tahun);
        } else {
            $tahun = date('Y');
            $tags = "Tera";
        }

        $data = PermohonanPeneraan::join("perusahaan", "perusahaan.uuid", "=", "permohonan_peneraan.uuid_perusahaan")
            ->select("permohonan_peneraan.*")
            ->where("perusahaan.file_npwp", "!=", null)
            ->where("perusahaan.verifikasi", "=", "1")
            ->whereYear("permohonan_peneraan.tanggal_permohonan", $tahun)
            ->where("permohonan_peneraan.status", "Diproses")
            ->where("permohonan_peneraan.jenis_pengujian", $tags)
            ->where("perusahaan.status", "=", "1")
            ->orderBy("permohonan_peneraan.created_at", "DESC")
            ->get();

        return Datatables::of($data)
            ->addIndexColumn()
            ->setRowId('uuid')
            ->addColumn('detail_permohonan', function ($data) {
                $detail_permohonan = '
                <p class="m-0 p-0"><strong style="display:inline-block; min-width:90px;">Kode</strong><span>: ' . $data->kode_permohonan . '</span></p>
                <p class="m-0 p-0"><strong style="display:inline-block; min-width:90px;">Nomor Surat</strong><span>: ' . $data->nomor_surat_permohonan . '</span></p>
                <p class="m-0 p-0"><strong style="display:inline-block; min-width:90px;">File Surat</strong><span>: <a target="_BLANK" href="' . CID::urlImg($data->file_surat_permohonan) . '" class="fw-bold"><i class="fa-solid fa-search"></i> Lihat File</a></span></p>
                <p class="m-0 p-0"><strong style="display:inline-block; min-width:90px;">Publish</strong><span>: ' . CID::TglJam($data->created_at) . '</span></p>
                ';
                return $detail_permohonan;
            })
            ->addColumn('detail_pemohon', function ($data) {
                $profile = $data->RelPerusahaan;
                $detail_pemohon = '
                <p class="m-0 p-0"><strong style="display:inline-block; min-width:90px;">Kode</strong><span>: ' . $profile->kode_perusahaan . '</span></p>
                <p class="m-0 p-0"><strong style="display:inline-block; min-width:90px;">Nama</strong><span>: ' . $profile->nama_perusahaan . '</span></p>
                <p class="m-0 p-0"><strong style="display:inline-block; min-width:90px;">NPWP</strong><span>: ' . $profile->npwp . '</span></p>
                <div class="accordion accordion-icon-collapse mt-2 m-0 p-0" id="kt_accordion_' . $data->uuid . '">
                    <div class="mb-5">
                        <div class="accordion-header d-flex collapsed" data-bs-toggle="collapse" data-bs-target="#detail_pemohon_accordion_' . $data->uuid . '">
                            <span class="accordion-icon me-2">
                                <i class="ki-duotone ki-plus-square fs-3 accordion-icon-off"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                                <i class="ki-duotone ki-minus-square fs-3 accordion-icon-on"><span class="path1"></span><span class="path2"></span></i>
                            </span>
                            <p class="p-0 m-0 text-primary">Selengkapnya...</p>
                        </div>
                        <div id="detail_pemohon_accordion_' . $data->uuid . '" class="fs-6 pt-2 collapse mw-300px" data-bs-parent="#kt_accordion_' . $data->uuid . '">
                            <p class="m-0 p-0"><strong style="display:inline-block; min-width:90px;">Jenis</strong><span>: ' . $profile->jenis_perusahaan . '</span></p>
                            <p class="m-0 p-0"><strong style="display:inline-block; min-width:90px;">PIC</strong><span>: ' . $profile->nama_pic . '</span></p>
                            <p class="m-0 p-0"><strong style="display:inline-block; min-width:90px;">Email</strong><span>: ' . $profile->email . '</span></p>
                            <p class="m-0 p-0"><strong style="display:inline-block; min-width:90px;">No. Telp 1</strong><span>: ' . $profile->no_telp_1 . '</span></p>
                            <p class="m-0 p-0"><strong style="display:inline-block; min-width:90px;">No. Telp 2</strong><span>: ' . $profile->no_telp_2 . '</span></p>
                            <p class="m-0 p-0"><strong style="display:inline-block; min-width:90px;">File NPWP</strong><span>: <a target="_BLANK" href="' . CID::urlImg($data->RelPerusahaan->file_npwp) . '" class="fw-bold"><i class="fa-solid fa-search"></i> Lihat File</a></span></p>
                        </div>
                    </div>
                </div>
                ';
                return $detail_pemohon;
            })
            ->addColumn('detail_pengujian', function ($data) {
                $lokasi = $data->lokasi_peneraan;
                $relAlamat = $data->RelAlamatPerusahaan;
                if ($relAlamat !== null) {
                    $alamat_luar_kantor = $relAlamat->alamat . ", RT. " . $relAlamat->rt . ", RW. " . $relAlamat->rw . ", " . Str::title($relAlamat->Desa->name) . ", " . Str::title($relAlamat->Kecamatan->name) . ", " . Str::title($relAlamat->Kabupaten->name) . ", " . Str::title($relAlamat->Provinsi->name) . " " . $relAlamat->kode_pos . ".";
                }
                $detail_pengujian = '
                    <p class="m-0 p-0"><strong style="display:inline-block; min-width:90px;">Lokasi</strong><span>: ' . $data->lokasi_peneraan . '</span></p>
                ';
                // alamat
                if ($lokasi == "Dalam Kantor") {
                    $detail_pengujian .= '<p class="m-0 p-0"><strong style="display:inline-block; min-width:90px;">Alamat</strong><span>: Bidang Metrologi Legal, Kec. Balaraja, Kabupaten Tangerang, Banten 15610.</span></p>';
                } else {
                    $detail_pengujian .= '<p class="m-0 p-0"><strong style="display:inline-block; min-width:90px;">Alamat</strong><span>: ' . $alamat_luar_kantor . '</span></p>';
                }
                // google maps
                if ($relAlamat !== null && ($relAlamat->google_maps != '' || ($relAlamat->lat != '' && $relAlamat->long != ''))) {
                    if (($relAlamat->google_maps != '')) {
                        // by url
                        $url_maps = $relAlamat->google_maps;
                    } elseif ($relAlamat->lat != '' && $relAlamat->long != '') {
                        // by latitude & longitude
                        $url_maps = 'https://www.google.com/maps/search/?api=1&query=' . $relAlamat->lat . ',' . $relAlamat->long . '';
                    }
                    $detail_pengujian .= '<p class="m-0 p-0"><strong style="display:inline-block; min-width:90px;">Maps</strong><span>: <a href="' . $url_maps . '" target="_BLANK"><i class="fa-solid fa-map-location-dot"></i> Buka Maps</a></span></p>';
                }
                return $detail_pengujian;
            })
            ->addColumn('aksi', function ($data) {
                $enc_uuid = CID::encode($data->uuid);
                $aksi = '<a href="#" class="btn btn-info btn-icon" data-bs-toggle="tooltip" title="Input Data Penugasan & Penjadwalan"><i class="fa-solid fa-keyboard fs-2"></i></a>';

                return $aksi;
            })
            ->escapeColumns([''])
            ->make(true);
        // }
    }
}
