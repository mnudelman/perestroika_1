<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 09.12.16
 * Time: 21:37
 */

namespace app\controllers;


use yii\web\Controller;
use app\controllers\BaseController ;

class OfficeController  extends BaseController {
    public function actionIndex()
    {
        return $this->render('index');
    }
}