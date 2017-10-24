<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 10.01.17
 * Time: 15:02
 */

namespace app\models;
use yii\db\ActiveRecord;

class Country extends ActiveRecord {
    const NAME_DEFAULT = 'Россия' ;
    private $_currentId ;
    public static function tableName(){
        return   'country';
    }
    public function attributeLabels()
    {
//        $labelTab = PageItems::getItemText(['user','fields']) ;

        return [
            'id' => 'id',
            'name' => 'name'
        ];
    }

    public function rules()
    {
        return [
            [['id','name',],'required'],
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
        $list =  $this->find()->orderBy('name')->asArray()->all() ;
        return $list ;
    }
    public function getByName($name) {
        $aa = $this->findOne(['name' => $name]) ;
        $this->_currentId = $this->id ;
        return $aa ;
    }
    public function getWorkCountry() {
        return $this->hasMany(WorkCountry::className(), ['country_id' => 'id']);
    }
    public static function className() {
    return __CLASS__ ;
}


}