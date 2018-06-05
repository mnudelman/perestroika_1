<?php
/**
 * Методы, запускаемые из форм подтверждения,
 * запущенных из email
 */

namespace app\controllers;
use app\controllers\funcs\MailingFunc;
use Yii ;
use app\controllers\funcs\OrderStatFunc ;
use app\controllers\BaseController ;
use app\models\LoginForm ;
use app\models\OrderMailing ;
use app\controllers\funcs\OrderFunc ;
use app\service\TaskStore ;
use yii\helpers\Url;
use app\models\UserProfile ;

class MailingResponseController extends BaseController
{
    private $recipientId;
    //-- состояние, в которое должен перейти заказ в зависимости от текущего состояния
    private $nextOrderStat = [
        MailingFunc::TYPE_READY_REQUEST => OrderStatFunc::STAT_ANSWERED,
        MailingFunc::TYPE_SELECTED_REQUEST => OrderStatFunc::STAT_SELECTED_ANSWERED,
    ];
    private $errorText = [
        'errorOrderStat' =>
            'Состояние заказа, которое Вы пытаетесь установить, пройдено ранее. <br> ' .
             'Войдите в кабинет и разберитесь с текущим состоянием заказа',
        'errorLogin' => 'не удалось выполнить Ваше подключение.<br>'.
            'Войдите по обычной схеме.',
        'errorProfile' => 'Регистрация не завершена. Ошибка профиля'
    ];
    private $userRoleParamName = 'currentUserRole' ; // имя параметра для сохранения
    private $urlTo = [        // адрес перехода
        'office' => '/office/index',
        'home' => '/'
        ] ;
    /**
     * подтверждение согласия на участие в конкурсе на исполнение заказа
     *  или выполнение заказа или любое другое сообщение, когда известен
     *  заказ
     * data = {
     *actionFlag: actionFlag,   // выполнить изменение статуса заказа
     *type: type,       // тип ответа (см. MailingFunc.php)
     *orderId: orderId,          // заказ
     *developerId: developerId,   // исполнитель
     *recipientRole: recipientRole, // роль пользователя-получателя ответа
     *recipientId: recipientId     // id  получателя
     * } ;
     */
    public function actionOrderAnswer()
    {
        $actionFlag = Yii::$app->request->post('actionFlag');   // выполнить изменение статуса заказа
        $type = Yii::$app->request->post('type');       // тип ответа (см. MailingFunc.php)
        $orderId = Yii::$app->request->post('orderId');          // заказ
        $developerId = Yii::$app->request->post('developerId');   // исполнитель
        $recipientRole = Yii::$app->request->post('recipientRole'); // роль пользователя-получателя ответа
        $this->recipientId = Yii::$app->request->post('recipientId');
        (new OrderFunc())->setCurrentOrder($orderId);
        $success = true;
        $message = [];
        if ($actionFlag) {
            $oM = new OrderMailing();
            $currentStat = $oM->getOrderStat($orderId, $developerId);
            $nextStat = $this->nextOrderStat[$type];
            if ($nextStat > $currentStat) {  // можно выполнить
                $oM->addOrderMailing($orderId, $developerId, $nextStat);
            } else {     // error - состояние уже достигнуто
                $success = false;
                $message[] = $this->errorText['errorOrderStat'];
            }
        }
        $currentUrl = $this->urlTo['office'] ;
        if ( !$this->autoLogin()) {
            $message[] = $this->errorText['errorLogin'];
            $success = false ;
            $currentUrl = $this->urlTo['home'] ;
        }

        if ($success) {
            TaskStore::putParam($this->userRoleParamName,$recipientRole) ;

        }
            $answ = [
                'url' => Url::to([$currentUrl]),
                'success' => $success,
                'message' => $message,
                'z_end' => 'end'
            ];
            echo json_encode($answ);
//        if ($success) {
//            Yii::$app->response->redirect(['/office/index']);
//        }

    }

    /**
     *  var data = {
     *  type: type,
     *  recipientId: recipientId
    } ;

     */
    public function actionRegistrationAnswer() {
        $type = Yii::$app->request->post('type');       // тип ответа (см. MailingFunc.php)
        $this->recipientId = Yii::$app->request->post('recipientId');
        $recipientRole =  Yii::$app->request->post('recipientRole');
        $profile = UserProfile::findOne(['userid' => $this->recipientId]);
        $success = true ;
        $userName = null ;
        $email = null ;
        $message = [] ;

        if (empty($profile)) {
            $success = false ;
            $message[] = $this->errorText['errorProfile'] ;
        }else {
            $profile->confirmation_flag = true ;
            $profile->scenario = UserProfile::SCENARIO_EXPRESS ; // иначе может быть ошибка при save
            $profile->save() ;
        }
        $currentUrl = $this->urlTo['home'] ;
        if ($success && !$this->autoLogin()) {
            $message[] = $this->errorText['errorLogin'];
            $success = false;
        }
        if ($success) {
            TaskStore::putParam($this->userRoleParamName,$recipientRole) ;
        }
        $answ = [
            'url' => Url::to([$currentUrl]),
            'success' => $success,
            'message' => $message,
            'z_end' => 'end'
        ];
        echo json_encode($answ);

    }
    /**
     * автоматический login
     *
     */
    private function autoLogin()
    {
        $success = false;
        $model = new LoginForm(['scenario' => LoginForm::SCENARIO_AUTOLOGIN]);
        $model->autoUserId = $this->recipientId;
        return ($model->autoLogin())  ;

    }
}