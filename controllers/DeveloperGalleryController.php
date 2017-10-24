<?php
/**
 * получит галерею от исполнителя
 * Time: 21:11
 */

namespace app\controllers;
use app\controllers\WorkGalleryController ;
use app\service\TaskStore ;

class DeveloperGalleryController extends WorkGalleryController {
//    protected $parentKeyName = 'order_id' ;
//    protected $models = [
//        'xWorkGallery' => 'app\models\OrderWorkGallery',
//    ] ;
    protected function getParentKeyId() {
        if (is_null($this->parentKeyId)) {
            $developer = TaskStore::getParam('currentDeveloper');
            if (is_array($developer) && isset($developer['id'])) {
                $this->parentKeyId =  $developer['id'] ;
            }
        }
        return $this->parentKeyId ;
    }
    protected function getUserId() {
        if (is_null($this->_userId)) {

            $developer = TaskStore::getParam('currentDeveloper');
            if (is_array($developer) && isset($developer['id'])) {
                $this->_userId =  $developer['id'] ;
            }
        }
        return $this->_userId ;
    }
}