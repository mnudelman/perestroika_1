<?php
/**
 * Исполнители
 *
 */

/**
 * @var $htmlPrefix
 */
use yii\bootstrap\Tabs;
use yii\helpers\Html ;
use yii\helpers\Url ;
use app\service\PageItems ;
?>
<?php
$tabItemName = PageItems::getItemText(['profile/tabs']);
$htmlPrefix = (isset($htmlPrefix)) ? $htmlPrefix . 'ProfileEdit' : 'profileEdit' ;
$url = '/office/officeDeveloper/orderCustomerProfile'
?>
<div style="border: 3px solid">
    <?php
    echo Tabs::widget([
        'items' => [
            [
                'label' => $tabItemName['general'],     // 'Общее',
//            'content' => $this->render('profile'),
                'content' => $this->render($url.'/profileGeneral',['tabTitle' => 'Это профиль',
                    'htmlPrefix' => $htmlPrefix]),
                'headerOptions' => ['name'=>$htmlPrefix . '-' . 'general' . '-header'],
                'active' => true
            ],
            [
                'label' => 'Статистика заказов', //'География',
//                'content' => $this->render('geographyWorks',['tabTitle' => 'География работ',
//                    'htmlPrefix' => $htmlPrefix]),
                'headerOptions' => ['name'=>$htmlPrefix . '-' . 'geography' . '-header'],
            ],

        ]
    ]);
    ?>
</div>
