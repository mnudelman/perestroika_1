<?php
/**
 * шаблон письма " // реквизиты заказчика"
 * Time: 19:39
 * @var $orderId
 * @var $orderName
 * @var $companyName
 * @var $email
 *@var $tel
 */
$subject = 'реквизиты заказчика' ;
$text = 'Ваша компания <b>(' .$companyName . ')</b>'.' выбрана исполнителем работ по договору<br> ' .
    '<b>' .$orderId . '('. $orderName . ')</b><br>' .
    'реквизиты заказчика.  email:' .$email . ' tel:' . $tel . '<br>' ;
$referText = 'Подробности договора в кабинете' ;
return [
    'subject' => $subject,
    'bodyText' => $text,
    'referText' => $referText,
] ;

