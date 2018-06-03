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
use app\models\OrderWork ;
use app\models\OrderMailing ;
use app\controllers\funcs\OrderFunc ;

class MailingResponseController extends BaseController
{
    private $recipientId;
    //-- состояние, в которое должен перейти заказ в зависимости от текущего состояния
    private $nextOrderStat = [
        MailingFunc::TYPE_READY_REQUEST => OrderStatFunc::STAT_ANSWERED,
        MailingFunc::TYPE_SELECTED_REQUEST => OrderStatFunc::STAT_SELECTED_ANSWERED,
    ];
    private $errorText = 'Состояние заказа, которое Вы пытаетесь установить,
    пройдено ранее. <br> Войдите в кабинет и разберитесь с текущим состоянием заказа';

    /**
     * подтверждение согласия на участие в конкурсе на исполнение заказа
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
            $nextStat = $this->nextOrderStat[$recipientRole];
            if ($nextStat > $currentStat) {  // можно выполнить
                $oM->addOrderMailing($orderId, $developerId, $nextStat);
            } else {     // error - состояние уже достигнуто
                $success = false;
                $message = $this->errorText;
            }
        }
        if ($success) {
            $this->goToOffice();
        } else {
            $answ = [
                'success' => $success,
                'message' => $message,
                'z_end' => 'end'
            ];
            echo json_encode($answ);
        }
    }

    /**
     * перейти в кабинет
     *
     */
    private function goToOffice()
    {
        $success = false;
        $model = new LoginForm(['scenario' => LoginForm::SCENARIO_AUTOLOGIN]);
        $model->autoUserId = $this->recipientId;
        if ($model->autoLogin()) {
            return $this->render('office/index');
        }

    }
}