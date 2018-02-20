<?php
/**
 * Управление географией работ
 */

namespace app\controllers;
use app\controllers\BaseController ;
use app\models\City;
use Yii ;
use app\models\WorkRegion ;
use app\models\WorkCountry ;
use app\models\WorkCity ;
use app\service\TaskStore ;

class WorkGeographyController extends BaseController {
    private $workRegionId ;
    private $workCountryId ;
    private $objectType = 'user' ;
    private $OBJECT_TYPE_USER = 'user' ;
    private $OBJECT_TYPE_DEVELOPER = 'developer' ;
    private $DEVELOPER_PARAM_NAME = 'currentDeveloper' ;
    /**
     * добавить регион работ
     */
    public function actionAddWorkRegion() {
        $opCod = (Yii::$app->request->post('OpCod'));
        $countryId = (Yii::$app->request->post('countryId'));
        $regionId =  (Yii::$app->request->post('regionId'));
        $userId = Yii::$app->user->identity->id ;
        $workCountry = new WorkCountry() ;
        $workCountry->userId = $userId ;
        $workCityList = [] ;
        $cityList = [] ;
        $success = false ;
        $wCountry = [] ;
        $wRegion = [] ;
        $workCountry = $workCountry->addCountry($countryId) ;
        if ($workCountry) {
            $wCountry = $workCountry->getName($workCountry->id) ;
            $workCountryId = $workCountry->id ;
            $workRegion = new WorkRegion() ;
            $workRegion->workCountryId = $workCountryId ;
            $workRegion = $workRegion->addWorkRegion($regionId) ;
            if ($workRegion) {
                $wRegion = $workRegion->getName($workRegion->id) ;
                $workRegionId = $workRegion->id ;
                $workCity = new WorkCity() ;
                $workCity->workRegionId = $workRegionId ;
                $workCityList = $workCity->getList() ;
                $city = new City() ;
                $city->regionId = $workRegion->region_id ;
                $cityList = $city->getList() ;
                $success = true ;
            }
        }
        $answ = [
            'success' => $success,
            'workCountry' => $wCountry ,
            'workRegion' => $wRegion,
            'workCityList' => $workCityList,
            'cityList' => $cityList,
            'z-end' => 'end'
        ] ;
        echo json_encode($answ);
    }
    private function getUserId($objectType) {
        $userId = null ;
        switch ($objectType) {
            case $this->OBJECT_TYPE_USER :
                $userId = Yii::$app->user->identity->id ;
                break ;
            case $this->OBJECT_TYPE_DEVELOPER :
                $developer = TaskStore::getParam($this->DEVELOPER_PARAM_NAME) ;
                $userId = $developer['id'] ;
                break ;
        }
        return $userId ;
    }
    /**
     * упрощенный вариант $this->actionAddWorkRegion
     */
    public function actionGetWorkCity() {
        $opCod = (Yii::$app->request->post('OpCod'));
        $countryId = (Yii::$app->request->post('countryId'));
        $regionId =  (Yii::$app->request->post('regionId'));
        $objectType = (Yii::$app->request->post('objectType'))  ?
            Yii::$app->request->post('objectType') : $this->OBJECT_TYPE_USER ;

//        $userId = Yii::$app->user->identity->id ;
        $userId = $this->getUserId($objectType) ;
        $workCountry = new WorkCountry() ;
        $workCountry->userId = $userId ;
        $workCityList = [] ;
        $cityList = [] ;
        $success = false ;
        $wCountry = [] ;
        $wRegion = [] ;
        $workCountry = $workCountry->addCountry($countryId) ;
        if ($workCountry) {
            $wCountry = $workCountry->getName($workCountry->id) ;
            $workCountryId = $workCountry->id ;
            $workRegion = new WorkRegion() ;
            $workRegion->workCountryId = $workCountryId ;
            $workRegion = $workRegion->addWorkRegion($regionId) ;
            if ($workRegion) {
                $wRegion = $workRegion->getName($workRegion->id) ;
                $workRegionId = $workRegion->id ;
                $city = new City() ;
                $city->regionId = $regionId ;
                $cityList = $city->getList() ;
                $workCity = new WorkCity() ;
                $workCity->workRegionId = $workRegionId ;
                $workCityList = $workCity->getList() ;
                $success = true ;

            }
        }
        $answ = [
            'success' => $success,
            'message' => [],
            'workCountry' => $wCountry ,
            'workRegion' => $wRegion,
            'workCityList' => $workCityList,
            'cityList' => $cityList,
            'z-end' => 'end'
        ] ;
        echo json_encode($answ);

    }
    public function actionGetWorkRegion()
    {
        $countryId = (Yii::$app->request->post('countryId'));
//        $userId = Yii::$app->user->identity->id;

        $objectType = (Yii::$app->request->post('objectType'))  ?
            Yii::$app->request->post('objectType') : $this->OBJECT_TYPE_USER ;

//        $userId = Yii::$app->user->identity->id ;
        $userId = $this->getUserId($objectType) ;


        $workCountry = new WorkCountry();
        $workCountry->userId = $userId;
        $success = false;
        $wCountry = [];
        $wRegionList = [];
        $workCountry = $workCountry->addCountry($countryId);
        if ($workCountry) {
            $wCountry = $workCountry->getName($workCountry->id);
            $this->workCountryId = $workCountry->id;
            $workRegion = new WorkRegion();
            $workRegion->workCountryId = $this->workCountryId ;
            $wRegionList = $workRegion->getList();
            $wRegionList = $this->checkWorkRegion($wRegionList,$countryId) ;
            $success = true ;
        }
        $answ = [
            'success' => $success,
            'workCountry' => $wCountry ,
            'workRegionList' => $wRegionList,
            'z-end' => 'end'
        ] ;
        echo json_encode($answ);

    }
    private function checkWorkRegion($workRegionList,$countryId)
    {
        $workRegion = new WorkRegion();
        $workRegion->workCountryId = $this->workCountryId;
   $newList = [];
        foreach ($workRegionList as $key => $item) {
            $itemCoutryId = $item['region']['country_id'];
            if ($itemCoutryId - 0 !== $countryId - 0) {
                $regionId = $item['region_id'];
                $workRegion->deleteWorkRegion($regionId);
            } else {
                $newList[] = $item;
            }
        }
        return $newList;

    }
    /**
     * формат
     *    data = {
    country : {
    country_id : countryId,
    name: countryName
    },
    region : {
    region_id : regionId,
    name: regionName,
    fullyFlag : fullyFlag,
    deleteFlag : deleteFlag
    },
    cityList : cityList
    */
    public function actionAddWorkCity() {
        $countryPost = (Yii::$app->request->post('country'));
        $regionPost = (Yii::$app->request->post('region'));
        $cityListPost = (Yii::$app->request->post('cityList'));
        $countryId = $countryPost['countryId'] ;
        $regionId =  $regionPost['regionId'] ;
        $fullyFlag = $regionPost['fullyFlag'] ;
        $fullyFlag = ($fullyFlag == 'true') ? true : false ;
        $deleteFLag = $regionPost['deleteFlag'] ;
        $deleteFLag = ($deleteFLag == 'true') ? true : false ;
        $userId = Yii::$app->user->identity->id ;
        $workCountry = new WorkCountry() ;
        $workCountry->userId = $userId ;
        $workCityList = [] ;
        $cityList = [] ;
        $success = false ;
        $wCountry = [] ;
        $wRegion = [] ;
        $workCountry = $workCountry->addCountry($countryId) ;
        if ($workCountry) {
            $wCountry = $workCountry->getName($workCountry->id) ;
            $workCountryId = $workCountry->id ;
            $workRegion = new WorkRegion() ;
            $workRegion->workCountryId = $workCountryId ;
            $workRegion = $workRegion->addWorkRegion($regionId) ;
            if ($workRegion) {
                $wRegion = $workRegion->getName($workRegion->id) ;
                if ($deleteFLag) {
                    $workRegion->deleteWorkRegion($regionId) ;
                }else{
                    $workRegion->fullyFlag = $fullyFlag ;
                    $workRegion->updateWorkRegion($regionId) ;

                    $this->workRegionId = $workRegion->id ;

                    $city = new City() ;
                    $city->regionId = $workRegion->region_id ;
                    $this->cityUpdate($cityListPost) ;

                    $workCity = new WorkCity() ;
                    $workCity->workRegionId = $this->workRegionId ;
                    $workCityList = $workCity->getList() ;
                    $workCityList = $this->cityCheck($workCityList,$regionId) ;
                }
                $success = true ;
            }
        }
        $answ = [
            'success' => $success,
            'workCountry' => $wCountry ,
            'workRegion' => $wRegion,
            'workCityList' => $workCityList,
            'z-end' => 'end'
        ] ;
        echo json_encode($answ);

    }

    /**
     * @param $cityListPost - переданный список
     */

    private function cityUpdate($cityListPost) {
//   $cityListPost - делим на две части: $cityInsert - то что набо добавить  $cityDelete - убрать

        foreach($cityListPost as $key => $item ) {
            $cityId = $item['city_id'] ;
            $inWorkCurrent = $item['inWorkCurrent'] ;
            $inWorkCurrent = ($inWorkCurrent == 'true') ;
//            $inWorkNow = $item['inWorkNow'] ;
            $opCod = ($inWorkCurrent) ? 'add' : 'del' ;
            $this->workCityAction($opCod,$cityId) ;

        }
    }
    private function workCityAction($opCod,$cityId) {
        $workCity = new WorkCity() ;
        $workCity->workRegionId = $this->workRegionId ;

        if ($opCod === 'add') {
            $workCity->addWorkCity($cityId) ;
        }else {
            $workCity->deleteWorkCity($cityId) ;
        }

    }

    /**
     * @param $workCityList
     * @param $regionId
     */
    private function cityCheck($workCityList,$regionId) {
        $workCity = new WorkCity() ;
        $newList = [] ;
        foreach($workCityList as $key => $item ) {
            $itemRegionId = $item['city']['region_id'] ;
            if ($itemRegionId - 0 !== $regionId - 0) {
                $cityId = $item['city_id'] ;
                $workCity->deleteWorkCity($cityId) ;
            }else {
                $newList[] = $item;
            }
        }
        return $newList ;

    }
}