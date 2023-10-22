<?php

namespace App\Http\Controllers\WebBase\WebAdmin\ScheduleApps\permohonan;

use App\Helpers\CID;
use App\Http\Controllers\Controller;
use App\Models\MasterKelompokUttp;
use App\Models\PdpDataPetugas;
use App\Models\PdpPenjadwalan;
use App\Models\Pegawai;
use App\Models\PermohonanPeneraan;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ScdInputDataPdpController extends Controller
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
    public function create($enc_uuid)
    {
        $uuid = CID::decode($enc_uuid);

        // data
        $permohonan = PermohonanPeneraan::findOrFail($uuid);
        $profile = $permohonan->RelPerusahaan;
        $RelAlamat = $permohonan->RelAlamatPerusahaan;
        $jp = $permohonan->jenis_pengujian;

        // cek penjadwalan
        $cekPenjadwalan = PdpPenjadwalan::where("uuid_permohonan", $uuid)->first();
        if ($cekPenjadwalan !== null) {
            return redirect()->route('scd.apps.input.pdp.index');
        }

        // kelompok uttp
        $kelompokUttp = MasterKelompokUttp::join("master_jenis_pelayanan", "master_jenis_pelayanan.uuid", "=", "master_kelompok_uttp.uuid_jenis_pelayanan")
            ->select("master_kelompok_uttp.*")
            ->where("master_jenis_pelayanan.nama_pelayanan", $jp)
            ->where("master_jenis_pelayanan.status", "1")
            ->where("master_kelompok_uttp.status", "1")
            ->orderBy("master_kelompok_uttp.no_urut", "ASC")
            ->get();

        // List TA
        $listTa = Pegawai::join("users", "users.uuid_profile", "=", "pegawai.uuid")
            ->select("pegawai.*")
            ->where("users.role", "Pegawai")
            ->where("users.sub_role", 'LIKE', '%Petugas%')
            ->where("users.status", "1")
            ->where("pegawai.status_pegawai", "ASN")
            ->orderBy("pegawai.nama_lengkap", "ASC")
            ->get();

        // List Pendamping Teknis
        $listPendamping = Pegawai::join("users", "users.uuid_profile", "=", "pegawai.uuid")
            ->select("pegawai.*")
            ->where("users.role", "Pegawai")
            ->where("users.sub_role", 'LIKE', '%Petugas%')
            ->where("users.status", "1")
            ->where("pegawai.status_pegawai", "Non ASN")
            ->orderBy("pegawai.nama_lengkap", "ASC")
            ->get();

        // title
        $title = "Input Data";
        $submit = "Simpan";
        return view('pages.admin.schedule_apps.pdp.create_edit', compact(
            'enc_uuid',
            'permohonan',
            'profile',
            'RelAlamat',
            'kelompokUttp',
            'listTa',
            'listPendamping',
            'title',
            'submit',
        ));
    }

    // store
    public function store(Request $request, $enc_uuid)
    {
        // uuid
        $uuid = CID::decode($enc_uuid);

        // auth
        $auth = Auth::user();
        $uuid_profile = $auth->uuid_profile;

        // validate
        $request->validate([
            "kelompok_uttp" => "required|string|max:100",
            "tanggal_peneraan" => "required|string",
            "jam_peneraan" => "required|string",
            "tenaga_ahli_penera" => "required",
            "pendamping_teknis" => "required",
        ]);

        // data
        $uuid_kelompok_uttp = $request->kelompok_uttp;
        $permohonan = PermohonanPeneraan::findOrFail($uuid);
        $mstKelompokUttp = MasterKelompokUttp::findOrFail($uuid_kelompok_uttp);
        $kode_uttp = $mstKelompokUttp->kode;

        // value 1 - penjadwalan
        $uuid_permohonan = $uuid;
        $uuid_penjadwalan = Str::uuid();
        $nomor_order = CID::genNomorOrder($kode_uttp);
        $tanggal_peneraan = date('Y-m-d', strtotime($request->tanggal_peneraan));
        $jam_peneraan = date('H:i', strtotime($request->jam_peneraan));
        $cekJamPeneraan = date('Hi', strtotime($request->jam_peneraan));

        // cek tanggal
        $tglTera = date('YmdHi', strtotime($request->tanggal_peneraan . " " . $request->jam_peneraan));
        $tglSekarang = date('YmdHi');
        if ($tglTera < $tglSekarang) {
            alert()->error('Gagal!', "Pilih Tanggal Hari Ini atau Setelah Hari Ini!");
            return back()->withInput($request->all());
        }

        // cek jadwal
        $dataPetugas = [];
        $PdpJadwal = PdpPenjadwalan::whereDate("tanggal_peneraan", $tanggal_peneraan)->get();
        foreach ($PdpJadwal as $item1) {
            $baseJamPeneraan = date('Hi', strtotime($item1->jam_peneraan));
            $jamAwalReal = date('Hi', strtotime($baseJamPeneraan));
            $next2JamReal = date('Hi', strtotime($jamAwalReal . " + 2hour "));
            // cek range jam peneraan yg diinput
            if ($cekJamPeneraan >= $jamAwalReal && $cekJamPeneraan <= $next2JamReal) {
                // petugas
                $relDataPetugas = $item1->RelPdpDataPetugas;
                foreach ($relDataPetugas as $item2) {
                    $dataPetugas[] = $item2->uuid_pegawai;
                }
            }
        }

        // cek jadwal - tenaga ahli penera
        $ta = $request->tenaga_ahli_penera;
        $cta = count($ta);
        for ($i = 0; $i < $cta; $i++) {
            $uuid_cek_ta = $ta[$i];
            if (in_array($uuid_cek_ta, $dataPetugas)) {
                // pegawai sudah ada jadwal dalam 2 jam aktif
                $pegawai = Pegawai::findOrFail($uuid_cek_ta);
                alert()->error('Gagal!', $pegawai->nama_lengkap . " Sudah Memiliki Jadwal di Hari Yang Sama dan dalam Rentang Masa Jam Tugas, Cek Jadwal Petugas!");
                return back()->withInput($request->all());
            }
        }

        // cek jadwal - pendamping teknis
        $teknis = $request->pendamping_teknis;
        $cteknis = count($teknis);
        for ($i = 0; $i < $cteknis; $i++) {
            $uuid_cek_teknis = $teknis[$i];
            if (in_array($uuid_cek_teknis, $dataPetugas)) {
                // pegawai sudah ada jadwal dalam 2 jam aktif
                $pegawai = Pegawai::findOrFail($uuid_cek_teknis);
                alert()->error('Gagal!', $pegawai->nama_lengkap . " Sudah Memiliki Jadwal di Hari Yang Sama dan dalam Rentang Masa Jam Tugas, Cek Jadwal Petugas!");
                return back()->withInput($request->all());
            }
        }

        // array value 1
        $value_1 = [
            "uuid" => $uuid_penjadwalan,
            "uuid_permohonan" => $uuid_permohonan,
            "uuid_kelompok_uutp" => $request->kelompok_uttp,
            "nomor_order" => $nomor_order,
            "tanggal_peneraan" => $tanggal_peneraan,
            "jam_peneraan" => $jam_peneraan,
            "status_peneraan" => "Menunggu",
            "uuid_created" => $uuid_profile,
        ];

        // save
        $save_1 = PdpPenjadwalan::create($value_1);
        if ($save_1) {
            // value 2 - tenaga ahli penera
            $ta = $request->tenaga_ahli_penera;
            $cta = count($ta);
            for ($i = 0; $i < $cta; $i++) {
                $value_2 = [
                    "uuid" => Str::uuid(),
                    "uuid_penjadwalan" => $uuid_penjadwalan,
                    "uuid_pegawai" => $ta[$i],
                    "jabatan_petugas" => "Tenaga Ahli Penera",
                    "uuid_created" => $uuid_profile,
                ];
                PdpDataPetugas::create($value_2);
            }

            // value 3 - pendamping teknis
            $teknis = $request->pendamping_teknis;
            $cteknis = count($teknis);
            for ($i = 0; $i < $cteknis; $i++) {
                $value_3 = [
                    "uuid" => Str::uuid(),
                    "uuid_penjadwalan" => $uuid_penjadwalan,
                    "uuid_pegawai" => $teknis[$i],
                    "jabatan_petugas" => "Pendamping Teknis",
                    "uuid_created" => $uuid_profile,
                ];
                PdpDataPetugas::create($value_3);
            }

            // create log
            $aktifitas = [
                "tabel" => array("pdp_penjadwalan"),
                "uuid" => array($uuid),
                "value" => array($value_1),
            ];
            $log = [
                "apps" => "Schedule Apps",
                "subjek" => "Menambahkan Penjadwalan & Penugasan: " . $nomor_order . " - " . $uuid_penjadwalan,
                "aktifitas" => $aktifitas,
                "device" => "web",
                "dashboard" => "0",
            ];
            CID::addToLogAktifitas($request, $log);
            // alert success
            alert()->success('Berhasil!', "Berhasil Menambahkan Penjadwalan & Penugasan: " . $nomor_order);
            return redirect()->route('scd.apps.input.pdp.index');
        } else {
            alert()->error('Gagal!', "Gagal Menambahkan Penjadwalan & Penugasan: " . $nomor_order);
            return back()->withInput($request->all());
        }
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

        $data = [];
        $PermohonanPeneraan = PermohonanPeneraan::join("perusahaan", "perusahaan.uuid", "=", "permohonan_peneraan.uuid_perusahaan")
            ->select("permohonan_peneraan.*")
            ->where("perusahaan.file_npwp", "!=", null)
            ->where("perusahaan.verifikasi", "=", "1")
            ->whereYear("permohonan_peneraan.tanggal_permohonan", $tahun)
            ->where("permohonan_peneraan.status", "Diproses")
            ->where("permohonan_peneraan.jenis_pengujian", $tags)
            ->where("perusahaan.status", "=", "1")
            ->orderBy("permohonan_peneraan.created_at", "DESC")
            ->get();
        foreach ($PermohonanPeneraan as $item) {
            $uuid_permohonan = $item->uuid;
            $pdp = PdpPenjadwalan::whereUuidPermohonan($uuid_permohonan)->first();
            if ($pdp === null) {
                $data[] = $item;
            }
        }

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
            ->addColumn('aksi', function ($data) {
                $enc_uuid = CID::encode($data->uuid);
                $inputData = route('scd.apps.input.pdp.create', [$enc_uuid]);
                $aksi = '<a href="' . $inputData . '" class="btn btn-info btn-icon" data-bs-toggle="tooltip" title="Input Data Penugasan & Penjadwalan"><i class="fa-solid fa-keyboard fs-2"></i></a>';

                return $aksi;
            })
            ->escapeColumns([''])
            ->make(true);
        // }
    }
}
