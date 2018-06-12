<?php
    /**
     * Редактировать профиль
     * Time: 21:17
     */

    /**
     * @var $htmlPrefix
     */
    use app\components\ProfileGeneralWidget ;
    //use Yii ;
    ?>
    <?php
    $htmlPrefix = (isset($htmlPrefix)) ? $htmlPrefix  : 'profileEdit' ;
    echo ProfileGeneralWidget::widget([
        'htmlPrefix' => $htmlPrefix ,
        'disabled' => false, // - true - запрет редактирования( только просмотр)
         'IDFieldsFlag' => true, // показывать или нет поля - идентификаторы (email, tel, site)
         'content' => []

]) ;