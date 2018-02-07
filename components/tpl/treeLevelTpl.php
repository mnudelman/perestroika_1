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
 */
?>
<?php
//include_once __DIR__ . '/variableWidget___.php' ;

 function variableWidget($widgetList) {
   if (is_array($widgetList)) {
       foreach ($widgetList as $name => $widgetItem) {
           $name = $widgetItem['name'] ;
           $par =  $widgetItem['par'] ;
           widgetCase__($name,$par) ;
       }

   }
 }
 function widgetCase__($widgetName, $widgetPar) {
     switch ($widgetName) {
         case 'ButtonDropdown' :
             echo yii\bootstrap\ButtonDropdown::widget($widgetPar);
             break ;
         case 'GeographySimpleWidget' :
             echo app\components\GeographySimpleWidget::widget($widgetPar);
             break ;
         case 'CollapsibleListWidget' :
             echo app\components\CollapsibleListWidget::widget($widgetPar);
             break ;
         case 'RuleTextWidget' :
             echo app\components\RuleTextWidget::widget($widgetPar);
             break ;
         case 'ToolBarWidget' :
             echo app\components\ToolbarWidget::widget($widgetPar);
             break ;
         case 'TooltipsWidget' :
             echo app\components\TooltipsWidget::widget($widgetPar);
             break ;

     }
 }

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
                                onclick="addWorkGeography()"
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
                        <a class="btn btn-default" role="button" data-toggle="collapse" style="width:82%"
                           aria-expanded="true" href="#<?= $htmlPrefix ?>-edit-collapse"
                           aria-controls="<?= $htmlPrefix ?>-edit-collapse" id="workRegionEdit-name">
                            <span> Свердловская обл.</span><b class="caret"></b>
                        </a>
                        <a class="btn btn-default" role="button" title="region fully in work geography"
                           id="workRegionEdit-fully" onclick="workRegionStat('fully')">
                            <span class="glyphicon glyphicon-share"></span>
                        </a>
                        <a class="btn btn-default" role="button" title="region removed from work gegraphy"
                           id="workRegionEdit-delete" onclick="workRegionStat('delete')">
                            <span class="glyphicon glyphicon-minus"></span>
                        </a>

                        <ul class="list-group collapse.in" id="<?= $htmlPrefix ?>-edit-collapse"
                            style="overflow:auto; max-height:200px">
                            <li class="list-group-item" name="city-[city_id]">Нижний тагил
                                <a class="btn btn-default btn-sm" role="button" title="city is in work"
                                   onclick="workRegionCityStat(city_id)">
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
