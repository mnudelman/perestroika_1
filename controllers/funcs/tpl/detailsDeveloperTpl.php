<?php
/**
 * шаблон письма " // реквизиты исполнителя"
 * Time: 19:39
* @var $orderId
* @var $orderName
 * @var $customer_companyName
* @var $developer_companyName
* @var $developer_email
* @var $developer_tel
*/
$subject = 'реквизиты исполнителя' ;
$text = 'Вы ' . '('.$customer_companyName.')' .
    ' выбрали исполнителем работ по договору<br> ' .
    '<b>№ ' .$orderId . '('. $orderName . ')</b><br>' .
    'компанию: <b>' . $developer_companyName . '</b><br>' .
    'получено согласие исполнителя на выполнение работ.<br>' .
    'реквизиты для связи.<br>' .
    '<b>email:</b>' .$developer_email . '<b> tel:</b>' . $developer_tel . '<br>' ;
$referText = 'Подробности договора в кабинете' ;
return [
    'subject' => $subject,
    'bodyText' => $text,
    'referText' => $referText,
] ;
