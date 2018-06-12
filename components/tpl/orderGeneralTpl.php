<?php
/**
 * шаблон для orderGeneral - страница описания ЗАКАЗА
 * @var $htmlPrefix
 * @var $orderModel
 * @var $userCountry
 * @var $userRegion
 * @var $userCity
 * @var $disabled
 */
?>
<?php
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
use app\components\GeographySimpleWidget ;

$htmlDesabled = ($disabled) ? 'disabled="disabled"' : '' ;
$fieldsName = ['orderName','description','perBeg','perEnd'] ;
$options = [] ;
foreach ($fieldsName as $ind => $field) {
    $options[$field]['id'] = $htmlPrefix . '-' . $field ;
    if ($disabled) {
        $options[$field]['disabled'] = 'disabled' ;
    }
    if ($field === 'perBeg') {
        $options[$field]['class'] = 'picker-per-beg' ;
    }
    if ($field === 'perEnd') {
        $options[$field]['class'] = 'picker-per-end' ;
    }

}
$form = ActiveForm::begin([
    'id' => 'work-order-form',
    'action' => '#',
    'options' => ['class' => 'form-horizontal'],
    'fieldConfig' => [
        'template' => "{label}\n<div class=\"col-lg-10\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
        'labelOptions' => ['class' => 'col-lg-2 control-label'],
    ],
]);
?>
<!---->
<?= $form->field($orderModel, 'order_name')->textInput($options['orderName']) ?>
<?= $form->field($orderModel, 'description')->textarea($options['description']) ?>
<?= $form->field($orderModel, 'per_beg')->widget(DatePicker::classname(), [
    'language' => 'en',
    'dateFormat' => 'php: d M Y',
//                                'value' => '20-03-2017',
    'clientOptions' => [
        'changeYear' => true,
        'changeMonth' => true,
        'yearRange' => '2010:2060'
    ],
    'options' => $options['perBeg'],
    // inline too, not bad
]) ?>

<?= $form->field($orderModel, 'per_end')
    ->widget(DatePicker::classname(), [
        'language' => 'en',
        'dateFormat' => 'php: d M Y',
        'options' =>  $options['perEnd'],
        'clientOptions' => [
            'changeYear' => true,
            'changeMonth' => true,
            'yearRange' => '2010:2060',
        ],
    ]) ?>
<?= $form->field($orderModel, 'city_id')->
widget(GeographySimpleWidget::className(), [
    'htmlIdPrefix' => $htmlPrefix,
    'currentCountry' => $userCountry,
    'currentRegion' => $userRegion,
    'currentCity' => $userCity,
    'disabled' => $disabled,

]);
?>
<div class="col-lg-offset-1" name="form-messages" style="color:#ff0000;">
</div>
<div class="form-messages-success" name="form-messages-success">

</div>
<div class="form-messages-error" name="form-messages-error">

</div>
<?php
ActiveForm::end();
?>
