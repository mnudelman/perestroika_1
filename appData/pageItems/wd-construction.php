<?php
/**
 * направление - строительные работы
 * Construction work
 * Time: 15:01
 */
$textRu = <<<TEXT
Федеральный проект «Перестройка» знает, как сложно найти бригаду строителей при всем богатстве предложений.
От профессионализма мастеров, технической подготовки и  скорости зависит не только прайс работ, но и скорость и качество.
 Не ищите в интернете «найти строителей недорого», сделайте заявку на сайте, укажите пожелания, и они сами выйдут на связь.

Перечень строительных работ обширен, а хорошие мастера-универсалы встречаются редко.
К примеру, бригада по бетонированию может не заниматься монтажом ЖБИ, а специалист по кладке камня не станет браться за
 фасадные и кровельные проекты. От правильного создания заявки в рамках «Перестройки» зависит то,
 какие именно строители вас выберут.
Почему строительные работы заказывают на «Перестройке»?

Будучи федеральным порталом о строительстве, «Перестройка» объединяет тысячи строительных бригад
(недорогих и премиум-класса) со всей страны. Тщательный отбор по количеству сотрудников, оборудованию,
 технической подготовке и образованию позволяет предлагать пользователям только лучших специалистов по справедливой цене.
На «Перестройке» вы найдете специалистов по:

    - бетонированию и монтажу ЖБИ;
    - кладочным и сварочным работам;
    - кровельным работам и отделке фасадов;
    - монтажу железобетонных конструкций;
    - внутренней отделке помещений.



Обратим внимание, что проект «Перестройка» выступает независимым и объективным посредником в подборе специалистов по строительству.
 Создаваемая вами заявка – по отделочным работам, капитальному ремонту, монтажу металлоконструкций и ЖБИ – это оферта,
 согласие подрядчика – акцепт. Контроль качества получаемой услуги лежит полностью на заказчике.
Как правильно выбрать подрядчика на строительные работы?

Прежде всего, определитесь с их типом, будь то сварочные работы, кладка кирпича, ремонт фасадов или внутренняя отделка.
 Создавая заявку, укажите пожелания, дабы сузить объем потенциальных подрядчиков.
 Общаясь с исполнителями, уточняйте, как давно они ведут деятельность, реализовали ли раньше подобные проекты,
  с какими препонами столкнулись.

Задавайте вопросы о технической подкованности специалистов по ремонту, наличии инженера ПГС и сроках выполнения заявки.
 Требуйте заключения договора с указанием ответственного лица, стоимости строительных работ и юридического или
 физического лица-подрядчика. Помните, что качество зависит от вашего  контроля, а «Перестройка» поможет сделать правильный выбор!
TEXT;
$textEn = <<<TEXT
<h2>Construction work</h2>
Federal project "Perestroika" knows how hard it is to find a team of builders with all the richness of proposals.
From the professionalism of the masters, technical training and speed depends not only price, but also the speed and quality.
Don't search online "to find inexpensive builders", place your order on the website, enter requests, and they will be in touch.

The list of construction works extensive, and a good master-rounders are rare.
For example, a team of concreting may not engage in the installation of concrete, and a specialist in the masonry of the stone will not be taken for
 facade and roofing projects. Right from creation of the requisition in the "Adjustment" depends on
what kind of builders you choose.
Why work order for "Restructuring"?

As a Federal portal about construction, "Restructuring" brings together thousands of construction crews
(inexpensive and premium) from across the country. Careful selection of the number of employees, equipment,
technical training and education allows us to offer users only the best professionals at a fair price.
To "Rebuild" you'll find specialists in:

- concreting and installation of concrete products;
 - masonry and welding works;
- roofing and facades;
- installation of reinforced concrete structures;
- interior decoration.



Note that the project "Restructuring" is an independent and objective mediator in the recruitment of construction professionals.
You create an application for painting and decorating, major repair, installation of steel structures and reinforced concrete is the offer,
the consent of the contractor acceptance. The control of the quality of services lies with the customer.
How to choose a contractor for the construction work?

First of all, let's define their type, whether by welding, bricklaying, repair of facades or interior.
Creating the application, specify wishes in order to narrow the scope of potential contractors.
Communicating with the performers, ask them how long they are in business, have earlier similar projects,
what obstacles are faced.

Ask questions about the technical expertise of specialists in repair, civil engineering and timing of the application.
Ask for a contract indicating the responsible persons of the construction costs, and legal or
 a natural person-the contractor. Remember that the quality depends on your control and "Restructuring" will help you make the right choice!
TEXT;

$pieceText = [
        'ru' => 'Федеральный проект «Перестройка» знает, как сложно найти бригаду строителей при всем богатстве предложений.
                 От профессионализма мастеров, технической подготовки и  скорости зависит не только прайс работ,
                 но и скорость и качество.
                 Не ищите в интернете «найти строителей недорого», сделайте заявку на сайте...',
        'en' => 'Federal project "Perestroika" knows how hard it is to find a team of builders with all the richness of proposals.
                 From the professionalism of the masters, technical training and speed depends not only on the price of the work,
                 but the speed and quality.Don\'t search online  "to find inexpensive builders", make a request on the website...'
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