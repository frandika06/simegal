<?php

namespace App\Http\Controllers\WebBase\WebPortal;

use App\Helpers\CID;
use App\Http\Controllers\Controller;
use App\Models\PortalFAQ;
use App\Models\PortalPage;
use App\Models\PortalPesan;
use App\Models\PortalPost;
use App\Models\PortalUnduhan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use \stdClass;

class PostController extends Controller
{
    // index
    public function index(Request $request, $tags)
    {
        $UcTags = CID::UcSlug($tags);
        $PortalPost = PortalPost::whereStatus("Published")
            ->whereRaw("kategori LIKE '%$tags%'")
            ->orderBy("created_at", "DESC")
            ->simplePaginate(6);
        return view('pages.portal.post.index', compact(
            'PortalPost',
            'tags',
            'UcTags'
        ));
    }

    // readPost
    public function readPost(Request $request, $tags, $slug)
    {
        $UcTags = CID::UcSlug($tags);
        $data = PortalPost::whereStatus("Published")
            ->whereRaw("kategori LIKE '%$tags%'")
            ->whereSlug($slug)
            ->orderBy("created_at", "DESC")
            ->firstOrFail();

        // update views
        $views = $data->views + 1;
        $data->update(["views" => $views]);
        return view('pages.portal.post.read', compact(
            'data',
            'tags',
            'UcTags'
        ));
    }

    // staticPage
    public function staticPage(Request $request, $slug)
    {
        $UcSlug = CID::UcSlug($slug);
        if ($slug == "kontak-kami") {
            $page = "pages.portal.post.page_contact";
            $data = null;
        } elseif ($slug == "faq") {
            // cek pages
            $data = PortalFAQ::whereStatus("Published")
                ->orderBy("created_at", "DESC")
                ->get();
            $page = "pages.portal.post.page_faq";
        } else {
            // cek pages
            $data = PortalPage::whereStatus("Published")
                ->whereSlug($slug)
                ->orderBy("created_at", "DESC")
                ->firstOrFail();
            // update views
            $views = $data->views + 1;
            $data->update(["views" => $views]);
            $page = "pages.portal.post.page";
        }

        return view($page, compact(
            'slug',
            'UcSlug',
            'data',
        ));

    }

    // searchPost
    public function searchPost(Request $request)
    {
        $q = $request->q;
        $UcKeys = CID::UcSlug($q);
        $data = [];

        // cek postingan
        $PortalPost = PortalPost::whereStatus("Published")
            ->whereRaw("judul LIKE '%$q%'")
            ->orderBy("created_at", "DESC")
            ->get();
        if (!empty($PortalPost)) {
            foreach ($PortalPost as $item) {
                $tags = explode(',', $item->kategori);
                $hasil = new StdClass();
                $hasil->judul = $item->judul;
                $hasil->url = route('prt.post.read', [$tags[0], $item->slug]);
                $hasil->tanggal = CID::hariTgl($item->tanggal);
                $data[] = $hasil;
            }
        }

        // cek halaman
        $PortalPage = PortalPage::whereStatus("Published")
            ->whereRaw("judul LIKE '%$q%'")
            ->orderBy("created_at", "DESC")
            ->get();
        if (!empty($PortalPage)) {
            foreach ($PortalPage as $item) {
                $hasil = new StdClass();
                $hasil->judul = $item->judul;
                $hasil->url = route('prt.page.index', [$item->slug]);
                $hasil->tanggal = CID::hariTgl($item->created_at);
                $data[] = $hasil;
            }
        }

        // cek unduhan
        $PortalUnduhan = PortalUnduhan::whereStatus("Published")
            ->whereRaw("judul LIKE '%$q%'")
            ->orderBy("created_at", "DESC")
            ->get();
        if (!empty($PortalUnduhan)) {
            foreach ($PortalUnduhan as $item) {
                $hasil = new StdClass();
                $hasil->judul = $item->judul;
                $hasil->url = route('prt.media.unduh.read', [$item->slug]);
                $hasil->tanggal = CID::hariTgl($item->tanggal);
                $data[] = $hasil;
            }
        }

        return view('pages.portal.post.page_search', compact(
            'UcKeys',
            'data'
        ));
    }

    // kirimPesan
    public function kirimPesan(Request $request)
    {
        // validate
        $request->validate([
            "nama_lengkap" => "required|string|max:100",
            "no_telp" => "required|string|max:100",
            "email" => "required|string|max:100",
            "subjek" => "required|string|max:300",
            "pesan" => "required|string|max:5000",
        ]);

        // cek data
        $email = $request->email;
        $no_telp = $request->no_telp;
        $tgl_sekarang = date('Y-m-d');
        $cekData = PortalPesan::whereEmail($email)
            ->whereDate("created_at", $tgl_sekarang)
            ->orWhere("no_telp", $no_telp)
            ->whereDate("created_at", $tgl_sekarang)
            ->first();
        if ($cekData !== null) {
            // sudah kirim pesan hari ini
            alert()->error('Ditolak', "Anda Sudah Mengimkan Pesan Hari Ini, Coba Lagi Besok!");
            return \redirect()->route('prt.page.index', ["kontak-kami"]);
        }

        // value
        $uuid = Str::uuid();
        $value_1 = [
            "uuid" => $uuid,
            "nama_lengkap" => $request->nama_lengkap,
            "no_telp" => $request->no_telp,
            "email" => Str::lower($request->email),
            "subjek" => $request->subjek,
            "pesan" => nl2br($request->pesan),
            "status" => "Unread",
        ];
        // save
        $save_1 = PortalPesan::create($value_1);
        if ($save_1) {
            // alert success
            alert()->success('Success', "Berhasil Mengirim Pesan!");
            return \redirect()->route('prt.page.index', ["kontak-kami"]);
        } else {
            alert()->error('Error', "Gagal Mengirim Pesan!");
            return \back()->withInput($request->all());
        }
    }
}
