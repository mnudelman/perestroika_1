<?php
/**
 * ответ, полученный по email
 *
 */
use app\controllers\funcs\MailingFunc ;
//const TYPE_DETAILS_CUSTOMER = 1; // реквизиты заказчика
//const TYPE_DETAILS_DEVELOPER = 2;// реквизиты исполнителя
//const TYPE_READY_REQUEST = 3;    // запрос ИСПОЛНИТЕЛЮ на участие в конкурсе на исполнение заказа
//const TYPE_SELECTED_REQUEST = 4; // запрос ИСПОЛНИТЕЛЮ о согласии выполнить заказа
//const TYPE_REGISTRATION = 5;     // подтверждение регистрации
//const TYPE_EXPRESS = 6;          // экспресс регистрация

$mailVect = (new MailingFunc())->unencriptMailId($mailId) ;
echo 'site/email-response: <br>' ;
var_dump($mailVect) ;
$success = (false !== $mailVect ) ;      // ошибка расшифровки параметра