<?php
/**
 * Я-заказчик - меню
 * @var $htmlPrefix
 */
?>
<?php
use yii\bootstrap\Tabs;
use app\models\UserProfile ;
use app\service\PageItems ;
use \app\components\TooltipsWidget ;
use app\controllers\OrderFunc ;

$htmlPrefix = (isset($htmlPrefix))? $htmlPrefix . 'OrderEdit' : 'orderEdit' ;
$userIsGuest = Yii::$app->user->isGuest ;
$email = '' ;
$confirmationFlag = false ;
if (!$userIsGuest) {
    $userId = Yii::$app->user->identity->getId() ;
    $profile = (new UserProfile())->getByUserId($userId) ;
    $email = $profile->email ;
//    $email = '' ;
    $confirmationFlag = $profile->confirmation_flag ;
}
$hideExpressFlag =  (!empty($email) && $confirmationFlag ) ;
$expressStyle = ($hideExpressFlag) ? 'display:none' : '' ;
$tabItemName = PageItems::getItemText(['order/tabs']);
$messages = PageItems::getItemText(['order/orderMessages']);
//$messagesTab = PageItems::getItemAttr('',['order/orderMessages']);
$orderGeneral = (new OrderFunc())->getOrderGeneral() ;
$orderLabel = (isset($orderGeneral['orderLabel'])) ? $orderGeneral['orderLabel']: '' ;
$orderLabel = (empty($orderLabel)) ? $messages['orderNotDefined'] : $orderLabel ;
?>
    <div class="double-panel">
        <?php
        echo TooltipsWidget::widget([
                'htmlPrefix' => $htmlPrefix,
            'tooltips' => [
                'orderNotDefined' => [
                        'yes' => $messages['orderNotDefined'] ],
                'orderNotDefinedText' => [
                        'yes' =>$messages['orderNotDefinedText']],
            ]
        ]) ;
        ?>

        <div  id="<?= $htmlPrefix ?>-order-label"
             style="color:#00a300;background-color:#d3d3d3;">
            <p><?=$orderLabel?></p>
        </div>

        <?php

echo Tabs::widget([
    'items' => [
        [
            'label' => $tabItemName['express'],
            'content' => $this->render('expressLogin',
                ['tabTitle' => 'экспресс регистрация','htmlPrefix' => $htmlPrefix]),
            'headerOptions' => ['style'=> $expressStyle,
                'name'=>$htmlPrefix . '-' . 'express' . '-header'],
            'options' => ['style'=> $expressStyle,
                'name'=>$htmlPrefix . '-' . 'express' . '-content'],
            'active' => !$hideExpressFlag,
        ],
        [
            'label' => $tabItemName['general'],
            'content' => $this->render('orderGeneral',
                ['tabTitle' => 'Общие сведения','htmlPrefix' => $htmlPrefix]),
            'options' => ['name'=>$htmlPrefix . '-' . 'general' . '-content'],
            'headerOptions' => ['name'=>$htmlPrefix . '-' . 'general' . '-header'],
            'active' => $hideExpressFlag
        ],
        [
            'label' => $tabItemName['works'],
            'content' => $this->render('orderWorks',
                ['tabTitle' => 'Общие сведения','htmlPrefix' => $htmlPrefix]),

            'options' => ['name'=>$htmlPrefix . '-' . 'works' . '-content'],
            'headerOptions' => ['name'=>$htmlPrefix . '-' . 'works' . '-header'],
        ],
        [
            'label' => $tabItemName['additional'],
            'options' => ['name'=>$htmlPrefix . '-' . 'additional' . '-content'],
            'headerOptions' => ['name'=>$htmlPrefix . '-' . 'additional' . '-header'],
            'content' => $this->render('orderAdditional',
                ['tabTitle' => 'Дополнительные материалы','htmlPrefix' => $htmlPrefix]),
        ],
        [
            'label' => $tabItemName['mailing'],
            'options' => ['name'=>$htmlPrefix . '-' . 'mailing' . '-content'],
            'headerOptions' => ['name'=>$htmlPrefix . '-' . 'mailing' . '-header'],
            'content' => $this->render('orderMailing',
                ['tabTitle' => 'Рассылка','htmlPrefix' => $htmlPrefix]),

        ],
    ]
]);
?>
</div>