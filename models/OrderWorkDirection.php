<?php
/**
 * Направления работ для заказа
 * повторяет DeveloperWorkDirection
 * Time: 16:43
 */

namespace app\models;
use yii\db\ActiveRecord ;
use app\models\DeveloperWorkDirection ;

class OrderWorkDirection extends DeveloperWorkDirection {
    public $orderId ;
    public $fullyFlag = null ;
    protected $parentKeyName = 'order_id' ;
    //----------------------------------------------------//

    public static function tableName(){
        return   'order_work_direction';
    }
    public function rules()
    {
        return [
            [['order_id','work_direction_id','fully_flag'],'required'],
            [['order_id'],'validateNotEmptyKeyId'],
        ];
    }

}