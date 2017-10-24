<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 26.12.16
 * Time: 21:17
 */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm ;
use app\models\LoginForm ;
use app\service\PageItems ;
?>
<?php

$model = new LoginForm() ;



$titleTab = PageItems::getItemText(['user','forms','loginForm','title']) ;
$title = $titleTab['text'] ;
$ruleTitleTab = PageItems::getItemText(['user','forms','loginForm','rules','title']) ;
$ruleTitle = $ruleTitleTab['text'] ;
$ruleContentTab = PageItems::getItemText(['user','forms','loginForm','rules','content']) ;
$ruleContent = $ruleContentTab['text'] ;
$buttonsTab = PageItems::getItemText(['user','buttons']) ;
$loginBt = $buttonsTab['login'] ;





?>
<div class="modal fade" id="enter-form" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="enter-modal-title"><?= Html::encode($title) ?></h4>
            </div>
            <div class="modal-body" id="modal-body">



                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingOne">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#enter-form-collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    <?=$ruleTitle ?><span class="caret"></span>
                                </a>
                            </h4>
                        </div>
                        <div id="enter-form-collapseOne" class="panel-collapse collapse in rule-content" role="tabpanel" aria-labelledby="headingOne">
                            <div class="panel-body">
                                <?=$ruleContent?>
                            </div>
                        </div>
                    </div>

                </div>
                <div id="enter-modal-insert" >
                    <div class="site-login">
                        <?php
                        $form = ActiveForm::begin([
                            'id' => 'login-form',
                            'action' => '#',
                            'options' => ['class' => 'form-horizontal'],
                            'fieldConfig' => [
                                'template' => "{label}\n<div class=\"col-lg-10\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
                                'labelOptions' => ['class' => 'col-lg-2 control-label'],
                            ],
                        ]); ?>

                        <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

                        <?= $form->field($model, 'password')->passwordInput() ?>

                        <?= $form->field($model, 'rememberMe')->checkbox([
                            'template' => "<div class=\"col-lg-offset-1 col-lg-3\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
                        ]) ?>

                        <div class="form-group">
                            <div class="col-lg-offset-1 col-lg-11">
                                <?= Html::button($loginBt,
                                    ['class' => 'btn btn-primary', 'name' => 'login-button',
                                        'onclick' => 'loginOnClick()']) ?>
                            </div>
                        </div>
                        <div class="form-messages-success" name="form-messages-success" >

                        </div>
                        <div class="form-messages-error" name="form-messages-error" >

                        </div>

                        <?php ActiveForm::end(); ?>

                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <p>
<!--                    <a class="btn btn-default" href="#" role="button" data-dismiss="modal" id="modal-exit">exit</a>-->
                </p>
            </div>
        </div>
    </div>
</div>
