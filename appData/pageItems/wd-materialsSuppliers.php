<?php
/**
 * направление - Поставщики специализированных строительных материалов
 * Suppliers of specialised building materials
 */
$textRu = <<<TEXT
Федеральный портал «Перестройка» уделяет внимание не только строительным бригадам — подрядчикам в возведении,
 ремонте и демонтаже зданий и сооружений — но и сопутствующим товарам и услугам.
 Одним из значимых направлений выступает поставка специализированных строительных материалов, анкеров, строительных смесей,
  металлоконструкций и железобетонных изделий.

В Российской Федерации существует большое количество предприятий строительного сектора,
готовых доставить или отправить продукцию по всей стране.
 Сухие химические смеси, купить которые можно во Владивостоке или Калининграде,
 поставляются с заводов в Свердловской области, Пермском крае или Якутии.
  Мы предлагаем исключить логистические связи и приобретать материалы напрямую.
Какие мы предлагаем специализированные строительные материалы?

Практически все. Задавая в поиске «анкерный крепеж», вы получите отзывы поставщиков химического анкера, простого,
 распорного, клинового, забивного. Сухие строительные смеси это целый сегмент, где есть отделочные материалы,
 финишные, для гидроизоляции бетона, защиты металлоконструкций, огнебиозащиты дерева, иных направлений строительства.
На федеральном проекте «Перестройка» заказывают:

    - анкерный крепеж;
    - металлоконструкции;
    - бетон и ЖБИ;
    - сухие строительные смеси;
    - металлопрокат и его изготовление.

Доставка бетона от производителя позволит выбрать самое выгодное предложение с учетом местоположения, объема и качества.
 Схожая ситуация с металлопрокатом, купить который можно от тысяч поставщиков со всей страны.
 На федеральном проекте «Перестройка» вы вправе выбрать как готовые изделия, так и металлопрокат «на заказ»,
 исходя из сформированных потребностей.
Как выбрать поставщика строительных материалов.
Интересуйтесь, как давно работает компания по производству бетона, металлопроката, сухих строительных смесей.
 Какие проекты были реализованы, каков объем рекомендаций и рекламаций.
 Уточните, есть ли на производстве собственный технолог, выпускается ли продукция по франшизе или в рамках договора подряда?
  Обязательно уточните наличие собственных мощностей.

Ведя обсуждение поставки стройматериалов с другого города или субъекта страны, уточните затраты на доставку и
стоимость логистического плеча. Ведь, если анкерам или металлоконструкциям долгая доставка не повредит,
миксер с бетоном должен провести в дороге не более двух часов. Обязательно требуйте заключения договора —
а федеральный проект «Перестройка» в этом поможет!
TEXT;
$textEn = <<<TEXT
Federal portal "Restructuring" pays attention not only to the construction team — contractors in the construction,
repair and dismantling of buildings and structures — but related goods and services.
One of the important directions is the supply of specialized building materials, anchors, mortar,
steel structures and concrete products.

In the Russian Federation there are a large number of enterprises in the construction sector
ready to deliver or to ship products across the country.
Dry chemical compounds, which can be bought in Vladivostok or Kaliningrad
 supplied from the factories in the Sverdlovsk region, Perm region and Yakutia.
We propose to delete the logistics of communication and to purchase materials directly.
What we offer specialised building materials?

Almost everything. Asking search for "anchor fasteners", you will get reviews suppliers of chemical anchor, simple,
spacer, wedge, drop-in. Dry building mixes is a segment where there are decoration materials,
the finish, for concrete waterproofing, protection of steel structures, onebusaway wood, other areas of construction.
At the Federal project "the Rebuilding" order:

- the anchor fasteners;
- metal construction;
- concrete and concrete products;
- dry building mixes;
the metal and its manufacture.

Delivery of concrete from the manufacturer will allow you to select the most advantageous proposal, taking into account the location, volume and quality.
The situation is similar with metal, which you can buy from thousands of suppliers from all over the country.
At the Federal project "Restructuring" you may choose ready-made products, and metal products "to order",
on the basis of the generated needs.
How to choose a supplier of construction materials.
Ask how long the company operates in the production of concrete, metal, dry mixes.
What projects have been implemented, what is the volume of recommendations and complaints.
Specify whether the production of its own technology, produced the franchise or under contract?
Be sure to check the availability of own capacities.

Taking the discussion of deliveries of building materials from another city or subject of the country, specify the cost of shipping and
the cost of the logistics of the shoulder. After all, if the anchors or steel long delivery will not hurt
mixer with concrete needs to spend on the road no more than two hours. Necessarily require the conclusion of a contract is
a Federal project "Perestroika".
TEXT;
$pieceText = [
        'ru' => 'Федеральный портал «Перестройка» уделяет внимание не только строительным бригадам — подрядчикам в возведении,
 ремонте и демонтаже зданий и сооружений — но и сопутствующим товарам и услугам.
 Одним из значимых направлений выступает поставка специализированных строительных материалов, анкеров, строительных смесей,
  металлоконструкций и железобетонных изделий ...',
        'en' => 'Federal portal "Restructuring" pays attention not only to the construction team — contractors in the construction,
repair and dismantling of buildings and structures — but related goods and services.
One of the important directions is the supply of specialized building materials, anchors, mortar,
steel structures and concrete products ...'
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