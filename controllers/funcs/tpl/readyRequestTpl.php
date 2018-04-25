<?php
/**
 * шаблон письма " //  запрос ИСПОЛНИТЕЛЮ на участие в конкурсе на исполнение заказа"
 * @var $orderId
 * @var $orderName
 * @var $deadline
 */
$subject = 'конкурс на выполнение работ по заказу' ;
$bodyText = 'Вы можете принять участие в конкурсе на выполнение работ по заказу <b> № ' . $orderId .
    '(' . $orderName .')</b><br>' .
    '<b>Время ответа до:</b>' . $deadline ;
$refText = 'Для подтверждения пройдите по ссылке' ;
return [
    'subject' => $subject,
    'bodyText' => $text,
    'referText' => $referText,
] ;
