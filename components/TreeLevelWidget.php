<?php
/**
 * Created by PhpStorm.
 * User: mickhael
 * Date: 06.02.18
 * Time: 16:26
 */

namespace app\components;
use yii\base\Widget;

class TreeLevelWidget extends Widget {
    public $rootPanel = [] ;
    public $listPanelHeading = [] ;
    public $listPanelBody = [] ;
    public $addPanelHeading = [] ;
    public $addPanelBody = [] ;
    public $editPanelHeading = [] ;
    public $editPanelBody = [] ;
    public function init() {
    }
    public function run() {
        ob_start();
        include __DIR__ . '/tpl/toolbarTpl.php';
        return ob_get_clean();
    }
}