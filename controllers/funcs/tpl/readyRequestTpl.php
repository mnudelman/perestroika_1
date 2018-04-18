<?php
/**
 * шаблон письма " //  запрос ИСПОЛНИТЕЛЮ на участие в конкурсе на исполнение заказа"
 */
$addText = 'Портал <b>Pere-stroika</b> предлагает Вам(<b>' . $company . '</b><br>' .
    'принять участие в конкурсе на выполнение работ по заказу <b> № ' . $orderId .
    '(' . $orderName .')</b><br>' ;
$totId = $id . '-' . $orderId ;
$siteUrl = Url::to(['site/order-email','id'=>$id . '-' . $orderId],true) ;
$text = 'Для подтверждения участия в конкурсе перейдите по ссылке ' ;
$a = Html::a($text, $siteUrl) ;
Yii::$app->mailer->compose()
//            ->setFrom('mnudelman@yandex.ru')
    ->setTo($email)
    ->setSubject('Pere-stroika. Конкурс на выолнение работы')
//            ->setTextBody($addText .' '.'Для подтверждения корректности email перейдите по ссылке ' . $siteUrl)
    ->setHtmlBody($addText .' '.$a)
    ->send();
