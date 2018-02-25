<?php
/**
 * Список направлений работы
 */
$title = [
    'ru' => 'НАПРАВЛЕНИЯ РАБОТ',
    'en' => 'WORK DIRECTION'
];
$content = [
    'diamondCutting' => [
        'text' => [
            'ru' => 'Алмазная резка и бурение',
            'en' => 'Diamond cutting and drilling'
        ],
        'img' => 'алмазная резка и бурение.jpg',
    ],
    'demolition' => [
        'text' => [
            'ru' => 'Демонтажные работы',
            'en' => 'Demolition work'
        ],
        'img' => 'Демонтажные работы.jpg',
    ],
    'dismantling' => [
        'text' => [
            'ru' => 'Демонтаж зданий и сооружений',
            'en' => 'Dismantling of buildings and structures'
        ],
        'img' => 'Демонтаж зданий и сооружений. 2.jpg',
    ],
    'construction' => [
        'text' => [
            'ru' => 'Строительные работы',
            'en' => 'Construction work'
        ],
        'img' => 'Строительные работы.jpg',
    ],
    'protection' => [
        'text' => [
            'ru' => 'Защита и восстановление строительных конструкций',
            'en' => 'Protection and restoration of building structures'
        ],
        'img' => 'Защита и восстановление строительных конструкций.jpg',
    ],
    'redevelopment' => [
        'text' => [
            'ru' => 'Перепланировка помещений',
            'en' => 'Redevelopment of premises'
        ],
        'img' => 'Перепланировка помещений.jpg',
    ],
    'reconstruction' => [
        'text' => [
            'ru' => 'Реконструкция зданий и сооружений',
            'en' => 'Reconstruction of buildings and structures'
        ],
        'img' => 'Реконструкция зданий и сооружений.jpg',
    ],
    'design' => [
        'text' => [
            'ru' => 'Проектные работы',
            'en' => 'Design work'
        ],
        'img' => 'Проектные работы.jpg',
    ],

    'diamondSuppliers' => [
        'text' => [
            'ru' => 'Поставщики оборудования и расходных материалов для алмазной резки и бурения',
            'en' => 'Suppliers of equipment and consumables for diamond cutting and drilling'
        ],
        'img' => 'Поставщики оборудования и расходных материалов для алмазной резки и бурения.jpg',
    ],
    'materialsSuppliers' => [
        'text' => [
            'ru' => 'Поставщики специализированных строительных материалов',
            'en' => 'Suppliers of specialised building materials'
        ],
        'img' => 'Поставщики специализированных строит. материалов.jpg',
    ],

    'specialRent' => [
        'text' => [
            'ru' => 'Аренда спец автотранспорта',
            'en' => 'Rent special vehicles'
        ],
        'img' => 'Аренда спец автотранспорта 2.jpg',
    ],
    'removal' => [
        'text' => [
            'ru' => 'Вывоз и утилизация строительного мусора',
            'en' => 'Removal and disposal of construction debris'
        ],
        'img' => 'Вывоз и утилизация строительного мусора.jpg',
    ],

];
$commands = [
    'order' => [
            'ru' => 'заказ',
            'en' => 'order',
    ],
    'developer' => [
            'ru' => 'добавить в исполнители',
            'en' => 'add to developer',
    ],
    'exit' => [
            'ru' => 'выход',
            'en' => 'exit',

    ]
];
$url = [
    'order' => 'order%2Findex',
    'developer' => 'developer%2Findex',
    'exit' => '#'
] ;
return [
    'title' => ['text' => $title],
    'content' => $content,
    'commands' => $commands,
    'url' => $url,

];