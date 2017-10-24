<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 10.01.17
 * Time: 15:06
 */

namespace app\models;
use yii\db\ActiveRecord ;

class City extends ActiveRecord {
    const NAME_DEFAULT = 'Екатеринбург' ;
    public $countryId ;
    public $regionId ;
    private $_currentId ;
//------------------------------------------//
    public static function tableName(){
        return   'city';
    }
    public function attributeLabels()
    {
//        $labelTab = PageItems::getItemText(['user','fields']) ;

        return [
            'id' => 'id',
            'country_id'  => 'country_id',
            'region_id'  => 'region_id',
            'name' => 'name'
        ];
    }

    public function rules()
    {
        return [
            [['id','country_id','region_id','name',],'required'],
        ];
    }

    public function getById($id = null) {
        if (is_null($id) || empty($id)) {
            $id = $this->getByName(self::NAME_DEFAULT) -> id ;
        }
        $aa = $this->findOne(['id' => $id]) ;
        $this->_currentId = $id ;
        return $aa ;
    }
    public function getList() {
        $list =  $this->find()
            ->where([
 //               'country_id' => $this->countryId,      // не надо
                'region_id' => $this->regionId])
            ->orderBy('name')->asArray()->all() ;
        return $list ;
    }
    public function getByName($name) {
        $aa = $this->findOne([
//            'country_id' => $this->countryId,        // можно обойтись
            'region_id' => $this->regionId,
            'name' => $name]) ;
        $this->_currentId = $this->id ;
        return $aa ;
    }
    public function getWorkCity() {
        return $this->hasMany(WorkCity::className(), ['city_id' => 'id']);
    }


    public static function className() {
        return __CLASS__ ;
    }
}