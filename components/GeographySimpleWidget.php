<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 10.01.17
 * Time: 11:38
 */

namespace app\components;
use yii\base\Widget;
use Yii;
use app\models\Country ;
use app\models\Region ;
use app\models\City ;

/**
 * Class GeographySimple
 * @package app\components
 * $model, $attribute  передаются из $form->field($profile, 'city')->widget(.....)
 */
class GeographySimpleWidget extends Widget {
    public $model ;
    public $attribute ;
    public $htmlIdPrefix = '';
    public $currentCountry =[] ;
    public $currentRegion =[] ;
    public $currentCity = [] ;
    public $geographyItems = [] ;        // список элементов ('country','region', 'city')
    public $listDirectUp = true ;        // направление раскрытия списка (true: вверх; false: вниз )
    public $onClickFunction ;
    public $disabled = false;
//  возможно внешнее задание списков
    public $countryList = [] ;
    public $regionList = [] ;
    public $cityList = [] ;
//  --------------------------------
    private $_countryList = [] ;
    private $_regionList = [] ;
    private $_cityList = [] ;
    private $_defaultItems = ['country','region','city'] ;
    private $_defaultHtmlIdPrefix = 'geography' ;
    private $_defaultOnClick = 'simpleGeographyOnClick' ;
//=====================================/
    public function init() {
        $this->geographyItems = (sizeof($this->geographyItems) == 0) ?
                                 $this->_defaultItems : $this->geographyItems ;
        $this->htmlIdPrefix = (empty($this->htmlIdPrefix)) ? $this->_defaultHtmlIdPrefix : $this->htmlIdPrefix ;
        $this->onClickFunction = (empty($this->onClickFunction)) ? $this->_defaultOnClick : $this->onClickFunction ;
        $this->prepareList() ;
    }

    /**
     * подготовить списки возможных значений,
     * взяв их из соотвествующих моделей
     */
    private function prepareList() {
        if (empty($this->countryList)) {
            $mdCountry = new Country() ;
            $this->_countryList = $mdCountry->getList()  ;
        }else {
            $this->_countryList = $this->countryList ;
        }

        if (sizeof($this->currentCountry) > 0) {
            if (empty($this->regionList)) {
                $mdRegion = new Region();
                $mdRegion->countryId = $this->currentCountry['id'];
                $this->_regionList = $mdRegion->getList();
            }else {
                $this->_regionList = $this->regionList ;
            }
            if (sizeof($this->currentRegion) > 0) {
                if (empty($this->cityList)) {
                    $mdCity = new City();
                    $mdCity->countryId = $this->currentCountry['id'];
                    $mdCity->regionId = $this->currentRegion['id'];
                    $this->_cityList = $mdCity->getList();
                }else {
                    $this->_cityList = $this->cityList ;
                }

            }
        }

    }

    /**
     * список может открываться вверх или вниз по отношению к кнопке
     * @return string
     */
    public function run() {
        ob_start();
        $divDirect = ($this->listDirectUp) ? '<div class="btn-group dropup">' :
            '<div class="btn-group dropdown">' ;
        ;
        echo   $divDirect ;
        $this->tplInclude() ;
        echo '</div>' ;
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
//        $tpls = ['country','region','city'] ;
        $tpls = $this->geographyItems ;
        foreach ($tpls as $ind => $typeName) {
            $curName = 'current' . ucfirst($typeName) ;
            $currentName = $this->$curName['name'] ;        // в шаблон
            $currentId =  $this->$curName['id'] ;        // в шаблон
            $nameList = '_' . $typeName . 'List' ;
            $itemList = $this->$nameList ;                  // в шаблон
            $htmlIdPrefix = $this->htmlIdPrefix ;
            $onClickFunction = $this->onClickFunction ;
            $disabled = $this->disabled ;
            include __DIR__ . '/tpl/geographySimpleTpl.php' ;
        }

    }
    public static function className() {
        return __CLASS__ ;
    }
}