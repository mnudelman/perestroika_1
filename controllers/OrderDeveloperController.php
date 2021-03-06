<?php
/**
 * контроллер исполнителей - Я - заказчик
 * Time: 21:23
 * это старый текст. Вместо него используется DeveloperOrdersController
 */

namespace app\controllers;



use yii\web\Controller;
use app\controllers\BaseController ;
use app\service\TaskStore ;
use app\models\Pagination ;
use app\models\DeveloperOrdersFilterForm ;
use app\models\OrderWork ;
use app\controllers\funcs\DeveloperFunc ;
use app\views\viewParts\OrderViewPrepare ;
use app\controllers\funcs\OrderStatFunc ;
use app\controllers\funcs\MailingFunc ;
use yii\helpers\Url ;
use yii\helpers\Html ;
use yii\swiftmailer ;
use Yii ;
class OrderDeveloperController extends BaseController {
    private $developerId ;
//    private $userRole = 'developer';
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
            $filterForm = new DeveloperOrdersFilterForm() ;
            $filterForm->setFilter($filter) ;
        }
        $initFlag = true ;
        $this->sendDataPage($initFlag) ;
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
     * выбор/отказ ИСПОНИТЕЛЯ
     */
    public function actionOrderSelect() {
//        $developerId = Yii::$app->request->post('developerId');
//        $devFunc = new DeveloperFunc() ;
//        $l = $devFunc->putOrderSelected($developerId) ;
//
//        $answ = [
//            'opcod' => 'orderSelect',
//            'success' => true,
//            'message' => [],
//            'currentPage' => $l['currentPage'],
//            'z_end' => 'end'
//        ];
//        echo json_encode($answ);





    }

    /**
     * переключение состояния
     */
    public function actionOrderNewStat() {
        $developerId = Yii::$app->request->post('developerId');
        $toggleDirect = Yii::$app->request->post('toggleDirect');
        $orderId = $this->getCurrentOrderId() ;
        $orderMailing = new OrderStatFunc() ;
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
     */
    public function actionSendEmail() {
// атрибуты тек договора
        $order = TaskStore::getParam('currentOrder') ;
        $orderId =   $order['orderId'] ;
        $orderRec = (new OrderWork())->getById($orderId) ;
        $orderName = $orderRec->order_name ;
        $timeCreate = $orderRec->time_create ;
        $limit = 20 ; // max число рассылок
        $devFunc = new DeveloperFunc() ;
        $limit = 1 ;
        $orderStatSelectedReady = OrderStatFunc::STAT_SELECTED_READY ;
        $lSelected = $devFunc->getDataFull($limit,'=',$orderStatSelectedReady) ;    // здесь имена полей как в таблице dev_order_rank_tmp
        $listItems = $lSelected['listItems'] ;
        $success = true ;
        $message = [] ;
        $messCount = 0 ;
        $devFunc = new DeveloperFunc() ;
        $mailingFunc = new MailingFunc() ;
        if (sizeof($listItems) > 0) {   // есть исполнитель. Больше рассылок не делать
            $item = $listItems[0] ;
            $userId = $item['userid'] ;
//            $company = $item['profile_company'] ;
//            $email = $item['profile_email'] ;
//            $tel = $item['profile_tel'] ;
//            $confirmation_key = $item['profile_confirmation_key'] ;

//  старое          $this->sendSelectedEmail($confirmation_key,$orderId,$orderName,$timeCreate,$company,$email) ;







            $message[] = 'Отправлено уведомление ИСПОЛНИТЕЛЮ ЗАКАЗА' ;
            $messCount = 1;
            $orderStatSelected = OrderStatFunc::STAT_SELECTED ;
            $devFunc->putOrderStatus($userId,$orderStatSelectedReady,
                $orderStatSelected) ;
//   отправка почты для подтверждения
            $mailingFunc->setOrderAttr($orderId,$userId)
                ->setType(MailingFunc::TYPE_SELECTED_REQUEST)
                ->sendDo() ;

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

                $mailingFunc->setOrderAttr($orderId,$userId)
                    ->setType(MailingFunc::TYPE_READY_REQUEST)
                    ->sendDo() ;


//                $this->sendEmail($confirmation_key,$orderId,$orderName,$timeCreate,$company,$email) ;




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
//    private function sendSelectedEmail($id,$orderId,$orderName,$timeCreate,$company,$email) {
//        $addText = 'Портал <b>Pere-stroika</b> сообщает Вам,(<b>' . $company . '</b>)<br>' .
//            'что компания выбрана ИСПОНИТЕЛЕМ работ по заказу <b> № ' . $orderId .
//            '(' . $orderName .')</b><br>' ;
//        $totId = $id . '-' . $orderId ;
//        $siteUrl = Url::to(['site/order-selected-email','id'=>$totId],true) ;
//        $text = 'Для подтверждения вашей готовности выполнить работы и ' .
//                 'получить реквизиты заказчика перейдите по ссылке ' ;
//        $a = Html::a($text, $siteUrl) ;
//        Yii::$app->mailer->compose()
////            ->setFrom('mnudelman@yandex.ru')
//            ->setTo($email)
//            ->setSubject('Pere-stroika. Вы выбраны исполнителем работ')
////            ->setTextBody($addText .' '.'Для подтверждения корректности email перейдите по ссылке ' . $siteUrl)
//            ->setHtmlBody($addText .' '.$a)
//            ->send();
//
//    }

//    private function sendEmail($id,$orderId,$orderName,$timeCreate,$company,$email) {
//        $addText = 'Портал <b>Pere-stroika</b> предлагает Вам(<b>' . $company . '</b><br>' .
//            'принять участие в конкурсе на выполнение работ по заказу <b> № ' . $orderId .
//            '(' . $orderName .')</b><br>' ;
//        $totId = $id . '-' . $orderId ;
//        $siteUrl = Url::to(['site/order-email','id'=>$id . '-' . $orderId],true) ;
//        $text = 'Для подтверждения участия в конкурсе перейдите по ссылке ' ;
//        $a = Html::a($text, $siteUrl) ;
//        Yii::$app->mailer->compose()
////            ->setFrom('mnudelman@yandex.ru')
//            ->setTo($email)
//            ->setSubject('Pere-stroika. Конкурс на выолнение работы')
////            ->setTextBody($addText .' '.'Для подтверждения корректности email перейдите по ссылке ' . $siteUrl)
//            ->setHtmlBody($addText .' '.$a)
//            ->send();
//
//    }
}