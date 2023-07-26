<?php

namespace App\Http\Controllers\WebBase\WebPortal;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    public function index()
    {
        $response = Http::get('https://api.slingacademy.com/v1/sample-data/blog-posts?limit=3');
        $posts = $response->object();
        // IMG GALLERI 1
        $offset = rand(0, 100);
        $endpoint1 = "https://api.slingacademy.com/v1/sample-data/photos?offset=$offset&limit=5";
        $response1 = Http::get($endpoint1);
        $images1 = $response1->object();
        $images1 = $images1->photos;
        return view('pages.portal.home.index', compact(
            'posts',
            'images1'
        ));
    }
}
