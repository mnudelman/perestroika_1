<?php
/**
 * Методы, запускаемые из форм подтверждения,
 * запущенных из email
 */

namespace app\controllers;
use Yii ;
use app\models\OrderMailing ;
use app\controllers\BaseController ;
use app\models\LoginForm ;
class MailingResponseController extends BaseController {
    private $userId ;
    private $orderId ;
    //-- типы ответа на предложение ---- //
    private $ANSWER_TYPE_YES = 'yes' ;
    private $ANSWER_TYPE_NO = 'no' ;
    private $ANSWER_TYPE_OFFICE = 'office' ;
    //-- состояние, в которое должен перейти заказ в зависимости от текущего состояния
    private $nextOrderStat = [
        'order' => OrderMailing::STAT_ANSWERED,
        'orderSelected' => OrderMailing::STAT_SELECTED_ANSWERED ,
    ] ;

    /**
     * подтверждение согласия на участие в конкурсе на исполнение заказа
     */
 public function actionOrderAnswer() {
     $answerName =  Yii::$app->request->post('answerName');
     $this->userId = Yii::$app->request->post('userId');
     $this->orderId = Yii::$app->request->post('orderId');
     $answerType = Yii::$app->request->post('answerType');
     if ($answerType === $this->ANSWER_TYPE_YES && isset($this->nextOrderStat[$answerName]) ) {
         $nextStat = $this->nextOrderStat[$answerName] ;
         $this->setOrderStat($nextStat) ;
     }
     $this->goToOffice() ;
 }
 public function actionConfirmationAnswer() {

 }

    /**
     * перейти в кабинет
     *
     */
 private function goToOffice() {
     $success = false ;
     $model = new LoginForm(['scenario' => LoginForm::SCENARIO_AUTOLOGIN]);
     $model->autoUserId = $this->userId ;
     if ($model->autoLogin()) {
         return $this->render('office/index');
     }

 }
 private function setOrderStat($nextOrderStat) {
     $orderId = $this->orderId ;
     $userId = $this->userId ;
     $orderMailing = (new OrderMailing())
         ->addOrderMailing($orderId, $userId, $nextOrderStat);
     $success = (!empty($orderMailing));
     return $success ;
 }
}