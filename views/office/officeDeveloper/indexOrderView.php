<?php
/**
 * @var $htmlPrefix
 */
use yii\bootstrap\Tabs;
$htmlPrefix .= 'OrderView' ;
echo Tabs::widget([
    'items' => [
        [
            'label' => 'основные', //$tabItemName['general'],
            'content' => $this->render('orderViewGeneral',
                ['tabTitle' => 'Общие сведения','htmlPrefix' => $htmlPrefix,]),
            'options' => ['name' => $htmlPrefix . '-' . 'general' . '-content'],
            'headerOptions' => ['name' => $htmlPrefix . '-general' . '-header'],
        ],

        [
            'label' => 'работы', //$tabItemName['works'],
            'content' => $this->render('orderViewWorks',
                ['tabTitle' => 'Общие сведения','htmlPrefix' => $htmlPrefix,]),

            'options' => ['name' => $htmlPrefix . '-' . 'works' . '-content'],
            'headerOptions' => ['name' => $htmlPrefix . '-works' . '-header'],
        ],
        [
            'label' => 'дополнит', // $tabItemName['additional'],
            'content' => $this->render('orderViewAdditional',
                ['tabTitle' => 'Дополнительные материалы','htmlPrefix' => $htmlPrefix,]),
            'options' => ['name' => $htmlPrefix . '-' . 'additional' . '-content'],
            'headerOptions' => ['name' => $htmlPrefix . '-additional' . '-header'],
        ],
        [
            'label' => 'заказчик', // $tabItemName['additional'],
            'content' => $this->render('orderViewCustomer',
                ['tabTitle' => 'Заказчик','htmlPrefix' => $htmlPrefix,]),
            'options' => ['name' => $htmlPrefix . '-' . 'customer' . '-content'],
            'headerOptions' => ['name' => $htmlPrefix . '-customer' . '-header'],
        ],
        [
            'label' => 'оценка', // $tabItemName['additional'],
            'content' => $this->render('orderViewPoint',
                ['tabTitle' => 'Оценка взаимодействия','htmlPrefix' => $htmlPrefix,]),
            'options' => ['name' => $htmlPrefix . '-' . 'point' . '-content'],
            'headerOptions' => ['name' => $htmlPrefix . '-point' . '-header'],
        ],

    ]
]);
