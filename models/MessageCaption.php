<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 08.08.17
 * Time: 21:13
 */

namespace app\models;
use yii\db\ActiveRecord ;
use Yii ;
use app\service\PageItems ;
use yii\db\Query ;


class MessageCaption extends ActiveRecord {
    public static function tableName()
    {
        return 'massage_caption';
    }

    /**
     *id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
     *user_id_from INTEGER REFERENCES user(id)
     * ON DELETE CASCADE,
     *user_id_to INTEGER REFERENCES user(id)
     *ON DELETE CASCADE,
     *subject VARCHAR (255),         --  тема сообщения
     *message_time TIMESTAMP DEFAULT NOW()
    )
     */
    public function attributeLabels()
    {
//        $labelTab = PageItems::getItemText(['user','fields']) ;
//        $pageItemFile = 'order/additional';
//        $fields = PageItems::getItemText([$pageItemFile, 'fields']);
        return [
            'id' => 'id',
            'user_id_from' => 'user_id_from',
            'user_id_to' => 'user_id_to',
            'subject' => 'subject',
        ];
    }

    public function rules()
    {
        return [
            [['user_id_from', 'user_id_to', 'subject'], 'required'],
        ];
    }
    public function addItem($userIdFrom,$userIdTo,$subject) {

        $obj = $this->findOrderMailing($orderId,$developerId);
        if (empty($obj)) {
            return $obj ;
        }
        $obj->developer_id = $developerId ;
        $obj->order_id = $orderId ;
        $obj->stat = $orderStat ;
        if ($obj->validate()) {
            $obj->save();
        }
        return $obj;

    }
    public function getById($orderId,$developerId) {
        $r = $this->findOrderMailing($orderId,$developerId) ;
        return $r ;
    }
    private function findOrderMailing($orderId,$developerId) {
        $r = $this->find()
            ->where(['order_id' => $orderId,'developer_id' => $developerId])->limit(1)->one() ;
        return $r  ;
    }
    public function getList()
    {
        $orderId = $this->getCurrentOrder();
        $list = $this->find()
            ->where([
                'order_id' => $orderId,
            ])
            ->asArray()->all();
        return $list;
    }
    public function typeCount()
    {
        $orderId = $this->getCurrentOrder();
        $query = (new Query())
            ->select(['stat', 'count(*) as count'])
            ->from('order_mailing')
            ->where(['order_id' => $orderId])
            ->groupBy(['stat'])
            ->orderBy(['stat'=>SORT_ASC]);
        $rows = $query->all();
        return $rows;
    }
    /** связь с т аблицей  order_work
     * @return \yii\db\ActiveQuery
     */
    public function getOrderWork() {
        return $this->hasOne(OrderWork::className(), ['id' => 'order_id']);
    }
    public function getName($id)
    {
        $res = $this->find()->with('orderWork')
            ->where([
                'id' => $id,
            ])
            ->asArray()->one();
        return $res;
    }
//--------------- методы для контроллера DeveloperOrdersController
    public function setFilter($filter) {
        $this->_filter = $filter ;
        return $this ;
    }



    public function getCount() {
        return 10 ;
    }

    public function getListByUser($limit = -1,$offset = -1) {

        $command = $this->queryBuild($limit,$offset) ;
        $list = $command->queryAll() ;
//        ->limit($limit)->offset($offset)->queryAll() ;


        return $this->orderListTransform($list) ;
    }
    private function queryBuild($limit = -1,$offset = -1) {
        $filter = $this->_filter ;
        $perBeg = $filter['perBeg'] ;
        $perEnd = $filter['perEnd'] ;
        $statList = $filter['statList'] ;
        $responseStatList = $filter['responseStatList'] ;
        $responseFlag = $filter['responseStat'] ;
        $userId = Yii::$app->user->identity->getId() ;
        $listTotal = ($responseFlag) ? $responseStatList : $statList ;

        $sql =
            'SELECT order_mailing.id AS mailing_id,
                    order_mailing.order_id AS mailing_order_id,
                    order_mailing.developer_id AS mailing_developer_id,
                    order_mailing.time_send AS mailing_developer_time_send,
                    order_mailing.time_answer AS mailing_developer_time_answer,
                    order_mailing.stat AS mailing_stat,
             order_work.*
             FROM order_mailing,order_work
             WHERE order_mailing.developer_id = :developerId
              AND order_mailing.stat IN (' .$listTotal .')
              AND order_work.id = order_mailing.order_id
              AND order_work.time_create BETWEEN :perBeg AND :perEnd
              ORDER BY order_mailing.stat
              LIMIT :limit
              OFFSET :offset
        ';
        $command = Yii::$app->db->createCommand($sql)
            ->bindValue(':developerId',$userId)
            ->bindValue(':perBeg',$perBeg)
            ->bindValue(':perEnd',$perEnd)
            ->bindValue(':limit',$limit)
            ->bindValue(':offset',$offset);
        return $command ;
    }

}