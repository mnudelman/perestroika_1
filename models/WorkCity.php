<?php
/**
 * География работ -города
 * Time: 20:54
 */

namespace app\models;
use yii\db\ActiveRecord ;

class WorkCity extends ActiveRecord {
    public $workRegionId = 1 ;
    public static function tableName(){
        return   'work_city';
    }
    public function attributeLabels()
    {
//        $labelTab = PageItems::getItemText(['user','fields']) ;

        return [
            'id' => 'id',
            'city_id'  => 'city_id',
            'work_region_id' => 'work_region_id',
            'last_change'  => 'last_change',
        ];
    }

    public function rules()
    {
        return [
            [['city_id','work_region_id',],'required'],
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
    public function getCity() {
        return $this->hasOne(City::className(), ['id' => 'city_id']);
    }
    public function getName($id)
    {
        $res = $this->find()->with('city')
            ->where([
                'id' => $id,
            ])
            ->asArray()->one();
        return $res;
    }

   public function getList() {
        $list =  $this->find()->with('city')
            ->where([
                'work_region_id' => $this->workRegionId])
            ->asArray()->all() ;
        return $list ;
    }
    public function addWorkCity($cityId) {
        $res = $this->findCity($cityId) ;
        if (empty($res)) {
            $this->city_id = $cityId ;
            $this->work_region_id = $this->workRegionId ;
            $this->save() ;
            return $this ;
        }else {
            return $res ;
        }

    }
    private function findCity($cityId) {
        $r = $this->find()
            ->where(['work_region_id' => $this->workRegionId,'city_id' => $cityId])->limit(1)->one() ;
        return $r  ;
    }
    public function deleteWorkCity($cityId) {
        $r =$this->findCity($cityId) ;
        if ($r) {
            $r->delete() ;
        }
    }

    public static function className() {
        return __CLASS__ ;
    }
}