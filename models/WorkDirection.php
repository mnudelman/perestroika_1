<?php
/*
 * справочник
 */

namespace app\models;
use yii\db\ActiveRecord ;

class WorkDirection extends ActiveRecord {
    private $_currentId ;
    public static function tableName(){
        return   'work_direction';
    }
    public function attributeLabels()
    {
//        $labelTab = PageItems::getItemText(['user','fields']) ;

        return [
            'id' => 'id',
            'name_en' => 'name_en',
            'name_ru' => 'name_ru',
        ];
    }

    public function rules()
    {
        return [
            [['id','name_en','name_ru'],'required'],
        ];
    }
    public function getById($id = null) {
        if (is_null($id) || empty($id)) {
            return false;
        }
        $aa = $this->findOne(['id' => $id]) ;
        $this->_currentId = $id ;
        return $aa ;
    }
    public function getList() {
        $list =  $this->find()->orderBy('name')->asArray()->all() ;
        return $list ;
    }
    public function getByName($name) {
        $aa = $this->findOne(['name' => $name]) ;
        $this->_currentId = $this->id ;
        return $aa ;
    }
    public function getDeveloperWorkDirection() {
        return $this->hasMany(DeveloperWorkDirection::className(),
            ['work_direction_id' => 'id']);
    }
    public function getOrderWorkDirection() {
        return $this->hasMany(OrderWorkDirection::className(),
            ['work_direction_id' => 'id']);
    }
    public static function className() {
        return __CLASS__ ;
    }

}