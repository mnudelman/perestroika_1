<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 10.01.17
 * Time: 15:04
 */

namespace app\models;
use yii\db\ActiveRecord ;

class Region extends ActiveRecord {
    const NAME_DEFAULT = 'Свердловская обл.' ;
    public $countryId ;
    private $_currentId ;
    public static function tableName(){
        return   'region';
    }

    public function attributeLabels()
    {
//        $labelTab = PageItems::getItemText(['user','fields']) ;

        return [
            'id' => 'id',
            'country_id'  => 'country_id',
            'name' => 'name'
        ];
    }

    public function rules()
    {
        return [
            [['id','country_id','name',],'required'],
        ];
    }

    public function getById($id = null) {
        if (is_null($id) || empty($Id)) {
            $id = $this->getByName(self::NAME_DEFAULT) -> id ;
        }
        $aa = $this->findOne(['id' => $id]) ;
        $this->_currentId = $id ;
        return $aa ;
    }
    public function getWorkRegion() {
        return $this->hasMany(WorkRegion::className(),['region_id' => 'id']) ;
    }
    public function getList() {
        $list =  $this->find()->where(['country_id' => $this->countryId])->orderBy('name')->asArray()->all() ;
        return $list ;
    }
    public function getByName($name) {
        $aa = $this->findOne([
            'country_id' => $this->countryId,
            'name' => $name]) ;
        $this->_currentId = $this->id ;
        return $aa ;
    }

}