<?php

namespace App\CmsModels;

class CmsModelPage
{
    const cms_settings = [
        'editable' => true,
        'deletable' => true,
        'has_published' => true,
        'has_position' => true,
        'parented' => [
            'id' => 'parent_id'
        ]
    ];


    const cms_filters = [
    ];

    const cms_list_fields = [
        'name' => [
            'title' => 'Заголовок страницы',
            'type' => 'line',
        ],
        'slug' => [
            'title' => 'Адрес страницы',
            'type' => 'line',
        ],
    ];

    const cms_fields = [
        'published' => [
            'title' => 'Опубликовать',
            'type' => 'bool'
        ],
        'binding' => [
            'title' => 'Положение в меню',
            'type' => 'enum',
            'values' => [
                '' => 'Не выводим',
                'header' => 'В шапку',
                'footer' => 'В подвал',
                'header_footer' => 'И в шапку и в подвал',
            ]
        ],
        'name' => [
            'title' => 'Заголовок страницы *',
            'type' => 'line',
            'required' => true
        ],
        'slug' => [
            'title' => 'Адрес страницы',
            'hint' => 'Только английский - без пробелов и заглавных букв',
            'type' => 'slug',
            'generate_from' => 'name'
        ],
        'content' => [
            'title' => 'Текст страницы',
            'type' => 'wysiwyg',
        ],
    ];
}
