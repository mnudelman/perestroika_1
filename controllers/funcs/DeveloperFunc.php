<?php
/**
 * CДополнительные функции для контроллера DeveloperController
 */

namespace app\controllers\funcs;
use app\models\OrderStatFunc;
use app\models\OrderMailing ;
use app\models\OrderWork ;
use app\service\TaskStore ;
use app\components\UserGeography ;
use app\models\OrderMailingFilterForm ;
use app\models\Pagination ;
use Yii ;
class DeveloperFunc {
    private $currentOrderId = 0 ;
    private $orderWorkDirections = '' ;   // список направлений работ заказа
    private $orderRegion = ['id'=>null,'name'=>null] ; // регион заказа
    private $orderCity = ['id'=>null,'name'=>null] ;   // город заказа
    //-----------------------------------------//
    private $PAGINATION_NAME = 'orderMailing' ;
    private $filterModel = null ;
    private $pagination = null ;    // объект
    private $orderModel ;           // объект класса OrderWork
    private $userGeography ;        // --''---------  UserGeography
    private $totalCount = 0 ;       // общее число записей
    private $INDEX_PAGES_SIZE = 3 ; // число ссылок на страницы в pagesIndex
    private $ROW_PER_PAGE = 5 ;     // число выводимых элементов на одной странице
//  ---- атрибуты фильтра --- //
    private $workRank ;
    private $geographyRank ;
    private $getListCommand = null ;  // команда выборки списка

    public function setOrderId($orderId) {
        if (empty($orderId)) {
            $order = TaskStore::getParam('currentOrder') ;
            if (!empty($order)) {
                $orderId =   $order['orderId'] ;
                $this->currentOrderId = $orderId ;

            }
        }

        $this->currentOrderId = $orderId ;
        if (!empty($orderId)) {
            $this->prepareTables() ;
        }
        return $this ;
    }
    private function getCurrentOrderId() {
        $orderId = $this->currentOrderId ;
        if (empty($orderId)) {
            $order = TaskStore::getParam('currentOrder') ;
            if (!empty($order)) {
                $orderId =   $order['orderId'] ;
                $this->currentOrderId = $orderId ;

            }
        }
        return $orderId ;
    }
    /**
     * выбор списка исполнителей
     * данные первой страницы
     * например, при смена фильтра или при новом заказе
     */
    public function getDataFirstPage()
    {
//        $orderId = $this->currentOrderId;
//            if (empty($orderId)) {
//                $order = TaskStore::getParam('currentOrder') ;
//                if (!empty($order)) {
//                    $orderId =   $order['orderId'] ;
//                    $this->currentOrderId = $orderId ;
//
//                }
//            }
        $this->setOrderId(0) ;                     // таблицы готовятся
        $orderId = $this->currentOrderId;
        $emptyFlag = (empty($orderId)) ;
        $paginationClear = true;
        $this->modelsDefine($paginationClear);
        $pagination = $this->pagination;
        $filter = $this->filterModel;
        $currentFilter = $filter->getFilter();
        $this->setFilter($currentFilter);
        $count = 0 ;
        if (!$emptyFlag) {
            $count = $this->getCount();
        }



        $pagination->setTotalRows($count)
            ->setIndexSize($this->INDEX_PAGES_SIZE)
            ->setRowsPerPage($this->ROW_PER_PAGE)
            ->save();
        $indexPagesType = Pagination::PAGE_NUM;   //
        $limitOffset = $pagination->getLimitOffset($indexPagesType, 1);
        $limit = $limitOffset['limit'];
        $offset = $limitOffset['offset'];
//        $indexPages = $pagination->getIndexPages();
        // выбрать список   -//
        $list = [] ;
        if (!$emptyFlag) {
            $list = $this->getList($limit, $offset);
        }
//        $schema = Yii::$app->db->getSchema() ;
//        $table =  Yii::$app->db->getTableSchema('dev_order_rank_tmp') ;
//        $r = Yii::$app->db->createCommand('show tables')->queryAll() ;
         return [
            'listItems' => $this->listFieldsPrepareForShow($list),
            'indexPages'=> $pagination->getIndexPages(),
        ] ;

    }
    /**
     * выбор списка исполнителей
     * данные любой страницы после первого выбора
     * @param $indexPagesType - это тип номера для пагинации(first|prev|next|last|num)
     * @param $pageNum - действительно только для type = 'num'
     * @return array
     */
    public function getDataOrdinaryPage($indexPagesType,$pageNum) {
//        $schema = Yii::$app->db->getSchema() ;
        $table =  Yii::$app->db->getTableSchema('dev_order_rank_tmp') ;
//        $r = Yii::$app->db->createCommand('show tables')->queryAll() ;
        if (empty($table)) {         // нет таблицы - надо возобновить
            $this->setOrderId(0) ;
        }
        $paginationClear = false;
        $this->modelsDefine($paginationClear);
        $filter = $this->filterModel;
        $currentFilter = $filter->getFilter();
        $this->setFilter($currentFilter);




        $pagination = $this->pagination;
        $limitOffset = $pagination->getLimitOffset($indexPagesType,$pageNum);
        $limit = $limitOffset['limit'];
        $offset = $limitOffset['offset'];
        // выбрать список   -//
//        $this->prepareTables() ;   ///  ????
        $list = $this->getList($limit, $offset);
        return [
            'listItems' => $this->listFieldsPrepareForShow($list),
            'indexPages'=> $pagination->getIndexPages(),
        ] ;
    }

    /**
     * полный список без разбиения на страницы
     * например для рассылки
     * @return array
     */
    public function getDataFull($limit = 100,$operand='>=',$orderStatMin= 0) {
//        $schema = Yii::$app->db->getSchema() ;
        $table =  Yii::$app->db->getTableSchema('dev_order_rank_tmp') ;
//        $r = Yii::$app->db->createCommand('show tables')->queryAll() ;
        if (empty($table)) {         // нет таблицы - надо возобновить
            $this->setOrderId(0) ;
        }
        $paginationClear = false;
        $this->modelsDefine($paginationClear);
        $filter = $this->filterModel;
        $currentFilter = $filter->getFilter();
        $this->setFilter($currentFilter);
        $offset = 0 ;
        // выбрать список   -//
//        $this->prepareTables() ;   ///  ????
        $list = $this->getList($limit, $offset,$operand,$orderStatMin);
        return [
            'listItems' => $list] ;
    }

    /**
     * установить/отменить выбранного исполнителя
     * 1. убрать прежнего
     * 2. поставить текущего
     * 3. перевывести тек страницу
     * если есть выбранный исполнитель, то проверять deadline
     * @param $developerId
     *
     */
    private function putOrderSelected($developerId,$currentStat) {
        $orderId = $this->getCurrentOrderId() ;
        $lSelectedReadyListItems = [] ;
        $lSelectedListItems = [] ;
        $lSelectedReady = $this->getDataFull(1,'=',OrderStatFunc::STAT_SELECTED_READY) ;
        if (is_array($lSelectedReady)) {
            $lSelectedReadyListItems = $lSelectedReady['listItems'] ;
        }


        $lSelected= $this->getDataFull(1,'>=',OrderStatFunc::STAT_SELECTED) ;
        if (is_array($lSelected)) {
            $lSelectedListItems = $lSelected['listItems'] ;
        }


        $prevDeveloperId = null ;
        $message = [] ;
        $success  = true ;
        if (sizeof($lSelectedListItems) > 0) {        // есть выбранные
            $success = false ;
            $company = $lSelectedListItems[0]['profile_company'] ;
            $message[] = 'Вы ОТПРАВИЛИ предложение ВЫПОЛНИТЬ ЗАКАЗ компании ' .
                $company . '. Время рассмотрения не вышло.' .
                'Выбор нового исполнителя невозможен.' ;

        }  else {
            $prevDeveloperId = (sizeof($lSelectedReadyListItems) == 0) ? null :
                $lSelectedReadyListItems[0]['userid'];
            $orderMailingModel = new OrderMailing();
            // если значения совпадают, то click вызывает отмену
            $selectedFlag = !empty($prevDeveloperId) &&
                            ($developerId != $prevDeveloperId);
            $newStat = OrderStatFunc::STAT_SELECTED_READY;

            if ($selectedFlag) {    // сбросить прежний выбор
                if (sizeof($lSelectedReadyListItems) > 0) {
                    $company = $lSelectedReadyListItems[0]['profile_company'] ;
                    $message[] = 'Вы ЗАБРАЛИ предложение ВЫПОЛНИТЬ ЗАКАЗ у компании ' .
                        $company  ;

                    $sql = '
                         UPDATE dev_order_rank_tmp
                         SET current_order_stat = :currentStat
                         WHERE userid = :prevDeveloperId
                    ';
                    $commandUpdate = Yii::$app->db->createCommand($sql);
                    $orderMailingModel->addOrderMailing($orderId, $developerId, $newStat);
                    $commandUpdate
                        ->bindValue(':currentStat', $currentStat)
                        ->bindValue(':prevDeveloperId', $prevDeveloperId)
                        ->execute();


                }
            }

        }
        return  [
            'success' => $success,
            'message' => $message,
        ] ;



    }


    /**
     * @param $developerId    - исполнитель
     * @param $currentStat -  тек состояние
     * @param $newStat  - новое состояние
     * @return array
     */
    public function putOrderStatus($developerId,$currentStat,$newStat)
    {
        $table = Yii::$app->db->getTableSchema('dev_order_rank_tmp');
//        $r = Yii::$app->db->createCommand('show tables')->queryAll() ;
        if (empty($table)) {         // нет таблицы - надо возобновить
            $this->setOrderId(0);
        }

        $orderId = $this->getCurrentOrderId();
        $orderMailingModel = new OrderMailing();
        $message = [];
        $success = true;
        // проверить было ли назначение другого исполнителя
        if ($newStat === OrderStatFunc::STAT_SELECTED_READY) {
            $res = $this->putOrderSelected($developerId, $currentStat);
            $message = $res['message'];
            $success = $res['success'];
        }
        if ($success) {
            $sql = '
              UPDATE dev_order_rank_tmp
              SET current_order_stat = :newStat
              WHERE userid = :developerId
              ';
            $commandUpdate = Yii::$app->db->createCommand($sql);
            $orderMailingModel->addOrderMailing($orderId, $developerId, $newStat);
            $commandUpdate
                ->bindValue(':newStat', $newStat)
                ->bindValue(':developerId', $developerId)
                ->execute();
        }

        //  перевывод текущей страницы
//        $paginationClear = false;
//        $this->modelsDefine($paginationClear);
//        $pagination = $this->pagination;
//        $indexPages = $pagination->getIndexPages();
//        $currentPage = $indexPages['currentPage'];
        $currentPage = $this->getCurrentPage() ;
        return [
            'success' => $success,
            'message' => $message,
            'currentPage' => $currentPage
        ];


    }

    public function getCurrentPage() {
        $paginationClear = false;
        $this->modelsDefine($paginationClear);
        $pagination = $this->pagination;
        $indexPages = $pagination->getIndexPages();
        $currentPage = $indexPages['currentPage'];
        return $currentPage ;
    }





    /**
     * список исполнителей меняет имена полей
     * @param $list
     */
    private function listFieldsPrepareForShow($list)
    {
        $res = [];
        foreach ($list as $ind => $item) {
            $res[] = [
                'userId' => $item['userid'],
                'userDateFirst' => $item['user_date_first'],
                'profileCompany' => $item['profile_company'],
                'profileInfo' => $item['profile_info'],
                'profileAvatar' => $item['profile_avatar'],
                'profileCityId' => $item['profile_city_id'],
                'profileCityName' => $item['profile_city_name'],
                'sentCount' => $item['sent_count'],
                'answeredCount' => $item['answered_count'],
                'selectedCount' => $item['selected_count'],
                'currentOrderStat' => $item['current_order_stat'],
                'workDirectionRank' => $item['work_direction_rank'],
                'regionStat' => $item['region_stat'],
                'cityStat' => $item['city_stat'],
                'geographyRank' => $item['geography_rank'],
            ];
        }
        return $res ;
    }
    /**
     * установить фильтр
     * @param $filter = ['workDirectionRank' => <rank%>,'geographyRank' => <rank%>]
     */
    private function setFilter($filter) {
        $this->workRank = $filter['workRank'] ;
        $this->geographyRank = $filter['geographyRank'] ;
    }
    /**
     * число строк в полном списке
     * @return int
     */
    private function getCount() {
        $sql = '
        SELECT count(*) AS count FROM dev_order_rank_tmp
        WHERE work_direction_rank >= :workingRank
              AND geography_rank >= :geographyRank
        ' ;
        $countRes = Yii::$app->db->createCommand($sql)
            ->bindValue(':workingRank',$this->workRank)
            ->bindValue(':geographyRank',$this->geographyRank)
            ->queryOne() ;
        return $countRes['count'] ;
    }
    private function getList($limit,$offset,$operand = '>=',$orderStatMin = 0) {

        $r = Yii::$app->db->createCommand('SELECT * FROM dev_order_rank_tmp')->queryAll() ;


        $sql =
            'SELECT * FROM dev_order_rank_tmp
             WHERE work_direction_rank >= :workingRank
                   AND geography_rank >= :geographyRank
                   AND current_order_stat' . $operand . $orderStatMin .
             ' LIMIT :limit
             OFFSET :offset
        ';
        $workingRank = $this->workRank ;
        $geographyRank = $this->geographyRank ;

        $command = Yii::$app->db->createCommand($sql)
            ->bindValue(':workingRank',$workingRank)
            ->bindValue(':geographyRank',$geographyRank)
            ->bindValue(':limit',$limit)
            ->bindValue(':offset',$offset);

        $list = $command->queryAll() ;
        return $list ;
    }
    /**
     * используется чтобы избежать повторное размещение
     * @param bool $paginationClear - сбросить счетчик страниц Иначе продолжить
     */
    private function modelsDefine($paginationClear = false) {
        if ($this->filterModel === null) {
            $this->filterModel = new OrderMailingFilterForm() ;
            $this->pagination = new Pagination($this->PAGINATION_NAME,$paginationClear) ;
            $this->orderModel = new OrderMailing() ;
            $this->userGeography = new UserGeography() ;
         }
    }
    /**
     * подготовить таблицы
     */
    private function prepareTables() {
        $this->createOrderWorkTable() ;
        $this->createOrderCountWorkTable() ;

        $this->getDevOrderTable() ;

        return [] ;
    }
    private function createOrderWorkTable() {
      $r =  Yii::$app->db->createCommand(
           'CREATE TEMPORARY TABLE IF NOT EXISTS order_work_tmp
             (work_direction_id INTEGER,
              work_item_id INTEGER,
              fully_flag INTEGER
             )'
       )->execute() ;
        $table = Yii::$app->db->getTableSchema('order_work_tmp');

        $r = Yii::$app->db->createCommand('SELECT * from order_work_tmp')->queryAll() ;
        $this->prepareOrderWork() ;     // загрузить данные
    }
    private function createOrderCountWorkTable() {
//        $drop = Yii::$app->db->createCommand()->dropTable('order_work_count_tmp') ;
        $r =  Yii::$app->db->createCommand(
            'CREATE TEMPORARY TABLE IF NOT EXISTS order_work_count_tmp
             (work_direction_id INTEGER,
              item_count INTEGER
             )'
        )->execute() ;
        $table = Yii::$app->db->getTableSchema('order_work_count_tmp');

        $r = Yii::$app->db->createCommand('SELECT * from order_work_count_tmp')->queryAll() ;
        $this->prepareOrderWorkCount() ;

    }
    private function prepareOrderWorkCount() {
        $countRec = Yii::$app->db->createCommand('
         SELECT work_direction_id,count(*) as item_count
         FROM order_work_tmp
         GROUP BY work_direction_id
        ')
            ->queryAll();
        Yii::$app->db->createCommand()->truncateTable('order_work_count_tmp')->execute() ;

        $r = Yii::$app->db->createCommand('
         SELECT *
         FROM order_work_count_tmp
         ')->queryAll();

        $insertList = [] ;

        foreach($countRec as $key=>$rec) {
            $insertItem = [$rec['work_direction_id'],$rec['item_count']] ;
            $insertList[] = $insertItem ;
        }
        Yii::$app->db->createCommand()->batchInsert('order_work_count_tmp',
            ['work_direction_id','item_count'],$insertList)->execute() ;
        $r = Yii::$app->db->createCommand('SELECT * from order_work_count_tmp')->queryAll() ;

    }
    private function prepareOrderWork()
    {

//   сначала для заказа направления с полным списом работ(fully_flag = 1)
        $fullyWorkDirectionList = Yii::$app->db->createCommand('
         SELECT
         owd.work_direction_id,
         owd.fully_flag,
         wi.id as work_item_id
         FROM order_work_direction owd,work_item wi
         WHERE owd.order_id = :order_id AND owd.fully_flag = 1 AND
               owd.work_direction_id = wi.work_direction_id
        ')
            ->bindValue(':order_id',$this->currentOrderId)
            ->queryAll();
   // направления с заданным списком работ (fully_flag = 0)
        $workItemsList = Yii::$app->db->createCommand('
         SELECT
         owd.work_direction_id,
         owd.fully_flag,
         owi.work_item_id
         FROM order_work_direction owd,order_work_item owi
         WHERE owd.order_id = :order_id AND owd.fully_flag = 0 AND
               owd.id = owi.order_work_direction_id
        ')
            ->bindValue(':order_id',$this->currentOrderId)
            ->queryAll();

        Yii::$app->db->createCommand()->truncateTable('order_work_tmp')->execute() ;
        $insertList = [] ;
// оба списка грузим order_work_tmp
         foreach($fullyWorkDirectionList as $key=>$rec) {
             $insertItem = [$rec['work_direction_id'],$rec['work_item_id'],$rec['fully_flag']] ;
             $insertList[] = $insertItem ;
         }
         Yii::$app->db->createCommand()->batchInsert('order_work_tmp',
          ['work_direction_id','work_item_id','fully_flag'],$insertList)->execute() ;

        $insertList = [] ;
        foreach($workItemsList as $key=>$rec) {
            $insertItem = [$rec['work_direction_id'],$rec['work_item_id'],$rec['fully_flag']] ;
            $insertList[] = $insertItem ;
        }
        Yii::$app->db->createCommand()->batchInsert('order_work_tmp',
            ['work_direction_id','work_item_id','fully_flag'],$insertList)->execute() ;
        $r = Yii::$app->db->createCommand('SELECT * from order_work_tmp')->queryAll() ;

    }

    /**
     * таблицы Исполнитель-заказ
     * Исполнителей подбираем по условию: перчень направлений должен
     * совпадать с перечнем направлений заказа. - это первое условие
     * Далее вычисляется степень совпадения по списку работ ( в %).
     * Т.е. допускается не полное совпадение по списку работ (уровень задаётся)
     */
    private function getDevOrderTable()
    {
        $res = Yii::$app->db->createCommand()->dropTable('dev_order_work_count_tmp') ;
        $r = Yii::$app->db->createCommand(
            'CREATE TEMPORARY TABLE IF NOT EXISTS dev_order_work_count_tmp
             (userid INTEGER,
             work_direction_id INTEGER,           -- навправление работ
             work_direction_name  VARCHAR(255),
              item_count INTEGER,     -- количество работ в направлении (исполнителя)
              order_item_count INTEGER -- количество работ в направлении (заказа)
             )'
        )->execute();
//  таблица оценок
//        $res = Yii::$app->db->createCommand()->dropTable('dev_order_rank_tmp') ;
        $r = Yii::$app->db->createCommand(
            'CREATE TEMPORARY TABLE IF NOT EXISTS dev_order_rank_tmp
             (userid INTEGER,
              user_date_first TIMESTAMP,          -- время регистрация
             profile_company VARCHAR(255),        -- данные из профиля
             profile_info VARCHAR(255),
             profile_avatar VARCHAR(100),
             profile_email VARCHAR (100),
             profile_tel VARCHAR (20),
             profile_city_id INTEGER ,
             profile_city_name VARCHAR(100),
             profile_confirmation_key VARCHAR (10),
              sent_count INTEGER,       -- статистика исполнителя:приглашений всего
              answered_count INTEGER,   -- число согласий на выполнение
              selected_count INTEGER,   -- выбран исполнителем всего
              current_order_stat INTEGER DEFAULT 0,   -- стаус по тек заказу
              work_direction_rank INTEGER ,     -- сумарная оценка по направл работ (%)
              region_stat INTEGER DEFAULT 0,    -- 1 если регион совпадает
              city_stat INTEGER DEFAULT 0,      -- 1 если город совпадает
              geography_rank INTEGER            -- оценка географии(100% - город| 50% - регион
             )'
        )->execute();
//        $table = Yii::$app->db->getTableSchema('dev_order_work_count_tmp');
        $table =  Yii::$app->db->getTableSchema('dev_order_rank_tmp') ;
        $r = Yii::$app->db->createCommand('show tables')->execute() ;

        Yii::$app->db->createCommand()->truncateTable('dev_order_work_count_tmp')->execute();

        Yii::$app->db->createCommand()->truncateTable('dev_order_rank_tmp')->execute();

        $this->makeOrderWorkDirections() ;  //  список направлений заказа
        $this->uploadDevWorkDirections() ;  // загрузить направления работ по исполнителям
        $this->putWorkItemCountForOrder() ; // поле - кол работ по направлению для заказа
        $this->addDirectionsFromOrder() ;   // добавить недостающие направления из заказа

        $this->putDataIntoDevOrderrank() ;

        $this->putNameFields() ;            // поставить имена из profile, имена направлений
        $this->putStatistic() ;             // поля статистики по всем заказам
        $this->putWorkDirectionrank() ;         // оценка по тек заказу

//       География
        $this->getOrderGeography() ;        // география заказа
        $this->putGeographyrank() ;         // оценка географии
        $this->putOrderStat() ;             // поле - состояние тек заказа


        $this->insertOrderMailing() ;       // добавить строки в таблицу рассылки
        $r = Yii::$app->db->createCommand('SELECT * from dev_order_rank_tmp')->queryAll() ;
    }

    /**
     * @return string - список направлений заказа в виде строки cod1,cjd2,...,codN
     */
    private function makeOrderWorkDirections() {
        $directions = Yii::$app->db->createCommand('
        SELECT DISTINCT work_direction_id FROM order_work_tmp')->queryAll();
        $directionsList = '';
        foreach ($directions as $ind => $item) {
            $id = $item['work_direction_id'];
            $directionsList .= ((strlen($directionsList) == 0) ? '' : ',') . $id;
        }
        $this->orderWorkDirections = $directionsList;
        return $directionsList;
    }

    /**
     * среди исполнителей выбираем тех, которые имеют такой же список направлений
     * $sql1 -  исполнители имеющие полный список работ по направлению(fully_flag = 1)
     * $sql2 -  исполнители имеющие не полный список работ по направлению(fully_flag = 0)
     */
    private function uploadDevWorkDirections()
    {
        $directionsList = $this->orderWorkDirections;
        $directionsList = (empty($directionsList)) ? '0' : $directionsList ;
        $sql1 = '
        SELECT dwd.userid,
               dwd.work_direction_id,
               wi.id as work_item_id
        FROM developer_work_direction dwd,
              work_item wi
        WHERE dwd.fully_flag = 1
              AND dwd.work_direction_id IN (' . $directionsList . ')
              AND dwd.work_direction_id = wi.work_direction_id

        ';
        $command1 = Yii::$app->db->createCommand($sql1) ;
        $r1 = $command1->queryAll() ;

        $sql2 = '
        SELECT dwd.userid,
               dwd.work_direction_id,
               dwi.id as work_item_id
        FROM developer_work_direction dwd,
              developer_work_item dwi
        WHERE dwd.fully_flag = 0
               AND dwd.work_direction_id IN (' . $directionsList . ')
              AND dwd.id = dwi.developer_work_direction_id
        ';
        $command2 = Yii::$app->db->createCommand($sql2) ;
        $r2 = $command2->queryAll() ;

        $sqlT1 = 'SELECT dwf.*,order_work_tmp.work_item_id as work_item_id_1
                FROM (' . $sql1 . ') dwf
                LEFT JOIN order_work_tmp ON order_work_tmp.work_item_id = dwf.work_item_id';
//        $command = Yii::$app->db->createCommand($sqlT1) ;
//        $rec = $command->queryAll() ;

        $sqlSum1 = 'SELECT dwt.userid,dwt.work_direction_id,
                   SUM(IF(dwt.work_item_id,1,0)) AS item_count
                   FROM (' . $sqlT1 . ') dwt
                   GROUP BY userid,work_direction_id
                   ';
        $commandSum1 = Yii::$app->db->createCommand($sqlSum1);
        $recSum1 = $commandSum1->queryAll();


        $sqlT2 = 'SELECT dwf.*,order_work_tmp.work_item_id as work_item_id_1
                FROM (' . $sql2 . ') dwf
                LEFT JOIN order_work_tmp ON order_work_tmp.work_item_id = dwf.work_item_id';
//        $command = Yii::$app->db->createCommand($sqlT2) ;
//        $rec = $command->queryAll() ;

        $sqlSum2 = 'SELECT dwt.userid,dwt.work_direction_id,
                   SUM(IF(dwt.work_item_id,1,0)) AS item_count
                   FROM (' . $sqlT2 . ') dwt
                   GROUP BY userid,work_direction_id
                   ';
        $commandSum2 = Yii::$app->db->createCommand($sqlSum2);
        $recSum2 = $commandSum2->queryAll();

//  добавляем полные направления
        $insertList = [];
        foreach ($recSum1 as $key => $rec) {
            $insertItem = [$rec['userid'], $rec['work_direction_id'], $rec['item_count']];
            $insertList[] = $insertItem;
        }
        Yii::$app->db->createCommand()->batchInsert('dev_order_work_count_tmp',
            ['userid', 'work_direction_id', 'item_count'], $insertList)->execute();
//        $r = Yii::$app->db->createCommand('SELECT * from dev_order_work_count_tmp')->queryAll() ;
//  по неполным направлениям
        $insertList = [];
        foreach ($recSum2 as $key => $rec) {
            $insertItem = [$rec['userid'], $rec['work_direction_id'], $rec['item_count']];
            $insertList[] = $insertItem;
        }
        Yii::$app->db->createCommand()->batchInsert('dev_order_work_count_tmp',
            ['userid', 'work_direction_id', 'item_count'], $insertList)->execute();
//        $r = Yii::$app->db->createCommand('SELECT * from dev_order_work_count_tmp')->queryAll() ;

// !! список исполнителей по заказу собран. Теперь будем доопределять поля таблицы

    }

    /**
     * по каждому направлению заносим количество работ для текущего заказа
     */
    private function putWorkItemCountForOrder()
    {
        $sqlUpdate = '
        UPDATE dev_order_work_count_tmp devOrder
        LEFT JOIN  order_work_count_tmp orderWork
              ON devOrder.work_direction_id = orderWork.work_direction_id
        SET devOrder.order_item_count = orderWork.item_count
        ';
        $sqlUpdate = Yii::$app->db->createCommand($sqlUpdate)->execute();
//        $r = Yii::$app->db->createCommand('SELECT * from dev_order_work_count_tmp')->queryAll() ;
    }

    /**
     * добавить недостающие направления из заказа
     */
    private function addDirectionsFromOrder()
    {
        // клон таблицы создаём, чтобы не использовать временную таблицу в подзапросе
        $sqlClone = 'CREATE TEMPORARY TABLE IF NOT EXISTS dev_order_work_clone
                     SELECT * FROM dev_order_work_count_tmp';;
        $cloneCreate = Yii::$app->db->createCommand($sqlClone)->execute();

        $sqlAdd = '
        SELECT DISTINCT d_order.userid,
               workOrder.work_direction_id, 0 as item_count,
               workOrder.item_count as order_item_count
        FROM  order_work_count_tmp workOrder,
              dev_order_work_count_tmp d_order
        WHERE workOrder.work_direction_id NOT IN (
              SELECT work_direction_id FROM dev_order_work_clone devClone
                     WHERE devClone.userid = d_order.userid
                     )
        ';

        $recAdd = Yii::$app->db->createCommand($sqlAdd)->queryAll();

        $insertList = [];
        foreach ($recAdd as $key => $rec) {
            $insertItem = [$rec['userid'], $rec['work_direction_id'],
                $rec['item_count'], $rec['order_item_count']];
            $insertList[] = $insertItem;
        }
        Yii::$app->db->createCommand()->batchInsert('dev_order_work_count_tmp',
            ['userid', 'work_direction_id', 'item_count', 'order_item_count'], $insertList)->execute();
// чистка значений для случая, когда исполнитель имеет полный список работ по направлению
// а в заказе задан неполный список
        $sqlUpdate = '
        UPDATE dev_order_work_count_tmp devOrder
        SET devOrder.item_count = devOrder.order_item_count
        WHERE devOrder.item_count > devOrder.order_item_count
        ';
        $recMin = Yii::$app->db->createCommand($sqlUpdate)->execute();
//        $r = Yii::$app->db->createCommand('SELECT * from dev_order_work_count_tmp')->queryAll() ;
    }

    /**
     * первичное заполнение таблицы dev_order_rank_tmp
     */
    private function putDataIntoDevOrderrank() {
        $sqlInsert = '
        SELECT DISTINCT userid FROM dev_order_work_count_tmp
        ' ;
        $recInsert =  Yii::$app->db->createCommand($sqlInsert)->queryAll();

        $insertList = [];
        foreach ($recInsert as $key => $rec) {
            $insertItem = [$rec['userid']] ;
            $insertList[] = $insertItem;
        }
        Yii::$app->db->createCommand()->batchInsert('dev_order_rank_tmp',
            ['userid'], $insertList)->execute();
        $r = Yii::$app->db->createCommand('SELECT * FROM dev_order_rank_tmp')->queryAll() ;
    }
    /**
     *  поставить имена из profile, work_direction - список направлений
     */
    private function putNameFields()
    {
        $sqlUpdate = '
        UPDATE dev_order_rank_tmp devOrder
        LEFT JOIN  userprofile profile
             ON devOrder.userid = profile.userid
        LEFT JOIN user ON user.id = devOrder.userid
        SET devOrder.user_date_first = user.date_first,
            devOrder.profile_company = profile.company,
            devOrder.profile_info = profile.info,
            devOrder.profile_avatar = profile.avatar,
            devOrder.profile_city_id = profile.city_id,
            devOrder.profile_email = profile.email,
            devOrder.profile_tel = profile.tel,
            devOrder.profile_confirmation_key = profile.confirmation_key
        ';
        $sqlUpdate = Yii::$app->db->createCommand($sqlUpdate)->execute();
//        $r = Yii::$app->db->createCommand('SELECT * from dev_order_work_count_tmp')->queryAll() ;
//      имя города

        $sqlCityNameUpdate = '
        UPDATE dev_order_rank_tmp devOrder
        LEFT JOIN  city
             ON devOrder.profile_city_id = city.id
        SET devOrder.profile_city_name = city.name
        ';
        $sqlUpdate = Yii::$app->db->createCommand($sqlCityNameUpdate)->execute();



        $sqlUpdate = '
        UPDATE dev_order_work_count_tmp devOrder
        LEFT JOIN  work_direction wD
              ON devOrder.work_direction_id = wD.id
        SET devOrder.work_direction_name = wD.name
        ';
        $sqlUpdate = Yii::$app->db->createCommand($sqlUpdate)->execute();


    }

    /**
     *  Собираем статистику по исполнителям по всем заказам
     */
    private function putStatistic()
    {
        $sqlStat = '
        SELECT developer_id,
        SUM(IF(stat >= :statSent,1,0)) AS sent_count,          -- приглашений
        SUM(IF(stat >= :statAnswered,1,0)) AS answered_count,  -- подтверждений
        SUM(IF(stat >= :statSelected,1,0)) AS selected_count   -- выбран исполнителем
        FROM order_mailing
        WHERE developer_id IN (SELECT userid FROM  dev_order_work_clone)
        GROUP BY developer_id
        ';
//        $statRec = Yii::$app->db->createCommand($sqlStat)
//            ->bindValue(':statSent',OrderMailing::STAT_SENT)
//            ->bindValue(':statAnswered',OrderMailing::STAT_ANSWERED)
//            ->bindValue(':statSelected',OrderMailing::STAT_SELECTED)
//            ->queryAll() ;

        $sqlStatUpdate = '
        UPDATE dev_order_rank_tmp devOrder
        LEFT JOIN  (' . $sqlStat . ') orderStat
              ON devOrder.userid = orderStat.developer_id
        SET devOrder.sent_count = orderStat.sent_count,
        devOrder.answered_count = orderStat.answered_count,
        devOrder.selected_count = orderStat.selected_count
        ';
        $sqlUpdate = Yii::$app->db->createCommand($sqlStatUpdate)
            ->bindValue(':statSent', OrderStatFunc::STAT_SENT)
            ->bindValue(':statAnswered', OrderStatFunc::STAT_ANSWERED)
            ->bindValue(':statSelected', OrderStatFunc::STAT_SELECTED)
            ->execute();
//        $r = Yii::$app->db->createCommand('SELECT * from dev_order_work_count_tmp')
//            ->queryAll() ;

    }

    /**
     * оценка по текущему заказу
     */
    private function putWorkDirectionrank() {
        $sqlOrderrank = '
        SELECT userid,AVG(item_count/order_item_count) AS avg_rank
        FROM dev_order_work_count_tmp
        GROUP BY userid
        ';

        $sqlOrderrankUpdate = '
        UPDATE dev_order_rank_tmp devOrder
        LEFT JOIN  (' . $sqlOrderrank . ') orderrank
              ON devOrder.userid = orderrank.userid
        SET work_direction_rank = orderrank.avg_rank * 100
        ';
        $sqlUpdate = Yii::$app->db->createCommand($sqlOrderrankUpdate)
            ->execute();
    }
    /**
     * получить регион и город заказа
     */
    private function getOrderGeography() {


        $orderAttr = (new OrderWork())->getById($this->currentOrderId);
//        $orderAttr = $this->orderModel->getById($this->currentOrderId);
        $cityId = $orderAttr->city_id;
        $geography = (new UserGeography())->setCityId($cityId)->getOwnGeography();
//        $geography = $this->userGeography->setCityId($cityId)->getOwnGeography();
        $this->orderRegion = $geography['userRegion'];
        $this->orderCity = $geography['userCity'];
    }
    /**
     * оценка по географии
     * Если у исполнителя есть городЗаказа, то 100%
     * Иначе Если у исполнителя есть регионЗаказа, то 50%
     * Иначе 0%
     */
    private function putGeographyrank() {
        $orderRegionId = $this->orderRegion['id'] ;
        $orderCityId = $this->orderCity['id'] ;
        $sqlRegion = '
        SELECT wc.userid
        FROM work_country wc,work_region wr
        WHERE wc.userid IN (SELECT userid FROM dev_order_work_count_tmp)
              AND wr.work_country_id = wc.id
              AND wr.region_id = :orderRegionId
        ' ;

        $r = Yii::$app->db->createCommand($sqlRegion)
            ->bindValue(':orderRegionId', $orderRegionId)
            ->queryAll();

        $sqlRegionrank = '
        UPDATE dev_order_rank_tmp devOrder
        LEFT JOIN  (' . $sqlRegion . ') regionStat
              ON devOrder.userid = regionStat.userid
        SET region_stat = IF(regionStat.userid,1,0)
        ';
        $sqlUpdate = Yii::$app->db->createCommand($sqlRegionrank)
            ->bindValue(':orderRegionId', $orderRegionId)
            ->execute();

        $r = Yii::$app->db->createCommand('SELECT * FROM dev_order_rank_tmp')
            ->queryAll();





        $sqlCity = '
        SELECT wc.userid
        FROM work_country wc,work_region wr,work_city wcity
        WHERE wc.userid IN (SELECT userid FROM dev_order_work_count_tmp)
              AND wr.work_country_id = wc.id
              AND wcity.work_region_id = wr.id
              AND wcity.city_id = :orderCityId
        ' ;
        $sqlCityrank = '
        UPDATE dev_order_rank_tmp devOrder
        LEFT JOIN  (' . $sqlCity . ') cityStat
              ON devOrder.userid = cityStat.userid
        SET city_stat = IF(cityStat.userid,1,0)
        ';
        $sqlUpdate = Yii::$app->db->createCommand($sqlCityrank)
            ->bindValue(':orderCityId', $orderCityId)
            ->execute();
//  итоговый ранг географии
        $sqlGeography = '
        UPDATE dev_order_rank_tmp devOrder
        SET geography_rank =
        CASE
           WHEN city_stat = 1 THEN 100
           WHEN  city_stat = 0 THEN region_stat * 50
           ELSE 0
        END
        ' ;
        $sqlUpdate = Yii::$app->db->createCommand($sqlGeography)
            ->execute();
         $r = Yii::$app->db->createCommand('SELECT * FROM dev_order_rank_tmp')->queryAll() ;

    }

    /**
     * готовим добавление в БД (order_mailing) по текущему заказу
     * добавляются только исполнители, у которых средний рейтинг по направлениям
     * превышает установленный  min (напр, 50 (%) означает, что испонитель способен выполнить
     * не меньше половины всех работ, заданных в заказе)
     */
    private function insertOrderMailing()
    {
        $r =  Yii::$app->db->createCommand()->truncateTable('order_mailing') ; // !!!?????
        $r1 = Yii::$app->db->createCommand('SELECT * FROM order_mailing')->queryAll() ;
        $r2 = Yii::$app->db->createCommand('SELECT * FROM dev_order_rank_tmp')->queryAll() ;


        $sqlInsert = '
        SELECT userid FROM dev_order_rank_tmp
        WHERE userid NOT IN (SELECT developer_id FROM order_mailing
                             WHERE order_id = :currentOrderId)
              AND work_direction_rank >= :minTotalrank
              AND geography_rank >= :minGeographyrank
        ';
        $dataInsert = Yii::$app->db->createCommand($sqlInsert)
            ->bindValue(':currentOrderId', $this->currentOrderId)
            ->bindValue(':minTotalrank', OrderStatFunc::MIN_TOTAL_RANK)
            ->bindValue(':minGeographyrank', OrderStatFunc::MIN_GEOGRAPHY_RANK)
            ->queryAll();

        $insertList = [];
        foreach ($dataInsert as $key => $rec) {
            $insertItem = [$this->currentOrderId, $rec['userid'],0];
            $insertList[] = $insertItem;
        }
        Yii::$app->db->createCommand()->batchInsert('order_mailing',
            ['order_id', 'developer_id','stat'], $insertList)->execute();
        $r1 = Yii::$app->db->createCommand('SELECT * FROM order_mailing')->queryAll() ;
        $r2 = Yii::$app->db->createCommand('SELECT * FROM dev_order_rank_tmp')->queryAll() ;

    }

    /**
     *  current_order_stat -  состояние по текущему заказу
     * состояние: см \models\OrderMailing
     */
    private function putOrderStat() {

        $r2 = Yii::$app->db->createCommand('SELECT * FROM dev_order_rank_tmp')->queryAll() ;




        $sqlCurrentStat = '
        SELECT developer_id,stat
        FROM order_mailing
        WHERE order_id = :orderId
        ' ;
        $r1 = Yii::$app->db->createCommand($sqlCurrentStat)
            ->bindValue(':orderId',$this->currentOrderId)
            ->queryAll() ;

        $sqlCurrentStatUpdate = '
        UPDATE dev_order_rank_tmp devOrder
        LEFT JOIN  (' . $sqlCurrentStat .') orderStat
              ON devOrder.userid = orderStat.developer_id
        SET devOrder.current_order_stat = IF(orderStat.stat,orderStat.stat,0)
        ' ;
        $sqlUpdate = Yii::$app->db->createCommand($sqlCurrentStatUpdate)
            ->bindValue(':orderId',$this->currentOrderId)
            ->execute() ;
        $r = Yii::$app->db->createCommand('SELECT * from dev_order_rank_tmp')
            ->queryAll() ;

    }

}