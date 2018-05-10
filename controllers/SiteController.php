<?php
/**
 * Чтобы сохранить схему умолчания Yii2:
 *  Yii::$app->defaultRoute = 'site'                 // controller
 *  Yii::$app->controller->defaultAction = 'index'   // action & view
 *  Yii::$app->layout = 'main'                       // template
 */
namespace app\controllers;

use app\controllers\funcs\OrderStatFunc ;
use app\controllers\funcs\MailingFunc ;
use app\models\User;
use app\service\Files;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Html;
use yii\web\UploadedFile ;
use app\service\PageItems ;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\UploadForm;
use app\models\UserProfile;
use app\models\OrderWork ;
use app\controllers\BaseController ;

class SiteController extends BaseController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function beforeAction($action){
        if( $action->id == 'upload' ){
//            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index') ;
    }
    public function actionMessage($act,$id)
    {
        $i = 1 ;
        $n = func_num_args() ;
        $act = ($n >= 1) ? func_get_arg(0) : '' ;
        $id = ($n >= 2) ? func_get_arg(1) : '' ;
//        if ($act == 'email') {
//            return $this->redirect(['email', 'id' => $id]);
//        }else {
//            echo 'ERROR!!!!!!' ;
        return $this->redirect(['email', 'id' => $id]);
//        }

//
    }
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * подтверждение регистрации по email
     * @param $id
     * @return string - переход на форму подтверждения
     */
    public function actionEmail($id) {
        $profile = UserProfile::findOne(['confirmation_key' => $id]);
        $success = true ;
        $userName = null ;
        $email = null ;
        if (empty($profile)) {
            $success = false ;
        }else {
            $userId = $profile->userid ;
            $profile->confirmation_flag = true ;
            $profile->scenario = UserProfile::SCENARIO_EXPRESS ; // иначе может быть ошибка при save
            $profile->save() ;
            $user = User::findOne(['id'=>$userId]) ;
            $userName = $user->username ;
            $email = $profile->email ;
        }
        return $this->render('emailConfirm',['success'=>$success,'userName' => $userName,'email'=>$email]);
    }

    /**
     * Подтверждение участия в конкурсе на выполнение заказа
     * @param $id
     * @return string - переход на форму подтверждения
     */
    public function actionOrderEmail($id) {
        list($type,$confirmationKey,$orderAliasId)= explode("-", $id);

        $profile = UserProfile::findOne(['confirmation_key' => $confirmationKey]);
        $order = OrderWork::findOne(['alias_id' => $orderAliasId]) ;
        $orderStat = OrderStatFunc::STAT_ANSWERED ;
        $success = true ;
        $company = '' ;
        $orderId = 0 ;
        $orderName = '' ;
        $userId = 0 ;

        if (empty($profile) || empty($order)) {
            $success = false ;
        }else {
            $company  = $profile->company ;
            $orderId = $order->id ;
            $orderName = $order->order_name ;
            $userId = $profile->userid ;
//  не надо торопиться
//            $orderMailing = (new OrderMailing())->addOrderMailing($orderId,$userId,$orderStat) ;
//            $success = (!empty($orderMailing)) ;

        }
        return $this->render('emailOrder',
            ['success'=>$success,'company' => $company,'orderId'=>$orderId,
                'userId'=>$userId,'orderName' => $orderName]);
    }

    /**
     * обработка возвратов по  email
     * @param $totalId
     */
    public function actionEmailResponse($mailId) {
        $mailVect = (new MailingFunc())->unencriptMailId($mailId) ;
        $success = true ;
        if (false === $mailVect ) {      // ошибка расшифровки параметра
            $success = false ;
        }

    }
    /**
     * принятие предложения от ЗАКАЗЧИКА на выполнение работ по ЗАКАЗУ
     * @param $id
     * @return string - переход на форму подтверждения
     */
    public function actionOrderSelectedEmail($id) {
        list($confirmationKey,$orderAliasId)= explode("-", $id);
        $profile = UserProfile::findOne(['confirmation_key' => $confirmationKey]);
        $order = OrderWork::findOne(['alias_id' => $orderAliasId]) ;
        $orderStat = OrderStatFunc::STAT_SELECTED_ANSWERED ;
        $success = true ;
        $company = '' ;
        $orderId = 0 ;
        $orderName = '' ;

        if (empty($profile) || empty($order)) {
            $success = false ;
        }else {
            $company  = $profile->company ;
            $orderId = $order->id ;
            $orderName = $order->order_name ;
            $developerId = $profile->userid ;
            $orderMailing = (new OrderStatFunc())->addOrderMailing($orderAliasId,$developerId,$orderStat) ;
            $success = (!empty($orderMailing)) ;

             $success = true ;
        }
        return $this->render('emailOrderSelected',
            ['success'=>$success,'company' => $company,'orderId'=>$orderId,'orderName' => $orderName]);
    }
    /**
     * обработать подтверждение  email
     * @param $id
     * @return string
     */
    public function actionEmailOk($id) {
        $profile = UserProfile::findOne(['confirmation_key' => $id]);
        if (empty($profile)) {

        }else {
            $userId = $profile->userid ;
            $profile->confirmation_flag = true ;
            $profile->save() ;
        }
        return $this->render('index');
    }
    /**
     * получить описание описание направления работ
     */
    public function actionWorkDirectGet() {
        if( Yii::$app->request->isAjax ){
            $query = Yii::$app->request->post() ;
            $wdId = $query['wdId'] ;

            $wdItems = PageItems::getItemText(['wd-list','content']) ;
            $wdContent = PageItems::getItemText(['wd-' . $wdId,'content']) ;
            $answ = [
                'title' => $wdItems[$wdId],
                'content' => $wdContent,
            ] ;
            echo json_encode($answ) ;
        }
    }
    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $success = false ;
        $model = new LoginForm();
        $avatar = '' ;
        $userId = false ;
        $userIsGuest = true ;
        $urlAvatar = false ;
        $profileAttributes = [] ;
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $success = true ;
            $userId = Yii::$app->user->identity->id ;
            $userIsGuest = Yii::$app->user->isGuest ;
            $profile = UserProfile::findOne(['userid' => $userId]);
            $avatar = $profile->avatar ;
            $profileAttributes = $profile->attributes ;
            if (!empty($avatar)) {
                $path = Files::getPath('userAvatar',$userId) ;
                $urlAvatar = $path['url'] ;
            }
//            return $this->goBack();
        }
//        return $this->render('login', [
//            'model' => $model,
//        ]);


        if( Yii::$app->request->isAjax ){
            $query = Yii::$app->request->post() ;
            $message=  (empty($model->errors)) ? ['oK!'] : $model->errors ;

                $answ = [
                'success' => $success ,
                'message' => $message,
                'avatar'  => $avatar,
                'urlAvatar'=> $urlAvatar,
                'userId'  => $userId,
                'userIsGuest' => $userIsGuest,
                'profile' => $profileAttributes,
                'z-end' => 'z-end'
            ] ;
            echo json_encode($answ) ;
        }
    }




    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        if( Yii::$app->request->isAjax ){
            $answ = [
                'success' => true ,
                'message' => 'oK!'
            ] ;
            echo json_encode($answ) ;
        }else {
            return $this->goHome();
        }


    }
    public function actionUpload($filesMax = 0)
    {
        $model = new UploadForm();
        $success = false ;
        if (Yii::$app->request->isPost) {
            $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
            if ($model->upload($filesMax)) {
                // file is uploaded successfully
                $success = true ;
            }
        }
        if( Yii::$app->request->isAjax ){
            $uploadedPath = ($success) ? $model->getUploadedPath() : false ;
            $uploadedUrl = ($success) ? $model->getUploadedUrl() : false ;
            $answ = [
                'success' => $success ,
                'message' => $model->errors,
                'uploadedPath' => $uploadedPath,
                'uploadedUrl' => $uploadedUrl,
            ] ;
            echo json_encode($answ) ;

        }else {
            return $this->render('index');
            return $this->goBack();
        }
    }

 }
