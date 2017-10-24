<?php
/**
 *контроллер направлений работ для ИСПОЛНИТЕЛЯ ЗАКАЗА
 * Time: 19:54
 */

namespace app\controllers;
use app\models\UserProfile;
use yii\web\Controller;
//use app\controllers\BaseController ;
use app\controllers\WorkDirectionController ;
use Yii ;
//use app\models\OrderWorkDirection;
//use app\models\OrderWorkItem ;
//use app\models\WorkDirection ;
//use app\models\WorkItem ;
//use app\models\OrderWork ;
use app\service\TaskStore ;

class DeveloperWorkDirectionController extends WorkDirectionController
{
//    private $parentKeyId = null;
//    private $_workDirectionId ;
//    protected $models = [
//        'xWorkDirection' => 'app\models\OrderWorkDirection',
//        'xWorkItems' => 'app\models\OrderWorkItem'
//    ] ;
    //-----------------------------------------------//
    protected function getParentKeyId() {
        if (is_null($this->parentKeyId)) {
            $developer = TaskStore::getParam('currentDeveloper');
            if (is_array($developer) && isset($developer['id'])) {
                $this->parentKeyId =  $developer['id'] ;
            }
        }
        return $this->parentKeyId ;
    }

}