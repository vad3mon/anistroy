<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Image;

use App\Services\Cms\CmsRightsService;
use App\Services\Cms\CmsSaveService;

use App\Models\Settings;
use App\Models\Cms\CmsAction;

class CmsSettingsController extends Controller
{

    public function home()
    {
        if(CmsRightsService::userHasRights('settings', 'view')) {
            CmsAction::writeAction('settings', 'view');

            $moduleRights = CmsRightsService::userViewRights();

            $canSave = CmsRightsService::userHasRights('settings', 'save');

            $settings = Settings::first();
    
            return view('cms.modules.settings.home', compact([
                'moduleRights',
                'canSave',
                'settings'
            ]));    
        }
        else {
            abort(404);
        }

    }

    public function save(Request $request)
    {
        if(CmsRightsService::userHasRights('settings', 'save')) {
            CmsAction::writeAction('settings', 'edit');

            $settings = Settings::first();

            $settingsData = $settings->settings;

            foreach(Config::get('cms.settings') as $blockId => $settingsBlock) {
                foreach($settingsBlock['fields'] as $field => $fieldData) {
                    if ($fieldData['type'] == 'image') {
                        $settingsData[$field] = CmsSaveService::saveImage($request, $field, $fieldData);
                    }
                    elseif($fieldData['type'] == 'json') {
                        $settingsData[$field] = CmsSaveService::saveJson($request, $field, $fieldData);
                    }
                    else {
                        $settingsData[$field] = $request->input($field);
                    }
                }
            }
        
            $settings->settings = $settingsData;

            $settings->save();

            return back();
        }
        else {
            abort(404);
        }
    }
}
