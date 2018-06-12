<?php
/**
 * Переписка - взаимодействие внутрипортала
 * @var $htmlPrefix
 */
?>
<?php
use app\components\UserGeography;
use app\models\OrderWork;
use app\service\TaskStore;
use app\components\OrderGeneralWidget ;
?>

<?php
$htmlPrefix = $htmlPrefix . 'OrderGeneral' ;
$order = TaskStore::getParam('currentOrder') ;
if (!empty($order)) {
    $orderId = $order['orderId'] ;
//
    $orderModel = OrderWork::findOne($orderId) ;
}else {
    $orderModel = new OrderWork();
    $orderModel->per_beg = date('Y-m-d', time());
    $orderModel->per_end = date('Y-m-d', time());

}
$ug = new UserGeography();
$ownGeography = $ug->getOwnGeography();
$userCountry = $ownGeography['userCountry'];
$userRegion = $ownGeography['userRegion'];
$userCity = $ownGeography['userCity'];
?>
<div class="container-fluid">
    <div id="<?= $htmlPrefix . '-tooltips' ?>">

    </div>

    <div class="row">
        <!-- правая часть  -изменения -->

        <div class="col-md-12">

            <?php
            echo OrderGeneralWidget::widget([
                'htmlPrefix' => $htmlPrefix,
                'orderModel' => $orderModel,
                'userCountry' => $userCountry,
                'userRegion' => $userRegion,
                'userCity' => $userCity,
                'disabled' => true,
            ]);
            ?>

        </div>
    </div>
</div>
