<?php
/**
 * ответ, полученный по email
 * @var $mailId
 *
 */

use app\controllers\funcs\EmailAnswerFunc;
use app\components\EmailAnswerWidget;

//const TYPE_DETAILS_CUSTOMER = 1; // реквизиты заказчика
//const TYPE_DETAILS_DEVELOPER = 2;// реквизиты исполнителя
//const TYPE_READY_REQUEST = 3;    // запрос ИСПОЛНИТЕЛЮ на участие в конкурсе на исполнение заказа
//const TYPE_SELECTED_REQUEST = 4; // запрос ИСПОЛНИТЕЛЮ о согласии выполнить заказа
//const TYPE_REGISTRATION = 5;     // подтверждение регистрации
//const TYPE_EXPRESS = 6;          // экспресс регистрация
//$mailVect = [
//'type' => $this->currentType,
//           'orderId' => $orderId,
//           'developerId' => $developerId,
//           'customerId' => $customerId,
//           'userId' => $userId,
//           'recipient' => ['userRole' => $recipientRole,
//    'userId' => $recipientId],
//           'message' => $textArr,
//        ] ;
$mailVect = (new EmailAnswerFunc())->responseDo($mailId);
$message = $mailVect['message'];
$success = (false !== $mailVect);      // ошибка расшифровки параметра
echo EmailAnswerWidget::widget([
    'title' => $message['title'],
    'bodyText' => $message['bodyText'],
    'buttons' => $message['buttons'],
    'clickParms' => $mailVect['clickParms'],
]);
