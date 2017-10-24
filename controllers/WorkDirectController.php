<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 18.12.16
 * Time: 19:54
 */

namespace app\controllers;

use yii\web\Controller;
use app\controllers\BaseController ;
use Yii ;

class WorkDirectController extends BaseController {
    public function actionIndex($wdId)
    {
        if( Yii::$app->request->isAjax ){
            $query = Yii::$app->request->post() ;
            debug($_GET);
            return 'test';
        }
    }
}