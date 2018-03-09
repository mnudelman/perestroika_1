<?php
/**
 * @var $htmlPrefix
 * @var $expressStyle
 * @var $hideExpressFlag
 */
use yii\bootstrap\Tabs;
use app\service\PageItems ;
$htmlPrefix .= 'Profile' ;
$tabItemName = PageItems::getItemText(['profile/tabs']);
echo Tabs::widget([
    'items' => [
        [
            'label' => $tabItemName['general'], //'основные', //$tabItemName['general'],
            'content' => $this->render('mailingProfile',
                ['tabTitle' => 'Общие сведения','htmlPrefix' => $htmlPrefix,]),
            'options' => ['name' => $htmlPrefix . '-' . 'general' . '-content'],
            'headerOptions' => ['name' => $htmlPrefix . '-profile-general' . '-header'],
            'active' => $hideExpressFlag
        ],

        [
            'label' => $tabItemName['geography'], //'география работ', //$tabItemName['general'],
            'content' => $this->render('mailingGeography',
                ['tabTitle' => 'география работ','htmlPrefix' => $htmlPrefix,]),
            'options' => ['name' => $htmlPrefix . '-' . 'geography' . '-content'],
            'headerOptions' => ['name' => $htmlPrefix . '-profile-geography' . '-header'],
//            'active' => $hideExpressFlag
        ],



                [
                    'label' => $tabItemName['works'], //'работы', //$tabItemName['works'],
                    'content' => $this->render('mailingWorks',
                        ['tabTitle' => 'Общие сведения','htmlPrefix' => $htmlPrefix,]),

                    'options' => ['name' => $htmlPrefix . '-' . 'works' . '-content'],
                    'headerOptions' => ['name' => $htmlPrefix . '-profile-works' . '-header'],
                ],
        [
            'label' => $tabItemName['gallery'], //'дополнительно', // $tabItemName['additional'],
            'content' => $this->render('mailingAdditional',
                ['tabTitle' => 'Дополнительные материалы','htmlPrefix' => $htmlPrefix,]),
            'options' => ['name' => $htmlPrefix . '-' . 'additional' . '-content'],
            'headerOptions' => ['name' => $htmlPrefix . '-profile-additional' . '-header'],
        ],

    ]
]);
