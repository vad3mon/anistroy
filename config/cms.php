<?php

return [
    'pagination' => 100,

    'modules' => [
        'banners' => [
            'name' => 'Банеры',
            'module' => 'Models',
            'model' => 'BannerProducts'
        ],        
        'discount' => [
            'name' => 'Товары со скидкой',
            'module' => 'Models',
            'model' => 'DiscountProducts'
        ],        
        'pages' => [
            'name' => 'Текстотвые страницы',
            'module' => 'Models',
            'model' => 'Page'
        ],        
        'properties' => [
            'name' => 'Способы фильтрации',
            'module' => 'Models',
            'model' => 'Property'
        ],        
        'filters' => [
            'name' => 'Фильтры',
            'module' => 'Models',
            'model' => 'Category'
        ],        
        'settings' => [
            'name' => 'Настройки',
            'route' => 'cms.settings.',
            'admin_only' => true
        ],
        'editors' => [
            'name' => 'Редакторы',
            'route' => 'cms.editors.',
            'admin_only' => true
        ],
    ],
    

    'menu' => [
        [
            'name' => 'Главная',
            'modules' => ['banners', 'discount']
        ],
        [
            'name' => 'Фильтры',
            'modules' => ['properties', 'filters']
        ],
        [
            'name' => 'Текстовые страницы',
            'modules' => 'pages'
        ],
        [
            'name' => 'Настройки',
            'modules' => 'settings' 
        ],
        [
            'name' => 'Редакторы',
            'modules' => 'editors',
            'admin_only' => true
        ],
    ],

    'settings' => [
        'block_1' => [
            'name' => 'Основные настройик',
            'fields' => [
                'phone_header' => [
                    'title' => 'Телефон в шапку',
                    'type' => 'line',
                ],
                'phone_footer' => [
                    'title' => 'Телефон в подвал',
                    'type' => 'line',
                ],
                'email' => [
                    'title' => 'Электронная почта',
                    'type' => 'line',
                ],
                'address' => [
                    'title' => 'Адрес',
                    'type' => 'text',
                ],              
            ]
        ],
        'block_2' => [
            'name' => 'Коды (счетчики, мессенджеры и тд.)',
            'fields' => [
                'codes_head' => [
                    'title' => 'Коды в <head>',
                    'type' => 'text',
                ],              
                'codes_body' => [
                    'title' => 'Коды в <BODY>',
                    'type' => 'text',
                ],              
            ]
        ],
    ]
];
