<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Image;

use App\Services\Cms\CmsRightsService;


class CmsDashboardController extends Controller
{

    public function home()
    {
        $moduleRights = CmsRightsService::userViewRights();

        return view('cms.modules.dashboard.home', compact([
            'moduleRights'
        ]));
    }

}
