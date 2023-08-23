<?php

namespace App\Http\Controllers\WebBase\WebPortal;

use App\Http\Controllers\Controller;
use App\Models\PortalBanner;
use App\Models\PortalPost;

class HomeController extends Controller
{
    public function index()
    {
        // $response = Http::get('https://api.slingacademy.com/v1/sample-data/blog-posts?limit=3');
        // $posts = $response->object();
        // // IMG GALLERI 1
        // $offset = rand(0, 100);
        // $endpoint1 = "https://api.slingacademy.com/v1/sample-data/photos?offset=$offset&limit=5";
        // $response1 = Http::get($endpoint1);
        // $images1 = $response1->object();
        // $images1 = $images1->photos;

        // PortalBanner
        $PortalBanner = PortalBanner::whereStatus("Published")->orderBy("created_at", "DESC")->get();
        // PortalPost
        $PortalPost = PortalPost::whereStatus("Published")->orderBy("created_at", "DESC")->limit(6)->get();
        return view('pages.portal.home.index', compact(
            'PortalBanner',
            'PortalPost'
        ));
    }
}
