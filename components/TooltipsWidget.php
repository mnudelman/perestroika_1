<?php
/**
 * Created by PhpStorm.
 * User: mickhael
 * Date: 06.02.18
 * Time: 16:36
 */

namespace app\components;
use yii\base\Widget ;

class TooltipsWidget extends Widget
{
    public $htmlPrefix ;
    public $tooltips = [] ;
 public function init() {

 }
 public function run() {
     ob_start();
     echo '<div id="' . $this->htmlPrefix . '-tooltips' .'">' ;
     foreach ($this->tooltips as $tooltipName => $toolTipVariants ) {
         include __DIR__ . '/tpl/tooltipsTpl.php';
     }

     echo '</div>' ;
     return ob_get_clean();
 }
}