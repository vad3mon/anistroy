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
        'block_3' => [
            'name' => 'Доставка - грузчики',
            'fields' => [
                'loader_base' => [
                    'title' => 'Базовая стоимость разгрузки за 100 кг (Разгрузка, пронос до 25 метров, подъем на лифте) (руб.)',
                    'type' => 'line',
                    'value' => 1000
                ],
                'loader_more_carry' => [
                    'title' => 'Пронос свыше 25 метров. За кг за 20 метров (руб.)',
                    'type' => 'line',
                    'value' => 1
                ],
                'loader_lift' => [
                    'title' => 'Подъем без лифта за 100 кг за этаж (руб.)',
                    'type' => 'line',
                    'value' => 100
                ],
                'loader_min' => [
                    'title' => 'Минимальная стоимость разгрузки и подъема (руб.)',
                    'type' => 'line',
                    'value' => 1000
                ],
                'loader_cleaning' => [
                    'title' => 'Уборка (руб.)',
                    'type' => 'line',
                    'value' => 1000
                ],
            ]
        ],
    ]
];
