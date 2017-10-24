<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 01.02.17
 * Time: 16:44
 */

namespace app\models;
use yii\db\ActiveRecord ;

class DeveloperWorkItem  extends ActiveRecord {
    public $developerWorkDirectionId ;
    protected $parentKeyName = 'developer_work_direction_id' ;
    public $parentKeyId ;
    public static function tableName(){
        return   'developer_work_item';
    }
    public function attributeLabels()
    {
//        $labelTab = PageItems::getItemText(['user','fields']) ;

        return [
            'id' => 'id',
//            'developer_work_direction_id' => 'developer_work_direction_id',
            $this->parentKeyName  => $this->parentKeyName ,
            'work_item_id'  => 'work_item_id',
        ];
    }

    public function rules()
    {
        return [
//            [['developer_work_direction_id','work_item_id',],'required'],
            [['work_item_id',],'required'],
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
    public function getWorkItem() {
        return $this->hasOne(WorkItem::className(), ['id' => 'work_item_id']);
    }
    public function getName($id)
    {
        $res = $this->find()->with('workItem')
            ->where([
                'id' => $id,
            ])
            ->asArray()->one();
        return $res;
    }

    public function getList() {
        $list =  $this->find()->with('workItem')
            ->where([
//                'developer_work_direction_id' => $this->developerWorkDirectionId
                   $this->parentKeyName => $this->parentKeyId
            ])
            ->asArray()->all() ;
        return $list ;
    }
    public function addWorkItem($workItemId) {
        $res = $this->findWorkItem($workItemId) ;
        if (empty($res)) {
            $this->work_item_id = $workItemId ;
//            $this->developer_work_direction_id = $this->developerWorkDirectionId
            $keyField = $this->parentKeyName ;
             $this->$keyField = $this->parentKeyId;
            $this->save() ;
            return $this ;
        }else {
            return $res ;
        }

    }
    private function findWorkItem($workItemId) {
        $r = $this->find()
            ->where([
//                'developer_work_direction_id' => $this->developerWorkDirectionId,
                $this->parentKeyName => $this->parentKeyId,
                'work_item_id' => $workItemId])->limit(1)->one() ;
        return $r  ;
    }
    public function deleteWorkItem($workItemId) {
        $r =$this->findWorkItem($workItemId) ;
        if ($r) {
            $r->delete() ;
        }
    }

    public static function className() {
        return __CLASS__ ;
    }

}