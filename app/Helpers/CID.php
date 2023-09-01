<?php

namespace App\Helpers;

use App\Models\PortalKategori;
use App\Models\PortalPage;
use App\Models\PortalSetup;
use App\Models\PortalSosmed;
use App\Models\SysLogAktifitas;
use Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Storage;

class CID
{
    /*
    |--------------------------------------------------------------------------
    | FUNCTION GLOBAL
    |--------------------------------------------------------------------------
     */
    // Untuk Encode String
    public static function encode($string)
    {
        $encode = date('Ymd') . $string;
        $encode = rtrim(strtr(base64_encode($encode), '+/', '-_'), '=');
        return $encode;
    }
    // Untuk Decode String
    public static function decode($string)
    {
        $decode = base64_decode(str_pad(strtr($string, '-_', '+/'), strlen($string) % 4, '=', STR_PAD_RIGHT));
        $decode = substr($decode, 8);
        return $decode;
    }
    // Untuk Crypt String
    public static function crypt($string)
    {
        $data = Crypt::encryptString($string);
        return $data;
    }
    // Untuk Dcrypt String
    public static function dcrypt($string)
    {
        $data = Crypt::decryptString($string);
        return $data;
    }
    // Untuk Kode String
    public static function gencode($bytes)
    {
        return bin2hex(openssl_random_pseudo_bytes($bytes));
    }
    // Untuk Kode String
    public static function genzero($num, $value)
    {
        $data = sprintf("%0" . $num . "d", $value);
        return $data;
    }
    // Untuk Foto Profil
    public static function pp()
    {
        $auth = Auth::user();
        $role = $auth->role;

        if ($role == "Perusahaan") {
            // perusahaan
            $nama = $auth->RelPerusahaan->nama_perusahaan;
            $pp = "https://ui-avatars.com/api/?name=$nama";
        } else {
            // pegawai dan admin
            $foto = $auth->RelPegawai->foto;
            if ($foto != "") {
                return Self::urlImg($foto);
            } else {
                $nama = $auth->RelPegawai->nama_lengkap;
                $pp = "https://ui-avatars.com/api/?name=$nama";
            }
        }
        return $pp;
    }
    // Untuk Data Profil
    public static function DataPP()
    {
        $auth = Auth::user();
        $role = $auth->role;

        if ($role == "Perusahaan") {
            // perusahaan
            $nama = $auth->RelPerusahaan->nama_perusahaan;
        } else {
            // pegawai dan admin
            $nama = $auth->RelPegawai->nama_lengkap;
        }
        $data = [
            "role" => $role,
            "nama" => $nama,
        ];
        return $data;
    }
    // Untuk Jenis Kelamin
    public static function getJKL($jkl)
    {
        if ($jkl == "L") {
            $gender = "Laki-laki";
        } else {
            $gender = "Perempuan";
        }
        return $gender;
    }
    // Untuk URL Image
    public static function urlImg($url)
    {
        if (Storage::disk('public')->exists($url)) {
            $url = asset('storage/' . $url);
        } else {
            $url = $url;
        }
        return $url;
    }
    // Untuk Lihat Image
    public static function ViewImg($url)
    {
        if (empty($url)) {
            return $url;
        }
        $url = asset('storage/' . $url);
        return $url;
    }
    // Untuk Mengubah Slug Jadi Ucwords
    public static function UcSlug($slug)
    {
        $slug = \str_replace("-", " ", $slug);
        $slug = \ucwords($slug);
        return $slug;
    }
    // Untuk Mengubah Slug Jadi UcModel
    public static function UcModel($slug)
    {
        $slug = \str_replace(["-", "_", " "], " ", $slug);
        $slug = \ucwords($slug);
        $slug = \str_replace(["-", "_", " "], "", $slug);
        return $slug;
    }
    // Untuk Mengubah Slug Jadi Ucwords
    public static function toRP($value)
    {
        $data = "Rp. " . number_format($value, 0, ',', '.');
        return $data;
    }
    // Untuk Mengubah Slug Jadi Ucwords
    public static function toDot($value)
    {
        $data = number_format($value, 0, ',', '.');
        return $data;
    }
    // Untuk Endpoint Response True
    public static function erTrue($data)
    {
        // response json
        $response = [
            "status" => true,
            "data" => $data,
        ];
        return response()->json($response, 200);
    }
    // Untuk Endpoint Response False
    public static function erFalse($msg, $code)
    {
        // response json
        $response = [
            "status" => false,
            "message" => $msg,
        ];
        return response()->json($response, $code);
    }
    // Konvert Size Disk
    public static function SizeDisk($bytes)
    {
        if ($bytes >= 1073741824) {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        } elseif ($bytes > 1) {
            $bytes = $bytes . ' bytes';
        } elseif ($bytes == 1) {
            $bytes = $bytes . ' byte';
        } else {
            $bytes = '0 bytes';
        }
        return $bytes;
    }

    /*
    |--------------------------------------------------------------------------
    | FUNCTION DATE
    |--------------------------------------------------------------------------
     */
    // Hari, Tgl/
    public static function TglSimple($tgl)
    {
        $tgll = "$tgl";
        $day = date('D', strtotime($tgll));
        $dayOne = date('d', strtotime($tgll));
        $array_hari = array(
            'Sun' => 'Minggu',
            'Mon' => 'Senin',
            'Tue' => 'Selasa',
            'Wed' => 'Rabu',
            'Thu' => 'Kamis',
            'Fri' => 'Jum\'at',
            'Sat' => 'Sabtu',
        );
        $blnn = date('m', strtotime($tgll));
        $array_bulan = array(
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember',
        );
        $thnn = date('y', strtotime($tgll));
        $Jam = date('H:i:s', strtotime($tgll));
        return $dayOne . "/" . $blnn . "/" . $thnn;
    }
    // Hari, Tgl/
    public static function hariTgl($tgl)
    {
        $tgll = "$tgl";
        $day = date('D', strtotime($tgll));
        $dayOne = date('d', strtotime($tgll));
        $array_hari = array(
            'Sun' => 'Minggu',
            'Mon' => 'Senin',
            'Tue' => 'Selasa',
            'Wed' => 'Rabu',
            'Thu' => 'Kamis',
            'Fri' => 'Jum\'at',
            'Sat' => 'Sabtu',
        );
        $blnn = date('m', strtotime($tgll));
        $array_bulan = array(
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember',
        );
        $thnn = date('Y', strtotime($tgll));
        $Jam = date('H:i:s', strtotime($tgll));
        return $array_hari[$day] . ", " . $dayOne . " " . $array_bulan[$blnn] . " " . $thnn;
    }
    // Tanggal Bulan Tahun (TTD)
    public static function tglBlnThn($tgl)
    {
        $tgll = "$tgl";
        $dayOne = date('d', strtotime($tgll));
        $blnn = date('m', strtotime($tgll));
        $array_bulan = array(
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember',
        );
        $thnn = date('Y', strtotime($tgll));
        return $dayOne . " " . $array_bulan[$blnn] . " " . $thnn;
    }
    // tanggal jam
    public static function TglJam($string)
    {
        $tgll = "$string";
        $tgl = date('d/m/y', strtotime($tgll));
        $jam = date('H:i', strtotime($tgll));
        return $tgl . " " . $jam;
    }
    // Bulan
    public static function intToMonth($int)
    {
        $array_bulan = array(
            '1' => 'Januari',
            '2' => 'Februari',
            '3' => 'Maret',
            '4' => 'April',
            '5' => 'Mei',
            '6' => 'Juni',
            '7' => 'Juli',
            '8' => 'Agustus',
            '9' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember',
        );

        return $array_bulan[$int];
    }
    // Array Bulan
    public static function arMonth()
    {
        $array_bulan = array(
            '1' => 'Januari',
            '2' => 'Februari',
            '3' => 'Maret',
            '4' => 'April',
            '5' => 'Mei',
            '6' => 'Juni',
            '7' => 'Juli',
            '8' => 'Agustus',
            '9' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember',
        );

        return $array_bulan;
    }
    // Array Bulan
    public static function arMonth2($bln)
    {
        $array_bulan = array(
            '1' => 'Jan',
            '2' => 'Feb',
            '3' => 'Mar',
            '4' => 'Apr',
            '5' => 'Mei',
            '6' => 'Jun',
            '7' => 'Jul',
            '8' => 'Aug',
            '9' => 'Sep',
            '10' => 'Oct',
            '11' => 'Nov',
            '12' => 'Dec',
        );

        return $array_bulan[$bln];
    }
    // Jam dan Menit
    public static function jamMenit($timestamp)
    {
        $jamMenit = date('H:i', strtotime($timestamp));
        return $jamMenit;
    }
    // Ucapan Waktu
    public static function Greeting()
    {
        $waktu = gmdate("H:i", time() + 7 * 3600);
        $t = explode(":", $waktu);
        $jam = $t[0];
        $menit = $t[1];

        if ($jam >= 00 and $jam < 10) {
            if ($menit > 00 and $menit < 60) {
                $ucapan = "Selamat Pagi";
            } else {
                $ucapan = "";
            }
        } elseif ($jam >= 10 and $jam < 15) {
            if ($menit > 00 and $menit < 60) {
                $ucapan = "Selamat Siang";
            } else {
                $ucapan = "";
            }
        } elseif ($jam >= 15 and $jam < 18) {
            if ($menit > 00 and $menit < 60) {
                $ucapan = "Selamat Sore";
            } else {
                $ucapan = "";
            }
        } elseif ($jam >= 18 and $jam <= 24) {
            if ($menit > 00 and $menit < 60) {
                $ucapan = "Selamat Malam";
            } else {
                $ucapan = "";
            }
        } else {
            $ucapan = "";
        }
        return $ucapan;
    }
    // Panggilan
    public static function Panggilan($jkl)
    {
        if ($jkl == "L" || $jkl == "Laki-laki") {
            $panggilan = "Bapak ";
        } elseif ($jkl == "P" || $jkl == "Perempuan") {
            $panggilan = "Ibu ";
        } else {
            $panggilan = "";
        }
        return $panggilan;
    }
    // wellcomeBack
    public static function welcomeBack()
    {
        $nama_lengkap = Auth::user()->RelAdministrator->nama_lengkap;
        $waktu = Self::Greeting();
        $welcome = $waktu . " " . $nama_lengkap;
        return $welcome;
    }
    /*
    |--------------------------------------------------------------------------
    | FUNCTION UPLOAD
    |--------------------------------------------------------------------------
     */
    // Untuk Upload Gambar
    public static function UpImg($request, $field, $path)
    {
        $ext = strtolower($request->file($field)->extension());
        $ext_array = array('jpg', 'jpeg', 'png');
        if (in_array($ext, $ext_array)) {
            $file = $request->file($field);
            $file_name = Self::gencode(5);
            $file_name = $file_name . "-" . rand(1000, 9999999999) . "-[SIMEGAL]." . Str::lower($ext);
            $file_save = $path . "/" . $file_name;
            if (!is_dir(storage_path('app/public/' . $path))) {
                Storage::disk('public')->makeDirectory($path);
            }
            Storage::disk('public')->putFileAs($path, $file, $file_name);
            return $file_save;
        } else {
            return "0";
        }
    }
    // Untuk Upload Gambar Post
    public static function UpImgPost($request, $field, $paths)
    {
        $detail = $request->input($field);
        libxml_use_internal_errors(true);
        $dom = new \DomDocument();
        $dom->loadHtml($detail, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $images = $dom->getElementsByTagName('img');
        foreach ($images as $k => $img) {
            $data = $img->getAttribute('src');
            if (strstr($data, "data:image")) {
                list($type, $data) = explode(';', $data);
                list(, $data) = explode(',', $data);
                $data = base64_decode($data);
                $folder = $paths;
                $image_name = Storage::disk('public')->makeDirectory($folder);
                $image_name = $folder . "/" . Self::gencode(3) . "-" . date('dmy') . "-" . rand(1000, 9999999) . "-" . $k . '-[SIMEGAL].png';
                $path = storage_path() . "/app/public/" . $image_name;
                file_put_contents($path, $data);
                $url_img = \url('/') . "/storage/" . $image_name;
                // $url_img = "/storage/" . $image_name;
                $img->removeAttribute('data-filename');
                $img->removeAttribute('src');
                $img->setAttribute('src', $url_img);
            }
        }
        return $dom->saveHTML();
    }
    // Untuk Update Gambar Post
    public static function UpdateImgPost($request, $field, $paths)
    {
        $detail = $request->input($field);
        libxml_use_internal_errors(true);
        $dom = new \DomDocument();
        $dom->loadHtml($detail, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $images = $dom->getElementsByTagName('img');
        foreach ($images as $k => $img) {
            $data = $img->getAttribute('src');
            if (strstr($data, "data:image")) {
                list($type, $data) = explode(';', $data);
                list(, $data) = explode(',', $data);
                $data = base64_decode($data);
                $folder = $paths;
                $image_name = Storage::disk('public')->makeDirectory($folder);
                $image_name = $folder . "/" . Self::gencode(3) . "-" . date('dmy') . "-" . rand(1000, 9999999) . "-" . $k . '-[SIMEGAL].png';
                $path = storage_path() . "/app/public/" . $image_name;
                file_put_contents($path, $data);
                $url_img = \url('/') . "/storage/" . $image_name;
                // $url_img = "/storage/" . $image_name;
                $img->removeAttribute('data-filename');
                $img->removeAttribute('src');
                $img->setAttribute('src', $url_img);
            }
        }
        return $dom->saveHTML();
    }
    // Untuk Upload Pdf
    public static function UpPdf($request, $field, $path)
    {
        $ext = strtolower($request->file($field)->extension());
        $ext_array = array('pdf');
        if (in_array($ext, $ext_array)) {
            $file = $request->file($field);
            $file_name = Self::gencode(5);
            $file_name = $file_name . "-" . rand(1000, 9999999999) . "." . $ext;
            $file_save = $path . "/" . $file_name;
            if (!is_dir(storage_path('app/public/' . $path))) {
                Storage::disk('public')->makeDirectory($path);
            }
            Storage::disk('public')->putFileAs($path, $file, $file_name);
            return $file_save;
        } else {
            return "0";
        }
    }
    // Untuk Upload File & Gambar
    public static function UpFileUnduhan($request, $field, $path)
    {
        $ext = strtolower($request->file($field)->extension());
        $ext_array = array('jpg', 'jpeg', 'png', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'pdf', 'zip', 'rar');
        if (in_array($ext, $ext_array)) {
            $file = $request->file($field);
            $filename = $file->getClientOriginalName();
            $name = ucwords(pathinfo($filename, PATHINFO_FILENAME));
            $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            $size = $file->getSize();
            $file_name = Str::uuid() . "-" . rand(1000, 9999999999) . "." . Str::lower($ext);
            $file_save = $path . "/" . $file_name;
            if (!is_dir(storage_path('app/public/' . $path))) {
                Storage::disk('public')->makeDirectory($path);
            }
            Storage::disk('public')->putFileAs($path, $file, $file_name);
            $data = [
                "judul_file" => $name,
                "nama_file" => $file_name,
                "tipe_file" => Str::lower($ext),
                "ukuran_file" => $size,
                "url" => $file_save,
            ];
            return $data;
        } else {
            return "0";
        }
    }
    // mengatasi path traversal
    public static function sanitize_input($input)
    {
        $input = str_replace('/', '', $input); // hapus tanda / pada input
        $input = str_replace('\\', '', $input); // hapus tanda \ pada input
        $input = str_replace('..', '', $input); // hapus tanda .. pada input
        $input = str_replace('|', '', $input); // hapus tanda | pada input
        return $input;
    }

    /*
    |--------------------------------------------------------------------------
    | FUNCTION MODELS
    |--------------------------------------------------------------------------
     */
    // Add Log Activity
    public static function addToLogAktifitas($request, $detail)
    {
        if (Auth::check()) {
            // User
            $user = Auth::user();
            // Log
            $log = [];
            $log['uuid'] = Str::uuid();
            $log['uuid_profile'] = $user->uuid_profile;
            $log['apps'] = $detail['apps'];
            $log['role'] = $user->role;
            $log['subjek'] = $detail['subjek'];
            $log['method'] = $request->method();
            $log['ip'] = $request->ip();
            $log['agent'] = $request->header('user-agent');
            $log['url'] = $request->fullUrl();
            $log['aktifitas'] = json_encode($detail['aktifitas']);
            $log['device'] = $detail['device'];
            if (isset($detail['dashboard'])) {
                $log['dashboard'] = $detail['dashboard'];
            }
        } else {
            // Log
            $log = [];
            $log['uuid'] = Str::uuid();
            $log['uuid_profile'] = $detail['uuid_profile'];
            $log['apps'] = $detail['apps'];
            $log['role'] = $detail['role'];
            $log['subjek'] = $detail['subjek'];
            $log['method'] = $request->method();
            $log['ip'] = $request->ip();
            $log['agent'] = $request->header('user-agent');
            $log['url'] = $request->fullUrl();
            $log['aktifitas'] = json_encode($detail['aktifitas']);
            $log['device'] = $detail['device'];
            if (isset($detail['dashboard'])) {
                $log['dashboard'] = $detail['dashboard'];
            }
        }
        SysLogAktifitas::create($log);
    }
    // Add Log Activity
    public static function tombolUnduhan($tipe)
    {
        // gambar
        $gambar = [
            "png",
            "jpg",
            "jpeg",
            "svg",
        ];
        $office = [
            "doc",
            "docx",
            "xls",
            "xlsx",
            "ppt",
            "pptx",
        ];
        $pdf = [
            "pdf",
        ];
        $package = [
            "zip",
            "rar",
        ];

        if (in_array($tipe, $gambar)) {
            $tags = "gambar";
        } elseif (in_array($tipe, $office)) {
            $tags = "office";
        } elseif (in_array($tipe, $pdf)) {
            $tags = "pdf";
        } elseif (in_array($tipe, $package)) {
            $tags = "package";
        }
        return $tags;
    }

    /*
    |--------------------------------------------------------------------------
    | PORTAL APPS
    |--------------------------------------------------------------------------
     */
    // Get Data Portal Setup
    public static function getPortalSetup()
    {
        // cek data setup
        $cekSetup = PortalSetup::first();
        if ($cekSetup === null) {
            // create
            $value_1 = [
                "uuid" => Str::uuid(),
                "google_maps" => "https: //goo.gl/maps/HT6TtdJCVubJqRB69",
                "alamat" => "Bidang Metrologi Legal, Balaraja, Kec. Balaraja, Kabupaten Tangerang, Banten 15610.",
                "no_telp" => "+6221234567",
                "email" => "info@simegal.tangerangkab.go.id",
                "link_survey" => "https://s.id/survey-simegal-23",
            ];
            PortalSetup::create($value_1);
        }
        // data
        $data = PortalSetup::first();
        return $data;
    }
    // Get Data Portal Sosmed
    public static function getSosmed()
    {
        // cek data sosmed
        $cekSosmed = PortalSosmed::first();
        if ($cekSosmed === null) {
            // create
            $sosmed = [
                "Facebook",
                "Twitter",
                "Instagram",
                "YouTube",
            ];
            $url = [
                "https://www.facebook.com/",
                "https://www.twitter.com/",
                "https://www.instagram.com/",
                "https://www.youtube.com/",
            ];
            $csosmed = count($sosmed);
            for ($i = 0; $i < $csosmed; $i++) {
                // value
                $value_1 = [
                    "uuid" => Str::uuid(),
                    "sosmed" => $sosmed[$i],
                    "url" => $url[$i],
                ];
                // save
                PortalSosmed::create($value_1);
            }
        }

        // update
        $data = PortalSosmed::all();
        return $data;
    }
    // Get Data Kategori
    public static function getKategori($jenis)
    {
        $data = PortalKategori::whereJenis($jenis)->whereStatus("1")->orderBy("nama")->get();
        return $data;
    }
    // Get Data Halaman
    public static function getHalaman()
    {
        $data = PortalPage::whereStatus("1")->orderBy("judul", "ASC")->get();
        return $data;
    }

    /*
    |--------------------------------------------------------------------------
    | PENJADWALAN DAN PENUGASAN APPS
    |--------------------------------------------------------------------------
     */
    // Generate Kode Perusahaan
    public static function genKodePerusahaan($jp)
    {
        if ($jp == "Perusahaan") {
            // Perusahaan
            $kode = "1";
            $kode .= date('ny');
            $kode .= "-" . Str::upper(Self::gencode(2));
        } else {
            // Pemilik UTTP
            $kode = "2";
            $kode .= date('ny');
            $kode .= "-" . Str::upper(Self::gencode(2));
        }
        return $kode;
    }
}
