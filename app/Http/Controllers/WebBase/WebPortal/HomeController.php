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
        return view('pages.portal.home.index', compact('posts'));
    }
}
