<?php

namespace App\Http\Controllers\ApiBase\ApiAdmin\ScheduleApps\penera;

use App\Helpers\CID;
use App\Http\Controllers\Controller;
use App\Models\MasterInstrumenDaftarItemUttp;
use App\Models\PdpAlat;
use App\Models\PdpInstrumen;
use App\Models\PdpPenjadwalan;
use App\Models\PdpRetribusi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ApiScdInstrumenAlatController extends Controller
{
    //index
    public function index($tahun, $status, $tags)
    {
        // auth
        $auth = auth()->user();

        // base data
        $dataArray = [];
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

        // foreach
        foreach ($data as $item) {
            $data->RelPermohonanPeneraan = $item->RelPermohonanPeneraan;
            $data->RelPerusahaan = $item->RelPermohonanPeneraan->RelPerusahaan;
            $data->RelAlamatPerusahaan = $item->RelPermohonanPeneraan->RelAlamatPerusahaan;
            $data->RelVerifikator = $item->RelPermohonanPeneraan->RelVerifikator;
            $data->RelMasterKelompokUttp = $item->RelMasterKelompokUttp;
            $data->RelDiproses = $item->RelDiproses;
            $data->RelDitunda = $item->RelDitunda;
            $data->RelDibatalkan = $item->RelDibatalkan;
            $data->RelSelesai = $item->RelSelesai;
            $data->RelTenagaAhliPenera = $item->RelGetPetugasTAP;
            $data->RelPendampingTeknis = $item->RelGetPetugasPT;
            $data->RelPdpInstrumenOrder = $item->RelPdpInstrumenOrder;
            $data->RelPdpAlatOrder = $item->RelPdpAlatOrder;
            $dataArray[] = $item;
        }

        // response
        $response = [
            "status" => true,
            "data" => $dataArray,
        ];
        return response()->json($response, 200);
    }

    /*
    | show
     */
    // show
    public function show($uuid)
    {
        // auth
        $auth = auth()->user();

        // base data
        $data = PdpPenjadwalan::where("pdp_penjadwalan.uuid", $uuid)
            ->select("pdp_penjadwalan.*")
            ->with("RelPermohonanPeneraan")
            ->with("RelPermohonanPeneraan.RelPerusahaan")
            ->with("RelPermohonanPeneraan.RelAlamatPerusahaan")
            ->with("RelPermohonanPeneraan.RelVerifikator")
            ->with("RelMasterKelompokUttp")
            ->with("RelDiproses")
            ->with("RelDitunda")
            ->with("RelDibatalkan")
            ->with("RelSelesai")
            ->with("RelGetPetugasTAP")
            ->with("RelGetPetugasPT")
            ->with("RelPdpInstrumenOrder")
            ->with("RelPdpAlatOrder")
            ->with("RelPdpRetribusi");

        // hak akses
        $subRoleOnlyPetugas = CID::subRoleOnlyPetugas();
        if ($subRoleOnlyPetugas == true) {
            // hanya petugas
            $uuid_profile = $auth->uuid_profile;
            $data = $data->join("pdp_data_petugas", "pdp_data_petugas.uuid_penjadwalan", "=", "pdp_penjadwalan.uuid")
                ->where("pdp_data_petugas.uuid_pegawai", $uuid_profile)->firstOrFail();
        } else {
            $data = $data->firstOrFail();
        }

        // response
        $response = [
            "status" => true,
            "data" => $data,
        ];
        return response()->json($response, 200);
    }

    /**
     * Update
     */
    public function update(Request $request, $uuid)
    {
        // auth
        $auth = auth()->user();

        // cek uuid
        $data = PdpPenjadwalan::findOrFail($uuid);

        // cek path form
        $path_form = $request->path_form;
        if ($path_form == "penjadwalan") {
            return $this->pathPenjadwalan($data, $auth, $request);
        } elseif ($path_form == "instrumen") {
            return $this->pathInstrumen($data, $auth, $request);
        } elseif ($path_form == "alat") {
            return $this->pathAlat($data, $auth, $request);
        } elseif ($path_form == "delete-instrumen") {
            return $this->pathDestroyInstrumen($data, $auth, $request);
        } elseif ($path_form == "delete-alat") {
            return $this->pathDestroyAlat($data, $auth, $request);
        }
    }

    // pathPenjadwalan
    private function pathPenjadwalan($data, $auth, $request)
    {
        // profile petugas
        $uuid_profile = $auth->uuid_profile;

        // validate
        $validator = Validator::make($request->all(), [
            "tanggal_peneraan" => "required|string",
            "jam_peneraan" => "required|string",
            "nama_supir" => "sometimes|nullable|string|max:100",
            "jenis_kendaraan" => "sometimes|nullable|string|max:10",
            "plat_nomor_kendaraan" => "sometimes|nullable|string|max:10",
        ]);

        // response validasi
        $response = [
            "status" => false,
            "message" => "Validation Error!!",
            "errors" => $validator->errors(),
            "request" => $request->all(),
        ];
        if ($validator->fails()) {
            return response()->json($response, 422);
        }

        // value 1 - penjadwalan
        $uuid_penjadwalan = $data->uuid;
        $tanggal_peneraan = date('Y-m-d', strtotime($request->tanggal_peneraan));
        $jam_peneraan = date('H:i', strtotime($request->jam_peneraan));
        $nomor_order = $data->nomor_order;

        // array value 1
        $value_1 = [
            "tanggal_peneraan" => $tanggal_peneraan,
            "jam_peneraan" => $jam_peneraan,
            "nama_supir" => isset($request->nama_supir) ? $request->nama_supir : null,
            "jenis_kendaraan" => isset($request->jenis_kendaraan) ? $request->jenis_kendaraan : null,
            "plat_nomor_kendaraan" => isset($request->plat_nomor_kendaraan) ? Str::upper($request->plat_nomor_kendaraan) : null,
            "uuid_updated" => $uuid_profile,
        ];

        // save
        $save_1 = $data->update($value_1);
        if ($save_1) {
            // create log
            $aktifitas = [
                "tabel" => array("pdp_penjadwalan"),
                "uuid" => array($uuid_penjadwalan),
                "value" => array($value_1),
            ];
            $log = [
                "apps" => "Schedule Apps",
                "subjek" => "Mengubah Data Instrumen & Alat: " . $nomor_order,
                "aktifitas" => $aktifitas,
                "role" => $auth->role,
                "device" => "web",
                "dashboard" => "0",
            ];
            CID::addToLogAktifitas($request, $log);
            // alert success
            $response = [
                "status" => true,
                "message" => "Berhasil Mengubah Instrumen & Alat pada Step 1: " . $nomor_order,
            ];
            return response()->json($response, 200);
        } else {
            $response = [
                "status" => false,
                "message" => "Berhasil Mengubah Instrumen & Alat pada Step 1: " . $nomor_order,
                "request" => $request->all(),
            ];
            return response()->json($response, 422);
        }
    }
    // pathInstrumen
    private function pathInstrumen($data, $auth, $request)
    {
        // base data
        $uuid_penjadwalan = $data->uuid;
        $nomor_order = $data->nomor_order;
        $jp = $data->RelPermohonanPeneraan->jenis_pengujian;

        // validate
        $validator = Validator::make($request->all(), [
            "uuid_instrumen" => "required",
            "jumlah_unit" => "required",
            "volume_instrumen" => "required",
        ]);

        // response validasi
        $response = [
            "status" => false,
            "message" => "Validation Error!!",
            "errors" => $validator->errors(),
            "request" => $request->all(),
        ];
        if ($validator->fails()) {
            return response()->json($response, 422);
        }

        // cek update atau create
        if ($request->has('uuid_edit_instrumen')) {
            // update
            $uuid_pdp_instrumen = $request->uuid_edit_instrumen;
            $pdpInstrumen = PdpInstrumen::findOrFail($uuid_pdp_instrumen);

            // value
            $uuid_instrumen = $request->uuid_instrumen;
            $get_instrumen = MasterInstrumenDaftarItemUttp::findOrFail($uuid_instrumen);
            $jumlah_unit = $request->jumlah_unit;
            $volume = $request->volume_instrumen;
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

            // update pdpInstrumen
            $pdpInstrumen->uuid_instrumen = $uuid_instrumen;
            $pdpInstrumen->tipe_tera = $tipe_tera;
            if ($flagjumlahunit != 0) {
                $pdpInstrumen->jumlah_unit = 0;
            } else {
                $pdpInstrumen->jumlah_unit = $jumlah_unit;
            }
            $pdpInstrumen->volume = $sisa_volume;
            $pdpInstrumen->retribusi_tera = $ret_tera;
            $pdpInstrumen->retribusi_justir = $ret_justir;
            $pdpInstrumen->nilai_retribusi = $nilai_ret;
            $pdpInstrumen->uuid_updated = $auth->uuid_profile;
            $pdpInstrumen->save();
        } else {
            // create
            $uuid_instrumen = $request->uuid_instrumen;
            $get_instrumen = MasterInstrumenDaftarItemUttp::findOrFail($uuid_instrumen);
            $jumlah_unit = $request->jumlah_unit;
            $volume = $request->volume_instrumen;
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
            $save_instrumen->no_urut = CID::getNoUrutInstrumen($uuid_penjadwalan);
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
        }

        // create retribusi
        $retribusi = PdpRetribusi::where("uuid_penjadwalan", $uuid_penjadwalan)->first();
        if ($retribusi === null) {
            // create
            $save_retribusi = new PdpRetribusi;
            $save_retribusi->uuid = Str::uuid();
            $save_retribusi->uuid_penjadwalan = $uuid_penjadwalan;
            $save_retribusi->total_retribusi = CID::getTotalRetribusi($uuid_penjadwalan);
            $save_retribusi->uuid_created = $auth->uuid_profile;
            $save_1 = $save_retribusi->save();
        } else {
            // update
            $retribusi->total_retribusi = CID::getTotalRetribusi($uuid_penjadwalan);
            $retribusi->uuid_updated = $auth->uuid_profile;
            $save_1 = $retribusi->save();
        }

        // save
        if ($save_1) {
            // alert success
            $response = [
                "status" => true,
                "message" => "Berhasil Mengubah Instrumen & Alat pada Step 2: " . $nomor_order,
            ];
            return response()->json($response, 200);
        } else {
            $response = [
                "status" => false,
                "message" => "Berhasil Mengubah Instrumen & Alat pada Step 2: " . $nomor_order,
                "request" => $request->all(),
            ];
            return response()->json($response, 422);
        }
    }
    // pathAlat
    private function pathAlat($data, $auth, $request)
    {
        // base data
        $uuid_penjadwalan = $data->uuid;
        $nomor_order = $data->nomor_order;
        $jp = $data->RelPermohonanPeneraan->jenis_pengujian;

        // validate
        $validator = Validator::make($request->all(), [
            "uuid_alat" => "required|string",
            "jumlah_unit_alat" => "required",
        ]);

        // response validasi
        $response = [
            "status" => false,
            "message" => "Validation Error!!",
            "errors" => $validator->errors(),
            "request" => $request->all(),
        ];
        if ($validator->fails()) {
            return response()->json($response, 422);
        }

        // cek update atau create
        if ($request->has('uuid_edit_alat')) {
            // cek data alat
            $uuid_pdp_alat = $request->uuid_edit_alat;
            $pdpAlat = PdpAlat::findOrFail($uuid_pdp_alat);
            // create
            $pdpAlat->uuid_alat = $request->uuid_alat;
            $pdpAlat->jumlah_unit = $request->jumlah_unit_alat;
            $pdpAlat->uuid_updated = $auth->uuid_profile;
            $save_1 = $pdpAlat->save();
        } else {
            // create
            $save_alat = new PdpAlat;
            $save_alat->uuid = Str::uuid();
            $save_alat->uuid_penjadwalan = $uuid_penjadwalan;
            $save_alat->uuid_alat = $request->uuid_alat;
            $save_alat->no_urut = CID::getNoUrutAlat($uuid_penjadwalan);
            $save_alat->jumlah_unit = $request->jumlah_unit_alat;
            $save_alat->uuid_created = $auth->uuid_profile;
            $save_1 = $save_alat->save();
        }

        if ($save_1) {
            // alert success
            $response = [
                "status" => true,
                "message" => "Berhasil Mengubah Instrumen & Alat pada Step 3: " . $nomor_order,
            ];
            return response()->json($response, 200);
        } else {
            $response = [
                "status" => false,
                "message" => "Berhasil Mengubah Instrumen & Alat pada Step 3: " . $nomor_order,
                "request" => $request->all(),
            ];
            return response()->json($response, 422);
        }
    }
    // pathDestroyInstrumen
    private function pathDestroyInstrumen($data, $auth, $request)
    {
        // base data
        $uuid_penjadwalan = $data->uuid;
        $nomor_order = $data->nomor_order;
        $jp = $data->RelPermohonanPeneraan->jenis_pengujian;

        // validate
        $validator = Validator::make($request->all(), [
            "uuid_edit_instrumen" => "required|string",
        ]);

        // response validasi
        $response = [
            "status" => false,
            "message" => "Validation Error!!",
            "errors" => $validator->errors(),
            "request" => $request->all(),
        ];
        if ($validator->fails()) {
            return response()->json($response, 422);
        }

        $uuid_pdp_instrumen = $request->uuid_edit_instrumen;
        $pdpInstrumen = PdpInstrumen::findOrFail($uuid_pdp_instrumen);

        $save_1 = $pdpInstrumen->forceDelete();
        if ($save_1) {
            // create retribusi
            $retribusi = PdpRetribusi::where("uuid_penjadwalan", $uuid_penjadwalan)->first();
            if ($retribusi === null) {
                // create
                $save_retribusi = new PdpRetribusi;
                $save_retribusi->uuid = Str::uuid();
                $save_retribusi->uuid_penjadwalan = $uuid_penjadwalan;
                $save_retribusi->total_retribusi = CID::getTotalRetribusi($uuid_penjadwalan);
                $save_retribusi->uuid_created = $auth->uuid_profile;
                $save_1 = $save_retribusi->save();
            } else {
                // update
                $retribusi->total_retribusi = CID::getTotalRetribusi($uuid_penjadwalan);
                $retribusi->uuid_updated = $auth->uuid_profile;
                $save_1 = $retribusi->save();
            }
            // alert success
            $response = [
                "status" => true,
                "message" => "Berhasil Menghapus Instrumen & Alat pada Step 2: " . $nomor_order,
            ];
            return response()->json($response, 200);
        } else {
            $response = [
                "status" => false,
                "message" => "Berhasil Menghapus Instrumen & Alat pada Step 2: " . $nomor_order,
                "request" => $request->all(),
            ];
            return response()->json($response, 422);
        }
    }
    // pathDestroyAlat
    private function pathDestroyAlat($data, $auth, $request)
    {
        // base data
        $uuid_penjadwalan = $data->uuid;
        $nomor_order = $data->nomor_order;
        $jp = $data->RelPermohonanPeneraan->jenis_pengujian;

        // validate
        $validator = Validator::make($request->all(), [
            "uuid_edit_alat" => "required|string",
        ]);

        // response validasi
        $response = [
            "status" => false,
            "message" => "Validation Error!!",
            "errors" => $validator->errors(),
            "request" => $request->all(),
        ];
        if ($validator->fails()) {
            return response()->json($response, 422);
        }

        $uuid_pdp_instrumen = $request->uuid_edit_alat;
        $pdpAlat = PdpAlat::findOrFail($uuid_pdp_instrumen);

        $save_1 = $pdpAlat->forceDelete();
        if ($save_1) {
            // alert success
            $response = [
                "status" => true,
                "message" => "Berhasil Menghapus Instrumen & Alat pada Step 2: " . $nomor_order,
            ];
            return response()->json($response, 200);
        } else {
            $response = [
                "status" => false,
                "message" => "Berhasil Menghapus Instrumen & Alat pada Step 2: " . $nomor_order,
                "request" => $request->all(),
            ];
            return response()->json($response, 422);
        }
    }
}
