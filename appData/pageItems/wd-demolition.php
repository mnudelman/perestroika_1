<?php
/**
 * направление - демонтажные работы
 * Demolition work
 */
$textRu = <<< TEXT
Поиск специалистов, способных быстро и качественно провести демонтажные работы, может растянуться на месяцы.
 Помимо специального оборудования, мастера должны иметь образование в области монтажа-демонтажа,
  соблюдать технику безопасности и предлагать справедливую цену, соответствующую объему и качеству планируемых работ.

Цена демонтажа несущих стен различается со стоимостью бетонных работ,
а снос старого фундамента несопоставим с демонтажем кровли.
При выборе подрядчика важно точно определить объем работ по демонтажу (стен или окон) и определить ценовой диапазон.
 Но и более высокая стоимость демонтажа не является залогом более высокого качества работ.
Как выбрать подрядчика на демонтаж?

Обратите внимание на количество реализованных им проектов по строительному демонтажу,
 применяемые инструменты, количество человек в строительной бригаде,
  наличие прораба, мастера, инженера по промышленно-гражданскому строительству.
   Нередко они специализируются на одном-двух типах работ — демонтаже кровли, окон или всей квартиры.
На «Перестройке» заказывают демонтаж:

    - старых фундаментов;
    - несущих стен и перегородок;
    - напольных и потолочных покрытий;
    - кровли, окон и квартир;
    - металлоконструкций и бетона.

TEXT;
$textEn = <<< TEXT
 Search for specialists that can quickly and efficiently carry out demolition works, can take months.
Besides the special equipment, the master must have education in the field of mounting and Dismounting,
to comply with safety regulations and offer a fair price, corresponding quantity and quality of planned works.

The price of dismantling the bearing walls varies with the cost of concrete
and the demolition of the old Foundation is not comparable with the dismantling of the roof.
When choosing a contractor it is important to accurately determine the amount of dismantling (wall or window) and determine the price range.
 But the higher the cost of dismantling is not a guarantee of higher quality works.
How to choose a contractor for demolition?

Note the number of the realized projects on construction and dismantling
the tools, the number of people in the construction team,
the presence of a foreman, craftsman, engineer, industrial civil construction.
They often spetsializiruyutsya on one or two types of works dismantling of roof, Windows or the entire apartment.
On "Restructuring" order of dismantling:

- old foundations;
- load-bearing walls and partitions;
 - floor and ceiling coverings;
roof, Windows and apartments;
- steel and concrete.
TEXT;

$pieceText = [
    'text' => [
        'ru' => 'Поиск специалистов, способных быстро и качественно провести демонтажные работы, может растянуться на месяцы.
                 Помимо специального оборудования, мастера должны иметь образование в области монтажа-демонтажа,
                 соблюдать технику безопасности и предлагать справедливую цену, соответствующую объему и качеству планируемых работ...',
        'en' => 'Search for specialists that can quickly and efficiently carry out demolition works, can take months.
                 Besides the special equipment, the master must have education in the field of mounting and Dismounting,
                 to comply with safety regulations and offer a fair price, corresponding quantity and quality of planned works...'
    ]
];
return [
    'content' => [
        'text' => [
            'ru' => $textRu,
            'en' => $textEn,
        ],
    ],
    'pieceText' => $pieceText,
];