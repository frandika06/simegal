<?php

namespace App\Http\Controllers\WebBase\WebAdmin\PortalApps\posts;

use App\Http\Controllers\Controller;
use App\Models\AppsCounter;
use App\Models\PortalBanner;
use App\Models\PortalFAQ;
use App\Models\PortalGaleri;
use App\Models\PortalPage;
use App\Models\PortalPesan;
use App\Models\PortalPost;
use App\Models\PortalUnduhan;
use App\Models\PortalVideo;

class PAStatistikController extends Controller
{
    // index
    public function index()
    {
        // widget
        $widget = [];
        $counter1 = AppsCounter::whereNamaApps("Portal Website")
            ->whereVisualTemplate("FE")
            ->whereDevice("web")
            ->whereDate("tanggal", date('Y-m-d'))
            ->first();
        $counter2 = AppsCounter::whereNamaApps("Portal Website")
            ->whereVisualTemplate("FE")
            ->whereDevice("web")
            ->whereMonth("tanggal", date('m'))
            ->whereYear("tanggal", date('Y'))
            ->sum("views");
        $counter3 = AppsCounter::whereNamaApps("Portal Website")
            ->whereVisualTemplate("FE")
            ->whereDevice("web")
            ->whereYear("tanggal", date('Y'))
            ->sum("views");
        $counter4 = AppsCounter::whereNamaApps("Portal Website")
            ->whereVisualTemplate("FE")
            ->whereDevice("web")
            ->sum("views");
        $widget['hari_ini'] = $counter1->views;
        $widget['bulan_ini'] = $counter2;
        $widget['tahun_ini'] = $counter3;
        $widget['total_kunjungan'] = $counter4;

        // tahun
        $tahun = date('Y');
        // data bulan chart
        $bulan = [
            "Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Ags", "Sep", "Okt", "Nov", "Des",
        ];
        // data counter
        $statBulan = [];
        for ($i = 1; $i <= 12; $i++) {
            $statBulan[] = AppsCounter::whereNamaApps("Portal Website")
                ->whereVisualTemplate("FE")
                ->whereDevice("web")
                ->whereMonth("tanggal", $i)
                ->whereYear("tanggal", $tahun)
                ->sum("views");
        }
        // data total post
        $portalPost = PortalPost::count();
        $portalPage = PortalPage::count();
        $portalBanner = PortalBanner::count();
        $portalGaleri = PortalGaleri::count();
        $portalVideo = PortalVideo::count();
        $portalUnduhan = PortalUnduhan::count();
        $portalPesan = PortalPesan::count();
        $portalFAQ = PortalFAQ::count();
        $statPost = [
            "portalPost" => $portalPost,
            "portalPage" => $portalPage,
            "portalBanner" => $portalBanner,
            "portalGaleri" => $portalGaleri,
            "portalVideo" => $portalVideo,
            "portalUnduhan" => $portalUnduhan,
            "portalPesan" => $portalPesan,
            "portalFAQ" => $portalFAQ,
        ];
        return view('pages.admin.portal_apps.statistik.index', compact(
            'tahun',
            'bulan',
            'statBulan',
            'statPost',
            'widget',
        ));
    }
}
