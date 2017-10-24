<?php
/**
 *  профиль исполнителя
 */

namespace app\controllers;
use app\controllers\BaseController ;
use Yii ;
use app\models\UserProfile ;
use app\service\TaskStore ;
use app\components\UserGeography ;
use app\service\Files ;
use app\models\WorkCountry ;
class DeveloperProfileController extends BaseController {
    private $developerId = null;      // текущий исполнитель
    private $DEVELOPER_PARAM_NAME = 'currentDeveloper' ;
    public function actionIndex()
    {
        return $this->render('index');
    }
//setDeveloper: urlPrefix + 'set-developer',
//profileGeneral: urlPrefix + 'get-profile-general',
//profileWorks: urlPrefix + 'get-profile-works',
//profileGeography: urlPrefix + 'get-profile-geography',
//profileAdditional: urlPrefix + 'get-profile-additional'
    /**
     * текущий исполнитель
     */

    public function actionSetDeveloper()
    {
        $this->developerId = Yii::$app->request->post('developerId');
        $developer = ['id' => $this->developerId];
        TaskStore::putParam($this->DEVELOPER_PARAM_NAME, $developer);
        $answ = [
            'success' => true,
            'message' => [],
            'z-end' => 'zend'
        ];
        echo json_encode($answ);
    }

    private function getDeveloperId()
    {
        $developerId = $this->developerId;
        if (empty($developerId)) {
            $developer = TaskStore::getParam($this->DEVELOPER_PARAM_NAME) ;
            $developerId = $developer['id'] ;
        }
        $this->developerId = $developerId ;
        return $developerId ;
    }
    public function actionGetProfileGeneral() {
        $developerId = $this->getDeveloperId() ;
        $profile = (new UserProfile())->getByUserId($developerId) ;
        $message = $profile->errors ;
        $success = (sizeof($message) === 0) ;
        $geography = [] ;
        $avatar = '' ;
        if($success) {
            $geography = (new UserGeography())->setCityId($profile['city_id'])
                ->getOwnGeography() ;
            $avatarPath = Files::getPath('userAvatar',$developerId) ;
            $avatar = $avatarPath['url'] . '/' . $profile['avatar'] ;
        }
        $answ = [
            'opCod' => 'getProfileGeneral',
            'success' => $success,
            'message' => $message,
            'general' => [
                'company' => ($success) ? $profile['company'] : '',
                'avatar' =>  $avatar,
                'info' =>    ($success) ? $profile['info'] : '',
                'geography' => $geography,
            ],
        ] ;
        echo json_encode($answ) ;
    }

    /**
     * верхний уровень - список стран
     */
    public function actionGetProfileGeography() {
        $developerId = $this->getDeveloperId() ;
        $countryList = (new WorkCountry())->setUserId($developerId)->getList() ;
        $res = [] ;
        foreach ($countryList as $ind => $countryItem) {
            $res[] = [
                'id' => $countryItem['country']['id'],
                'name' => $countryItem['country']['name'],
            ] ;
        }

        $answ = [
            'opCod' => 'getProfileGeography',
            'success' => true,
            'message' => [],
            'countryList' => $res,
        ] ;
        echo json_encode($answ) ;
    }
}