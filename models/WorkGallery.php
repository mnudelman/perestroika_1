<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 12.02.17
 * Time: 21:40
 */

namespace app\models;
use yii\db\ActiveRecord ;
use Yii ;
use app\service\Files ;
class WorkGallery extends ActiveRecord {
    public $userId ;
    protected $parentKeyName = 'userid' ;
    public $parentKeyId ;


    public $uploadDirectory = null;
    public $galleryDirectory = null;
    private $orderMaxNum = 99999 ;   // удалять за пределами номера
    private $binMaxNum = 99999 ;
    //-----------------------------------------//
    //-----------------------------------------//
    public static function tableName(){
        return   'work_gallery';
    }
    public function attributeLabels()
    {
//        $labelTab = PageItems::getItemText(['user','fields']) ;

        return [
            'id' => 'id',
//            'userid' => 'userid',
            $this->parentKeyName => $this->parentKeyName,
            'image' => 'image',                  // файл изображения
            'order_n' => 'order_n',              // пор № при выводе
            'bin_flag' => 'bin_flag',            // 1 - в корзине
            'title_ru' => 'title_ru',                   // подпись
            'title_en' => 'title_en'                   // подпись
        ];
    }

    public function rules()
    {
        return [
            [['image','order_n','title_ru',],'required'],
        ];
    }
    public function addImage($imgItem,$orderN,$binFlag)
    {
        $img = $imgItem['img'];
        $title_ru = $imgItem['title_ru'];
        $title_en = $imgItem['title_en'];
        $r = $this->findImgByOrderNum($orderN, $binFlag);
        $result = null ;
        if (empty($r)) {
//            $this->userid = $this->userId ;
            $fld = $this->parentKeyName ;
            $this->$fld = $this->parentKeyId ;
            $this->order_n = $orderN ;
            $this->image = $img ;
            $this->title_ru = $title_ru ;
            $this->title_en = $title_en ;
            $this->bin_flag = $binFlag ;
            $this->save() ;
            $result = $this ;
        } else {
            $r->image = $img ;
            $r->title_ru = $title_ru ;
            $r->title_en = $title_en ;
            $r->save() ;
            $result = $r ;
        }
        $this->moveImageToGalleryDirectory($img) ;
    }
    public function delImage($orderN,$binFlag) {
        $r = $this->findImgByOrderNum($orderN, $binFlag);
        if ($r) {
            $img = $r->image ;
            $r->delete() ;
            $this->removeImage($img) ;
        }
    }

    /**
     * убрать с диска
     * если не было сохранения, то файл в dirUpload
     * @param $imgFile
     * @return bool
     */
    public function removeImage($imgFile) {
        $dirGallery = $this->galleryDirectory ;
        $dirUpload =  $this->uploadDirectory ;
        if(empty($dirGallery) || !is_dir($dirGallery)) {
            return false ;
        }
        $file = $dirGallery . '/' . $imgFile ;
        if (is_file($file)) {
            unlink($file) ;
        }else {
            $file = $dirUpload . '/' . $imgFile ;
            if (is_file($file)) {
                unlink($file);
            }
        }
        return !is_file($file) ;
    }
    /**
     * файл $imgFile должен оказаться в galleryDirectory
     * @param $imgFile
     * @return bool
     */
    private function moveImageToGalleryDirectory($imgFile) {
        $dirFrom = $this->uploadDirectory ;
        $dirTo = $this->galleryDirectory ;
        if(is_null($dirFrom) || is_null($dirTo) ||
            !(is_dir($dirFrom) && is_dir($dirTo))) {
            return false ;
        }
        $fileFrom = $dirFrom . '/' . $imgFile ;
        $fileTo = $dirTo . '/' . $imgFile ;
        if (!is_file($fileTo) && is_file($fileFrom) ) {
            rename($fileFrom,$fileTo) ;
        }
        return is_file($fileTo) ;

    }
    public function getList($binFlag) {
        $list =  $this->find()
            ->where([
//                'userid' => $this->userId,
                $this->parentKeyName => $this->parentKeyId,
                'bin_flag'=>$binFlag])
            ->orderBy('order_n')
            ->asArray()->all() ;
        return $list ;
    }

    /**
     * поиск элемента с заданным порядковым номером
     * @param $orderN
     * @param $binFlag
     * @return array|null|ActiveRecord
     */
    private function findImgByOrderNum($orderN,$binFlag) {
        $r = $this->find()
            ->where([
//                'userid'=>$this->userId,
                $this->parentKeyName => $this->parentKeyId,
            'order_n' => $orderN,'bin_flag' => $binFlag])
            ->limit(1)->one() ;
        return $r ;
    }
}