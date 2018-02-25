<?php
/**
 * Языковое оформление "Направления работ"
 */
$title = [
        'ru' => 'Направления работ',
        'en' => 'Work direction'
];
$text_ru = <<<TEXT
<b>1. Форма поделена на две половины:</b><br>
&nbsp;&nbsp;- левая - список выбранных направлений работ,<br>
&nbsp;&nbsp;- правая - область добавления новых направлений и область изменеий<br>
<b>2. Добавление нового направления</b><br>
&nbsp;&nbsp;- для добавления, надо выбрать в области добавления <i>направление работ</i>  и <br>
&nbsp;&nbsp;- нажать кнопку
<span class="glyphicon glyphicon-plus" style="color:white;background-color:green"></span>.
Направление вместе со списком включённых видов работ будет пренесёно в область изменений.<br>
<b>3. Область изменеий</b><br>
&nbsp;&nbsp;- Чтобы включить(или отключить) вид работ надо кликнуть по иконке напротив вида работ. <br>
&nbsp;&nbsp;- Можно включить направление целиком в работу. Для этого надо кликнуть по иконке рядом с <br>
&nbsp;&nbsp;с именем направления, поставить в положение: <span class="glyphicon glyphicon-lock"></span>
Если иконка в положении: <span class="glyphicon glyphicon-share"></span>, в работу будут включены<br>
&nbsp;&nbsp; только отмеченные виды работ.<br>
&nbsp;&nbsp;- Направление можно полностью исключить из работы, поставив вторую иконку в положение
<span class="glyphicon glyphicon-minus" style="color:white;background-color:red"></span><br>
&nbsp;&nbsp;- По кнопке "сохранить" все изменения по направлению будут перенесены в левую поолвину формы.<br>
<b>4. Область текущего состояния.</b><br>
&nbsp;&nbsp;- Рядом с именем направления имеется кнопка <span class="glyphicon glyphicon-edit"></span>
для перевода направления в область изменений.
TEXT;
$text_en = <<<TEXT
<b>1. The form is divided into two halves:</b><br>
&nbsp;&nbsp;- left - selected list of the areas of work,<br>
&nbsp;&nbsp;- right area of the add new directions and area of changes<br>
<b>2. Adding a new direction</b><br>
&nbsp;&nbsp;- to add, it is necessary to choose in the area add a <i>work</i> <br>
&nbsp;&nbsp;- click
<span class="glyphicon glyphicon-plus" style="color:white;background-color:green"></span>.
Direction together with the list of included types of work will be prenest in the area changes.<br>
<b>3. Region changes</b><br>
&nbsp;&nbsp;- to enable(or disable) the type of work it is necessary to click on the icon opposite. <br / >
&nbsp;&nbsp;- you Can include a direction wholly to the work. For this we need to click on the icon next to <br>
&nbsp;&nbsp;with the name of the direction, to position: <span class="glyphicon glyphicon-lock"></span>
If the icon position: <span class="glyphicon glyphicon-share"></span> work will be included<br>
&nbsp;&nbsp; only the checked activity types.<br>
&nbsp;&nbsp;- Direction can be completely excluded from the work, placing a second icon in the situation
<span class="glyphicon glyphicon-minus" style="color:white;background-color:red"></span><br>
&nbsp;&nbsp;- click "save" all changes in direction will be moved to the left to paolino form.<br>
<b>4. The scope of the current state.</b><br>
&nbsp;&nbsp;- the name of a direction button <span class="glyphicon glyphicon-edit"></span>
for the translation direction in the area changes.
TEXT;
$rules = [
    'title' => [
            'ru' => 'При формировании направлений работ, используйте правила:',
            'en' => 'In the formation of areas of work, use rules:'
    ],
    'content' => [
            'ru' => $text_ru,
            'en' => $text_en
    ]
];
$tooltips = [
    'itemEdit' => [
            'ru' => 'Редактировать направление',
            'en' => 'Edit direction'
    ],
    'itemAdd' => [
            'ru' => 'Добавить новое направление',
            'en' => 'add new direction'
    ],
    'subItemInWork' => [
        'no' => [
            'ru' => 'Работа не включена в выполняемый список.Нажмите, чтобы добавить',
            'en' => 'Work not included in the running list.Click to add'
        ],
        'yes' => [
                'ru' => 'Работа включёна в выполняемый список.Нажмите, чтобы удалить',
                'en' => 'Work is included in the running list.Click to remove'
        ],
    ],

    'itemFully' => [
        'yes' => [
                'ru' => 'Направление полностью в работе.Нажмите, чтобы включать только отдельные виды работ',
                'en' => 'Direction fully at work.Click to include only certain types of work'
        ],
        'no' => [
                'ru' => 'В выполняемом списке только отмеченные виды работ. Нажмите, чтобы включить всё направление',
                'en' => 'In the running list only the selected jobs. Click to turn on all direction'
        ],
    ],
    'itemDelete' => [
        'yes' => [
                'ru' => 'Направление полностью будет исключёно.Нажмите, чтобы включить',
                'en' => 'Region will be removed from work. Click to add'
        ],
        'no' => [
                'ru' => 'Направление включёно.Нажмите, чтобы исключить',
                'en' => 'The direction of inclusive.Click to exclude'
        ],
    ],

];
$parts = [
    'current' => [
            'ru' => 'Выбранные направления',
            'en' => 'The chosen direction'
    ],
    'add' => [
            'ru' => 'Добавить направление',
            'en' => 'Add direction'
    ],
    'edit' => [
            'ru' => 'Изменения',
            'en' => 'Changes'
    ],

] ;
return [
    'title' => $title,
    'rules' => $rules,
    'tooltips' => $tooltips,
    'partsTitle' => $parts,
    'buttons' => [
        'save' => [
            'text' => [
                'ru' => 'сохранить',
                'en' => 'save'
            ]
        ]
    ]
];