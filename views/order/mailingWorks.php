<?php
/**
 * География работ
 * Time: 10:44
 */
use yii\bootstrap\ButtonDropdown;
use yii\bootstrap\Dropdown;
use app\components\GeographySimpleWidget;
use app\components\UserGeography;
use app\components\CollapsibleListWidget;
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\WorkDirection;
use \app\models\DeveloperWorkDirection ;
use \app\models\DeveloperWorkItem ;
?>
<?php
// это правая часть - изменения
$workDirection = new WorkDirection();
$wDirectionList = $workDirection->getList();
$workDirectionShow = [];
$liList = [];
$htmlPrefix .= 'Works';
$type = 'workDirection';
// это для выбора из справочника
$onClickFunction = 'newSetItemToggle';
$picture = $wDirectionList[0]['image'];
foreach ($wDirectionList as $key => $wdItem) {
    $workDirectionShow[] = [
        'id' => $wdItem['id'],
        'name' => $wdItem['name_ru'],
        'image' => $wdItem['image'],
    ];
    $liName = $htmlPrefix . '-' . $type . '-' . $wdItem['id'];
    $liList[] = [
        'label' => $wdItem['name_ru'],
        'url' => '#',
        'options' => [
            'class' => 'list-group-item',
            'data-img' => $wdItem['image'],
            'style' => 'white-space:normal',
            'name' => $liName,
            'onclick' => $onClickFunction . "('" . $liName . "')",
        ]
    ];
}
$styleDropdown = 'overflow-y:auto;max-height:400px;white-space: normal;';
// левая часть - что имееем      ****
$devWorkDirection = new DeveloperWorkDirection();
$userId =(Yii::$app->user->isGuest) ? 0 : Yii::$app->user->identity->getId() ;
//$devWorkDirection->userId = $userId ;
$devWorkDirection->parentKeyId = $userId ;
$dWDList = $devWorkDirection->getList() ;
$devWorkItem = new DeveloperWorkItem() ;
// формировать надо вот это
//'listItems' =>
//                            [         // список компонентов
//                                [
//                                    'id' => '1123',
//                                    'name' => 'Алмазная резка и бурение .',
//                                    'editFlag' => true,          // можно редактировать
//                                    'fullyFlag' => false,        // флаг - все возможные sumItems включены
//                                    'subItems' => [             // выпадающий список
//                                        'Алмазная резка бетона, железобетона',
//                                        'Алмазная резка проёмов в стенах, перекрытиях',
//                                        'Штробление бетонных полов, стен'
//                                    ]
//
//                                ],
//                            ],
$listItems = [] ;
foreach ($dWDList as $key => $dWDItem) {
    $item = [
        'id' => $dWDItem['work_direction_id'],
        'name'=> $dWDItem['workDirection']['name_ru'],
        'fullyFlag' => $dWDItem['fully_flag'] - 0 ,
        'editFlag' => true,
    ] ;
//    $devWorkItem->developerWorkDirectionId = $dWDItem['id'] ;
    $devWorkItem->parentKeyId = $dWDItem['id'] ;
    $devWList = $devWorkItem->getList() ;
    $subItems = [] ;
    foreach ($devWList as $subKey => $workItem) {
        $subItems[] = $workItem['workItem']['name_ru'] ;
    }
    $item['subItems'] = $subItems ;
    $listItems[] = $item ;
}
//----------- подписи ---//
$pageItemFile = 'profile/workDirection' ;
$ruleContentId = 'workDirection-form-collapseOne' ;
include('workEditLabels.php') ;     // подписи для  формы



?>
<div class="container-fluid">
    <div id="<?=$htmlPrefix .'-tooltips'?>">
        <input type="text" hidden="hidden" name="itemFully"
               data-yes="<?=$toolTipItemFullyYes?>" data-no="<?=$toolTipItemFullyNo?>">
        <input type="text" hidden="hidden" name="itemDelete"
               data-yes="<?=$toolTipItemDeleteYes?>" data-no="<?=$toolTipItemDeleteNo?>">
        <input type="text" hidden="hidden" name="subItemInWork"
               data-yes="<?=$toolTipSubItemInWorkYes?>" data-no="<?=$toolTipSubItemInWorkNo?>">

    </div>

    <div class="row">
        <?=$this->render($dirLayoutParts . '/ruleAccordion',
            ['ruleTitle'=>$ruleTitle,'ruleContent'=>$ruleContent,
                'ruleContentId' => $ruleContentId])?>
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h5 class="header-title" style="text-align: left;">
                        <?=$partsTitleCurrent?></h5></div>
                <div class="panel-body">
                    <?php

                    echo CollapsibleListWidget::widget([
                        'listName' => '',        // например. 'workRegion' - регионы работ
                        'pictureClass' => [     // картинки, обозначающие действия (см. defaultPictures)
//                                 'edit' => [],
                        ],
                        'onClick' => [
                            'edit' => 'setItemEdit',      // реакция на кнопку "редактировать"
                        ],
                        'htmlPrefix' => $htmlPrefix ,     // префикс id для обеспечения уникальнгости
                        'btTitle' => $toolTipItemEdit,      // поясняющая подпись для кнопки редактирования
                        'listItems' => $listItems,
                    ]);
                    ?>
                </div>
            </div>
        </div>


        <!-- правая часть  -изменения -->

    </div>
</div>
<!--для закрытия  tab потребовался /div    ?????-->
