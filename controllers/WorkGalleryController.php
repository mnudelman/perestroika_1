<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 13.02.17
 * Time: 20:57
 */

namespace app\controllers;
use yii\web\Controller;
use app\controllers\BaseController ;
use Yii ;
use app\models\WorkGallery;
use app\service\Files ;
use yii\db\Query ;
use yii\helpers\Url ;

class WorkGalleryController extends BaseController {
    protected $_galleryDirectory = null ;      // директория картинок
    protected $_galleryUrl = null ;      // Url - адрес
    protected $_uploadDirectory = null;       // директория загрузок
    protected $_workGallery = null;           // объект WorkGallery()
    protected $_userId = null;
    protected  $parentKeyId = null;
    protected $parentKeyName = 'userid' ;
    protected $models = [
        'xWorkGallery' => 'app\models\WorkGallery',
    ] ;

    /**
     * очистить корзину
     */
    public function actionCleanBin() {
        $workGallery = $this->getNewWorkGallery() ;
        $binPlace = [];
        $binRemoved = [] ;

        $binData = Yii::$app->request->post('binData');
        if (!is_null($binData)) {
            if(isset($binData['placeItems'])) {
                $binPlace = $binData['placeItems'];
            }
            if (isset($binData['removedItems'])) {
                $binRemoved = $binData['removedItems'];
            }
        }


        $this->removedImages($binPlace) ;            // удалить с диска файл
        $this->removedImages($binRemoved) ;
        $this->tailRemove(0,1) ;  //  убрать из БД

//        $this->actionGetGallery() ;  // отправить обратно по факту
        $answ = [
            'success' => true,
            'z_end' => 'z_end'
        ] ;
        echo json_encode($answ) ;

    }
    /**
     * сохранить галлерею
     *sendData = {
    opCod : 'saveGallery',
    orderData: {
    placeItems : galleryOnlyNameImgFile(orderPlace),
    removedItems: galleryOnlyNameImgFile(orderRemoved)
    },
    binData: {
    placeItems : galleryOnlyNameImgFile(binPlace),
    removedItems: galleryOnlyNameImgFile(binRemoved)
    }
     */
    public function actionSaveGallery()
    {
        $workGallery = $this->getNewWorkGallery() ;
        $orderData = Yii::$app->request->post('orderData');
        $orderPlace = [];
        $orderRemoved = [] ;

        if (!is_null($orderData)) {
            if(isset($orderData['placeItems'])) {
                $orderPlace = $orderData['placeItems'];
            }
            if (isset($orderData['removedItems'])) {
                $orderRemoved = $orderData['removedItems'];
            }
        }

        $binPlace = [];
        $binRemoved = [] ;

        $binData = Yii::$app->request->post('binData');
        if (!is_null($binData)) {
            if(isset($binData['placeItems'])) {
                $binPlace = $binData['placeItems'];
            }
            if (isset($binData['removedItems'])) {
            $binRemoved = $binData['removedItems'];
            }
        }


        $this->removedImages($orderRemoved) ;
        $this->removedImages($binRemoved) ;

        $this->addListImages($orderPlace,0) ;
        $this->addListImages($binPlace,1) ;

        $this->tailRemove(sizeof($orderPlace),0) ;
        $this->tailRemove(sizeof($binPlace),1) ;

        $this->actionGetGallery() ;  // отправить обратно по факту
    }
    private function tailRemove($nMax,$binFlag) {
        $parentKeyId = $this->getParentKeyId() ;
//        $subQuery = (new Query())->select('*')->from('work_gallery')
//            ->where(['userid' => $this->_userId,
//                'bin_flag' => $binFlag])
//            ->andWhere(['>', 'order_n', $nMax])
//        ;
        $xWorkGallery = $this->models['xWorkGallery'] ;
//        $models = WorkGallery::find()
        $models = $xWorkGallery::find()
            ->where([
//                'userid' => $this->_userId,
                $this->parentKeyName => $parentKeyId,
                'bin_flag' => $binFlag])
            ->andWhere(['>', 'order_n', $nMax])
            ->all();

        foreach($models as $model) {
            $model->delete();
        }
    }
    public function actionGetGallery()
    {
        $workGallery = $this->getNewWorkGallery() ;
        $orderList = $workGallery->getList(0) ;
        $binList =  $workGallery->getList(1) ;
        $urlPdfShow = Url::to('@web/commands/pdfShow.php') ;  // просмотр на экране
        $answ = [
            'success' => true,
            'galleryUrl' => $this->_galleryUrl,
            'orderList' => $orderList,
            'binList' => $binList,
            'urlPdfShow' => $urlPdfShow,
            'z_end' => 'z_end'
        ] ;
        echo json_encode($answ) ;
    }
    protected function getUserId() {
        if (is_null($this->_userId)) {
            $this->_userId = Yii::$app->user->identity->getId() ;
        }
        return $this->_userId ;
    }
     private function getNewWorkGallery() {

//        $workGallery = new WorkGallery();
        $xWorkGallery = $this->models['xWorkGallery'] ;
         $workGallery = new $xWorkGallery();
         $this->_workGallery = $workGallery ;

         $keyId = $this->getParentKeyId() ;

        $userId = $this->getUserId() ;
        if (is_null($this->_galleryDirectory)) {
            $path = Files::getPath('userGallery',$userId) ;
            $this->_galleryDirectory = $path['dir'] ;
            $this->_galleryUrl = $path['url'] ;
        }
        if (is_null($this->_uploadDirectory)) {
            $path = Files::getPath('upload',$userId) ;
            $this->_uploadDirectory = $path['dir'] ;
        }




//        $workGallery->userId = $userId ;
         $workGallery->parentKeyId = $keyId ;
        $workGallery->galleryDirectory = $this->_galleryDirectory ;
        $workGallery->uploadDirectory = $this->_uploadDirectory ;
        return $workGallery ;
    }
    /**
     * убрать с диска img-файлы
     * @param $removeList
     */
    private function removedImages($removeList) {
        $workGallery = $this->_workGallery ;
        foreach($removeList as $ind=>$removeItem) {
            $img = $removeItem['img'] ;
            $workGallery->removeImage($img) ;
        }
    }
    private function addListImages($list,$binFlag) {

        for($i = 0; $i < sizeof($list) ;$i++) {
            $workGallery = $this->getNewWorkGallery() ;
            $addItem = $list[$i] ;
            $workGallery->addImage($addItem,$i+1,$binFlag) ;
        }
    }
    protected function getParentKeyId() {
        if (is_null($this->parentKeyId)) {
            $this->parentKeyId = Yii::$app->user->identity->id ;
        }
        return $this->parentKeyId ;
    }

}