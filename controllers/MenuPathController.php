<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 23.06.17
 * Time: 14:46
 */

namespace app\controllers;
use app\models\MenuPath ;
use Yii ;
use yii\base\Controller ;
class MenuPathController extends Controller{
    private $menuPathModel = null ;
    public function actionAddMenuItem() {
        $this->defineModel() ;
        $menuItemId = Yii::$app->request->post('menuItemId');
        $this->menuPathModel->addNewItem($menuItemId) ;
        $this->getMenuPath() ;
    }
    public function getMenuPath() {
        $this->defineModel() ;
        $object = $this->menuPathModel->getMenuPath() ;
        $answ = [
            'success' => true,
            'message' => [],
            'menuPath' => $object,
        ] ;
        echo json_encode($answ) ;
    }
    private function defineModel() {
        if (empty($this->menuPathModel)) {
            $this->menuPathModel = new MenuPath() ;
        }

    }
}