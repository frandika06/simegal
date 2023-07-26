<?php

namespace App\Http\Controllers\WebBase\WebPortal;

use App\Helpers\CID;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PostController extends Controller
{
    // index
    public function index(Request $request, $tags)
    {
        $UcTags = CID::UcSlug($tags);
        $response = Http::get('https://api.slingacademy.com/v1/sample-data/blog-posts?limit=30');
        $posts = $response->object();
        return view('pages.portal.post.index', compact(
            'posts',
            'tags',
            'UcTags'
        ));
    }

    // readPost
    public function readPost(Request $request, $tags, $slug)
    {
        $UcTags = CID::UcSlug($tags);
        $endpoint = "https://api.slingacademy.com/v1/sample-data/blog-posts/" . $slug;
        $response = Http::get($endpoint);
        $posts = $response->object();
        $data = $posts->blog;
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
        // post
        $endpointPosts = "https://api.slingacademy.com/v1/sample-data/blog-posts/1";
        $responsePosts = Http::get($endpointPosts);
        $posts = $responsePosts->object();
        $dataPosts = $posts->blog;

        // users
        $endpointUsers = "https://dummyjson.com/users";
        $responseUsers = Http::get($endpointUsers);
        $users = $responseUsers->object();
        $dataUsers = $users->users;

        if ($slug == "tentang-kami") {
            $page = "pages.portal.post.page_about";
        } elseif ($slug == "kontak-kami") {
            $page = "pages.portal.post.page_contact";
        } elseif ($slug == "frequently-asked-questions") {
            $page = "pages.portal.post.page_faq";
        } else {
            $page = "pages.portal.post.page";
        }

        return view($page, compact(
            'slug',
            'UcSlug',
            'dataPosts',
            'dataUsers',
        ));

    }

    // searchPost
    public function searchPost(Request $request)
    {
        $q = $request->q;
        $UcKeys = CID::UcSlug($q);

        return view('pages.portal.post.page_search', compact(
            'UcKeys'
        ));
    }
}
