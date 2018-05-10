<?php
/**
 * Time: 14:09
 */
use app\controllers\funcs\MailingFunc ;
$testList = [
    MailingFunc::TYPE_DETAILS_CUSTOMER ,   // реквизиты заказчика
    MailingFunc::TYPE_DETAILS_DEVELOPER ,  // реквизиты исполнителя
    MailingFunc::TYPE_READY_REQUEST ,      // запрос ИСПОЛНИТЕЛЮ на участие в конкурсе на исполнение заказа
    MailingFunc::TYPE_SELECTED_REQUEST,    // запрос ИСПОЛНИТЕЛЮ о согласии выполнить заказа
    MailingFunc::TYPE_REGISTRATION ,       // подтверждение регистрации
    MailingFunc::TYPE_EXPRESS,             // экспресс регистрация
] ;
$mF = (new MailingFunc())-> setDebug(true) ;
for ($i = 0; $i < sizeof($testList); $i++) {
    echo '<b>======тест MailingFunc: type =' . $testList[$i] .'====</b><br>' ;
    $mF -> setOrderAttr(1,1)
        ->setType($testList[$i])
        ->setRegistrationAttr(1,'qwerty')
        ->sendDo() ;
    echo '<b>=============================================</b><br>' ;
}