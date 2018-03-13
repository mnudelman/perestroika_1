<?php
/**
 *  класс - Сворачиваемый списк
 */

namespace app\components;
use yii\base\Widget;
use Yii;


class CollapsibleListWidget extends Widget {
    public $listName ='' ;        // например. 'workRegion' - регионы работ
    public $listItems = [] ;      // список компонентов
    public $listItemFormat = [] ; // формат элементов (умолчание см. $_default....
    public $pictureClass = [] ;       // картинки, обозначающие действия (см. defaultPictures)
    public $onClick = [] ;        // реакция на кнопку "редактировать"
    public $htmlPrefix = '' ;     // префикс id для обеспечения уникальнгости
    public $btTitle ='';          // поясняющая подпись для кнопки редактирования
    public $btTooltipName = '' ;  // ссылка на tooltops  раздел
    public $buttons = [] ;       // можно включать несколько кнопок(а не олько редактирование)
                                 // btItem = ['btTitle' => '','pictureClass'=>'','onclick'=> '']
    public $currentItemId = false ;   // текущий ItemId
    public $currentItemClass = false ; // class для выделения текущего item
    private $_defaultListItemFormat = [
        'id' => 'id',
        'name' => 'name',
        'editFlag' => 'editFlag',          // можно редактировать
        'fullyFlag' => 'fullyFlag',        // флаг - все возможные sumItems включены
        'subItems'  => 'subItems'          // выпадающий список
    ] ;
    private $_defaultPictureClass = [
        'edit' => 'glyphicon glyphicon-edit'] ; // bootstrap - шрифты
    private $_defaultOnClick = [
        'edit' => 'listCollapseOnClick'
    ] ;
    private $_defaultBtTitle = 'click to edit' ;
    private $_defaultBtClass = 'btn-primary' ;
    //--------------------------------------------------//
    public function init() {
        $this->listItemFormat = (sizeof($this->listItemFormat) == 0) ?
            $this->_defaultListItemFormat : $this->listItemFormat ;
        $this->pictureClass = (sizeof($this->pictureClass) == 0) ? $this->_defaultPictureClass : $this->pictureClass ;
        $this->onClick = (sizeof($this->onClick) == 0) ? $this->_defaultOnClick : $this->onClick ;
        $this->btTitle = (empty($this->btTitle)) ? $this->_defaultBtTitle : $this->btTitle ;
        // кнопку, если есть засовываем в $buttons
        if (sizeof($this->buttons) == 0) {
            $this->buttons['edit'] = [
                    'btTitle' => $this->btTitle,
                    'pictureClass'=> $this->pictureClass['edit'],
                    'onClick'=> $this->onClick['edit'],
                    'btClass' => 'btn-primary',
                    'btTooltipName' => $this->btTooltipName,
            ] ;
        }



    }
    public function run() {
        ob_start();

        echo '<div> <ul class="list-group" id="' . $this->htmlPrefix .'-ul' . '"> ' ;
        $this->tplInclude() ;
        echo '</ul></div>' ;
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
        foreach ($this->listItems as $ind => $item) {
            $id = $item['id'] ;
            $currentItemFlag = ($this->currentItemId == $id) ;
            $currentItemClass = $this->currentItemClass ;

            $itemName = $item['name'] ;
            $editFlag = $item['editFlag'] ;          // можно редактировать
            $fullyFlag = $item['fullyFlag'];        // флаг - все возможные sumItems включены
            $editClass = $this->pictureClass['edit'] ;
            $htmlId = $this->htmlPrefix . '-' . $id ;
            $htmlSubItemId = $htmlId . '-subitems' ;
            $args =  $htmlId  ;
            $onClick = $this->onClick['edit'] . "('" . $args . "')";
            $fullyName = ($fullyFlag) ? '(полностью)' : '' ;
            $subItems = $item['subItems'] ;          // выпадающий список
            $btTitle = $this->btTitle ;
            $btTooltipName = $this->btTooltipName ;
//         у элемента может быть набор кнопок, отличный от основного
            $itemButtons = (isset($item['buttons'])) ? $item['buttons'] : [] ;


            $buttons = $this->buttons ;
//  подстановка атрибутов тек кнопки из описание элемента
            if (sizeof($itemButtons) > 0) {
                foreach ($itemButtons as $btKey => $btItem) {
                    if (isset($buttons[$btKey])) {
                        foreach ($btItem as $key => $value) {
                            if (isset($buttons[$btKey][$key])) {
                                $buttons[$btKey][$key] = $value;
                            }
                        }
                    }
                }
            }

            foreach($buttons as $ind1 => $btItem ) {
                if ($ind1 === 'null') {
                    continue ;
                }
                $btItem['onClick'] = $btItem['onClick'] . "('" . $args . "')";
                if (!isset($btItem['btClass']) || empty($btItem['btClass'])) {
                    $btItem['btClass'] = $this->_defaultBtClass ;
                }

                $buttons[$ind1] = $btItem ;
            }

            include __DIR__ . '/tpl/collapseListItemTpl.php' ;
        }

    }
    public static function className() {
        return __CLASS__ ;
    }
}