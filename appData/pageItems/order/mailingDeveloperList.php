<?php
/**
 * закладка - Рассылка. Список исполнителей
 * Time: 16:10
 */
$title = [
        'ru' => 'Рассылка. Список исполнителей',
        'en' => 'The list of performers.'
];
$text_ru = <<<TEXT
Система строит <b>список ИСПОЛНИТЕЛЕЙ</b> на основе сравнения профиля ИМПОЛНИТЕЛЯ и требований ЗАКАЗА<br>
Каждая строка списка ИСПОЛНИТЕЛЕЙ имеет следующую структуру: <br>
1. Большая кнопка с названием фирмы ИСПОЛНИТЕЛЯ. <br>
&nbsp;&nbsp; При нажатии на эту кнопку открывается справка с основными характеристиками ИСПОЛНИТЕЛЯ. <br>
2. <button class="btn btn-primary btn-xs"> <i class="fa fa-caret-right"></i></button> - по этой кнопке в правой половине
 откроется профиль ИСПОЛНИТЕЛЯ. <br>

3. оценка совпадения набора работ в профиле ИСПОЛНИТЕЛЯ и требований ЗАКАЗА<br>
&nbsp;&nbsp; С помощью фильтра (<i class="fa fa-filter"></i>) ЗАКАЗЧИК может изменять требования к профилю
 ИСПОЛНИТЕЛЯ. Визуальное выражение степени совпадения набора работ может быть следующим:<br>
 <button class="btn btn-danger btn-xs"> <i class="fa fa-battery-half"></i></button> -  >= 50% совпадений <br>
 <button class="btn btn-warning btn-xs"> <i class="fa fa-battery-three-quarters"></i></button> -  >= 75% совпадений <br>
<button class="btn btn-success btn-xs"> <i class="fa fa-battery-full"></i></button> -  100% совпадений <br>

4. оценка совпадения географии работ ИСПОЛНИТЕЛЯ и требований ЗАКАЗА<br>
<button class="btn btn-danger btn-xs"> <i class="fa fa-battery-half"></i></button> - 50% - совпадает только регион  <br>
<button class="btn btn-success btn-xs"> <i class="fa fa-battery-full"></i></button> - 100% - совпадает регион и город<br>

5. Состояние ЗАКАЗА. На стороне ЗАКАЗЧИКА состояние ЗАКАЗА может быть следующим: <br>

0 - <button class="btn btn-primary btn-xs"> <i class="fa fa-frown-o"></i></button> -
              предложение ИСПОНИТЕЛЮ не сделано <br>

5 - <button class="btn btn-default btn-xs"> <i class="fa fa-envelope-o"></i></button> -
              предложение ИСПОНИТЕЛЮ подготовлено, но не отправлено <br>

10 - <button class="btn btn-primary btn-xs"> <i class="fa fa-envelope-o"></i></button> -
              предложение ИСПОНИТЕЛЮ  отправлено <br>

20 - <button class="btn btn-success btn-xs"> <i class="fa fa-envelope-o"></i></button> -
              получено согласие от ИСПОЛНИТЕЛЯ на участие в конкурсе на выполнение работ по ЗАКАЗУ<br>

25 - <button class="btn btn-default btn-xs"> <i class="fa fa-thumbs-o-up"></i></button> -
              ЗАКАЗЧИК выбрал данного ИСПОЛНИТЕЛЯ, но предложение не отправил<br>

30 - <button class="btn btn-primary btn-xs"> <i class="fa fa-thumbs-o-up"></i></button> -
              ЗАКАЗЧИК выбрал данного ИСПОЛНИТЕЛЯ и отправил предложение<br>

40 - <button class="btn btn-success btn-xs"> <i class="fa fa-thumbs-o-up"></i></button> -
              Получено подтверждение от ИСПОЛНИТЕЛЯ на выполнение работ по ЗАКАЗУ<br>

5. <b>Кнопка изменения состояния ЗАКАЗА.</b> может иметь одно из следующих значений: <br>
<button class="btn btn-primary btn-xs"> <i class="fa fa-plus"></i></button> -
              Сдвигает состояние ЗАКАЗА "вперёд" (из состояния 0 -> 5, 20 -> 25) <br>
<button class="btn btn-primary btn-xs"> <i class="fa fa-minus"></i></button> -
              Сдвигает состояние ЗАКАЗА "назад" (из состояния 0 <- 5, 20 <- 25) <br>

<button class="btn btn-primary btn-xs" disabled="disabled"> <i class="fa fa-square-o"></i></button> -
              ЗАКАЗЧИК не может изменить состояние. Управление состоянием на "стороне" ИСПОЛНИТЕЛЯ <br>
<b> Замечание </b> Отправка предложений ИСПОЛНИТЕЛЯМ осуществляется кнопкой
 <button class="btn btn-primary btn-xs"> <i class="fa fa-send-o"></i></button> на панели инструментов.
TEXT;
$text_en = <<<TEXT
TEXT;
$rules = [
    'title' => [
            'ru' => 'Список ИСПОЛНИТЕЛЕЙ',
            'en' => 'The list of performers'
    ],
    'content' => [
            'ru' => $text_ru,
            'en' => $text_en
    ]
];
return [
    'title' => $title,
    'rules' => $rules,
];