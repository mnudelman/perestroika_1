<?php
/**
 * форма - Настройка рассылки
 * @var $htmlPrefix
 */
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
use yii\bootstrap\ButtonDropdown ;
use app\models\MailingSetupForm ;
$setupForm = new MailingSetupForm() ;
$timeItems = $setupForm->getTimeItems() ;
$mailingNumberMaxItems = $setupForm->getMailingNumberMaxItems() ;
?>
<div id="<?= $htmlPrefix ?>-setup"
     title="prepare and save filter for order list"
     style="display:none;border:1px solid blue;border-radius:3px;">
    <?php
    $form = ActiveForm::begin([
        'id' => 'mailing-setup-form',
        'action' => '#',
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-md-8\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-md-4 control-label'],
        ],
    ]);
    ?>
    <!---->
    <?=$form->field($setupForm,  'currentTime',
        ['options' => ['readonly'=> true]])
         ?>
    <div class="checkbox" style="margin-left: 5px">
        <?=$form->field($setupForm,  'autoSendFlag')
            ->checkbox() ; ?>
    </div>
<!--    <div class="input-group">-->
    <div class="row">
        <div class="col-md-8">
            <?= $form->field($setupForm, 'deadline')
                ->widget(DatePicker::classname(), [
                    'language' => 'en',
                    'dateFormat' => 'php:d M Y',
                    'options' => [
                        'class' => 'picker-per-end'
                    ],
                    'clientOptions' => [
//                        'dateFormat' => 'dd-mm-yy',
                        'changeYear' => true,
                        'changeMonth' => true,
                        'yearRange' => '2010:2060'
                    ],
                ]) ?>

        </div>
        <div class="col-md-4">
            <?= $form->field($setupForm, 'deadlineTime',
                ['template' => "{label}\n<div class=\"col-md-11\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-md-0 control-label'],
                ]
            )
                ->dropdownList($timeItems);?>

        </div>

    </div>
<!--     </div>-->


    <?= $form->field($setupForm, 'mailingNumberMax',
        ['template' => "{label}\n<div class=\"col-md-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-md-4 control-label'],
        ] )
        ->dropdownList($mailingNumberMaxItems);?>




        <div class="checkbox" style="margin-left: 5px">
    <?=$form->field($setupForm, 'randSelectFlag')
        ->checkbox() ; ?>
        </div>

    <div class="form-messages-success" name="form-messages-success">

    </div>
    <div class="form-messages-error" name="form-messages-error">

    </div>

    <?php
    ActiveForm::end();
    ?>
    <div style="margin-bottom: 5px">
        &nbsp;
        <button class="btn btn-primary" title="filter"
                onclick="dataSetup('<?= $htmlPrefix ?>-save')">
            save setup
        </button>
    </div>
</div>