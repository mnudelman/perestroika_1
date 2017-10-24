<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 18.12.16
 * Time: 19:54
 */

namespace app\controllers;
use yii\web\Controller;
use app\controllers\BaseController ;
use Yii ;
use app\models\DeveloperWorkDirection;
use app\models\DeveloperWorkItem ;
use app\models\WorkDirection ;
use app\models\WorkItem ;

class WorkDirectionController extends BaseController
{
//    private $userId = null;
    protected  $parentKeyId = null;
    protected  $_workDirectionId ;
    protected $models = [
        'xWorkDirection' => 'app\models\DeveloperWorkDirection',
        'xWorkItems' => 'app\models\DeveloperWorkItem'
    ] ;


    //-----------------------------------------------//
    public function actionIndex($wdId)
    {
        if (Yii::$app->request->isAjax) {
            debug($_GET);
            return 'test';
        }
    }

    /**
     * pадать извне userId
     * @param $user
     */
    public function setParentKeyId($user) {
        $this->parentKeyId = $user ;
    }

    /**
     * напрвления работ - выбираем два списка
     * фактическое и полное
     */
//    public function actionGetDeveloperWorkDirection() {
    public function actionGetFactWorkDirection() {
        $xWorkDirectionModel = $this->models['xWorkDirection'] ;
        $xWorkDirection = new $xWorkDirectionModel() ;
        $xWorkDirection->parentKeyId = $this->getParentKeyId() ;


        $dwDirectionList = $xWorkDirection->getList() ;


        $success = true ;
        $answ = [
            'success' => $success,
            'factWorkDirectionList' => $dwDirectionList ,
            'z-end' => 'end'
        ] ;
        echo json_encode($answ);

    }
    /**
     * напрвления работ - выбираем два списка
     * полное из справочника
     */
    public function actionGetWorkDirection() {
        $workDirection = new WorkDirection() ;
        $wDirectionList = $workDirection->getList() ;
        $success = true ;
        $answ = [
            'success' => $success,
            'workDirectionList' => $wDirectionList ,
            'z-end' => 'end'
        ] ;
        echo json_encode($answ);
    }

    /**
     * два списка : фактический и полный
     */
    public function actionGetWorkItems() {
        $directionId = Yii::$app->request->post('workDirectionId') ;
        $xWorkDirectionModel = $this->models['xWorkDirection'] ;

//        $dWDirect = new DeveloperWorkDirection() ;
        $dWDirect = new $xWorkDirectionModel() ;
//        $dWDirect->userId = $this->getParentKeyId() ;
        $dWDirect->parentKeyId = $this->getParentKeyId() ;

        $dWDOne = $dWDirect->addDirection($directionId) ;   //  добавить, если нет
        $message = $dWDOne->errors ;
        $success = (sizeof($message) == 0) ;
        $dWDItem = [] ;
        $dWItemList = [] ;
        $wItemList = [] ;
        if ($success) {
            $workDirectionId = $dWDOne->id ;
            $dWDItem = $dWDirect->getName($workDirectionId) ;
            //-- items --//

//        $dWItems = new DeveloperWorkItem() ;
            $xWorkItemsModel = $this->models['xWorkItems'] ;
            $dWItems = new $xWorkItemsModel() ;

//        $dWItems->developerWorkDirectionId = $workDirectionId ;
//        $dWItems->parentKeyId = $workDirectionId ;
            $dWItems->parentKeyId = $workDirectionId ;
            $dWItemList = $dWItems->getList() ;
            //--- полный саписок --------------//
            $wItems = new WorkItem() ;
            $wItems->workDirectionId = $directionId ;
            $wItemList = $wItems->getList() ;
            $success = true ;

        }
        $answ = [
            'success' => $success,
            'message' => $message,
            'workDirectionId' => $directionId,
            'developerWorkDirection' => $dWDItem,
            'developerWorkItemList' => $dWItemList ,
            'workItemList' => $wItemList ,
            'z-end' => 'end'
        ] ;
        echo json_encode($answ);

    }
    protected function getParentKeyId() {
        if (is_null($this->parentKeyId)) {
            $this->parentKeyId = Yii::$app->user->identity->id ;
        }
        return $this->parentKeyId ;
    }

    /**
     * сохранить направление работ
     * var data = {
             workDirection : setItem = {id: , name:  ,fullyFlag , deleteFlag }},
             workItems: subItems = [{id:,name: , inWorkCurrent}]
    } ;
     */
    public function actionSaveWorkDirection()
    {
        $workDirection = Yii::$app->request->post('workDirection');

        $workItems = Yii::$app->request->post('workItems');

//        $devWorkDirection = new DeveloperWorkDirection();
//        $devWorkDirection->userId = Yii::$app->user->identity->getId();
        $xWorkDirectionModel = $this->models['xWorkDirection'] ;
        $xWorkDirection = new $xWorkDirectionModel();
        $xWorkDirection->parentKeyId = $this->getParentKeyId() ;

        $message = [] ;
        $success = true ;

        $fullyFlag = $workDirection['fullyFlag'];
        $fullyFlag = (is_string($fullyFlag)) ? ($fullyFlag === 'true') : $fullyFlag;
        $deleteFlag = $workDirection['deleteFlag'];
        $deleteFlag = (is_string($deleteFlag)) ? ($deleteFlag === 'true') : $deleteFlag;
        $xWorkDirection->fullyFlag = $fullyFlag;
        $workDirectionId = $workDirection['id'];
        if ($deleteFlag) {
            $xWorkDirection->deleteDirection($workDirectionId);
        } else {
           $wdOne =  $xWorkDirection->addDirection($workDirectionId);
           $message = array_merge($message,$wdOne->errors) ;
            $success = $success && (sizeof($message) === 0 ) ;
           if ($success) {
               $this->_workDirectionId = $wdOne->id ;
               $this->workItemsUpdate($workItems) ;
           }

        }
        $answ = [
            'success' => $success,
            'message' => $message,
            'z-end' => 'end'
        ];
        echo json_encode($answ);

    }
    /**
     * @param $workCity  - объект WorkCity     -
     * @param $cityListPost - переданный список
     */

    private function workItemsUpdate($workItems) {
        foreach($workItems as $key => $item ) {
            $workItemId = $item['id'] ;
            $inWorkCurrent = $item['inWorkCurrent'] ;
            $inWorkCurrent = ($inWorkCurrent == 'true') ;
            $opCod = ($inWorkCurrent) ? 'add' : 'del' ;
            $this->workItemAction($opCod,$workItemId) ;

        }
    }
    private function workItemAction($opCod,$workItemId) {
//        $dWorkItem = new DeveloperWorkItem() ;
          $xWorkItemModel = $this->models['xWorkItems'] ;
        $dWorkItem = new $xWorkItemModel() ;


//        $dWorkItem->developerWorkDirectionId = $this->_workDirectionId ;
        $dWorkItem->parentKeyId = $this->_workDirectionId ;
        if ($opCod === 'add') {
            $dWorkItem->addWorkItem($workItemId) ;
        }else {
            $dWorkItem->deleteWorkItem($workItemId) ;
        }

    }
}