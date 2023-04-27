<?php

namespace App\CmsModels;

class CmsModelCategory
{

    const cms_settings = [
        'editable' => true,
        'deletable' => true,
        'has_published' => false,
        'has_position' => false,
        'order_by' => 'name',
        'parented' => [
            'id' => 'parent_id'
        ]
    ];

    const cms_filters = [
    ];

    const cms_list_fields = [
        'name' => [
            'title' => 'Название',
            'type' => 'line',
        ],
        'slug' => [
            'title' => 'Адрес страницы',
            'type' => 'line',
        ],
    ];

    const cms_fields = [
        'name' => [
            'title' => 'Название страницы *',
            'type' => 'line',
            'required' => true,
            'readonly' => true
        ],
        'page_id' => [
            'title' => 'Фильтры',
            'type' => 'set',
            'model' => 'Property',
            'model_name_field' => 'title'
        ],

/*        
        'slug' => [
            'title' => 'Адрес',
            'hint' => 'Только английский - без пробелов и заглавных букв',
            'type' => 'slug',
            'generate_from' => 'name'
        ],
        'text' => [
            'title' => 'Текст страницы',
            'type' => 'wysiwyg',
        ],
        'page_id' => [
            'title' => 'Страница',
            'type' => 'one_by_id',
            'model' => 'ParentedData'
        ],
        'pg_id' => [
            'title' => 'Страница',
            'type' => 'one_by_id',
            'model' => 'ParentedData'
        ],
        'enm' => [
            'title' => 'Списочек',
            'type' => 'enum',
            'values' => [
                'one' => 'один',
                'two' => 'два'
            ]
        ]
*/        
    ];
}