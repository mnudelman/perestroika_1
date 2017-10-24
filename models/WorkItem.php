<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 01.02.17
 * Time: 16:43
 */

namespace app\models;
use yii\db\ActiveRecord ;

class WorkItem  extends ActiveRecord {
    public $workDirectionId = 1 ;
    public static function tableName(){
        return   'work_item';
    }
    public function attributeLabels()
    {
//        $labelTab = PageItems::getItemText(['user','fields']) ;

        return [
            'id' => 'id',
            'work_direction_id'  => 'work_direction_id',
            'name_en'  => 'name_en',
            'name_ru'  => 'name_ru',
        ];
    }

    public function rules()
    {
        return [
            [['work_direction_id','name_en','name_ru',],'required'],
        ];
    }

    public function getById($id = null) {
        if (is_null($id) || empty($id)) {
            return false ;
        }
        $aa = $this->findOne(['id' => $id]) ;
        return $aa ;
    }

    /** связь с т аблицей  city
     * @return \yii\db\ActiveQuery
     */
    public function getDeveloperWorkItem() {
        return $this->hasMany(developerWorkItem::className(), ['work_item_id' => 'id']);
    }
    public function getOrderWorkItem() {
        return $this->hasMany(OrderWorkItem::className(), ['work_item_id' => 'id']);
    }

    public function getList() {
        $list =  $this->find()
            ->where([
                'work_direction_id' => $this->workDirectionId])
            ->asArray()->all() ;
        return $list ;
    }
    public static function className() {
        return __CLASS__ ;
    }

}