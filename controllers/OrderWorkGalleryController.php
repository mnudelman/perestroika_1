<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 06.04.17
 * Time: 21:11
 */

namespace app\controllers;
use app\controllers\WorkGalleryController ;
use app\service\TaskStore ;
use app\models\OrderWork ;

class OrderWorkGalleryController extends WorkGalleryController {
    protected $parentKeyName = 'order_id' ;
    protected $models = [
        'xWorkGallery' => 'app\models\OrderWorkGallery',
    ] ;
    protected function getParentKeyId() {
        if (is_null($this->parentKeyId)) {
            $order = TaskStore::getParam('currentOrder');
            if (is_array($order) && isset($order['orderId'])) {
                $this->parentKeyId =  $order['orderId'] ;
            }
        }
        return $this->parentKeyId ;
    }
    protected function getUserId() {
        $orderId = $this->parentKeyId ;
        $order = (new OrderWork())->getById($orderId) ;
        $this->_userId  = $order->userid ;
        return $this->_userId ;
    }
}