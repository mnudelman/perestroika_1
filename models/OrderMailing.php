<?php
/**
 * Рассылка заказов
 * Time: 17:10
 */
namespace app\models ;
use yii\db\ActiveRecord ;
use app\service\PageItems ;
use app\service\TaskStore ;
use app\models\OrderWork ;
use app\models\OrderStatFunc ;
use Yii ;
use yii\db\Query ;
class OrderMailing extends ActiveRecord
{
    public $currentOrderId = null;
    public $developerId ;
    public $orderStat ;
    public $timeAnswer ;
//    const STAT_NO_SENT = 0 ;    // не отправлено предложение
//    const STAT_SENT_READY = 5 ; // Готов к отправке (заказчик)
//    const STAT_SENT = 10 ;       // отправлено предложение (заказчик)
//    const STAT_ANSWERED_READY = 15 ;  // подтверждение сделано, но не отправлено(исполнитель)
//    const STAT_ANSWERED = 20 ;   // получено подтверждение (исполнитель)
//    const STAT_SELECTED_READY = 25 ;   // выбран исполнитель (заказчик)
//    const STAT_SELECTED = 30 ;   // выбран исполнитель - отправлено предложение
//    const STAT_SELECTED_ANSWERED_READY = 35 ;
//    const STAT_SELECTED_ANSWERED = 40 ; // подтверждение от исполнителя
//    const MIN_TOTAL_RANK = 50 ; // min суммарная оценка(%) для добавления в order_mailing
//    const MIN_GEOGRAPHY_RANK = 50 ; // min оценка(%) географии для добавления в order_mailing
    const TIME_EMPTY = '2017-01-01' ; // пустое значение для time_deadline
    private $statParams = [] ;
    private $_filter = [] ;
    //------------------------------------------//
    public static function tableName()
    {
        return 'order_mailing';
    }

    public function attributeLabels()
    {
//        $labelTab = PageItems::getItemText(['user','fields']) ;
//        $pageItemFile = 'order/additional';
//        $fields = PageItems::getItemText([$pageItemFile, 'fields']);
        return [
            'id' => 'id',
            'order_id' => 'order_id',
            'developer_id' => 'developer_id',
            'stat' => 'stat',
            'time_send' => 'time_send',
            'time_answer' => 'time_answer',
            'time_deadline' => 'time_deadline',
        ];
    }

    public function rules()
    {
        return [
            [['order_id', 'developer_id', 'stat'], 'required'],
            [['time_send','time_answer','time_deadline'],'default'],
        ];
    }

    private function getCurrentOrder()
    {
        $orderId = $this->currentOrderId;
        if (empty($orderId)) {
            $order = TaskStore::getParam('currentOrder') ;
            if (!empty($order)) {
                $orderId =   $order['orderId'] ;
            }
        }
        return $orderId ;
    }

    /**
     * добавить состояние заказа
     */
    public function addOrderMailing($orderId,$developerId,$orderStat,$deadlineTime = -1)
    {
        $obj = $this->findOrderMailing($orderId,$developerId);
        if (empty($obj)) {
            return $obj ;
        }
        $currentTime = date('Y-m-dTH',time()) ;
        $orderStatF = new OrderStatFunc() ;
        if ($orderStatF->isAnswerStat($orderStat)) {
            $obj->time_answer = $currentTime ;
        }
        if ($orderStatF->isSendStat($orderStat)) {
            $obj->time_send = $currentTime ;
        }
        if ($orderStatF->isDeadlineStat($orderStat)) {
            if (is_string($deadlineTime)) {
                $obj->time_deadline = $deadlineTime ;
            }

        }

        $obj->developer_id = $developerId ;
        $obj->order_id = $orderId ;
        $obj->stat = $orderStat ;
        if ($obj->validate()) {
            $obj->save();
        }
        return $obj;

    }

    /**
     * текущее состояние заказа
     */
    public function getOrderStat($orderId,$developerId) {
            $r = $this->getById($orderId,$developerId) ;
            if (empty($r)) {
                return false ;
            }
            return $r->stat ;
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
    /**
     * перестановка внутри списка. атрибуты mailing "прячутся" в элемент
     * 'mailing' , а то что было в 'orderWork' поднимается на 0 уровень
     * @param $list
     */
    private function orderListTransform($list) {
       $resList = [] ;
       foreach ($list as $i => $item ) {
           $newItem = [] ;
           $mailing = [] ;
           foreach ($item as $key => $value) {
               if (strpos($key,'mailing_') === 0) {
                   $newKey =  str_replace('mailing_', '', $key) ;
                   $mailing[$newKey] = $value ;
               }else {
                   $newItem[$key] = $value ;
               }
            }
           $newItem['mailing'] = $mailing ;
           $resList[] = $newItem ;
        }
        return $resList ;
    }
}