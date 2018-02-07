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
    public $htmlPrefix ;
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
//        include __DIR__ . '/tpl/variableWidget___.php' ;
        ob_start();
        $htmlPrefix  = $this->htmlPrefix;
        $rootPanel = $this->rootPanel ;
        $listPanelHeading = $this->listPanelHeading ;
        $listPanelBody = $this->listPanelBody ;
        $addPanelHeading = $this->addPanelHeading ;
        $addPanelBody = $this->addPanelBody ;
        $editPanelHeading = $this->editPanelHeading ;
        $editPanelBody = $this->editPanelBody ;
        include __DIR__ . '/tpl/treeLevelTpl.php';
        return ob_get_clean();
    }
}