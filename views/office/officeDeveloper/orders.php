<?php
/**
 * Заказ - generalPart
 * Time: 19:45
 */
?>
<?php

use app\components\CollapsibleListWidget;
use app\components\UserGeography;
//use yii\widgets\ActiveForm;
use app\models\OrderWork;
use app\service\PageItems;
//use yii\jui\DatePicker;
use app\service\TaskStore;
use app\controllers\funcs\OrderFunc;
use app\models\DeveloperOrdersFilterForm;
//use app\components\PaginationWidget ;
use app\views\viewParts\OrderViewPrepareByOrder;

?>

<?php
$htmlPrefix .= 'Orders';
$partsTitleCurrent = 'Заказы с моим участием';
//-------------------------------------------
$toolTipItemEdit = 'редактирование заказа';
$dirLayoutParts = '../layouts/layoutParts';
$partsTitleAdd = 'информация по заказу';
$pageItemFile = 'order/general';
$ruleTab = PageItems::getItemText([$pageItemFile, 'rules']);
$ruleTitle = $ruleTab['title'];
$ruleContent = $ruleTab['content'];
$ruleContentId = 'order-rules-content';
$tooltips = PageItems::getItemText([$pageItemFile, 'tooltips']);
$tooltipItemEdit = $tooltips['itemEdit'];
$tooltipOrderCreate = $tooltips['orderCreate'];
$tooltipOrderCopy = $tooltips['orderCopy'];
$tooltipOrderSave = $tooltips['orderSave'];
$tooltipOrderDelete = $tooltips['orderDelete'];
$partsTitle = PageItems::getItemText([$pageItemFile, 'partsTitle']);
$partsTitleCurrent = 'Заказы'; //$partsTitle['current'];
$partsTitleEdit = $partsTitle['edit'];
$partsTitleView = 'Заказ:';
//-----------------------------------------------

$res = (new OrderFunc('mailing'))->getOrderList();

$listItems = $res['listItems'];
$indexPagesVect = $res['indexPages'];
$buttons = $res['buttons'];
//$resItems = (new OrderViewPrepareByOrder())->getItemsForShow($listItems);

//$listItems = $resItems['setItems'];
//$buttons = $resItems['buttons'];
//$indexPagesVect = (new Pagination('order'))->getIndexPages() ;
$indexPagesList = $indexPagesVect['indexPages'];
$currentPage = $indexPagesVect['currentPage'];
$firstClass = ($indexPagesVect['firstFlag']) ? '' : 'class="disabled"';
$prevClass = ($indexPagesVect['prevFlag']) ? '' : 'class="disabled"';
$nextClass = ($indexPagesVect['nextFlag']) ? '' : 'class="disabled"';
$lastClass = ($indexPagesVect['lastFlag']) ? '' : 'class="disabled"';


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

$filterForm = new DeveloperOrdersFilterForm();
?>
<div class="container-fluid" style="border:2px solid; padding:2px>
    <div id="<?= $htmlPrefix . '-tooltips' ?>">

    </div>
<!--     подсказка  -->

<?= $this->render('ordersRule',
    ['htmlPrefix' => $htmlPrefix,]) ?>

<div class="row">
    <div class="col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">


                <?= $this->render('ordersToolbar',
                    ['htmlPrefix' => $htmlPrefix, 'indexPagesVect' => $indexPagesVect]) ?>


            </div>
            <div class="panel-body">
                <?= $this->render('ordersFilter',
                    ['htmlPrefix' => $htmlPrefix,
                        'filterForm' => $filterForm]) ?>


                <?php

                echo CollapsibleListWidget::widget(['listName' => '',        // например. 'workRegion' - регионы работ
                    'pictureClass' => [     // картинки, обозначающие действия (см. defaultPictures)
                        //                                 'edit' => [],
                    ],
                    'onClick' => ['edit' => 'orderItemEdit',      // реакция на кнопку "редактировать"
                    ],
                    'buttons' => $buttons,
                    'htmlPrefix' => $htmlPrefix,     // префикс id для обеспечения уникальнгости
                    'btTitle' => $toolTipItemEdit,      // поясняющая подпись для кнопки редактирования
                    'listItems' => $listItems,]);
                ?>
            </div>
        </div>
    </div>


    <!-- правая часть  -изменения -->

    <div class="col-md-6">

        <div class="panel panel-primary">
            <div class="panel-heading">
                <h5 class="header-title" id="<?= $htmlPrefix ?>-orderView-title"
                    style="text-align: left;">
                    <?= $partsTitleView ?></h5></div>
            <!--                    <div class="navbar navbar-default" style="margin-bottom:0px;min-height:20px ">-->
            <!--                    </div>-->
            <div class="panel-body" id="<?= $htmlPrefix ?>-orderView" style="display: none;">

                <?php
                $expressStyle = '';
                $hideExpressFlag = true;
                //        $this->render('indexProfile',['htmlPrefix' => $htmlPrefix,
                //        'expressStyle' => $expressStyle,'hideExpressFlag'=>$hideExpressFlag]) ;
                include_once __DIR__ . '/indexOrderView.php';
                ?>

            </div>

        </div>


        <!--                    <button class="btn btn-danger" onclick="restoreWorkGeography()">restore</button>-->
    </div>
</div>
<!--                </div>-->

<!--</div>-->
