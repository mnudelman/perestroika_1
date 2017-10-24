<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 10.01.17
 * Time: 15:27
 */
namespace app\controllers;
use app\controllers\BaseController ;
use app\models\UserProfile ;
use app\models\Country ;
use app\models\Region ;
use app\models\City ;

use Yii ;
class GeographyController extends BaseController {
    private $_success = false ;
    private $_countryList = [] ;
    private $_regionList = [] ;
    private $_cityList = [] ;
    private $_countryId  ;
    private $_regionId ;
    private $_cityId ;
    private $_youngerNodes = [
        'all' => ['country','region','city'],
        'country' => ['region','city'],
        'region' => ['city'],
        'city' => [],

     ] ;
    private $_seniorNodes = [
        'city' => ['region'],
        'region' => ['country'],
        'country' => []
    ] ;
    private $_params = [
        'country' => null,
        'region' => null,
        'city' => null ] ;
   //---------------------------------------------------//
   public function actionIndex() {
       $opCod = (Yii::$app->request->post('opcod'));
       if ($opCod === 'restore') {
           $this->setRestoreParms() ;
       }
       $attrType = (Yii::$app->request->post('type'));
       $attrId = (Yii::$app->request->post('id'));
       if (!is_null($attrType) && !is_null($attrId)) {
           $this->_success = true ;
           $this->_countryList = [];
           $this->_regionList = [];
           $this->_cityList = [];
//           $this->getList($attrType);             // собственный список - он не нужен
           $this->_params[$attrType] = $attrId ;
           $nodes = $this->_youngerNodes[$attrType];          // подчинённые узлы
           foreach ($nodes as $ind => $nodeAttrType) {
               $this->getList($nodeAttrType);                // список для подчинённого узла
           }
       }
       if( Yii::$app->request->isAjax ){
           $answ = [
               'success' => $this->_success ,
               'country_id' => $this->_params['country'],
               'region_id' => $this->_params['region'],
               'city_id' => $this->_params['city'],
               'countryList' => $this->_countryList,
               'regionList' => $this->_regionList,
               'cityList' => $this->_cityList,
               'z-end' => 'end'
           ] ;
           echo json_encode($answ) ;
       }

   }

    /**
     * параметры восстановления географии из profile
     */
    private function setRestoreParms() {
        $userId = Yii::$app->user->identity->id;
        $userProfile = UserProfile::findOne(['userid' => $userId]);
        $cityId = $userProfile->city_id ;
        $md = new City() ;
        $city = $md->getById($cityId) ;
        $this->_params['city'] = $cityId ;
        $this->_params['region'] = $city->region_id ;
        $this->_params['country'] = $city->country_id ;

    }
    /**
     * @param $md      - объект-модель, в которую требуется подставить параметры
     * @param $attrTyp - тип модели(country | region | city)
     * параметры берутся от "старших" узлов дерева
     * например, если модель city, то передаются параметры: countryId, regionId
     */
    private function setModelParameters($md,$attrTyp) {
        $nodes = $this->_seniorNodes[$attrTyp] ;
        foreach ($nodes as $ind => $paramName) {
            $modelParameter = $paramName . 'Id' ;
            $paramValue = $this->_params[$paramName] ;
            $md->$modelParameter = $paramValue ;
        }

    }
//$listName = '_' . $attrTyp  . 'List' ;
    /**
     * получить список из соответствующего объекта-модели
     * если по $attrTyp не пределён параметр для подстановки в модели нижнего уровня,
     * то берётся id первого элемента
     * @param $attrTyp
     * @return mixed
     */
    private function getList($attrTyp) {
        $model =  'app\\models\\' . ucfirst($attrTyp) ;
       $md = new $model() ;
//        $md = new City() ;
        $this->setModelParameters($md,$attrTyp) ;
        $list = $md->getList() ;
        $listName = '_' . $attrTyp . 'List' ;
        $this->$listName = $list ;
        if (is_null($this->_params[$attrTyp])) {
            $this->_params[$attrTyp] = $list[0]['id'] ;
        }
        return $list ;
    }
}