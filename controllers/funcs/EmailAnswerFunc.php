<?php
/**
 * класс - обработка ответа по email
 * Time: 15:57
 */

namespace app\controllers\funcs;
use app\controllers\funcs\MailingFunc ;
use app\models\OrderWork ;
use app\models\UserProfile ;

class EmailAnswerFunc extends MailingFunc {
    private $mailVectStruct = [
        'type' => '*',    // тип сообщения - всегда
        'userAlias' => ['userRole' => '*', 'aliasId' => '*'], // всегда
        'orderAlias' => '',   // только для запросов подтверждения
    ] ;
    private $errorTpl = 'errorAnswerTpl' ;
    private $clickParms = [
        'orderParms' =>
            ['type','orderId','developerId','recipientRole','recipientId'],
        'noOrderParms' => ['type','recipientId'],
    ] ;
    //------------------------------------------------//

    /**
     * добавить параметры для click
     */
    private function init() {
        $orderParms = $this->clickParms['orderParms'] ;
        $noOrderParms = $this->clickParms['noOrderParms'] ;
        $this->types[self::TYPE_DETAILS_CUSTOMER]['clickParms'] =
            $orderParms ;
        $this->types[self::TYPE_DETAILS_DEVELOPER ]['clickParms'] =
            $orderParms ;
        $this->types[self::TYPE_READY_REQUEST]['clickParms'] =
            $orderParms ;
        $this->types[self::TYPE_SELECTED_REQUEST]['clickParms'] =
            $orderParms ;
        $this->types[self::TYPE_REGISTRATION]['clickParms'] =
            $noOrderParms ;
        $this->types[self::TYPE_EXPRESS]['clickParms'] =
            $noOrderParms ;
    }
    public function responseDo($mailId)
    {
        $this->init() ;
        $mailVect = $this->unencriptMailId($mailId);
        $tplFile = '';
        $orderId = '';
        $developerId = '';
        $customerId = '';
        $userId = '';
        $recipientId = '';
        if (false === $mailVect) {
            $tplFile = $this->errorTpl;
            $this->currentType = 'error';
        } else {
            $this->currentType = $mailVect['mailingType'];
            $orderAlias = (isset($mailVect['orderAlias'])) ? $mailVect['orderAlias'] : '';
            $userAliasArr = (isset($mailVect['userAlias'])) ? $mailVect['userAlias'] : '';
            $tplFile = $this->types[$this->currentType]['answerTpl'];
            $recipient = $this->types[$this->currentType]['recipient'];

            //       ---------------------------

            if (!empty($orderAlias)) {
                $oW = OrderWork::findOne(['alias_id' => $orderAlias]);
                $orderId = $oW->id;
            }
            if (!empty($userAliasArr)) {
                for ($i = 0; $i < sizeof($userAliasArr); $i++) {
                    $userAlias = $userAliasArr[$i];
                    $aliasId = $userAlias['aliasId'];
                    $userRole = $userAlias['userRole'];
                    $profile = UserProfile::findOne(['confirmation_key' => $aliasId]);
                    $idName = $userRole . 'Id';
                    $$idName = $profile->userid;

                }

            }
            if (!empty($developerId) && !empty($orderId)) {
                $this->setOrderAttr($orderId, $developerId);
            } else {
                $userId = (!empty($developerId)) ? $developerId :
                    ((!empty($customerId)) ? $customerId : $userId);
                $this->setRegistrationAttr($userId);
            }
            //       выделяем тип и usrAlias из recipient - получатель сообщ на сайте
            $recipientArr = explode('_', $recipient);
            $recipientRole = $recipientArr[0];
            $recipientUserAlias = $this->userRole[$recipientRole]['userAlias'];
            $profile = UserProfile::findOne(
                ['confirmation_key' => $recipientUserAlias]);
            $recipientId = $profile->userid;

            // переменные получают имя с префиксом <role>_
            foreach ($this->userRole as $role => $attr) {
                if (!empty($attr)) {
                    extract($attr, EXTR_PREFIX_ALL, $role);
                }
            }
            extract($this->order);
            $typeAttr = $this->types[$this->currentType];
            extract($typeAttr);
        }
        $textArr = include __DIR__ . '/tpl/' . $tplFile . '.php';
        //$textArr =['tile'=> '*',bodyText => '*','buttons' => []]
        $paramList = $this->types[$this->currentType]['clickParms'];
        $type = $this->currentType ;
        $res = [
            'type' => $this->currentType,
            'orderId' => $orderId,
            'developerId' => $developerId,
            'customerId' => $customerId,
            'userId' => $userId,
            'clickParms' => compact($paramList),
            'recipient' => ['userRole' => $recipientRole,
                'userId' => $recipientId],
            'message' => $textArr,
        ];
        return $res;
    }
}