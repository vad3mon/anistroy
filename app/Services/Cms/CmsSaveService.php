<?php

namespace App\Services\Cms;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Image;

class CmsSaveService
{

    
    private static function russianToLatinWithNoSigns($text) 
    {

        $translations = [
            'а' => 'a',
            'б' => 'b',
            'в' => 'v',
            'г' => 'g',
            'д' => 'd',
            'ъе' => 'ye',
            'ье' => 'ye',
            'е' => 'e',
            'ё' => 'yo',
            'ж' => 'zh',
            'з' => 'z',
            'и' => 'i',
            'й' => 'y',
            'к' => 'k',
            'л' => 'l',
            'м' => 'm',
            'н' => 'n',
            'о' => 'o',
            'п' => 'p',
            'р' => 'r',
            'с' => 's',
            'т' => 't',
            'у' => 'u',
            'ф' => 'f',
            'х' => 'kh',
            'ц' => 'ts',
            'ч' => 'ch',
            'ш' => 'sh',
            'щ' => 'shch',
            'ъ' => '',
            'ы' => 'y',
            'ь' => '',
            'э' => 'e',
            'ю' => 'yu',
            'я' => 'ya',

            '%22' => '',
            '+' => '-',
            '=' => '-',
            ' ' => '-',
            ',' => '',
            '.' => '',
            '!' => '',
            '?' => '',
            '"' => '',
            '\'' => '',
            '(' => '',
            ')' => '',
            '*' => '',
            '&' => '',
            '^' => '',
            '%' => '',
            '$' => '',
            '#' => '',
            '@' => '',
            '№' => '',
            ':' => '',
            ';' => '',
            '_' => '-'
        ];

        $translationFrom = array_keys($translations);
        $translationTo = array_values($translations);

        $textUpdated = mb_strtolower($text, 'UTF-8');

        $textUpdated = str_replace($translationFrom, $translationTo, $textUpdated);

        $textUpdated = urlencode($textUpdated);

        $textUpdated = str_replace('i%CC%86', 'y', $textUpdated);

        $textUpdated = preg_replace('/[^\w-]/', '', $textUpdated);

        return $textUpdated;

    }


    public static function saveImage(Request $request, $field, $fieldData) {
        $result = '';

        if($request->input('image_' . $field . '_delete')) {
            $result = '';
        }
        if ($request->hasfile($field)) {
            $file = $request->file($field);
            $fileName = basename($file->getClientOriginalName());

            $fileParts = pathinfo($fileName);
            $fileExt = $fileParts['extension'];
            $clearName = str_replace('.' . $fileExt, '', $fileParts['filename']);

            $clearNameLatin = self::russianToLatinWithNoSigns($clearName);

            $newFileName = $clearNameLatin . '.' . $fileExt;

            $i = 2;
            while(Storage::exists('public/images/content/' . $newFileName)) {
                $newFileName = $clearNameLatin . '_' . $i . '.' . $fileExt;
                $i++;
            }

            $file->storeAs('images/content', $newFileName, 'public');

            if(isset($fieldData['thumbnail']) && isset($fieldData['thumbnail']['width']) && isset($fieldData['thumbnail']['height'])) {
                if($fileExt == 'svg') {
                    copy(Storage::path('public/images/content/') . $newFileName, Storage::path('public/images/thumbnails/') . $newFileName);
                } else {
                    $img = Image::make(Storage::path('public/images/content/') . $newFileName)
                        ->resize($fieldData['thumbnail']['width'], $fieldData['thumbnail']['height'])
                        ->save(Storage::path('public/images/thumbnails/') . $newFileName);
                }    
            }

            if($fileExt == 'svg') {
                copy(Storage::path('public/images/content/') . $newFileName, Storage::path('public/images/cms_thumbnails/') . $newFileName);
            } else {
                $img = Image::make(Storage::path('public/images/content/') . $newFileName)
                    ->resize(100, 100)
                    ->save(Storage::path('public/images/cms_thumbnails/') . $newFileName);
            }
            $result = $newFileName;
        }        

        return $result;
    }


    public static function saveJson(Request $request, $field, $fieldData) {
        $result = [];
        foreach($fieldData['json_fields'] as $jsonField) {
            $jsonFields = $request->input('json_' . $field . '_' . $jsonField['name']);
            foreach($jsonFields as $k => $jsonFieldData) {
                $result[$k][$jsonField['name']] = $jsonFieldData;
            }
        }

        return $result;
    }

    public static function saveSlug($id, Request $request, $field, $fieldData, $model) {
        $result = $request->input($field);
        if(!$result && $fieldData['generate_from']) {
            $result = $request->input($fieldData['generate_from']);
        }
        $result = self::russianToLatinWithNoSigns($result);

        // проверка на уникальность
        while($model::where($field, $result)
            ->whereNot('id', $id)
            ->first()
            ) {
            $result .= '-';
        }

        return $result;
    }


    public static function buildFields($id, $model, $request): array
    {

        $fields = [];


        foreach ($model::cms_fields as $field => $fieldData) {
            if ($fieldData['type'] == 'image') {
                $fields[$field] = self::saveImage($request, $field, $fieldData);

            } else {
                if ($fieldData['type'] == 'bool' && !$request->input($field)) {
                    $fields[$field] = 0;
                }
                // сохраняем slug
                elseif($fieldData['type'] == 'slug') {
                    $fields[$field] = self::saveSlug($id, $request, $field, $fieldData, $model);
                }
                // сохраняем json
                elseif($fieldData['type'] == 'json') {
                    $fields[$field] = self::saveJson($request, $field, $fieldData);
                }                
                // сохраняем список
                elseif ($fieldData['type'] == 'set') {
                    $fields['relation_models'][] = [
                        'relation' => $fieldData['model'],
                        'data' => $request->input($field) ?? []
                    ];
                } elseif ($fieldData['type'] == 'set_ordered') {
                    $fields['relation_models_position'][] = [
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
