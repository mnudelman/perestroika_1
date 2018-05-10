<?php
/**
 * шаблон письма " // реквизиты заказчика"
 * Time: 19:39
 * @var $orderId
 * @var $orderName
 * @var $developer_companyName
 * @var $customer_companyName
 * @var $customer_email
 *@var $customer_tel
 */
$subject = 'реквизиты заказчика' ;
$text = 'Ваша компания <b>(' .$developer_companyName . ')</b>' .
    ' выбрана исполнителем работ по договору<br> ' .
    '<b>№ ' .$orderId . '('. $orderName . ')</b><br>' .
    'реквизиты заказчика.<br>' .
    '<b>компания:</b>' . $customer_companyName . '<br>' .
    '<b>email:</b>' .$customer_email . '<b> tel:</b>' . $customer_tel . '<br>' ;
$referText = 'Подробности договора в кабинете' ;
return [
    'subject' => $subject,
    'bodyText' => $text,
    'referText' => $referText,
] ;

