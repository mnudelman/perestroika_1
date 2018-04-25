<?php
/**
 * шаблон письма " // реквизиты исполнителя"
 * Time: 19:39
* @var $orderId
* @var $orderName
* @var $companyName
* @var $email
* @var $tel
*/
$subject = 'реквизиты исполнителя' ;
$text = 'Вы выбрали исполнителем работ по договору<br> ' .
    '<b>№ ' .$orderId . '('. $orderName . ')</b><br>' .
    'компанию: <b>' . $companyName . '</b><br>' .
    'реквизиты для связи.  email:' .$email . ' tel:' . $tel . '<br>' ;
$referText = 'Подробности договора в кабинете' ;
return [
    'subject' => $subject,
    'bodyText' => $text,
    'referText' => $referText,
] ;
