<?php
/**
 * Языковое оформление "Географии работ"
 */
$title = [
        'ru' => 'География работ',
        'en' => 'Geography of works'
];
$text_ru = <<<TEXT
<b>1. Форма поделена на две половины:</b><br>
&nbsp;&nbsp;- левая - список регионов, составляющих геграфию работ,<br>
&nbsp;&nbsp;- правая - область добавления новых регионов и область изменеий<br>
<b>2. Добавление нового региона</b><br>
&nbsp;&nbsp;- для добавления, надо выбрать в области добавления <i>страну,регион</i>  и <br>
&nbsp;&nbsp;- нажать кнопку
<span class="glyphicon glyphicon-plus" style="color:white;background-color:green"></span>.
Регион вместе со списком своих городов будет пренесён в область изменений.<br>
<b>3. Область изменеий</b><br>
&nbsp;&nbsp;- Чтобы включить(или отключить) город надо кликнуть по иконке напротив имени города. <br>
&nbsp;&nbsp;- Можно включить регион целиком в работу. Для этого надо кликнуть по иконке рядом с <br>
&nbsp;&nbsp;с именем региона, поставить в положение: <span class="glyphicon glyphicon-lock"></span>
Если иконка в положении: <span class="glyphicon glyphicon-share"></span>, в работу будут включены<br>
&nbsp;&nbsp; только отмеченные города.<br>
&nbsp;&nbsp;- Регион можно полностью исключить из работы, поставив вторую иконку в положение
<span class="glyphicon glyphicon-minus" style="color:white;background-color:red"></span><br>
&nbsp;&nbsp;- По кнопке "сохранить" все изменения по региону будут перенесены в левую поолвину формы.<br>
<b>4. Область текущего состояния.</b><br>
&nbsp;&nbsp;- Рядом с именем региона имеется кнопка <span class="glyphicon glyphicon-edit"></span>
для перевода региона в область изменений.
TEXT;
$text_en = <<<TEXT
<b>1. The form is divided into two halves:</b><br>
&nbsp;&nbsp;- left - the list of regions that constitute the geography of works,<br>
&nbsp;&nbsp;- right area of the add new regions and the area of changes<br>
<b>2. Add new region</b><br>
&nbsp;&nbsp;- to add, it is necessary to choose in the area add a <i>country,region</i> and <br>
&nbsp;&nbsp;- click
<span class="glyphicon glyphicon-plus" style="color:white;background-color:green"></span>.
Region together with a list of its cities will prenest in the area changes.<br>
<b>3. Region changes</b><br>
&nbsp;&nbsp;- to enable(or disable) the city it is necessary to click on the icon next to the name of the city. <br / >
&nbsp;&nbsp;- you Can turn the whole region into work. For this we need to click on the icon next to <br>
&nbsp;&nbsp;with the name of the region to position: <span class="glyphicon glyphicon-lock"></span>
If the icon position: <span class="glyphicon glyphicon-share"></span> work will be included<br>
&nbsp;&nbsp; only marked by the city.<br>
&nbsp;&nbsp;- Region can be completely excluded from the work, placing a second icon in the situation
<span class="glyphicon glyphicon-minus" style="color:white;background-color:red"></span><br>
&nbsp;&nbsp;- On the "save" button all the changes in the region will be moved to the left to paolino form.<br>
<b>4. The scope of the current state.</b><br>
&nbsp;&nbsp;- Next to the name of the region there is a button <span class="glyphicon glyphicon-edit"></span>
for the transfer of the region in the area of change.
TEXT;
$rules = [
    'title' => [
            'ru' => 'При формировании географии работ, используйте правила:',
            'en' => 'When forming geography works, use the rules:'
    ],
    'content' => [
            'ru' => $text_ru,
            'en' => $text_en
    ]
];
$tooltips = [
    'itemEdit' => [
            'ru' => 'Редактировать регион',
            'en' => 'region edit'
    ],
    'itemAdd' => [
            'ru' => 'Добавить новый регион',
            'en' => 'add new region'
    ],
    'subItemInWork' => [
        'no' => [
            'ru' => 'Город не включён в работу.Нажмите, чтобы добавить',
            'en' => 'City removed from work. Click to add'
        ],
        'yes' => [
                'ru' => 'Город включён в работу.Нажмите, чтобы удалить',
                'en' => 'City in work. Click to remove'
        ],
    ],

    'itemFully' => [
        'yes' => [
                'ru' => 'Регион весь полностью в работе.Нажмите, чтобы включать только отдельные города',
                'en' => 'Region fully in work. Click to select individual cities'
        ],
        'no' => [
                'ru' => 'в работе только отмеченные города. Нажмите, чтобы включить весь регион',
                'en' => 'you may select individual cities. Click to select region fully'
        ],
    ],
    'itemDelete' => [
        'yes' => [
                'ru' => 'Регион полностью будет исключён из работы.Нажмите, чтобы включить',
                'en' => 'Region will be removed from work. Click to add'
        ],
        'no' => [
                'ru' => 'Регион всключён в работы.Нажмите, чтобы исключить',
                'en' => 'Region will be in work. Click to remove'
        ],
    ],

];
$parts = [
    'current' => [
            'ru' => 'Текущие регионы',
            'en' => 'Current regions'
    ],
    'add' => [
            'ru' => 'Добавить регион',
            'en' => 'Add region'
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
                'ru' => 'сохранить',
                'en' => 'save'
        ]
    ]
];