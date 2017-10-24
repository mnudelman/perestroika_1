<?php
/**
 * @var $htmlPrefix
 * @var $expressStyle
 * @var $hideExpressFlag
 */
use yii\bootstrap\Tabs;
$htmlPrefix .= 'OrderView' ;
echo Tabs::widget([
    'items' => [
        [
            'label' => 'основные', //$tabItemName['general'],
            'content' => $this->render('tabItem',
                ['tabTitle' => 'Общие сведения', 'tabContent' => 'orderViewGeneral',
                    'htmlPrefix' => $htmlPrefix,]),
            'options' => ['name' => $htmlPrefix . '-' . 'general' . '-content'],
            'headerOptions' => ['name' => $htmlPrefix . '-general' . '-header'],
//            'active' => $hideExpressFlag
        ],

                [
                    'label' => 'работы', //$tabItemName['works'],
                    'content' => $this->render('tabItem',
                        ['tabTitle' => 'Общие сведения', 'tabContent' => 'orderViewWorks',
                            'htmlPrefix' => $htmlPrefix,]),

                    'options' => ['name' => $htmlPrefix . '-' . 'works' . '-content'],
                    'headerOptions' => ['name' => $htmlPrefix . '-works' . '-header'],
                ],
        [
            'label' => 'дополнит', // $tabItemName['additional'],
            'content' => $this->render('tabItem',
                ['tabTitle' => 'Дополнительные материалы', 'tabContent' => 'orderViewAdditional',
                    'htmlPrefix' => $htmlPrefix,]),
            'options' => ['name' => $htmlPrefix . '-' . 'additional' . '-content'],
            'headerOptions' => ['name' => $htmlPrefix . '-additional' . '-header'],
        ],
        [
            'label' => 'заказчик', // $tabItemName['additional'],
            'content' => $this->render('tabItem',
                ['tabTitle' => 'Заказчик', 'tabContent' => 'orderViewCustomer',
                    'htmlPrefix' => $htmlPrefix,]),
            'options' => ['name' => $htmlPrefix . '-' . 'customer' . '-content'],
            'headerOptions' => ['name' => $htmlPrefix . '-customer' . '-header'],
        ],
        [
            'label' => 'оценка', // $tabItemName['additional'],
            'content' => $this->render('tabItem',
                ['tabTitle' => 'Оценка взаимодействия', 'tabContent' => 'orderViewPoint',
                    'htmlPrefix' => $htmlPrefix,]),
            'options' => ['name' => $htmlPrefix . '-' . 'point' . '-content'],
            'headerOptions' => ['name' => $htmlPrefix . '-point' . '-header'],
        ],

    ]
]);
