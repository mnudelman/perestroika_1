<?php
/**
 * закладка - общие
 * Time: 16:10
 */
$title = [
        'ru' => 'Заказ. Рассылка',
        'en' => 'Order. Mailing'
];
$text_ru = <<<TEXT
На этой вкладке ЗАКАЗЧИК управляет рассылкой ИСПОЛНИТЕЛЯМ двух видов предложений:<br>
&nbsp;&nbsp;- Всем или отдельным ИСПОЛНИТЕЛЯМ рассылается предложение принять участие <br>
&nbsp;&nbsp;&nbsp; в конкурсе на выполнение работ по текущему ЗАКАЗУ.<br>
&nbsp;&nbsp;- Среди принявших предложение выбирается единственный и ему отсылается <br>
&nbsp;&nbsp;&nbsp; предложение ВЫПОЛНИТЬ ЗАКАЗ.<br><br>

Сайт выдаёт ЗАКАЗЧИКУ список ИСПОЛНИТЕЛЕЙ, в профиле которых указаны работы, требуемые для<br>
  выполнения ЗАКАЗА, и в географии работ указан город, в котром выполняется ЗАКАЗ. <br>
&nbsp;&nbsp;ЗАКАЗЧИК, с помощью ФИЛЬТРА (<i class="fa fa-filter"></i>) на панели иструментов, может ослабить требования к ИСПОНИТЕЛЮ.<br>
Это может потребоваться, если список найденных ИСПОЛНИТЕЛЕЙ не устроит ЗАКАЗЧИКА.<br>
&nbsp;&nbsp; - Он (ЗАКАЗЧИК) может выставить % выполняемых ИСПОЛНИТЕЛЕМ работ < 100 или(и)<br>
&nbsp;&nbsp; - условие нахождения города в географии работ ИСПОЛНИТЕЛЯ заменить на требование <br>
&nbsp;&nbsp;&nbsp;&nbsp; совпадения региона. <br>
Если при новых условиях отбора ИСПОЛНИТЕЛЕЙ появятся такие, которые его заинтересуют, то <br>
&nbsp;&nbsp; может путём ПЕРЕПИСКИ, уточнить с ЗАКАЗЧИКОМ условия и прийти к какому-то соглашению.<br>
&nbsp;&nbsp; ЗАКАЗЧИК, с помощью НАСТРОЙКИ (<i class="fa fa-cog"></i>) на панели иструментов, может управлять рассылкой предложений ЗАКАЗЧИКАМ. <br>
НАСТРОЙКА включает следующие параметры: количество рассылок; мах время ответа на предложение; <br>
ручной режим выбира ИСПОЛНИТЕЛЕЙ - адресатов рассылки<br>
После того как все подготовительные действия завершены, ЗАКАЗЧИК нажимает кнопку "отослать"(<i class="fa fa-send"></i>) на панели инструментов.

TEXT;
$text_en = <<<TEXT
TEXT;
$rules = [
    'title' => [
            'ru' => 'Рассылка предложений ИСПОЛНИТЕЛЯМ',
            'en' => 'Sending suggestions to the PERFORMERS'
    ],
    'content' => [
            'ru' => $text_ru,
            'en' => $text_en
    ]
];
$parts = [
    'current' => [
            'ru' => 'Исполнители заказа',
            'en' => 'the executors of the order'
    ],
    'edit' => [
            'ru' => 'Профиль исполнителя',
            'en' => 'Profile of the contractor'
    ],

] ;
return [
    'title' => $title,
    'rules' => $rules,
    'partsTitle' => $parts,
];