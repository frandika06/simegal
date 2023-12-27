<?php

namespace App\Http\Controllers\WebBase\WebAdmin\PdpApps\permohonan;

use App\Helpers\CID;
use App\Http\Controllers\Controller;
use App\Models\AlamatPerusahaan;
use App\Models\PermohonanPeneraan;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PDPPermohonanPeneraanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // auth
        $auth = Auth::user();
        $profile = $auth->RelPerusahaan;

        // cek filter
        if ($request->session()->exists('filter_tahun')) {
            $tahun = $request->session()->get('filter_tahun');
            $status = $request->session()->get('filter_status');
        } else {
            $request->session()->put('filter_tahun', date('Y'));
            $request->session()->put('filter_status', "Baru");
            $tahun = date('Y');
            $status = "Baru";
        }

        // cek data permohonan
        $tahunPermohonan = PermohonanPeneraan::select(DB::raw("YEAR(created_at) year"))
            ->groupBy("year")
            ->orderBy("year", "DESC")
            ->get();

        return view('pages.admin.pdp_apps.permohonan.index', compact(
            'profile',
            'tahun',
            'status',
            'tahunPermohonan'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // auth
        $auth = Auth::user();
        $profile = $auth->RelPerusahaan;

        // get data alamat
        $alamatPerusahaan = AlamatPerusahaan::whereUuidPerusahaan($profile->uuid)
            ->orderBy("created_at", "ASC")
            ->get();

        // title & button
        $title = "Tambah Data";
        $submit = "Simpan";
        return view('pages.admin.pdp_apps.permohonan.create_edit', compact(
            'title',
            'submit',
            'profile',
            'alamatPerusahaan'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // auth
        $auth = Auth::user();
        $profile = $auth->RelPerusahaan;
        $uuid_profile = $auth->uuid_profile;
        $uuid_perusahaan = $profile->uuid;

        // validate
        $request->validate([
            "jenis_pengujian" => "required|string|max:100",
            "nomor_surat_permohonan" => "required|string|max:100",
            "file_surat_permohonan" => "required|file|mimes:png,jpg,jpeg,pdf|max:5000",
            "tanggal_permohonan" => "required|string|max:10",
            "lokasi_peneraan" => "required|string|max:100",
            "uuid_alamat" => "sometimes|nullable|string|max:100",
        ]);

        // value
        $jp = $request->jenis_pengujian;
        $lokasi_peneraan = $request->lokasi_peneraan;
        $kode_permohonan = CID::genKodePermohonan($jp);

        if ($lokasi_peneraan == "Luar Kantor Metrologi") {
            $uuid_alamat = $request->uuid_alamat;
        } else {
            $uuid_alamat = null;
        }
        $uuid = Str::uuid();
        $value_1 = [
            "uuid" => $uuid,
            "uuid_perusahaan" => $uuid_perusahaan,
            "kode_permohonan" => $kode_permohonan,
            "jenis_pengujian" => $jp,
            "nomor_surat_permohonan" => $request->nomor_surat_permohonan,
            "tanggal_permohonan" => date('Y-m-d', strtotime($request->tanggal_permohonan)),
            "lokasi_peneraan" => $lokasi_peneraan,
            "uuid_alamat" => $uuid_alamat,
            "status" => "Baru",
            "uuid_created" => $uuid_profile,
        ];

        // file_surat_permohonan
        $path = "permohonan/" . date('Y') . "/" . $kode_permohonan;
        if ($request->hasFile('file_surat_permohonan')) {
            $file_surat_permohonan = CID::UpImgPdf($request, "file_surat_permohonan", $path);
            if ($file_surat_permohonan == "0") {
                alert()->error('Error!', 'Gagal Menyimpan Data, File Surat Permohonan Tidak Sesuai Format!');
                return \back();
            }
            $value_1['file_surat_permohonan'] = $file_surat_permohonan['url'];
        }

        // save
        $save_1 = PermohonanPeneraan::create($value_1);
        if ($save_1) {
            // create log
            $aktifitas = [
                "tabel" => array("permohonan_peneraan"),
                "uuid" => array($uuid),
                "value" => array($value_1),
            ];
            $log = [
                "apps" => "Penjadwalan dan Penugasan Apps",
                "subjek" => "Berhasil Mengajukan Permohonan Pengujian (" . $kode_permohonan . ") - " . $uuid,
                "aktifitas" => $aktifitas,
                "device" => "web",
                "dashboard" => "1",
            ];
            CID::addToLogAktifitas($request, $log);
            // alert success
            alert()->success('Berhasil!', 'Berhasil Mengajukan Permohonan Pengujian.');
            return redirect()->route('pdp.apps.reqpeneraan.index');
        } else {
            alert()->error('Gagal!', 'Gagal Mengajukan Permohonan Pengujian.');
            return back()->withInput($request->all());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($uuid_enc)
    {
        // auth
        $auth = Auth::user();
        $profile = $auth->RelPerusahaan;
        $uuid_profile = $auth->uuid_profile;
        $uuid_perusahaan = $profile->uuid;

        // uuid
        $uuid = CID::decode($uuid_enc);
        $data = PermohonanPeneraan::where("uuid_perusahaan", $uuid_perusahaan)
            ->where("uuid", $uuid)
            ->firstOrFail();
        $pdpPenjadwalan = $data->RelPdpPenjadwalan;

        // get data alamat
        $alamatPerusahaan = AlamatPerusahaan::whereUuidPerusahaan($profile->uuid)
            ->orderBy("created_at", "ASC")
            ->get();

        // title & button
        $title = "Detail Permohonan";
        return view('pages.admin.pdp_apps.permohonan.show', compact(
            'uuid_enc',
            'title',
            'profile',
            'pdpPenjadwalan',
            'alamatPerusahaan',
            'data'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($uuid_enc)
    {
        // auth
        $auth = Auth::user();
        $profile = $auth->RelPerusahaan;
        $uuid_profile = $auth->uuid_profile;
        $uuid_perusahaan = $profile->uuid;

        // uuid
        $uuid = CID::decode($uuid_enc);
        $data = PermohonanPeneraan::where("uuid_perusahaan", $uuid_perusahaan)
            ->where("uuid", $uuid)
            ->firstOrFail();

        // get data alamat
        $alamatPerusahaan = AlamatPerusahaan::whereUuidPerusahaan($profile->uuid)
            ->orderBy("created_at", "ASC")
            ->get();

        // title & button
        $title = "Edit Data";
        $submit = "Ubah";
        return view('pages.admin.pdp_apps.permohonan.create_edit', compact(
            'uuid_enc',
            'title',
            'submit',
            'profile',
            'alamatPerusahaan',
            'data'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $uuid_enc)
    {
        // auth
        $auth = Auth::user();
        $profile = $auth->RelPerusahaan;
        $uuid_profile = $auth->uuid_profile;
        $uuid_perusahaan = $profile->uuid;

        // validate
        $request->validate([
            "nomor_surat_permohonan" => "required|string|max:100",
            "file_surat_permohonan" => "sometimes|nullable|file|mimes:png,jpg,jpeg,pdf|max:5000",
            "tanggal_permohonan" => "required|string|max:10",
            "lokasi_peneraan" => "required|string|max:100",
            "uuid_alamat" => "sometimes|nullable|string|max:100",
        ]);

        // uuid
        $uuid = CID::decode($uuid_enc);
        $data = PermohonanPeneraan::where("uuid_perusahaan", $uuid_perusahaan)
            ->where("uuid", $uuid)
            ->firstOrFail();

        // value
        $lokasi_peneraan = $request->lokasi_peneraan;
        $kode_permohonan = $data->kode_permohonan;
        if ($lokasi_peneraan == "Luar Kantor Metrologi") {
            $uuid_alamat = $request->uuid_alamat;
        } else {
            $uuid_alamat = null;
        }
        $value_1 = [
            "nomor_surat_permohonan" => $request->nomor_surat_permohonan,
            "tanggal_permohonan" => date('Y-m-d', strtotime($request->tanggal_permohonan)),
            "lokasi_peneraan" => $lokasi_peneraan,
            "uuid_alamat" => $uuid_alamat,
            "uuid_updated" => $uuid_profile,
        ];

        // file_surat_permohonan
        $path = "permohonan/" . date('Y', strtotime($data->tanggal_permohonan)) . "/" . $kode_permohonan;
        if ($request->hasFile('file_surat_permohonan')) {
            $file_surat_permohonan = CID::UpImgPdf($request, "file_surat_permohonan", $path);
            if ($file_surat_permohonan == "0") {
                alert()->error('Error!', 'Gagal Menyimpan Data, File Surat Permohonan Tidak Sesuai Format!');
                return \back();
            }
            $value_1['file_surat_permohonan'] = $file_surat_permohonan['url'];
        }

        // save
        $save_1 = $data->update($value_1);
        if ($save_1) {
            // create log
            $aktifitas = [
                "tabel" => array("permohonan_peneraan"),
                "uuid" => array($uuid),
                "value" => array($value_1),
            ];
            $log = [
                "apps" => "Penjadwalan dan Penugasan Apps",
                "subjek" => "Berhasil Mengubah Permohonan Pengujian (" . $kode_permohonan . ") - " . $uuid,
                "aktifitas" => $aktifitas,
                "device" => "web",
                "dashboard" => "1",
            ];
            CID::addToLogAktifitas($request, $log);
            // alert success
            alert()->success('Berhasil!', 'Berhasil Mengubah Permohonan Pengujian.');
            return redirect()->route('pdp.apps.reqpeneraan.index');
        } else {
            alert()->error('Gagal!', 'Gagal Mengubah Permohonan Pengujian.');
            return back()->withInput($request->all());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        // uuid
        $uuid = CID::decode($request->uuid);

        // data
        $data = PermohonanPeneraan::findOrFail($uuid);

        // save
        $save_1 = $data->delete();
        if ($save_1) {
            // create log
            $aktifitas = [
                "tabel" => array("permohonan_peneraan"),
                "uuid" => array($uuid),
                "value" => array($data),
            ];
            $log = [
                "apps" => "Penjadwalan dan Penugasan Apps",
                "subjek" => "Berhasil Menghapus Permohonan Peneraan (" . $data->kode_permohonan . ") - " . $uuid,
                "aktifitas" => $aktifitas,
                "device" => "web",
                "dashboard" => "1",
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

    /**
     * Remove the specified resource from storage.
     */
    public function data(Request $request)
    {
        // auth
        $auth = Auth::user();
        $profile = $auth->RelPerusahaan;

        // cek filter
        if ($request->session()->exists('filter_tahun')) {
            $tahun = $request->session()->get('filter_tahun');
            $status = $request->session()->get('filter_status');
        } else {
            $request->session()->put('filter_tahun', date('Y'));
            $request->session()->put('filter_status', "Baru");
            $tahun = date('Y');
            $status = "Baru";
        }

        if ($request->ajax()) {
            if (isset($_GET['filter'])) {
                $tahun = $_GET['filter']['tahun'];
                $status = $_GET['filter']['status'];
                $request->session()->put('filter_tahun', $tahun);
                $request->session()->put('filter_status', $status);
            } else {
                $tahun = $request->session()->get('filter_tahun');
                $status = $request->session()->get('filter_status');
            }

            if ($status == "Semua Data") {
                $data = PermohonanPeneraan::whereUuidPerusahaan($profile->uuid)
                    ->whereYear("tanggal_permohonan", $tahun)
                    ->orderBy("created_at", "DESC")
                    ->get();
            } else {
                $data = PermohonanPeneraan::whereUuidPerusahaan($profile->uuid)
                    ->whereYear("tanggal_permohonan", $tahun)
                    ->whereStatus($status)
                    ->orderBy("created_at", "DESC")
                    ->get();
            }
            return Datatables::of($data)
                ->addIndexColumn()
                ->setRowId('uuid')
                ->addColumn('jenis_pengujian', function ($data) {
                    if ($data->jenis_pengujian == "Tera") {
                        $jenis_pengujian = '<span class="badge badge-info">' . $data->jenis_pengujian . '</span>';
                    } elseif ($data->jenis_pengujian == "Tera Ulang") {
                        $jenis_pengujian = '<span class="badge badge-success">' . $data->jenis_pengujian . '</span>';
                    } elseif ($data->jenis_pengujian == "Pengujian BDKT") {
                        $jenis_pengujian = '<span class="badge badge-secondary">' . $data->jenis_pengujian . '</span>';
                    }

                    return $jenis_pengujian;
                })
                ->addColumn('nomor_order', function ($data) {
                    $nomor_order = "";
                    if (isset($data->RelPdpPenjadwalan)) {
                        $nomor_order = $data->RelPdpPenjadwalan->nomor_order;
                    }
                    return $nomor_order;
                })
                ->addColumn('progress', function ($data) {
                    $progress = CID::getProgressPermohonan($data);
                    return $progress;
                })
                ->addColumn('status', function ($data) {
                    $progress = CID::getProgressPermohonan($data);
                    $color = CID::getColorStatusPermohonan($data, 1);
                    $status = '<label class="' . $color . '"><strong>' . Str::upper($data->status) . '</strong></label>';
                    $status .= '<p class="m-0 p-0 ps-5"><i>' . $progress . '</i></p>';
                    return $status;
                })
                ->addColumn('aksi', function ($data) {
                    $status = $data->status;
                    $uuid_enc = CID::encode($data->uuid);
                    $edit = route('pdp.apps.reqpeneraan.edit', $uuid_enc);
                    $show = route('pdp.apps.reqpeneraan.show', $uuid_enc);
                    if ($status == "Baru") {
                        $aksi = '
                        <div class="d-flex">
                            <a href="' . $edit . '" class="btn btn-sm btn-info shadow btn-xs sharp me-1"><i class="fas fa-pencil-alt"></i></a>
                            <a href="javascript:void(0);" class="btn btn-sm btn-danger shadow btn-xs sharp" data-delete="' . $uuid_enc . '"><i class="fa fa-trash"></i></a>
                        </div>';

                    } else {
                        $aksi = '
                        <div class="d-flex">
                            <a href="' . $show . '" class="btn btn-sm btn-success shadow btn-xs sharp me-1 btn-block"><i class="fas fa-eye"></i></a>
                        </div>';
                    }
                    return $aksi;
                })
                ->escapeColumns([''])
                ->make(true);
        }
    }
}
