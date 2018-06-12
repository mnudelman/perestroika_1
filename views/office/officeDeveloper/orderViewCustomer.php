<?php
/**
 * Справка о заказчике
 * @var $htmlPrefix
 */
?>
<?php
    use app\components\ProfileGeneralWidget ;
?>
<?php
$htmlPrefix = (isset($htmlPrefix)) ? $htmlPrefix  : 'profileEdit' ;
echo ProfileGeneralWidget::widget([
    'htmlPrefix' => $htmlPrefix ,
    'disabled' => true, // - true - запрет редактирования( только просмотр)
    'IDFieldsFlag' => false, // показывать или нет поля - идентификаторы (email, tel, site)
    'content' => ['avatar' => true,'formEdit'=>true]

]) ;