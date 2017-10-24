<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 24.12.16
 * Time: 21:20
 */

namespace app\models;
use yii\db\ActiveRecord ;
use app\service\PageItems ;
use Yii ;

class UserRegistration extends ActiveRecord {
     const NAME_MIN_LENGTH = 8 ;
     const NAME_MAX_LENGTH = 50 ;
     const PASSW_MIN_LENGTH = 12 ;
     const PASSW_MAX_LENGTH = 50 ;
    public $enterPassword = '' ;
    public $enterPassword_repeat = '' ;

    public static function tableName(){
        return 'user';
    }
    public function attributeLabels()
    {
        $labelTab = PageItems::getItemText(['user','fields']) ;

        return [
            'username' => $labelTab['username'],
            'enterPassword' => $labelTab['password'],
            'enterPassword_repeat' => $labelTab['password_repeat'],
            'email' => $labelTab['email'],
            'tel' => $labelTab['tel'],
            'site' => $labelTab['site'],
            'company' => $labelTab['company'],
            'info' => $labelTab['info']
        ];
    }

    public function rules()
    {
        $currentDate = date('Y.m.d',time()) ;
        $ip = Yii::$app->request->userIp ;
        return [
            // username and password are both required
            [['username', 'enterPassword'],'required',],
            [['username', 'enterPassword','enterPassword_repeat'],'filter','filter' => function($value) {
                return strtolower(trim($value)) ;
            }],
            ['username','unique'],
            ['username','string','length' => [self::NAME_MIN_LENGTH,self::NAME_MAX_LENGTH]],
            ['enterPassword','string','length' => [self::PASSW_MIN_LENGTH,self::PASSW_MAX_LENGTH]],
            [['username','enterPassword'],'match','pattern' => '/^[\w,\-,\_,\@,\.]+$/i'],
            // password is compared with password_repeat
            ['enterPassword', 'compare'],
            ['date_first','default','value' => $currentDate],
            ['date_last','default','value' => $currentDate],
            ['ip','default','value' => $ip]

        ];
    }
    public function saveRegistration() {
        if ($this->validate()) {
            $this->password = Yii::$app->security->generatePasswordHash($this->enterPassword) ;
            return $this->save() ;
        }else {
            return false ;
        }
    }
    public function changePassword($uid,$password) {
            $r = $this->findUser($uid) ;
            if (!empty($r)) {
//                ['username' => $email, 'enterPassword' => $password, 'enterPassword_repeat' => $password];
                $r->enterPassword =  $password ;
                $r->enterPassword_repeat = $password ;
                if ($r->validate()) {
                    $r->password = Yii::$app->security->generatePasswordHash($this->enterPassword) ;
                    return $r->save() ;
                }else {
                    return false ;
                }
            }
    }
    public function getByUserId($uid) {
        return $this->findUser($uid) ;
    }
    private function findUser($uid) {
        $r = $this->find()
            ->where(['id' => $uid])->limit(1)->one() ;
        return $r ;
    }
}