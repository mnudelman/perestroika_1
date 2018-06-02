<?php
/**
 * класс операций по отправке email пользователям
 * Time: 19:26
 */

namespace app\controllers\funcs;

use yii\helpers\Url;
use yii\helpers\Html;
use Yii;
use app\service\SimpleEncrypt;
use app\controllers\funcs\OrderStatFunc ;
use app\models\OrderMailing ;
use app\models\OrderWork ;
use app\models\UserProfile ;
class MailingFunc
{
    const TYPE_DETAILS_CUSTOMER = 1; // реквизиты заказчика
    const TYPE_DETAILS_DEVELOPER = 2;// реквизиты исполнителя
    const TYPE_READY_REQUEST = 3;    // запрос ИСПОЛНИТЕЛЮ на участие в конкурсе на исполнение заказа
    const TYPE_SELECTED_REQUEST = 4; // запрос ИСПОЛНИТЕЛЮ о согласии выполнить заказа
    const TYPE_REGISTRATION = 5;     // подтверждение регистрации
    const TYPE_EXPRESS = 6;          // экспресс регистрация
    protected  $types = [
        self::TYPE_DETAILS_CUSTOMER => [    // реквизиты заказчика
            'sendId' => ['developer_userAlias','customer_userAlias','orderAlias'],
            'urlAnswer' => '',
            'tpl' => 'detailsCustomerTpl',
            'answerTpl' => 'detailsCustomerAnswerTpl',
            'addressee' => 'developer_email',     // email адресата
            'recipient' => 'developer_userAlias', // получатель ответа

        ],
        self::TYPE_DETAILS_DEVELOPER => [    // реквизиты исполнителя
            'sendId' => ['customer_userAlias','developer_userAlias','orderAlias'],
            'urlAnswer' => '',
            'tpl' => 'detailsDeveloperTpl',
            'answerTpl' => 'detailsDeveloperAnswerTpl',
            'addressee' => 'customer_email',     // email адресата
            'recipient' => 'customer_userAlias', // получатель ответа
        ],
        self::TYPE_SELECTED_REQUEST => [     // запрос ИСПОЛНИТЕЛЮ о согласии выполнить заказа
            'sendId' => ['developer_userAlias', 'orderAlias'],
            'urlAnswer' => '',
            'tpl' => 'selectedRequestTpl',
            'answerTpl' => 'selectedRequestAnswerTpl',
            'addressee' => 'developer_email',     // email адресата
            'recipient' => 'developer_userAlias', // получатель ответа
        ],
        self::TYPE_READY_REQUEST => [        // запрос ИСПОЛНИТЕЛЮ на участие в конкурсе на исполнение заказа
            'sendId' => ['developer_userAlias', 'orderAlias'],
            'urlAnswer' => '',
            'tpl' => 'readyRequestTpl',
            'answerTpl' => 'readyRequestAnswerTpl',
            'addressee' => 'developer_email',     // email адресата
            'recipient' => 'developer_userAlias', // получатель ответа
        ],
        self::TYPE_REGISTRATION => [     // подтверждение регистрации
            'sendId' => ['user_userAlias'],
            'urlAnswer' => '',
            'tpl' => 'registrationTpl',
            'answerTpl' => 'registrationAnswerTpl',
            'addressee' => 'user_email',     // email адресата
            'recipient' => 'user_userAlias', // получатель ответа
        ],
        self::TYPE_EXPRESS => [            // экспресс регистрация
            'sendId' => ['user_userAlias'],
            'urlAnswer' => '',
            'tpl' => 'expressTpl',
            'answerTpl' => 'expressAnswerTpl',
            'addressee' => 'user_email',     // email адресата
            'recipient' => 'user_userAlias', // получатель ответа
            'password' => '',               // пароль для экспресс регистрации
        ],
    ];
    //-- длина компонентов передаваемого id
    protected $sendIdLen = [
        'userAlias' => 10,
        'orderAlias' => 10,
        'key' => 10
    ];
    //-- дополнительные символы для формировании базовой строки
    private $addString = 'UY-UMSMADUseGcgygrogm13lKp6JDCvh' .
    'FUBlLz7B7cmUnb759TVqLSb4FLteHpOB';
    //--- пользователь с указанием роли
    protected $userRole = [
        OrderStatFunc::USER_ROLE_CUSTOMER => [],
        OrderStatFunc::USER_ROLE_DEVELOPER => [],
        OrderStatFunc::USER_ROLE_USER => [],
    ] ;

    protected $order = [
        'orderId' => '',
        'orderName' => '',
        'orderAlias' => '',
        'timeCreate' => '',
        'deadline' => '',
        ];
    protected $currentType;
    //-- параметры для вычисления $totalId
    private $encrypt = [
        'start' => 0,
        'step' => 2,
        'len' => 10,
    ];

    private $encryptObj = null;
    //---- общий заголовок сообщений
    private $headBodyText =
        'Портал <b>Pere-stroika</b> сообщает <br>';
    private $debugFlag = false ;
    private $urlAnswerDefault = 'site/email-response' ;


    public function __construct()
    {
        $this->encryptObj = new SimpleEncrypt();
    }
    public function setDebug($debug = true) {
        $this->debugFlag = $debug ;
        return $this ;
    }
    /**
     * атрибуты для email, связанного с состоянием зеказа
     * @param $orderId
     * @param $DeveloperId
     * @param $deadline
     */
    public function setOrderAttr($orderId,$developerId) {
        $orderMailing = new OrderMailing() ;
        $orderRec = $orderMailing->getById($orderId,$developerId) ;
        $this->order['orderId'] = $orderId ;
        $this->order['deadline'] = $orderRec->time_deadline ;
        $oW = OrderWork::findOne($orderId) ;
        if (empty($oW->alias_id)) {
            $oW = (new OrderWork())->addOrder($orderId) ;
        }

        $customerId = $oW->userid ;        // заказчик
        $this->order['orderName'] = $oW->order_name ;
        $this->order['orderAlias'] = $oW->alias_id ;
        $this->order['timeCreate'] = $oW->time_create ;
        $this->userRole[OrderStatFunc::USER_ROLE_CUSTOMER] =
            $this->getUserAttr($customerId) ;
        $this->userRole[OrderStatFunc::USER_ROLE_DEVELOPER] =
            $this->getUserAttr($developerId) ;
        return $this ;
    }
    private function getUserAttr($userId) {
        $profile = UserProfile::findOne(['userid'=>$userId]) ;
        return [
            'userId' => $userId,
            'email'  => $profile->email,
            'companyName' => $profile->company,
            'userAlias' => $profile->confirmation_key,
            'tel' => $profile->tel,          // при передаче реквизитов

        ] ;
    }

    /**
     * атрибуты пользователя для подтверждения регистрации
     * @param $userId
     * @param $password - для экспресс регистрации
     * @return $this
     */
    public function setRegistrationAttr($userId, $password='')
    {
        $userAttr = $this->getUserAttr($userId) ;
        $userAttr['password'] = $password ;
        $this->userRole[OrderStatFunc::USER_ROLE_USER] = $userAttr ;
        return $this;
    }
    public function setType($type)
    {
        $this->currentType = $type;
        return $this;
    }

    public function sendDo()
    {
// переменные получают имя с префиксом <role>_
        foreach ($this->userRole as $role => $attr) {
            if (!empty($attr)) {
                extract($attr,EXTR_PREFIX_ALL,$role) ;
            }
        }


        $tpl = '' ;
        $email = '' ;
        extract($this->order);
        $typeAttr = $this->types[$this->currentType];
        extract($typeAttr);
        $headBodyText = $this->headBodyText ;
       $textArr = include  __DIR__ . '/tpl/' . $tpl . '.php';
       $subject = $textArr['subject'];
       $textBody = $headBodyText . $textArr['bodyText'];
       $referText = $textArr['referText'];
       $totId = $this->getTotalId();
       $emailAddressee = $this->getAddressee() ;
       $urlAnswer = $typeAttr['urlAnswer'] ;
        $urlAnswer = (empty($urlAnswer)) ? $this->urlAnswerDefault : $urlAnswer ;
       $siteUrl = Url::to([$urlAnswer, 'mailId' => $totId], true);
        $a = Html::a($referText, $siteUrl);     // ссылка для возврата на сайт
        if ($this->debugFlag) {
            echo $textBody . ' ' . $a . '<br>' ;
        }else {
            Yii::$app->mailer->compose()
//            ->setFrom('mnudelman@yandex.ru')
                ->setTo($emailAddressee)
                ->setSubject($subject)
//            ->setTextBody($addText .' '.'Для подтверждения корректности email перейдите по ссылке ' . $siteUrl)
                ->setHtmlBody($textBody . ' ' . $a)
                ->send();
        }
    }

    /**
     * получить email - адресата
     *
     */
    private function getAddressee() {
        $typeDescript = $this->types[$this->currentType];
        $addresseeText = $typeDescript['addressee'] ;
        $type = $this->currentType ;
        if (!empty($addresseeText)) {
            list($type, $mail) = explode('_', $addresseeText);
        }
        return $this->userRole[$type]['email'] ;
    }

    /**
     * определить id - параметр для ссылки возврата на сайт в сообщении
     * атрибут sendId содержит набор компонентов для сборки id
     * чтобы лишить читаемого вида включается простая шифрация
     * параметр шифрации start определяет тип сообщения
     * @return string
     */
    private function getTotalId()
    {
        $typeDescript = $this->types[$this->currentType];
        $sendIdArr = $typeDescript['sendId'];
        $totalId = '';
        for ($i = 0; $i < sizeof($sendIdArr); $i++) {
            $componentText = $sendIdArr[$i] ;
            $type = '' ;
            $component = '' ;
            if (strpos($componentText,'_') > 0) {
                $componentArr = explode('_',$sendIdArr[$i]) ;
                list($type,$component) = $componentArr ;
            }else {
                $component = $componentText ;
            }


            switch ($component) {
                case 'userAlias' :
                    $totalId .= $this->userRole[$type]['userAlias'];
                    break;
                case 'orderAlias' :
                    $totalId .= $this->order['orderAlias'];
                    break;
            }
        }
        $baseString = $totalId . $this->addString;
        $encrypt = $this->encrypt;           // паарметры шифрования
        $obj = $this->encryptObj;
        $start = 0;
        $step = 0;
        $len = 0;
        extract($encrypt);
        $start = $this->currentType ;
        $cipher = $obj->setKey($this->currentType, $start, $step, $len)
            ->encryptDo($baseString);
        return $totalId . $cipher;
    }

    public function unencriptMailId($mailId)
    {
        $cipherLen = $this->encrypt['len'];
        $ln = strlen($mailId);
        $cipher = ($ln > $cipherLen) ?
            substr($mailId, -$cipherLen) : 'zzzz';
        $encryptObj = $this->encryptObj;

        $params = ($ln > $cipherLen) ?
            substr($mailId, 0, $ln - $cipherLen) : '';
        $baseStr = $params . $this->addString;
        $key = $encryptObj->getUnencryptKey($baseStr, $cipher);
        $paramVect = [];
        if (false === $key) {
            return false;
        } else {
            $this->currentType = $key['start'];
            $sendIdArr = $this->types[$this->currentType]['sendId'];
            $paramVect['mailingType'] = $this->currentType ;

            for ($i = 0; $i < sizeof($sendIdArr); $i++) {
                $componentText = $sendIdArr[$i];
                $userRole = '' ;
                $component = '' ;
                if (strpos($componentText,'_') > 0) {
                    $componentArr = explode('_',$sendIdArr[$i]) ;
                    list($userRole,$component) = $componentArr ;
                }else {
                    $component = $componentText ;
                }





                $ln = $this->sendIdLen[$component];
                $componemtValue = substr($params, 0, $ln);
                if (empty($userRole)) {
                    $paramVect[$component] = $componemtValue;
                }else {
//                    $paramVect[$component] = [
//                        'userRole' => $userRole,
//                        'aliasId' => $componemtValue,
//                    ] ;
                    $paramVect['userAlias'][] = [
                        'userRole' => $userRole,
                        'aliasId' => $componemtValue,
                    ] ;

                }

                $params = (strlen($params) > $ln) ? substr($params, $ln) : '';
            }
        }
        return $paramVect;
    }

}