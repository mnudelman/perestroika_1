<?php
/**
 * формирование запуска widget по имени
 * @var widgetName   - имя widget
 * @var widgetPar -   параметры widget
 * Time: 13:25
 */
//use yii\bootstrap\ButtonDropdown ;
  $exeVar = $widgetName .'::widget($widgetPar)' ;
  ?>
<?php
 switch ($widgetName) {
     case 'ButtonDropdown' :
     echo yii\bootstrap\ButtonDropdown::widget($widgetPar);
         break ;
 }