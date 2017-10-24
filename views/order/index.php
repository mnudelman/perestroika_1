<?php
/**
 * Заказ
 *
 */
?>
<?php
use yii\bootstrap\Tabs;
use yii\helpers\Html ;
use yii\helpers\Url ;
use app\models\UserProfile ;
use app\service\PageItems ;

//            'headerOptions' => ['style'=>'display:none'],
//            'options' => ['style'=>'display:none'],
$htmlPrefix = 'orderEdit' ;
$userIsGuest = Yii::$app->user->isGuest ;
//$expressStyle = (!$userIsGuest) ? 'display:none' : '' ;
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


echo Tabs::widget([
    'items' => [
        [
            'label' => $tabItemName['express'],
            'content' => $this->render('tabItem',
                ['tabTitle' => 'экспресс регистрация','tabContent' => 'expressLogin']),
            'headerOptions' => ['style'=> $expressStyle,
                'name'=>$htmlPrefix . '-' . 'express' . '-header'],
            'options' => ['style'=> $expressStyle,
                'name'=>$htmlPrefix . '-' . 'express' . '-content'],
            'active' => !$hideExpressFlag,
        ],
        [
            'label' => $tabItemName['general'],
            'content' => $this->render('tabItem',
                ['tabTitle' => 'Общие сведения','tabContent' => 'orderGeneral']),
            'options' => ['name'=>$htmlPrefix . '-' . 'general' . '-content'],
            'headerOptions' => ['name'=>$htmlPrefix . '-' . 'general' . '-header'],
            'active' => $hideExpressFlag
        ],
        [
            'label' => $tabItemName['works'],
            'content' => $this->render('tabItem',
                ['tabTitle' => 'Общие сведения','tabContent' => 'orderWorks']),

            'options' => ['name'=>$htmlPrefix . '-' . 'works' . '-content'],
            'headerOptions' => ['name'=>$htmlPrefix . '-' . 'works' . '-header'],
        ],
        [
            'label' => $tabItemName['additional'],
            'options' => ['name'=>$htmlPrefix . '-' . 'additional' . '-content'],
            'headerOptions' => ['name'=>$htmlPrefix . '-' . 'additional' . '-header'],
            'content' => $this->render('tabItem',
                ['tabTitle' => 'Дополнительные материалы','tabContent' => 'orderAdditional']),
        ],
        [
            'label' => $tabItemName['mailing'],
            'options' => ['name'=>$htmlPrefix . '-' . 'mailing' . '-content'],
            'headerOptions' => ['name'=>$htmlPrefix . '-' . 'mailing' . '-header'],
            'content' => $this->render('tabItem',
                ['tabTitle' => 'Рассылка','tabContent' => 'orderMailing']),

        ],
    ]
]);