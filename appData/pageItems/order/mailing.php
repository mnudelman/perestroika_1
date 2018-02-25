<?php
/**
 * закладка - общие
 * Time: 16:10
 */
$title = [
        'ru' => 'Заказ. Рассылка',
        'en' => 'Order. Mailing'
];
$text_ru = <<<TEXT
 <b>1. Форма "Рассылка" поделена на две половины:</b><br>
&nbsp;&nbsp;- левая - список испонителей, соответствующих требованиям заказа<br>
&nbsp;&nbsp;- правая - профиль исполнителя<br>
<b>2.Кнопки панели инструментов</b> <br>
&nbsp;&nbsp;- фильтр, определяющий количество исполнителей. <br>
&nbsp;&nbsp;иконка: <i class="fa fa-filter"></i> <br>
 Фильтр задаёт уровень совпадения набора работ заказа с набором работ из профиля исполнителя и
  уровень совпадения географии работ.<br>
&nbsp;&nbsp;- кнопка рассылки приглашений исполнителям принять участие в конкурсе на выполнение заказа<br>
&nbsp;&nbsp;иконка: <i class="fa fa-send-o"></i> <br>
<b>3. Каждый элемент списка исполнителей сопровождается набором кнопок, расположенных справа:</b> <br>
&nbsp;&nbsp;- показать профиль исполнителя<br>
&nbsp;&nbsp;иконка:<button class="btn btn-success"> <i class="fa fa-caret-right"></i></button> <br>
&nbsp;&nbsp;действие: В правой панели будет показан профиль исполнитнля.<br>
&nbsp;&nbsp;- оценка совпадения набора работ исполнителя и требований заказа<br>
&nbsp;&nbsp;иконка: <i class="fa fa-battery-half"></i>  >= 50% совпадений <br>
&nbsp;&nbsp;иконка: <i class="fa fa-battery-three-quarters"></i> >= 75% совпадений <br>
&nbsp;&nbsp;иконка: <i class="fa fa-battery-full"></i> >= 100% совпадений <br>
&nbsp;&nbsp;- оценка совпадения географии работ исполнителя и требований заказа<br>
&nbsp;&nbsp;иконка: <i class="fa fa-battery-half"></i> 50% - совпадает только регион <br>
&nbsp;&nbsp;иконка: <i class="fa fa-battery-full"></i> 100% - совпадает регион и город <br>
&nbsp;&nbsp;- состояние(стадия) исполнения заказа<br>
&nbsp;&nbsp;иконка: <i class="fa fa-square-o"></i> - не было рассылки приглашения <br>
&nbsp;&nbsp;иконка: <i class="fa fa-send-o"></i> - отправлено предложение на участие в конкурсе <br>
&nbsp;&nbsp;иконка: <i class="fa fa-check-square-o"></i> - подтверждено участие в конкурсе <br>

&nbsp;&nbsp;- последняя стадия исполнения заказа - выбор ИСПОЛНИТЕЛЯ работ по ЗАКАЗУ - выделена в отдельное поле<br>
&nbsp;&nbsp;иконка: <i class="fa fa-square-o"></i> - не выбран исполнителем <br>
&nbsp;&nbsp;иконка: <i class="fa fa-thumbs-o-up"></i> - выбран исполнителем <br>
Замечание. Для данного заказа может быть выбран только один ИСПОЛНИТЕЛЬ<br>

TEXT;
$text_en = <<<TEXT
TEXT;
$rules = [
    'title' => [
            'ru' => 'Для выполнения расылки используйте следующее:',
            'en' => 'In the formation of areas of work, use rules:'
    ],
    'content' => [
            'ru' => $text_ru,
            'en' => $text_en
    ]
];
$fields = [
    'orderName' => [
            'ru' => 'имя',
            'en' => 'name'
    ],
    'description' => [
            'ru' => 'описание',
            'en' => 'description'
    ],
    'perBeg' => [
            'ru' => 'период- начало',
            'en' => 'period- Begin'
    ],
    'perEnd' => [
            'ru' => 'период- окончание',
            'en' => 'period- the end'
    ],
    'city' => [
            'ru' => 'город',
            'en' => 'city'
    ],
] ;
$infoFields = [
    'name'  => [
            'ru' => 'имя',
            'en' => 'name'
    ],
    'period'  => [
            'ru' => 'период',
            'en' => 'period'
    ],
    'description' => [
            'ru' => 'описание',
            'en' => 'description'
    ],
    'additional' => [
            'ru' => 'Дополнительные материалы',
            'en' => 'additional'
    ],
    'mailing' => [
            'ru' => 'Рассылки всего',
            'en' => 'mailing total'
    ],
    'answers' => [
            'ru' => 'Ответов',
            'en' => 'answers'
    ],
    'selectedYes' => [
            'ru' => 'Исполнитель определён.',
            'en' => 'the contractor determined'
    ],
    'selectedNo' => [
            'ru' => 'Исполнитель не определён.',
            'en' => 'the contractor is not defined'
    ],
    'city' => [
            'ru' => 'город',
            'en' => 'city'
    ],



] ;
$tooltips = [
    'itemEdit' => [
            'ru' => 'Редактировать заказ',
            'en' => 'To edit the order'
    ],
    'orderCreate' => [
            'ru' => 'Создать новый заказ',
            'en' => 'To create a new order'
    ],
    'orderCopy' => [
            'ru' => 'Создать новый заказ копированием текущего',
            'en' => 'To create a new order by copying this'
    ],

    'orderSave' => [
            'ru' => 'Сохранить заказ',
            'en' => 'To save the order'
    ],
    'orderDelete' => [
            'ru' => 'Удалить заказ',
            'en' => 'Delete the order'
    ],

];
$parts = [
    'current' => [
            'ru' => 'Исполнители заказа',
            'en' => 'the executors of the order'
    ],
    'edit' => [
            'ru' => 'Профиль исполнителя',
            'en' => 'Profile of the contractor'
    ],

] ;
return [
    'title' => $title,
    'rules' => $rules,
    'tooltips' => $tooltips,
    'partsTitle' => $parts,
    'fields' => $fields,
    'infoFields' => $infoFields,
];