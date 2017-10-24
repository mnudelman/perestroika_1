<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 09.12.16
 * Time: 21:34
 */

namespace app\controllers;


use yii\web\Controller;
use app\controllers\BaseController ;

class AboutController extends BaseController {
    public function actionIndex()
    {
        return $this->render('index');
    }
    public function action__Language()
    {
        return $this->render('index');
    }
}