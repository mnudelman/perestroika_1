<?php
/**
 * шаблон ответа на письмо " // реквизиты заказчика"
 * Time: 19:39
 * @var $orderId
 * @var $orderName
 * @var $developer_companyName
 * @var $customer_companyName
 */
$title = 'реквизиты заказчика' ;
$bodyText = 'Ваша компания <b>(' .$developer_companyName . ')</b>' .
    ' выбрана исполнителем работ по договору<br> ' .
    '<b>№ ' .$orderId . '('. $orderName . ')</b><br>' .
    'по полученным реквизитам( почта, телефон) Вы можете связаться <br>'.
    'с ЗКАЗЧИКОМ <b>' .$customer_companyName . ')</b><br>' .
    'для подробной информации по договору нажмите "Кабинет"' ;
$buttons = ['office'];
return compact(['bodyText','title','buttons']) ;


