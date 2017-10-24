<?php
/**
 *  класс - Сворачиваемый списк
 */

namespace app\components;
use yii\base\Widget;
use Yii;


class PaginationWidget extends Widget {
    public $htmlPrefix = '' ;     // префикс id для обеспечения уникальнгости
    public $indexPages = [1] ;     // список №№ страниц
    public $currentPage = 1 ;
// разрешение/запрет кнопок first,prev,next,last (class="disabled")
    public $firstClass = '';
    public $prevClass = '';
    public $nextClass = '';
    public $lastClass = '';
    //--------------------------------------------------//
    public function init() {
       ob_start();
        $this->tplInclude() ;
        return ob_get_clean();


    }
    public function run() {
        ob_start();
        $this->tplInclude() ;
        return ob_get_clean();
    }

    /**
     * шаблон вывода кнопки - элемента географии(страна | регион | город)
     * @var $typeName = { 'country' | 'region' | 'city'} - тип элемента географии
     * @var $currentName - имя элемента
     * @var $currentId - ид элемента
     * @$itemList - список возможных значений item = ['id' => ..,'name' => ..]
     */
    private function tplInclude() {
        $htmlPrefix = $this->htmlPrefix ;     // префикс id для обеспечения уникальнгости
        $indexPages = $this->indexPages ;     // список №№ страниц
        $currentPage = $this->currentPage ;
// разрешение/запрет кнопок first,prev,next,last (class="disabled")
        $firstClass = $this->firstClass ;
        $prevClass = $this->prevClass;
        $nextClass = $this->nextClass;
        $lastClass = $this->lastClass;
            include __DIR__ . '/tpl/paginationTpl.php' ;


    }
    public static function className() {
        return __CLASS__ ;
    }
}