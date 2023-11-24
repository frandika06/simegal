<?php

namespace App\Http\Controllers\WebBase\WebAdmin\ScheduleApps\penera;

use App\Helpers\CID;
use App\Http\Controllers\Controller;
use App\Models\MasterKelompokUttp;
use App\Models\PdpAlat;
use App\Models\PdpDataPetugas;
use App\Models\PdpInstrumen;
use App\Models\PdpPenjadwalan;
use App\Models\Pegawai;
use App\Models\PermohonanPeneraan;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ScdInstrumenAlatController extends Controller
{
    // index
    public function index(Request $request)
    {
        // cek filter
        if ($request->session()->exists('filter_tahun') && $request->session()->exists('filter_status_insalat') && $request->session()->exists('filter_tags')) {
            $tahun = $request->session()->get('filter_tahun');
            $status = $request->session()->get('filter_status_insalat');
            $tags = $request->session()->get('filter_tags');
        } else {
            $request->session()->put('filter_tahun', date('Y'));
            $request->session()->put('filter_status_insalat', 'All');
            $request->session()->put('filter_tags', 'Tera');
            $tahun = date('Y');
            $status = "All";
            $tags = "Tera";
        }

        // cek data permohonan
        $tahunPermohonan = PermohonanPeneraan::select(DB::raw("YEAR(created_at) year"))
            ->groupBy("year")
            ->orderBy("year", "DESC")
            ->get();
        return view('pages.admin.schedule_apps.instrumen_alat.index', compact(
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
        $title = "Lihat Instrumen dan Alat";
        $submit = "Simpan";
        return view('pages.admin.schedule_apps.instrumen_alat.view_pdp', compact(
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
        // uuid
        $uuid = CID::decode($enc_uuid);

        // data
        $data = PdpPenjadwalan::findOrFail($uuid);
        $uuid_permohonan = $data->uuid_permohonan;
        $permohonan = PermohonanPeneraan::findOrFail($uuid_permohonan);
        $profile = $permohonan->RelPerusahaan;
        $RelAlamat = $permohonan->RelAlamatPerusahaan;
        $jp = $permohonan->jenis_pengujian;

        // title
        $title = "Edit Instrumen dan Alat";
        $submit = "Simpan";
        return view('pages.admin.schedule_apps.instrumen_alat.edit_pdp', compact(
            'enc_uuid',
            'data',
            'permohonan',
            'profile',
            'RelAlamat',
            'title',
            'submit',
        ));
    }

    // update
    public function update(Request $request, $enc_uuid)
    {
        // uuid
        $uuid = CID::decode($enc_uuid);

        // auth
        $auth = Auth::user();
        $uuid_profile = $auth->uuid_profile;

        // return dd($request->all());

        // validate
        $request->validate([
            "tanggal_peneraan" => "required|string",
            "jam_peneraan" => "required|string",
            "nama_supir" => "required|string|max:100",
            "jenis_kendaraan" => "required|string|max:10",
            "repeat_instrumen" => "required",
            "repeat_alat" => "required",
        ]);

        // data
        $data = PdpPenjadwalan::findOrFail($uuid);
        $getDataPetugas = $data->RelPdpDataPetugas;

        // value 1 - penjadwalan
        $uuid_penjadwalan = $uuid;
        $tanggal_peneraan = date('Y-m-d', strtotime($request->tanggal_peneraan));
        $jam_peneraan = date('H:i', strtotime($request->jam_peneraan));
        $cekJamPeneraan = date('Hi', strtotime($request->jam_peneraan));

        // cek jadwal
        // $dataPetugas = [];
        // $PdpJadwal = PdpPenjadwalan::where("uuid", "!=", $uuid_penjadwalan)->whereDate("tanggal_peneraan", $tanggal_peneraan)->get();
        // foreach ($PdpJadwal as $item1) {
        //     $baseJamPeneraan = date('Hi', strtotime($item1->jam_peneraan));
        //     $jamAwalReal = date('Hi', strtotime($baseJamPeneraan));
        //     $next2JamReal = date('Hi', strtotime($jamAwalReal . " + 2hour "));
        //     // cek range jam peneraan yg diinput
        //     if ($cekJamPeneraan >= $jamAwalReal && $cekJamPeneraan <= $next2JamReal) {
        //         // petugas
        //         $relDataPetugas = $item1->RelPdpDataPetugas;
        //         foreach ($relDataPetugas as $item2) {
        //             $dataPetugas[] = $item2->uuid_pegawai;
        //         }
        //     }
        // }

        // cek jadwal petugas
        // foreach ($getDataPetugas as $itemJadwal) {
        //     $uuid_cek_petugas = $itemJadwal->uuid_pegawai;
        //     if (in_array($uuid_cek_petugas, $dataPetugas)) {
        //         // pegawai sudah ada jadwal dalam 2 jam aktif
        //         $pegawai = Pegawai::findOrFail($uuid_cek_petugas);
        //         alert()->error('Gagal!', $pegawai->nama_lengkap . " Sudah Memiliki Jadwal di Hari Yang Sama dan dalam Rentang Masa Jam Tugas, Cek Jadwal Petugas!");
        //         return back()->withInput($request->all());
        //     }
        // }

        // array value 1
        $value_1 = [
            "tanggal_peneraan" => $tanggal_peneraan,
            "jam_peneraan" => $jam_peneraan,
            "nama_supir" => $request->nama_supir,
            "jenis_kendaraan" => $request->jenis_kendaraan,
            "plat_nomor_kendaraan" => $request->plat_nomor_kendaraan,
            "uuid_updated" => $uuid_profile,
        ];

        // delete Instrumen & Alat
        PdpInstrumen::where("uuid_penjadwalan", $uuid_penjadwalan)->forceDelete();
        PdpAlat::where("uuid_penjadwalan", $uuid_penjadwalan)->forceDelete();

        return dd($request->repeat_instrumen[0]['uuid_instrumen']);

        // store instrumen pengujian data
        $total_retribusi = 0;
        for ($i = 0; $i < count($request->ip_id); $i++) {
            $get_instrumen = InstrumenPengujian::findOrFail($request->ip_id[$i]);
            $volume = $request->ip_volume[$i];

            $sisa_volume = $volume;
            $flagjumlahunit = 0;
            if (!is_null($get_instrumen->seq_id)) {
                $flagjumlahunit++;
                $get_seq = InstrumenPengujian::findOrFail($get_instrumen->seq_id);

                if ($volume > $get_seq->volume_to) {
                    $sisa_volume = $volume - $get_seq->volume_to;

                    $harga = 0;
                    $hargajustir = 0;
                    if ($request->ip_tipe_tera[$i] == 'baru') {
                        $harga = $get_seq->tera_baru_pengujian;
                    } else if ($request->ip_tipe_tera[$i] == 'ulang') {
                        $harga = $get_seq->tera_ulang_pengujian;
                        $hargajustir = $get_seq->tera_ulang_pejustiran;
                    } else if ($request->ip_tipe_tera[$i] == 'tarif-per-jam') {
                        $harga = $get_seq->tarif_per_jam;
                    }

                    $ret_tera = $harga * $request->ip_jumlah[$i];
                    $ret_justir = $hargajustir * $request->ip_jumlah[$i];
                    $nilai_ret = $ret_tera + $ret_justir;

                    $save_instrumen = new TindakLanjutInstrumen;
                    $save_instrumen->id_tindak_lanjut = $tindak_lanjut->id;
                    $save_instrumen->id_instrumen = $get_instrumen->seq_id;
                    $save_instrumen->tipe_tera = $request->ip_tipe_tera[$i];
                    $save_instrumen->jumlah_unit = $request->ip_jumlah[$i];
                    $save_instrumen->volume = $get_seq->volume_to;
                    $save_instrumen->retribusi_tera = $ret_tera;
                    $save_instrumen->retribusi_justir = $ret_justir;
                    $save_instrumen->nilai_retribusi = $nilai_ret;
                    $save_instrumen->save();

                    $total_retribusi += $nilai_ret;
                }
            }

            $harga = 0;
            $hargajustir = 0;
            if ($request->ip_tipe_tera[$i] == 'baru') {
                $harga = $get_instrumen->tera_baru_pengujian;
                if ($get_instrumen->id == 90) {
                    // kalo pompa ukur bbm tetep kasih justir walaupun tera baru
                    $hargajustir = $get_instrumen->tera_ulang_pejustiran;
                }
            } else if ($request->ip_tipe_tera[$i] == 'ulang') {
                $harga = $get_instrumen->tera_ulang_pengujian;
                $hargajustir = $get_instrumen->tera_ulang_pejustiran;
            } else if ($request->ip_tipe_tera[$i] == 'tarif-per-jam') {
                $harga = $get_instrumen->tarif_per_jam;
            }

            if (!is_null($get_instrumen->seq_id)) {
                // jika uttp yg di pilih punya perhitungan sequence..
                $ret_tera = $harga * ($sisa_volume / $get_instrumen->volume_per) * $request->ip_jumlah[$i];
                $ret_justir = $hargajustir * ($sisa_volume / $get_instrumen->volume_per) * $request->ip_jumlah[$i];
                $nilai_ret = $ret_tera + $ret_justir;
            } else {
                // jika uttp yg di pilih, tidak punya perhitungan sequence..
                $ret_tera = $harga * $request->ip_jumlah[$i];
                $ret_justir = $hargajustir * $request->ip_jumlah[$i];
                $nilai_ret = $ret_tera + $ret_justir;
            }

            $save_instrumen = new TindakLanjutInstrumen;
            $save_instrumen->id_tindak_lanjut = $tindak_lanjut->id;
            $save_instrumen->id_instrumen = $request->ip_id[$i];
            $save_instrumen->tipe_tera = $request->ip_tipe_tera[$i];

            if ($flagjumlahunit != 0) {
                $save_instrumen->jumlah_unit = 0;
            } else {
                $save_instrumen->jumlah_unit = $request->ip_jumlah[$i];
            }

            $save_instrumen->volume = $sisa_volume;
            $save_instrumen->retribusi_tera = $ret_tera;
            $save_instrumen->retribusi_justir = $ret_justir;
            $save_instrumen->nilai_retribusi = $nilai_ret;
            $save_instrumen->save();

            $total_retribusi += $nilai_ret;
        }

        // value 2 - tenaga ahli penera
        $repeat_instrumen = $request->repeat_instrumen;
        $crepeat_instrumen = count($repeat_instrumen);
        for ($i = 0; $i < $crepeat_instrumen; $i++) {
            $value_2 = [
                "uuid" => Str::uuid(),
                "uuid_penjadwalan" => $uuid_penjadwalan,
                "uuid_instrumen" => $repeat_instrumen[$i]['uuid_instrumen'],
                "tipe_tera",
                "jumlah_unit" => $repeat_instrumen[$i]['uuid_instrumen'],
                "volume" => $repeat_instrumen[$i]['uuid_instrumen'],
                "retribusi_tera",
                "retribusi_justir",
                "nilai_retribusi",
                "uuid_created" => $uuid_profile,
            ];
            PdpInstrumen::create($value_2);
        }

        return dd($request->all());

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
            return redirect()->route('scd.apps.insalat.index');
        } else {
            alert()->error('Gagal!', "Gagal Mengubah Penjadwalan & Penugasan: " . $nomor_order);
            return back()->withInput($request->all());
        }
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
        $data = PdpPenjadwalan::findOrFail($uuid);

        // value
        $value_1 = [
            "status_peneraan" => $status,
            "uuid_updated" => $auth->uuid_profile,
        ];

        if ($status == "Diproses") {
            $value_1['uuid_diproses'] = $auth->uuid_profile;
        } elseif ($status == "Ditunda") {
            $value_1['uuid_ditunda'] = $auth->uuid_profile;
        } elseif ($status == "Dibatalkan") {
            $value_1['uuid_dibatalkan'] = $auth->uuid_profile;
            // ubah status permohonan jadi ditolak
            $uuid_permohonan = $data->uuid_permohonan;
            // value permohonan
            $value_2 = [
                "status" => "Ditolak",
                "uuid_updated" => $auth->uuid_profile,
            ];
            PermohonanPeneraan::whereUuid($uuid_permohonan)->update($value_2);
        } elseif ($status == "Selesai") {
            $value_1['uuid_selesai'] = $auth->uuid_profile;
        }

        // save
        $save_1 = $data->update($value_1);
        if ($save_1) {
            // create log
            $aktifitas = [
                "tabel" => array("pdp_penjadwalan"),
                "uuid" => array($uuid),
                "value" => array($data),
            ];
            $log = [
                "apps" => "Schedule Apps",
                "subjek" => "Mengubah Status Jadawal & Penugasan Menjadi : " . $status . " - " . $uuid,
                "aktifitas" => $aktifitas,
                "device" => "web",
                "dashboard" => "1",
            ];
            CID::addToLogAktifitas($request, $log);
            // alert success
            $msg = "Berhasil Merubah Status Jadawal & Penugasan Menjadi: " . $status . "!";
            $response = [
                "status" => true,
                "message" => $msg,
            ];
            return response()->json($response, 200);
        } else {
            // gagal
            $msg = "Gagal Melakukan Perubahan Status Jadawal & Penugasan!";
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
                $status = $_GET['filter']['status'];
                $tags = $_GET['filter']['tags'];
                $request->session()->put('filter_tahun', $tahun);
                $request->session()->put('filter_status_insalat', $status);
                $request->session()->put('filter_tags', $tags);
            } else {
                $tahun = date('Y');
                $status = "All";
                $tags = "Tera";
            }

            // base data
            $data = PdpPenjadwalan::join("permohonan_peneraan", "permohonan_peneraan.uuid", "=", "pdp_penjadwalan.uuid_permohonan")
                ->select("pdp_penjadwalan.*")
                ->whereYear("pdp_penjadwalan.tanggal_peneraan", $tahun)
                ->where("permohonan_peneraan.jenis_pengujian", $tags)
                ->orderBy("pdp_penjadwalan.tanggal_peneraan", "ASC")
                ->orderBy("pdp_penjadwalan.jam_peneraan", "ASC");

            // Semua Data
            if ($status == "All") {
                $data = $data->where("pdp_penjadwalan.status_peneraan", "!=", "Menunggu");
            } else {
                $data = $data->where("pdp_penjadwalan.status_peneraan", $status);
            }

            // hak akses
            $subRoleOnlyPetugas = CID::subRoleOnlyPetugas();
            if ($subRoleOnlyPetugas == true) {
                // hanya petugas
                $uuid_profile = $auth->uuid_profile;
                $data = $data->join("pdp_data_petugas", "pdp_data_petugas.uuid_penjadwalan", "=", "pdp_penjadwalan.uuid")
                    ->where("pdp_data_petugas.uuid_pegawai", $uuid_profile)->get();
            } else {
                $data = $data->get();
            }

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
                ->addColumn('detail_insalat', function ($data) {
                    $detail_insalat = '';
                    return $detail_insalat;
                })
                ->addColumn('aksi', function ($data) use ($status) {
                    $enc_uuid = CID::encode($data->uuid);
                    $aksi = '';
                    // route
                    $edit = route('scd.apps.insalat.edit', $enc_uuid);
                    $view = route('scd.apps.insalat.show', $enc_uuid);
                    // hak akses
                    $subRoleOnlyPetugas = CID::subRoleOnlyPetugas();
                    if ($subRoleOnlyPetugas == true) {
                        $aksi = '<div class="dropdown">
                            <button class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                Aksi
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <li><a class="dropdown-item" href="' . $edit . '"><i class="fa-solid fa-pencil"></i> Edit Data</a></li>
                                <li><a class="dropdown-item" href="' . $view . '"><i class="fa-solid fa-eye"></i> Lihat Data</a></li>
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
                    return $aksi;
                })
                ->escapeColumns([''])
                ->make(true);
        }
    }
}
