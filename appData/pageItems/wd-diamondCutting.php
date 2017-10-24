<?php
/**
 * направление работ - алмазное бурение и резка бетона
 */
$textRu = <<< TEXT
Алмазное бурение  (сверление), технологических отверстий в железобетонных конструкциях :
стенах, перекрытиях, фундаментах, различного диаметра,
является современной технологией прохождения материалов.
Предназначенной для монтажа систем инженерных коммуникаций,
с целью обеспечения полноценного функционирования строящегося вновь или реконструируемого здания.
 Ключевое отличие и уникальность технологии алмазного бурения,
 заключается в получении технологических отверстий точной, изначально заданной,
 геометрической формы  (диаметра ). и необходимой глубины  (толщины ) , сквозных или " глухих " ,
 в зависимости от проектных задач.
 При использовании технологии алмазного бурения, на перфорируемую конструкцию,
 отсутствует воздействие ударных сил ,  поэтому, не происходит нарушения или потери конструктивной (несущей )
 способности строительных элементов зданий.
 Исключается (либо сводится к допустимому минимуму) , появление сколов, микротрещин, вибрационных разрушений.
Алмазное бурение отверстий производится полой металлической короной  (визуально напоминающей трубу ) ,
 с одной стороны, которой находится хвостовик  (предназначеный для соединения с валом двигателя, задающем ее вращение).
 И с другой - напаянными алмазными сегментами , которые и осуществляют режущее воздействие на перфорирумый материал.
 Двигатель, который придает вращение коронке , закрепляется на станине,
 обеспечивая точное управление процессом бурения оператором.
 Машины для безударного прохождения строительных конструкций. Называются установками алмазного  бурения .
  Между собой различаются по мощности двигателя  (влияет на минимальный и максимальный диаметр отверстий ),
   по типу привода двигателя (электрический, гидравлический, пневмотический ) .
   Ручные (для бурения малых диаметров,
   ( и станинные  (основное использование ). а также ценовой категорией ,
   в зависимости от производителя и различных функциональных и эргономических отличий.
TEXT;

$textEn = <<< TEXT
Diamond drilling (drilling), drilling in reinforced concrete structures :
walls, ceilings, and foundations of various diameters,
modern technology is passing materials.
Designed for the installation of utilities,
to ensure the full functioning of newly constructed or reconstructed buildings.
The key difference and the uniqueness of the technology of diamond drilling
is to obtain accurate holes, originally specified,
geometric shapes (diameter ). and the required depth (thickness ) , pass-through or "blind" ,
 depending on project tasks.
When the technology of diamond drilling in perforated design,
no impact forces , so, there is no breach or constructive loss (carrier )
the ability of construction elements of buildings.
Is eliminated (or reduced to an acceptable minimum) , the appearance of chips, cracks, vibration damage.
Diamond drilling holes is a hollow metal crown (resembling a pipe)
 on the one hand, which is the shank (designed for connection to the motor shaft, specify its rotation).
And with the other brazed diamond segments , which carry out a cutting effect on partrimony material.
The engine, which gives the rotation of the crown is fixed on the frame,
providing precise control of the drilling process by the operator.
Machines for non-impact passage of building structures. Referred to as installations of diamond drilling .
Among themselves differ in engine power (affects the maximum and minimum hole diameter ),
 type of drive motor (electric, hydraulic, pneumatic ) .
Manual (for drilling small diameters
( and an ancient dwelling (primary use ). and price category ,
depending on the manufacturer and the various functional and ergonomic differences.
TEXT;

$pieceText = [
    'text' => [
        'ru' => 'Алмазное бурение  (сверление), технологических отверстий в железобетонных конструкциях :
                 стенах, перекрытиях, фундаментах, различного диаметра,
                 является современной технологией прохождения материалов.
                 Предназначенной для монтажа систем инженерных коммуникаций,',
        'en' => 'Diamond drilling (drilling), drilling in reinforced concrete structures :
                 walls, ceilings, and foundations of various diameters,
                 modern technology is passing materials.
                 Designed for installation of engineering communications'
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