<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 06.04.17
 * Time: 21:07
 */

namespace app\models;
use app\models\WorkGallery ;

class OrderWorkGallery extends WorkGallery {
    protected $parentKeyName = 'order_id' ;
    public $uploadDirectory = null;
    public $galleryDirectory = null;
    private $orderMaxNum = 99999 ;   // удалять за пределами номера
    private $binMaxNum = 99999 ;
    //-----------------------------------------//
    //-----------------------------------------//
    public static function tableName(){
        return   'order_additional';
    }

}