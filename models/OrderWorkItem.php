<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 01.02.17
 * Time: 16:44
 */

namespace app\models;
use yii\db\ActiveRecord ;
use app\models\DeveloperWorkItem ;

class OrderWorkItem  extends DeveloperWorkItem {
    protected $parentKeyName = 'order_work_direction_id' ;
//----------------------------------------------------------//
    public static function tableName(){
        return   'order_work_item';
    }
    public function attributeLabels()
    {
//        $labelTab = PageItems::getItemText(['user','fields']) ;

        return [
            'id' => 'id',
            'order_work_direction_id' => 'order_work_direction_id',
            'work_item_id'  => 'work_item_id',
        ];
    }

    public function rules()
    {
        return [
            [['order_work_direction_id','work_item_id',],'required'],
        ];
    }

}