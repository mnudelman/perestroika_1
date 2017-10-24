<?php
/**
 * Cписок работ
 * @var $htmlPrefix
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
include_once __DIR__ . '/editWorksFunction.php' ;
// это правая часть - изменения
//$htmlPrefix = 'workDirectionEdit';
$type = 'workDirection';
// левая часть - что имееем      ****
$listItems = [] ;
switch ($objectType) {
    case 'user' :
        $listItems = developerWorkDirectionList() ;
        break ;
    case 'order' :
        $listItems = orderWorkDirectionList_1() ;
}

$styleDropdown = 'overflow-y:auto;max-height:400px;white-space: normal;';

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
        <div class="col-md-12">
<!--            <div class="panel panel-primary">-->
<!--                <div class="panel-heading">-->
<!--                    <h5 class="header-title" style="text-align: left;">-->
<!--                        //=$partsTitleCurrent?><!--</h5>-->
<!--                </div>-->
<!--                <div class="panel-body">-->
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
                        'buttons' => ['null'=> []]
                    ]);
                    ?>
<!--                </div>-->
<!--            </div>-->
        </div>


        <!-- правая часть  -изменения -->

    </div>
</div>
<!--для закрытия  tab потребовался /div    ?????-->
