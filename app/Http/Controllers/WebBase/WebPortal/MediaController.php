<?php

namespace App\Http\Controllers\WebBase\WebPortal;

use App\Helpers\CID;
use App\Http\Controllers\Controller;
use App\Models\PortalGaleri;
use App\Models\PortalUnduhan;
use App\Models\PortalVideo;

class MediaController extends Controller
{
    // tagsUnduhan
    public function tagsUnduhan($tags = null)
    {
        $UcTags = CID::UcSlug($tags);
        if ($tags !== null) {
            $data = PortalUnduhan::whereStatus("Published")
                ->whereRaw("kategori LIKE '%$tags%'")
                ->orderBy("created_at", "DESC")
                ->simplePaginate(6);
        } else {
            $data = PortalUnduhan::whereStatus("Published")
                ->orderBy("created_at", "DESC")
                ->simplePaginate(6);
        }
        return view('pages.portal.media.index_unduhan', compact(
            'tags',
            'UcTags',
            'data'
        ));
    }
    // tagsUnduhan
    public function readUnduhan($slug)
    {
        $UcTags = CID::UcSlug($slug);
        $data = PortalUnduhan::whereStatus("Published")
            ->whereSlug($slug)
            ->firstOrFail();

        // update views
        $views = $data->views + 1;
        $data->update(["views" => $views]);
        return view('pages.portal.media.read_unduhan', compact(
            'data',
            'UcTags'
        ));

    }

    // indexGaleri
    public function indexGaleri()
    {
        $data = PortalGaleri::whereStatus("Published")
            ->orderBy("created_at", "DESC")
            ->simplePaginate(3);
        return view('pages.portal.media.index_galeri', compact(
            'data'
        ));
    }
    // readGaleri
    public function readGaleri($slug)
    {
        $UcTags = CID::UcSlug($slug);
        $data = PortalGaleri::whereStatus("Published")
            ->whereSlug($slug)
            ->firstOrFail();

        // update views
        $views = $data->views + 1;
        $data->update(["views" => $views]);
        return view('pages.portal.media.read_galeri', compact(
            'data',
            'UcTags'
        ));

    }

    // indexVideo
    public function indexVideo()
    {
        $data = PortalVideo::whereStatus("Published")
            ->orderBy("created_at", "DESC")
            ->simplePaginate(6);
        return view('pages.portal.media.index_video', compact(
            'data'
        ));
    }
    // readVideo
    public function readVideo($slug)
    {
        $UcTags = CID::UcSlug($slug);
        $data = PortalVideo::whereStatus("Published")
            ->whereSlug($slug)
            ->firstOrFail();

        // update views
        $views = $data->views + 1;
        $data->update(["views" => $views]);
        return view('pages.portal.media.read_video', compact(
            'data',
            'UcTags'
        ));

    }
}
