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
use app\models\OrderAdditional;
use app\models\OrderMailing;
use app\service\PageItems;
use yii\jui\DatePicker;
use app\service\TaskStore;

//use dosamigos\datepicker\DatePicker ;
?>

<?php
$htmlPrefix = 'orderEdit';
$partsTitleCurrent = 'Текущие заказы';
//$ruleTitle = 'Правила оформления заказа';
//$ruleContent = 'Заполняйте правильно!!';
//-------------------------------------------
$toolTipItemEdit = 'редактирование заказа';
$dirLayoutParts = '../layouts/layoutParts';
$partsTitleAdd = 'создание/изменение заказа';
$pageItemFile = 'order/general';
$ruleTitleTab = PageItems::getItemText([$pageItemFile, 'rules', 'title']);
$ruleTitle = $ruleTitleTab['text'];
$ruleContentTab = PageItems::getItemText([$pageItemFile, 'rules', 'content']);
$ruleContent = $ruleContentTab['text'];
$ruleContentId = 'order-rules-content';
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
$ug = new UserGeography();
$ownGeography = $ug->getOwnGeography();
$userCountry = $ownGeography['userCountry'];
$userRegion = $ownGeography['userRegion'];
$userCity = $ownGeography['userCity'];
$orderModel = new OrderWork();
$orderModel->per_beg = date('Y-m-d', time());
$orderModel->per_end = date('Y-m-d', time());
// формировать надо вот это
$orderList = $orderModel->getList();
$ln = TaskStore::getParam('currentLanguage');
$newText = (empty($ln) || $ln == 'ru') ? 'новый' : 'new';
$orderText = (empty($ln) || $ln == 'ru') ? 'заказ' : 'order';
$orderLabel = $orderText . ' № xxxxxxx (<b>' . $newText . '</b>)';
$listItems = [];
$additionalModel = new OrderAdditional();
$mailingModel = new OrderMailing();
$infoFields = PageItems::getItemText([$pageItemFile, 'infoFields']);
foreach ($orderList as $ind => $orderItem) {
    $item = [];
    $id = $orderItem['id'];
    $name = $orderItem['order_name'];
    $descript = $orderItem['description'];
    $timeCreate = date('d-m-y', strtotime($orderItem['time_create']));
    $perBeg = date('Y-m-d', strtotime($orderItem['per_beg']));
    $perEnd = date('Y-m-d', strtotime($orderItem['per_end']));
    $item['id'] = $orderItem['id'];

    $mailingModel->currentOrderId = $id;
    $additionalModel->currentOrderId = $id;
    $addList = $additionalModel->getList();
    $sentList = $mailingModel->typeCount();
    $sentTotal = 0;
    $answered = 0;
    $isSelected = false;
    foreach ($sentList as $key => $value) {
        switch ($key) {
            case OrderMailing::STAT_SENT :
                $sentTotal = $value;
                break;
            case OrderMailing::STAT_ANSWERED :
                $answered = $value;
                break;
            case OrderMailing::STAT_SELECTED :
                $isSelected = ($value) ? true : false;;
                break;

        }
    }

    $fullName = '№ ' . $id . ' от ' . $timeCreate . ' ' . $name;
    $subItems = [];
    $perText = '<b>' . $infoFields['period'] . ': ' . '</b>' . $perBeg . ' - ' . $perEnd;
    $subItems[] = $perText;
    $subItems[] = '<b>' . $infoFields['description'] . ': ' . '</b>' . $descript;
    $subItems[] = '<b>' . $infoFields['additional'] . ': ' . '</b>' . '0';
    $subItems[] = '<b>' . $infoFields['mailing'] . ': ' . '</b>' . $sentTotal;
    $subItems[] = '<b>' . $infoFields['answers'] . ': ' . '</b>' . $answered;
    if ($isSelected) {
        $subItems[] = '<b>' . $infoFields['selectedYes'] . '</b>';
    } else {
        $subItems[] = '<b>' . $infoFields['selectedNo'] . '</b>';
    }
    $subItems[] = '<b>' . 'город' . ': ' . '</b>' . $userCity['name'];

    $item = [
        'id' => $id,
        'name' => $fullName,
        'fullyFlag' => false,
        'editFlag' => true,
        'subItems' => $subItems,
    ];
    $listItems[] = $item;

}
//$listItems =
//    [         // список компонентов
//        [
//            'id' => '1123',
//            'name' => '№ 001 от 01.02.2017 Технологические отверстия.',
//            'editFlag' => true,          // можно редактировать
//            'fullyFlag' => false,        // флаг - все возможные sumItems включены
//            'subItems' => [             // выпадающий список
//                'период: 01.02.2017 - 05.02.2017',
//                'описание:Ремонтные работы.Технологические отверстия 100шт под сантехнику',
//                '<b>доп материалы</b>: нет',
//                'исполнитнль:определён'
//            ]
//
//        ],
//    ];

?>
<div class="container-fluid">
    <div id="<?= $htmlPrefix . '-tooltips' ?>">

    </div>

    <div class="row">
        <?= $this->render($dirLayoutParts . '/ruleAccordion',
            ['ruleTitle' => $ruleTitle, 'ruleContent' => $ruleContent,
                'ruleContentId' => $ruleContentId]) ?>
        <div class="col-md-10">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h5 class="header-title" style="text-align: left;">
                        <?= $partsTitleCurrent ?></h5></div>
                <div class="panel-body">
                    <?php

                    echo CollapsibleListWidget::widget(['listName' => '',        // например. 'workRegion' - регионы работ
                        'pictureClass' => [     // картинки, обозначающие действия (см. defaultPictures)
                            //                                 'edit' => [],
                        ],
                        'onClick' => ['edit' => 'orderItemEdit',      // реакция на кнопку "редактировать"
                        ],
                        'htmlPrefix' => $htmlPrefix,     // префикс id для обеспечения уникальнгости
                        'btTitle' => $toolTipItemEdit,      // поясняющая подпись для кнопки редактирования
                        'listItems' => $listItems,]);
                    ?>
                </div>
            </div>
        </div>


        <!-- правая часть  -изменения -->

    </div>
    <!--                </div>-->
</div>
