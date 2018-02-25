<?php
/**
 * направление - демонтаж зданий и сооружений
 * Dismantling of buildings and structures
 */
$textRu = <<<TEXT
Федеральный проект «Перестройка» объединяет десятки тысяч заказчиков и исполнителей со всей страны.
Озадачившись поиском бригады по монтажу-демонтажу зданий и сооружений, вы исследуете сотни сайтов в поисках
самых выгодных расценок демонтажа. Цена играет важную роль, но выбор зависит от качества, скорости работ и
технической подготовки бригады.

Сносом несущих стен, равно как и старого фундамента, занимаются специалисты в области промышленного и
гражданского строительства. Нередко пользователи запрашивают прайс работ и выясняют, что он носит примерный характер —
 те или иные демонтажные работы подрядчиком не оказываются. Чтобы не оказаться в такой ситуации,
 лучше пользоваться проектом «Перестройка».
Почему демонтаж зданий и сооружений заказывают в «Перестройке»?

Строительные предприятия, ведущие демонтаж зданий, проходят строгую проверку нашим проектом.
На «Перестройке» заказывают демонтаж зданий и сооружений:

    -вручную — высотой до трех этажей;
    -экскаваторами — высотой выше трех этажей;
    -гидромолотами, миниэкскаваторами;
    -методом подрыва с привлечением специалистов;
    -электрогазосваркой — для металлоконструкций.

Демонтаж зданий это специфическая сфера, требующая серьезной практической и теоретической подготовки.
 Нередко малые компании, специализирующиеся на одном-двух типах демонтажных работ, берутся за комплексные услуги:
 снос домов, монтаж-демонтаж несущих стен или гарантируют разобрать дом в кратчайшие сроки.
  Проект «Перестройка» позволяет их «отсечь» в пользу действительно сильных специалистов.
Как выбрать подрядчика на демонтаж зданий и сооружений?

Выбирайте подрядчика из своего или соседнего города — это позволит снизить стоимость за
счет выезда бригады и доставки оборудования. Обратите внимание на прайс работ и сравните его с иными компаниями,
 ведущими монтаж-демонтаж. Очень низкая цена демонтажа должна свидетельствовать о «подводных камнях» в процессе работ,
 а высокая — на мысли об оправданности цены.


TEXT;

$textEn = <<<TEXT
Federal project "Restructuring" brings together tens of thousands of customers and performers from across the country.
Puzzled by search crews on installation-dismantling of buildings and structures, you can explore hundreds of sites in search
the most favourable rate of removal. Price plays an important role, but the choice depends on the quality, speed of work and
technical training team.

Demolition of load-bearing walls, as well as the old Foundation, by specialists in the field of industrial and
civil engineering. Often users request the price of the work and find out that it was illustrative —
 certain demolition work the contractor shall not be. Not to be in such a situation,
better to use the project "Rebuilding".
Why the dismantling of buildings and structures bought in the "Perestroika"?

Construction companies, leading to the dismantling of buildings, subjected to severe tests in our project.
On "Restructuring" order the removal of buildings and structures:

-by hand — up to three floors;
-excavators — height three stories;
-hydraulic hammers, mini excavators;
-blasting with specialists;
-elektrolesovskaya for steel structures.

Dismantling of buildings is a specific field that requires significant practical and theoretical training.
Often small companies specializing in one or two types of demolition work, to undertake comprehensive services:
the demolition of houses, the Assembly and dismantling of load-bearing walls or guaranteed to tear the house promptly.
The project "the Restructuring" allows them to "cut off" in favor of really strong professionals.
How to choose a contractor for dismantling of buildings and structures?

Choose a contractor from our own or neighbouring cities — this will reduce the cost for
the expense of the team and the delivery of the equipment. Please note the price of the work and compare it with other companies
leading the Assembly and dismantling. Very low cost of dismantling must testify about the "pitfalls" in the process,
and high — thinking about the justification of prices.
TEXT;

$pieceText = [
        'ru' => 'Федеральный проект «Перестройка» объединяет десятки тысяч заказчиков и исполнителей со всей страны.
Озадачившись поиском бригады по монтажу-демонтажу зданий и сооружений, вы исследуете сотни сайтов в поисках
самых выгодных расценок демонтажа. Цена играет важную роль, но выбор зависит от качества, скорости работ и
технической подготовки бригады ...',
        'en' => 'Federal project "Restructuring" brings together tens of thousands of customers and performers from across the country.
Puzzled by search crews on installation-dismantling of buildings and structures, you can explore hundreds of sites in search
the most favourable rate of removal. Price plays an important role, but the choice depends on the quality, speed of work and
technical training team ...'
];
return [
    'content' => [
            'ru' => $textRu,
            'en' => $textEn,
    ],
    'pieceText' => $pieceText,
];