<?php
/**
 */
?>
<?php
/**Главная стрпница профиля
 * @var $htmlPrefix
 * @var $disabled  - true - запрет редактирования( только просмотр)
 * @var $IDFieldsFlag - показывать или нет поля - идентификаторы (email, tel, site)
 * @var $avatarShow - показывать аватар
 * @var $content = [ 'tooltips' => true, 'rule' => true, 'toolbar' => true,
 *                   'avatar' => true, 'formEdit' => true]
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
$htmlPrefix = (isset($htmlPrefix)) ? $htmlPrefix  : 'profileEdit' ;
$ug = new UserGeography() ;
$ownGeography = $ug->getOwnGeography() ;
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
$urlUpload = Url::to(['site/upload','filesMax' => 1]);
//$uploadFormId = "profile-upload-form";
//$avatarImgId = 'profile-avatar-img';

$uploadFormId = $htmlPrefix . "-upload-form";
$avatarImgId = $htmlPrefix . '-avatar-img';
$profileFormId = $htmlPrefix . "-profile-form" ;

$avatarImgName = $profile->avatar;
$avatar = $profile->getAvatar() ;
$avatarUrl = $avatar['url'] ;

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
$fields = [
        'email' => ['id' => $htmlPrefix . '-profile-email'],
        'tel' => ['id' => $htmlPrefix . '-profile-tel'],
        'site' => ['id' => $htmlPrefix . '-profile-site'],
        'company' => ['id' => $htmlPrefix . '-profile-company'],
        'info' => ['id' => $htmlPrefix . '-profile-info'],
] ;
if ($disabled) {
    foreach ($fields as $fldname => $attrs) {
        $attrs['disabled'] = 'disabled' ;
        $fields[$fldname] = $attrs ;
    }
}
?>
<!--===================================================================================-->
<!--===================================================================================-->

<div class="container-fluid">
    <div id="<?= $htmlPrefix . '-tooltips' ?>">

    </div>
    <!--     подсказка  -->
    <?php
    if ($content['rule']) {
        echo RuleTextWidget::widget([
            'htmlPrefix' => $htmlPrefix,
            'ruleTitle' => '',
            'ruleItems' => [
                ['ruleTitle'=>$ruleTitle,
                    'ruleContent' => $ruleContent]
            ],
        ]) ;
    }
    ?>
    <div class="row">
            <div class="panel panel-primary">
                <div class="panel-heading"  style="margin-bottom: -10px">
                    <?php
                    if ($content['rule']) {
                        echo ToolbarWidget::widget([
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
                    }
                    ?>
                </div>
                <div class="panel-body">


                    <?php
                    if ($content['avatar']) {
                        $img = Html::img($avatarUrl . '/' . $avatarImgName,
                            ['class' => 'img-responsive img-thumbnail', 'alt' => 'this is picture',
                                'width' => '72px', 'id' => $avatarImgId]);
                        echo Html::tag('div', $img);
                    }
                    ?>

                    <?php
                    if($content['avatar'] && !$disabled) {
                        $form = ActiveForm::begin([
                            'id' => $uploadFormId,
                            'action' => '#',
                            'options' => ['enctype' => 'multipart/form-data']]);
                        ?>
                        <?= $form->field($mdUpload, 'imageFiles[]')->
                        fileInput(['id' => $htmlPrefix . '-profile-imageFile',
                            'multiple' => true, 'accept' => 'image/*']) ?>
                        <!--                        <div class="form-group">-->
                        <div class="col-lg-11">
                            <?= Html::button('upload',
                                ['type' => 'button', 'class' => 'btn btn-primary', 'name' => 'upload-button',
                                    'onclick' => 'uploadOnClick('
                                        . '"' . $htmlPrefix . '","avatar"' . ')']) ?>

                        </div>
                        <!--                        </div>-->
                        <?php ActiveForm::end() ?><br><br>
                        <?php
                    }
                    ?>
                    <?php
                    if ($content['formEdit']) {
                        $form = ActiveForm::begin([
                            'id' => $profileFormId, //'profile-form',
                            'action' => '#',
                            'options' => ['class' => 'form-horizontal'],
                            'fieldConfig' => [
                                'template' => "{label}\n<div class=\"col-lg-10\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
                                'labelOptions' => ['class' => 'col-lg-2 control-label'],
                            ],
                        ]);
                        ?>
                        <!---->
                        <?php
                        if ($IDFieldsFlag) {
                            ?>
                            <?= $form->field($profile, 'email')->
                            textInput($fields['email']) ?>
                            <?= $form->field($profile, 'tel')->
                            textInput($fields['tel']) ?>
                            <?= $form->field($profile, 'site')->
                            textInput($fields['site']) ?>
                            <?php
                        }
                        ?>
                        <?= $form->field($profile, 'company')->
                        textarea($fields['company']) ?>
                        <?= $form->field($profile, 'info')->
                        textarea($fields['info']) ?>
                        <?= $form->field($profile, 'city_id')->
                        widget(GeographySimpleWidget::className(), [
                            'htmlIdPrefix' => $htmlPrefix,
                            'currentCountry' => $userCountry,
                            'currentRegion' => $userRegion,
                            'currentCity' => $userCity,
                            'disabled' => $disabled
                        ]) ?>
                        <br><br><br>
                        <div class="col-lg-offset-1" name="form-messages" style="color:#ff0000;">
                        </div>
                        <div class="form-messages-success" name="form-messages-success">

                        </div>
                        <div class="form-messages-error" name="form-messages-error">

                        </div>

                        <?php ActiveForm::end(); ?>
                        <?php
                    }
                    ?>







                </div>
            </div>
<!--        </div>-->


    </div>
    <!--                </div>-->
</div>
