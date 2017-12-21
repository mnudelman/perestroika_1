<?php
/**
 * Я-заказчик - меню
 *
 */
?>
<?php
use yii\bootstrap\Tabs;
use app\models\UserProfile ;
use app\service\PageItems ;

$htmlPrefix = 'orderEdit' ;
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


?>
    <div class="double-panel">
        <div  id="<?= $htmlPrefix ?>-order-label"
             style="color:#00a300;background-color:#d3d3d3;">
            <p>заказ не определён</p>
        </div>

        <?php
echo Tabs::widget([
    'items' => [
        [
            'label' => $tabItemName['express'],
            'content' => $this->render('expressLogin',
                ['tabTitle' => 'экспресс регистрация']),
            'headerOptions' => ['style'=> $expressStyle,
                'name'=>$htmlPrefix . '-' . 'express' . '-header'],
            'options' => ['style'=> $expressStyle,
                'name'=>$htmlPrefix . '-' . 'express' . '-content'],
            'active' => !$hideExpressFlag,
        ],
        [
            'label' => $tabItemName['general'],
            'content' => $this->render('orderGeneral',['tabTitle' => 'Общие сведения']),
            'options' => ['name'=>$htmlPrefix . '-' . 'general' . '-content'],
            'headerOptions' => ['name'=>$htmlPrefix . '-' . 'general' . '-header'],
            'active' => $hideExpressFlag
        ],
        [
            'label' => $tabItemName['works'],
            'content' => $this->render('orderWorks',['tabTitle' => 'Общие сведения',]),

            'options' => ['name'=>$htmlPrefix . '-' . 'works' . '-content'],
            'headerOptions' => ['name'=>$htmlPrefix . '-' . 'works' . '-header'],
        ],
        [
            'label' => $tabItemName['additional'],
            'options' => ['name'=>$htmlPrefix . '-' . 'additional' . '-content'],
            'headerOptions' => ['name'=>$htmlPrefix . '-' . 'additional' . '-header'],
            'content' => $this->render('orderAdditional',['tabTitle' => 'Дополнительные материалы']),
        ],
        [
            'label' => $tabItemName['mailing'],
            'options' => ['name'=>$htmlPrefix . '-' . 'mailing' . '-content'],
            'headerOptions' => ['name'=>$htmlPrefix . '-' . 'mailing' . '-header'],
            'content' => $this->render('orderMailing',['tabTitle' => 'Рассылка']),

        ],
    ]
]);
?>
</div>