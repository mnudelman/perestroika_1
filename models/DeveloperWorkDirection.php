<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 01.02.17
 * Time: 16:43
 */

namespace app\models;
use yii\db\ActiveRecord ;

class DeveloperWorkDirection extends ActiveRecord {
    public $userId ;
    protected $parentKeyName = 'userid' ;
    public $parentKeyId ;
    public $fullyFlag = null ;
    //----------------------------------------------------//

    public static function tableName(){
        return   'developer_work_direction';
    }
    public function attributeLabels()
    {
        return [
            'parentKeyId' => 'parentKeyId',
            'work_direction_id'=>'work_direction_id',
            'fully_flag' => 'fully_flag'
        ];
    }


    public function rules()
    {
//        return [
//            [['userid','work_direction_id','fully_flag'],'required'],
//        ];
        return [
            [['fully_flag','parentKeyId'],'required'],
            [['userId'],'validateNotEmptyKeyId'],
        ];

    }
    public function validateNotEmptyKeyId($attribute, $params)
    {
        $message = 'Не задан объект для сохранения' ;
        if (empty($this->parentKeyId)) {
            $this->addError($attribute, $message);
        }
    }
    /** связь с т аблицей  city
     * @return \yii\db\ActiveQuery
     */
    public function getWorkDirection() {
        return $this->hasOne(WorkDirection::className(), ['id' => 'work_direction_id']);
    }
    public function getById($id = null) {
        if (is_null($id) || empty($id)) {
            return false ;
        }
        $aa = $this->findOne(['id' => $id]) ;
        return $aa ;
    }

    public function getName($id)
    {
        $res = $this->find()->with('workDirection')
            ->where([
                'id' => $id,
            ])
            ->asArray()->one();
        return $res;
    }
    public function getList() {
        if (empty($this->parentKeyId)) {
            return [] ;
        }
        $list =  $this->find()->with('workDirection')
            ->where([
//                'userid' => $this->userId])
             $this->parentKeyName => $this->parentKeyId])
            ->asArray()->all() ;
        return $list ;
    }
    public function addDirection($directionId) {
        $res = $this->findDirection($directionId) ;
        if (empty($res) ) {
            $this->work_direction_id = $directionId ;
//            $this->userid = $this->userId ;
            $keyField = $this->parentKeyName ;
             $this->$keyField = $this->parentKeyId ;
            $this->fully_flag = (is_null($this->fullyFlag)) ? false : $this->fullyFlag  ;
            $v =  $this->validate() ;
            $this->save() ;
            return $this ;
        }else {
            if(!is_null($this->fullyFlag) && ($res->fully_flag != $this->fullyFlag)) {
                $res->parentKeyId = $this->parentKeyId ;
                $res->fully_flag = $this->fullyFlag ;
                $res->save() ;
            }
            return $res ;
        }

    }
    public function deleteDirection($directionId) {
        $res = $this->findDirection($directionId) ;
        if ($res) {
            $res->delete() ;
        }
    }
    private function findDirection($directionId) {
        if (empty($this->parentKeyId)) {
            return null ;
        }
        $r = $this->find()
            ->where([
//                'userid' => $this->userId,
                $this->parentKeyName => $this->parentKeyId,
                'work_direction_id' => $directionId])->limit(1)->one() ;
        return  $r ;
    }

    public static function className() {
        return __CLASS__ ;
    }

}