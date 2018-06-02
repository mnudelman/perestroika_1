<?php
/**
 * шаблон письма " // реквизиты исполнителя"
 * Time: 19:39
 * @var $orderId
 * @var $orderName
 * @var $developer_companyName
 * @var $customer_companyName
 */
$title = 'реквизиты исполнителя' ;
$bodyText = 'Вы <b>(' .$customer_companyName . ')</b>' .
    ' определили исполнителя работ по договору<br> ' .
    '<b>№ ' .$orderId . '('. $orderName . ')</b><br>' .
    'по полученным реквизитам( почта, телефон) Вы можете связаться <br>'.
    'с ИСПОЛНИТЕЛЕМ <b>' .$developer_companyName . ')</b><br>' .
    'для подробной информации по договору нажмите "Кабинет"' ;
$buttons = ['office'];
return compact(['bodyText','title','buttons']) ;
