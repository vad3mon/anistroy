<?php

namespace App\Models\Cms;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CmsAction extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'module',
        'model',
        'item_id',
        'action',
        'user_id'
    ];

    public static function writeAction($module, $action, $itemId = 0, $model = '') {
        $user = Auth::user();

        $writeAction = new self();
        $writeAction->user_id = $user->id;
        $writeAction->module = $module;
        $writeAction->action = $action;
        $writeAction->model = $model;
        if(is_int($itemId)) {
            $writeAction->item_id = $itemId;
        }
        $writeAction->save();
    }

    public static function getActionsForUser($module, $action = null) {
        
    }
    
    public static function getAllActions($module, $action = null) {
        
    }    

}
