<?php
/**
  * направление - перепланировка помещений
 * Redevelopment of premises
 */
$textRu = <<<TEXT
Задумавшись о перепланировке помещений, не обойтись без профессионалов, знакомых с требованиями БТИ, СанПиН, СНиП,
 иной нормативной базой. К счастью, федеральный портал «Перестройка» знает о планировке все и поможет выбрать
 оптимальный вариант по цене, качеству и объему услуг. Ведь большинство специалистов отрасли находятся здесь!

Создавая заявку посредством проекта, вы выбираете одно из нескольких ключевых направлений:
проектирования проемов в несущих стенах, фундаментах или перекрытиях,
согласования перепланировки жилых и нежилых помещений,
перевода помещения в нежилой фонд,
получения технического заключения для согласования перепланировки и выполнения всего комплекса сопутствующих работ.
Почему перепланировку заказывают в «Перестройке»?

Любые действия с несущими стенами и перегородками, изменяющие первоначальные габариты помещений,
должны согласовываться и узакониваться в БТИ — бюро технической инвентаризации.
В противном случае надзорный орган обратится в суд с требованием восстановления стен и перегородок.
 В ряде случаев — при переводе жилого помещения в нежилое — без справки из БТИ к работам не приступают.
Здесь вы закажете:

    - проектирование проемов в перекрытиях, фундаменте или несущих стенах;
    - согласование перепланировки нежилых помещений и жилых;
    - перевод помещения или целого здания в нежилой фонд;
    - техническое заключение БТИ на проведение работ, связанных с перепланировкой;
    - весь комплекс работ по строительству, связанный с перепланировкой.

В проекте учитывается все. Это назначение помещения, срок перевода в нежилую категорию,
 технические возможности несущих стен и даже размер дверного проема.
 В технических особенностях непросто даже подготовленному специалисту,
  не говоря о множестве противоречивых советов из интернета. Выход есть: заказать перепланировку помещений
  через федеральный проект «Перестройка».
Как отбирают специалистов на перепланировку?

В России есть десятки тысяч мастеров, занимающихся перепланировкой помещений с переводом в нежилой сектор и узакониванием в БТИ.
Специалисты «Перестройки» связываются с каждым из подрядчиков и уточняют,
как давно действует компания, каковы успешные проекты, с какими трудностями сталкиваются граждане и чем именно им можно помочь.
TEXT;
$textEn = <<<TEXT
Thinking about redevelopment areas, can not do without professionals who are familiar with the requirements of the BTI, SanPiN, SNiP,
a different regulatory framework. Fortunately, the Federal portal "Restructuring" knows all about the layout and help you choose
best option for price, quality and volume of services. Because most industry professionals are here!

Creating a request through the project, you choose one of several key areas:
design of openings in bearing walls, foundations or slabs,
harmonization of redevelopment of residential and non-residential premises,
translation premises in uninhabited Fund,
receiving technical advice for approval of redevelopment and the full range of associated works.
Why redevelop bought a "Restructuring"?

Any action with bearing walls and partitions that alter the original dimensions of the premises,
must be negotiated and usacheverse BTI — Bureau of technical inventory.
Otherwise, the Supervisory body will go to court to demand the restoration of walls and partitions.
In some cases when transferring to non-residential premises — without the help of the works not proceed.
Here you will order:

 - design of openings in slabs, foundations or bearing walls;
- harmonization of redevelopment of non-residential premises and residential;
- translation of the premise or the whole building to non-residential Fund;
technical conclusion BTI to carry out works associated with the redevelopment;
- the whole complex of construction works associated with the redevelopment.

The draft took account of all. It is the purpose of the premises, the term of translation into non-residential category
the technical capabilities of the bearing walls and even the size of the doorway.
The technical features difficult even for a trained technician
 not to mention the multitude of conflicting advice from the Internet. There is a solution: book the redevelopment of premises
through the Federal project "Rebuilding".
Employ specialists to redevelop?

In Russia there are tens of thousands of artists involved in the redevelopment of premises, translation of non-residential sector and the legalization of the BTI.
The specialists of "Realignment" associated with each of the contractors and clarifies
how long the company operates, what are the successful projects, what are the difficulties citizens face and what they can help.
TEXT;
$pieceText = [
    'text' => [
        'ru' => 'Задумавшись о перепланировке помещений, не обойтись без профессионалов, знакомых с требованиями БТИ, СанПиН, СНиП,
 иной нормативной базой. К счастью, федеральный портал «Перестройка» знает о планировке все и поможет выбрать
 оптимальный вариант по цене, качеству и объему услуг. Ведь большинство специалистов отрасли находятся здесь! ...',
        'en' => 'Thinking about redevelopment areas, can not do without professionals who are familiar with the requirements of the BTI, SanPiN, SNiP,
a different regulatory framework. Fortunately, the Federal portal "Restructuring" knows all about the layout and help you choose
best option for price, quality and volume of services. Because most industry professionals are here!'
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