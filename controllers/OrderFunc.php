<?php
/**
 * Дополнительные функции для контроллера OrderController
 */

//namespace app\controllers;
namespace app\controllers ;
use app\components\UserGeography;
use yii\widgets\ActiveForm;
use app\models\OrderWork;
use app\models\OrderAdditional;
use app\models\OrderMailing;
use app\service\PageItems;
use yii\jui\DatePicker;
use app\models\OrderFilterForm ;
use app\models\Pagination ;
use app\service\TaskStore;


class OrderFunc
{
    private $pageItemFile = 'order/general';   // файл сообщений/имена полей
    private $orderModel = null ;
    private $additionalModel = null ;
    private $mailingModel = null ;
    private $ugModel = null ;
    private $orderFilterModel = null ;
    private $infoFields = null ;   // имена полей
    private $pagination = null ;
    private $paginationName = 'order' ;
    private $getListAction = 'getList' ;
    private $sourceType = 'order' ;
    private $models = [
        'order' => [
            'object' => 'app\models\OrderWork',
            'filter' => 'app\models\OrderFilterForm',
            'paginationName' => 'order',
            'getListAction' => 'getList',
        ],
        'mailing' => [
            'object' => 'app\models\OrderMailing',
            'filter' => 'app\models\DeveloperOrdersFilterForm',
            'paginationName' => 'developerOrders',
            'getListAction' => 'getListByUser',
        ],

    ] ;
    //--------------------------------------------//
    public function __construct($sourceType = 'order') {
        $this->setSourceType($sourceType) ;

    }
    public function setSourceType($sourceType) {
        $this->sourceType = $sourceType ;

        $this->paginationName = $this->models[$this->sourceType]['paginationName'] ;
        $this->getListAction =  $this->models[$this->sourceType]['getListAction'] ;

        $this->modelsDefine() ;

    }
    private function modelsDefine($paginationClear = false) {
        if ($this->orderModel === null) {
            $xOrderClass = $this->models[$this->sourceType]['object'] ;
            $xOrderFilter = $this->models[$this->sourceType]['filter'] ;

//            $this->orderModel = new OrderWork() ;
            $this->orderModel = new $xOrderClass() ;
            $this->additionalModel = new OrderAdditional() ;
            $this->mailingModel = new OrderMailing() ;
            $this->ugModel = new UserGeography() ;
//            $this->orderFilterModel = new OrderFilterForm() ;
            $this->orderFilterModel = new $xOrderFilter() ;
            $this->infoFields = PageItems::getItemText([$this->pageItemFile, 'infoFields']);
            $this->pagination = new Pagination($this->paginationName,$paginationClear) ;
        }

    }
    /**
     * формирует список для вывода
     */
    public function getOrderList($indexSize = 3, $rowsPerPage = 5)
    {
        $paginationClear = true ;     // очистка 
        $this->modelsDefine($paginationClear) ;
        $orderModel = $this->orderModel ;
        $additionalModel = $this->additionalModel ;
        $mailingModel= $this->mailingModel ;
        $ug = $this->ugModel;
        $pagination = $this->pagination ;
//        $orderModel->per_beg = date('Y-m-d', time());
//        $orderModel->per_end = date('Y-m-d', time());

        $orderFilter = $this->orderFilterModel ;
        $currentFilter = $orderFilter->getFilter() ;
        $orderModel->setFilter($currentFilter) ;
        $count = $orderModel->getCount() ;
        $pagination->setTotalRows($count)
            ->setIndexSize($indexSize)
            ->setRowsPerPage($rowsPerPage)
            ->save() ;
        $pageType = Pagination::PAGE_NUM ;
        $limitOffset = $pagination->getLimitOffset($pageType,1) ;
        $limit = $limitOffset['limit'] ;
        $offset = $limitOffset['offset'] ;
        $indexPages = $pagination->getIndexPages() ;

        $getListAction = $this->models[$this->sourceType]['getListAction'] ;

        $orderList = $orderModel->$getListAction($limit,$offset);

        $listItems = [];
        foreach ($orderList as $ind => $orderItem) {
            $listItems[] = $this->orderItemShowPrepare($orderItem) ;

        }
        return [
            'listItems' => $listItems,
            'indexPages' => $indexPages
        ] ;

    }

    /**
     *
     * @param $indexPagesType - это тип номера для пагинации(first|prev|next|last|num)
     * @param $pageNum - действительно только для type = 'num'
     * @return array
     */
    public function getOrderPage($indexPagesType,$pageNum) {
        $paginationClear = false ;     // очистка
        $this->modelsDefine($paginationClear) ;
        $pagination= $this->pagination ;
        $orderModel = $this->orderModel ;
        $limitOffset = $pagination->getLimitOffset($indexPagesType,$pageNum) ;
        $limit = $limitOffset['limit'] ;
        $offset = $limitOffset['offset'] ;

        $indexPages = $pagination->getIndexPages() ;
        $orderFilter = $this->orderFilterModel ;
        $currentFilter = $orderFilter->getFilter() ;
        $orderModel->setFilter($currentFilter) ;

        $getListAction = $this->models[$this->sourceType]['getListAction'] ;

        $orderList = $orderModel->$getListAction($limit,$offset);

        $listItems = [];
        foreach ($orderList as $ind => $orderItem) {
            $listItems[] = $this->orderItemShowPrepare($orderItem) ;

        }
        return [
            'listItems' => $listItems,
            'indexPages' => $indexPages
        ] ;
    }
    /**
     * @param $orderItem -
     * @return array - строка для вывода
     */
    public function getOrderItem($orderItem) {
        $this->modelsDefine() ;
        return $this->orderItemShowPrepare($orderItem) ;
    }

    /**
     * @param $orderItem
     * @return array
     */
    private function orderItemShowPrepare($orderItem) {
        $ug = $this->ugModel;
        $infoFields= $this->infoFields ;
        $item = [];

        $id = $orderItem['id'];
        $lockFlag = ((int)$orderItem['lock_flag'] == true);
        $lockTime = $orderItem['lock_time'];
        $deadlineAnswer = $orderItem['deadline_answer'];
        $deadlineSelect = $orderItem['deadline_select'];
    // поле mailing.stat - существует при  $this->sourceType === 'mailing' ;
        $mailingStat = (isset($orderItem['mailing']['stat'])) ? $orderItem['mailing']['stat'] : '' ;

        $cityId = $orderItem['city_id'] ;
        $ug->setCityId($cityId) ;
        $orderGeography = $ug->getOwnGeography();
        $orderCity = $orderGeography['userCity'];

        $name = $orderItem['order_name'];
        $descript = $orderItem['description'];
        $timeCreate = date('d-m-y', strtotime($orderItem['time_create']));
        $perBeg = date('Y-m-d', strtotime($orderItem['per_beg']));
        $perEnd = date('Y-m-d', strtotime($orderItem['per_end']));
        $item['id'] = $id ;
//   статистика запроса
        $statistic = $this->orderStatistic($id) ;

        $sentTotal = $statistic['sentTotal'] ;
        $answered  = $statistic['answered'] ;
        $isSelected  = $statistic['isSelected'] ;

        $fullName = '№ ' . $id . ' от ' . $timeCreate . ' ' . $name;
        $subItems = [];
        $perText = '<b>' . $infoFields['period'] . ': ' . '</b>' . $perBeg . ' - ' . $perEnd;
        $subItems[] = $perText;
        $subItems[] = '<b>' . $infoFields['description'] . ': ' . '</b>' . $descript;
        $subItems[] = '<b>' . $infoFields['additional'] . ': ' . '</b>' . '0';
        $subItems[] = '<b>' . $infoFields['mailing'] . ': ' . '</b>' . $sentTotal;
        $subItems[] = '<b>' . $infoFields['answers'] . ': ' . '</b>' . $answered;
        if ($isSelected) {
            $subItems[] = '<b>' . $infoFields['selectedYes'] . '</b>';
        } else {
            $subItems[] = '<b>' . $infoFields['selectedNo'] . '</b>';
        }
        $subItems[] = '<b>' . $infoFields['city'] . ': ' . '</b>' . $orderCity['name'];


        return [
            'id' => $id,
            'name' => $fullName,
            'fullyFlag' => false,
            'editFlag' => true,
            'lockFlag' => $lockFlag,
            'lockTime' => $lockTime,
            'deadLineAnswer' => $deadlineAnswer,
            'deadlineSelect' => $deadlineSelect,
            'mailingStat' => $mailingStat,
            'subItems' => $subItems,
        ];

    }
    private function orderStatistic($orderId) {
        $mailingModel= $this->mailingModel ;
        $mailingModel->currentOrderId = $orderId;
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
                case OrderMailing::STAT_SELECTED_ANSWERED :
                    $isSelected = ($value) ? true : false;;
                    break;

            }
        }
        return [
            'sentTotal' => $sentTotal,
            'answered' => $answered,
            'isSelected' => $isSelected,
        ] ;
    }
    //--- адаптер -- //
    public function getDataFirstPage() {
        return $this->getOrderList() ;
    }
    public function getDataOrdinaryPage($indexPageType,$pageNum) {
        return $this->getOrderPage($indexPageType,$pageNum) ;
    }
    public function getDataFull($limit,$operand,$parameter) {

    }
    private function getFullList($limit = 9999999,$offset = 0) {
        $paginationClear = false ;     // очистка
        $this->modelsDefine($paginationClear) ;
        $pagination= $this->pagination ;
        $orderModel = $this->orderModel ;
        $orderFilter = $this->orderFilterModel ;
        $currentFilter = $orderFilter->getFilter() ;
        $orderModel->setFilter($currentFilter) ;

        $getListAction = $this->models[$this->sourceType]['getListAction'] ;

        $orderList = $orderModel->$getListAction($limit,$offset);
        return ['listItems' =>$orderList] ;
    }
    /**
     * получить список заказов, требующих ответа
     * это может быть условием фильтра или
     * использоваться при завершении ответа исполнителя(
     * кнопка переслать в toolbar)
     */
    public function getDataStatReady() {
        $this->sourceType = 'mailing' ;
        $paginationClear = true ;     // очистка
        $this->modelsDefine($paginationClear) ;
        $orderModel = $this->orderModel ;
        $orderFilter = $this->orderFilterModel ;



        $oldFilter = $orderFilter->getFilter() ;
        $orderFilter->setResponseStat(true) ;
        $res = $this->getFullList() ;
// вернуть старый фильтр
        $orderFilter->setFilter($oldFilter) ;
        $orderModel->setFilter($oldFilter) ;
        return $res ;

    }
    public function putOrderStatus($developerId,$orderId,$currentStat,$newStat) {

    }
    public function getCurrentPage() {
        $paginationClear = false;
        $this->modelsDefine($paginationClear);
        $pagination = $this->pagination;
        $indexPages = $pagination->getIndexPages();
        $currentPage = $indexPages['currentPage'];
        return $currentPage ;
    }

}