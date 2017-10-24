<?php
/**
 * Редактировать профиль
 * Time: 21:17
 */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\models\LoginForm;
use app\models\UserProfile;
use app\models\UploadForm;
use yii\widgets\Pjax;
use app\service\PageItems;
use yii\bootstrap\Dropdown;
use yii\bootstrap\ButtonDropdown;
use app\components\GeographySimpleWidget ;
//use app\models\Country ;
//use app\models\Region ;
//use app\models\City ;
use app\components\UserGeography ;
use \app\service\Files ;

//use Yii ;
?>
<?php
$ug = new UserGeography() ;
$ownGeography = $ug->getOwnGeography() ;
//    $userCountry = ['id' => $country->id,'name' => $country->name ] ;
//    $userRegion = ['id' => $region->id,'name' => $region->name ] ;
//    $userCity = ['id' => $city->id,'name' => $city->name ] ;

$userCountry = $ownGeography['userCountry'] ;
$userRegion = $ownGeography['userRegion'] ;
$userCity =  $ownGeography['userCity'] ;
$profile = null ;
$userIsGuest = Yii::$app->user->isGuest;
$userid = 'Z' ;
if ($userIsGuest) {
    $profile = new UserProfile();
} else {
    $userid = Yii::$app->user->identity->id;
    $profile = UserProfile::findOne(['userid' => $userid]);
}

$mdUpload = new UploadForm();
$title = 'ProfileEdit';
$urlUpload = Url::to(['site/upload']);
$uploadFormId = "profile-upload-form";
$avatarImgId = 'profile-avatar-img';
$avatarImgName = $profile->avatar;
$avatarUrl = '' ;

if ($userIsGuest || empty($avatarImgName)) {
    $avatarImgName = 'people.png' ;
    $path = Files::getPath('image',$userid) ;
    $avatarUrl = $path['url'] ;
}else {
    $path = Files::getPath('userAvatar', $userid);
    $avatarUrl = $path['url'];
}


$titleTab = PageItems::getItemText(['user', 'forms', 'profileForm', 'title']);
$title = $titleTab['text'];
$ruleTitleTab = PageItems::getItemText(['user', 'forms', 'profileForm', 'rules', 'title']);
$ruleTitle = $ruleTitleTab['text'];
$ruleContentTab = PageItems::getItemText(['user', 'forms', 'profileForm', 'rules', 'content']);
$ruleContent = $ruleContentTab['text'];
$ruleContentId = 'profile-form-collapseOne' ;
$buttonsTab = PageItems::getItemText(['user', 'buttons']);
$saveBt = $buttonsTab['saveProfile'];
$restoreBt = $buttonsTab['restoreProfile'];
$dirLayoutParts = '../layouts/layoutParts' ;
?>
<!--//$this->render($dirLayoutParts . '/ruleAccordion',-->
<!--//    ['ruleTitle'=>$ruleTitle,'ruleContent'=>$ruleContent,'ruleContentId'=>$ruleContentId])-->

<div id="enter-modal-insert">
    <div class="site-login">

        <!---->
        <?php
        $img = Html::img($avatarUrl . '/' . $avatarImgName,
            ['class' => 'img-responsive img-thumbnail', 'alt' => 'this is picture',
                'width' => '72px', 'id' => $avatarImgId]);
        echo Html::tag('div', $img);
        ?>
       <?php
        $form = ActiveForm::begin([
            'id' => 'profile-form',
            'action' => '#',
            'options' => ['class' => 'form-horizontal'],
            'fieldConfig' => [
                'template' => "{label}\n<div class=\"col-lg-10\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
                'labelOptions' => ['class' => 'col-lg-2 control-label'],
            ],
        ]);
        ?>
        <!---->
        <?= $form->field($profile, 'company')->textarea(['disabled'=>"disabled"]) ?>
        <?= $form->field($profile, 'info')->textarea(['disabled'=>"disabled"]) ?>
        <?= $form->field($profile, 'city_id')->
        widget(GeographySimpleWidget::className(),[
            'currentCountry' => $userCountry,
            'currentRegion' => $userRegion,
            'currentCity' => $userCity,
            'disabled' => true
        ])?>
        <br><br><br>
        <!---->
       <!---->
        <div class="col-lg-offset-1" name="form-messages" style="color:#ff0000;">
        </div>
        <div class="form-messages-success" name="form-messages-success">

        </div>
        <div class="form-messages-error" name="form-messages-error">

        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
