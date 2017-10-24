<?php
/**
 * аналог broadCrumbs - хлебные крошки
 */

namespace app\models;
use app\service\TaskStore ;

/**
 * Class MenuPath
 * в списке $menuItems в качестве ключа использовать controllerId
 * @package app\models
 */
class MenuPath {
    private $menuPath = [] ;     // фактический путь
    private $rootItem = 'site' ;  // корневой элемент
    private  $menuItems = [ // связь пунктов меню текущий- предшествующий
        'site' => [
            'url' => 'site/index',          // url пункта меню
            'name' => 'Главная',         // имя для вывода
            'prevItem' => null, // ссылка на ид предшествующего узла
            'menuBlockId' => '', // блок меню
        ],
        'order' => [
            'url' => 'order/index',          // url пункта меню
            'name' => 'Заказ',         // имя для вывода
            'prevItem' => 'site', // ссылка на ид предшествующего узла
            'menuBlockId' => '', // блок меню
        ],
        'developer' => [
            'url' => 'developer/index',          // url пункта меню
            'name' => 'Профиль',         // имя для вывода
            'prevItem' => 'site', // ссылка на ид предшествующего узла
            'menuBlockId' => '', // блок меню
        ],
        'office' => [
            'url' => '#',          // url пункта меню
            'name' => 'Кабинет',         // имя для вывода
            'prevItem' => 'site', // ссылка на ид предшествующего узла
            'menuBlockId' => 'officeTabHeader', // ид блок меню
        ],
        'officeOrder' => [
            'url' => '#',          // url пункта меню
            'name' => 'Я - заказчик',         // имя для вывода
            'prevItem' => 'office', // ссылка на ид предшествующего узла
            'menuBlockId' => 'officeTabHeader', // блок меню
        ],
        'officeDeveloper' => [
            'url' => '#',          // url пункта меню
            'name' => 'Я - исполнитель',         // имя для вывода
            'prevItem' => 'office', // ссылка на ид предшествующего узла
            'menuBlockId' => 'officeTabHeader', // блок меню
        ],
        'officeProfile' => [
            'url' => '#',          // url пункта меню
            'name' => 'Мой профиль',         // имя для вывода
            'prevItem' => 'office', // ссылка на ид предшествующего узла
            'menuBlockId' => 'officeTabHeader', // блок меню
        ],

    ] ;
    private $PARAM_NAME = 'menuPath' ; // имя для запоминания в  TaskStore
    //----------------------------------------//
    public function __construct() {
        $this->restoreMenuPath() ;
        if (empty($this->menuPath)) {
            $this->init() ;
        }


    }
    private function init() {
        $this->menuPath = [] ;
        $this->menuPath[] = $this->rootItem ;
        $this->saveMenuPath() ;
        return $this ;
    }
    private function newMenuItem() {
        return [
            'url' => '',          // url пункта меню
            'name' => '',         // имя для вывода
            'prevItem' => '', // ссылка на ид предшествующего узла
            'menuBlockId' => '', // блок заголовков tab
        ] ;
    }
    private function saveMenuPath() {
        TaskStore::putParam($this->PARAM_NAME,$this->menuPath) ;
    }
    private function restoreMenuPath() {
        $this->menuPath = TaskStore::getParam($this->PARAM_NAME) ;
    }
    public function getMenuPath() {
       $this->restoreMenuPath() ;
       $res = [] ;
       foreach ($this->menuPath as $i => $itemId) {
           if (false === $itemId) {
               continue ;
           }
           array_push($res,$this->menuItems[$itemId]) ;
       }
       if (sizeof($res) === 1) {      // корень не выводится
           $res = [] ;
       }
        return $res ;
    }
    public function addNewItem($itemId) {
        if (!isset($this->menuItems[$itemId])) {
            return false ;
        }
        $this->restoreMenuPath() ;
        $newItem = $this->menuItems[$itemId] ;
        $prevItemId = $newItem['prevItem'] ;
        $itemIsRoot = (empty($prevItemId)) ;
        $currentInd = false ;
        if ($itemIsRoot) {
            $currentInd = 0 ;
        }
        else {
            $currentInd = array_search($prevItemId,$this->menuPath) ;
            $currentInd = (false !== $currentInd) ? $currentInd + 1 : false ;
        }
        if (false !== $currentInd) {
            $n = sizeof($this->menuPath) ;
            if ($n === $currentInd ) {
               array_push($this->menuPath,$itemId) ;
            } else {
                $this->menuPath[$currentInd] = $itemId ;
            }
            if ($n -1 > $currentInd)
            for ($i = $currentInd + 1 ; $i < $n; $i++) {
                $this->menuPath[$i] = false ;
            }
        }
        $this->saveMenuPath() ;

    }
}