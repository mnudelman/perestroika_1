<?php
/**
 * Рассылка заказов
 * Time: 20:00
 */

/**
 * Заказ - generalPart
 * Time: 19:45
 */
?>
<?php
use app\components\CollapsibleListWidget;
use app\models\OrderAdditional;
use app\controllers\funcs\OrderStatFunc ;
use app\service\PageItems;
//use yii\jui\DatePicker;
use app\service\TaskStore;
//use yii\bootstrap\Tabs;
use app\controllers\funcs\DeveloperFunc ;
//use app\components\PaginationWidget ;
use app\models\OrderMailingFilterForm ;
use app\models\MailingSetupForm ;
//use yii\bootstrap\ButtonDropdown ;
////use app\views\order\OrderMailingPrepare ;
use app\views\viewParts\OrderViewPrepare ;
//use dosamigos\datepicker\DatePicker ;
?>

<?php
$htmlPrefix = $htmlPrefix . 'Mailing' ; //'orderEditMailing';
$partsTitleCurrent = 'Текущие заказы';
$ruleTitle = 'Правила оформления заказа';
$ruleContent = 'Заполняйте правильно!!';
//-------------------------------------------



$partsTitleCurrent = 'Текущие заказы';
//$ruleTitle = 'Правила оформления заказа';
//$ruleContent = 'Заполняйте правильно!!';
//-------------------------------------------
$toolTipItemEdit = 'редактирование заказа';
$dirLayoutParts = '../layouts/layoutParts';
$partsTitleAdd = 'создание/изменение заказа';
$pageItemFile = 'order/mailing';
$ruleTab = PageItems::getItemText([$pageItemFile, 'rules']);
$ruleTitle = $ruleTab['title'];
$ruleContent = $ruleTab['content'];
$tooltips = PageItems::getItemText([$pageItemFile, 'tooltips']);
$tooltipItemEdit = $tooltips['itemEdit'];
$tooltipOrderCreate = $tooltips['orderCreate'];
$tooltipOrderCopy = $tooltips['orderCopy'];
$tooltipOrderSave = $tooltips['orderSave'];
$tooltipOrderDelete = $tooltips['orderDelete'];
$partsTitle = PageItems::getItemText([$pageItemFile, 'partsTitle']);
$partsTitleCurrent = 'Выбор исполнителя';
$partsTitleEdit = $partsTitle['edit'];
//-----------------------------------------------
$ln = TaskStore::getParam('currentLanguage');
$newText = (empty($ln) || $ln == 'ru') ? 'новый' : 'new';
$orderText = (empty($ln) || $ln == 'ru') ? 'заказ' : 'order';
$orderLabel = $orderText . ' № xxxxxxx (<b>' . $newText . '</b>)';
$listItems = [];
$additionalModel = new OrderAdditional();
$mailingModel = new OrderStatFunc();
$infoFields = PageItems::getItemText([$pageItemFile, 'infoFields']);

$toolTipEmptyPicture = 'fa fa-square-o fa-lg';   // пустой квадрат

$toolTipShowMore = 'Показать профиль исполнителя';
$toolTipShowMorePicture = 'fa fa-caret-right fa-lg';

$toolTipSendOfferEmpty = 'кликните чтобы отправить предложение исполнить заказ';
$toolTipSendOfferPrepare = 'готовность к отправке предложения';
$toolTipSendOfferYes = 'предложение исполнителю отправлено';

$toolTipSendOfferPreparePicture = 'fa fa-send-o';
$toolTipSendOfferYesPicture = 'fa fa-send fa-lg';


$toolTipSelectedEmpty = 'Нет подтверждения о готовности выполнить заказ';
$toolTipAnswered = 'Получено подтверждение о готовности выполнить заказ';
$toolTipSelectedYes = 'Исполнитель выбран для исполнения заказа';
$toolTipAnsweredPicture = 'fa fa-thumbs-o-up';
$toolTipSelectedYesPicture = 'fa fa-star fa-lg';

$df = new DeveloperFunc();
//$df->setNewOrder(1) ;
$l = $df->getDataFirstPage() ;
$lItems = $l['listItems'] ;
$indexPages = $l['indexPages'] ;

$filterForm = new OrderMailingFilterForm() ;
$mailingSetupForm = new MailingSetupForm() ;
//$listForShow = (new OrderMailingPrepare())->getItemsForShow($lItems) ;

$listForShow = (new OrderViewPrepare())->getItemsForShow($lItems) ;




$listItems = $listForShow['setItems'] ;
$buttons = $listForShow['buttons'] ;

?>
<div class="container-fluid">
    <div id="<?= $htmlPrefix . '-tooltips' ?>">
        <input type="text" hidden="hidden" name="showMore"
               data-yes="<?= $toolTipShowMore ?>"
               data-picture="<?= $toolTipShowMorePicture ?>"
            >
        <input type="text" hidden="hidden" name="sendOffer"
               data-empty="<?= $toolTipSendOfferEmpty ?>"
               data-prepare="<?= $toolTipSendOfferPrepare ?>"
               data-yes="<?= $toolTipSendOfferYes ?>"
               data-picture-empty="<?= $toolTipEmptyPicture ?>"
               data-picture-prepare="<?= $toolTipSendOfferPreparePicture ?>"
               data-picture-yes="<?= $toolTipSendOfferYesPicture ?>"

            >
        <input type="text" hidden="hidden" name="selectedDeveloper"
               data-empty="<?= $toolTipSelectedEmpty ?>"
               data-answered="<?= $toolTipAnswered ?>"
               data-yes="<?= $toolTipSelectedYes ?>"
               data-picture-empty="<?= $toolTipEmptyPicture ?>"
               data-picture-prepare="<?= $toolTipAnsweredPicture ?>"
               data-picture-yes="<?= $toolTipSelectedYesPicture ?>"
            >

    </div>
    <!--     подсказка  -->

    <?= $this->render('orderMailingRule',
        ['htmlPrefix' => $htmlPrefix,]) ?>
    <div class="row">
        <div class="col-md-6">

            <div class="panel panel-primary">
                <div class="panel-heading" style="margin-bottom: -30px">
                    <?= $this->render('orderMailingToolbar',
                        ['htmlPrefix' => $htmlPrefix,'indexPagesVect' => $indexPages]) ?>


                </div>
            </div>
            <div class="panel-body">
                <?=$this->render('orderMailingFilter',
                    ['htmlPrefix'=>$htmlPrefix,
                        'filterForm'=>$filterForm])?>

                <?=$this->render('mailingSetup',
                    ['htmlPrefix'=>$htmlPrefix])?>

                <?php

                $toolTipSendOfferPreparePicture = 'fa fa-send-o';
                echo CollapsibleListWidget::widget(['listName' => '',        // например. 'workRegion' - регионы работ
                    'pictureClass' => [     // картинки, обозначающие действия (см. defaultPictures)
                        //                                 'edit' => [],
                    ],
                    'onClick' => ['edit' => 'orderItemEdit',      // реакция на кнопку "редактировать"
                    ],
                    'htmlPrefix' => $htmlPrefix,     // префикс id для обеспечения уникальнгости
                    'btTitle' => $toolTipItemEdit,      // поясняющая подпись для кнопки редактирования
                    'buttons' => $buttons,
                    'listItems' => $listItems,]);
                ?>
            </div>
        </div>
<!--    </div>-->


    <!-- правая часть  -изменения -->

    <div class="col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading" id="<?=$htmlPrefix?>-profile-title" >
                        <h5 class="header-title" style="text-align: left;">профиль:</h5></div>
            <div class="panel-body" id="<?=$htmlPrefix?>-profile" style="display: none">
                <?php
                $expressStyle = '';
                $hideExpressFlag = true;
                //        $this->render('indexProfile',['htmlPrefix' => $htmlPrefix,
                //        'expressStyle' => $expressStyle,'hideExpressFlag'=>$hideExpressFlag]) ;
                include_once __DIR__ . '/indexProfile.php' ;
            ?>
            </div>
        </div>
    </div>
</div>
<!--                </div>-->
<!--</div>-->
