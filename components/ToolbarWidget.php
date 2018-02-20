<?php
/**
 * панель инструментов состоит из :
 * - текста($title), набора кнопок(buttons), пагинации
 * топология(topology) - это ширина отдельных компонентов(сумма 12 единиц)
 */

/**
 * пример:
 echo ToolbarWidget::widget([
'htmlPrefix' => $htmlPrefix,
'topology' => [
'title' => 4,
'buttons' => 3,
'pagination' => 5
],
'title' => $partsTitleCurrent,
'buttons' => [
'help'=> [],
'filter' => []
],
'pagination' => [
'indexPages' => $indexPagesList,
'currentPage' => $currentPage,
'firstClass' => $firstClass,
'prevClass' => $prevClass,
'nextClass' => $nextClass,
'lastClass' => $lastClass,
],
]) ;

 */

namespace app\components;
use yii\base\Widget;
//use app\components\PaginationWidget ;
//use Yii;

class ToolbarWidget extends Widget
{
    public $htmlPrefix ;
    public $topology = null ;
    public $title ;
    public $buttons = [];
    public $pagination = [];
    public $widgetVar = [] ;
    private $topologyDefault = [
        'title' => 3,       // ширина заголовка
        'buttons' => 5,     // ширина раздела кнопок
        'widget' => 0,      // gроизвольный widget
        'pagination' => 4   // ширина указателя страниц
    ] ;
    private $btEmpty = [         // список атрибутов кнопки
        'title' => '',
        'iconClass' => '',
        'clickFunction' => '',
        'clickAction' => '',
        'id' => '',
        'disabled' => false,
        'dataItems' => []
    ] ;
    private $paginationDefault = [
        'indexPages' => [1] ,// массив страниц для вывода [1,2,3]
        'currentPage' => 1,// - текущая страница
        'firstClass' => '',  // разрешение/запрет для терминальных страниц
        'prevClass' =>  '',  //
        'nextClass'=> '',
        'lastClass' => '' ,
        ] ;
    private $buttonsSet = [    // иконки по умолчанию
          'help' => [
              'title' => 'help',
              'iconClass' => 'fa fa-question',
              'clickFunction' => 'dataRule',
              'clickAction' => 'open'
          ],
          'filter' => [
              'title' => 'filter',
              'iconClass' => 'fa fa-filter',
              'clickFunction' => 'dataFilter',
              'clickAction' => 'edit'

          ] ,
          'setup' => [
              'title' => 'setup',
              'iconClass' => 'fa fa-cog',
              'clickFunction' => 'dataSetup',
              'clickAction' => 'edit'
          ],
          'lock' => [
              'title' => 'lock',
              'iconClass' => 'fa fa-lock',
              'clickFunction' => 'orderLockClick',
              'clickAction' => ''
          ],
          'unlock' => [
              'title' => 'unlock',
              'iconClass' => 'fa fa-unlock',
              'clickFunction' => 'orderLockClick',
              'clickAction' => ''
          ],
          'send' => [
              'title' => 'send message',
              'iconClass' => 'fa fa-send-o',
              'clickFunction' => 'orderMailingGo',
              'clickAction' => ''

          ],
          'newTheme' => [
              'title' => 'newTheme',
              'iconClass' => 'fa fa-user-plus',
              'clickFunction' => '',
              'clickAction' => ''

          ],
          'yourCorrespondent' => [
              'title' => 'yourCorrespondent',
              'iconClass' => 'fa fa-user-secret',
              'clickFunction' => '',
              'clickAction' => ''
          ],
          'newFile' => [
              'title' => 'newFile',
              'iconClass' => 'fa fa-file-o',
              'clickFunction' => '',
              'clickAction' => ''
          ],
          'delete' => [
              'title' => 'delete',
              'iconClass' => 'fa fa-minus-square',
              'clickFunction' => '',
              'clickAction' => ''
          ],
          'ban' => [
              'title' => 'close correspondence',
              'iconClass' => 'fa fa-ban',
              'clickFunction' => '',
              'clickAction' => ''
          ],
        'unban' => [
            'title' => 'open correspondence',
            'iconClass' => 'fa fa-envelope-o',
            'clickFunction' => '',
            'clickAction' => ''
        ],
        'clone' => [
            'title' => 'clone the current object',
            'iconClass' => 'fa fa-clone',
            'clickFunction' => '',
            'clickAction' => ''

        ],
        'save' => [
            'title' => 'save the object',
            'iconClass' => 'fa fa-save',
            'clickFunction' => '',
            'clickAction' => ''

        ],
        'openedEye' => [
            'title' => 'opened eye',
            'iconClass' => 'fa fa-eye',
            'clickFunction' => '',
            'clickAction' => '',
            'dataItems' => [
                'img-yes' => 'fa fa-eye',
                'img-no' => 'fa fa-eye-slach',
            ],

        ],
        'coveredEye' => [                // прикрытый глаз
            'title' => 'covered eye',
            'iconClass' => 'fa fa-eye-slash',
            'clickFunction' => '',
            'clickAction' => '',
            'dataItems' => [
                'img-no' => 'fa fa-eye',
                'img-yes' => 'fa fa-eye-slash',
            ],


        ],




    ] ;
    public function init() {
        $this->topologyPrepare() ;
        $this->buttonsPrepare() ;
        $this->paginationPrepare() ;
    }

    /**
     * Готовит список кнопок, добавляя атрибуты из $this->buttonsSet
     */
    private function buttonsPrepare() {
        foreach ($this->buttons as $btName => $btItem) {
            if (isset($this->buttonsSet[$btName])) {
                $btDefault = $this->buttonsSet[$btName] ;
                foreach ($this->btEmpty as $key => $value) {
                    if (!isset($btItem[$key]) && isset($btDefault[$key])) {
                        $btItem[$key] = $btDefault[$key] ;
                    }
                }
                $this->buttons[$btName] = $btItem ;
            }
        }
    }
    private function paginationPrepare() {
        foreach ($this->paginationDefault as $key => $value ) {
            if (!isset($this->pagination[$key])) {
                $this->pagination[$key] = $value ;
            }
        }
    }
    private function topologyPrepare() {
        if (is_null($this->topology)) {
            $this->topology = $this->topologyDefault ;
        }
        foreach ($this->topologyDefault as $key=> $value) {
            if (!isset($this->topology[$key])) {
                $this->topology[$key] = 0 ;
            } else {
                $this->topology[$key] = $this->topology[$key] - 0 ;
            }
        }
    }
    public function run() {
        ob_start();
        $htmlPrefix = $this->htmlPrefix ;
        $titleWidth = $this->topology['title'] ;
        $buttonsWidth  = $this->topology['buttons'] ;
        $paginationWidth = $this->topology['pagination'] ;
        $widgetWidth =  $this->topology['widget'] ;
        $toolbarTitle = $this->title ;
        $buttons = $this->buttons ;
        $widgetVar = $this->widgetVar ;
        $indexPages = $this->pagination['indexPages'] ;  // массив страниц для вывода [1,2,3]
        $currentPage = $this->pagination['currentPage'] ;// - текущая страница
        $firstClass = $this->pagination['firstClass'] ;  // разрешение/запрет для терминальных страниц
        $prevClass = $this->pagination['prevClass'] ;    //
        $nextClass = $this->pagination['nextClass'] ;
        $lastClass= $this->pagination['lastClass'] ;
                include __DIR__ . '/tpl/toolbarTpl.php';
        return ob_get_clean();
   }

}
