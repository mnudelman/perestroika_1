<?php
/**
 * подтверждение почты
 * @var $success
 * @var $userName
 * @var $email
 */
use yii\helpers\Url ;
use app\service\PageItems ;
?>
<?php
$mailTab = PageItems::getItemText(['emailConfirm']) ;
$title = $mailTab['title'] ;
$messageName = ($success) ? 'messageOk' : 'messageError' ;
$messageText = $mailTab[$messageName];
$fields = PageItems::getItemText(['emailConfirm','fields']) ;
$fieldName = $fields['name'] ;

$message = $messageText ;
if ($success) {
    $message = $messageText .
        '<b>' .$fieldName . ':</b><br>' .
        '<b>email:</b>' . $email .'<br>' ;
//    $message = 'Для завершения нажмите "oK!" внизу формы.<br>' .
//        'Ваши реквизиты' .'<br>' .
//        '<b>имя(login):</b>' . $userName .'<br>' .
//        '<b>email:</b>' . $email .'<br>' ;
}else {
    $message = $messageText  ;
//    $message = '<b>Ошибка идентификации в база данных</b>.<br>
//      Для повторения процедуры выполните следущее: <br>
//      -Войдите на сайт под своим именем  <br>
//      -зайдите в "профиль".на вкладке "основное" нажмите "сохранить"<br>' ;
}
//$panelTitle = 'подтверждение правильности email' ;
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
