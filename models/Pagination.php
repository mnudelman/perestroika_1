<?php
/**
 * поддержка разбиения на страницы
 */

namespace app\models;
use app\service\TaskStore ;
class Pagination  {
    private $totalRows = 0 ;
    private $rowsPerPage = 15 ;
    private $indexSize = 3 ;    // число ссылок на страницы
    private $currentPage = 1 ;           // текущая страница
    private $paginationName ;        // идентификатор при сохранении/восстановлении
    private $PREFIX_NAME = 'pagination' ;
    private $indexPages = [] ;
    private $minPage = 1 ;
    private $maxPage = 1 ;
    const PAGE_FIRST = 0 ;
    const PAGE_PREV = 1 ;
    const PAGE_NUM = 2 ;
    const PAGE_NEXT = 3 ;
    const PAGE_LAST = 4 ;
    //--------------------------------------------//
    public function __construct($pagName,$clearFlag = false) {
        $this->paginationName = $pagName ;
        if($clearFlag || false === $this->getFromTaskStore()) {  // нет вектора -> создать вектор
            $this->saveToTaskStore() ;
        }

    }
    public function setRowsPerPage($perPage) {
        $this->rowsPerPage = $perPage ;
        return $this ;
    }
    public function setIndexSize($indexSize) {
        $this->indexSize = $indexSize ;
        return $this ;
    }
    public function setTotalRows($total) {
        $this->totalRows = $total ;
        return $this ;
    }
    public function save() {
        $this->saveToTaskStore() ;
        return $this ;
    }
    private function saveToTaskStore() {
        $vect = $this->getAttributeVect() ;
        $vectName = $this->getVectName() ;
        TaskStore::putParam($vectName,$vect) ;
        return $this ;
    }
    private function getVectName() {
        return $this->PREFIX_NAME .'-' . $this->paginationName ;
    }
    private function getAttributeVect()
    {
        return [
            'totalRows' => $this->totalRows,
            'perPage' => $this->rowsPerPage,
            'indexSize' => $this->indexSize,
            'currentPage' => $this->currentPage,
            'indexPages' => $this->indexPages ,
        ];
    }
    private function getFromTaskStore() {
        $vectName = $this->getVectName() ;
        $vect = TaskStore::getParam($vectName) ;
        if (is_null($vect)) {
            return false ;
        }
            $this->totalRows = $vect['totalRows'] ;
            $this->rowsPerPage = $vect['perPage'] ;
            $this->indexSize = $vect['indexSize'] ;
            $this->currentPage = $vect['currentPage'] ;
            $this->indexPages = $vect['indexPages'] ;

        $this->maxPage = floor($this->totalRows/$this->rowsPerPage) ;
        if ($this->rowsPerPage * $this->maxPage  < $this->totalRows) {
            $this->maxPage++ ;
        }
        return true ;
    }
    private function indexPagesClc() {
        $currentPage = $this->currentPage ;
        $indexPages = $this->indexPages ;
        if (sizeof($indexPages) === 0) {
            for ($i = 0; $i < $this->indexSize ; $i++) {
                $indexPages[] = ($i+1 <= $this->maxPage) ? $i+1 : -1 ;
            }
        }
        if ($currentPage < $indexPages[0]) {
            $indexPages[0] = $currentPage ;
            for ($i = 1; $i < sizeof($indexPages); $i++) {
                $newPage = $indexPages[$i-1] + 1 ;
                $indexPages[$i] = ($newPage <= $this->maxPage) ? $newPage : -1 ;
            }
        }
        $lastNum = sizeof($indexPages) - 1 ;
        $lastValue = $indexPages[$lastNum] ;
        if ($lastValue > 0 && $currentPage > $lastValue) {
            $indexPages[$lastNum] = $currentPage ;
            for ($i = $lastNum - 1; $i >= 0; $i--) {
                $newPage = $indexPages[$i+1] -1 ;
                $indexPages[$i] = ($newPage >= $this->minPage) ? $newPage : -1 ;
            }
        }
        $this->indexPages = $indexPages ;
    }
    public function getLimitOffset($pageType,$pageNum) {
        $currentFlag = $this->getFromTaskStore() ;
        switch ($pageType) {
            case (self::PAGE_FIRST) :
                $this->currentPage = 1 ;
                break ;
            case (self::PAGE_PREV) :
                $this->currentPage-- ;
                break ;
            case (self::PAGE_NUM) :
                if ($pageNum < 0 && $currentFlag) {
                    $pageNum = $this->currentPage ;
                }
                $this->currentPage = $pageNum ;
                break ;

            case (self::PAGE_NEXT) :
                $this->currentPage++ ;
                break ;
            case (self::PAGE_LAST) :
                $this->currentPage = $this->maxPage  ;
                break ;
        }
        $this->currentPage = min($this->currentPage,$this->maxPage) ;
        $this->currentPage = max($this->currentPage,$this->minPage) ;
        $this->saveToTaskStore() ;
        $limit = $this->rowsPerPage ;
        $offset = ($this->currentPage - 1) * $this->rowsPerPage ;
        return [
            'limit'  => $limit,
            'offset' => $offset,
        ] ;
    }
    public function getIndexPages() {
        $this->getFromTaskStore() ;
        $this->indexPagesClc() ;
        $leftDirect = ($this->minPage != $this->currentPage) ;
        $rightDirect = ($this->maxPage != $this->currentPage) ;
        return [
            'currentPage' => $this->currentPage,
            'firstFlag' => $leftDirect,    // ссылка на первую  страницу
            'prevFlag' => $leftDirect,     // ссылка на предшеств  страницу
            'indexPages' => $this->indexPages,
            'nextFlag' => $rightDirect,    // ссылка на след  страницу
            'lastFlag' => $rightDirect,    // ссылка на последнюю страницу
        ] ;
    }
}