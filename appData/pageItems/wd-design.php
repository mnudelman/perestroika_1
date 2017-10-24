<?php
/**
 * Напрвление - проектные работы
 *Design work
 */
$textRu = <<<TEXT
Проектные работы по возведению сооружений и зданий — ключевое направление промышленного гражданского строительства.
  Федеральный портал «Перестройка» объединяет тысячи компаний со всей страны, предлагающих проектно-сметные работы,
  изыскательские, ведение проектной документации. Здесь вы можете уточнить срок выполнения и запросить прайс работ.

Схема работы «Перестройки» проста: вы регистрируетесь, выбираете одно из ключевых направлений —
создание эскизного проекта, архитектурно-строительных решений, проектирования инженерных систем, частного строительства,
зданий гражданского и промышленного назначения, стальных и конструктивных элементов сооружений и просто нажимаете «Найти исполнителя».
Почему проектные работы заказывают на «Перестройке».

Мы тщательно отбираем компании-подрядчики в области проектных работ и уточняем фактическую возможность их проведения,
наличие специального инструмента, количество ранее реализованных проектов и состав ИТР.
 Определяем базовую стоимость проектных работ — из чего она складывается, какие факторы оказывают наибольшее влияние.
Здесь вы вправе заказать создание и проектирование:

    - эскизного проекта;
    - архитектурно-строительных решений;
    - проектирования инженерных систем;
    - частного строительства, зданий гражданского и промышленного назначения;
    - стальных и конструктивных элементов сооружений.

Имеет значение и специфика подрядчика — насколько грамотно он разрабатывает проектную и сметную документацию,
 ведет проектно-изыскательские работы. Не секрет, что серьезные компании владеют целыми справочниками на
 проектную деятельность, что позволяют рассчитывать конкретное техническое задание с
 точностью до копейки и обоснованием всего процесса.
Как выбрать подрядчика на проектную работу?

После того, как с помощью федерального проекта «Перестройка» вы получили массу откликов,
 необходимо обсудить с подрядчиками конкретную проектную работу. Цену, срок исполнения, уровень подготовки и
 возможность сочетания различных направлений. Интересуйтесь наличием инженерно-технических работников —
 проектантов, сметчиков, специалистов по ПГС.

Если есть возможность, возьмите справочник цен базовых проектных работ и, хотя бы примерно,
высчитайте объективную стоимость. Заранее запросите прайс работ конкретной компании и
сравните нормочасы со специальной литературой. Требуйте заключения строгого договора и помните:
проект «Перестройка» лишь сводит заказчика и исполнителя, а контроль возложен полностью на вас.

TEXT;
$textEn = <<<TEXT
Design work for the construction of structures and buildings is a key area of industrial and civil construction.
Federal portal "Restructuring" brings together thousands of companies from all over the country, offering design-budget work,
survey, maintenance of project documentation. Here you can specify the deadline and request price works.

The scheme of "Restructuring" is simple: you register, select one of the key areas —
creation of conceptual design, architectural solutions, design, systems engineering, private construction,
buildings civil and industrial use, steel and structural elements of buildings and just click on "Find a contractor".
Why design work order for "Restructuring".

We carefully select the companies-contractors in the scope of the project and Refine the actual possibility of their implementation,
availability of special tools, the number of previously completed projects and personnel of engineers and technicians.
Determine the cost of design work — what does it comprise, what factors have the greatest impact.
Here you may enjoy creating and designing:

- conceptual design;
 - architectural and construction solutions;
- design of engineering systems;
- private construction, buildings, civil and industrial purposes;
- steel and structural elements of buildings.

Matters and specificity of a contractor is how well he develops the design and estimate documentation,
leads project and research work. It is no secret that the big companies own all directories on
project activities that allow us to calculate specific terms of reference with
accurate to the penny, and the rationale of the whole process.
How to choose a contractor for design work?

After using the Federal project "Restructuring," have you received a lot of feedback,
it is necessary to discuss with contractors the specific design work. Price, execution time, level of training and
the possibility of combining different directions. Ask about the presence of engineering-technical workers —
designers, quantity surveyors, specialists in PGS.

If possible, take reference prices of the base project work and, at least approximately,
calculate the objective value. Please find out in advance the price of work of a particular company and
compare the currently under way with the special literature. Ask to sign a strict contract and remember:
the project "Rebuilding" only brings the customer and the contractor, and control is vested entirely on you.
TEXT;

$pieceText = [
    'text' => [
        'ru' => 'Проектные работы по возведению сооружений и зданий — ключевое направление промышленного гражданского строительства.
  Федеральный портал «Перестройка» объединяет тысячи компаний со всей страны, предлагающих проектно-сметные работы,
  изыскательские, ведение проектной документации. Здесь вы можете уточнить срок выполнения и запросить прайс работ.',
        'en' => 'Design work for the construction of structures and buildings is a key area of industrial and civil construction.
Federal portal "Restructuring" brings together thousands of companies from all over the country, offering design-budget work,
survey, maintenance of project documentation. Here you can specify the deadline and request price works.'
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