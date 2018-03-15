<?php
/**
 * Вспомогательгный класс для обслуживания географии пользователя
 * Ослуживается ownCity - собственный город пользователя(profile->city_id)
 * всё, что связано с географией работ
 */

namespace app\components;
use Yii ;
//use app\models\UserProfile ;
use app\models\Country ;
use app\models\Region ;
use app\models\City ;

class UserGeography
{
    private $_baseModelName = 'app\models\UserProfile' ;
    private $_cityId = false ;
    private $_userCountry = [];
    private $_userRegion = [];
    private $_userCity = [];

//==================================================//
    public function getOwnGeography()
    {
        if(sizeof($this->_userCountry) == 0 || !empty($this->_cityId) ) {
            $this->prepareOwnGeography() ;
        }
        return [
            'userCountry' => $this->_userCountry,
            'userRegion' =>  $this->_userRegion,
            'userCity' => $this->_userCity,
        ] ;
    }
    public function setCityId($cityId) {
        $this->_cityId = $cityId ;
        return $this ;
    }
    /**
     * @param $baseModelName - модель из которой надо брать  city_id
     * по умолчанию это userProfile
     */
    public function setBaseModel($baseModelName) {
        $this->_baseModelName = $baseModelName;
        return $this;
    }

    /**
     * получить начальное значение  cityId из BaseModel
     */
    private function getCityId() {
        if (!empty($this->_cityId)) {
            return $this->_cityId ;
        }
        $userIsGuest = Yii::$app->user->isGuest;
        if ($userIsGuest) {
            return null ;
        }
        $userid = Yii::$app->user->identity->getId();
        $baseName = $this->_baseModelName ;
        $model = $baseName::findOne(['userid' => $userid]);
        $cityId = $model->city_id;
        return $cityId ;
    }
    /**
     * география раскручивается от profile->city_id
     */
    private function prepareOwnGeography() {
        $cityId = $this->getCityId() ;
        if (is_null($cityId) || empty($cityId)) {
            $mdCountry = new Country();
            $country = $mdCountry->getById();
            $mdRegion = new Region();
            $mdRegion->countryId = $country->id;
            $region = $mdRegion->getById();
            $mdCity = new City();
            $mdCity->countryId = $country->id;
            $mdCity->regionId = $region->id;
            $city = $mdCity->getById();
        } else {
            $city = City::findOne(['id' => $cityId]);
            $regionId = $city->region_id;
            $region = Region::findOne(['id' => $regionId]);
            $countryId = $region->country_id;
            $country = Country::findOne(['id' => $countryId]);
        }
        $this->_userCountry = ['id' => $country->id, 'name' => $country->name];
        $this->_userRegion = ['id' => $region->id, 'name' => $region->name];
        $this->_userCity = ['id' => $city->id, 'name' => $city->name];


    }
}