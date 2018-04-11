<?php
/**
 * контроллер исполнителей - Я - ИСПОЛНИТЕЛЬ
 * Time: 21:23
 */

namespace app\controllers;


use app\models\OrderStatFunc;
use app\models\OrderMailing ;
use yii\web\Controller;
use app\controllers\BaseController ;
use app\service\TaskStore ;
use app\models\Pagination ;
use app\models\DeveloperOrdersFilterForm ;
use app\models\OrderWork ;
use app\controllers\DeveloperFunc ;
use app\views\viewParts\OrderViewPrepare ;

use yii\helpers\Url ;
use yii\helpers\Html ;
use yii\swiftmailer ;
use app\models\UserProfile ;
use Yii ;
class DeveloperOrdersController extends BaseController {
    protected  $objectId ;
    protected $OBJECT_ID_NAME = 'developerId' ;
    protected  $OBJECT_NAME = 'currentDeveloper' ;
    protected $FILTER_FORM_NAME = 'app\models\DeveloperOrdersFilterForm' ;
    protected $EXT_FUNC = 'app\controllers\OrderFunc' ;
    protected $VIEW_PREPARE_FUNC = 'app\views\viewParts\OrderViewPrepareByOrder' ;
    protected $userRole = 'developer';
//-----------------------------------------------------//
    public function actionIndex() {
        return $this->render('index');
    }

    /**
     * объект
     * @return mixed
     */
    protected  function getContextObjectId() {
        $this->objectId  = Yii::$app->user->getId(); ;

        $objectId = $this->objectId  ;
//        if (empty($objectId)) {
//            $obj = TaskStore::getParam($this->OBJECT_NAME) ;
//            $objectId =   $obj[$this->OBJECT_ID_NAME] ;
//            $this->objectId = $objectId ;
//        }
        return $objectId ;
    }
    /**
     * установить новый фильтр и взять список
     * пустой фильтр может быть - тогда, то что по умолчанию
     */
    public function actionSetFilter()  {
        $filter = Yii::$app->request->post('filter');
        $xFilterForm = $this->FILTER_FORM_NAME ;
        if (!empty($filter)) {
            $filterForm = new $xFilterForm() ;
            $filterForm->setFilter($filter) ;
        }
        $initFlag = true ;
        $this->sendDataPage($initFlag) ;
    }

    /**
     * отправить страницу данных
     */
    private function sendDataPage($initFlag = false,$indexPageType = -1,$pageNum = -1) {
//        $devFunc = new DeveloperFunc() ;
        $xExtFuncName = $this->EXT_FUNC ;
        $xExtFunc = new $xExtFuncName('mailing') ;
        $l = [] ;
        if ($initFlag) {
            $l = $xExtFunc->getDataFirstPage() ;
        }else {
            $l = $xExtFunc->getDataOrdinaryPage($indexPageType,$pageNum) ;
        }
        $lItems = $l['listItems'] ;
        $indexPages = $l['indexPages'] ;

        $xViewPrepareFuncName = $this->VIEW_PREPARE_FUNC ;

        $listForShow = (new $xViewPrepareFuncName())->getItemsForShow($lItems) ;
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
        $xFilterName =$this->FILTER_FORM_NAME ;
//        $filterForm = new OrderMailingFilterForm() ;
        $filterForm = new $xFilterName() ;

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
     * параметры для определния состояния заказа
     * на выходе пара ['orderId' => ... , 'developerId' => ..],
     * определяющая состояние заказа
     */
    protected function getNewStatParams() {
        $orderId = Yii::$app->request->post('orderId');
        $developerId = $this->getContextObjectId() ;
        return ['orderId' => $orderId,'developerId' => $developerId] ;
    }
    /**
     * переключение состояния
     */
    public function actionOrderNewStat() {
//        $developerId = Yii::$app->request->post('developerId');
//        $toggleDirect = Yii::$app->request->post('toggleDirect');
//        $orderId = $this->getContextObjectId() ;

        $toggleDirect = Yii::$app->request->post('toggleDirect');
        $statParams = $this->getNewStatParams() ;
        $developerId = $statParams['developerId'] ;
        $orderId = $statParams['orderId'] ;

        $orderMailing = new OrderMailing() ;
        $orderRec = $orderMailing->getById($orderId,$developerId) ;
        $orderStat = $orderRec->stat ;   // тек состояние
        // состояние зависит от теукущей роли пользователя
        $newStat = (new OrderStatFunc())
            ->nextStat($this->userRole,$toggleDirect,$orderStat) ;
//      сохранить состояние
        $orderMailing->addOrderMailing($orderId,$developerId,$newStat) ;

        $xExtFuncName = $this->EXT_FUNC ;
        $xFunc = new $xExtFuncName('mailing') ;
        $currentPage = $xFunc->getCurrentPage() ;

        $answ = [
            'opCod' => 'orderStat',
            'success' => true,
            'message' => [],
            'orderId' => $orderId,
            'developerId' => $developerId,
            'prevOrderStat' => $orderStat,
            'newOrderStat' => $newStat,
            'currentPage' => $currentPage,
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
     */
    /**
     * сдесь нет рассылки, только изменение сотояния
     */
    public function actionSendEmail() {
        $statParams = $this->getNewStatParams() ;
        $developerId = $statParams['developerId'] ;
//        $orderId = $statParams['orderId'] ;

        $statReadyList = (new OrderStatFunc())->getStatReadyList($this->userRole) ;
        $xExtFuncName = $this->EXT_FUNC ;
        $limit = -1 ;
        $xExtFunc =  new $xExtFuncName('mailing') ;
        $lSelected = $xExtFunc
            ->getDataStatReady($limit) ;    // здесь имена полей как в таблице dev_order_rank_tmp
        $listItems = $lSelected['listItems'] ;
        $success = true ;
        $message = [] ;
        $messCount = 0 ;
        $statFunc = new OrderStatFunc() ;
        $orderMailing = new OrderMailing() ;
        foreach ($listItems as $ind => $item) {
            $userId = $item['userid'] ;
            $messCount += 1 ;
            $currentStat = $item['mailing']['stat'] ;
            $orderId = $item['id'] ;
            $newStat = $statFunc
                ->nextStat($this->userRole,'plus',$currentStat) ;
            $xExtFunc->putOrderStatus($userId,$orderId,$currentStat,$newStat) ;

            $orderMailing->addOrderMailing($orderId,$developerId,$newStat) ;
//          послать координаты
            if ($newStat === OrderStatFunc::STAT_SELECTED_ANSWERED) {
                $this->emailSelectedAnswered($developerId,$orderId) ;



            }
        }
            $message[] = 'Сделано подтверждений на выполнение работ по заказам' .
                         ' - ' . $messCount;
//        if ($newStat === OrderMailing::STAT_SELECTED_ANSWERED) {
////            $this->sendSelectedEmail() ;
//        }

        $answ = [
            'opcod' => 'sendEmail',
            'success' => $success,
            'message' => $message,
            'z_end' => 'end'
        ];
        echo json_encode($answ);

    }
    /**
     * заказчик определяется через ЗАКАЗ
     * @param $developerId
     * @param $orderId
     */
    private function emailSelectedAnswered($developerId,$orderId) {
        $order = (new OrderWork())->getById($orderId) ;
        $orderName = $order->order_name ;
        $customerId = $order->userid ;      // Заказчик
        $profile = new UserProfile() ;
        $customerProfile = $profile->getByUserId($customerId) ;
        $companyCustomer = $customerProfile->company ;
        $developerProfile = $profile->getByUserId($developerId) ;
        $companyDeveloper = $developerProfile->company ;
        $developerTel = $developerProfile->tel ; ;
        $developerEmail = $developerProfile->email ;
        $customerEmail = $customerProfile->email ;
        $addText = 'Портал <b>Pere-stroika</b> сообщает Вам,(<b>' . $companyCustomer . '</b>)<br>' .
            'что выбранный Вами ИСПОЛНИТЕЛЬ (<b>' . $companyDeveloper . '</b>)<br>' .
            'дал согласие на выполнение работ по ЗАКАЗУ №  ' .$orderId . '(<b>' . $orderName . '</b>)<br>' .
            'рнквизиты для связи: тел:<b>' . $developerTel .'</b><br>' .
            'email:<b>' . $developerEmail .'</b><br>' ;
        $siteUrl = Url::to(['site/'],true) ;
        $text = 'Подробности в Вашем кабинете на сайте Pere-stroika' ;
        $a = Html::a($text, $siteUrl) ;
        Yii::$app->mailer->compose()
//            ->setFrom('mnudelman@yandex.ru')
            ->setTo($customerEmail)
            ->setSubject('Pere-stroika. Исполнитель дал согласие на выполнение работы')
//            ->setTextBody($addText .' '.'Для подтверждения корректности email перейдите по ссылке ' . $siteUrl)
            ->setHtmlBody($addText .' '.$a)
            ->send();

    }
    /**
     * Возможно здесь отправка атрибутов ИСПОЛНИТЕЛЯ
     * @param $id
     * @param $orderId
     * @param $orderName
     * @param $timeCreate
     * @param $company
     * @param $email
     */
    private function sendSelectedEmail($id,$orderId,$orderName,$timeCreate,$company,$email) {
        $addText = 'Портал <b>Pere-stroika</b> сообщает Вам,(<b>' . $company . '</b>)<br>' .
            'что компания выбрана ИСПОНИТЕЛЕМ работ по заказу <b> № ' . $orderId .
            '(' . $orderName .')</b><br>' ;
        $totId = $id . '-' . $orderId ;
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