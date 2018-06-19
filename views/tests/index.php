<?php
/**
 * Кабинет -  меню
 *
 */
use yii\bootstrap\Tabs;
use app\service\PageItems ;
$htmlPrefix = 'tests' ;
echo Tabs::widget([
    'options' => ['id' => $htmlPrefix . 'TabHeader','class' => 'tab-header-1'],
    'items' => [
        [
            'label' => 'sempleEncript',             //'Я - Заказчик',
            'content' => $this->render('simpleEncriptTest'),
        ],
        [
            'label' => 'orderMailing',             //'Я - Заказчик',
            'content' => $this->render('orderMailingTest'),
        ],
        [
            'label' => 'mailingFunc',             //'рассылка сообщений через почту',
            'content' => $this->render('mailingFuncTest'),
        ],
        [
            'label' => 'slider',
            'content' => $this->render('slider'),
        ],

    ]
]);