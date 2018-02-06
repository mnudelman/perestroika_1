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
    public $htmlprefix ;
    public $tooltips = [] ;
 public function init() {

 }
 public function run() {
     ob_start();
     include __DIR__ . '/tpl/tooltipsTpl.php';
     return ob_get_clean();
 }
}