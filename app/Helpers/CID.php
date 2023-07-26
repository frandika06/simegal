<?php

namespace App\Helpers;

use App\Models\DataKapitasi;
use App\Models\Jabatan;
use App\Models\PangkatGolongan;
use App\Models\Pegawai;
use App\Models\Pendidikan;
use App\Models\StatusKetenagaan;
use App\Models\SysLogAktifitas;
use Auth;
use Illuminate\Contracts\Session\Session;
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
        $nama = $auth->RelAdministrator->nama_lengkap;
        $pp = "https://ui-avatars.com/api/?name=$nama";
        return $pp;
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
            $url = asset('assets-portal/dist/img/no_image.jpg');
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
    // motivation
    public static function motivationDay()
    {
        /*
        SUMBER:
        https: //www.merdeka.com/jatim/100-kata-kata-inspiratif-tokoh-dunia-penuh-makna-bijak-dan-memotivasi-kln.html
         */
        $text = [
            '"Perjalanan seribu mil dimulai dengan satu langkah." - Lao Tzu',
            '"Kesuksesan dan kebahagiaan terletak pada diri sendiri. Tetaplah berbahagia, dan kebahagiaanmu dan kamu akan membentuk sebuah karakter kuat melawan kesulitan." - Helen Keller',
            '"Kita harus berarti untuk diri kita sendiri dulu sebelum kita menjadi orang yang berharga bagi orang lain." - Ralph Waldo Emerson',
            '"Beberapa orang akan pergi dari hidupmu, tapi itu bukan akhir dari ceritamu. Itu cuma akhir dari bagian mereka di ceritamu." - Faraaz Kazi',
            '"Seseorang tak akan pernah tahu betapa dalam kadar cintanya sampai terjadi sebuah perpisahan." - Kahlil Gibran',
            '"Cinta itu seperti angin. Kau tak dapat melihatnya, tapi kau dapat merasakannya." - Nicholas Sparks',
            '"Sebelum apapun, persiapan adalah kunci menuju kesuksesan." - Alexander Graham Bell',
            '"Penemuan terbesar sepanjang masa adalah bahwa seseorang bisa mengubah masa depannya hanya dengan mengubah sikapnya saat ini." - Oprah Winfrey',
            '"Satu-satunya sumber dari pengetahuan adalah pengalaman." - Albert Einstein',
            '"Kesenangan dalam sebuah pekerjaan membuat kesempurnaan pada hasil yang dicapai." - Aristoteles',
            '"Yang membuatku terus berkembang adalah tujuan-tujuan hidupku." - Muhammad Ali',
            '"Kita tidak menjadi wadah peleburan, tetapi menjadi mosaik yang indah. Beda orang, beda keyakinan, beda kerinduan, beda harapan, beda mimpi." — Jimmy Carter',
            '"Menjalani sebuah pengalaman, takdir tertentu, adalah menerimanya sepenuhnya." — Albert Camus',
            '"Ketika mencapai ujung tali, ikat simpul di dalamnya dan bertahanlah." -Franklin D. Roosevelt',
            '"Tidak masalah seberapa lambat kau berjalan asalkan kau tidak berhenti." - Confucius',
            '"Kesuksesan dan kegagalan adalah sama-sama bagian dalam hidup. Keduanya hanyalah sementara." - Shah Rukh Khan',
            '"Beri nilai dari usahanya jangan dari hasilnya. Baru kita bisa menilai kehidupan." - Albert Einstein',
            '"Hitunglah umurmu dengan teman, bukan tahun. Hitunglah hidupmu dengan senyum, bukan air mata." - John Lennon',
            '"Diam adalah sumber dari kekuatan yang luar biasa." - Lao Tzu',
            '"Kesempatan emas yang kamu cari ada di dalam dirimu." - Orison Sweet Marden',
            '"Segala yang dapat kamu bayangkan adalah nyata." - Pablo Picasso',
            '"Jika kamu kehilangan seseorang, tapi menemukan dirimu yang sebenarnya, kamu menang." - Paulo Coelho',
            '"Untuk mata yang cantik, lihatlah kebaikan orang lain; untuk bibir yang indah, berkatalah dalam kebaikan; dan ketenangan diri, berjalanlah dengan pengetahuan bahwa kamu tidak pernah sendiri." - Audrey Hepburn',
            '"Kamu akan menghadapi banyak kekalahan dalam hidup, tetapi jangan biarkan dirimu dikalahkan." -Maya Angelou',
            '"Hidup tidak pernah adil, dan mungkin itu hal yang baik bagi kebanyakan dari kita bahwa itu tidak adil." - Oscar Wilde',
            '"Janganlah engkau mengucapkan perkataan yang engkau sendiri tak suka mendengarnya jika orang lain mengucapkannya kepadamu." - Ali bin Abi Thalib',
            '"Kamu tidak pernah terlalu tua untuk menetapkan tujuan lain atau untuk memimpikan impian baru." - C. S. Lewis',
            '"Masa depan adalah milik mereka yang percaya pada keindahan impian mereka." - Eleanor Roosevelt',
            '"Tidak ada yang bisa membuatmu merasa rendah diri tanpa seizinmu." - Eleanor Roosevelt',
            '"Aku tidak takut badai, karena itu aku belajar berlayar dengan kapalku." - Louisa May Alcott',
            '"Jika kita semua melakukan hal-hal yang mampu kita lakukan, kita akan benar-benar mengejutkan diri kita sendiri." - Thomas Edison',
            '"Jika kamu tidak suka jalan yang kamu lewati, mulailah membuat jalan lain." - Dolly Parton',
            '"Hidup itu seperti mengendarai sepeda. Untuk menjaga keseimbangan, kamu harus terus bergerak." - Albert Einstein',
            '"Kehidupan yang tidak diuji tidak layak untuk dijalani." - Socrates',
            '"Kamu tidak bisa kembali dan mengubah awal, tetapi kamu bisa mulai di mana kamu berada dan mengubah akhirnya." - C.S. Lewis',
            '11. "Hidup adalah apa yang terjadi ketika kamu sibuk membuat rencana lain." - John Lennon',
            '"Cintai hidup yang kau jalani. Jalani hidup yang kau cintai." -Bob Marley',
            '"Lakukan semua yang kamu bisa, untuk semua orang yang kamu temui, dengan semua cara yang kamu bisa, selama kamu bisa." - Hillary Clinton',
            '"Hidup memaksakan hal-hal padamu yang tidak dapat kamu kendalikan, tetapi kamu masih punya pilihan tentang bagaimana kamu akan menjalaninya." - Celine Dion',
            '"Jangan puas dengan hidup yang diberikan, buat hidup lebih baik dan bangun sesuatu. "- Ashton Kutcher',
            '"Jangan takut hidup. Percayalah bahwa hidup ini layak dijalani, dan kepercayaanmu akan membantu menciptakan fakta. " - William James',
            '"Kau tidak akan pernah bisa merencanakan masa depan di masa lalu." —Edmund Burke',
            '"Tujuan hidup kita adalah untuk bahagia." — Dalai Lama',
            '"Kamu hanya hidup sekali, tetapi jika kamu melakukannya dengan benar, sekali saja sudah cukup." — Mae West',
            '"Banyak dari kegagalan hidup adalah orang-orang yang tidak menyadari seberapa dekat mereka dengan kesuksesan ketika mereka menyerah." - Thomas A. Edison',
            '"Jika Anda ingin hidup bahagia, ikatlah pada tujuan, bukan pada orang atau benda." - Albert Einstein',
            '"Uang dan kesuksesan tidak mengubah orang; mereka hanya memperkuat apa yang sudah ada." — Will Smith',
            '"Hidup terbuat dari begitu banyak bagian yang dilas menjadi satu." -Charles Dickens',
            '"Sukses bukanlah final; kegagalan tidak fatal: Ini adalah keberanian untuk melanjutkan yang penting." -Winston S. Churchill',
        ];
        // cek session
        $tgl = date('Y-m-d');
        if (session()->exists('tgl_motivation')) {
            $day_motivation = session()->get('day_motivation');
            $tgl_motivation = session()->get('tgl_motivation');
            if ($tgl != $tgl_motivation) {
                $ctext = count($text);
                $select = rand(1, $ctext);
                $day_motivation = $text[$select];
                session()->put('tgl_motivation', $tgl);
                session()->put('day_motivation', $day_motivation);
                $result = $day_motivation;
            } else {
                $result = $day_motivation;
            }
        } else {
            $ctext = count($text);
            $select = rand(1, $ctext);
            $day_motivation = $text[$select];
            session()->put('tgl_motivation', $tgl);
            session()->put('day_motivation', $day_motivation);
            $result = $day_motivation;
        }
        return $result;
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
            $file_name = $file_name . "-" . rand(1000, 9999999999) . "-[JASPEL]." . Str::lower($ext);
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
                $image_name = $folder . "/" . Self::gencode(3) . "-" . date('dmy') . "-" . rand(1000, 9999999) . "-" . $k . '-[JASPEL].png';
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
                $image_name = $folder . "/" . Self::gencode(3) . "-" . date('dmy') . "-" . rand(1000, 9999999) . "-" . $k . '-[JASPEL].png';
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
        // User
        $user = Auth::user();
        // Log
        $log = [];
        $log['uuid'] = Str::uuid();
        $log['uuid_profile'] = $user->uuid_profile;
        $log['email'] = $user->email;
        $log['apps'] = $detail['apps'];
        $log['role'] = $user->role;
        $log['subjek'] = $detail['subjek'];
        $log['method'] = $request->method();
        $log['ip'] = $request->ip();
        $log['agent'] = $request->header('user-agent');
        $log['url'] = $request->fullUrl();
        $log['aktifitas'] = json_encode($detail['aktifitas']);
        $log['device'] = $detail['device'];
        SysLogAktifitas::create($log);
    }
    // get NomorUrutL
    public static function getNomorUrut($uuid_instansi)
    {
        $data = Pegawai::whereUuidInstansi($uuid_instansi)->max('nomor_urut');
        if ($data !== null) {
            $result = $data + 1;
        } else {
            $result = 1;
        }
        return $result;
    }
    // get PangkatGolongan ALL
    public static function getPangkatGolonganAll()
    {
        $data = PangkatGolongan::whereStatus("1")->orderBy("id")->get();
        if ($data !== null) {
            $result = $data;
        } else {
            $result = null;
        }
        return $result;
    }
    // get PangkatGolongan
    public static function getPangkatGolongan($id)
    {
        $data = PangkatGolongan::whereId($id)->whereStatus("1")->first();
        if ($data !== null) {
            $result = $data;
        } else {
            $result = null;
        }
        return $result;
    }
    // get Jabatan All
    public static function getJabatanAll()
    {
        $data = Jabatan::whereStatus("1")->orderBy("id")->get();
        if ($data !== null) {
            $result = $data;
        } else {
            $result = null;
        }
        return $result;
    }
    // get Jabatan
    public static function getJabatan($id)
    {
        $data = Jabatan::whereId($id)->whereStatus("1")->first();
        if ($data !== null) {
            $result = $data;
        } else {
            $result = null;
        }
        return $result;
    }
    // get Pendidikan All
    public static function getPendidikanAll()
    {
        $data = Pendidikan::whereStatus("1")->orderBy("id")->get();
        if ($data !== null) {
            $result = $data;
        } else {
            $result = null;
        }
        return $result;
    }
    // get Pendidikan
    public static function getPendidikan($id)
    {
        $data = Pendidikan::whereId($id)->whereStatus("1")->first();
        if ($data !== null) {
            $result = $data;
        } else {
            $result = null;
        }
        return $result;
    }
    // get Status Ketenagaan All
    public static function getStatusKetenagaanAll()
    {
        $data = StatusKetenagaan::whereStatus("1")->orderBy("id")->get();
        if ($data !== null) {
            $result = $data;
        } else {
            $result = null;
        }
        return $result;
    }
    // get Status Ketenagaan
    public static function getStatusKetenagaan($id)
    {
        $data = StatusKetenagaan::whereId($id)->whereStatus("1")->first();
        if ($data !== null) {
            $result = $data;
        } else {
            $result = null;
        }
        return $result;
    }
    // get Data Pegawai
    public static function getPegawai($uuid_instansi)
    {
        $data = Pegawai::whereUuidInstansi($uuid_instansi)->whereStatus("1")->orderBy("nomor_urut", "ASC")->get();
        if ($data !== null) {
            $result = $data;
        } else {
            $result = null;
        }
        return $result;
    }
    // get Data Pegawai
    public static function getPegawaiJasPel($kapitasi)
    {
        $uuid_instansi = $kapitasi->uuid_instansi;
        $uuid_kapitasi = $kapitasi->uuid;

        $data = Pegawai::whereUuidInstansi($uuid_instansi)->whereStatus("1")->whereNotIn('uuid', function ($query) use ($uuid_kapitasi) {
            $query->select('uuid_pegawai')->from('data_kapitasi')->where('uuid_kapitasi', $uuid_kapitasi)->where('deleted_at', null);
        })->orderBy("nomor_urut", "ASC")->get();

        if ($data !== null) {
            $result = $data;
        } else {
            $result = null;
        }
        return $result;
    }
    // get jumlah Total
    public static function getSumJmlTotal($uuid_kapitasi)
    {
        $result = DataKapitasi::whereUuidKapitasi($uuid_kapitasi)->where("deleted_at", null)->sum('jml_total');
        return $result;
    }
    // get Jumlah Hari Kerja dalam 1 Bulan
    public static function jmlHariKerja1Bulan($year, $month)
    {
        $weekdays = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday');
        $count = 0;
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $currentDay = date('l', strtotime("$year-$month-$day"));

            if (in_array($currentDay, $weekdays)) {
                $count++;
            }
        }
        return $count;
    }
    // get Jumlah tahun kerja
    public static function jmlTahunKerja($tahun)
    {
        $currentYear = date('Y');
        $yearDiff = $currentYear - $tahun;
        return $yearDiff;
    }
    // get Nilai Masa Kerja dari Aturan PERATURAN MENTERI KESEHATAN REPUBLIK INDONESIA NOMOR 6 TAHUN 2022
    public static function getMasaKerja($jml_tahun)
    {
        /*
        a. kurang dari 5 (lima) tahun, diberi tambahan nilai 2
        (dua);
        b. 5 (lima) tahun sampai dengan 10 (sepuluh) tahun,
        diberi tambahan nilai 5 (lima);
        c. 11 (sebelas) tahun sampai dengan 15 (lima belas)
        tahun, diberi tambahan nilai 10 (sepuluh);
        d. 16 (enam belas) tahun sampai dengan 20 (dua
        puluh) tahun, diberi tambahan nilai 15 (lima belas);
        e. 21 (dua puluh satu) tahun sampai dengan 25 (dua
        puluh lima) tahun, diberi tambahan nilai 20 (dua
        puluh); dan
        f. lebih dari 25 (dua puluh lima) tahun, diberi
        tambahan nilai 25 (dua puluh lima).
         */
        if ($jml_tahun > 25) {
            $result = 25;
        } elseif ($jml_tahun >= 21 && $jml_tahun <= 25) {
            $result = (int) 20;
        } elseif ($jml_tahun >= 16 && $jml_tahun <= 20) {
            $result = (int) 15;
        } elseif ($jml_tahun >= 11 && $jml_tahun <= 15) {
            $result = (int) 10;
        } elseif ($jml_tahun >= 5 && $jml_tahun <= 10) {
            $result = (int) 5;
        } elseif ($jml_tahun < 5) {
            $result = (int) 2;
        }
        return $result;
    }
    // get last ID table
    public static function getLastID($tables)
    {
        if ($tables == "pangkat_golongan") {
            $data = PangkatGolongan::orderBy("id", "DESC")->withTrashed()->first();
            if ($data === null) {
                $id = 1;
            } else {
                $id = $data->id + 1;
            }
        } elseif ($tables == "jabatan") {
            $data = Jabatan::orderBy("id", "DESC")->withTrashed()->first();
            if ($data === null) {
                $id = 1;
            } else {
                $id = $data->id + 1;
            }
        } elseif ($tables == "pendidikan") {
            $data = Pendidikan::orderBy("id", "DESC")->withTrashed()->first();
            if ($data === null) {
                $id = 1;
            } else {
                $id = $data->id + 1;
            }
        } elseif ($tables == "status_ketenagaan") {
            $data = StatusKetenagaan::orderBy("id", "DESC")->withTrashed()->first();
            if ($data === null) {
                $id = 1;
            } else {
                $id = $data->id + 1;
            }
        } else {
            $id = 1;
        }

        return $id;
    }
    // get last ID table
    public static function getFullName($first, $middle, $last)
    {
        // first name
        if ($first != "") {
            $name = $first . ". ";
        } else {
            $name = "";
        }

        //  middle name
        $name .= $middle;

        // last name
        if ($last != "") {
            $name .= ", " . $last;
        } else {
            $name .= "";
        }

        return $name;
    }
    // get Data Pegawai
    public static function getPegawaiIW($kapitasi)
    {
        $uuid_instansi = $kapitasi->uuid_instansi;
        $uuid_kapitasi = $kapitasi->uuid;

        $data = Pegawai::whereUuidInstansi($uuid_instansi)->whereStatus("1")->whereNotIn('uuid', function ($query) use ($uuid_kapitasi) {
            $query->select('uuid_pegawai')->from('data_iw')->where('uuid_kapitasi', $uuid_kapitasi)->where('deleted_at', null);
        })->orderBy("nomor_urut", "ASC")->get();

        if ($data !== null) {
            $result = $data;
        } else {
            $result = null;
        }
        return $result;
    }
}
