<?php
/**
 * Текст - введение на главной странице
 */
// @var $routeAbout
use yii\helpers\Html ;

$title = [
    'ru' => 'О САЙТЕ',
    'en' => 'ABOUT SITE',
] ;
$text_ru = <<<TEXT
<p>Портал "Перестройка" - это сервис быстрого поиска, объединяющий <b>заказчиков</b>
и <b>исполнителей работ</b>, поставщиков оборудования, материалов,
специализированной техники, связанных с перепланировкой помещений,
реконструкцией зданий и сооружений. </p>

<p>В этом проекте, мы сделали отраслевую сегментацию рынка строительных услуг с
целью упростить систему поиска, для заказчиков специализированных видов работ,
связанных с различными этапами изменения конструкций, окружающего нас жилого,
промышленного и социального секторов, зданий и сооружений.</p>

<p>Потребность в "Перестройке" существующего пространства, с целью улучшения,
 оптимизации или функционального изменения, возникает ежедневно.</p>

<p>Мы предлагаем вам двенадцать специализированных разделов, включающих <b>алмазную
резку бетона, демонтаж зданий, перепланировку, реконструкцию, проектирование и
другие</b>, в которых вы сможете сделать <a>заказ</a>, или <a>заявить о себе</a>
, как профессионал по представленным направлениям. </p>

<p><?= Html::a('подробнее о работе сайта',['about']) ?></p>

TEXT;
$text_en = <<<TEXT
<p>the Portal's "Perestroika" - a service for quick search, combining <b>customers</b>
and <b>contractors</b>, suppliers of equipment, materials,
specialized equipment associated with the redevelopment of premises,
reconstruction of buildings and structures. </p>

<p>In this project, we made a sectoral segmentation of the market of building services
in order to simplify the search system for clients of the specialized types of work
associated with the various stages of design modifications, the surrounding residential,
industrial and social sectors, buildings and structures.</p>

<p>the Need to "restructure" the existing space to improve,
optimization or functional changes, occurs daily.</p>

<p>We offer twelve specialized sections including <b>diamond
the concrete cutting, demolition, remodeling, renovation, design and
other</b>, in which you can do <a>purchase order</a> or <a>Express yourself</a>
as a professional in the following areas. </p>
<p><?= Html::a('read more about the website',['about']) ?></p>

TEXT;
return [
    'title' => $title ,
    'content' => [
        'ru' => $text_ru,
        'en' => $text_en,
    ],
] ;
