<?php
/**
 * состав работ
 * @var $htmlPrefix
 * @var $objectType = {'user' | 'order'}
 */
use yii\bootstrap\ButtonDropdown;
use yii\bootstrap\Dropdown;
use app\components\CollapsibleListWidget;
use yii\helpers\Html;
use yii\helpers\Url;
?>
<?php
include_once __DIR__ . '/editWorksFunction.php';
// это правая часть - изменения
//$htmlPrefix = 'workDirectionEdit';
$type = 'workDirection';
$liList = workDirectionList($htmlPrefix,$type) ;

$picture = $liList[0]['options']['data-img'];
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
include('workEditLabels.php');     // подписи для  формы
?>

<div class="container-fluid">
    <div id="<?=$htmlPrefix .'-tooltips'?>">
        <input type="text" hidden="hidden" name="itemFully"
               data-yes="<?=$tooltipItemFullyYes?>" data-no="<?=$tooltipItemFullyNo?>">
        <input type="text" hidden="hidden" name="itemDelete"
               data-yes="<?=$tooltipItemDeleteYes?>" data-no="<?=$tooltipItemDeleteNo?>">
        <input type="text" hidden="hidden" name="subItemInWork"
               data-yes="<?=$tooltipSubItemInWorkYes?>" data-no="<?=$tooltipSubItemInWorkNo?>">

    </div>

    <div class="row">
        <?=$this->render($dirLayoutParts . '/ruleAccordion',
            ['ruleTitle'=>$ruleTitle,'ruleContent'=>$ruleContent,
                'ruleContentId' => $ruleContentId])?>
        <div class="col-md-6">
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
                        'btTitle' => $tooltipItemEdit,      // поясняющая подпись для кнопки редактирования
                        'listItems' => $listItems,
                    ]);
                    ?>
                </div>
            </div>
        </div>


<!-- правая часть  -изменения -->

        <div class="col-md-6">

            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h5 class="header-title" style="text-align: left;"><?=$partsTitleAdd?></h5></div>
                <div class="panel-body">


                    <div class="row">
                        <div class="col-md-8" style="max-width:80%">
                            <?php
                            $btName = $liList[0]['options']['name'];
                            $id = $htmlPrefix . '-newSetItem-bt';
                            echo ButtonDropdown::widget([
                                'label' => $liList[0]['label'],
                                'id' => $htmlPrefix . '-newSetItem-bt',     // geography-country-bt
                                'options' => [
                                    'name' => $btName,
                                    'class' => 'btn-primary',
                                    'style' => 'white-space: normal;'
                                ],
                                'dropdown' => [
                                    'options' => [
                                        'class' => 'list-group',
                                        'style' => 'white-space:normal;',
                                        'id' => $htmlPrefix . '-newSetItem-ul',     // geography-country-ul
                                        'name' => $btName,
                                    ],
                                    'items' => $liList]
                            ]);
                            ?>
                        </div>

                        <?php
                          $imgClick = "newSetItemPictureToggle('" . $htmlPrefix . "-newSetItem-bt').click()" ;
                        ?>
                        <a href="#" onclick="<?=$imgClick?>">
                        <?= Html::img('@web/images/' . $picture,
                            ['height' => '50px',
                                'id' => $htmlPrefix . '-newSetItem-img',
                                'data-dir' => Url::to('@web/images/'),
                            ]); ?>
                        </a>
                        <button class="btn btn-success" role="button"
                                onclick="addNewSetItem('<?= $htmlPrefix ?>')"
                                title="<?=$tooltipItemAdd?>">
                            <span class="glyphicon glyphicon-plus"></span>
                        </button>
                    </div>

                </div>

            </div>

            <div class="panel panel-primary" id="workDirectionEdit-panel">
                <div class="panel-heading">
                    <h5 class="header-title" style="text-align: left;"><?=$partsTitleEdit?></h5></div>
                <div class="panel-body">
                    <!--                 <span id="workRegionEdit-placeHolder">Область изменений географии работ</span>-->
                    <div id="workDirectionEdit-area" hidden="hidden">
                        <!--                    <ul class="list-group" >-->
                        <a class="btn btn-default" role="button" data-toggle="collapse"
                          data-fullyFlag="false"
                           style="width:82%;white-space: normal;"
                           aria-expanded="true" href="#workDirectionEdit-editSetItem-ul"
                           aria-controls="workDirectionEdit-editSetItem-ul"
                           id="workDirectionEdit-editSetItem-bt">
                            <span> Алмазное бурениеи сверление.</span><b class="caret"></b>
                        </a>
                        <a class="btn btn-default" role="button" title="region fully in work geography"
                           id="workDirectionEdit-fully-bt" onclick="setItemStat('<?=$htmlPrefix?>-fully')"
                           data-toggle="tooltip" data-placement="left" >
                            <span class="glyphicon glyphicon-share"></span>
                        </a>
                        <button class="btn btn-default" role="button" title="region removed from work gegraphy"
                           id="workDirectionEdit-delete-bt" onclick="setItemStat('<?=$htmlPrefix?>-delete')"
                           data-toggle="tooltip" data-placement="top">
                            <span class="glyphicon glyphicon-minus"></span>
                        </button>

                        <ul class="list-group collapse.in" id="workDirectionEdit-editSetItem-ul"
                            style="overflow:auto; max-height:200px;white-space:normal;">
                            <li class="list-group-item" name="workItem-[item_id]">
                                'Алмазная резка бетона, железобетона',
                                <a class="btn btn-success btn-sm" role="button" title="city is in work"
                                   onclick="workDirectionItemStat(item_id)">
                                    <span class="glyphicon glyphicon-ok"></span>
                                </a>

                            </li>
                            <li class="list-group-item">
                                'Алмазная резка проёмов в стенах, перекрытиях',
                                <a class="btn btn-default btn-sm" role="button" title="city not in work">
                                    <span class="glyphicon glyphicon-remove"></span>
                                </a>
                            </li>
                        </ul>
                        <!--
     </ul>-->
                        <div class="row">
                            <div class="col-md-3">
                                <button class="btn btn-primary"
                                        onclick="setItemSave('<?=$htmlPrefix?>')">
                                    <?=$btSave?>
                                </button>
                            </div>
                            <div class="col-md-8">

                                <div class="input-group" id="<?=$htmlPrefix?>-onlySelectedShow"
                                     onclick="setSubItemShowStat('<?=$htmlPrefix?>')">
                                  <span class="input-group-addon">
                                      <input type="checkbox" aria-label="selected only">
                                   </span>
                                   <input type="text" class="form-control" readonly="readonly"
                                          aria-label="selected only" value="режим просмотра">
                                </div>
                            </div>
                        </div>

                        <!--                    <button class="btn btn-danger" onclick="restoreWorkGeography()">restore</button>-->
                    </div>
                </div>
                <!--                </div>-->
            </div>
        </div>
    </div>
</div>
