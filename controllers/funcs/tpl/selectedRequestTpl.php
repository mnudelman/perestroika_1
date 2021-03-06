<?php
/**
 * шаблон письма " //  запрос ИСПОЛНИТЕЛЮ о согласии выполнить заказа"
* @var $orderId
* @var $orderName
* @var $deadline
* @var $developer_companyName
* @var $customer_companyName
*/
$subject = 'согласие на исполнение работ по заказу' ;
$bodyText = 'Вы (<b>' .$developer_companyName .'</b>)' .
    'выбраны в качестве исполнителя работ по заказу <br>' .
    '<b> № ' . $orderId .'(' . $orderName .')</b><br>' .
    '<b>заказчик:</b> ' . $customer_companyName . '<br>' .
    '<b>Время ответа до:</b>' . $deadline . '<br>';
$referText = 'Для подтверждения пройдите по ссылке' ;
return [
    'subject' => $subject,
    'bodyText' => $bodyText,
    'referText' => $referText,
] ;
