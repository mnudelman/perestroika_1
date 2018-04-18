<?php
/**
 * Заказ - generalPart
 * @var $htmlPrefix
 * @var $orderGeneral - основные данные о заказе
 * ['orderId' => *,'orderName' => *,
 * 'orderDescription' => *,'perBeg' => *,'perEnd' => *]
 */
?>
<?php
use app\components\CollapsibleListWidget;
use app\components\ToolbarWidget;
use app\components\UserGeography;
use yii\widgets\ActiveForm;
use app\components\GeographySimpleWidget;
use app\models\OrderWork;
use app\service\PageItems;
use yii\jui\DatePicker;
use app\controllers\funcs\OrderFunc;
use app\models\OrderFilterForm;
use app\models\Pagination ;
?>

<?php
//  $htmlPrefix = 'orderEdit';
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

//$res = (new OrderFunc())->getOrderList();

$res = (new OrderFunc())->getOrderPage(Pagination::PAGE_NUM,-1);

$listItems = $res['listItems'] ;
$indexPagesVect = $res['indexPages'] ;
$buttons = $res['buttons'] ;

$orderId = (isset($orderGeneral['orderId'])) ? $orderGeneral['orderId']:'' ;

$cityId = (isset($orderGeneral['cityId'])) ? $orderGeneral['cityId']:'' ;

$orderModel = new OrderWork();
$orderModel->per_beg = (empty($orderId)) ?
    date('Y-m-d', time()) : $orderGeneral['perBeg'];
$orderModel->per_end = (empty($orderId)) ?
    date('Y-m-d', time()) : $orderGeneral['perEnd'];
$orderModel->order_name = (empty($orderId)) ? '' :$orderGeneral['orderName'];
$orderModel->description = (empty($orderId)) ? '' :
                       $orderGeneral['orderDescription'];
$ug = new UserGeography();
$ug->setCityId($cityId) ;
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
    <?= $this->render('orderGeneralRule',
        ['htmlPrefix' => $htmlPrefix,]) ?>

    <div class="row">



        <div class="col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading"  style="margin-bottom: -10px">
                    <?= $this->render('orderGeneralToolbar',
                        ['htmlPrefix' => $htmlPrefix,'indexPagesVect' => $indexPagesVect]) ?>

                </div>
                <div class="panel-body">
                    <?=$this->render('orderFilter',
                        ['htmlPrefix'=>$htmlPrefix,
                         'filterForm'=>$filterForm])?>
                    <?php

                    echo CollapsibleListWidget::widget(['listName' => '',        // например. 'workRegion' - регионы работ
                        'pictureClass' => [ ],
                        'onClick' => ['edit' => 'orderItemEdit',      // реакция на кнопку "редактировать"
                        ],
                        'buttons' => $buttons,
                        'currentItemId' => $orderId,
                        'currentItemClass' => 'setItemHighlight',
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
<!--                    <h5 class="header-title" style="text-align: left;">-->
<!--                        //= $partsTitleEdit ?><!--</h5>-->
<!--                    -->
                    <?php

                    echo ToolbarWidget::widget([
                        'htmlPrefix' => $htmlPrefix,
                        'topology' => [
                            'title' => 4,
                            'buttons' => 8,
                            'pagination' => 0
                        ],
                        'title' => $partsTitleEdit,
                        'buttons' => [
                            'newFile' => [
                                'title' => $tooltipOrderCreate,
                                'clickFunction' => 'orderEditClick',
                                'clickAction' => 'create'
                            ],
                            'clone' => [
                                'title' => $tooltipOrderCopy,
                                'clickFunction' => 'orderEditClick',
                                'clickAction' => 'copy'
                            ],
                            'save' => [
                                'title' => $tooltipOrderSave,
                                'clickFunction' => 'orderEditClick',
                                'clickAction' => 'save'
                            ],
                            'delete' => [
                                'title' => $tooltipOrderDelete,
                                'clickFunction' => 'orderEditClick',
                                'clickAction' => 'delete'
                            ]
                        ],
                        'pagination' => [],
                    ]) ;
                    ?>
                </div>



                <div  class="panel-body" >


                    <?php
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
                    <?= $form->field($orderModel, 'order_name')->textInput(['id'=>$htmlPrefix . '-orderName']) ?>
                    <?= $form->field($orderModel, 'description')->textarea(['id'=>$htmlPrefix . '-description']) ?>
                    <?= $form->field($orderModel, 'per_beg')->widget(DatePicker::classname(), [
                        'language' => 'en',
                        'dateFormat' => 'php: d M Y',
//                                'value' => '20-03-2017',
                        'clientOptions' => [
                            'changeYear' => true,
                            'changeMonth' => true,
                            'yearRange' => '2010:2060'
                        ],
                        'options' => [
                            'class' => 'picker-per-beg',
                            'id' => $htmlPrefix . '-perBeg',

                        ],
                        // inline too, not bad
                    ]) ?>

                    <?= $form->field($orderModel, 'per_end')
                        ->widget(DatePicker::classname(), [
                            'language' => 'en',
                            'dateFormat' => 'php: d M Y',
                            'options' => [
                                'class' => 'picker-per-end',
                                'id' => $htmlPrefix . '-perEnd',
                            ],
                            'clientOptions' => [
                                'changeYear' => true,
                                'changeMonth' => true,
                                'yearRange' => '2010:2060'
                            ],
                        ]) ?>
                    <?= $form->field($orderModel, 'city_id')->
                    widget(GeographySimpleWidget::className(), [
                        'htmlIdPrefix' => $htmlPrefix,
                        'currentCountry' => $userCountry,
                        'currentRegion' => $userRegion,
                        'currentCity' => $userCity,
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


                </div>

            </div>


            <!--                    <button class="btn btn-danger" onclick="restoreWorkGeography()">restore</button>-->
        </div>
    </div>
    <!--                </div>-->
</div>
