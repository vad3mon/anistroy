<?php

namespace App\Services\Cms;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class CmsRightsService
{

    public static function userHasRights($module, $type = 'view') {
        $user = Auth::user();

        if($user->rights == 'cms_admin') {
            return true;
        }
        elseif(isset($user->cms_modules[$type]) && in_array($module, $user->cms_modules[$type])) {
            return true;
        }
        else {
            return false;
        }
    }


    public static function userViewRights() {
        $rights = [];

        foreach(Config::get('cms.modules') as $moduleSlug => $nothing) {
            $rights[$moduleSlug] = self::userHasRights($moduleSlug);
        }

        return $rights;
    }

}
