<?php
/**
 * закладка - Рассылка. Список исполнителей
 * Time: 16:10
 */
$title = [
        'ru' => 'Прохождение заказа',
        'en' => 'the order passing.'
];
$text_ru = <<<TEXT

<b>В процессе выполнения ЗАКАЗ проходит следующие состояния:</b> <br>
<b>на стороне ЗАКАЗЧИКА : </b> <br>
&nbsp;&nbsp;0 - <button class="btn btn-primary btn-xs"> <i class="fa fa-frown-o"></i></button> -
              предложение ИСПОНИТЕЛЮ не сделано  -----------------------------
             <button class="btn btn-primary btn-xs" title="переключить в следующее состояние">
              <i class="fa fa-plus"></i></button>  ==> <b>(5)</b><br>

&nbsp;&nbsp;5 - <button class="btn btn-default btn-xs"> <i class="fa fa-envelope-o"></i></button> -
              предложение ИСПОНИТЕЛЮ подготовлено, но не отправлено . Можно сбросить  --
             <button class="btn btn-primary btn-xs"  title="переключить в предыдущее состояние"> <i class="fa fa-minus"></i></button>  ==> <b>(0)</b> ИЛИ <br>
-----------------------разослать подготовленные предложения ИСПОЛНИТЕЛЯМ ---------------------------------------
панель инмтрументов: <button class="btn btn-primary btn-xs" title="отправить ИСПОЛНИТЕЛЮ"> <i class="fa fa-send-o"></i></button>  ==> <b>(10)</b><br>
&nbsp;&nbsp;10 - <button class="btn btn-primary btn-xs"> <i class="fa fa-envelope-o"></i></button> -
              предложение ИСПОНИТЕЛЮ  отправлено. Управление состоянием ЗАКАЗА на стороне ИСПОЛНИТЕЛЯ. <br>

<br><b>на стороне ИСПОЛНИТЕЛЯ : </b> <br>
&nbsp;&nbsp;10 - <button class="btn btn-default btn-xs"> <i class="fa fa-envelope-o"></i></button> -
              получено предложение от ЗАКАЗЧИКА ---------------------
             <button class="btn btn-primary btn-xs" title="переключить в следующее состояние">
              <i class="fa fa-plus"></i></button>  ==> <b>(15)</b><br>

&nbsp;&nbsp;15 - <button class="btn btn-primary btn-xs"> <i class="fa fa-envelope-o"></i></button> -
              Подготовил согласие, но не отправил . Можно сбросить  -----
             <button class="btn btn-primary btn-xs"  title="переключить в предыдущее состояние">
             <i class="fa fa-minus"></i></button>  ==> <b>(10)</b> ИЛИ <br>
-----------------------отправить согласие на участие в конкурсе ЗАКАЗЧИКУ ---------------------------------------
панель инмтрументов: <button class="btn btn-primary btn-xs" title="отправить ЗАКАЗЧИКУ">
<i class="fa fa-send-o"></i></button>  ==> <b>(20)</b><br>


&nbsp;&nbsp;20 - <button class="btn btn-success btn-xs"> <i class="fa fa-envelope-o"></i></button> -
              Отправил согласие на участие в конкурсе. Управление состоянием ЗАКАЗА на стороне ЗАКАЗЧИКА. <br><br>


<b>на стороне ЗАКАЗЧИКА : </b> <br>
20 - <button class="btn btn-success btn-xs"> <i class="fa fa-envelope-o"></i></button> -
              получено согласие от ИСПОЛНИТЕЛЯ на участие в конкурсе на выполнение работ по ЗАКАЗУ
               ---------------------
             <button class="btn btn-primary btn-xs" title="переключить в следующее состояние">
              <i class="fa fa-plus"></i></button>  ==> <b>(25)</b><br>

25 - <button class="btn btn-default btn-xs"> <i class="fa fa-thumbs-o-up"></i></button> -
              ЗАКАЗЧИК выбрал данного ИСПОЛНИТЕЛЯ, но предложение не отправил. Можно сбросить  --------
             <button class="btn btn-primary btn-xs"  title="переключить в предыдущее состояние">
             <i class="fa fa-minus"></i></button>  ==> <b>(20)</b> ИЛИ <br>
-----------------------отправить предложение на ИСПОЛНЕНИЕ ЗАКАЗА  -----------------------
панель инмтрументов: <button class="btn btn-primary btn-xs" title="отправить ИСПОЛНИТЕЛЮ">
<i class="fa fa-send-o"></i></button>  ==> <b>(30)</b><br>


30 - <button class="btn btn-primary btn-xs"> <i class="fa fa-thumbs-o-up"></i></button> -
              ЗАКАЗЧИК выбрал данного ИСПОЛНИТЕЛЯ и отправил предложение
              . Управление состоянием ЗАКАЗА на стороне ИСПОЛНИТЕЛЯ. <br><br>

<b>на стороне ИСПОЛНИТЕЛЯ : </b> <br>

30 - <button class="btn btn-default btn-xs"> <i class="fa fa-thumbs-o-up"></i></button> -
              Получено предложения на ВЫПОЛНЕНИЕ ЗАЗКАЗА
              ---------------------
             <button class="btn btn-primary btn-xs" title="переключить в следующее состояние">
              <i class="fa fa-plus"></i></button>  ==> <b>(35)</b><br>


35 - <button class="btn btn-primary btn-xs"> <i class="fa fa-thumbs-o-up"></i></button> -
              Согласился на ВЫПОЛНЕНИЕ.Но не отправил подтверждение
              <button class="btn btn-primary btn-xs"  title="переключить в предыдущее состояние">
             <i class="fa fa-minus"></i></button>  ==> <b>(30)</b> ИЛИ <br>
-----------------------отправить согласие на исполнение ЗАКАЗА  -----------------------
панель инмтрументов: <button class="btn btn-primary btn-xs" title="отправить ЗАКАЗЧИКУ">
<i class="fa fa-send-o"></i></button>  ==> <b>(40)</b><br>


40 - <button class="btn btn-success btn-xs"> <i class="fa fa-thumbs-o-up"></i></button> -
              Согласился на ВЫПОЛНЕНИЕ.Отправил подтверждение. Отправил ЗАКАЗЧИКУ свои
               реквизиты для связи (тел, email).<br>

<b>на стороне ЗАКАЗЧИКА : </b> <br>
40 - <button class="btn btn-success btn-xs"> <i class="fa fa-thumbs-o-up"></i></button> -
              Получено подтверждение от ИСПОЛНИТЕЛЯ на выполнение работ по ЗАКАЗУ
              Получены реквизиты для связи с ИСПОЛНИТЕЛЕМ<br>

TEXT;
$text_en = <<<TEXT
TEXT;
$rules = [
    'title' => [
            'ru' => 'Прохождение заказа',
            'en' => 'The order passing'
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