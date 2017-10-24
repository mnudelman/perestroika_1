<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 16.12.16
 * Time: 15:55
 */

namespace app\controllers;
use yii\web\Controller;
use Yii ;
use yii\helpers\Url ;
use app\service\TaskStore ;
use app\models\MenuPath ;

class BaseController extends Controller{
    private $LANGUAGE_ENGLISH = 'en-US' ;
    private $LANGUAGE_RUSSIAN = 'ru-RU' ;
//----------------------------------------------------//
    /**
     *
     * @param $action
     * @return bool
     */
    public function beforeAction($action){
        if( $action->id == 'index' ){    // добавить в путь
            $this->setTimeZone() ;
            $currentController = Yii::$app->controller->id ;
            (new MenuPath())->addNewItem($currentController) ;
//            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }
    private function setTimeZone() {
        $tz = TaskStore::getParam('timeZone') ;
        if (empty($tz)) {
//          date_default_timezone_set('Europe/Moscow') ;
          $dt = (int)date('O');
          $sign = ($dt >= 0) ? '+' : '-' ;
           $d = $dt/100 ;
            $dt = $sign . $d . ':00' ;
          $r =  Yii::$app->db->createCommand(
              'SET time_zone = :dt')
              ->bindValue(':dt', $dt)
              ->execute() ;
            TaskStore::putParam('timeZone','Europe/Moscow') ;
        }
    }
    /**
     * если использовать  $action , то проблема с параметрами
     * @param $ln
     * @param $action
     * @return \yii\web\Response
     */
    public function actionLanguage($ln,$action)
    {
        $currentController = Yii::$app->controller->id ;
        $arr = explode('-',Yii::$app->language) ;
        $currentLg =  $arr[0] ;
        Yii::$app->language = ($ln === 'en') ? $this->LANGUAGE_ENGLISH : $this->LANGUAGE_RUSSIAN ;
        $_SESSION['lang'] = Yii::$app->language ;
        TaskStore::putParam('currentLanguage',$ln) ;
//        $act = (empty($action)) ? 'index' : $action ;
        $url = Url::to([$currentController.'/index' ]) ;
//        echo $url ;
        return $this->redirect($url);
    }
}