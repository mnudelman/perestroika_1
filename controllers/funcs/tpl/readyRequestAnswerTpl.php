<?php
/**
 * шаблон письма " //  запрос ИСПОЛНИТЕЛЮ на участие в конкурсе на исполнение заказа"
 * @var $orderId
 * @var $orderName
 * @var $deadline
 * @var $developer_companyName
 * @var $customer_companyName
 */
$title = 'конкурс на выполнение работ по заказу' ;
$bodyText = 'Вы ('.$developer_companyName .')' .
    ' можете принять участие в конкурсе на выполнение работ по заказу <br><b> № ' . $orderId .
    '(' . $orderName .')</b><br>' .
    '<b>заказчик:</b> ' . $customer_companyName . '<br>' .
    'для подтверждения согласия нажмите <b>"oK"</b><br>' .
    'для подробной информации по договору нажмите <b>"Кабинет"</b>' ;
$buttons = ['oK','office'] ;
return compact(['bodyText','title','buttons']) ;