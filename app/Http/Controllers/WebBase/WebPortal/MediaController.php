<?php

namespace App\Http\Controllers\WebBase\WebPortal;

use App\Helpers\CID;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MediaController extends Controller
{
    // index
    public function index(Request $request, $tags)
    {
        $ar_tags = [
            "unduhan",
            "galeri",
            "video",
        ];
        if (!in_array($tags, $ar_tags)) {
            return \abort(404);
        }

        if ($tags == "unduhan") {
            return $this->indexUnduhan($request, $tags);
        } elseif ($tags == "galeri") {
            return $this->indexGaleri($request, $tags);
        } elseif ($tags == "video") {
            return $this->indexVideo($request, $tags);
        }
    }
    private function indexUnduhan($request, $tags)
    {
        $UcTags = CID::UcSlug($tags);
        $endpoint = "https://api.slingacademy.com/v1/sample-data/blog-posts?limit=30";
        $response = Http::get($endpoint);
        $posts = $response->object();
        $data = $posts->blogs;
        return view('pages.portal.media.index_unduhan', compact(
            'tags',
            'UcTags',
            'data'
        ));
    }
    private function indexGaleri($request, $tags)
    {
        $UcTags = CID::UcSlug($tags);
        $endpoint = "https://api.slingacademy.com/v1/sample-data/blog-posts?limit=2";
        $response = Http::get($endpoint);
        $posts = $response->object();
        $data = $posts->blogs;
        // IMG GALLERI 1
        $endpoint1 = "https://api.slingacademy.com/v1/sample-data/photos?offset=0&limit=3";
        $response1 = Http::get($endpoint1);
        $images1 = $response1->object();
        $images1 = $images1->photos;
        // IMG GALLERI 2
        $endpoint2 = "https://api.slingacademy.com/v1/sample-data/photos?offset=12&limit=3";
        $response2 = Http::get($endpoint2);
        $images2 = $response2->object();
        $images2 = $images2->photos;
        return view('pages.portal.media.index_galeri', compact(
            'tags',
            'UcTags',
            'data',
            'images1',
            'images2',
        ));
    }
    private function indexVideo($request, $tags)
    {
        $UcTags = CID::UcSlug($tags);
        $endpoint = "https://api.slingacademy.com/v1/sample-data/blog-posts?limit=4";
        $response = Http::get($endpoint);
        $posts = $response->object();
        $data = $posts->blogs;
        return view('pages.portal.media.index_video', compact(
            'tags',
            'UcTags',
            'data'
        ));
    }

    // readMedia
    public function readMedia(Request $request, $tags, $slug)
    {
        $ar_tags = [
            "unduhan",
            "galeri",
            "video",
        ];
        if (!in_array($tags, $ar_tags)) {
            return \abort(404);
        }

        if ($tags == "unduhan") {
            return $this->readMediaUnduhan($request, $tags, $slug);
        } elseif ($tags == "galeri") {
            return $this->readMediaGaleri($request, $tags, $slug);
        } elseif ($tags == "video") {
            return $this->readMediaVideo($request, $tags, $slug);
        }
    }
    private function readMediaUnduhan($request, $tags, $slug)
    {
        $UcTags = CID::UcSlug($tags);
        $endpoint = "https://api.slingacademy.com/v1/sample-data/blog-posts/" . $slug;
        $response = Http::get($endpoint);
        $posts = $response->object();
        $data = $posts->blog;
        return view('pages.portal.media.read_unduhan', compact(
            'data',
            'tags',
            'UcTags'
        ));
    }
    private function readMediaGaleri($request, $tags, $slug)
    {
        $UcTags = CID::UcSlug($tags);
        $endpoint = "https://api.slingacademy.com/v1/sample-data/blog-posts/" . $slug;
        $response = Http::get($endpoint);
        $posts = $response->object();
        $data = $posts->blog;
        // IMG GALLERI 1
        $offset = rand(0, 100);
        $endpoint1 = "https://api.slingacademy.com/v1/sample-data/photos?offset=$offset&limit=12";
        $response1 = Http::get($endpoint1);
        $images1 = $response1->object();
        $images1 = $images1->photos;
        return view('pages.portal.media.read_galeri', compact(
            'data',
            'tags',
            'UcTags',
            'images1'
        ));
    }
    private function readMediaVideo($request, $tags, $slug)
    {
        $UcTags = CID::UcSlug($tags);
        $endpoint = "https://api.slingacademy.com/v1/sample-data/blog-posts/" . $slug;
        $response = Http::get($endpoint);
        $posts = $response->object();
        $data = $posts->blog;
        return view('pages.portal.media.read_video', compact(
            'data',
            'tags',
            'UcTags'
        ));
    }
}
