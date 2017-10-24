<?php
/**
 * закладка - Я -ИСПОЛНИТЕЛЬ. Список ЗАКАЗОВ
 *
 */
$title = [
    'text' => [
        'ru' => 'Список ЗАКАЗОВ B ИСПОЛНИТЕЛЯ',
        'en' => 'performer\'s orders.'
    ]
];
$text_ru = <<<TEXT
Каждая строка списка ЗАКАЗОВ имеет следующую структуру: <br>
1. Большая кнопка с № ЗАКАЗА, датой размещения ЗАКАЗА и названием. <br>
&nbsp;&nbsp; При нажатии этой кнопки открывается справка с основными характеристиками ЗАКАЗА. <br>
2. <button class="btn btn-primary btn-xs"> <i class="fa fa-caret-right"></i></button> - по этой кнопке в правой половине
 откроется полное описание ЗАКАЗА. <br>

3. Состояние ЗАКАЗА. На стороне ИСПОЛНИТЕЛЯ состояние ЗАКАЗА может быть следующим: <br>


&nbsp;&nbsp;10 - <button class="btn btn-default btn-xs"> <i class="fa fa-envelope-o"></i></button> -
              получено предложение от ЗАКАЗЧИКА на участие в конкурсе на выполнение ЗАКАЗА <br>

&nbsp;&nbsp;15 - <button class="btn btn-primary btn-xs"> <i class="fa fa-envelope-o"></i></button> -
              Подготовил согласие, но не отправил<br>
&nbsp;&nbsp;20 - <button class="btn btn-success btn-xs"> <i class="fa fa-envelope-o"></i></button> -
              Отправил согласие на участие в конкурсе.<br>

&nbsp;&nbsp;30 - <button class="btn btn-default btn-xs"> <i class="fa fa-thumbs-o-up"></i></button> -
              Получено предложения от ЗАКАЗЧИКА на ИСПОЛНЕНИЕ ЗАЗКАЗА<br>
&nbsp;&nbsp;35 - <button class="btn btn-primary btn-xs"> <i class="fa fa-thumbs-o-up"></i></button> -
              Согласился на ВЫПОЛНЕНИЕ.Но не отправил подтверждение<br>

&nbsp;&nbsp;40 - <button class="btn btn-success btn-xs"> <i class="fa fa-thumbs-o-up"></i></button> -
              Согласился на ВЫПОЛНЕНИЕ.Отправил подтверждение. Отправил ЗАКАЗЧИКУ свои
               реквизиты для связи (тел, email).<br>

4. <b>Кнопка изменения состояния ЗАКАЗА.</b> может иметь одно из следующих значений: <br>
<button class="btn btn-primary btn-xs"> <i class="fa fa-plus"></i></button> -
              Сдвигает состояние ЗАКАЗА "вперёд" (из состояния 10 -> 15, 30 -> 35) <br><button class="btn btn-primary btn-xs"> <i class="fa fa-minus"></i></button> -
              Сдвигает состояние ЗАКАЗА "назад" (из состояния 10 <- 15, 30 <- 35) <br>

<button class="btn btn-primary btn-xs" disabled="disabled"> <i class="fa fa-square-o"></i></button> -
              ЗАКАЗЧИК не может изменить состояние. Управление состоянием на "стороне" ИСПОЛНИТЕЛЯ <br>
<b> Замечание </b> Отправка подтверждений ЗАКАЗЧИКУ осуществляется кнопкой
 <button class="btn btn-primary btn-xs"> <i class="fa fa-send-o"></i></button> на панели инструментов.
TEXT;
$text_en = <<<TEXT
TEXT;
$rules = [
    'title' => [
        'text' => [
            'ru' => 'Список ЗАКАЗОВ',
            'en' => 'Orders list'
        ]
    ],
    'content' => [
        'text' => [
            'ru' => $text_ru,
            'en' => $text_en
        ]
    ]
];
return [
    'title' => $title,
    'rules' => $rules,
];