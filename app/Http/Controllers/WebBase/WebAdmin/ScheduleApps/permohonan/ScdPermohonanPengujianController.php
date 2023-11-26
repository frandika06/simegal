<?php

namespace App\Http\Controllers\WebBase\WebAdmin\ScheduleApps\permohonan;

use App\Helpers\CID;
use App\Http\Controllers\Controller;
use App\Models\PdpPenjadwalan;
use App\Models\PermohonanPeneraan;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ScdPermohonanPengujianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $enc_tags)
    {
        // tags
        $tags = CID::decode($enc_tags);

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
        return view('pages.admin.schedule_apps.permohonan.index', compact(
            'enc_tags',
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
        $data = PermohonanPeneraan::findOrFail($uuid);

        // cek penjadwalan dan penugasan
        if ($status == "Baru") {
            // status permohonan Baru
            $cekPdp = PdpPenjadwalan::where("uuid_permohonan", $uuid)->first();
            if ($cekPdp !== null) {
                // cek status peneraan
                $status_peneraan = $cekPdp->status_peneraan;
                if ($status_peneraan == "Dibatalkan") {
                    // gagal
                    $msg = "Permohonan Ini Sudah Dibatalkan Oleh Petugas!";
                    $response = [
                        "status" => false,
                        "message" => $msg,
                    ];
                    return response()->json($response, 422);
                } else {
                    // gagal
                    $msg = "Permohonan Sudah Dijadwalkan, Tidak Bisa Di Reset!";
                    $response = [
                        "status" => false,
                        "message" => $msg,
                    ];
                    return response()->json($response, 422);
                }
            }
        } elseif ($status == "Diproses") {
            // status permohonan Diproses
            $cekPdp = PdpPenjadwalan::where("uuid_permohonan", $uuid)->first();
            if ($cekPdp !== null) {
                // cek status peneraan
                $status_peneraan = $cekPdp->status_peneraan;
                if ($status_peneraan == "Selesai") {
                    // gagal
                    $msg = "Permohonan Ini Sudah Selesai Dilaksanakan Pengujian!";
                    $response = [
                        "status" => false,
                        "message" => $msg,
                    ];
                    return response()->json($response, 422);
                }
            }
        } elseif ($status == "Selesai") {
            // status permohonan Selesai
            $cekPdp = PdpPenjadwalan::where("uuid_permohonan", $uuid)->first();
            if ($cekPdp !== null) {
                // cek status peneraan
                $status_peneraan = $cekPdp->status_peneraan;
                if ($status_peneraan != "Selesai") {
                    // gagal
                    $msg = "Permohonan Belum Diselesaikan Oleh Petugas Penera, Status Saat ini adalah " . Str::upper($status_peneraan) . "!";
                    $response = [
                        "status" => false,
                        "message" => $msg,
                    ];
                    return response()->json($response, 422);
                }
            } else {
                // belum dijadwalkan dan ditugaskan
                // gagal
                $msg = "Permohonan Ini Belum Ada Data Penjadwalan dan Penugasannya!";
                $response = [
                    "status" => false,
                    "message" => $msg,
                ];
                return response()->json($response, 422);
            }
        }

        // value
        $value_1 = [
            "status" => $status,
            "uuid_verifikator" => $auth->uuid_profile,
            "uuid_updated" => $auth->uuid_profile,
        ];

        // save
        $save_1 = $data->update($value_1);
        if ($save_1) {
            // create log
            $aktifitas = [
                "tabel" => array("permohonan_peneraan"),
                "uuid" => array($uuid),
                "value" => array($data),
            ];
            $log = [
                "apps" => "Schedule Apps",
                "subjek" => "Mengubah Status Permohonan Menjadi : " . $status . " - " . $uuid,
                "aktifitas" => $aktifitas,
                "device" => "web",
                "dashboard" => "1",
            ];
            CID::addToLogAktifitas($request, $log);
            // alert success
            $msg = "Berhasil Merubah Status Permohonan Menjadi: " . $status . "!";
            $response = [
                "status" => true,
                "message" => $msg,
            ];
            return response()->json($response, 200);
        } else {
            // gagal
            $msg = "Gagal Melakukan Perubahan Status Permohonan!";
            $response = [
                "status" => false,
                "message" => $msg,
            ];
            return response()->json($response, 422);
        }
    }

    /**
     * Pindah Kamar Tera / Tera Ulang
     */
    public function pindahJP(Request $request)
    {
        // auth
        $auth = Auth::user();

        // uuid
        $uuid = CID::decode($request->uuid);
        $status = CID::decode($request->status);

        // data
        $data = PermohonanPeneraan::findOrFail($uuid);

        // value
        $kode_permohonan = CID::genKodePermohonan($status);
        $value_1 = [
            "kode_permohonan" => $kode_permohonan,
            "jenis_pengujian" => $status,
            "uuid_updated" => $auth->uuid_profile,
        ];

        // save
        $save_1 = $data->update($value_1);
        if ($save_1) {
            // create log
            $aktifitas = [
                "tabel" => array("permohonan_peneraan"),
                "uuid" => array($uuid),
                "value" => array($data),
            ];
            $log = [
                "apps" => "Schedule Apps",
                "subjek" => "Mengubah Jenis Permohonan Menjadi: " . $status . " - " . $uuid,
                "aktifitas" => $aktifitas,
                "device" => "web",
                "dashboard" => "1",
            ];
            CID::addToLogAktifitas($request, $log);
            // alert success
            $msg = "Berhasil Merubah Jenis Permohonan Menjadi : " . $status . "!";
            $response = [
                "status" => true,
                "message" => $msg,
            ];
            return response()->json($response, 200);
        } else {
            // success
            $msg = "Gagal Melakukan Perubahan Status Permohonan!";
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
    public function data(Request $request, $enc_tags)
    {
        // tags
        $tags = CID::decode($enc_tags);

        // cek filter
        if ($request->session()->exists('filter_tahun')) {
            $tahun = $request->session()->get('filter_tahun');
        } else {
            $request->session()->put('filter_tahun', date('Y'));
            $tahun = date('Y');
        }

        if ($request->ajax()) {
            if (isset($_GET['filter'])) {
                $tahun = $_GET['filter']['tahun'];
                $status = $_GET['filter']['status'];
                $request->session()->put('filter_tahun', $tahun);
            } else {
                $tahun = date('Y');
                $status = "Baru";
            }

            $data = PermohonanPeneraan::join("perusahaan", "perusahaan.uuid", "=", "permohonan_peneraan.uuid_perusahaan")
                ->select("permohonan_peneraan.*")
                ->where("perusahaan.file_npwp", "!=", null)
                ->where("perusahaan.verifikasi", "=", "1")
                ->whereYear("permohonan_peneraan.tanggal_permohonan", $tahun)
                ->where("permohonan_peneraan.status", $status)
                ->where("permohonan_peneraan.jenis_pengujian", $tags)
                ->where("perusahaan.status", "=", "1")
                ->orderBy("permohonan_peneraan.created_at", "DESC")
                ->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->setRowId('uuid')
                ->addColumn('detail_permohonan', function ($data) {
                    $lokasi = $data->lokasi_peneraan;
                    $relAlamat = $data->RelAlamatPerusahaan;
                    $rt = isset($relAlamat->rt) ? "RT. " . $relAlamat->rt . ", " : "";
                    $rw = isset($relAlamat->rw) ? "RW. " . $relAlamat->rw . ", " : "";
                    $kode_pos = isset($relAlamat->kode_pos) ? ", " . $relAlamat->kode_pos . "." : ".";
                    if ($relAlamat !== null) {
                        $alamat_luar_kantor = $relAlamat->alamat . ", " . $rt . $rw . Str::title($relAlamat->Desa->name) . ", " . Str::title($relAlamat->Kecamatan->name) . ", " . Str::title($relAlamat->Kabupaten->name) . ", " . Str::title($relAlamat->Provinsi->name) . $kode_pos;
                    }

                    // detail_permohonan
                    $detail_permohonan = '
                        <p class="m-0 p-0"><strong style="display:inline-block; min-width:90px;">Kode</strong><span>: ' . $data->kode_permohonan . '</span></p>
                        <p class="m-0 p-0"><strong style="display:inline-block; min-width:90px;">Nomor Surat</strong><span>: ' . $data->nomor_surat_permohonan . '</span></p>
                        <p class="m-0 p-0"><strong style="display:inline-block; min-width:90px;">File Surat</strong><span>: <a target="_BLANK" href="' . CID::urlImg($data->file_surat_permohonan) . '" class="fw-bold"><i class="fa-solid fa-search"></i> Lihat File</a></span></p>
                        <div class="accordion accordion-icon-collapse mt-2 m-0 p-0" id="kt_accordion_permohonan_' . $data->uuid . '">
                            <div class="mb-5">
                                <div class="accordion-header d-flex collapsed" data-bs-toggle="collapse" data-bs-target="#detail_pemohon_accordion_' . $data->uuid . '">
                                    <span class="accordion-icon me-2">
                                        <i class="ki-duotone ki-plus-square fs-3 accordion-icon-off"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                                        <i class="ki-duotone ki-minus-square fs-3 accordion-icon-on"><span class="path1"></span><span class="path2"></span></i>
                                    </span>
                                    <p class="p-0 m-0 text-primary">Selengkapnya...</p>
                                </div>
                                <div id="detail_pemohon_accordion_' . $data->uuid . '" class="fs-6 pt-2 collapse mw-300px" data-bs-parent="#kt_accordion_permohonan_' . $data->uuid . '">
                                    <p class="m-0 p-0"><strong style="display:inline-block; min-width:90px;">Tgl. Usulan</strong><span>: ' . CID::TglSimple($data->tanggal_permohonan) . '</span></p>
                                ';
                    $detail_permohonan .= '
                        <p class="m-0 p-0"><strong style="display:inline-block; min-width:90px;">Tgl. Diajukan</strong><span>: ' . CID::TglSimple($data->created_at) . '</span></p>';
                    if ($data->uuid_verifikator !== null) {
                        $detail_permohonan .= '
                        <p class="m-0 p-0"><strong style="display:inline-block; min-width:90px;">Tgl. Verifikasi</strong><span>: ' . CID::TglSimple($data->tanggal_verifikasi) . '</span></p>
                        <p class="m-0 p-0"><strong style="display:inline-block; min-width:90px;">Verifikator</strong><span>: ' . $data->RelVerifikator->nama_lengkap . '</span></p>
                        ';
                    }
                    $detail_permohonan .= '
                    <p class="m-0 p-0"><strong style="display:inline-block; min-width:90px;">Lokasi</strong><span>: ' . $data->lokasi_peneraan . '</span></p>';
                    // alamat
                    if ($lokasi == "Dalam Kantor Metrologi") {
                        $detail_permohonan .= '<p class="m-0 p-0"><strong style="display:inline-block; min-width:90px;">Alamat</strong><span>: Bidang Metrologi Legal, Kec. Balaraja, Kabupaten Tangerang, Banten, 15610.</span></p>';
                    } else {
                        $detail_permohonan .= '<p class="m-0 p-0"><strong style="display:inline-block; min-width:90px;">Alamat</strong><span>: ' . $alamat_luar_kantor . '</span></p>';
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
                        $detail_permohonan .= '<p class="m-0 p-0"><strong style="display:inline-block; min-width:90px;">Maps</strong><span>: <a href="' . $url_maps . '" target="_BLANK"><i class="fa-solid fa-map-location-dot"></i> Buka Maps</a></span></p>';
                    }

                    $detail_permohonan .= '</div></div></div>';
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
                ->addColumn('tinjut', function ($data) {
                    $uuid_permohonan = $data->uuid;
                    if ($data->status == "Diproses" || $data->status == "Selesai") {
                        $dataPdp = PdpPenjadwalan::whereUuidPermohonan($uuid_permohonan)->first();
                        if ($dataPdp !== null) {
                            $tinjut = '
                                <p class="m-0 p-0"><strong style="display:inline-block; min-width:90px;">Nomor Order</strong><span>: ' . $dataPdp->nomor_order . '</span></p>
                                <p class="m-0 p-0"><strong style="display:inline-block; min-width:90px;">Tgl. Peneraan</strong><span>: ' . CID::TglSimple($dataPdp->tanggal_peneraan) . '</span></p>
                                <p class="m-0 p-0"><strong style="display:inline-block; min-width:90px;">Jam. Peneraan</strong><span>: ' . CID::jamMenit($dataPdp->tanggal_peneraan) . '</span></p>
                                <p class="m-0 p-0"><strong style="display:inline-block; min-width:90px;">Status Peneraan</strong>: <span class="badge badge-info">' . $dataPdp->status_peneraan . '</span></p>
                            ';
                        } else {
                            $tinjut = '
                                <p class="m-0 p-0"><strong style="display:inline-block; min-width:90px;">Nomor Order</strong><span>: -</span></p>
                                <p class="m-0 p-0"><strong style="display:inline-block; min-width:90px;">Tgl. Peneraan</strong><span>: -</span></p>
                                <p class="m-0 p-0"><strong style="display:inline-block; min-width:90px;">Jam. Peneraan</strong><span>: -</span></p>
                                <p class="m-0 p-0"><strong style="display:inline-block; min-width:90px;">Status Peneraan</strong><span>: -</span></p>
                            ';
                        }
                    } else {
                        $tinjut = '
                                <p class="m-0 p-0"><strong style="display:inline-block; min-width:90px;">Nomor Order</strong><span>: -</span></p>
                                <p class="m-0 p-0"><strong style="display:inline-block; min-width:90px;">Tgl. Peneraan</strong><span>: -</span></p>
                                <p class="m-0 p-0"><strong style="display:inline-block; min-width:90px;">Jam. Peneraan</strong><span>: -</span></p>
                                <p class="m-0 p-0"><strong style="display:inline-block; min-width:90px;">Status Peneraan</strong><span>: -</span></p>
                            ';
                    }
                    return $tinjut;
                })
                ->addColumn('aksi', function ($data) use ($enc_tags, $status) {
                    $tags = CID::decode($enc_tags);
                    $enc_uuid = CID::encode($data->uuid);
                    $verifikator = CID::subRoleVerifikator();
                    if ($verifikator == true) {
                        if ($status == "Baru") {
                            // status baru
                            $diproses = CID::encode("Diproses");
                            $ditolak = CID::encode("Ditolak");
                            if ($tags == "Pengujian BDKT") {
                                $aksi = '<div class="dropdown">
                                <button class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                    Aksi
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <li><a class="dropdown-item bg-hover-success" href="javascript:void(0);" data-proses="' . $enc_uuid . '" data-status="' . $diproses . '"><i class="fa-solid fa-check-to-slot"></i> Proses Permohonan</a></li>
                                    <li><a class="dropdown-item bg-hover-danger" href="javascript:void(0);" data-ditolak="' . $enc_uuid . '" data-status="' . $ditolak . '"><i class="fa-regular fa-rectangle-xmark"></i> Tolak Permohonan</a></li>
                                </ul>
                            </div>';
                            } else {
                                if ($tags == "Tera") {
                                    $jp = CID::encode("Tera Ulang");
                                    $text = "Pindahkan ke Tera Ulang";
                                } elseif ($tags == "Tera Ulang") {
                                    $jp = CID::encode("Tera");
                                    $text = "Pindahkan ke Tera";
                                }
                                $aksi = '<div class="dropdown">
                                <button class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                    Aksi
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <li><a class="dropdown-item bg-hover-success" href="javascript:void(0);" data-proses="' . $enc_uuid . '" data-status="' . $diproses . '"><i class="fa-solid fa-check-to-slot"></i> Proses Permohonan</a></li>
                                    <li><a class="dropdown-item bg-hover-danger" href="javascript:void(0);" data-ditolak="' . $enc_uuid . '" data-status="' . $ditolak . '"><i class="fa-regular fa-rectangle-xmark"></i> Tolak Permohonan</a></li>
                                    <li><a class="dropdown-item bg-hover-primary" href="javascript:void(0);" data-pindah-jp="' . $enc_uuid . '" data-status="' . $jp . '"><i class="fa-solid fa-right-left"></i> ' . $text . '</a></li>
                                </ul>
                            </div>';
                            }
                        } elseif ($status == "Diproses") {
                            // status Diproses
                            $selesai = CID::encode("Selesai");
                            $reset = CID::encode("Baru");
                            $aksi = '<div class="dropdown">
                            <button class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                Aksi
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <li><a class="dropdown-item bg-hover-success" href="javascript:void(0);" data-selesai="' . $enc_uuid . '" data-status="' . $selesai . '"><i class="fa-solid fa-check-double"></i> Permohonan Selesai</a></li>
                                <li><a class="dropdown-item bg-hover-danger" href="javascript:void(0);" data-reset="' . $enc_uuid . '" data-status="' . $reset . '"><i class="fa-solid fa-rotate-left"></i> Reset Permohonan</a></li>
                            </ul>
                        </div>';
                            // <li><a class="dropdown-item bg-hover-warning" href="' . $tl . '"><i class="fa-solid fa-elevator"></i> Penjadwalan & Penugasan</a></li>
                        } elseif ($status == "Selesai") {
                            // status Selesai
                            $diproses = CID::encode("Diproses");
                            $reset = CID::encode("Baru");
                            $aksi = '<div class="dropdown">
                            <button class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                Aksi
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <li><a class="dropdown-item bg-hover-success" href="javascript:void(0);" data-reproses="' . $enc_uuid . '" data-status="' . $diproses . '"><i class="fa-solid fa-check-to-slot"></i> Proses Kembali Permohonan</a></li>
                            </ul>
                        </div>';
                        } elseif ($status == "Ditolak") {
                            // status Ditolak
                            $reset = CID::encode("Baru");
                            $aksi = '<div class="dropdown">
                            <button class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                Aksi
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <li><a class="dropdown-item bg-hover-danger" href="javascript:void(0);" data-reset="' . $enc_uuid . '" data-status="' . $reset . '"><i class="fa-solid fa-rotate-left"></i> Reset Permohonan</a></li>
                            </ul>
                        </div>';
                        }
                    } else {
                        $aksi = '
                            <button class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm dropdown-toggle disabled" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                Aksi
                            </button>';
                    }
                    return $aksi;
                })
                ->escapeColumns([''])
                ->make(true);
        }
    }
}
