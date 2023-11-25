<?php

namespace App\Http\Controllers\ApiBase\ApiAdmin\PortalApps;

use App\Helpers\CID;
use App\Http\Controllers\Controller;
use App\Models\PortalPost;
use App\Models\PortalUnduhan;

class ApiPortalAppsController extends Controller
{
    // get postingan
    public function postingan($page = null, $tags = null)
    {
        // data
        $data = [];
        $data = PortalPost::whereStatus("Published")
            ->orderBy("created_at", "DESC");
        // tags
        if ($tags !== null) {
            $data = $data->whereRaw("kategori LIKE '%$tags%'");
        }
        // page
        if ($page !== null) {
            $data = $data->simplePaginate($page);
        } else {
            $data = $data->get();
        }

        // foreach
        foreach ($data as $item) {
            $item->thumbnails = CID::urlImg($item->thumbnails);
            $data[] = $item;
        }

        // response
        $response = [
            "status" => true,
            "data" => $data,
        ];
        return response()->json($response, 200);
    }

    // readPostingan
    public function readPostingan($uuid)
    {
        // data
        $data = [];
        $data = PortalPost::whereStatus("Published")
            ->whereUuid($uuid)
            ->orderBy("created_at", "DESC")
            ->firstOrFail();
        // update views
        $views = $data->views + 1;
        $data->update(["views" => $views]);
        // revalue thumbnails
        $data['thumbnails'] = CID::urlImg($data->thumbnails);
        // response
        $response = [
            "status" => true,
            "data" => $data,
        ];
        return response()->json($response, 200);
    }

    // get unduhan
    public function unduhan($page = null, $tags = null)
    {
        // data
        $data = [];
        $data = PortalUnduhan::whereStatus("Published")
            ->orderBy("created_at", "DESC");
        // tags
        if ($tags !== null) {
            $data = $data->whereRaw("kategori_file LIKE '%$tags%'");
        }
        // page
        if ($page !== null) {
            $data = $data->simplePaginate($page);
        } else {
            $data = $data->get();
        }

        // foreach
        foreach ($data as $item) {
            $link_unduh = route('exdown.unduh', [CID::encode($item->uuid)]);
            $item['link_unduh'] = $link_unduh;
            $item['url'] = CID::urlImg($item->url);
            $data[] = $item;
        }

        // response
        $response = [
            "status" => true,
            "data" => $data,
        ];
        return response()->json($response, 200);
    }

    // readUnduhan
    public function readUnduhan($uuid)
    {
        // data
        $data = PortalUnduhan::whereStatus("Published")
            ->whereUuid($uuid)
            ->orderBy("created_at", "DESC")
            ->firstOrFail();
        // revalue
        $link_unduh = route('exdown.unduh', [CID::encode($data->uuid)]);
        // update views
        $views = $data->views + 1;
        $data->update(["views" => $views]);
        $data['link_unduh'] = $link_unduh;
        $data['url'] = CID::urlImg($data->url);
        // response
        $response = [
            "status" => true,
            "data" => $data,
        ];
        return response()->json($response, 200);
    }
}
