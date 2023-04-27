<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Config;

use App\Models\User;
use App\Models\Cms\CmsAction;

use App\Services\Cms\CmsRightsService;


class CmsEditorsController extends Controller
{

    public function home()
    {
        if(CmsRightsService::userHasRights('editors', 'view')) {        
            $moduleRights = CmsRightsService::userViewRights();

            $list = User::where('rights', 'cms_editor')->get();
            
            return view('cms.modules.editors.list', compact(
                'moduleRights',
                'list'
            ));
        }
        else {
            abort(404);
        }
    }

    public function item($id)
    {
        if(CmsRightsService::userHasRights('editors', 'view')) {
            $moduleRights = CmsRightsService::userViewRights();

            $item = null;

            if($id) {
                CmsAction::writeAction('editors', 'view', $id);
    
                $item = User::where('id', $id)->first();
            }
    
            return view('cms.modules.editors.item', compact(
                'moduleRights',
                'id',
                'item'
            ));    
        }
        else {
            abort(404);
        }
    }

    public function save($id, Request $request)
    {
        if(CmsRightsService::userHasRights('editors', 'edit')) {
                
            if ($id == 'add') {
                $user = new User();
                if(!$request->input('password') && !$request->input('password_confirm')) {
                    $password = 'not_set_yet';
                }
            }
            else {
                $user = User::find($id);
                $password = $user->password;
            }

            if($request->input('password') && $request->input('password') == $request->input('password_confirm')) {
                $password = Hash::make($request->input('password'));
            }
            elseif($request->input('password')) {
                return redirect()->back();
            }

            $moduleRights = [
                'view' => [],
                'add' => [],
                'edit' => [],
                'delete' => [],
            ];
            foreach(Config::get('cms.modules') as $moduleSlug => $module) {
                foreach($moduleRights as $right => $nothing) {
                    if($request->input($moduleSlug . '_' . $right)) {
                        $moduleRights[$right][] = $moduleSlug;
                    }    
                }
            }


            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->rights = 'cms_editor';
            $user->phone = '';
            $user->cms_modules = $moduleRights;
            $user->password = $password;
            $user->save();

            if ($id == 'add') {
                CmsAction::writeAction('editors', 'add', $user->id);
            }
            else {
                CmsAction::writeAction('editors', 'edit', $user->id);
            }
            return redirect()->route('cms.editors.home');
        }
        else {
            abort(404);
        }

    }

    public function delete($id)
    {
        if(CmsRightsService::userHasRights('editors', 'delete')) {
            $item = User::find($id);
            $item->delete();

            CmsAction::writeAction('editors', 'delete', $id);
        }
        else {
            abort(404);
        }
    }    

}
