<?php
/**
 * Направление - аренда спец транспорта
 * Rent special vehicles
 */
$textRu = <<<TEXT
Федеральный портал «Перестройка» стремится удовлетворить все запросы граждан в области строительства, отделки, монтажа,
восстановления и демонтажа зданий и сооружений. Помимо приобретения материалов, бетона, металлоконструкций и ЖБИ,
 мы предлагаем воспользоваться арендой специального транспорта с персоналом (и без) для работы на площадке.

Поисковый алгоритм разработан таким образом, чтобы пользователь мог точно указать тип искомого транспортного средства.
 Это экскаваторы, автокраны, бульдозеры, манипуляторы, автовышки, компрессоры, бетононасосы, миксеры, оборудование для
 алмазной резки бетона и сверления. В рамках «Перестройки» присутствует практически все спецтехника для строительства.
Особенности аренды строительной техники на «Перестройке».

Выбирая конкретный тип техники, пользователь указывает, когда именно ему требуется услуга –
 для срочных заявок есть отметка «Прямо сейчас». Одновременно можно выбрать сразу несколько позиций,
 либо описать заявку и предложить арендодателю стройтехники самостоятельно определить объем и тип работ.
  Нередко опытные специалисты безошибочно определяют объем работ «на глаз».
На «Перестройке» арендуют:

    - гусеничную строительную технику;
    - колесную строительную технику;
    - компрессорные и генераторные установки;
    - миксеры и высотные бетононасосы;
    - оборудование для резки и сверления.

Для сужения поступающих заявок в поле «Описание Заказа» указывается город, местоположение объекта,
 объем работ и желаемая стоимость. И, напротив, когда пользователь планирует получить максимальный объем предложений
 об аренде специальной техники, он вправе прописать «рассмотрю ваши предложения».
Это реальная возможность выбора по справедливой цене.
Как арендовать спецтехнику для строительства?

Всероссийский проект «Перестройка» рекомендует начинать работу с приглашения инженеров по промышленному гражданскому строительству,
которые проведут замеры и подготовят проект. Далее пользователь запрашивает прайс работ у компаний-подрядчиков,
исходя из их компетенции и технических возможностей. Специальная техника арендуется исходя из перечня работ,
представленного техническим работником.

При проведении спецтехникой работ по монтажу-демонтажу сооружений и зданий,
также важно присутствие инженера ПГС – разумеется, если заказчик не обладает серьезными познаниями в этом деле.
Перед заключением договора аренды необходимо уточнить, какие проекты уже проводились,
 каков срок службы водителей и механиков и в каком состоянии находится специальная техника.
TEXT;
$textEn = <<<TEXT
Federal portal "Restructuring" aims to satisfy all the requests of the citizens in the field of construction, finishes, installation,
recovery and dismantling of buildings and structures. In addition to the acquisition of materials, concrete, steel structures and concrete
we offer rental of special transport resources (and without) to work on site.

The search algorithm is designed so that the user can accurately specify the type of the desired vehicle.
This excavators, cranes, bulldozers, cranes, aerial platforms, compressors, concrete pumps, mixers, equipment for
 diamond concrete cutting and drilling. In the framework of "Perestroika" is present in almost all of the machinery for construction.
Renting construction equipment in the "Restructuring."

Choosing the specific type of equipment, the user specifies when they need a service –
for urgent requests there is a mark "Right now." At the same time you can select multiple positions
or describe the application and offer the landlord construction equipment and to determine the amount and type of work.
Often experienced professionals accurately determine scope of work "by eye".
On "Restructuring" lease:

 - caterpillar construction equipment;
- wheeled construction equipment;
compressor and generator sets;
- high rise mixers and concrete pumps;
- equipment for cutting and drilling.

To restrict incoming requests in the "job Description" specifies the city, the location of the object,
the scope of work and desired cost. In contrast, when the user intends to obtain the maximum amount of offers
the rental of special equipment, he has the right to write "I will consider your offer."
It's a real choice at a fair price.
How to rent machinery for construction?

Russian project "Perestroika" recommends to start with the invitation of the engineers of industrial and civil construction,
who will conduct the measurements and prepare the project. Next, the user requests the price of the work to subcontractors,
on the basis of their competence and technical capabilities. Special equipment is rented on the basis of list of works
submitted to the technical worker.

When the equipment works on installation-dismantling of structures and buildings,
also important is the presence of civil engineering – of course, if the customer does not have great knowledge in this matter.
Before signing a lease agreement you need to clarify what projects have been conducted,
what is the lifespan of the drivers and mechanics and what is the status of special equipment.
TEXT;

$pieceText = [
        'ru' => 'Федеральный портал «Перестройка» стремится удовлетворить все запросы граждан в области строительства, отделки, монтажа,
восстановления и демонтажа зданий и сооружений. Помимо приобретения материалов, бетона, металлоконструкций и ЖБИ,
 мы предлагаем воспользоваться арендой специального транспорта с персоналом (и без) для работы на площадке...',
        'en' => 'Federal portal "Restructuring" aims to satisfy all the requests of the citizens in the field of construction, finishes, installation,
recovery and dismantling of buildings and structures. In addition to the acquisition of materials, concrete, steel structures and concrete
we offer rental of special transport resources (and without) to work on the site'
];
return [
    'content' => [
            'ru' => $textRu,
            'en' => $textEn,
    ],
    'pieceText' => $pieceText,
];