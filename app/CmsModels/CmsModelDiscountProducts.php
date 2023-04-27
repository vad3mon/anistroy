<?php

namespace App\CmsModels;

class CmsModelDiscountProducts
{
    const cms_settings = [
        'editable' => true,
        'deletable' => true,
        'has_published' => true,
        'has_position' => true
    ];


    const cms_filters = [
    ];

    const cms_list_fields = [
        'name' => [
            'title' => 'Название (не выводится)',
            'type' => 'line',
        ],
    ];

    const cms_fields = [
        'published' => [
            'title' => 'Опубликовать',
            'type' => 'bool'
        ],
        'name' => [
            'title' => 'Название (не выводится) *',
            'type' => 'line',
            'required' => true
        ],
        'product_id' => [
            'title' => 'Товар',
            'type' => 'one_by_id',
            'model' => 'Product',
        ],        
    ];
}
