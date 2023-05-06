<?php

namespace App\CmsModels;

class CmsModelProperty
{
    const cms_settings = [
        'editable' => true,
        'deletable' => false,
        'has_published' => false,
        'has_position' => false,
    ];


    const cms_filters = [
    ];

    const cms_list_fields = [
        'title' => [
            'title' => 'Название',
            'type' => 'line',
        ],
    ];

    const cms_fields = [
        'title' => [
            'title' => 'Название',
            'type' => 'line',
            'readonly' => true
        ],
        'type' => [
            'title' => 'Тип фильтра',
            'type' => 'enum',
            'values' => [
                'range' => 'Слайдер',
                'list' => 'Список',
            ]
        ],
    ];
}
