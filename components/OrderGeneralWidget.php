<?php
/**
 * Вывод основной страницы описания для ЗАКАЗА
 * Time: 19:58
 */

namespace app\components;
use yii\base\Widget;
use Yii;

class OrderGeneralWidget extends Widget {
    public $htmlPrefix = '' ;
    public $orderModel ;
    public $userCountry ;
    public $userRegion ;
    public $userCity ;
    public $disabled ;
    //---------------------------------------------//
    public function init() {
    }
    public function run() {
        ob_start();
        $htmlPrefix = $this->htmlPrefix ;
        $orderModel = $this->orderModel ;
        $userCountry = $this->userCountry ;
        $userRegion = $this->userRegion ;
        $userCity = $this->userCity;
        $disabled  = $this->disabled ;


        include __DIR__ . '/tpl/orderGeneralTpl.php' ;
        return ob_get_clean();
    }
}