<?php
/**
 * контролирует операции регистрации, изменения профайла, изменение пароля
 * работает с моделями UserRegistr, UserProfile
 * регистрация получает данные через ajax, если валидация успешна, то создаётся объект
 * user = new yii\app\model\user с id.
 */

namespace app\controllers;


use app\service\Files;
use yii\helpers\Url;
use yii\helpers\Html ;
use yii\web\Controller;
use Yii;
use app\models\UserProfile;
use app\models\UserRegistration;
use app\models\LoginForm;
use app\service\PageItems ;
use app\controllers\funcs\MailingFunc ;
use app\models\User ;



class UserController extends BaseController
{
    private $_registrationSuccessMessage = '' ;
    private $_registrationErrorMessage = '' ;
    private $_profileSuccessMessage = '' ;
    private $_profileErrorMessage = '' ;

    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionExpressRegistration()
    {
        $expressMessage =
            PageItems::getItemText(['user', 'forms', 'expressForm', 'rules', 'messages']);
        $profileMessage =
            PageItems::getItemText(['user', 'forms', 'profileForm', 'rules', 'messages']);
        $userIsGuest = Yii::$app->user->isGuest;
        $expressForm = Yii::$app->request->post('expressForm');
        $email = $expressForm['email'];
        $tel = $expressForm['tel'];
        $company = $expressForm['company'];
        $userName = $email;
        $password = substr(\Yii::$app->security->generateRandomString(), -UserRegistration::PASSW_MIN_LENGTH);
        $userProfile = null;
        $success = false;
        $message = [];
        $userLogin = [];
        $profileModel = new UserProfile(['scenario' => UserProfile::SCENARIO_EXPRESS]);
        $profileModel->attributes  = $expressForm;
        $profileValidFlag = $profileModel->validate();
        $message = array_merge($message, $profileModel->errors);
        $confirmationMessage = [] ;
//   проверить userProfile на наличие email, если есть, считаем это ошибкой. Предлагаем нормальный вход и
//   затем продолжить
//        if ($profileValidFlag) {
            if ($userIsGuest) {
                if ($profileValidFlag) {
                    $userProfile = $profileModel->getByEmail($email);

                    if (!empty($userProfile)) {
                        $success = false;
                        $message['email'][] = $expressMessage['impersonation']; // подмена пользователя

                    } else {
// сначала регистрация
                        $userRegistration = new UserRegistration();
                        $userRegistration->attributes =
                            ['username' => $email, 'enterPassword' => $password, 'enterPassword_repeat' => $password];
                        $success = $userRegistration->saveRegistration();
                        $message = array_merge($message,$userRegistration->errors) ;
//-----------------------
                        $model = new LoginForm();
                        $userId = false;
                        $userIsGuest = true;
                        $model->attributes = (['username' => $userName, 'password' => $password]);
                        if ($model->login()) {
                            $userId = Yii::$app->user->getId();
                            $userLogin = User::findByUsername($userName);
                            $userProfile = $profileModel->getByUserId($userId);
                            $userProfile->attributes = ['email' => $email, 'tel' => $tel, 'company' => $company];
                            $userProfile->scenario = UserProfile::SCENARIO_EXPRESS ;
//            $success = $userProfile->save();
                            $success = $userProfile->saveProfile();
                            $message = array_merge($message, $userProfile->errors);
                        }
                        $message = array_merge($message, $model->errors);


                    }
                }
            }else  {
                $userId = Yii::$app->user->identity->getId();
                // экспресс - регистрация-> новый пароль
                $userRegistration = new UserRegistration();
                $user = $userRegistration->getByUserId($userId) ;
                $userRegistration->changePassword($userId,$password) ;
                $message = array_merge($message,$userRegistration->errors) ;
                $userName = $user->username ;




                $profileModel = new UserProfile(['scenario' => UserProfile::SCENARIO_EXPRESS]);
                $userProfile = $profileModel->getByUserId($userId);
                $oldAttributes = $userProfile->attributes;
                $userProfile->emailPrev = $oldAttributes['email'];
                $userProfile->attributes =['email' => $email, 'tel' => $tel, 'company' => $company];
                $userLogin = User::findIdentity($userId)->attributes;
//            $success = $userProfile->save();
                $userProfile->scenario = UserProfile::SCENARIO_EXPRESS ;
                $success = $userProfile->saveProfile();
            }
            if (!empty($userProfile)) {
                if (!$userProfile->confirmation_flag) {
//                    $this->sendEmailConfirmation($userProfile->confirmation_key,$email,true,$userName,$password);
//                    sendEmailConfirmation($id,$email,$expressFlag = false,$login = false,$password = false)

//             отправить email  для подтверждения
                    (new MailingFunc())
                     -> setType(MailingFunc::TYPE_EXPRESS)
                        ->setRegistrationAttr($userId,$password)
                        ->sendDo() ;

                    }
                $message = array_merge($message,$userProfile->errors) ;
                $confirmationFlag = $userProfile->confirmation_flag ;
                $confirmationMessage = ($confirmationFlag) ? '' : $profileMessage['confirmation'] ;
            }



        $answ = [
            'opcod' => 'expressRegistration',
            'success' => $success,
            'message' => $message,
            'confirmationMessage' => $confirmationMessage,    // ссобщение о подтверждении почты
            'userProfile' => ($userProfile === null) ? [] :$userProfile->attributes,
            'userLogin' => $userLogin,
            'userIsGuest' => $userIsGuest,
            'z_end' => 'end'
        ];
        echo json_encode($answ);


    }
    public function actionRegistration()
    {
//        if (!Yii::$app->user->isGuest) {
//            return $this->goHome();
//        }
        $_registrationMessage =
            PageItems::getItemText(['user','forms','registrationForm','rules','messages']) ;
        $_profileMessage =
            PageItems::getItemText(['user','forms','profileForm','rules','messages']) ;

        $success = false;
        $successUser = false ;
        $successProfile = false ;
        $profile = UserProfile::find() ;
        $uid = false ;
        $userIsGuest = Yii::$app->user->isGuest ;
        $avatar = false ;
        $urlAvatar = false ;
        if  ($userIsGuest) {
            $userRegistration =new UserRegistration();
            $userRegAttr = (Yii::$app->request->post('UserRegistration'));
            $userRegistration->enterPassword_repeat = $userRegAttr['enterPassword_repeat'];
            $successUser = $userRegistration->load(Yii::$app->request->post()) &&
                           $userRegistration->saveRegistration() ;
        }else {
            $uid = Yii::$app->user->identity->id ;
            $userRegistration =UserRegistration::findOne($uid) ;
            $successUser = true ;
        }
        $errors = (isset($userRegistration->errors)) ? $userRegistration->errors : [];

//        $errors = (isset($profile->errors)) ? array_merge($errors, $profile->errors) : $errors;
        $userAttributes = ($successUser) ?  $userRegistration->attributes : [0] ;
//        $profileAttributes = ($successProfile) ? $profile->attributes : [0] ;


        if (Yii::$app->request->isAjax) {
            $answ = [
                'success' => $successUser && $successProfile,
                'successUser' => $successUser,
                'successProfile' => $successProfile,
                'message' => $errors,
                'userAttributes' => $userAttributes,
//                'profileAttributes' => $profileAttributes,
                'login' => ['userId' => $uid,
                            'userIsGuest' => $userIsGuest,
                            'avatar' => $avatar,
                            'urlAvatar' => $urlAvatar ],
                'messageRegistration' => ($successUser) ? $_registrationMessage['success'] :
                    $_registrationMessage['error'] ,
                'messageProfile' => ($successProfile) ? $_profileMessage['success'] :
                    $_profileMessage['error'] ,
                'z-end' => 'end'
            ];
            echo json_encode($answ);
        }

    }


    public function actionProfile()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $userId = Yii::$app->user->identity->id;
        $userProfile = UserProfile::findOne(['userid' => $userId]);
        $userProfile->emailPrev = $userProfile->email ;
        $oldAttributes = $userProfile->attributes;
        $opcod = Yii::$app->request->post('opcod');
// если запрос 'get' на имеющиеся значения, то сохранять не надо
        $success = true;
        if ($opcod === 'save') {
            $userProfile->avatarPrev = $userProfile->avatar ;
            $userProfile->load(Yii::$app->request->post());

//            $success = $userProfile->save();
            $success = $userProfile->saveProfile();
        }

        $errors = $userProfile->errors;
        $isError = (!empty($errors)) ;
        if (Yii::$app->request->isAjax) {
            $message = (empty($errors)) ? ['oK!'] : $errors;
            $profileMessage =
                PageItems::getItemText(['user','forms','profileForm','rules','messages']) ;
            $confirmationFlag = $userProfile->confirmation_flag ;
            $confirmationMessage = ($confirmationFlag || $isError) ? '' : $profileMessage['confirmation'] ;
            if (!($confirmationFlag || $isError)) {
                $email = $userProfile->email ;
//                $this->sendEmailConfirmation($userProfile->confirmation_key,$email) ;

//             отправить email  для подтверждения
                (new MailingFunc())
                 -> setType(MailingFunc::TYPE_REGISTRATION)
                    ->setRegistrationAttr($userId)
                    ->sendDo() ;
            }
            $avatar = $userProfile->getAvatar() ;
            $avatarUrl = $avatar['url'] ;
            $answ = [
                'opcod' => $opcod,
                'success' => $success,
                'message' => $message,
                'confirmationMessage' => $confirmationMessage,    // ссобщение о подтверждении почты
                'attributes' => $userProfile->attributes,
                'oldAttributes' => $oldAttributes,
                'avatarUrl' => $avatarUrl,
                'z_end' => 'end'
            ];
            echo json_encode($answ);
        }

    }
//    public function actionEmailConfirmation($id) {
//        $siteUrl = Url::to(['site/email','id'=>id]) ;
//        return $this->redirect($siteUrl);
//    }
//    private function sendEmailConfirmation($id,$email,$expressFlag = false,$login = false,$password = false) {
////        $email = 'mnudelman@yandex.ru' ;
//        $addText = '' ;
//        if (isset($expressFlag) && $expressFlag) {
//            $addText = 'Процедура экспресс регистрации на сайте<b>PERE-STROIKA.ru</b><br>
//            <b>Ваш login:</b>' . $login .'<br>' . ' <b>Ваш пароль:</b>' . $password .'<br>' ;
//        }
//        $siteUrl = Url::to(['site/email','id'=>$id],true) ;
//        $text = 'Для подтверждения корректности email перейдите по ссылке ' ;
//        $a = Html::a($text, $siteUrl) ;
//        Yii::$app->mailer->compose()
////            ->setFrom('mnudelman@yandex.ru')  // в конфигурации по умолчанию
//            ->setTo($email)
//            ->setSubject('подтвердить корректность email')
////            ->setTextBody($addText .' '.'Для подтверждения корректности email перейдите по ссылке ' . $siteUrl)
//            ->setHtmlBody($addText .' '.$a)
//            ->send();
//
//    }
    public function actionGetAvatar() {
        $userId = Yii::$app->user->identity->id;
        $userProfile = UserProfile::findOne(['userid' => $userId]);
//        'imgName' => $this->avatar,
//            'url' => $path['url'],
//            'dir' => $path['dir'],
        $avatar = $userProfile->getAvatar() ;
        $answ = [
        'imgName' => $avatar['imgName'],
            'url' => $avatar['url'],
        ];
        echo json_encode($answ);

    }
}