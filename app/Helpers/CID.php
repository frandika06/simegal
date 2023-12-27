<?php

namespace App\Helpers;

use App\Models\MasterFitur;
use App\Models\MasterInstrumenDaftarItemUttp;
use App\Models\MasterKategoriKelompok;
use App\Models\PdpDataPetugas;
use App\Models\PdpPenjadwalan;
use App\Models\PermohonanPeneraan;
use App\Models\Perusahaan;
use App\Models\PortalKategori;
use App\Models\PortalPage;
use App\Models\PortalSetup;
use App\Models\PortalSosmed;
use App\Models\SysLogAktifitas;
use App\Models\TteSkhp;
use Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
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
    public static function pp($url = null)
    {
        $auth = Auth::user();
        $role = $auth->role;

        if ($url !== null) {
            if ($url != "") {
                return Self::urlImg($url);
            } else {
                $pp = asset('assets-portal/dist/img/no_image.png');
            }
        } else {
            if ($role == "Perusahaan") {
                // perusahaan
                $foto = $auth->RelPerusahaan->foto;
                if ($foto != "") {
                    return Self::urlImg($foto);
                } else {
                    $nama = $auth->RelPerusahaan->nama_perusahaan;
                    $pp = "https://ui-avatars.com/api/?name=$nama";
                }
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
        }

        return $pp;
    }
    // Untuk Foto Profil
    public static function ppPegawai($url = null)
    {
        if ($url !== null) {
            if ($url != "") {
                return Self::urlImg($url);
            } else {
                $pp = asset('assets-portal/dist/img/no_image.png');
            }
        } else {
            $pp = asset('assets-portal/dist/img/no_image.png');
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
            $email = $auth->RelPerusahaan->email;
            $no_telp = $auth->RelPerusahaan->no_telp_1;
            $npwp = $auth->RelPerusahaan->npwp;
            $kode = $auth->RelPerusahaan->kode_perusahaan;
            $data = [
                "role" => $role,
                "nama" => $nama,
                "email" => $email,
                "npwp" => $npwp,
                "kode" => $kode,
            ];
        } else {
            // pegawai dan admin
            $nama = $auth->RelPegawai->nama_lengkap;
            $email = $auth->RelPegawai->email;
            $no_telp = $auth->RelPegawai->no_telp;
            $data = [
                "role" => $role,
                "nama" => $nama,
                "email" => $email,
            ];
        }
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
    // penyebut
    public static function penyebut($nilai)
    {
        $nilai = abs($nilai);
        $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
        $temp = "";
        if ($nilai < 12) {
            $temp = " " . $huruf[$nilai];
        } else if ($nilai < 20) {
            $temp = self::penyebut($nilai - 10) . " belas";
        } else if ($nilai < 100) {
            $temp = self::penyebut($nilai / 10) . " puluh" . self::penyebut($nilai % 10);
        } else if ($nilai < 200) {
            $temp = " seratus" . self::penyebut($nilai - 100);
        } else if ($nilai < 1000) {
            $temp = self::penyebut($nilai / 100) . " ratus" . self::penyebut($nilai % 100);
        } else if ($nilai < 2000) {
            $temp = " seribu" . self::penyebut($nilai - 1000);
        } else if ($nilai < 1000000) {
            $temp = self::penyebut($nilai / 1000) . " ribu" . self::penyebut($nilai % 1000);
        } else if ($nilai < 1000000000) {
            $temp = self::penyebut($nilai / 1000000) . " juta" . self::penyebut($nilai % 1000000);
        } else if ($nilai < 1000000000000) {
            $temp = self::penyebut($nilai / 1000000000) . " milyar" . self::penyebut(fmod($nilai, 1000000000));
        } else if ($nilai < 1000000000000000) {
            $temp = self::penyebut($nilai / 1000000000000) . " trilyun" . self::penyebut(fmod($nilai, 1000000000000));
        }
        return $temp;
    }
    // terbilang
    public static function terbilang($nilai)
    {
        if ($nilai < 0) {
            $hasil = "minus " . trim(self::penyebut($nilai));
        } else {
            $hasil = trim(self::penyebut($nilai));
        }
        return $hasil;
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
    // Bulan to romawi
    public static function bln2Romawi($bln)
    {
        $array_bulan = array(
            '1' => 'I',
            '2' => 'II',
            '3' => 'III',
            '4' => 'IV',
            '5' => 'V',
            '6' => 'VI',
            '7' => 'VII',
            '8' => 'VIII',
            '9' => 'IX',
            '10' => 'X',
            '11' => 'XI',
            '12' => 'XII',
        );

        return $array_bulan[$bln];
    }
    // Jam dan Menit
    public static function jamMenit($timestamp)
    {
        $jamMenit = date('H:i', strtotime($timestamp));
        return $jamMenit;
    }
    // Hitung Berapa Hari Ke Sekarang
    public static function hitungHariSekarang($tgl)
    {
        $date = Carbon::parse($tgl);
        $now = Carbon::now('Asia/Jakarta');
        $diff = $date->diffInDays($now);
        $result = (int) $diff;
        return $result;
    }
    // Hitung Berapa Jam Ke Sekarang
    public static function hitungJamSekarang($tgl)
    {
        $date = Carbon::parse($tgl);
        $now = Carbon::now('Asia/Jakarta');
        $diff = $date->diffInHours($now);
        $result = (int) $diff;
        return $result;
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
        $nama_lengkap = Auth::user()->RelPegawai->nama_lengkap;
        $waktu = Self::Greeting();
        $welcome = $waktu . " " . $nama_lengkap;
        return $welcome;
    }
    // hitungMasaAktifHari
    public static function hitungMasaAktif($expired)
    {
        // Tanggal sekarang
        $now = Carbon::now('Asia/Jakarta');

        // Tanggal kadaluwarsa
        $expiration = Carbon::parse($expired);

        // Periksa apakah sudah kadaluwarsa
        if ($now > $expiration) {
            return 'Expired';
        }

        // Hitung selisih hari
        $remainingDays = $now->diffInDays($expiration);

        return $remainingDays;
    }
    // hitungMasaAktifLengkap
    public static function hitungMasaAktifLengkap($expired)
    {
        // Tanggal sekarang
        $now = Carbon::now('Asia/Jakarta');

        // Tanggal kadaluwarsa
        $expiration = Carbon::parse($expired);

        // Periksa apakah sudah kadaluwarsa
        if ($now > $expiration) {
            return 'Expired';
        }

        // Hitung selisih waktu
        $diff = $now->diff($expiration);

        // Format hasil
        $result = [];

        if ($diff->d > 0) {
            $result[] = $diff->d . ' Hari';
        }

        if ($diff->h > 0) {
            $result[] = $diff->h . ' Jam';
        }

        if ($diff->i > 0) {
            $result[] = $diff->i . ' Menit';
        }

        return implode(', ', $result);
    }
    // getBulanLetterFromParameter
    public static function getBulanLetterFromParameter($bulan)
    {
        switch ($bulan) {
            case '01':
                return "Januari";
                break;
            case '02':
                return "Februari";
                break;
            case '03':
                return "Maret";
                break;
            case '04':
                return "April";
                break;
            case '05':
                return "Mei";
                break;
            case '06':
                return "Juni";
                break;
            case '07':
                return "Juli";
                break;
            case '08':
                return "Agustus";
                break;
            case '09':
                return "September";
                break;
            case '10':
                return "Oktober";
                break;
            case '11':
                return "November";
                break;
            case '12':
                return "Desember";
                break;
            default:
                return "NONE";
                break;
        }
    }
    // getBulanLetter
    public static function getBulanLetter()
    {
        switch (date('m')) {
            case '01':
                return "Januari";
                break;
            case '02':
                return "Februari";
                break;
            case '03':
                return "Maret";
                break;
            case '04':
                return "April";
                break;
            case '05':
                return "Mei";
                break;
            case '06':
                return "Juni";
                break;
            case '07':
                return "Juli";
                break;
            case '08':
                return "Agustus";
                break;
            case '09':
                return "September";
                break;
            case '10':
                return "Oktober";
                break;
            case '11':
                return "November";
                break;
            case '12':
                return "Desember";
                break;
            default:
                return "NONE";
                break;
        }
    }
    // getRomawi
    public static function getRomawi()
    {
        switch (date('m')) {
            case '01':
                return "I";
                break;
            case '02':
                return "II";
                break;
            case '03':
                return "III";
                break;
            case '04':
                return "IV";
                break;
            case '05':
                return "V";
                break;
            case '06':
                return "VI";
                break;
            case '07':
                return "VII";
                break;
            case '08':
                return "VIII";
                break;
            case '09':
                return "IX";
                break;
            case '10':
                return "X";
                break;
            case '11':
                return "XI";
                break;
            case '12':
                return "XII";
                break;
            default:
                return "NONE";
                break;
        }
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
    // Untuk Upload File & Gambar
    public static function UpImgPdf($request, $field, $path)
    {
        $ext = strtolower($request->file($field)->extension());
        $ext_array = array('jpg', 'jpeg', 'png', 'pdf', 'JPG', 'JPEG', 'PNG', 'PDF');
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
    // Untuk Upload File PDF
    public static function UpFilePdf($request, $field, $path)
    {
        $ext = strtolower($request->file($field)->extension());
        $ext_array = array('pdf');
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
    // Untuk Upload File SKHP
    public static function UpFileSKHP($request, $field, $path)
    {
        $ext = strtolower($request->file($field)->extension());
        $ext_array = array('pdf');
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
    // Hak Akses subRoleSuperAdmin
    public static function subRoleSuperAdmin()
    {
        $auth = Auth::user();
        $role = $auth->role;

        if ($role == "Admin System" || $role == "Super Admin") {
            // izinkan
            return true;
        } else {
            // blokir
            return false;
        }
    }
    // Hak Akses subRolePegawai
    public static function subRolePegawai()
    {
        $auth = Auth::user();
        $role = $auth->role;
        $sub_role = \explode(',', $auth->sub_role);
        $sub_sub_role = \explode(',', $auth->sub_sub_role);

        if ($role == "Admin System" || $role == "Super Admin" || $role == "Kepala Dinas" || $role == "Kepala Bidang") {
            // izinkan
            return true;
        } elseif ($role == "Pegawai") {
            // PEGAWAI
            $ar_sub_role = ['Admin Aplikasi', 'Admin Pengawasan', 'Verifikator', 'Ketua Tim', 'Petugas'];
            if (count(array_intersect($sub_role, $ar_sub_role)) != 0) {
                // izinkan
                return true;
            } else {
                // blokir
                return false;
            }
        } else {
            // blokir
            return false;
        }
    }
    // Hak Akses subRoleAdmin
    public static function subRoleAdmin()
    {
        $auth = Auth::user();
        $role = $auth->role;
        $sub_role = \explode(',', $auth->sub_role);
        $sub_sub_role = \explode(',', $auth->sub_sub_role);

        if ($role == "Admin System" || $role == "Super Admin") {
            // izinkan
            return true;
        } elseif ($role == "Pegawai") {
            // PEGAWAI
            $ar_sub_role = ['Admin Aplikasi'];
            if (count(array_intersect($sub_role, $ar_sub_role)) != 0) {
                // izinkan
                return true;
            } else {
                // blokir
                return false;
            }
        } else {
            // blokir
            return false;
        }
    }
    // Hak Akses subRoleAdminPortal
    public static function subRoleAdminPortal()
    {
        $auth = Auth::user();
        $role = $auth->role;
        $sub_role = \explode(',', $auth->sub_role);
        $sub_sub_role = \explode(',', $auth->sub_sub_role);

        if ($role == "Admin System" || $role == "Super Admin") {
            // izinkan
            return true;
        } elseif ($role == "Pegawai") {
            // PEGAWAI
            $ar_sub_role = ['Admin Portal'];
            if (count(array_intersect($sub_role, $ar_sub_role)) != 0) {
                // izinkan
                return true;
            } else {
                // blokir
                return false;
            }
        } else {
            // blokir
            return false;
        }
    }
    // Hak Akses subRoleAdminPengawasan
    public static function subRoleAdminPengawasan()
    {
        $auth = Auth::user();
        $role = $auth->role;
        $sub_role = \explode(',', $auth->sub_role);
        $sub_sub_role = \explode(',', $auth->sub_sub_role);

        if ($role == "Admin System" || $role == "Super Admin") {
            // izinkan
            return true;
        } elseif ($role == "Pegawai") {
            // PEGAWAI
            $ar_sub_role = ['Admin Aplikasi', 'Admin Pengawasan'];
            if (count(array_intersect($sub_role, $ar_sub_role)) != 0) {
                // izinkan
                return true;
            } else {
                // blokir
                return false;
            }
        } else {
            // blokir
            return false;
        }
    }
    // Hak Akses subRoleVerifikator
    public static function subRoleVerifikator()
    {
        $auth = Auth::user();
        $role = $auth->role;
        $sub_role = \explode(',', $auth->sub_role);
        $sub_sub_role = \explode(',', $auth->sub_sub_role);

        if ($role == "Admin System" || $role == "Super Admin") {
            // izinkan
            return true;
        } elseif ($role == "Pegawai") {
            // PEGAWAI
            $ar_sub_role = ['Admin Aplikasi', 'Verifikator'];
            if (count(array_intersect($sub_role, $ar_sub_role)) != 0) {
                // izinkan
                return true;
            } else {
                // blokir
                return false;
            }
        } else {
            // blokir
            return false;
        }
    }
    // Hak Akses subRolePetugas
    public static function subRolePetugas()
    {
        $auth = Auth::user();
        $role = $auth->role;
        $sub_role = \explode(',', $auth->sub_role);
        $sub_sub_role = \explode(',', $auth->sub_sub_role);

        if ($role == "Admin System" || $role == "Super Admin") {
            // izinkan
            return true;
        } elseif ($role == "Pegawai") {
            // PEGAWAI
            $ar_sub_role = ['Admin Aplikasi', 'Petugas'];
            if (count(array_intersect($sub_role, $ar_sub_role)) != 0) {
                // izinkan
                return true;
            } else {
                // blokir
                return false;
            }
        } else {
            // blokir
            return false;
        }
    }
    // Hak Akses subSubRoleKetuaTim
    public static function subSubRoleKetuaTim()
    {
        $auth = Auth::user();
        $role = $auth->role;
        $sub_role = \explode(',', $auth->sub_role);
        $sub_sub_role = \explode(',', $auth->sub_sub_role);

        if ($role == "Admin System" || $role == "Super Admin") {
            // izinkan
            return true;
        } elseif ($role == "Pegawai") {
            // PEGAWAI
            $ar_sub_role = ['Admin Aplikasi', 'Ketua Tim'];
            if (count(array_intersect($sub_role, $ar_sub_role)) != 0) {
                // izinkan
                $ar_sub_sub_role = ['Ketua Tim Pelayanan', 'Ketua Tim Pengawasan', 'Ketua Tim Bina SDM'];
                if (count(array_intersect($sub_sub_role, $ar_sub_sub_role)) != 0) {
                    // izinkan
                    return true;
                } else {
                    // kembali ke admin
                    return Self::subRoleAdmin();
                }
            } else {
                // blokir
                return false;
            }
        } else {
            // blokir
            return false;
        }
    }
    // Hak Akses subSubRoleKetuaTimPelayanan
    public static function subSubRoleKetuaTimPelayanan()
    {
        $auth = Auth::user();
        $role = $auth->role;
        $sub_role = \explode(',', $auth->sub_role);
        $sub_sub_role = \explode(',', $auth->sub_sub_role);

        if ($role == "Admin System" || $role == "Super Admin") {
            // izinkan
            return true;
        } elseif ($role == "Pegawai") {
            // PEGAWAI
            $ar_sub_role = ['Admin Aplikasi', 'Ketua Tim'];
            if (count(array_intersect($sub_role, $ar_sub_role)) != 0) {
                // izinkan
                $ar_sub_sub_role = ['Ketua Tim Pelayanan'];
                if (count(array_intersect($sub_sub_role, $ar_sub_sub_role)) != 0) {
                    // izinkan
                    return true;
                } else {
                    // kembali ke admin
                    return Self::subRoleAdmin();
                }
            } else {
                // blokir
                return false;
            }
        } else {
            // blokir
            return false;
        }
    }
    // Hak Akses subSubRoleKetuaTimPengawasan
    public static function subSubRoleKetuaTimPengawasan()
    {
        $auth = Auth::user();
        $role = $auth->role;
        $sub_role = \explode(',', $auth->sub_role);
        $sub_sub_role = \explode(',', $auth->sub_sub_role);

        if ($role == "Admin System" || $role == "Super Admin") {
            // izinkan
            return true;
        } elseif ($role == "Pegawai") {
            // PEGAWAI
            $ar_sub_role = ['Admin Aplikasi', 'Admin Pengawasan', 'Ketua Tim'];
            if (count(array_intersect($sub_role, $ar_sub_role)) != 0) {
                // izinkan
                $ar_sub_sub_role = ['Ketua Tim Pengawasan'];
                if (count(array_intersect($sub_sub_role, $ar_sub_sub_role)) != 0) {
                    // izinkan
                    return true;
                } else {
                    // kembali ke admin
                    return Self::subRoleAdminPengawasan();
                }
            } else {
                // blokir
                return false;
            }
        } else {
            // blokir
            return false;
        }
    }
    // Hak Akses subSubRoleKetuaTimBinaSdm
    public static function subSubRoleKetuaTimBinaSdm()
    {
        $auth = Auth::user();
        $role = $auth->role;
        $sub_role = \explode(',', $auth->sub_role);
        $sub_sub_role = \explode(',', $auth->sub_sub_role);

        if ($role == "Admin System" || $role == "Super Admin") {
            // izinkan
            return true;
        } elseif ($role == "Pegawai") {
            // PEGAWAI
            $ar_sub_role = ['Admin Aplikasi', 'Ketua Tim'];
            if (count(array_intersect($sub_role, $ar_sub_role)) != 0) {
                // izinkan
                $ar_sub_sub_role = ['Ketua Tim Bina SDM'];
                if (count(array_intersect($sub_sub_role, $ar_sub_sub_role)) != 0) {
                    // izinkan
                    return true;
                } else {
                    // kembali ke admin
                    return Self::subRoleAdmin();
                }
            } else {
                // blokir
                return false;
            }
        } else {
            // blokir
            return false;
        }
    }
    // Hak Akses subRolePejabatTte
    public static function subRolePejabatTte()
    {
        $auth = Auth::user();
        $role = $auth->role;
        $sub_role = \explode(',', $auth->sub_role);
        $sub_sub_role = \explode(',', $auth->sub_sub_role);

        if ($role == "Kepala Dinas" || $role == "Kepala Bidang") {
            // izinkan
            return true;
        } elseif ($role == "Pegawai") {
            // PEGAWAI
            $ar_sub_role = ['Ketua Tim'];
            if (count(array_intersect($sub_role, $ar_sub_role)) != 0) {
                // izinkan
                $ar_sub_sub_role = ['Ketua Tim Pelayanan', 'Ketua Tim Pengawasan', 'Ketua Tim Bina SDM'];
                if (count(array_intersect($sub_sub_role, $ar_sub_sub_role)) != 0) {
                    // izinkan
                    return true;
                } else {
                    // blokir
                    return false;
                }
            } else {
                // blokir
                return false;
            }
        } else {
            // blokir
            return false;
        }
    }
    // Hak Akses subRoleOnlyPetugas
    public static function subRoleOnlyPetugas()
    {
        $auth = Auth::user();
        $role = $auth->role;
        $sub_role = \explode(',', $auth->sub_role);
        $sub_sub_role = \explode(',', $auth->sub_sub_role);

        if ($role == "Pegawai") {
            // PEGAWAI
            $ar_sub_role = ['Petugas'];
            if (count(array_intersect($sub_role, $ar_sub_role)) != 0) {
                // izinkan
                return true;
            } else {
                // blokir
                return false;
            }
        } else {
            // blokir
            return false;
        }
    }

    // Hak Akses subRolePimpinan
    public static function subRolePimpinan()
    {
        $auth = Auth::user();
        $role = $auth->role;
        $sub_role = \explode(',', $auth->sub_role);
        $sub_sub_role = \explode(',', $auth->sub_sub_role);

        if ($role == "Admin System" || $role == "Super Admin" || $role == "Kepala Dinas" || $role == "Kepala Bidang") {
            // izinkan
            return true;
        } elseif ($role == "Pegawai") {
            // PEGAWAI
            $ar_sub_role = ['Admin Aplikasi'];
            if (count(array_intersect($sub_role, $ar_sub_role)) != 0) {
                // izinkan
                return true;
            } else {
                // blokir
                return false;
            }
        } else {
            // blokir
            return false;
        }
    }

    // Hak Akses subRoleKetuaTimDanPimpinan
    public static function subRoleKetuaTimDanPimpinan()
    {
        $auth = Auth::user();
        $role = $auth->role;
        $sub_role = \explode(',', $auth->sub_role);
        $sub_sub_role = \explode(',', $auth->sub_sub_role);

        if ($role == "Admin System" || $role == "Super Admin" || $role == "Kepala Dinas" || $role == "Kepala Bidang") {
            // izinkan
            return true;
        } elseif ($role == "Pegawai") {
            // PEGAWAI
            $ar_sub_role = ['Admin Aplikasi', 'Ketua Tim'];
            if (count(array_intersect($sub_role, $ar_sub_role)) != 0) {
                // izinkan
                return true;
            } else {
                // blokir
                return false;
            }
        } else {
            // blokir
            return false;
        }
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
                "google_maps" => "https://goo.gl/maps/HT6TtdJCVubJqRB69",
                "alamat" => "Bidang Metrologi Legal, Kec. Balaraja, Kabupaten Tangerang, Banten 15610.",
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
    // get progress permohonan
    public static function getProgressPermohonan($permohonan)
    {
        if ($permohonan->status == "Baru") {
            $progress = "Menunggu Verifikasi Permohonan";
        } elseif ($permohonan->status == "Ditolak") {
            $progress = "Permohonan Ditolak";
        } elseif ($permohonan->status == "Diproses") {
            $posisi1 = isset($permohonan->RelPdpPenjadwalan) ? true : false; // Penjadwalan & Penugasan
            if ($posisi1 == true) {
                $pdp = $permohonan->RelPdpPenjadwalan;
                // sudah penjadwalan
                $posisi2 = isset($pdp->RelPdpInstrumenOrder) ? true : false; // Penentuan Intrumen
                $posisi3 = isset($pdp->RelPdpAlatOrder) ? true : false; // Penentuan Alat
                if ($posisi2 == true || $posisi3 == true) {
                    $progress = "Menunggu Kunjungan Peneraan";
                } else {
                    $progress = "Sudah Dijadwalkan & Penugasan";
                }
            }
        } elseif ($permohonan->status == "Selesai") {
            $progress = "Permohonan Selesai";
        }
        return $progress;
    }
    // set color status permohonan
    public static function getColorStatusPermohonan($permohonan, $id)
    {
        if ($permohonan->status == "Baru") {
            if ($id == "1") {
                $getColor = "text-primary";
            } else {
                $getColor = "bg-primary text-white";
            }
        } elseif ($permohonan->status == "Ditolak") {
            if ($id == "1") {
                $getColor = "text-danger";
            } else {
                $getColor = "bg-danger text-white";
            }
        } elseif ($permohonan->status == "Diproses") {
            if ($id == "1") {
                $getColor = "text-info";
            } else {
                $getColor = "bg-info text-white";
            }
        } elseif ($permohonan->status == "Selesai") {
            if ($id == "1") {
                $getColor = "text-success";
            } else {
                $getColor = "bg-success text-white";
            }
        }
        return $getColor;
    }
    // get alamat perusahaan
    public static function getAlamatPerusahaan($permohonan)
    {
        $alamat = '';
        if ($permohonan->uuid_alamat === null) {
            $alamatDefault = $permohonan->RelPerusahaan->RelAlamatPerusahaanDefault[0];
            $alamat = $alamatDefault->alamat . ',';
            $alamat .= isset($alamatDefault->rt) ? 'RT. ' . $alamatDefault->rt . ', ' : '';
            $alamat .= isset($alamatDefault->rw) ? 'RW. ' . $alamatDefault->rw . ', ' : '';
            $alamat .= Str::title($alamatDefault->Desa->name) . ',';
            $alamat .= Str::title($alamatDefault->Kecamatan->name) . ',';
            $alamat .= Str::title($alamatDefault->Kabupaten->name) . ',';
            $alamat .= Str::title($alamatDefault->Provinsi->name);
            $alamat .= isset($alamatDefault->kode_pos) ? ', ' . $alamatDefault->kode_pos . '.' : '.';
        } else {
            $alamatDefault = $permohonan->RelAlamatPerusahaan;
            $alamat = $alamatDefault->alamat . ',';
            $alamat .= isset($alamatDefault->rt) ? 'RT. ' . $alamatDefault->rt . ', ' : '';
            $alamat .= isset($alamatDefault->rw) ? 'RW. ' . $alamatDefault->rw . ', ' : '';
            $alamat .= Str::title($alamatDefault->Desa->name) . ',';
            $alamat .= Str::title($alamatDefault->Kecamatan->name) . ',';
            $alamat .= Str::title($alamatDefault->Kabupaten->name) . ',';
            $alamat .= Str::title($alamatDefault->Provinsi->name);
            $alamat .= isset($alamatDefault->kode_pos) ? ', ' . $alamatDefault->kode_pos . '.' : '.';
        }
        return $alamat;
    }
    // Generate Kode Perusahaan
    public static function genKodePerusahaan($jp)
    {
        $tahun = date('Y');
        $jumlahPermohonan = Perusahaan::whereYear("created_at", $tahun)->withTrashed()->count();
        if ($jumlahPermohonan > 0) {
            $nomorUrut = (int) $jumlahPermohonan + 1;
        } else {
            $nomorUrut = 1;
        }

        if ($jp == "Perusahaan") {
            // Perusahaan
            $kode = "10";
            $kode .= date('ny');
            // $kode .= "-" . Str::upper(Self::gencode(2));
            $kode .= Self::genzero(4, $nomorUrut);
        } else {
            // Pemilik UTTP
            $kode = "11";
            $kode .= date('ny');
            // $kode .= "-" . Str::upper(Self::gencode(2));
            $kode .= Self::genzero(4, $nomorUrut);
        }
        return $kode;
    }
    // Generate Kode Permohonan
    public static function genKodePermohonan($jp)
    {
        // cek jumlah permohonan bulan aktif
        $jumlahPermohonan = PermohonanPeneraan::whereMonth("created_at", date('m'))->count();
        if ($jumlahPermohonan == "0") {
            $jumlahPermohonan = "1";
        } else {
            $data = [];
            $PermohonanPeneraan = PermohonanPeneraan::select(\DB::raw("SUBSTRING_INDEX(kode_permohonan, '-', -1) as kode"))
                ->whereMonth("created_at", date('m'))
                ->withTrashed()
                ->get();
            foreach ($PermohonanPeneraan as $item) {
                $convert_kode = (int) $item->kode;
                $item->kode = $convert_kode;
                $data[] = $item;
            }
            $current_kode = max($data);
            $jumlahPermohonan = $current_kode->kode + 1;
        }
        if ($jp == "Tera") {
            $kode = "P.1.";
            $kode .= Self::bln2Romawi(date('n')) . "." . date('y');
            $kode .= "-" . Self::genzero(4, $jumlahPermohonan);
        } elseif ($jp == "Tera Ulang") {
            $kode = "P.2.";
            $kode .= Self::bln2Romawi(date('n')) . "." . date('y');
            $kode .= "-" . Self::genzero(4, $jumlahPermohonan);
        } elseif ($jp == "Pengujian BDKT") {
            $kode = "P.3.";
            $kode .= Self::bln2Romawi(date('n')) . "." . date('y');
            $kode .= "-" . Self::genzero(4, $jumlahPermohonan);
        }

        // cek kode
        $cekKode = PermohonanPeneraan::where("kode_permohonan", $kode)->withTrashed()->first();
        if ($cekKode !== null) {
            // ada duplikat
            $exkode = explode("-", $kode);
            $jumlahPermohonan = $exkode[1] + 1;
            $kode = $exkode[0];
            $kode .= "-" . Self::genzero(4, $jumlahPermohonan);
        }
        return $kode;
    }
    // Generate Nomor Order
    public static function genNomorOrder($kodeUttp)
    {
        $PdpPenjadwalan = PdpPenjadwalan::select(\DB::raw("SUBSTRING_INDEX(nomor_order, '/', 1) as kode"))
            ->where(\DB::raw("substr(SUBSTRING_INDEX(nomor_order, '/', 2), 6, 4)"), $kodeUttp)
            ->whereMonth("created_at", date('m'))
            ->withTrashed()
            ->orderBy(\DB::raw("SUBSTRING_INDEX(nomor_order, '/', 1)"), "DESC")
            ->first();
        if ($PdpPenjadwalan === null) {
            $jumlahOrder = "1";
        } else {
            $currentKode = PdpPenjadwalan::select(\DB::raw("SUBSTRING_INDEX(nomor_order, '/', 1) as kode"))
                ->where(\DB::raw("substr(SUBSTRING_INDEX(nomor_order, '/', 2), 6, 4)"), $kodeUttp)
                ->whereMonth("created_at", date('m'))
                ->withTrashed()
                ->orderBy(\DB::raw("SUBSTRING_INDEX(nomor_order, '/', 1)"), "DESC")
                ->get();
            foreach ($currentKode as $item) {
                $convert_kode = (int) $item->kode;
                $item->kode = $convert_kode;
                $data[] = $item;
            }
            $current_kode = max($data);
            $jumlahOrder = $current_kode->kode + 1;
        }

        // gen kode
        $kode = Self::genzero(4, $jumlahOrder);
        $kode .= "/" . $kodeUttp . "/";
        $kode .= Self::bln2Romawi(date('n')) . "/" . date('Y');

        // cek kode
        $cekKode = PdpPenjadwalan::where("nomor_order", $kode)->withTrashed()->first();
        if ($cekKode !== null) {
            // ada duplikat
            $exkode = explode("/", $kode);
            $jumlahOrder = $exkode[0] + 1;
            $kode = Self::genzero(4, $jumlahOrder);
            $kode .= "/" . $kodeUttp . "/";
            $kode .= Self::bln2Romawi(date('n')) . "/" . date('Y');
        }
        return $kode;
    }
    // Generate Kode TTE SKHP
    public static function genKodeTteSkhp($jenis_uttp, $status_apps)
    {
        $tahun = date('Y');
        $bulan = date('m');
        $ctte = TteSkhp::whereYear("tanggal_generate", $tahun)->whereMonth("tanggal_generate", $bulan)->where("status_apps", $status_apps)->count();
        if ($ctte == "0") {
            $ctte = 1;
        }
        if ($status_apps == "Schedule") {
            // Perusahaan
            $kode = "SCH";
            $kode .= date('dn');
            $kode .= $jenis_uttp;
            $kode .= Self::genzero(3, $ctte);
            $kode .= Self::gencode(2);
        } elseif ($status_apps == "Supervision") {
            // Pemilik UTTP
            $kode = "SPV";
            $kode .= date('dn');
            $kode .= $jenis_uttp;
            $kode .= Self::genzero(3, $ctte);
            $kode .= Self::gencode(2);
        }
        return Str::upper($kode);
    }

    /*
    |--------------------------------------------------------------------------
    | LIST APPS
    |--------------------------------------------------------------------------
     */
    // Generate Background
    public static function genPageBg()
    {
        // background
        $pageBg = Cache::get('pageBg');
        if ($pageBg === null) {
            $bgNumber = rand(1, 31);
            Cache::put('pageBg', $bgNumber, now()->addMinutes(1));
            $pageBg = $bgNumber;
        } else {
            $pageBg = $pageBg;
        }

        return $pageBg;
    }
    // get data alert verifikasi perusahaan
    public static function alertVerifikasiPerusahaan()
    {
        $allData = Perusahaan::where("file_npwp", "!=", null)
            ->where("verifikasi", "=", "0")
            ->orderBy("created_at", "DESC")
            ->get();
        $limitData = Perusahaan::where("file_npwp", "!=", null)
            ->where("verifikasi", "=", "0")
            ->orderBy("created_at", "DESC")
            ->limit(5)
            ->get();

        $data = [
            "all_data" => $allData,
            "limit_data" => $limitData,
        ];
        return $data;
    }
    // get data alert jadwal dan penugasan petugas
    public static function alertPDPPetugas($jp)
    {
        $auth = Auth::user();
        $uuid_profile = $auth->uuid_profile;
        $tahun = date('Y');
        $data = PdpPenjadwalan::join("permohonan_peneraan", "permohonan_peneraan.uuid", "=", "pdp_penjadwalan.uuid_permohonan")
            ->join("pdp_data_petugas", "pdp_data_petugas.uuid_penjadwalan", "=", "pdp_penjadwalan.uuid")
            ->select("pdp_penjadwalan.*")
            ->whereYear("pdp_penjadwalan.tanggal_peneraan", $tahun)
            ->where("pdp_penjadwalan.status_peneraan", "Menunggu")
            ->where("permohonan_peneraan.jenis_pengujian", $jp)
            ->orderBy("pdp_penjadwalan.tanggal_peneraan", "ASC")
            ->orderBy("pdp_penjadwalan.jam_peneraan", "ASC")
            ->where("pdp_data_petugas.uuid_pegawai", $uuid_profile)
            ->get();
        return $data;
    }

    /*
    |--------------------------------------------------------------------------
    | PENGATURAN APPS
    |--------------------------------------------------------------------------
     */
    // cek kategori master kategori kelompok
    public static function getKategoriStatus($value)
    {
        if ($value == "0") {
            $kategori = "Jenis UTTP";
        } elseif ($value == "1") {
            $kategori = "Alat Standar & Perlengkapannya";
        } elseif ($value == "2") {
            $kategori = "CTT";
        }
        return $kategori;
    }
    // cek kategori master fitur
    public static function getMasterFitur($nama_fitur)
    {
        $mstFitur = MasterFitur::where("nama_fitur", $nama_fitur)->first();
        return $mstFitur;
    }

    /*
    |--------------------------------------------------------------------------
    | PENGATURAN APPS
    |--------------------------------------------------------------------------
     */
    // Untuk Logo Aplikasi
    public static function logoApps()
    {
        $url = asset('assets-portal/dist/img/logo.png');
        return $url;
    }
    // Untuk Logo Aplikasi
    public static function logoSimegal()
    {
        $url = asset('assets-portal/dist/img/logo-color.png');
        return $url;
    }
    // Untuk Logo BANTJANA PATAKARAN PRALAJA KAPRADANAN
    // sumber: https: //metinsugm.blogspot.com/2014/08/makna-lambang.html
    public static function logoBPPK()
    {
        $url = asset('assets-portal/dist/img/logo-bp.png');
        return $url;
    }
    // get data petugas Tenaga Ahli Penera (tap)
    public static function getPetugasTAP($uuid_pdp)
    {
        $mstFitur = PdpDataPetugas::where("uuid_penjadwalan", $uuid_pdp)->where("jabatan_petugas", "Tenaga Ahli Penera")->get();
        return $mstFitur;
    }
    // get data petugas Pendamping Teknis (PT)
    public static function getPetugasPT($uuid_pdp)
    {
        $mstFitur = PdpDataPetugas::where("uuid_penjadwalan", $uuid_pdp)->where("jabatan_petugas", "Pendamping Teknis")->get();
        return $mstFitur;
    }
    // get dd list instrumen all
    public static function getListInstrumenAll()
    {
        $data = MasterInstrumenDaftarItemUttp::join("master_instrumen_jenis_uttp", "master_instrumen_jenis_uttp.uuid", "=", "master_instrumen_daftar_item_uttp.uuid_instrumen_jenis_uttp")
            ->select("master_instrumen_daftar_item_uttp.*")
            ->orderBy("master_instrumen_jenis_uttp.no_urut", "ASC")
            ->orderBy("master_instrumen_daftar_item_uttp.no_urut", "ASC")
            ->get();
        return $data;
    }
    // get dd list instrumen group by jenis_uttp
    public static function getListInstrumenGByJenisUttp()
    {
        $data = MasterInstrumenDaftarItemUttp::join("master_instrumen_jenis_uttp", "master_instrumen_jenis_uttp.uuid", "=", "master_instrumen_daftar_item_uttp.uuid_instrumen_jenis_uttp")
            ->select("master_instrumen_jenis_uttp.*")
            ->orderBy("master_instrumen_jenis_uttp.no_urut", "ASC")
            ->orderBy("master_instrumen_daftar_item_uttp.no_urut", "ASC")
            ->groupBy("master_instrumen_jenis_uttp.nama_jenis_uttp")
            ->get();
        return $data;
    }
    // get dd list instrumen group by group_instrumen
    public static function getListInstrumenGByGroupInstrumen()
    {
        $data = MasterInstrumenDaftarItemUttp::join("master_instrumen_jenis_uttp", "master_instrumen_jenis_uttp.uuid", "=", "master_instrumen_daftar_item_uttp.uuid_instrumen_jenis_uttp")
            ->select("master_instrumen_daftar_item_uttp.*")
            ->orderBy("master_instrumen_jenis_uttp.no_urut", "ASC")
            ->orderBy("master_instrumen_daftar_item_uttp.no_urut", "ASC")
            ->groupBy("master_instrumen_daftar_item_uttp.group_instrumen")
            ->get();
        return $data;
    }
    // get dd list instrumen all
    public static function getListInstrumenByJenisUttp($uuid_uttp)
    {
        $data = MasterInstrumenDaftarItemUttp::where("uuid_instrumen_jenis_uttp", $uuid_uttp)
            ->orderBy("no_urut", "ASC")
            ->get();
        return $data;
    }
    // get dd list alat
    public static function getListAlat($jp, $tagsUttp)
    {
        $jenisPengujian = $jp;
        $uuid_kelompok_uttp = $tagsUttp;
        $data = MasterKategoriKelompok::join("master_jenis_pelayanan", "master_jenis_pelayanan.uuid", "=", "master_kategori_kelompok.uuid_jenis_pelayanan")
            ->join("master_kelompok_uttp", "master_kelompok_uttp.uuid", "=", "master_kategori_kelompok.uuid_kelompok_uttp")
            ->select("master_kategori_kelompok.*")
            ->where("master_jenis_pelayanan.nama_pelayanan", $jenisPengujian)
            ->where("master_kategori_kelompok.uuid_kelompok_uttp", $uuid_kelompok_uttp)
            ->orderBy("master_jenis_pelayanan.no_urut", "ASC")
            ->orderBy("master_kelompok_uttp.no_urut", "ASC")
            ->orderBy("master_kategori_kelompok.kategori", "ASC")
            ->orderBy("master_kategori_kelompok.no_urut", "ASC")
            ->get();
        return $data;
    }

    /*
    |--------------------------------------------------------------------------
    | WEBR HELPER
    |--------------------------------------------------------------------------
     */
    public static function webrSetHeader()
    {
        date_default_timezone_set("UTC");

        // $userid = \env('WEBR_USERID');
        $userid = "wssimegal";
        // $password = \env('WEBR_PASSWORD');
        $password = "XcILzDqjuMjXedGLnKCJRP3NVK79SVTfbWQmOrkpDsTgvIEtOAlogbEuYZUACp2y";

        $inttime = strval(time() - strtotime("1970-01-01 00:00:00"));

        $value = "$userid&$inttime";
        $key = $password;

        $signature = hash_hmac("sha256", $value, $key, true);
        $signature64 = base64_encode($signature);

        $headers = [
            "userid:$userid",
            "signature:$signature64",
            "key:$inttime",
        ];

        return $headers;
    }

    public static function webrSetInvoice(
        $id_perusahaan, $nama_perusahaan, $alamat_perusahaan, $biaya,
        $no_skrd, $tgl_skrd, $tgl_jatuh_tempo
    ) {
        $data = '
		{
			"departemen_kode" : "3.07.01.01",
            "departemen_nama" : "DINAS PERINDUSTRIAN DAN PERDAGANGAN",
            "objek_kode" : "' . $id_perusahaan . '",
            "objek_nama" : "Retribusi ' . $nama_perusahaan . '",
            "objek_alamat_1" : "' . $alamat_perusahaan . '",
            "objek_alamat_2" : "-",
            "produk_kode" : "4.1.2.01.46",
            "produk_nama" : "Retribusi Pelayanan Tera/Tera Ulang",
            "rekening_kode" : "4.1.2.01.46",
            "rekening_nama" : "Retribusi Pelayanan Tera/Tera Ulang",
            "pejabat_nm" : "IRWAN HENGKI, SH,. M.Si",
            "subjek_kode" : "' . $id_perusahaan . '",
            "subjek_nama" : "' . $nama_perusahaan . '",
            "subjek_alamat_1" : "' . $alamat_perusahaan . '",
            "subjek_alamat_2" : "-",
            "dasar" : "0",
            "tarif" : "1",
            "pokok" : "' . $biaya . '",
            "pengurang" : "0",
            "penambah" : "0",
            "setoran" : "0",
            "terutang" : "' . $biaya . '",
            "denda" : "0",
            "bunga" : "0",
            "jumlah" : "' . $biaya . '",
            "jenis" : "1",
            "jenis_penerimaan" : "1",
            "no_skrd" : "' . $no_skrd . '",
            "tgl_skrd" : "' . $tgl_skrd . '",
            "periode_1" : "' . $tgl_skrd . '",
            "periode_2" : "' . $tgl_skrd . '",
            "tgl_terima" : "' . $tgl_skrd . '",
            "jatuh_tempo" : "' . $tgl_jatuh_tempo . '"
        }';

        $params = '
        {
            "jsonrpc":"2.0",
            "method":"set_invoice",
            "params":{
                "data":' . $data . '
            },
            "id":1
        }';

        // $url = \env('WEBR_URL');
        $url = "https://webr.tangkab.dapda.id/api/webr";

        $headers = self::webrSetHeader();

        $session = curl_init($url);
        curl_setopt($session, CURLOPT_URL, $url);
        curl_setopt($session, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($session, CURLOPT_VERBOSE, true);
        curl_setopt($session, CURLOPT_POST, true);
        curl_setopt($session, CURLOPT_POSTFIELDS, $params);
        curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($session);

        return $response;
    }

    public static function webrGetPayment($kode_bayar)
    {
        $data = '
		{
			"kd_bayar" : "' . $kode_bayar . '"
        }';

        $params = '
        {
            "jsonrpc":"2.0",
            "method":"get_payment",
            "params":{
                "data":' . $data . '
            },
            "id":1
        }';

        $url = \env('WEBR_URL');
        $headers = self::webrSetHeader();

        $session = curl_init($url);
        curl_setopt($session, CURLOPT_URL, $url);
        curl_setopt($session, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($session, CURLOPT_VERBOSE, true);
        curl_setopt($session, CURLOPT_POST, true);
        curl_setopt($session, CURLOPT_POSTFIELDS, $params);
        curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($session);

        if ($response === false) {
            dd(curl_error($session));
        }

        return $response;
    }
}