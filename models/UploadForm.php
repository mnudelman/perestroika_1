<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 28.12.16
 * Time: 7:11
 */

namespace app\models;

use app\service\PageItems;
use yii\base\Model;
use yii\web\UploadedFile;
use app\service\Files ;
use Yii ;
class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $imageFile;
    public $userId = null;
    private $_uploadedPath ;
    private $_uploadedUrl ;
    const UPLOAD_DIR = 'images/avatars/' ;

    public function attributeLabels()
    {
        $labelTab = PageItems::getItemText(['user','fields']) ;

        return [
            'imageFile' => $labelTab['imageFile'],
        ];
    }

    public function rules()
    {
        return [
            [['imageFile'], 'file', 'skipOnEmpty' => false,
                'extensions' => 'png,jpg,jpeg,pdf'],
        ];
    }

    public function upload()
    {
        $userId = $this->getUserId() ;
        $path = Files::getPath('upload',$userId) ;
        if (false !== $path && $this->validate()) {
            $randomSuffix = substr(\Yii::$app->security->generateRandomString(),-5) ;
            $appendix = $this->imageFile->baseName . '_' . $randomSuffix .  '.' . $this->imageFile->extension ;
            $this->_uploadedPath = $path['dir'] . '/' . $appendix ;
            $this->_uploadedUrl = $path['url'] . '/' . $appendix ;
            $this->imageFile->saveAs($this->_uploadedPath);
            return true;
        } else {
            return false;
        }


//        if ($this->validate()) {
//            $randomSuffix = substr(\Yii::$app->security->generateRandomString(),-5) ;
//            $this->_uploadedPath = self::UPLOAD_DIR .
//                $this->imageFile->baseName . '_' . $randomSuffix .  '.' . $this->imageFile->extension ;
//            $this->imageFile->saveAs($this->_uploadedPath);
//            return true;
//        } else {
//            return false;
//        }
    }
    private function getUserId() {
        if (is_null($this->userId))  {
            $this->userId = Yii::$app->user->identity->getId() ;
        }
        return $this->userId ;
    }
    public function getUploadedPath() {
        return $this->_uploadedPath ;
    }
    public function getUploadedUrl() {
        return $this->_uploadedUrl ;
    }
}