<?php
/**
 * поддержка контроллера  CommunicationController
 */

namespace app\controllers;


class CommunicationFunc {
    private $currentThemeId = 0 ;
    //-----------------------------------------//
    private $PAGINATION_NAME = 'communication' ;
    private $filterModel = null ;
    private $pagination = null ;    // объект
    private $INDEX_PAGES_SIZE = 3 ; // число ссылок на страницы в pagesIndex
    private $ROW_PER_PAGE = 5 ;     // число выводимых элементов на одной странице
//  ---- атрибуты фильтра --- //
    /**
     * выбор списка
     * данные первой страницы
     * например, при смена фильтра
     */
    public function getDataFirstPage()
    {
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

}