<?php
/**
 * форма - фильтр списка заказов
 * @var $htmlPrefix
 * @var $filterForm
 */
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
?>
<div id="<?= $htmlPrefix ?>-filter"
     title="prepare and save filter for order list"
     style="display:none;border:1px solid blue;border-radius:3px;">
    <?php
    $form = ActiveForm::begin([
        'id' => 'work-order-filter-form',
        'action' => '#',
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-md-8\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-md-2 control-label'],
        ],
    ]);
    ?>
    <!---->
    <?= $form->field($filterForm, 'perBeg')
        ->widget(DatePicker::classname(), [
            'language' => 'en',
            'dateFormat' => 'php:d M Y', // 'yyyy-MM-dd',
            'clientOptions' => [
                'changeYear' => true,
                'changeMonth' => true,
                'yearRange' => '2010:2060'
            ],
            'options' => [
                'class' => 'picker-per-beg',

            ],
        ]) ?>

    <?= $form->field($filterForm, 'perEnd')
        ->widget(DatePicker::classname(), [
            'language' => 'ru',
            'dateFormat' => 'php:d M Y', //'yyyy-MM-dd',
            'options' => [
                'class' => 'picker-per-end'
            ],
            'clientOptions' => [
                'changeYear' => true,
                'changeMonth' => true,
                'yearRange' => '2010:2060'
            ],
        ]) ?>
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
                onclick="orderEditFilter('<?= $htmlPrefix ?>-save')">
            save filter
        </button>
    </div>
</div>