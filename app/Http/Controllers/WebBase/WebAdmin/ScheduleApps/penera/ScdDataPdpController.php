<?php

namespace App\Http\Controllers\WebBase\WebAdmin\ScheduleApps\penera;

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

class ScdDataPdpController extends Controller
{
    // index
    public function index(Request $request)
    {
        // cek filter
        if ($request->session()->exists('filter_tahun') && $request->session()->exists('filter_status') && $request->session()->exists('filter_tags')) {
            $tahun = $request->session()->get('filter_tahun');
            $status = $request->session()->get('filter_status');
            $tags = $request->session()->get('filter_tags');
        } else {
            $request->session()->put('filter_tahun', date('Y'));
            $request->session()->put('filter_status', 'Menunggu');
            $request->session()->put('filter_tags', 'Tera');
            $tahun = date('Y');
            $status = "Menunggu";
            $tags = "Tera";
        }

        // cek data permohonan
        $tahunPermohonan = PermohonanPeneraan::select(DB::raw("YEAR(created_at) year"))
            ->groupBy("year")
            ->orderBy("year", "DESC")
            ->get();
        return view('pages.admin.schedule_apps.jadwal_penugasan.index', compact(
            'tahun',
            'status',
            'tahunPermohonan',
        ));
    }

    /*
    | show
     */
    // show
    public function show($enc_uuid)
    {
        // uuid
        $uuid = CID::decode($enc_uuid);

        // data
        $data = PdpPenjadwalan::findOrFail($uuid);
        $uuid_permohonan = $data->uuid_permohonan;
        $permohonan = PermohonanPeneraan::findOrFail($uuid_permohonan);
        $profile = $permohonan->RelPerusahaan;
        $RelAlamat = $permohonan->RelAlamatPerusahaan;
        $jp = $permohonan->jenis_pengujian;

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
        $title = "Lihat Jadwal dan Penugasan";
        $submit = "Simpan";
        return view('pages.admin.schedule_apps.jadwal_penugasan.view_pdp', compact(
            'enc_uuid',
            'data',
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

    /*
    | edit
     */
    // edit
    public function edit($enc_uuid)
    {
        // subSubRoleKetuaTimPelayanan
        $subSubRoleKetuaTimPelayanan = CID::subSubRoleKetuaTimPelayanan();
        if ($subSubRoleKetuaTimPelayanan == false) {
            return redirect()->route('scd.apps.data.pdp.index');
        }

        // uuid
        $uuid = CID::decode($enc_uuid);

        // data
        $data = PdpPenjadwalan::findOrFail($uuid);
        $uuid_permohonan = $data->uuid_permohonan;
        $permohonan = PermohonanPeneraan::findOrFail($uuid_permohonan);
        $profile = $permohonan->RelPerusahaan;
        $RelAlamat = $permohonan->RelAlamatPerusahaan;
        $jp = $permohonan->jenis_pengujian;

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
        $title = "Edit Jadwal dan Penugasan";
        $submit = "Simpan";
        return view('pages.admin.schedule_apps.jadwal_penugasan.edit_pdp', compact(
            'enc_uuid',
            'data',
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

    // update
    public function update(Request $request, $enc_uuid)
    {
        // subSubRoleKetuaTimPelayanan
        $subSubRoleKetuaTimPelayanan = CID::subSubRoleKetuaTimPelayanan();
        if ($subSubRoleKetuaTimPelayanan == false) {
            return redirect()->route('scd.apps.data.pdp.index');
        }

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
        $data = PdpPenjadwalan::findOrFail($uuid);
        $uuid_permohonan = $data->uuid_permohonan;
        $uuid_kelompok_uttp = $request->kelompok_uttp;
        $permohonan = PermohonanPeneraan::findOrFail($uuid_permohonan);
        $mstKelompokUttp = MasterKelompokUttp::findOrFail($uuid_kelompok_uttp);
        $kode_uttp = $mstKelompokUttp->kode;

        // cek nomor order
        if ($uuid_kelompok_uttp != $data->uuid_kelompok_uttp) {
            $nomor_order = CID::genNomorOrder($kode_uttp);
        } else {
            $nomor_order = $data->nomor_order;
        }

        // value 1 - penjadwalan
        $uuid_penjadwalan = $uuid;
        $tanggal_peneraan = date('Y-m-d', strtotime($request->tanggal_peneraan));
        $jam_peneraan = date('H:i', strtotime($request->jam_peneraan));
        $cekJamPeneraan = date('Hi', strtotime($request->jam_peneraan));

        // cek jadwal
        $dataPetugas = [];
        $PdpJadwal = PdpPenjadwalan::where("uuid", "!=", $uuid_penjadwalan)->whereDate("tanggal_peneraan", $tanggal_peneraan)->get();
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
            "uuid_kelompok_uttp" => $request->kelompok_uttp,
            "nomor_order" => $nomor_order,
            "tanggal_peneraan" => $tanggal_peneraan,
            "jam_peneraan" => $jam_peneraan,
            "status_peneraan" => "Menunggu",
            "uuid_created" => $uuid_profile,
        ];

        // delete data penugasan
        PdpDataPetugas::where("uuid_penjadwalan", $uuid_penjadwalan)->forceDelete();
        // save
        $save_1 = $data->update($value_1);
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
                "subjek" => "Mengubah Penjadwalan & Penugasan: " . $nomor_order . " - " . $uuid_penjadwalan,
                "aktifitas" => $aktifitas,
                "device" => "web",
                "dashboard" => "0",
            ];
            CID::addToLogAktifitas($request, $log);
            // alert success
            alert()->success('Berhasil!', "Berhasil Mengubah Penjadwalan & Penugasan: " . $nomor_order);
            return redirect()->route('scd.apps.data.pdp.index');
        } else {
            alert()->error('Gagal!', "Gagal Mengubah Penjadwalan & Penugasan: " . $nomor_order);
            return back()->withInput($request->all());
        }
    }

    /**
     * Data untuk Datatables
     */
    public function data(Request $request)
    {
        if ($request->ajax()) {
            if (isset($_GET['filter'])) {
                $tahun = $_GET['filter']['tahun'];
                $status = $_GET['filter']['status'];
                $tags = $_GET['filter']['tags'];
                $request->session()->put('filter_tahun', $tahun);
                $request->session()->put('filter_status', $status);
                $request->session()->put('filter_tags', $tags);
            } else {
                $tahun = date('Y');
                $status = "Menunggu";
                $tags = "Tera";
            }

            $data = PdpPenjadwalan::join("permohonan_peneraan", "permohonan_peneraan.uuid", "=", "pdp_penjadwalan.uuid_permohonan")
                ->select("pdp_penjadwalan.*")
                ->whereYear("pdp_penjadwalan.tanggal_peneraan", $tahun)
                ->where("pdp_penjadwalan.status_peneraan", $status)
                ->where("permohonan_peneraan.jenis_pengujian", $tags)
                ->orderBy("pdp_penjadwalan.tanggal_peneraan", "ASC")
                ->orderBy("pdp_penjadwalan.jam_peneraan", "ASC")
                ->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->setRowId('uuid')
                ->addColumn('detail_permohonan', function ($data) {
                    $relPermohonan = $data->RelPermohonanPeneraan;
                    $relPerusahaan = $data->RelPermohonanPeneraan->RelPerusahaan;
                    $detail_permohonan = '
                    <p class="m-0 p-0"><strong style="display:inline-block; min-width:90px;">Kode Permohonan</strong><span>: ' . $relPermohonan->kode_permohonan . '</span></p>
                    <p class="m-0 p-0"><strong style="display:inline-block; min-width:90px;">Perusahaan/UTTP</strong><span>: ' . $relPerusahaan->nama_perusahaan . '</span></p>
                    <p class="m-0 p-0"><strong style="display:inline-block; min-width:90px;">Jenis</strong><span>: ' . $relPerusahaan->jenis_perusahaan . '</span></p>
                    <p class="m-0 p-0"><strong style="display:inline-block; min-width:90px;">No. Telp 1</strong><span>: ' . $relPerusahaan->no_telp_1 . '</span></p>
                    <hr />
                    <p class="m-0 p-0"><strong style="display:inline-block; min-width:90px;">Nomor Order</strong><span>: ' . $data->nomor_order . '</span></p>
                    <p class="m-0 p-0"><strong style="display:inline-block; min-width:90px;">Tgl. Peneraan</strong><span>: ' . CID::tglBlnThn($data->tanggal_peneraan) . '</span></p>
                    <p class="m-0 p-0"><strong style="display:inline-block; min-width:90px;">Jam Peneraan</strong><span>: ' . CID::jamMenit($data->jam_peneraan) . '</span></p>
                    <p class="m-0 p-0"><strong style="display:inline-block; min-width:90px;">Status Peneraan</strong>: <span class="badge badge-info">' . $data->status_peneraan . '</span></p>
                ';
                    return $detail_permohonan;
                })
                ->addColumn('detail_pdp', function ($data) {
                    $getPetugasTAP = CID::getPetugasTAP($data->uuid);
                    $getPetugasPT = \CID::getPetugasPT($data->uuid);
                    $detail_pdp = '
                    <p class="m-0 p-0"><strong style="display:inline-block; min-width:90px;">Tenaga Ahli Penera</strong><span>:</span></p>
                    <ul>
                ';
                    foreach ($getPetugasTAP as $itemTAP) {
                        $detail_pdp .= '<li>' . $itemTAP->RelPegawai->nama_lengkap . '</li>';
                    }
                    $detail_pdp .= '
                    </ul>
                    <p class="m-0 p-0"><strong style="display:inline-block; min-width:90px;">Pendamping Teknis</strong><span>:</span></p>
                    <ul>
                ';
                    foreach ($getPetugasPT as $itemPT) {
                        $detail_pdp .= '<li>' . $itemPT->RelPegawai->nama_lengkap . '</li>';
                    }
                    $detail_pdp .= '</ul>';
                    return $detail_pdp;
                })
                ->addColumn('aksi', function ($data) use ($status) {
                    $enc_uuid = CID::encode($data->uuid);
                    // route
                    $edit = route('scd.apps.data.pdp.edit', $enc_uuid);
                    $view = route('scd.apps.data.pdp.show', $enc_uuid);
                    // hak akses
                    $subSubRoleKetuaTimPelayanan = CID::subSubRoleKetuaTimPelayanan();
                    if ($subSubRoleKetuaTimPelayanan == true) {
                        // Admin Aplikasi
                        if ($status == "Menunggu") {
                            // status Menunggu
                            $aksi = '<div class="dropdown">
                            <button class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                Aksi
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <li><a class="dropdown-item" href="' . $edit . '"><i class="fa-solid fa-edit"></i> Edit Data</a></li>
                            </ul>
                        </div>';
                        } else {
                            // view only
                            $aksi = '<div class="dropdown">
                            <button class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                Aksi
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <li><a class="dropdown-item" href="' . $view . '"><i class="fa-solid fa-eye"></i> Lihat Data</a></li>
                            </ul>
                        </div>';
                        }
                    } else {
                        // view only
                        $aksi = '<div class="dropdown">
                        <button class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                            Aksi
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                            <li><a class="dropdown-item" href="' . $view . '"><i class="fa-solid fa-eye"></i> Lihat Data</a></li>
                        </ul>
                    </div>';
                    }
                    return $aksi;
                })
                ->escapeColumns([''])
                ->make(true);
        }
    }
}
