<?php
/**
 * напрвление - Поставщики оборудования и расходных материалов для алмазной резки и бурения
 * Suppliers of equipment and consumables for diamond cutting and drilling
 */
$textRu = <<<TEXT
Алмазная резка — важный этап при демонтаже зданий и сооружений, позволяющий быстро и оперативно разделять конструктивные элементы.
 При всем богатстве технических решений и инструментов, методика схожа: распил происходит с помощью диска,
  каната или сверла (алмазной коронки) с высокоуглеродистым напылением, схожим по структуре с настоящим алмазом.

Такому инструменту, фактически, безразлично, что разрушать. В перечне предложений федерального портала «Перестройка»
есть алмазная резка бетона канатом, алмазной струной, специальными усиленными сверлами.
 Он справляется как с очень твердыми материалами — вроде того же железобетона — так и с относительно хрупкими:
  кирпичом, пеноблоком, камнем-дикарем.
Богатство выбора от «Перестройки».

Обращаясь за помощью к федеральному проекту «Перестройка», важно определиться, какой именно тип работ или услуг вам требуется.
 Помимо непосредственно алмазной резки, здесь вы можете найти бригаду с оборудованием для алмазной резки,
  заказать аренду стенорезных машин, нарезчиков швов и электрических резчиков,
  а также изготовление алмазных коронок для камнерезного бурения.
У нас заказывают:

    - аренду стенорезных машин и нарезчиков швов;
    - установки алмазного бурения в железобетоне;
    - изготовление и установку алмазных коронок;
    - алмазные диски, канаты, струны и сопутствующие материалы;
    - услуги алмазной резки и сверлению железобетона.

Также алмазная резка является неотъемлемой часть монтажа-демонтажа зданий и сооружений и перепланировки помещений.
Она находит отражение в проектных работах (прайс предлагается подрядчиком),
но требует спецподготовки персонала, поэтому самостоятельный распил или сверление крайне нежелательны.
Помните: техника безопасности — первична!
Как выбрать подрядчика на алмазную резку?

Оставив на федеральном проекте «Перестройка» заявку и получив отклики — будь то резка алмазным канатом или диском —
уточните, как давно подрядчик специализируется на данном типе работ.
Есть ли профильное образование у операторов алмазной резки и допуск к специальной технике.
Не стесняйтесь задать вопрос о стоимости алмазной резки и факторах удорожания.

Вина за повреждения капитальных конструкций лежат на исполнителе, но ответственность с заказчика никто не снимал.
Перед тем, как заказать алмазную резку, обратитесь к проектантам в области ПГС — они проведут необходимые замеры и расчеты,
 что позволит избежать эксцессов в ходе проведения работ.
  И помните: резку бетона или камня алмазным инструментом лучше доверить профессионалам!

TEXT;
$textEn = <<<TEXT
Diamond cutting is an important step in the dismantling of buildings and structures, allowing you to quickly and efficiently separate structural elements.
With all the richness of technical solutions and tools, the technique is similar: cut with the disk,
rope or drill bit (diamond core bits) with a carbon coating, similar in structure to a real diamond.

This instrument, in fact, no matter what to destroy. In the list of proposals of the Federal portal "Perestroika"
diamond concrete cutting rope, diamond wire, reinforced with special drills.
 He's dealing with very hard materials like reinforced concrete and relatively fragile:
bricks, concrete blocks, stone-savage.
A wealth of choice from the "Perestroika".

Recourse to the Federal project "Restructuring", it is important to determine what type of work or services you require.
In addition to direct diamond cutting, here you can find a team with equipment for diamond cutting
to book a rental stenobitnyh machines, floor saws seams and electric carvers
as well as the manufacture of diamond bits for stone cutting drilling.
We ordered:

 - rent stenobitnyh machines and floor saws seams;
- installation of diamond drilling in reinforced concrete;
- fabrication and installation of the diamond bits;
- diamond blades, ropes, strings and related materials;
- services of diamond cutting and drilling concrete.

Diamond cutting is an integral part of the mounting and dismantling of buildings and structures and redevelopment areas.
It is reflected in the project work (the price proposed by the contractor),
but it requires special training of staff, so self-cutting or drilling is highly undesirable.
Remember: safety is the primary!
How to choose a contractor for diamond cutting?

Leaving the Federal project "Rebuilding" the application and receiving feedback — whether it's cutting with diamond wire or disk
ask how long the contractor specializiruetsya on this type of work.
Is there any specialized education, the operators of diamond cutting and access to technology.
Do not hesitate to ask a question about the cost of the diamond cutting and factors of cost.

The blame for damage to major structures lie on the contractor, but the responsibility to the customer has not been removed.
Before you order diamond cutting, contact the designers in the field of PGS, they will conduct the necessary measurements and calculations
in order to avoid excesses in the course of the work.
And remember: cutting of concrete or stone the diamond tool best left to professionals!
TEXT;

$pieceText = [
        'ru' => 'Алмазная резка — важный этап при демонтаже зданий и сооружений, позволяющий быстро и оперативно разделять конструктивные элементы.
 При всем богатстве технических решений и инструментов, методика схожа: распил происходит с помощью диска,
  каната или сверла (алмазной коронки) с высокоуглеродистым напылением, схожим по структуре с настоящим алмазом.
Такому инструменту, фактически, безразлично, что разрушать...',
        'en' => 'Diamond cutting is an important step in the dismantling of buildings and structures, allowing you to quickly and efficiently separate structural elements.
With all the richness of technical solutions and tools, the technique is similar: cut with the disk,
rope or drill bit (diamond core bits) with a carbon coating, similar in structure to a real diamond.
This instrument, in fact, no matter what to destroy...'
];
return [
    'content' => [
            'ru' => $textRu,
            'en' => $textEn,
    ],
    'pieceText' => $pieceText,
];