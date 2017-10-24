<?php
/**
 * Переписка - взаимодействие внутрипортала
 */
?>
Это переписка
<?php
/**
 * Заказ - generalPart
 * Time: 19:45
 */
?>
<?php
use app\components\CollapsibleListWidget;
use app\components\UserGeography;
use yii\widgets\ActiveForm;
use app\components\GeographySimpleWidget;
use app\models\OrderWork;
//use app\models\OrderAdditional;
//use app\models\OrderMailing;
use app\service\PageItems;
use yii\jui\DatePicker;
use app\service\TaskStore;
use app\controllers\OrderFunc;
use app\models\OrderFilterForm;
//use app\models\Pagination ;
//use app\components\PaginationWidget ;
//use app\components\RuleTextWidget ;
//use dosamigos\datepicker\DatePicker ;
?>

<?php
$htmlPrefix = 'orderEdit';
$partsTitleCurrent = 'Текущие заказы';
//-------------------------------------------
$toolTipItemEdit = 'редактирование заказа';
$dirLayoutParts = '../layouts/layoutParts';
$partsTitleAdd = 'создание/изменение заказа';
$pageItemFile = 'order/general';
$tooltips = PageItems::getItemText([$pageItemFile, 'tooltips']);
$tooltipItemEdit = $tooltips['itemEdit'];
$tooltipOrderCreate = $tooltips['orderCreate'];
$tooltipOrderCopy = $tooltips['orderCopy'];
$tooltipOrderSave = $tooltips['orderSave'];
$tooltipOrderDelete = $tooltips['orderDelete'];

$partsTitle = PageItems::getItemText([$pageItemFile, 'partsTitle']);
$partsTitleCurrent = $partsTitle['current'];
$partsTitleEdit = $partsTitle['edit'];
//-----------------------------------------------

$res = (new OrderFunc())->getOrderList();

$listItems = $res['listItems'] ;
$indexPagesVect = $res['indexPages'] ;

$ln = TaskStore::getParam('currentLanguage');
$newText = (empty($ln) || $ln == 'ru') ? 'не определён' : 'not defined';
$orderText = (empty($ln) || $ln == 'ru') ? 'заказ' : 'order';
$orderLabel = $orderText . ' № xxxxxxx (<b>' . $newText . '</b>)';
$orderModel = new OrderWork();
$orderModel->per_beg = date('Y-m-d', time());
$orderModel->per_end = date('Y-m-d', time());
$ug = new UserGeography();
$ownGeography = $ug->getOwnGeography();
$userCountry = $ownGeography['userCountry'];
$userRegion = $ownGeography['userRegion'];
$userCity = $ownGeography['userCity'];

$filterForm = new OrderFilterForm();
?>




<div class="container-fluid">
    <div id="<?= $htmlPrefix . '-tooltips' ?>">

    </div>
    <!--     подсказка  -->
<!--    ?= $this->render('orderGeneralRule',-->
<!--        ['htmlPrefix' => $htmlPrefix,]) ?>-->

    <div class="row">
        <div class="col-md-6">
            <?php
            $baseScel = '/viewParts/communicationLeft' ;
            //$htmlPrefix .= 'Gallery';
            $objectType = 'order' ;
            ?>
            <?=$this->render($baseScel,['htmlPrefix'=>$htmlPrefix,
                'indexPagesVect' => $indexPagesVect,
                'objectType'=> $objectType])?>

        </div>
        <!-- правая часть  -изменения -->

        <div class="col-md-6">

            <?php
            $baseScel = '/viewParts/communicationRight' ;
            //$htmlPrefix .= 'Gallery';
            $objectType = 'order' ;
            ?>
            <?=$this->render($baseScel,['htmlPrefix'=>$htmlPrefix,
                'indexPagesVect' => $indexPagesVect,
                'objectType'=> $objectType])?>
            <!--                    <button class="btn btn-danger" onclick="restoreWorkGeography()">restore</button>-->
        </div>
    </div>
    <!--                </div>-->
</div>
