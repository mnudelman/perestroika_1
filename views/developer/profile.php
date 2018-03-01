<?php
/**
 * Редактировать профиль
 * Time: 21:17
 */

/**
 * @var $htmlPrefix
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
use app\components\UserGeography ;
use \app\service\Files ;
use app\components\ToolbarWidget ;
use app\components\RuleTextWidget ;
//use Yii ;
?>
<?php
$ug = new UserGeography() ;
$ownGeography = $ug->getOwnGeography() ;
//    $userCountry = ['id' => $country->id,'name' => $country->name ] ;
//    $userRegion = ['id' => $region->id,'name' => $region->name ] ;
//    $userCity = ['id' => $city->id,'name' => $city->name ] ;

$htmlPrefix = (isset($htmlPrefix)) ? $htmlPrefix  : 'profileEdit' ;

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
//$uploadFormId = "profile-upload-form";
//$avatarImgId = 'profile-avatar-img';

$uploadFormId = $htmlPrefix . "-upload-form";
$avatarImgId = $htmlPrefix . '-avatar-img';
$profileFormId = $htmlPrefix . "-profile-form" ;

$avatarImgName = $profile->avatar;
$avatar = $profile->getAvatar() ;
$avatarUrl = $avatar['url'] ;

//if ($userIsGuest || empty($avatarImgName)) {
//        $avatarImgName = 'people.png' ;
//        $path = Files::getPath('image',$userid) ;
//        $avatarUrl = $path['url'] ;
//    }else {
//    $path = Files::getPath('userAvatar', $userid);
//    $avatarUrl = $path['url'];
//}


$title = PageItems::getItemText(['user', 'forms', 'profileForm', 'title']);
$ruleTab = PageItems::getItemText(['user', 'forms', 'profileForm', 'rules']);
$ruleTitle = $ruleTab['title'];
$ruleContent = $ruleTab['content'];
$ruleContentId = 'profile-form-collapseOne' ;
$buttonsTab = PageItems::getItemText(['user', 'buttons']);
$saveBt = $buttonsTab['saveProfile'];
$restoreBt = $buttonsTab['restoreProfile'];
//$dirLayoutParts = '../layouts/layoutParts' ;
$partsTitleEdit = 'профиль.Основное' ;

?>
<!--===================================================================================-->
<!--===================================================================================-->

<div class="container-fluid">
    <div id="<?= $htmlPrefix . '-tooltips' ?>">

    </div>
    <!--     подсказка  -->

    <?=RuleTextWidget::widget([
    'htmlPrefix' => $htmlPrefix,
    'ruleTitle' => '',
    'ruleItems' => [
    ['ruleTitle'=>$ruleTitle,
    'ruleContent' => $ruleContent]
    ],
    ]) ;
    ?>
    <div class="row">



<!--        <div class="col-md-6">-->
            <div class="panel panel-primary">
                <div class="panel-heading"  style="margin-bottom: -10px">


                    <?=ToolbarWidget::widget([
                    'htmlPrefix' => $htmlPrefix,
                    'topology' => [
                    'title' => 4,
                    'buttons' => 8,
                    'pagination' => 0
                    ],
                    'title' => $partsTitleEdit,
                    'buttons' => [
                    'help' => [],
                    'save' => [
                    'title' => 'save',
                    'clickFunction' => 'profileOnClick',
                    'clickAction' => 'save'
                    ],
                    ],
                    'pagination' => [],
                    ]) ;
                    ?>





                </div>
                <div class="panel-body">


                    <?php
                    $img = Html::img($avatarUrl . '/' . $avatarImgName,
                        ['class' => 'img-responsive img-thumbnail', 'alt' => 'this is picture',
                            'width' => '72px', 'id' => $avatarImgId]);
                    echo Html::tag('div', $img);
                    ?>

                    <?php $form = ActiveForm::begin([
                        'id' => $uploadFormId,
                        'action' => '#',
                        'options' => ['enctype' => 'multipart/form-data']]);
                    ?>
                    <?= $form->field($mdUpload, 'imageFile')->
                    fileInput(['id'=> $htmlPrefix . '-profile-imageFile']) ?>
                    <!--                        <div class="form-group">-->
                    <div class="col-lg-11">
                        <?= Html::button('upload',
                            ['type' => 'button', 'class' => 'btn btn-primary', 'name' => 'upload-button',
                                'onclick' => 'uploadOnClick('
                                    . '"' . $uploadFormId . '","' . $urlUpload . '","' . $avatarImgId . '")']) ?>
                    </div>
                    <!--                        </div>-->
                    <?php ActiveForm::end() ?><br><br>
                    <?php
                    $form = ActiveForm::begin([
                        'id' => $profileFormId , //'profile-form',
                        'action' => '#',
                        'options' => ['class' => 'form-horizontal'],
                        'fieldConfig' => [
                            'template' => "{label}\n<div class=\"col-lg-10\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
                            'labelOptions' => ['class' => 'col-lg-2 control-label'],
                        ],
                    ]);
                    ?>
                    <!---->
                    <?= $form->field($profile, 'email')->
                    textInput(['id'=> $htmlPrefix . '-profile-email']) ?>
                    <?= $form->field($profile, 'tel')->
                    textInput(['id'=> $htmlPrefix . '-profile-tel']) ?>
                    <?= $form->field($profile, 'site')->
                    textInput(['id'=> $htmlPrefix . '-profile-site']) ?>
                    <?= $form->field($profile, 'company')->
                    textarea(['id'=> $htmlPrefix . '-profile-company']) ?>
                    <?= $form->field($profile, 'info')->
                    textarea(['id'=> $htmlPrefix . '-profile-info']) ?>
                    <?= $form->field($profile, 'city_id')->
                    widget(GeographySimpleWidget::className(),[
                        'htmlIdPrefix' => $htmlPrefix,
                        'currentCountry' => $userCountry,
                        'currentRegion' => $userRegion,
                        'currentCity' => $userCity,
                    ])?>
                    <br><br><br>
                    <div class="col-lg-offset-1" name="form-messages" style="color:#ff0000;">
                    </div>
                    <div class="form-messages-success" name="form-messages-success">

                    </div>
                    <div class="form-messages-error" name="form-messages-error">

                    </div>

                    <?php ActiveForm::end(); ?>








                </div>
            </div>
<!--        </div>-->


    </div>
    <!--                </div>-->
</div>
