<?php
/**
 *  шаблон трёхуровневой модели
 * @var $htmlPrefix
 * @var $rootPanel - начало панели
 * @var $listPanelHeading - левая часть - заголовок
 * @var $listPanelBody ,    - левая часть - тело
 * @var $addPanelHeading - раздел "Добавить новый элемент множества"
 * @var $addPanelBody - ---------------""--------------------
 * @var $ediPanelHeading ,  - раздел "изменить атрибуты(компоненты) элемента множества
 * функция variableWidget($widgetName,$widgetPar) - запускает widget по имени
 *      загружается в корне при запуске index
 */
?>
<?php

?>
<div class="container-fluid">
    <?php
    variableWidget($rootPanel) ;
    ?>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <?php
                    variableWidget($listPanelHeading) ;
                    ?>

                </div>
                <div class="panel-body">
                    <?php
                    variableWidget($listPanelBody) ;
                    ?>
                </div>
            </div>
        </div>
        <div class="col-md-6">

            <div class="panel panel-primary">
                <div class="panel-heading">
                    <?php
                    variableWidget($addPanelHeading) ;
                    ?>

                </div>
                <div class="panel-body">


                    <div class="row">

                        <?php
                        variableWidget($addPanelBody) ;
                        ?>

                        <button class="btn btn-success" role="button"
                                onclick="addNewSetItem('<?=$htmlPrefix?>')"
                                title="add item">
                            <span class="glyphicon glyphicon-plus"></span>
                        </button>


                    </div>

                </div>
            </div>
            <div class="panel panel-primary" id="<?= $htmlPrefix ?>-edit-panel">
                <div class="panel-heading">
                    <?php
                    variableWidget($editPanelHeading) ;
                    ?>



                </div>
                <div class="panel-body">
                    <!--                 <span id="workRegionEdit-placeHolder">Область изменений географии работ</span>-->
                    <div hidden="hidden" id="<?= $htmlPrefix ?>-edit-area">
                        <!--                    <ul class="list-group" >-->
                        <a class="btn btn-default setItemHighlight" role="button" data-toggle="collapse" style="width:82%"
                           aria-expanded="true"
                           data-set-id="" data-set-item-id=""
                           href="#<?= $htmlPrefix ?>-editSetItem-ul"
                           aria-controls="<?= $htmlPrefix ?>-editSetItem-ul"
                           id="<?=$htmlPrefix?>-editSetItem-bt">
                            <span> Свердловская обл.</span><b class="caret"></b>
                        </a>
                        <a class="btn btn-default" role="button" title="region fully in work geography"
                           id="<?=$htmlPrefix?>-fully-bt"
                           onclick="setItemStat('<?=$htmlPrefix?>-fully')">
                            <span class="glyphicon glyphicon-share"></span>
                        </a>
                        <a class="btn btn-default" role="button" title="region removed from work gegraphy"
                           id="<?=$htmlPrefix?>-delete-bt"
                           onclick="setItemStat('<?=$htmlPrefix?>-delete')">
                            <span class="glyphicon glyphicon-minus"></span>
                        </a>

                        <ul class="list-group collapse.in"
                            id="<?= $htmlPrefix ?>-editSetItem-ul"
                            style="overflow:auto; max-height:200px">
                            <li class="list-group-item" name="city-[city_id]">Нижний тагил
                                <a class="btn btn-default btn-sm" role="button" title="city is in work"
                                   onclick="setSubItemStat(<?=$htmlPrefix?>'-city_id')">
                                    <span class="glyphicon glyphicon-ok"></span>
                                </a>

                            </li>
                            <li class="list-group-item">
                                Екатеринбург
                                <a class="btn btn-default btn-sm" role="button" title="city not in work">
                                    <span class="glyphicon glyphicon-remove"></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <!--                </div>-->
            </div>
        </div>
    </div>
</div>
