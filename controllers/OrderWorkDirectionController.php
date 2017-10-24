<?php
/**
 *контроллер направлений работ для ЗАКАЗА
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

class OrderWorkDirectionController extends WorkDirectionController
{
//    private $parentKeyId = null;
//    private $_workDirectionId ;
    protected $models = [
        'xWorkDirection' => 'app\models\OrderWorkDirection',
        'xWorkItems' => 'app\models\OrderWorkItem'
    ] ;
    //-----------------------------------------------//
    protected function getParentKeyId() {
        if (is_null($this->parentKeyId)) {
            $order = TaskStore::getParam('currentOrder');
            if (is_array($order) && isset($order['orderId'])) {
                $this->parentKeyId =  $order['orderId'] ;
            }
        }
        return $this->parentKeyId ;
    }

}