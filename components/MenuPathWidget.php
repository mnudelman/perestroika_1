<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 22.06.17
 * Time: 16:37
 */

namespace app\components;
use yii\base\Widget;
use Yii;
use app\models\MenuPath ;
use yii\helpers\Url ;

class MenuPathWidget extends Widget {
    private $menuPath ;
    private $btnClass = [
        'ordinary' => 'btn btn-primary',
        'last' => 'btn btn-success',
    ] ;

    /**
     *$menuItem => [
    'url' => 'office/index',          // url пункта меню
    'name' => 'Кабинет',         // имя для вывода
    'prevItem' => 'site', // ссылка на ид предшествующего узла
    'htmlMenuBlockId' => '', // блок меню
    'menuHidden' => false,   // убирать меню с экрана после выбора
    ],
     */
    public function init() {
        $this->menuPath = (new MenuPath()) -> getMenuPath() ;
    }
    public function run() {
        ob_start();
        $pathSize = sizeof($this->menuPath) ;
//        echo   '<div class="btn-group">' ;
        if ($pathSize > 0) {
            echo '<div style="width:100%;height:40px;margin-top:-15px" id="menuPath">';
            for ($i = 0; $i < $pathSize; $i++) {
                $menuItem = $this->menuPath[$i];
                $lastItem = ($i === $pathSize - 1);

                $url = ($lastItem) ? '#' : Url::to([$menuItem['url']]);
                $name = $menuItem['name'];
                $disabled = ($lastItem) ? 'disabled="disabled"' : '';
                $btnClass = ($lastItem) ? $this->btnClass['last'] : $this->btnClass['ordinary'];
                $btnClass .= ' menuPath' ;
                $menuBlockId  = $menuItem['menuBlockId'];
                $onClick = '' ;
                if (!empty($menuBlockId)) {
                    $onClick = 'menuPathClick("' . $menuBlockId . '")' ;
                }
                include __DIR__ . '/tpl/menuPathTpl.php';
            }
            echo '</div>';
        }
        return ob_get_clean();


    }
}