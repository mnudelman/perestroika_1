<?php
/**
 * Заказ
 * Time: 10:10
 */

namespace app\models;
use yii\db\ActiveRecord ;
use Yii ;
use app\models\UserProfile ;
use app\service\PageItems ;
use yii\db\Query ;
use app\models\OrderMailing ;
//---------------------------------------//
class OrderWork extends ActiveRecord{
    public $userId = null;
    public $confirmationFlag = false ;
    private $_successFlag  = false ;
    private $_filter = [] ;
    private $_lockFlag = false ;

    public static function tableName(){
        return   'order_work';
    }
    public function attributeLabels()
    {
//        $labelTab = PageItems::getItemText(['user','fields']) ;
        $pageItemFile = 'order/general' ;
        $fields = PageItems::getItemText([$pageItemFile, 'fields']);
        return [
            'id' => 'id',
            'userid'  => 'userid',
            'order_name'  => $fields['orderName'],
            'description' => $fields['description'],
            'city_id' => $fields['city'],
            'orderNum' => 'orderNum',
            'per_beg' => $fields['perBeg'],
            'per_end' => $fields['perEnd'],
            'time_create' => 'time_create'
        ];
    }

    public function rules()
    {
        return [
            [['order_name','description','city_id'],'required'],
            [['userId','confirmationFlag'],'validateConfirmation'],
            [['per_beg','per_end'],'required'],
            [['per_beg','per_end'],'validatePeriod'],
            [['time_create'],'default'],
//            [['per_beg','per_end'],'date'],
//            ['per_beg','timestampAttribute'=>'perBegTimestamp'],
//            [['per_end','timestampAttribute'=>'perEndTimestamp']],
//            [['perEndTimestamp','compare','compareAttribute'=>'perBegTimestamp',
//                'operator'=>'>=','type'=>'number']],
//            [['per_beg', 'per_end'], 'default', 'value' => function ($model, $attribute) {
//                return date('Y-m-d', time());
//            }]
        ];
    }
    public function validatePeriod($attribute, $params) {
        $message = 'недопустимый период исполнения' ;
        $dateBeg = strtotime($this->per_beg) ;
        $dateEnd = strtotime($this->per_end) ;
        if ($dateBeg === -1 || $dateEnd === -1 || $dateBeg > $dateEnd) {
            $this->addError($attribute, $message);
        }
    }
    public function validateConfirmation($attribute, $params)
    {
        $messages = PageItems::getItemText(['user', 'forms', 'orderForm', 'messages']);
        $userId = $this->getUser();
        if (empty($userId)) {
            $this->addError($attribute, $messages['username']);
        } elseif (empty($this->getConfirmationFlag())) {
            $this->addError($attribute, $messages['username']);
        }
    }
    public function setFilter($filter) {
        $this->_filter = $filter ;
        return $this ;
    }
    public function getSuccessFlag() {
        return $this->_successFlag ;

    }
    public function getById($id = null) {
        if (is_null($id) || empty($id)) {
            $this->_successFlag = false ;
            return false ;
        }
        $aa = $this->findOne(['id' => $id]) ;
        if (!empty($aa)) {
            $this->_successFlag = true ;
        }
        return $aa ;
    }
    public function getList($limit=-1,$offset=-1) {
//        $filter = $this->_filter ;
//        $perBeg = $filter['perBeg'] ;
//        $perEnd = $filter['perEnd'] ;
//
//        $userId = $this->getUser() ;
//        $query = (new Query())
//            ->select('*')
//            ->from('order_work')
//            ->where(['userid' => $userId])
//            ->andWhere(
//                ['between','time_create',$perBeg,$perEnd]) ;
        $query = $this->queryBuild() ;
        $rows = $query->limit($limit)->offset($offset)->all();
        return $rows ;
    }
    public function getSqlList($limit=-1,$offset=-1) {
        $sqlMaiLingStat = '
        SELECT order_id,MAX(stat) AS mailingStat
        FROM order_mailing
        GROUP BY order_id
        ' ;
        $res1 = Yii::$app->db->createCommand($sqlMaiLingStat)
            ->queryAll() ;

        $filter = $this->_filter ;
        $perBeg = $filter['perBeg'] ;
        $perEnd = $filter['perEnd'] ;

        $userId = $this->getUser() ;
        $sql = '
        SELECT oW.*,orderMailing.mailingStat 
        FROM order_work oW 
        LEFT JOIN (' . $sqlMaiLingStat .') orderMailing ON orderMailing.order_id = oW.id
        WHERE oW.userid = :userId AND oW.per_beg >= :perBeg
              AND oW.per_end <= :perEnd 
               
        ' ;
        $res = Yii::$app->db->createCommand($sql)
            ->bindValue(':userId',$userId)
            ->bindValue(':perBeg',$perBeg)
            ->bindValue(':perEnd',$perEnd)
            ->queryAll() ;
        return $res ;
    }
    public function getCount() {
        $query = $this->queryBuild() ;
        return $query->count() ;
    }
    private function queryBuild() {
        $filter = $this->_filter ;
        $perBeg = $filter['perBeg'] ;
        $perEnd = $filter['perEnd'] ;

        $userId = $this->getUser() ;
        return  (new Query())
            ->select('*')
            ->from('order_work')
            ->where(['userid' => $userId])
            ->andWhere(
                ['between','time_create',$perBeg,$perEnd]) ;
    }
    public function addOrder($orderId,$attributes) {
        $obj = (!empty($orderId)) ? $this->findOrder($orderId) : $this ;
        $obj->userid = $this->getUser() ;
        $obj->attributes = $attributes ;
        $ValidFlag = $obj->validate() ;
        $this->_successFlag = $ValidFlag ;
        if ($ValidFlag) {
            $obj->save() ;
        }
        return $obj ;
    }
    public function deleteOrder($orderId) {
        $r =$this->findOrder($orderId) ;
        if ($r) {
            $r->delete() ;
        }
        $this->_successFlag = true ;
    }
    public function setOrderLock($orderId,$lockFlag) {
        $r =$this->findOrder($orderId) ;
        if ($r) {
            $r->lock_flag = $lockFlag;
            $ValidFlag = $r->validate();
            $this->_successFlag = $ValidFlag;
            if ($ValidFlag) {
                $r->save();
            }
        }
    }
    public function updateOrder($orderId,$attributes) {
        $r =$this->findOrder($orderId) ;

        if ($r) {
            $r->attributes = $attributes ;
            $ValidFlag = $r->validate() ;
            $this->_successFlag = $ValidFlag ;
            if ($ValidFlag) {
                $r->save() ;
            }
        }
        return $r ;
    }

    /**
     * текущий пользователь
     * @return int|null|string
     */
    private function getUser() {
        if(empty($this->userId)) {
            $userIsGuest = Yii::$app->user->isGuest ;
            if (!$userIsGuest) {
                $this->userId = Yii::$app->user->getId() ;
            }
        }
        return $this->userId ;
    }
    private function getConfirmationFlag() {
        $userId = $this->getUser() ;
        if (empty($userId)) {
            $this->confirmationFlag = false ;
        }else {
            $profile = UserProfile::findOne(['userid' => $userId]) ;
            $this->confirmationFlag = $profile->confirmation_flag ;
        }
        return $this->confirmationFlag ;
    }
    private function findOrder($orderId) {
        $r = $this->find()
            ->where(['id' => $orderId])->limit(1)->one() ;
        return $r  ;
    }
    public function getOrderMailing() {
        return $this->hasMany(OrderMailing::className(), ['order_id' => 'id']);
    }

    public static function className() {
        return __CLASS__ ;
    }

}