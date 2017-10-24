<?php
/**
 *География работ - страны
 * Time: 20:51
 */

namespace app\models;
use yii\db\ActiveRecord ;
use Yii ;
class WorkCountry extends ActiveRecord {
    public $userId ;
    //----------------------------------------------------//

    public static function tableName(){
        return   'work_country';
    }
    public function attributeLabels()
    {
//        $labelTab = PageItems::getItemText(['user','fields']) ;

        return [
            'id' => 'id',
            'country_id'  => 'country_id',
            'userid' => 'userid',
            'last_change'  => 'last_change',
        ];
    }

    public function rules()
    {
        return [
            [['country_id','userid',],'required'],
        ];
    }
    public function setUserId($uId) {
        $this->userId = $uId ;
        return $this ;
    }
    public function getById($id = null) {
        if (is_null($id) || empty($id)) {
            return false ;
        }
        $aa = $this->findOne(['id' => $id]) ;
        return $aa ;
    }
    public function getCountry() {
        return $this->hasOne(Country::className(), ['id' => 'country_id']);
    }
    public function getName($id)
    {
        $res = $this->find()->with('country')
            ->where([
                'id' => $id,
            ])
            ->asArray()->one();
        return $res;
    }
        public function getList() {
        $list =  $this->find()->with('country')
            ->where([
                'userid' => $this->userId])
            ->asArray()->all() ;
        return $list ;
    }
    public function addCountry($countryId) {
        $res = $this->findCountry($countryId) ;
        if (empty($res)) {
            $this->country_id = $countryId ;
            $this->userid = $this->userId ;
            $this->save() ;
            return $this ;
        }else {
            return $res ;    
        }

    }
    private function findCountry($countyId) {
        $r = $this->find()
            ->where(['userid' => $this->userId,'country_id' => $countyId])->limit(1)->one() ;
        return  $r ;
    }

    public static function className() {
        return __CLASS__ ;
    }


}