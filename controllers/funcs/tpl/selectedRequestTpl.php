<?php
/**
 * шаблон письма " //  запрос ИСПОЛНИТЕЛЮ о согласии выполнить заказа"
* @var $orderId
* @var $orderName
* @var $deadline
*/
$subject = 'согласие на исполнение работ по заказу' ;
$bodyText = 'Вы выбраны в качестве исполнителя работ по заказу <b> № ' . $orderId .
    '(' . $orderName .')</b><br>' .
    '<b>Время ответа до:</b>' . $deadline ;
$refText = 'Для подтверждения согласия на выполнение работ пройдите по ссылке' ;
return [
    'subject' => $subject,
    'bodyText' => $text,
    'referText' => $referText,
] ;
