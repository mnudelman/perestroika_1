<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 26.12.16
 * Time: 21:17
 */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\models\LoginForm;
use app\models\UserRegistration;
use app\models\UserProfile;
use app\models\UploadForm;
use yii\widgets\Pjax;
use app\service\PageItems ;
?>
<?php
$mdReg = new UserRegistration();
$mdProf = new UserProfile();
$userIsGuest = Yii::$app->user->isGuest ;
if (!$userIsGuest){
   $userId = Yii::$app->user->identity->getId() ;
   $mdProf = $mdProf->getByUserId($userId) ;
}

$mdUpload = new UploadForm();
$urlUpload = Url::to(['site/upload']) ;
$uploadFormId = "upload-form" ;
$avatarImgId = 'avatar-img' ;

$title = PageItems::getItemText(['user','forms','expressForm','title']) ;
$ruleTab = PageItems::getItemText(['user','forms','expressForm','rules']) ;
$ruleTitle = $ruleTab['title'] ;
$ruleContent = $ruleTab['content'] ;
$buttonsTab = PageItems::getItemText(['user','buttons']) ;
$uploadBt = $buttonsTab['upload'] ;
$registrationBt = $buttonsTab['registration'] ;
$loginBt = $buttonsTab['login'] ;
$continueExpressBt = $buttonsTab['saveExpress'] ;
$orNormalLoginText = PageItems::getItemText(['user','forms','expressForm','rules','messages','orNormalLogin']) ;
?>

<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
    <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="headingOne">
            <h4 class="panel-title">
                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#registration-form-collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    <?=$ruleTitle ?><span class="caret"></span>
                </a>
            </h4>
        </div>
        <div id="registration-form-collapseOne" class="panel-collapse collapse in rule-content" role="tabpanel" aria-labelledby="headingOne">
            <div class="panel-body">
                <?=$ruleContent?>
            </div>
        </div>
    </div>

</div>


<!--<div id="----enter-modal-insert">-->
<div>
    <div class="site-login">
        <?php
        $form = ActiveForm::begin([
            'id' => 'express-registration-form',
            'action' => '#',
            'options' => ['class' => 'form-horizontal'],
            'fieldConfig' => [
                'template' => "{label}\n<div class=\"col-lg-10\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
                'labelOptions' => ['class' => 'col-lg-2 control-label'],
            ],
        ]);
        ?>
        <!---->
        <?= $form->field($mdProf, 'email')->textInput() ?>
        <?= $form->field($mdProf, 'tel')->textInput() ?>
        <?= $form->field($mdProf, 'company')->textarea() ?>
        <!---->
        <!--                        ]) ?>-->
        <!---->
        <div class="form-group">
            <div class="col-lg-offset-1 col-lg-11">
                <?= Html::button($continueExpressBt,
                    ['class' => 'btn btn-primary', 'name' => 'express-button',
                        'onclick' => "expressRegistration('continue')"]) ?>
                <?= Html::button($orNormalLoginText,
                    ['class' => 'btn btn-success', 'name' => 'login-button',
                        'onclick' => "expressRegistration('login')"]) ?>
<!--                или-->
<!--                ?= Html::button($registrationBt,-->
<!--                    ['class' => 'btn btn-success', 'name' => 'registration-button',-->
<!--                        'onclick' => "expressRegistration('registration')"]) ?>-->

            </div>
        </div>
        <!---->
        <div class="form-messages-success" name="form-messages-success" >

        </div>
        <div class="form-messages-error" name="form-messages-error" >

        </div>
        <?php ActiveForm::end(); ?>

    </div>
</div>
