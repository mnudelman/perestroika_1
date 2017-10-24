<?php
/**
 * класс обслуживания директориев задачи
 */

namespace app\service;
use yii\helpers\Url ;
use Yii ;

class Files
{
    private static $basePath = [
        'image' => [
            'path' => '@webroot/images',
            'url' => '@web/images'],
        'workDirectionImg' => [
            'path' => '@webroot/images/workDirection',
            'url' => '@web/images/workDirection'],
        'userImg' => [
            'path' => '@webroot/images/user/u_{userId}',
            'url' => '@web/images/user/u_{userId}'],
        'upload' => [
            'path' => '@webroot/upload/u_{userId}',
            'url' => '@web/upload/u_{userId}'],
        'userAvatar' => [
            'path' => '@webroot/images/user/u_{userId}/avatar',
            'url' => '@web/images/user/u_{userId}/avatar'],
        'userGallery' =>  [
            'path' => '@webroot/images/user/u_{userId}/gallery',
            'url' => '@web/images/user/u_{userId}/gallery'],
        'layoutParts' => [
            'path' => '@app/views/layouts/layOutParts',
            'url' => '@app/views/layouts/layOutParts'],
    ];

    const DIR_MODE = 0777 ; // 0755 ;
    //-------------------------------------------------------//
    public static function getPath($pathName,$userId = null) {
        $userReplace =  $userId  ;
        $path = self::$basePath[$pathName] ;
        if (isset($userId)) {
            $path = str_replace('{userId}',$userReplace,$path) ;
        }
        $realPath = Yii::getAlias($path['path']) ;
        $realUrl = Url::to($path['url']) ;
        $success = true ;
        if (!is_dir($realPath)) {
            $success = mkdir($realPath,self::DIR_MODE,true) ;
        }
        return ($success) ? ['dir' => $realPath,'url' => $realUrl] : false ;
    }
    public static function fileExist($pathName,$userId,$fileName) {
        $path = self::getPath($pathName,$userId) ;
        if (false === $path) {
            return false ;
        }
        $filePath = $path['dir'] . '/' . $fileName ;
        return is_file($filePath) ;
    }

    /**
     * перенос файла - возможно только для собственных файлов
     * @param $fileName
     * @param $dirNameFrom
     * @param $dirNameTo
     */
    public static function fileMove($fileName,$pathNameFrom,$pathNameTo) {
        $userId = Yii::$app->user->identity->getId() ;
        $pathFrom = self::getPath($pathNameFrom,$userId) ;
        $pathTo = self::getPath($pathNameTo,$userId) ;
        $fileTo = false ;
        if (false !== $pathFrom && false !== $pathTo) {
            $dirFrom = $pathFrom['dir'] ;
            $dirTo = $pathTo['dir'] ;
            $fileFrom = $dirFrom . '/' . $fileName ;
            $fileTo = $dirTo . '/' . $fileName ;
            rename($fileFrom,$fileTo);
        }
        return (false == $fileTo) ? false : is_file($fileTo) ;
    }
    public static function fileDelete($pathName,$userId,$fileName) {
        $path = self::getPath($pathName,$userId) ;
        if (false === $path) {
            return false ;
        }
        $filePath = $path['dir'] . '/' . $fileName ;
        $res = true ;
        if (file_exists($filePath)) {
            $res = unlink($filePath) ;
        }
        return $res ;

    }
}