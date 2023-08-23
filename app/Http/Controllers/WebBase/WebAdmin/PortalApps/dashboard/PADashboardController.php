<?php

namespace App\Http\Controllers\WebBase\WebAdmin\PortalApps\dashboard;

use App\Helpers\CID;
use App\Http\Controllers\Controller;
use App\Models\PortalBanner;
use App\Models\PortalFAQ;
use App\Models\PortalGaleri;
use App\Models\PortalPage;
use App\Models\PortalPost;
use App\Models\PortalUnduhan;
use App\Models\PortalVideo;
use DataTables;
use Illuminate\Http\Request;

class PADashboardController extends Controller
{
    //index
    public function index(Request $request)
    {
        // data
        $kategori = [];
        $url = [];
        $draft = [];
        $published = [];
        $unpublish = [];
        $data = [];

        // Postingan
        $kategori[] = "Postingan";
        $url[] = \route('prt.apps.post.index');
        $draft[] = PortalPost::whereStatus("Draft")->count();
        $published[] = PortalPost::whereStatus("Published")->count();
        $unpublish[] = PortalPost::whereStatus("Unpublish")->count();
        // Halaman
        $kategori[] = "Halaman";
        $url[] = \route('prt.apps.page.index');
        $draft[] = PortalPage::whereStatus("Draft")->count();
        $published[] = PortalPage::whereStatus("Published")->count();
        $unpublish[] = PortalPage::whereStatus("Unpublish")->count();
        // Banner
        $kategori[] = "Banner";
        $url[] = \route('prt.apps.banner.index');
        $draft[] = PortalBanner::whereStatus("Draft")->count();
        $published[] = PortalBanner::whereStatus("Published")->count();
        $unpublish[] = PortalBanner::whereStatus("Unpublish")->count();
        // Galeri
        $kategori[] = "Galeri";
        $url[] = \route('prt.apps.gallery.index');
        $draft[] = PortalGaleri::whereStatus("Draft")->count();
        $published[] = PortalGaleri::whereStatus("Published")->count();
        $unpublish[] = PortalGaleri::whereStatus("Unpublish")->count();
        // Video
        $kategori[] = "Video";
        $url[] = \route('prt.apps.video.index');
        $draft[] = PortalVideo::whereStatus("Draft")->count();
        $published[] = PortalVideo::whereStatus("Published")->count();
        $unpublish[] = PortalVideo::whereStatus("Unpublish")->count();
        // Unduhan
        $kategori[] = "Unduhan";
        $url[] = \route('prt.apps.unduh.index');
        $draft[] = PortalUnduhan::whereStatus("Draft")->count();
        $published[] = PortalUnduhan::whereStatus("Published")->count();
        $unpublish[] = PortalUnduhan::whereStatus("Unpublish")->count();
        // FAQ
        $kategori[] = "FAQ";
        $url[] = \route('prt.apps.faq.index');
        $draft[] = PortalFAQ::whereStatus("Draft")->count();
        $published[] = PortalFAQ::whereStatus("Published")->count();
        $unpublish[] = PortalFAQ::whereStatus("Unpublish")->count();

        // count
        $ckategori = count($kategori);
        for ($i = 0; $i < $ckategori; $i++) {
            $data[$i] = [
                "kategori" => $kategori[$i],
                "url" => $url[$i],
                "draft" => CID::toDot($draft[$i]),
                "published" => CID::toDot($published[$i]),
                "unpublish" => CID::toDot($unpublish[$i]),
            ];
        }

        if ($request->ajax()) {
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('kategori', function ($data) {
                    $kategori = '<a href="' . $data['url'] . '">' . $data['kategori'] . '</a>';
                    return $kategori;
                })
                ->setRowId('uuid')
                ->escapeColumns([''])
                ->make(true);
        }
        return view('pages.admin.portal_apps.dashboard.index');
    }
}
