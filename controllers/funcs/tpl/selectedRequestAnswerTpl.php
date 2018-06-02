<?php
/**
 * шаблон письма " //  запрос ИСПОЛНИТЕЛЮ о согласии выполнить заказа"
* @var $orderId
* @var $orderName
* @var $deadline
* @var $developer_companyName
* @var $customer_companyName
*/
$title = 'согласие на исполнение работ по заказу' ;
$bodyText = 'Вы (<b>' .$developer_companyName .'</b>)' .
    'выбраны в качестве исполнителя работ по заказу <br>' .
    '<b> № ' . $orderId .'(' . $orderName .')</b><br>' .
    '<b>заказчик:</b> ' . $customer_companyName . '<br>' .
    'для подтверждения согласия нажмите <b>"oK"</b><br>' .
    'для подробной информации по договору нажмите <b>"Кабинет"</b>' ;
$buttons = ['oK','office'] ;
return compact(['bodyText','title','buttons']) ;