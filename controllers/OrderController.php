<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 09.12.16
 * Time: 21:33
 */

namespace app\controllers;


use app\models\Pagination;
use yii\web\Controller;
use app\controllers\BaseController ;
use app\models\OrderWork ;
use app\service\TaskStore ;
use app\components\UserGeography ;
use app\models\OrderAdditional ;
use app\models\OrderMailing ;
use app\controllers\OrderFunc ;
use app\models\OrderFilterForm ;
use Yii ;
class OrderController extends BaseController {
    private $currentOrder = [
        'isNew' => true ,
        'orderId' => null,
        'copyFromId' => null,      // получен копированием
    ] ;
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * отмечаем тек заказ как новый
     */
    public function actionCreateOrder() {
        $this->currentOrder['isNew'] = true ;
        $this->currentOrder['orderId'] = null ;
        $this->currentOrder['copyFromId'] = null ;
        TaskStore::putParam('currentOrder',$this->currentOrder) ;
        $orderGeneral = [] ;
        $orderGeneral['orderName'] = '' ;
        $orderGeneral['orderDescription'] = '' ;
        $orderGeneral['perBeg'] = date('Y-m-d',time()) ;
        $orderGeneral['perEnd'] = date('Y-m-d',time()) ;

            $answ = [
            'currentOrder' => $this->currentOrder,
            'orderGeneral' => $orderGeneral,
            'message' => [],
            'success' => true,
            'z-end' => 'zend'
        ] ;
        echo json_encode($answ) ;
    }

    /**
     *
     */
    public function actionCopyOrder() {
        $order = $this->getCurrentOrder() ;
        if(!empty($order['orderId'])) {
            $order['copyFromId'] = $order['orderId'] ;
        }
        $order['orderId'] = null ;
        $order['isNew'] = true ;
        $this->currentOrder = $order ;
        TaskStore::putParam('currentOrder',$this->currentOrder) ;

        $orderGeneral = Yii::$app->request->post('orderGeneral');
        $orderGeneral['orderId'] = '' ;

        $answ = [
            'currentOrder' => $this->currentOrder,
            'success' => true,
            'message' => [],
            'orderGeneral' => $orderGeneral,
            'z-end' => 'zend'
        ] ;
        echo json_encode($answ) ;

    }

    /**
     * установить тек заказ
     */
    public function actionSetCurrentOrder() {

        $orderId = Yii::$app->request->post('orderId');
        $order = [] ;
        $order['orderId'] = $orderId ;
        $order['isNew'] = false ;
        $order['copyFromId'] = null ;
        $this->currentOrder = $order ;
        TaskStore::putParam('currentOrder',$this->currentOrder) ;
        $answ = [
            'currentOrder' => $order,
            'success' => true,
            'message' => [],
            'z-end' => 'zend'] ;
        echo json_encode($answ) ;
    }
    private function getCurrentOrder()
    {
        $order = TaskStore::getParam('currentOrder');
        $result = [];
        $result['isNew'] = (isset($order['isNew'])) ? $order['isNew'] : $this->currentOrder['isNew'];
        $result['orderId'] = (isset($order['orderId'])) ? $order['orderId'] : $this->currentOrder['orderId'];
        $result['copyFromId'] = (isset($order['copyFromId'])) ? $order['copyFromId'] : $this->currentOrder['copyFromId'];
        return $result;
    }
    public function actionSaveOrder() {
        $order = $this->getCurrentOrder() ;
        $orderGeneral = Yii::$app->request->post('orderGeneral');
        $orderWork = new OrderWork() ;
        $orderId = ($order['isNew']) ? null : $order['orderId'] ;
        $orderAttributes = [
            'order_name' => $orderGeneral['orderName'],
            'description' => $orderGeneral['description'],
            'city_id' => $orderGeneral['cityId'],
            'per_beg' => $orderGeneral['perBeg'],
            'per_end' => $orderGeneral['perEnd'],
        ] ;
        $orderAdd = $orderWork->addOrder($orderId,$orderAttributes) ;
        $success = $orderWork->getSuccessFlag() ;
        if ($success) {
            $orderId = $orderAdd->id ;
            $orderAdd = $orderWork->getById($orderId) ;

            $order['orderId'] = $orderAdd-> id ;
            $order['isNew'] = false ;
            $order['copyFromId'] = null ;
            $this->currentOrder = $order ;
            TaskStore::putParam('currentOrder',$this->currentOrder) ;
        }
        $orderSetItem = (new orderFunc())->getOrderItem($orderAdd) ;

        $orderGeneral['timeCreate'] = $orderAdd->time_create ;
        $orderGeneral['orderId'] = $orderAdd->id ;
        $message = ($success) ? ['save' => 'oK!'] :  $orderWork->errors ;
        $answ = [
            'currentOrder' => $order,
            'success' => $success,
            'message' => $message,
            'orderGeneral' => $orderGeneral,
            'orderSetItem' => $orderSetItem ,
            'z-end' => 'zend'
        ] ;
        echo json_encode($answ) ;

    }
    private function mailingCount() {
        $currentOrder = TaskStore::getParam('currentOrder') ;

        $orderId = $currentOrder['orderId'] ;
        $additionalModel = new OrderAdditional();
        $mailingModel = new OrderMailing();
        $mailingModel->currentOrderId = $orderId;
        $additionalModel->currentOrderId = $orderId;
        $addList = $additionalModel->getList();
        $sentList = $mailingModel->typeCount();
        $sentTotal = 0;
        $answered = 0;
        $isSelected = false;
        foreach ($sentList as $key => $value) {
            switch ($key) {
                case OrderMailing::STAT_SENT :
                    $sentTotal = $value;
                    break;
                case OrderMailing::STAT_ANSWERED :
                    $answered = $value;
                    break;
                case OrderMailing::STAT_SELECTED :
                    $isSelected = ($value) ? true : false;;
                    break;

            }
        }

    }
    public function actionDeleteOrder() {
        $order = $this->getCurrentOrder() ;
        $orderId = $order['orderId'] ;
        $orderWork = new OrderWork() ;
        $orderWork->deleteOrder($orderId) ;
        $this->currentOrder['isNew'] = false ;
        $this->currentOrder['orderId'] = null ;
        $this->currentOrder['copyFromId'] = null ;

        TaskStore::putParam('currentOrder',$this->currentOrder) ;
        $orderGeneral = [] ;
        $orderGeneral['orderName'] = '' ;
        $orderGeneral['orderDescription'] = '' ;
        $orderGeneral['perBeg'] = date('Y-m-d',time()) ;
        $orderGeneral['perEnd'] = date('Y-m-d',time()) ;
        $message = ['delete' => 'oK!'] ;
        $answ = [
            'opCod' => 'orderDelete',
            'orderId' => $orderId,
            'currentOrder' => $this->currentOrder,
            'orderGeneral' => $orderGeneral,
            'message' => $message,
            'success' => true,
            'z-end' => 'zend'
        ] ;
        echo json_encode($answ) ;



    }

    /**
     * получить основную часть описания ЗАПРОСА
     */
    public function actionGetOrderGeneral() {
       return $this->actionEditOrder() ;
    }
    private function getOrderId() {
        $orderId = null ;
        if (Yii::$app->request->isAjax) {
            $orderGeneral = Yii::$app->request->post('orderGeneral');
            $orderId = (isset($orderGeneral['orderId'])) ? $orderGeneral['orderId']:null ;
        }
        if (empty($orderId)) {
            $currentOrder = $this->getCurrentOrder() ;
            $orderId = $currentOrder['orderId'] ;
        }
        return $orderId ;
    }
    private function getOrderLabel($order) {
        $lang = TaskStore::getParam('currentLanguage') ;
        $orderShow =  ($lang === 'en') ? 'Order' : 'Заказ' ;
        $byShow =  ($lang === 'en') ? 'by' : 'от' ;
        $orderId = $order['id'] ;
        $timeCreate = $order['time_create'] ;
        return( (empty($orderId)) ? '' :
            $orderShow . ' N ' . $orderId .' ' . $byShow .' ' . $timeCreate );
    }
    /**
     * редактировать запрос (перенос в область редактирования)
     */
    public function actionEditOrder() {
//        $orderGeneral = Yii::$app->request->post('orderGeneral');
//        $orderId = $orderGeneral['orderId'] ;
        $orderId = $this->getOrderId() ;

        $orderWork = new OrderWork() ;
        $order = $orderWork->getById($orderId) ;
        $success = !empty($order) ;
        $message = [] ; //$order->errors ;
        $orderGeneral = [] ;
        if ($success) {
            $orderGeneral = [
                'orderId' => $order['id'],
                'orderName'=>$order['order_name'],
                'orderDescription' => $order['description'],
                'cityId' => $order['city_id'],
                'perBeg' => $order['per_beg'],
                'perEnd' => $order['per_end'],
                'timeCreate' => $order['time_create'],
                'orderLabel' => $this->getOrderLabel($order),
            ] ;
            $geography = new UserGeography() ;
            $geography->setCityId($order['city_id']) ;
            $orderPlace = $geography->getOwnGeography() ;
            $orderGeneral['orderPlace'] = $orderPlace ;
        }
        if ($success) {
            $this->currentOrder['orderId'] = $orderId ;
            $this->currentOrder['isNew'] = false ;
            $this->currentOrder['copyFromId'] = null ;
            TaskStore::putParam('currentOrder',$this->currentOrder) ;
        }
        $answ = [
            'currentOrder' => $this->currentOrder,
            'success' => $success,
            'message' => $message,
            'orderGeneral' => $orderGeneral,
            'z-end' => 'zend'
        ] ;
        if (Yii::$app->request->isAjax) {
            echo json_encode($answ);
        }else {
            return $answ ;
        }
    }

    /**
     * установить новый фильтр и взять список
     */
    public function actionSetFilterOrder()  {
        $orderFilter = Yii::$app->request->post('orderFilter');
        $filterForm = new OrderFilterForm() ;
        $filterForm->setFilter($orderFilter) ;
        $orderModel = new OrderWork() ;
        $orderModel->setFilter($orderFilter) ;
        $message = $filterForm->errors ;
        $success = (sizeof($message) === 0) ;
        $orderList = [] ;
        if ($success) {
            $orderList = (new OrderFunc())->getOrderList() ;
        }

        $answ = [
            'success' => $success ,
            'orderList' => $orderList,
            'message' => $message,
            'z-end' => 'zend'
        ] ;
        echo json_encode($answ) ;
    }
    /**
     * установить новый фильтр и взять список
     */
    public function actionGetFilterOrder()  {
        $filterForm = new OrderFilterForm() ;
        $orderFilter = $filterForm->getFilter() ;
        $success = true ;
        $answ = [
            'success' => $success ,
            'orderFilter' => $orderFilter,
            'message' => [],
            'z-end' => 'zend'
        ] ;
        echo json_encode($answ) ;
    }
    public function actionNewPage() {

        $newPage = Yii::$app->request->post('page');
        $pageType = -1 ;
        $pageNum = -1 ;
        switch ($newPage) {
            case 'first' :
                $pageType = Pagination::PAGE_FIRST ;
                break ;
            case 'prev' :
                $pageType = Pagination::PAGE_PREV ;
                break ;
            case 'next' :
                $pageType = Pagination::PAGE_NEXT ;
                break ;
            case 'last' :
                $pageType = Pagination::PAGE_LAST ;
                break ;
            default :
                $pageType = Pagination::PAGE_NUM ;
                $pageNum = $newPage ;
                break ;


        }
        $res = (new orderFunc())->getOrderPage($pageType,$pageNum) ;
        $listItems = $res['listItems'] ;
        $indexPages = $res['indexPages'] ;
        $success = true ;
        $message = [] ;
        $answ = [
            'success' => $success ,
            'listItems' => $listItems,
            'indexPages' => $indexPages,
            'message' => $message,
            'z-end' => 'zend'
        ] ;
        echo json_encode($answ) ;

    }

}