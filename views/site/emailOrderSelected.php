<?php
/**
 * ответ пользователя на предложение ИСПОЛНИТЬ ЗАКЗА
 */
use yii\helpers\Url ;
use app\service\PageItems ;
?>
<?php
//$mailTab = PageItems::getItemText(['emailConfirm']) ;
//$title = $mailTab['title'] ;
//$messageName = ($success) ? 'messageOk' : 'messageError' ;
//$messageText = $mailTab[$messageName];
//$fields = PageItems::getItemText(['emailConfirm','fields']) ;
//$fieldName = $fields['name'] ;
$title = 'Подтверждение согласия на ВЫПОЛНЕНИЕ ЗАКАЗА ' ;
$messageText = 'ЗАКАЗЧИК(пользователь, разместивший заказ)<br>' .
               'выбрал <b>ВАС (' .$company . ')' .'<br>' .
              'ИСПОЛНИТЕЛЕМ ЗАКАЗА № ' .$orderId .' (' . $orderName . ')<br>'  ;

$messageError = 'Допущена ошибка прри обращении к базе данных.' ;
$message = ($success) ? $messageText : $messageError ;
?>
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title"><?=$title?></h3>
    </div>
    <div class="panel-body">
        <?=$message?>
        <div class="col-md-1">
            <a class="btn btn-primary" role="button" href="<?=Url::to(['site/index'])?>">
                oK!
            </a>
        </div>

    </div>
</div>
