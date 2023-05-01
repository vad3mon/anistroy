<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use Image;

use App\Services\Cms\CmsRightsService;
use App\Services\Cms\CmsSaveService;

use App\Models;
use App\Models\Cms\CmsAction;

class CmsModelsController extends Controller
{

    private $moduleModel;
    private $moduleSettings;

    public function __construct()
    {
        if(Route::current()) {
            $this->moduleSettings = $this->getModelCmsSettings(Route::current()->parameter('module'));
            $this->moduleModel = $this->getModel(Route::current()->parameter('module'));    
            if (!class_exists($this->moduleSettings) || !class_exists($this->moduleModel)) {
                abort(404);
            }
        }
    }

    private function getModel($module): string
    {
        return 'App\Models\\' . config("cms.modules.{$module}.model");
    }

    private function getModelByName($model)
    {
        return 'App\Models\\' . $model;
    }

    private function getModelCmsSettings($module): string
    {
        return 'App\CmsModels\CmsModel' . config("cms.modules.{$module}.model");
    }

    // открываем окно со списком элементов
    public function home(Request $request, $module)
    {
        if(CmsRightsService::userHasRights($module, 'view')) { 

            $moduleRights = CmsRightsService::userViewRights();

            // $modelSettings = $this->getModelCmsSettings($module);
            $modelSettings = $this->moduleSettings;
            $theModel = $this->getModel($module);


            if (class_exists($theModel) && class_exists($modelSettings)) {

                $editorSettings = $modelSettings::cms_settings;
                $editorFilters = $modelSettings::cms_filters ? $modelSettings::cms_filters : [];
                $editorTableFields = $modelSettings::cms_list_fields;

                // сортировка
                $sortBy = 'id';
                if (isset($modelSettings::cms_settings['has_position']) && $modelSettings::cms_settings['has_position']) {
                    $sortBy = 'position';
                } elseif (isset($modelSettings::cms_settings['order_by'])) {
                    $sortBy = $modelSettings::cms_settings['order_by'];
                }

                $sortByType = isset($modelSettings::cms_settings['order_by_type']) ? $modelSettings::cms_settings['order_by_type'] : 'asc';

                

                // достаем элементы
                $list = $theModel::where('id', '>', '0');

                $parented = false;
                $goUpId = false;
                if(isset($modelSettings::cms_settings['parented'])) {
                    $parented = true;
                    if($request->input('parent')) {
                        $list->where($modelSettings::cms_settings['parented']['id'], $request->input('parent'));
                        $goUpId = $theModel::where('id', $request->input('parent'))->first()[$modelSettings::cms_settings['parented']['id']];
                        if(!$goUpId) {
                            $goUpId = 0;
                        }
                    }
                    else {
                        $list->whereNull($modelSettings::cms_settings['parented']['id']);
                    }
                }


                $additionalData = [];

                // добавляем фильтрацию
                foreach($editorFilters as $field => $fieldData) {
                    switch($fieldData['type']) {
                        case 'enum':
                            if($request->input($field)) {
                                $list = $list->where($field, $request->input($field));
                            }
                        break;

                        case 'set':
                            $tmp_model = $this->getModelByName($fieldData['model']);
                            $tmp_sort_by = isset($fieldData['sort_by']) ? $fieldData['sort_by'] : 'id';
                            $additionalData[$field] = $tmp_model::all()->sortBy($tmp_sort_by);

                            if($request->input($field)) {
                                $list = $list->whereHas($field, function($q) use ($tmp_model, $request, $field) {
                                    $q->where($field . '.id', $request->input($field));
                                });
                            }

                            break;    

                        case 'search':
                            if($request->input($field)) {
                                $list = $list->where(function($query) use ($field, $fieldData, $request) {
                                    $query->where('id', '=', '0');
        
                                    foreach($fieldData['fields'] as $searchFiled) {
                                        $query = $query->orWhere($searchFiled, 'like', '%' . $request->input($field) . '%');
                                    }
                                });    
                            }
                        break;
                    }    
                }


                $list = $list->orderBy($sortBy, $sortByType)->paginate(Config::get('cms.pagination'));;


                foreach ($editorTableFields as $field => $fieldData) {
                    if($fieldData['type'] == 'one_by_id') {
                        $additionalData[$field] = $this->getModelByName($fieldData['model'])::all();
                    }
                }


                return view('cms.modules.models.list', compact(
                    'parented',
                    'goUpId',
                    'moduleRights',
                    'editorFilters',
                    'editorTableFields',
                    'editorSettings',
                    'module',
                    'list',
                    'request',
                    'additionalData'
                ));
            } else {
                abort(404);
            }
        }
        else {
            abort(404);
        }

    }

    // открываем окно редактирования элемента или создания нового
    public function item(Request $request, $module, $id)
    {
        if(CmsRightsService::userHasRights($module, 'view')) { 
            $moduleRights = CmsRightsService::userViewRights();


            $hasSave = isset($this->moduleSettings::cms_settings['has_save']) ? $this->moduleSettings::cms_settings['has_save'] : true;
            $hasSaveProtection = isset($this->moduleSettings::cms_settings['has_save_protection']) ? $this->moduleSettings::cms_settings['has_save_protection'] : false;

            if(CmsRightsService::userHasRights($module, 'edit')) {
                $canSave = true;
            }
            else {
                $canSave = !$item 
                    || (
                        $hasSave 
                    && (
                        strtotime($item['updated_at']) + 3 * 86400 > time()
                        || !$item->published
                        || !$hasSaveProtection
                        )
                    );
            }

            $item = null;
            if ($id != 'add') {
                CmsAction::writeAction('models', 'view', $id, $module);

                $item = $this->moduleModel::find($id);
            }

            $goUpId = false;
            if(isset($this->moduleSettings::cms_settings['parented'])) {
                $goUpId = $request->input('with_parent');
            }


            $editorFields = $this->moduleSettings::cms_fields;

            $additionalData = [];
            $additionalDataSelected = [];

            foreach ($editorFields as $field => $fieldData) {
                if ($fieldData['type'] == 'set' ||
                    $fieldData['type'] == 'set_ordered' ||
                    $fieldData['type'] == 'one_by_id') {

                    $tmp_model = $this->getModelByName($fieldData['model']);
                    
                    $tmp_sort_by = isset($fieldData['sort_by']) ? $fieldData['sort_by'] : 'id';

                    $additionalData[$field] = $tmp_model::all()->sortBy($tmp_sort_by);
                }

                if ($item && ($fieldData['type'] == 'set' || $fieldData['type'] == 'set_ordered')) {
                    $additionalDataSelected[$field] = [];

                    if (isset($fieldData['model'])) {
                        $additionalDataSelected[$field] = $item->belongsToMany($tmp_model)->get();
                    }
                }
            }


            


            return view('cms.modules.models.item', compact(
                'moduleRights',
                'goUpId',
                'editorFields',
                'canSave',
                'module',
                'id',
                'item',
                'additionalData',
                'additionalDataSelected',
                'request'
            ));

        }
        else {
            abort(404);
        }
    }

    // сохраняем изменения или создаем элемент
    public function save($module, $id, Request $request)
    {
        if(CmsRightsService::userHasRights($module, 'edit')) { 


            if ($id == 'add') {
                $fields = $this->buildFields($id, $this->moduleModel, $this->moduleSettings::cms_fields, $request);

                // позиция, если создаем новый элемент
                if($this->moduleSettings::cms_settings['has_position']) {
                    $this->moduleModel::whereNotNull('id')->increment('position');
                    $fields['position'] = max(1, $this->moduleModel::min('position') - 1);
                }

                if(isset($this->moduleSettings::cms_settings['parented'])) {
                    $fields[$this->moduleSettings::cms_settings['parented']['id']] = $request->input('parent');
                }


                $item = $this->moduleModel::create($fields);

                CmsAction::writeAction('models', 'add', $item->id, $module);
            } else {
                $item = $this->moduleModel::find($id);
                $fields = $this->buildFields($id, $this->moduleModel, $this->moduleSettings::cms_fields, $request);

                $item->update($fields);

                CmsAction::writeAction('models', 'edit', $id, $module);
            }

            if (!empty($fields['cms_relation_models'])) {
                foreach ($fields['cms_relation_models'] as $relation_model) {
                    $this->syncRelationData($item, 
                        $this->getModelByName($relation_model['relation']), 
                        $relation_model['data']);
                }
            }

            if (!empty($fields['cms_relation_models_position'])) {
                foreach ($fields['cms_relation_models_position'] as $relation_model) {
                    $this->syncRelationDataWithPos($item, 
                    $this->getModelByName($relation_model['relation']), 
                        $relation_model['data']);
                }
            }

            if ($id == 'add') {
                // перенаправляем на редактирование, если создавался новвый элемент
                return redirect()->route('cms.models.item', [$module, $item->id]);
            } else {
                return back();
            }

        }
        else {
            abort(404);
        }
    }

    //  изменение позиции (вывзыввается через JS)
    public function position($module, Request $request)
    {
        if(CmsRightsService::userHasRights($module, 'edit')) { 
            if ($this->moduleSettings::cms_settings['has_position']) {

                $currentProduct = $this->moduleModel::find($request->input('id'));
                $previousProduct = $this->moduleModel::find($request->input('prev_id'));

                if ($previousProduct) {
                    // сверху вниз
                    $newPosition = $previousProduct->position + 1;

                    if ($previousProduct->position > $currentProduct->position) {
                        // снизу вверх
                        $newPosition = $previousProduct->position;
                    }
                } else {
                    // в самый низ
                    $newPosition = $this->moduleModel::all()->sortBy('position')->first()->position;
                }

                if ($newPosition > $currentProduct->position) {
                    $this->moduleModel::query()->whereBetween('position', [$currentProduct->position, $newPosition])->decrement('position');
                } else {
                    $this->moduleModel::query()->whereBetween('position', [$newPosition, $currentProduct->position])->increment('position');
                }

                $currentProduct->update(['position' => $newPosition]);


                return response()->json(['result' => 'ok', 'id' => $request->input('id')]);
            }

            return response()->json(['result' => 'error', 'text' => 'the model is not editable']);
        }
        else {
            abort(404);
        }
    }

    // удаление элемента
    public function delete($module, $id)
    {
        if(CmsRightsService::userHasRights('editors', 'delete')) { 
            if ($this->moduleSettings::cms_settings['deletable']) {
                $item = $this->moduleModel::find($id);
                $item->delete();

                CmsAction::writeAction('models', 'delete', $id, $module);
                return response()->json(['result' => 'ok', 'id' => $id]);
            }
            else {
                return response()->json(['result' => 'error', 'text' => 'the model is not deletable']);
            }
        }
        else {
            return response()->json(['result' => 'error', 'text' => 'you have no rights to delete']);
        }
    }




    private function syncRelationData($model, $relation, $data)
    {
        return $model->belongsToMany($relation)->sync($data);
    }


    private function syncRelationDataWithPos($model, $relation, $data)
    {
        $flipData = array_flip($data);
        $dataWithPosition = array_map(fn($position) => ['position' => $position + 1], $flipData);

        return $model->belongsToMany($relation)->withPivot('position')
            ->orderByPivot('position')->sync($dataWithPosition);
    }



    private function buildFields($id, $model, $settingsFields, $request): array
    {

        $fields = [];

        foreach ($settingsFields as $field => $fieldData) {
            if ($fieldData['type'] == 'image') {
                $fields[$field] = CmsSaveService::saveImage($request, $field, $fieldData);                
            } else {
                if ($fieldData['type'] == 'bool' && !$request->input($field)) {
                    $fields[$field] = 0;
                }
                // сохраняем slug
                elseif($fieldData['type'] == 'slug') {
                    $fields[$field] = CmsSaveService::saveSlug($id, $request, $field, $fieldData, $model);
                }
                // сохраняем json
                elseif($fieldData['type'] == 'json') {
                    $fields[$field] = CmsSaveService::saveJson($request, $field, $fieldData);
                }                
                // сохраняем список
                elseif ($fieldData['type'] == 'set') {
                    $fields['cms_relation_models'][] = [
                        'relation' => $fieldData['model'],
                        'data' => $request->input($field) ?? []
                    ];
                } elseif ($fieldData['type'] == 'set_ordered') {
                    $fields['cms_relation_models_position'][] = [
                        'relation' => $fieldData['model'],
                        'data' => $request->input($field) ?? []
                    ];
                } // сохраняем остальные
                else {
                    $fields[$field] = $request->input($field);
                }
            }
        }

        return $fields;
    }
}
