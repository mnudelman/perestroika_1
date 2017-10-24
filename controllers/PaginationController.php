<?php
/**
 * контроллер перебоора страниц. Используеся ка базовый
 * Time: 21:23
 */

namespace app\controllers;


use yii\web\Controller;
use app\models\Pagination ;
use yii\helpers\Url ;
use yii\helpers\Html ;
use yii\swiftmailer ;
use Yii ;
class PaginationController extends BaseController  {
    protected $FILTER_FORM_NAME = 'app\models\DeveloperOrdersFilterForm' ;
    protected $EXT_FUNC = 'app\controllers\OrderFunc' ;
    protected $VIEW_PREPARE_FUNC = 'app\views\viewParts\OrderViewPrepareByOrder' ;
//-----------------------------------------------------//
    public function actionIndex() {
        return $this->render('index');
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
    protected function sendDataPage($initFlag = false,$indexPageType = -1,$pageNum = -1) {
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

}