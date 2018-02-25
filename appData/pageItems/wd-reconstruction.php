<?php
/**
 * напрвление - реконструкция зданий и сооружений
 * Reconstruction of buildings and structures
 */
$textRu = <<<TEXT
Федеральный портал «Перестройка» усиливает присутствие на рынке страны. Реконструкция зданий и сооружений,
востребованная самыми разными слоями населения, представлена у нас тысячами строительных компаний различного уровня работ,
 технического оснащения и ценовой политики. Создавая заявку в рамках проекта,
 будьте уверены в правильном выборе и справедливой стоимости.

Направление по реконструкции сооружений достаточно специфично. Помимо технического оснащения строительных бригад и их опыта,
 важно наличие инженера по промышленному гражданскому строительству, знакомого с особенностями конструкций и способного
 рассчитать нагрузку в различных режимах эксплуатации. Не менее значим опыт по узакониванию реконструкции в БТИ и Госстройнадзоре.
Особенности реконструкции сооружений и зданий.

Реконструкция — синоним «восстановления с возвратом конструктивной целостности и назначения».
В этой связи крайне важна техническая подготовка коллектива и ранее реализованные проекты.
Сказываются налаженные связи с государственными органами в области строительства — от них зависит то,
 насколько быстро здание восстановят и примут в эксплуатацию.
Закажите на «Перестройке»:

    - обследование строительных конструкций зданий и сооружений;
    - согласование реконструкции;
    - выдачу заключения на возможность проведения реконструкции;
    - получение разрешения на эксплуатацию реконструируемого объекта.
    - выполнение полного комплекса реконструкционных работ.

Нередко специалисты приступают к работе, не разработав проект реконструкции здания,
что является грубейшим нарушением градостроительных норм. Федеральный проект «Перестройка» тщательно отбирает подрядчиков,
 уточняя возможность разработки документации по реконструкции зданий и объем ранее выполненных работ.
  Цель одна: предложить вам лучшие компании по реконструкции сооружений со всей страны!
Как выбрать бригаду по реконструкции здания.

Прежде всего, воспользуйтесь федеральным проектом «Перестройка»: выберите одно из ключевых направлений —
обследование строительных конструкций зданий и сооружений, согласование реконструкции,
выдачу заключения на возможность проведения реконструкции или выполнение полного комплекса реконструкционных работ.
Создайте заявку, кликните «Найти исполнителя».

Помните, что контроль над качеством работ, их скоростью и стоимостью лежит целиком на заказчике —
здесь портал «Перестройка» выступает площадкой, объединяющей людей со всей страны.
Требуйте заключения договора реконструкции, разработки проекта и одобрений Госстройнадзора и БТИ.
Благодаря этому реконструкция зданий и сооружений будет максимальной быстрой и удобной.
TEXT;
$textEn = <<<TEXT
Federal portal "Restructuring" reinforces the presence on the market of the country. Reconstruction of buildings and structures,
the most popular different segments of the population, we have provided thousands of construction companies at various levels of work
technical equipment and price policy. Creating the application project
be confident in the proper selection and fair value.

The direction of reconstruction works is quite specific. In addition to technical equipment, the construction crews and their experiences
 it is important the presence of the engineer in industrial and civil construction, familiar with the characteristics of the structures and are able
to calculate the load in different modes of operation. Not less significant experience in the legalization of redevelopment in the BTI and the state Inspectorate.
Features of reconstruction of structures and buildings.

Reconstruction — a synonym for "restoration with the return of structural integrity and purpose."
In this regard, critical technical training of staff and previously completed projects.
Affect established relations with the state bodies in the field of construction — depends on
 how fast the building recovers and will be in operation.
Ask for the "Restructuring":

- survey of construction of buildings and structures;
- coordination of reconstruction;
- issue conclusions on the possibility of reconstruction;
- obtaining a permit to operate the reconstructed object.
- execution of complex renovation work.

Often, professionals begin to work, not having developed the project of reconstruction of the building,
that is a gross violation of town planning rules. Federal project "Perestroika" carefully selects contractors
 stating the possibility of development of documentation for reconstruction of buildings and the amount of previously completed work.
One goal: to offer you the best companies for the reconstruction of buildings from across the country!
How to choose a team on reconstruction of the building.

First of all, take advantage of the Federal project "Perestroika": select one of the key areas —
the survey of construction of buildings and structures, coordination of reconstruction,
issue conclusions on the possibility of reconstruction or execution of complex renovation work.
Create an application, click "Find a contractor".

Remember that the control over the quality of work, their speed and cost lies entirely on the customer
here the portal "Restructuring" is a platform that brings together people from across the country.
Ask for a contract reconstruction, project design and approvals, construction supervision and BTI.
Due to this, reconstruction of buildings and structures will be maximum fast and convenient.
TEXT;

$pieceText = [
        'ru' => 'Федеральный портал «Перестройка» усиливает присутствие на рынке страны. Реконструкция зданий и сооружений,
востребованная самыми разными слоями населения, представлена у нас тысячами строительных компаний различного уровня работ,
 технического оснащения и ценовой политики. Создавая заявку в рамках проекта,
 будьте уверены в правильном выборе и справедливой стоимости ...',
        'en' => 'Federal portal "Restructuring" reinforces the presence on the market of the country. Reconstruction of buildings and structures,
the most popular different segments of the population, we have provided thousands of construction companies at various levels of work
technical equipment and price policy. Creating the application project
be confident in the proper selection and fair value ...'
];
return [
    'content' => [
            'ru' => $textRu,
            'en' => $textEn,
    ],
    'pieceText' => $pieceText,
];