<?php
/**
 * ответ пользователя на предложение участвовать в конкурсе = Выполнить заказ
 * Time: 19:13
 * @var $success
 * @var $company
 * @var $userId
 * @var $orderId
 * @var $orderName
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
$title = 'Подтверждение согласия на участие в конкурсе ' ;
$messageText = 'Вы ' . '<b>(' . $company .')</b><br>' .
           'дали согласие на участие в конкурсе на выполнение заказа № ' .$orderId .
            ' (' . $orderName . ')<br>' .
           'Выбор ИСПОЛНИТЕЛЯ сделает заказчик (пользователь, разместивший заказ)<br>' .
           'Если будет выбрана ваша компания, Вы получите дополнительное уведомление.' ;
$messageError = 'Допущена ошибка при обращении к базе данных.' ;
$message = ($success) ? $messageText : $messageError ;
?>
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title"><?=$title?></h3>
    </div>
    <div class="panel-body">
        <?=$message?>
        <?php
        if (!$success) {
        ?>
            <div class="col-md-5">
                <a class="btn btn-primary" role="button"
                   href="<?=Url::to(['site/index'])?>"
                >
                    Перейти на главную страницу
                </a>
            </div>

        <?php
        } else {
            $answerId = $userId . '-' . $orderId ;
            ?>
            <div class="col-md-1">
                <a class="btn btn-success" role="button"
                   onclick='orderAnswer("<?= $answerId . '-yes' ?>")'
                >
                    oK!
                </a>
            </div>
            <div class="col-md-3">
                <a class="btn btn-warning" role="button"
                   onclick='orderAnswer("<?= $answerId . '-no' ?>")'
                >
                    ОТКАЗ
                </a>
            </div>
            <div class="col-md-5">
                <a class="btn btn-primary" role="button"
                   onclick='orderAnswer("<?= $answerId . '-office' ?>")'
                >
                    Для принятия решения перейти в кабинет
                </a>
            </div>
            <?php
        }
        ?>
    </div>
</div>
