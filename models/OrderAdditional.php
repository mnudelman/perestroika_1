<?php
/**
 * Дополнительные материалы к заказу
 * Time: 16:52
 */

namespace app\models;
use yii\db\ActiveRecord ;
use app\service\PageItems ;
use app\service\TaskStore ;
use Yii ;
class OrderAdditional extends ActiveRecord {
    public $currentOrderId = null ;
    //------------------------------------------//
    public static function tableName(){
        return   'order_additional';
    }
    public function attributeLabels()
    {
//        $labelTab = PageItems::getItemText(['user','fields']) ;
        $pageItemFile = 'order/additional' ;
        $fields = PageItems::getItemText([$pageItemFile, 'fields']);
        return [
            'id' => 'id',
            'order_id'  => 'order_id',
            'file_name'  => 'file_name',
            'file_title' => 'file_title',
        ];
    }

    public function rules()
    {
        return [
            [['order_id','file_name','file_title'],'required'],
            ] ;
    }
    private function getCurrentOrder() {
        $orderId = $this->currentOrderId ;
        if(empty($orderId)) {
            $order = TaskStore::getParam('currentOrder') ;
            if (!empty($order)) {
                $orderId =   $order['orderId'] ;
            }
        }
        return $orderId ;
    }
    public function getList() {
        $orderId = $this->getCurrentOrder() ;
        $list =  $this->find()
            ->where([
                'order_id' => $orderId,
            ])
            ->asArray()->all() ;
        return $list ;
    }

}