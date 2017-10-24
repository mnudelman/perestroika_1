<?php
/**
 * закладка - общие
 * Time: 16:10
 */
$title = [
    'text' => [
        'ru' => 'Заказ. Основное',
        'en' => 'Order. General'
    ]
];
$text_ru = <<<TEXT
 <b>информация о заказе разнесена на несколько закладок:. </b> <br>
 &nbsp;&nbsp;- "общее" . <br>
 &nbsp;&nbsp;- "работы/услуги". <br>
 &nbsp;&nbsp;- "дополнительные материалы". <br>
 &nbsp;&nbsp;- "рассылка". <br>

<b>1. Форма "общее" поделена на две половины:</b><br>
&nbsp;&nbsp;- левая - список оформленных ранее заказов,<br>
&nbsp;&nbsp;- правая - область добавления новых заказов или внесения изменений в существующие<br>
<b>2. Добавление нового заказа</b> можно выполнить двумя способами:<br>
&nbsp;&nbsp;- создание пустого заказа. <br>
&nbsp;&nbsp;&nbsp; В панели инструментов в верхней части нажать иконку <i class="fa fa-file-o"></i> <br>
&nbsp;&nbsp;&nbsp; Будет создан новый заказ с незаполненными полями. <br>
&nbsp;&nbsp;- создание нового копированием текущего заказа. <br>
&nbsp;&nbsp;&nbsp; В левой половине формы надо выбрать заказ.
Нажать иконку <span class="glyphicon glyphicon-edit"></span> <br>
                   Заказ будет перенесён в область изменений.
                   Затем нажать иконку в панели управления <i class="fa fa-clone"></i> <br>
                   Будет создан новый заказ - копия текущего. <br>
<b>замечание 1.</b> Если вы не зарегистрированы на сайте, будет открыта закладка "экспресс регистрация"<br>
<b>Замечание 2.</b> Редактирование и сохранение элементов заказа распространяется только на текущую(открытую) закладку.<br>
<b>Замечание 3.</b> Для создания заказа достаточно иметь права пользователя,
               т.е. пройти процедуру регистрации (экспресс регистрации)<br>
           Для рассылки заказа нужно подтверждение вашего email. <br>
<b>Замечание 4.</b> Операции <b>редактирования->сохранения</b>, <b>удаления</b> имеют естественные ограничения.<br>
 &nbsp;&nbsp;- Нельзя изменять уже разосланный заказ<br>
&nbsp;&nbsp;- Нельзя удалять заказ, по которому определён исполнитель.
TEXT;
$text_en = <<<TEXT
<b>ordering information posted on several tabs:. </b> <br>
&nbsp;&nbsp;- "General" . <br / >
&nbsp;&nbsp;- "services". <br / >
&nbsp;&nbsp;- "additional materials". <br / >
&nbsp;&nbsp;- "mailing list". <br / >

<b>1. Form of "General" is divided into two halves:</b><br>
&nbsp;&nbsp;- left - list of the previously processed orders<br>
&nbsp;&nbsp;- right area of the add new orders or changes to existing<br>
<b>2. Add new order</b> can be accomplished in two ways:<br>
&nbsp;&nbsp;- create a blank order. <br / >
&nbsp;&nbsp;&nbsp; In the toolbar at the top click the icon <i class="fa fa-file-o"></i> <br>
&nbsp;&nbsp;&nbsp; creates a new order with blank fields. <br / >
&nbsp;&nbsp;- create a new copy current order. <br / >
&nbsp;&nbsp;&nbsp; In the left half of the form is necessary to choose the order.
Click the icon <span class="glyphicon glyphicon-edit"></span> <br>
The order is transferred to the area changes.
Then click the icon in the control panel <i class="fa fa-clone"></i> <br>
It will create a new order - a copy of the current. <br / >
<b>note 1.</b> If you are not registered on the site, open the tab "Express registration"<br>
<b>Note 2.</b> to Edit and save items order applies only to the current(open) tab.<br>
<b>Note 3.</b> To create your order, you should have user rights,
ie complete the registration (Express registration)<br>
To send the order need confirmation of your email. <br / >
<b>Note 4.</b> Operations <b>editing->saving</b>, <b>removal</b> have other natural limitations.<br>
 &nbsp;&nbsp; you can't change an already sent order<br>
&nbsp;&nbsp; you can't cancel the order, at which time contractor.
TEXT;
$rules = [
    'title' => [
        'text' => [
            'ru' => 'При оформлении заказа, используйте правила:',
            'en' => 'In the formation of areas of work, use rules:'
        ]
    ],
    'content' => [
        'text' => [
            'ru' => $text_ru,
            'en' => $text_en
        ]
    ]
];
$fields = [
    'orderName' => [
        'text' => [
            'ru' => 'имя',
            'en' => 'name'
        ]
    ],
    'description' => [
        'text' => [
            'ru' => 'описание',
            'en' => 'description'
        ]
    ],
    'perBeg' => [
        'text' => [
            'ru' => 'период- начало',
            'en' => 'period- Begin'
        ]
    ],
    'perEnd' => [
        'text' => [
            'ru' => 'период- окончание',
            'en' => 'period- the end'
        ]
    ],
    'city' => [
        'text' => [
            'ru' => 'город',
            'en' => 'city'
        ]
    ],
] ;
$infoFields = [
    'name'  => [
        'text' => [
            'ru' => 'имя',
            'en' => 'name'
        ]
    ],
    'period'  => [
        'text' => [
            'ru' => 'период',
            'en' => 'period'
        ]
    ],
    'description' => [
        'text' => [
            'ru' => 'описание',
            'en' => 'description'
        ]
    ],
    'additional' => [
        'text' => [
            'ru' => 'Дополнительные материалы',
            'en' => 'additional'
        ]
    ],
    'mailing' => [
        'text' => [
            'ru' => 'Рассылки всего',
            'en' => 'mailing total'
        ]
    ],
    'answers' => [
        'text' => [
            'ru' => 'Ответов',
            'en' => 'answers'
        ]
    ],
    'selectedYes' => [
        'text' => [
            'ru' => 'Исполнитель определён.',
            'en' => 'the contractor determined'
        ]
    ],
    'selectedNo' => [
        'text' => [
            'ru' => 'Исполнитель не определён.',
            'en' => 'the contractor is not defined'
        ]
    ],
    'city' => [
        'text' => [
            'ru' => 'город',
            'en' => 'city'
        ]
    ],



] ;
$tooltips = [
    'itemEdit' => [
        'text' => [
            'ru' => 'Редактировать заказ',
            'en' => 'To edit the order'
        ]
    ],
    'orderCreate' => [
        'text' => [
            'ru' => 'Создать новый заказ',
            'en' => 'To create a new order'
        ]
    ],
    'orderCopy' => [
            'text' => [
                'ru' => 'Создать новый заказ копированием текущего',
                'en' => 'To create a new order by copying this'
        ],
    ],

    'orderSave' => [
            'text' => [
                'ru' => 'Сохранить заказ',
                'en' => 'To save the order'
        ],
    ],
    'orderDelete' => [
            'text' => [
                'ru' => 'Удалить заказ',
                'en' => 'Delete the order'
        ],
    ],

];
$parts = [
    'current' => [
        'text' => [
            'ru' => 'Существующие заказы',
            'en' => 'Existing orders'
        ]
    ],
    'edit' => [
        'text' => [
            'ru' => 'Создать/изменить заказ',
            'en' => 'Create/edit ordering'
        ]
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