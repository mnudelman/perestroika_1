<?php
/**
 *   География работ - регионы
 */

namespace app\models;
use yii\db\ActiveRecord ;

class WorkRegion extends ActiveRecord {
    public $workCountryId ;
    public $fullyFlag = false ;
    //--------------------------------------------------//
    public static function tableName(){
        return   'work_region';
    }
    public function attributeLabels()
    {
//        $labelTab = PageItems::getItemText(['user','fields']) ;

        return [
            'id' => 'id',
            'region_id' => 'region_id',
            'work_country_id'  => 'work_country_id',
            'last_change'  => 'last_change',
        ];
    }

    public function rules()
    {
        return [
            [['work_country_id','region_id',],'required'],
        ];
    }

    public function getById($id = null) {
        if (is_null($id) || empty($id)) {
            return false ;
        }
        $aa = $this->findOne(['id' => $id]) ;
        return $aa ;
    }
    public function getRegion() {
        return $this->hasOne(Region::className(), ['id' => 'region_id']);
    }
    public function getName($id) {
        $res =  $this->find()->with('region')
            ->where([
                'id' => $id,
            ])
            ->asArray()->one() ;
        return $res ;
    }
    public function getList() {
        $list =  $this->find()->with('region')
            ->where([
                'work_country_id' => $this->workCountryId,
            ])
            ->asArray()->all() ;
        return $list ;
    }
    public function addWorkRegion($regionId) {
        $res = $this->findRegion($regionId) ;
        if (empty($res)) {
            $this->region_id = $regionId ;
            $this->work_country_id = $this->workCountryId ;
            $this->save() ;
            return $this ;
        }else {
            return $res ;
        }

    }
    public function deleteWorkRegion($regionId) {
        $r =$this->findRegion($regionId) ;
        if ($r) {
            $r->delete() ;
        }
    }
    public function updateWorkRegion($regionId) {
        $r =$this->findRegion($regionId) ;
        if ($r) {
            $r->fully_flag = $this->fullyFlag ;
            $r->save() ;
        }
    }

    private function findRegion($regionId) {
        $r = $this->find()
            ->where(['work_country_id' => $this->workCountryId,'region_id' => $regionId])->limit(1)->one() ;
        return $r  ;
    }
    public static function className() {
        return __CLASS__ ;
    }

}