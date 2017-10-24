<?php
/**
 * закладка - общие
 * Time: 16:10
 */
$title = [
    'text' => [
        'ru' => 'Рассылка. Панель инструментов',
        'en' => 'Mailing Toolbar.'
    ]
];
$text_ru = <<<TEXT
<b>Кнопки и их назначение.</b><br>
<i class="fa fa-question"></i>  - вызов справки <br>
<i class="fa fa-cog"></i>  - настройка рассылки <br>
<i class="fa fa-lock"></i> (или <i class="fa fa-unlock"></i> - блокировка (отмена блокировки) изменений состояния заказа<br>
<i class="fa fa-send"></i>  - выполнить рассылку <br>
<i class="fa fa-filter"></i>  - фильтр, позволяющий расширить список ИСПОЛНИТЕЛЕЙ <br>
TEXT;
$text_en = <<<TEXT
TEXT;
$rules = [
    'title' => [
        'text' => [
            'ru' => 'Панель инструментов',
            'en' => 'Toolbar'
        ]
    ],
    'content' => [
        'text' => [
            'ru' => $text_ru,
            'en' => $text_en
        ]
    ]
];
return [
    'title' => $title,
    'rules' => $rules,
];