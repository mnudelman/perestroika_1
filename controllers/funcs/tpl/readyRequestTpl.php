<?php
/**
 * шаблон письма " //  запрос ИСПОЛНИТЕЛЮ на участие в конкурсе на исполнение заказа"
 * @var $orderId
 * @var $orderName
 * @var $deadline
 * @var $developer_companyName
 * @var $customer_companyName
 */
$subject = 'конкурс на выполнение работ по заказу' ;
$bodyText = 'Вы ('.$developer_companyName .')' .
    ' можете принять участие в конкурсе на выполнение работ по заказу <br><b> № ' . $orderId .
    '(' . $orderName .')</b><br>' .
    '<b>заказчик:</b> ' . $customer_companyName . '<br>' .
    '<b>Время ответа до:</b>' . $deadline . '<br>';
$referText = 'Для подтверждения пройдите по ссылке' ;
return [
    'subject' => $subject,
    'bodyText' => $bodyText,
    'referText' => $referText,
] ;
