<?php

function debug($arr){
    echo '<pre>' . print_r($arr, true) . '</pre>';
}
//============== treeLevelFunction ============================== //
function variableWidget($widgetList) {
    if (is_array($widgetList)) {
        foreach ($widgetList as $itemName => $item) {
            if (!isset($item['name']) || !isset($item['par'])) {
                continue ;
            }
            $type = (isset($item['type'])) ? $item['type'] : 'widget' ;
            $name = $item['name'] ;
            $par =  $item['par'] ;
            if ($itemName === 'html') {
                htmlWidgetCase($name,$par) ;
            }elseif ($type === 'widget') {
                widgetCase($name,$par) ;
            }

        }

    }
}
function htmlWidgetCase($htmlName,$par) {
    switch ($htmlName) {
        case 'br' :
            for ($i = 0; $i < $par; $i++){
                echo '<br>' ;
            }
            break ;
    }
}
function widgetCase($widgetName, $widgetPar) {
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
//================================================================//