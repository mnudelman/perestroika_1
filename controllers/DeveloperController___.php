<?php
/**
 * контроллер исполнителей - Я - заказчик
 * Time: 21:23
 */

namespace app\controllers;

use app\controllers\DeveloperOrdersController ;
use app\models\OrderStatFunc;
use app\models\OrderMailing ;
use yii\web\Controller;
use app\service\TaskStore ;
use app\models\Pagination ;
use app\models\OrderMailingFilterForm ;
use app\models\MailingSetupForm ;
use app\models\OrderWork ;
use app\controllers\DeveloperFunc ;
use app\views\viewParts\OrderViewPrepare ;
use yii\helpers\Url ;
use yii\helpers\Html ;
use yii\swiftmailer ;
use Yii ;
class DeveloperController extends DeveloperOrdersController {
    private $orderId ;
    private $userRole = 'customer';
//-----------------------------------------------------//
    public function actionIndex() {
        return $this->render('index');
    }
    private function getCurrentOrderId() {
        $orderId = $this->orderId   ;
        if (empty($orderId)) {
            $order = TaskStore::getParam('currentOrder') ;
            $orderId =   $order['orderId'] ;
            $this->orderId = $orderId ;
        }
        return $orderId ;
    }
    /**
     * установить новый фильтр и взять список
     * пустой фильтр может быть - тогда, то что по умолчанию
     */
    public function actionSetFilter()  {
        $filter = Yii::$app->request->post('filter');
        if (!empty($filter)) {
            $filterForm = new OrderMailingFilterForm() ;
            $filterForm->setFilter($filter) ;
        }
        $orderLock = $this->getOrderLock() ;
        $success = true ;
        $answ = [
            'success' => $success ,
            'message' => [],
            'orderLock' => $orderLock,
            'z-end' => 'zend'
        ] ;
        echo json_encode($answ) ;
//        $this->sendDataPage($initFlag) ;
    }

    /**
     * отправить страницу данных
     */
    private function sendDataPage($initFlag = false,$indexPageType = -1,$pageNum = -1) {
        $devFunc = new DeveloperFunc() ;
        $l = [] ;
        if ($initFlag) {
            $l = $devFunc->getDataFirstPage() ;
        }else {
            $l = $devFunc->getDataOrdinaryPage($indexPageType,$pageNum) ;
        }
        $lItems = $l['listItems'] ;
        $indexPages = $l['indexPages'] ;

        $listForShow = (new OrderViewPrepare())->getItemsForShow($lItems) ;
        $listItems = $listForShow['setItems'] ;
        $buttons = $listForShow['buttons'] ;
        $success = true ;
        $answ = [
            'success' => $success ,
            'listItems' => $listItems,
            'indexPages' => $indexPages,
            'buttons' => $buttons,
            'message' => [],
            'z-end' => 'zend'
        ] ;
        echo json_encode($answ) ;

    }
    /**
     * текущий фильтр
     */
    public function actionGetFilter()  {
        $filterForm = new OrderMailingFilterForm() ;
        $filter = $filterForm->getFilter() ;
        $success = true ;
        $answ = [
            'success' => $success ,
            'filter' => $filter,
            'message' => [],
            'z-end' => 'zend'
        ] ;
        echo json_encode($answ) ;
    }

    /**
     * страница данных из indexPages
     */
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
        $this->sendDataPage(false,$pageType,$pageNum) ;
    }
    /**
     * переключение состояния
     */
    public function actionOrderNewStat() {
        $developerId = Yii::$app->request->post('developerId');
        $toggleDirect = Yii::$app->request->post('toggleDirect');
        $orderId = $this->getCurrentOrderId() ;
        $orderMailing = new OrderMailing() ;
        $orderRec = $orderMailing->getById($orderId,$developerId) ;
        $orderStat = $orderRec->stat ;
        $newStat = (new OrderStatFunc())->nextStat('customer',$toggleDirect,$orderStat) ;

        $devFunc = new DeveloperFunc() ;
        $l = $devFunc->putOrderStatus($developerId,$orderStat,$newStat) ;






        $orderMailing->addOrderMailing($orderId,$developerId,$newStat) ;
        $answ = [
            'opCod' => 'orderStat',
            'success' => true,
            'message' => [],
            'orderId' => $orderId,
            'developerId' => $developerId,
            'prevOrderStat' => $orderStat,
            'newOrderStat' => $newStat,
            'currentPage' => $l['currentPage'],
            'z_end' => 'end'
        ];
        echo json_encode($answ);

    }
    private function getOrderLock() {
        $orderId = $this->getCurrentOrderId() ;
        $orderModel = new OrderWork() ;
        $order = $orderModel->getById($orderId) ;
        return  (boolean) $order->lock_flag ;

    }
    /**
     * блокировка/отменаблокировки заказа
     */
    public function actionToggleOrderLock() {
        $orderId = $this->getCurrentOrderId() ;
        $orderModel = new OrderWork() ;
        $order = $orderModel->getById($orderId) ;
        $lockFlag = (boolean) $order->lock_flag ;
        $lockFlag = !$lockFlag ;
        $orderModel->setOrderLock($orderId,$lockFlag) ;
        $answ = [
            'opCod' => 'orderLock',
            'success' => true,
            'message' => [],
            'orderId' => $orderId,
            'orderLock' => $lockFlag,
            'z_end' => 'end'
        ];
        echo json_encode($answ);


    }

    /**
     * настройка рассылки
     */
    public function actionGetSetup() {
        $setupForm = new MailingSetupForm() ;
        $setup = $setupForm->getFilter() ;
        $answ = [
            'opCod' => 'getSetup',
            'success' => true,
            'message' => [],
            'setup' => $setup,
            'z_end' => 'end'
        ];
        echo json_encode($answ);

        $a = 1 ;
    }
    public function actionSetSetup() {
        $a = 1 ;
        $setup = Yii::$app->request->post('setup');
        $setupForm = new MailingSetupForm() ;
        $setupForm->setFilter($setup) ;
// обработка для случая авто //
//---------------------------//
        $answ = [
            'opCod' => 'setSetup',
            'success' => true,
            'message' => [],
            'setup' => $setup,
            'z_end' => 'end'
        ];
        echo json_encode($answ);

    }
    /**
     * сообщение для выбранного исполнителя
     */
    public function actionSendSelectedEmail() {

    }
    /**
     * если есть выбранный исполнитель, то отсылается единственное письмо
     * иначе всем, кому не было предложений  (orderStat = 0 )
     * 'CREATE TEMPORARY TABLE IF NOT EXISTS dev_order_rank_tmp
    (userid INTEGER,
    user_date_first TIMESTAMP,          -- время регистрация
    profile_company VARCHAR(255),        -- данные из профиля
    profile_info VARCHAR(255),
    profile_avatar VARCHAR(100),
    profile_email VARCHAR (100),
    profile_tel VARCHAR (20),
    profile_city_id INTEGER ,
    profile_city_name VARCHAR(100),
    sent_count INTEGER,       -- статистика исполнителя:приглашений всего
    answered_count INTEGER,   -- число согласий на выполнение
    selected_count INTEGER,   -- выбран исполнителем всего
    current_order_stat INTEGER DEFAULT 0,   -- стаус по тек заказу
    work_direction_rank INTEGER ,     -- сумарная оценка по направл работ (%)
    region_stat INTEGER DEFAULT 0,    -- 1 если регион совпадает
    city_stat INTEGER DEFAULT 0,      -- 1 если город совпадает
    geography_rank INTEGER            -- оценка географии(100% - город| 50% - регион
     * сохранять deadline
     */
    public function actionSendEmail() {
// атрибуты тек договора
        $order = TaskStore::getParam('currentOrder') ;
        $orderId =   $order['orderId'] ;
        $orderRec = (new OrderWork())->getById($orderId) ;
        $orderName = $orderRec->order_name ;
        $timeCreate = $orderRec->time_create ;
        $aliasId =  $orderRec->alias_id ;
        if (empty($aliasId)) {
           $orderRec->addOrder() ;   // обновить тек заказ (заполнить поле alias_id)
            $aliasId =  $orderRec->alias_id ;
        }
        $limit = 20 ; // max число рассылок
        $devFunc = new DeveloperFunc() ;
        $limit = 1 ;
        $orderStatSelectedReady = OrderStatFunc::STAT_SELECTED_READY ;
        $lSelected = $devFunc->getDataFull($limit,'=',$orderStatSelectedReady) ;    // здесь имена полей как в таблице dev_order_rank_tmp
        $listItems = $lSelected['listItems'] ;
        $success = true ;
        $message = [] ;
        $messCount = 0 ;
//        $devFunc = new DeveloperFunc() ;

        if (sizeof($listItems) > 0) {   // есть исполнитель. Больше рассылок не делать
            $item = $listItems[0] ;
            $userId = $item['userid'] ;
            $company = $item['profile_company'] ;
            $email = $item['profile_email'] ;
            $tel = $item['profile_tel'] ;
            $confirmation_key = $item['profile_confirmation_key'] ;
//            $this->sendSelectedEmail($confirmation_key,$orderId,$orderName,$timeCreate,$company,$email) ;
            $this->sendSelectedEmail($confirmation_key,$aliasId,$orderName,$timeCreate,$company,$email) ;
            $message[] = 'Отправлено уведомление ИСПОЛНИТЕЛЮ ЗАКАЗА' ;
            $messCount = 1;
            $orderStatSelected = OrderStatFunc::STAT_SELECTED ;
            $devFunc->putOrderStatus($userId,$orderStatSelectedReady,
                $orderStatSelected) ;

        }else {
            $limit = 20 ;
            $orderStatSentReady = OrderStatFunc::STAT_SENT_READY ;
            $orderStatSent = OrderStatFunc::STAT_SENT ;
            $lSent = $devFunc->getDataFull($limit,'=',$orderStatSentReady) ;    // здесь имена полей как в таблице dev_order_rank_tmp
            $listItems = $lSent['listItems'] ;
            foreach ($listItems as $ind => $item) {
                $userId = $item['userid'] ;
                $company = $item['profile_company'] ;
                $email = $item['profile_email'] ;
                $tel = $item['profile_tel'] ;
                $confirmation_key = $item['profile_confirmation_key'] ;
                $this->sendEmail($confirmation_key,$aliasId,$orderName,$timeCreate,$company,$email) ;
                $messCount += 1 ;
                $devFunc->putOrderStatus($userId,$orderStatSentReady,$orderStatSent) ;
            }
            $message[] = 'Отправлено уведомлений с предложением принять участие в конкурсе' .
                         ' - ' . $messCount;
        }


        $answ = [
            'opcod' => 'sendEmail',
            'success' => $success,
            'message' => $message,
            'z_end' => 'end'
        ];
        echo json_encode($answ);
//      отправлено nnn предложений по заказу xxxxxxxxx
    }
    private function sendSelectedEmail($id, $aliasId, $orderName, $timeCreate, $company, $email) {
        $addText = 'Портал <b>Pere-stroika</b> сообщает Вам,(<b>' . $company . '</b>)<br>' .
            'что компания выбрана ИСПОНИТЕЛЕМ работ по заказу <b> № ' . $aliasId .
            '(' . $orderName .')</b><br>' ;
        $totId = $id . '-' . $aliasId ;
        $siteUrl = Url::to(['site/order-selected-email','id'=>$totId],true) ;
        $text = 'Для подтверждения вашей готовности выполнить работы и ' .
                 'получить реквизиты заказчика перейдите по ссылке ' ;
        $a = Html::a($text, $siteUrl) ;
        Yii::$app->mailer->compose()
//            ->setFrom('mnudelman@yandex.ru')
            ->setTo($email)
            ->setSubject('Pere-stroika. Вы выбраны исполнителем работ')
//            ->setTextBody($addText .' '.'Для подтверждения корректности email перейдите по ссылке ' . $siteUrl)
            ->setHtmlBody($addText .' '.$a)
            ->send();

    }

    private function sendEmail($id,$orderId,$orderName,$timeCreate,$company,$email) {
        $addText = 'Портал <b>Pere-stroika</b> предлагает Вам(<b>' . $company . '</b><br>' .
            'принять участие в конкурсе на выполнение работ по заказу <b> № ' . $orderId .
            '(' . $orderName .')</b><br>' ;
        $totId = $id . '-' . $orderId ;
        $siteUrl = Url::to(['site/order-email','id'=>$id . '-' . $orderId],true) ;
        $text = 'Для подтверждения участия в конкурсе перейдите по ссылке ' ;
        $a = Html::a($text, $siteUrl) ;
        Yii::$app->mailer->compose()
//            ->setFrom('mnudelman@yandex.ru')
            ->setTo($email)
            ->setSubject('Pere-stroika. Конкурс на выолнение работы')
//            ->setTextBody($addText .' '.'Для подтверждения корректности email перейдите по ссылке ' . $siteUrl)
            ->setHtmlBody($addText .' '.$a)
            ->send();

    }
}