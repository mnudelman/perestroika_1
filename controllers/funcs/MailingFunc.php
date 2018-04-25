<?php
/**
 * класс операций по отправке email пользователям
 * Time: 19:26
 */

namespace app\controllers\funcs;
use yii\helpers\Url ;
use yii\helpers\Html ;
use Yii ;
use app\service\SimpleEncrypt ;

class MailingFunc
{
    const TYPE_DETAILS_CUSTOMER = 1 ; // реквизиты заказчика
    const TYPE_DETAILS_DEVELOPER = 2 ;// реквизиты исполнителя
    const TYPE_READY_REQUEST = 3 ;    // запрос ИСПОЛНИТЕЛЮ на участие в конкурсе на исполнение заказа
    const TYPE_SELECTED_REQUEST = 4 ; // запрос ИСПОЛНИТЕЛЮ о согласии выполнить заказа
    const TYPE_REGISTRATION = 5 ;     // подтверждение регистрации
    const TYPE_EXPRESS = 6 ;          // экспресс регистрация
    private $types = [
        self::TYPE_DETAILS_CUSTOMER => [    // реквизиты заказчика
            'sendId' => ['userAlias'],
            'urlAnswer' => '',
            'tpl' => '',
            'encrypt' => []
        ],
        self::TYPE_DETAILS_DEVELOPER => [    // реквизиты исполнителя
            'sendId' => ['userAlias'],
            'urlAnswer' => '',
            'tpl' => '',
            'encrypt' => []
        ],
        self::TYPE_SELECTED_REQUEST=> [     // запрос ИСПОЛНИТЕЛЮ о согласии выполнить заказа
            'sendId' => ['userAlias','orderAlias'],
            'urlAnswer' => '',
            'tpl' => '',
            'encrypt' => []
        ],
        self::TYPE_READY_REQUEST => [        // запрос ИСПОЛНИТЕЛЮ на участие в конкурсе на исполнение заказа
            'sendId' => ['userAlias','orderAlias'],
            'urlAnswer' => '',
            'tpl' => '',
            'encrypt' => []
        ],
        self::TYPE_REGISTRATION => [     // подтверждение регистрации
            'sendId' => ['userAlias'],
            'urlAnswer' => '',
            'tpl' => '',
            'encrypt' => []

        ],
        self::TYPE_EXPRESS => [            // экспресс регистрация
            'sendId' => ['userAlias'],
            'urlAnswer' => '',
            'tpl' => '',
            'encrypt' => []

        ],
    ];
    //-- длина компонентов передаваемого id
    private $sendIdLen = [
        'userAlias' => 10,
        'orderAlias'=> 10,
        'key' => 10
    ] ;
    //-- дополнительные символы для формировании базовой строки
    private $addString = 'UY-UMSMADUseGcgygrogm13lKp6JDCvh' .
                          'FUBlLz7B7cmUnb759TVqLSb4FLteHpOB';
    private $urlAnswer = 'site/mail-answer' ;
// substr(\Yii::$app->security->generateRandomString(),-10)
    private $sendId;
    // атрибуты, передавемые через set....
    private $deadline;
    private $user = [
        'userId' => '',
        'userName' => '',
        'password' => '',     //  передаётся при экспресс регистрации
    ];
    private $userProfile = [
        'email' => '',
        'companyName' => '',
        'userAlias' => '',
        'tel' => '',          // при передаче реквизитов
    ];
    private $order = [
        'orderId' => '',
        'orderName' => '',
        'orderAlias' => '',
        'timeCreate' => '',
    ];
    private $currentType;
    //-- параметры для вычисления $totalId
    private $encrypt = [
        'start' => 0,
        'step' => 2,
        'len' => 10,
     ] ;

    private $encryptObj = null ;
    //---- общий заголовок сообщений
    private $headBodyText =
        'Портал <b>Pere-stroika</b> сообщает Вам (<b> companyName </b>)<br>' ;
    public function __construct() {
            $this->encryptObj = new SimpleEncrypt() ;
    }

    public function setUser($userId, $userName)
    {
        $this->user = compact(array_keys($this->user));
        return $this ;
    }

    public function setUserProfile($email, $companyName, $userAlias)
    {
        $this->userProfile = compact(array_keys($this->userProfile));
        return $this ;
    }

    public function setOrder($orderId, $orderAlias, $orderName, $timeCreate)
    {
        $this->order = compact(array_keys($this->order));
        return $this ;
    }

    public function setDeadline($deadline)
    {
        $this->deadline = $deadline;
        return $this ;
    }

    public function setType($type)
    {
        $this->currentType = $type;
        return $this ;
    }

    public function sendDo()
    {
//     $addText = 'Портал <b>Pere-stroika</b> сообщает Вам,(<b>' . $company . '</b>)<br>' .
//         'что компания выбрана ИСПОНИТЕЛЕМ работ по заказу <b> № ' . $aliasId .
//         '(' . $orderName .')</b><br>' ;
//     $totId = $id . '-' . $aliasId ;
//     $siteUrl = Url::to(['site/order-selected-email','id'=>$totId],true) ;
//     $text = 'Для подтверждения вашей готовности выполнить работы и ' .
//         'получить реквизиты заказчика перейдите по ссылке ' ;
//     $a = Html::a($text, $siteUrl) ;
//     Yii::$app->mailer->compose()
////            ->setFrom('mnudelman@yandex.ru')
//         ->setTo($email)
//         ->setSubject('Pere-stroika. Вы выбраны исполнителем работ')
////            ->setTextBody($addText .' '.'Для подтверждения корректности email перейдите по ссылке ' . $siteUrl)
//         ->setHtmlBody($addText .' '.$a)
//         ->send();
//
        extract($this->user);
        extract($this->order);
        extract($this->userProfile);
        $typeAttr = $this->types[$this->currentType];
        extract($typeAttr);
       $headBodyText = str_replace('companyName',$companyName,$this->headBodyText)
       $textArr =  include __DIR__ . '/tpl/' . $tpl ;
       $subject = $textArr['subject'] ;
       $textBody = $headBodyText . $textArr['bodyText'] ;
       $refText =  $textArr['refText'] ;
       $totId = $this->getTotalId() ;
       $siteUrl = Url::to(['site/order-selected-email','id'=>$totId],true) ;
        $a = Html::a($refText, $siteUrl) ;
     Yii::$app->mailer->compose()
//            ->setFrom('mnudelman@yandex.ru')
         ->setTo($email)
         ->setSubject($subject)
//            ->setTextBody($addText .' '.'Для подтверждения корректности email перейдите по ссылке ' . $siteUrl)
         ->setHtmlBody($textBody .' '.$a)
         ->send();

    }

    private function getTotalId() {
        $typeDescript = $this->types[$this->currentType] ;
        $sendIdArr = $typeDescript['sendId'] ;
        $totalId = '' ;
        for ($i = 0; $i < sizeof($sendIdArr); $i++) {
            switch ($sendIdArr[$i]) {
                case 'userAlias' :
                    $totalId .= $this->userProfile['userAlias'] ;
                    break ;
                case 'orderAlias' :
                    $totalId .= $this->order['orderAlias'] ;
                    break ;
            }
        }
        $baseString = $totalId . $this->addString ;
        $encrypt = $this->encrypt ;           // паарметры шифрования
        $tuneEncrypt = $sendIdArr['encript'] ;
        foreach ($tuneEncrypt as $key => $value) {
            $encrypt[$key] = $value ;
        }
        $obj = $this->encryptObj ;
        extract($encrypt) ;
        $cipher = $obj ->setKey($this->currentType,$start,$step,$len)
            ->encryptDo($baseString) ;
        return $totalId . $cipher ;
    }
    public function unencriptMailId($mailId) {
        $cipherLen = $this->encrypt['len'] ;
        $cipher =  substr($mailId,-$cipherLen) ;
        $encryptObj = $this->encryptObj ;
        $ln = strlen($mailId) ;
        $params = substr($mailId,0,$ln - $cipherLen) ;
        $baseStr = $params . $this->addString;
        $key = $encryptObj->getUnencryptKey($baseStr,$cipher) ;
        $this->currentType = $key['start'] ;
        $sendIdArr = $this->types[$this->currentType]['sendId'] ;
        $paramVect = ['mailingType' => $this->currentType] ;

        for ($i = 0; $i < sizeof($sendIdArr); $i++) {
            $name = $sendIdArr[$i];
            $ln = $this->sendIdLen[$name];
            $paramVect[$name] = substr($params, 0, $ln);
            $params = substr($params, $ln);
        }
        return $paramVect ;
    }

}