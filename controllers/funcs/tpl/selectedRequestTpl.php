<?php
/**
 * шаблон письма " //  запрос ИСПОЛНИТЕЛЮ о согласии выполнить заказа"
 */
$addText = 'Портал <b>Pere-stroika</b> сообщает Вам,(<b>' . $company . '</b>)<br>' .
    'что компания выбрана ИСПОНИТЕЛЕМ работ по заказу <b> № ' . $aliasId .
    '(' . $orderName .')</b><br>' ;
$totId = $id . '-' . $aliasId ;
$siteUrl = Url::to(['site/order-selected-email','id'=>$totId],true) ;
$text = 'Для подтверждения вашей готовности выполнить работы и ' .
    'получить реквизиты заказчика перейдите по ссылке ' ;
$a = Html::a($text, $siteUrl) ;
Yii::$app->mailer->compose()
//            ->setFrom('mnudelman@yandex.ru')
    ->setTo($email)
    ->setSubject('Pere-stroika. Вы выбраны исполнителем работ')
//            ->setTextBody($addText .' '.'Для подтверждения корректности email перейдите по ссылке ' . $siteUrl)
    ->setHtmlBody($addText .' '.$a)
    ->send();
