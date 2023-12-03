<?php

namespace App\Http\Controllers\WebBase\WebAdmin\ScheduleApps\penera;

use App\Helpers\CID;
use App\Http\Controllers\Controller;
use App\Models\MasterInstrumenDaftarItemUttp;
use App\Models\PdpAlat;
use App\Models\PdpInstrumen;
use App\Models\PdpPenjadwalan;
use App\Models\PdpRetribusi;
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

        // title
        $title = "Lihat Instrumen dan Alat";
        $submit = "Simpan";
        return view('pages.admin.schedule_apps.instrumen_alat.view_pdp', compact(
            'enc_uuid',
            'data',
            'permohonan',
            'profile',
            'RelAlamat',
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

        // validate
        $request->validate([
            "tanggal_peneraan" => "required|string",
            "jam_peneraan" => "required|string",
            "nama_supir" => "required|string|max:100",
            "jenis_kendaraan" => "required|string|max:10",
            "repeat_instrumen" => "sometimes|nullable",
            "repeat_alat" => "sometimes|nullable",
        ]);

        // data
        $data = PdpPenjadwalan::findOrFail($uuid);

        // value 1 - penjadwalan
        $uuid_penjadwalan = $uuid;
        $tanggal_peneraan = date('Y-m-d', strtotime($request->tanggal_peneraan));
        $jam_peneraan = date('H:i', strtotime($request->jam_peneraan));
        $nomor_order = $data->nomor_order;

        // array value 1
        $value_1 = [
            "tanggal_peneraan" => $tanggal_peneraan,
            "jam_peneraan" => $jam_peneraan,
            "nama_supir" => $request->nama_supir,
            "jenis_kendaraan" => $request->jenis_kendaraan,
            "plat_nomor_kendaraan" => Str::upper($request->plat_nomor_kendaraan),
            "uuid_updated" => $uuid_profile,
        ];

        // save
        $save_1 = $data->update($value_1);
        if ($save_1) {
            // save instrumen & retribusi
            $this->saveInstrumen($request, $auth, $data);
            // save alat
            $this->saveAlat($request, $auth, $data);
            // create log
            $aktifitas = [
                "tabel" => array("pdp_penjadwalan"),
                "uuid" => array($uuid),
                "value" => array($value_1),
            ];
            $log = [
                "apps" => "Schedule Apps",
                "subjek" => "Mengubah Data Instrumen & Alat: " . $nomor_order,
                "aktifitas" => $aktifitas,
                "device" => "web",
                "dashboard" => "0",
            ];
            CID::addToLogAktifitas($request, $log);
            // alert success
            alert()->success('Berhasil!', "Berhasil Mengubah Instrumen & Alat: " . $nomor_order);
            return redirect()->route('scd.apps.insalat.index');
        } else {
            alert()->error('Gagal!', "Gagal Mengubah Instrumen & Alat: " . $nomor_order);
            return back()->withInput($request->all());
        }
    }

    /**
     * PRIVATE FUNCTION
     */
    // instrumen
    private function saveInstrumen($request, $auth, $data)
    {
        // base data
        $uuid_penjadwalan = $data->uuid;
        $jp = $data->RelPermohonanPeneraan->jenis_pengujian;
        $no_urut = 1;

        // delete all instrumen
        PdpInstrumen::where("uuid_penjadwalan", $uuid_penjadwalan)->forceDelete();
        PdpRetribusi::where("uuid_penjadwalan", $uuid_penjadwalan)->forceDelete();

        // value baru data instrumen
        $total_retribusi = 0;
        if ($request->has('repeat_instrumen')) {
            $repeat_instrumen = $request->repeat_instrumen;
            $crepeat_instrumen = count($repeat_instrumen);
            for ($i = 0; $i < $crepeat_instrumen; $i++) {
                $uuid_instrumen = $repeat_instrumen[$i]['uuid_instrumen'];
                $get_instrumen = MasterInstrumenDaftarItemUttp::findOrFail($uuid_instrumen);
                $jumlah_unit = $repeat_instrumen[$i]['jumlah_unit_instrumen'];
                $volume = $repeat_instrumen[$i]['volume_instrumen'];
                $sisa_volume = $volume;
                $flagjumlahunit = 0;
                $harga = 0;
                $hargajustir = 0;
                // tipe_tera
                if ($jp == "Tera") {
                    $tipe_tera = "baru";
                    $harga = $get_instrumen->tera_baru_pengujian;
                    if ($get_instrumen->nama_instrumen == "POMPA UKUR BBM") {
                        // kalo pompa ukur bbm tetep kasih justir walaupun tera baru
                        $hargajustir = $get_instrumen->tera_ulang_pejustiran;
                    }
                } elseif ($jp == "Tera Ulang") {
                    $tipe_tera = "ulang";
                    $harga = $get_instrumen->tera_ulang_pengujian;
                    $hargajustir = $get_instrumen->tera_ulang_pejustiran;
                } elseif ($jp == "Pengujian BDKT") {
                    $tipe_tera = "tarif-per-jam";
                    $harga = $get_instrumen->tarif_per_jam;
                }

                // instrumen dengan perhitungan perhitungan sequence
                $ar_seq = [
                    "LEBIH DARI 3000KG",
                ];
                if (in_array($get_instrumen->nama_instrumen, $ar_seq)) {
                    // jika uttp yg di pilih punya perhitungan sequence..
                    $ret_tera = $harga * ($sisa_volume / $get_instrumen->volume_per) * $jumlah_unit;
                    $ret_justir = $hargajustir * ($sisa_volume / $get_instrumen->volume_per) * $jumlah_unit;
                    $nilai_ret = $ret_tera + $ret_justir;
                } else {
                    // jika uttp yg di pilih, tidak punya perhitungan sequence..
                    $ret_tera = $harga * $jumlah_unit;
                    $ret_justir = $hargajustir * $jumlah_unit;
                    $nilai_ret = $ret_tera + $ret_justir;
                }

                // create save_instrumen
                $save_instrumen = new PdpInstrumen;
                $save_instrumen->uuid = Str::uuid();
                $save_instrumen->uuid_penjadwalan = $uuid_penjadwalan;
                $save_instrumen->uuid_instrumen = $uuid_instrumen;
                $save_instrumen->no_urut = $no_urut;
                $save_instrumen->tipe_tera = $tipe_tera;
                if ($flagjumlahunit != 0) {
                    $save_instrumen->jumlah_unit = 0;
                } else {
                    $save_instrumen->jumlah_unit = $jumlah_unit;
                }
                $save_instrumen->volume = $sisa_volume;
                $save_instrumen->retribusi_tera = $ret_tera;
                $save_instrumen->retribusi_justir = $ret_justir;
                $save_instrumen->nilai_retribusi = $nilai_ret;
                $save_instrumen->uuid_created = $auth->uuid_profile;
                $save_instrumen->save();

                // total_retribusi
                $total_retribusi += $nilai_ret;
                $no_urut++;
            }
        }

        // value edit data instrumen
        if ($request->has('uuid_pdp_instrumen')) {
            $cPdpInstrumen = count($request->uuid_pdp_instrumen);
            for ($i = 0; $i < $cPdpInstrumen; $i++) {
                $uuid_instrumen = $request->uuid_instrumen[$i];
                $get_instrumen = MasterInstrumenDaftarItemUttp::findOrFail($uuid_instrumen);
                $jumlah_unit = $request->jumlah_unit_instrumen[$i];
                $volume = $request->volume_instrumen[$i];
                $sisa_volume = $volume;
                $flagjumlahunit = 0;
                $harga = 0;
                $hargajustir = 0;
                // tipe_tera
                if ($jp == "Tera") {
                    $tipe_tera = "baru";
                    $harga = $get_instrumen->tera_baru_pengujian;
                    if ($get_instrumen->nama_instrumen == "POMPA UKUR BBM") {
                        // kalo pompa ukur bbm tetep kasih justir walaupun tera baru
                        $hargajustir = $get_instrumen->tera_ulang_pejustiran;
                    }
                } elseif ($jp == "Tera Ulang") {
                    $tipe_tera = "ulang";
                    $harga = $get_instrumen->tera_ulang_pengujian;
                    $hargajustir = $get_instrumen->tera_ulang_pejustiran;
                } elseif ($jp == "Pengujian BDKT") {
                    $tipe_tera = "tarif-per-jam";
                    $harga = $get_instrumen->tarif_per_jam;
                }

                // instrumen dengan perhitungan perhitungan sequence
                $ar_seq = [
                    "LEBIH DARI 3000KG",
                ];
                if (in_array($get_instrumen->nama_instrumen, $ar_seq)) {
                    // jika uttp yg di pilih punya perhitungan sequence..
                    $ret_tera = $harga * ($sisa_volume / $get_instrumen->volume_per) * $jumlah_unit;
                    $ret_justir = $hargajustir * ($sisa_volume / $get_instrumen->volume_per) * $jumlah_unit;
                    $nilai_ret = $ret_tera + $ret_justir;
                } else {
                    // jika uttp yg di pilih, tidak punya perhitungan sequence..
                    $ret_tera = $harga * $jumlah_unit;
                    $ret_justir = $hargajustir * $jumlah_unit;
                    $nilai_ret = $ret_tera + $ret_justir;
                }

                // create save_instrumen
                $save_instrumen = new PdpInstrumen;
                $save_instrumen->uuid = Str::uuid();
                $save_instrumen->uuid_penjadwalan = $uuid_penjadwalan;
                $save_instrumen->uuid_instrumen = $uuid_instrumen;
                $save_instrumen->no_urut = $no_urut;
                $save_instrumen->tipe_tera = $tipe_tera;
                if ($flagjumlahunit != 0) {
                    $save_instrumen->jumlah_unit = 0;
                } else {
                    $save_instrumen->jumlah_unit = $jumlah_unit;
                }
                $save_instrumen->volume = $sisa_volume;
                $save_instrumen->retribusi_tera = $ret_tera;
                $save_instrumen->retribusi_justir = $ret_justir;
                $save_instrumen->nilai_retribusi = $nilai_ret;
                $save_instrumen->uuid_created = $auth->uuid_profile;
                $save_instrumen->save();

                // total_retribusi
                $total_retribusi += $nilai_ret;
                $no_urut++;
            }
        }

        // create retribusi
        if ($request->has('repeat_instrumen') || $request->has('uuid_pdp_instrumen')) {
            $retribusi = PdpRetribusi::where("uuid_penjadwalan", $uuid_penjadwalan)->first();
            if ($retribusi === null) {
                // create
                $save_retribusi = new PdpRetribusi;
                $save_retribusi->uuid = Str::uuid();
                $save_retribusi->uuid_penjadwalan = $uuid_penjadwalan;
                $save_retribusi->total_retribusi = $total_retribusi;
                $save_retribusi->uuid_created = $auth->uuid_profile;
                $save_retribusi->save();
            } else {
                // update
                $retribusi->total_retribusi = $total_retribusi;
                $retribusi->save();
            }
        }
    }
    // alat
    private function saveAlat($request, $auth, $data)
    {
        // base data
        $uuid_penjadwalan = $data->uuid;
        $no_urut = 1;

        // delete all alat
        PdpAlat::where("uuid_penjadwalan", $uuid_penjadwalan)->forceDelete();

        // value baru data alat
        if ($request->has('repeat_alat')) {
            $repeat_alat = $request->repeat_alat;
            $crepeat_alat = count($repeat_alat);
            for ($i = 0; $i < $crepeat_alat; $i++) {
                // create
                $save_alat = new PdpAlat;
                $save_alat->uuid = Str::uuid();
                $save_alat->uuid_penjadwalan = $uuid_penjadwalan;
                $save_alat->uuid_alat = $repeat_alat[$i]['uuid_alat'];
                $save_alat->no_urut = $no_urut;
                $save_alat->jumlah_unit = $repeat_alat[$i]['jumlah_unit_alat'];
                $save_alat->uuid_created = $auth->uuid_profile;
                $save_alat->save();
                $no_urut++;
            }
        }

        // value edit data alat
        if ($request->has('uuid_pdp_alat')) {
            $cPdpAlat = count($request->uuid_pdp_alat);
            for ($i = 0; $i < $cPdpAlat; $i++) {
                $uuid_alat = $request->uuid_alat[$i];
                $jumlah_unit = $request->jumlah_unit_alat[$i];
                // create
                $save_alat = new PdpAlat;
                $save_alat->uuid = Str::uuid();
                $save_alat->uuid_penjadwalan = $uuid_penjadwalan;
                $save_alat->uuid_alat = $uuid_alat;
                $save_alat->no_urut = $no_urut;
                $save_alat->jumlah_unit = $jumlah_unit;
                $save_alat->uuid_created = $auth->uuid_profile;
                $save_alat->save();
                $no_urut++;
            }
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
                    $getPetugasPT = CID::getPetugasPT($data->uuid);
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
                    $getInstrumen = $data->RelPdpInstrumenOrder;
                    $getAlat = $data->RelPdpAlatOrder;
                    $detail_insalat = '
                    <p class="m-0 p-0"><strong>List Instrumen</strong><span>:</span></p>
                    <ul>
                ';
                    foreach ($getInstrumen as $itemInstrumen) {
                        $detail_insalat .= '<li>' . $itemInstrumen->RelMasterInstrumenDaftarItemUttp->nama_instrumen . '</li>';
                    }
                    $detail_insalat .= '
                    </ul>
                    <p class="m-0 p-0"><strong>List Alat</strong><span>:</span></p>
                    <ul>
                ';
                    foreach ($getAlat as $itemAlat) {
                        $detail_insalat .= '<li>' . $itemAlat->RelMasterKategoriKelompok->nama_kategori . '</li>';
                    }
                    $detail_insalat .= '</ul>';
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
                        $link_item = '';
                        if ($data->status_peneraan == "Diproses" || $data->status_peneraan == "Ditunda") {
                            $link_item = '<li><a class="dropdown-item" href="' . $edit . '"><i class="fa-solid fa-pencil"></i> Edit Data</a></li>';
                        }
                        $aksi = '<div class="dropdown">
                            <button class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                Aksi
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                ' . $link_item . '
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