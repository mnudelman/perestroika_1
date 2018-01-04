<?php
/**
 * Created by PhpStorm.
 * User: mickhael
 * Date: 02.01.18
 * Time: 19:29
 */

namespace app\components;
use yii\base\Widget;
use app\components\PaginationWidget ;
use Yii;

class ToolbarWidget extends Widget
{
    public $htmlPrefix ;
    public $topology = null ;
    public $title ;
    public $buttons = [];
    public $pagination = [];
    private $topologyDefault = [
        'title' => 3,       // ширина заголовка
        'buttons' => 5,     // ширина раздела кнопок
        'pagination' => 4   // ширина указателя страниц
    ] ;
    private $btEmpty = [         // список атрибутов кнопки
        'title' => '',
        'iconClass' => '',
        'clickFunction' => '',
        'clickAction' => ''
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
              'clickFunction' => 'orderMailingGo',
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
        ]


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
                $btCurrent = $this->buttonsSet[$btName] ;
                foreach ($this->btEmpty as $key => $value) {
                    if (!isset($btItem[$key])) {
                        $btItem[$key] = $btCurrent[$key] ;
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
        $toolbarTitle = $this->title ;
        $buttons = $this->buttons ;
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
