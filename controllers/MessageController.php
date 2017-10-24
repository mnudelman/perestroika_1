<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 11.03.17
 * Time: 16:05
 */

namespace app\controllers;

use yii\web\Controller;
use app\controllers\BaseController ;

class MessageController extends BaseController {
    public function actionIndex($act,$id)
    {
        return $this->render('index',['act'=>$act,'id'=>$id]);
    }
}