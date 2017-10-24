<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 13.06.17
 * Time: 20:54
 */
use yii\bootstrap\ButtonDropdown;
use yii\bootstrap\Dropdown;
use app\components\CollapsibleListWidget;
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\WorkDirection;
use \app\models\DeveloperWorkDirection ;
use \app\models\DeveloperWorkItem ;
use \app\models\OrderWorkDirection ;
use \app\models\OrderWorkItem ;
use app\service\TaskStore ;
/**
 * список всех направлений( по справочнику)
 */
function workDirectionList($htmlPrefix,$type) {
    $workDirection = new WorkDirection();
    $wDirectionList = $workDirection->getList();
    $workDirectionShow = [];
    $liList = [];


// это для выбора из справочника
    $onClickFunction = 'newSetItemToggle';
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
    return $liList ;
}

/**
 * факт список направлений по исполнителю
 */
function developerWorkDirectionList() {
    $devWorkDirection = new DeveloperWorkDirection();
    $userId = Yii::$app->user->identity->getId() ;
//$devWorkDirection->userId = $userId ;
    $devWorkDirection->parentKeyId = $userId ;
    $dWDList = $devWorkDirection->getList() ;
    $devWorkItem = new DeveloperWorkItem() ;
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
    return $listItems ;
}
function orderWorkDirectionList_1() {
    $orderWorkDirection = new OrderWorkDirection();
    $orderId = null ;
    $order = TaskStore::getParam('currentOrder');
    if (is_array($order) && isset($order['orderId'])) {
        $orderId =  $order['orderId'] ;
    }
    $orderWorkDirection->parentKeyId = $orderId ;
    $oWDList = $orderWorkDirection->getList() ;
    $orderWorkItem = new OrderWorkItem() ;
    $listItems = [] ;
    foreach ($oWDList as $key => $oWDItem) {
        $item = [
            'id' => $oWDItem['work_direction_id'],
            'name'=> $oWDItem['workDirection']['name_ru'],
            'fullyFlag' => $oWDItem['fully_flag'] - 0 ,
            'editFlag' => true,
        ] ;
        $orderWorkItem->parentKeyId = $oWDItem['id'] ;
        $devWList = $orderWorkItem->getList() ;
        $subItems = [] ;
        foreach ($devWList as $subKey => $workItem) {
            $subItems[] = $workItem['workItem']['name_ru'] ;
        }
        $item['subItems'] = $subItems ;
        $listItems[] = $item ;
    }
    return $listItems ;
}
