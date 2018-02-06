<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 24.12.16
 * Time: 21:23
 */

namespace app\models;
use app\service\Files;
use yii\db\ActiveRecord ;
use app\service\PageItems ;

class UserProfile extends ActiveRecord {
    public $avatarPrev = false ; // предыдущее значение
    public $emailPrev = false ;
    private $_userProfile = false ;
    private $_userId ;
    private $AVATAR_PATH_NAME = 'userAvatar'; // имя в классе Files
    private $AVATAR_PATH_NAME_DEFAULT = 'image'; // имя в классе Files
    private $AVATAR_DEFAULT = 'people.png'; // имя в классе Files
    const SCENARIO_EXPRESS = 'express' ;
    const SCENARIO_DEFAULT = 'default' ;
//    public $avatar = '' ;

    public static function tableName(){
        return   'userprofile';
    }
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_EXPRESS]  = ['email', 'tel','company'] ;
        return $scenarios ;
    }
    public function attributeLabels()
    {
        $labelTab = PageItems::getItemText(['user','fields']) ;

        return [
            'email' => $labelTab['email'],
            'tel' => $labelTab['tel'],
            'site' => $labelTab['site'],
            'company' => $labelTab['company'],
            'info' => $labelTab['info'],
            'city_id' => 'место положения'
        ];
    }
//  [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png,jpg,jpeg'],
//             ['email','email'],
    public function rules()
    {
        return [
            [['email','tel','company',],'required'],
            [['info','city_id'],'required','on'=>self::SCENARIO_DEFAULT],
            [['info','city_id'],'default','on'=>self::SCENARIO_EXPRESS],
            [['email'],'email','checkDNS'=> true],
            ['email', 'unique'],
            ['site','url'],
            ['avatar','default'],
            [['confirmation_key','confirmation_flag','confirmation_date'],'default']
        ];
    }
    public function setUserId($userid) {
        $this->_userId = $userid ;
    }
    public function saveProfile() {
        if (!$this->checkAvatar()) {
            $this->avatar = '' ;
        }
        if ($this->validate()) {
            if ($this->email !== $this->emailPrev) {
                $this->confirmation_flag = false ;
            }
            $this->confirmation_key = substr(\Yii::$app->security->generateRandomString(),-10) ;
            return $this->save() ;
        }else {
            return false ;
        }

    }
    /**
     * Finds user by [[userid]]
     *
     * @return User|null
     */
    public function getByUserId($id)
    {
        $aa = $this->findOne(['userid' => $id]);
        $this->_userId = $id ;
        return $aa ;
    }

    /**
     * наличие файла - изображения
     * @return bool
     */
    private function checkAvatar() {
        $fileAvatar = $this->avatar ;
        if (empty($fileAvatar)) {
            return true ;
        }
        $res = true ;
        if(!Files::fileExist($this->AVATAR_PATH_NAME,$this->userid,$fileAvatar)) {
            $res = Files::fileMove($fileAvatar,'upload','userAvatar') ;
            if ($res) {
                $fileAvatarPrev = $this->avatarPrev ;
                if (!empty($fileAvatarPrev) && $fileAvatarPrev !== $fileAvatar) {
                    if (Files::fileExist($this->AVATAR_PATH_NAME,$this->userid,$fileAvatarPrev)) {
                        Files::fileDelete($this->AVATAR_PATH_NAME,$this->userid,$fileAvatarPrev) ;
                    }
                }
            }
        }
        return $res ;


    }
    public function getByEmail($email) {
        $aa = $this->findOne(['email' => $email]);
        if ($aa) {
            $this->_userId = $aa->attributes['userid'];
        }

        return $aa ;
    }

    public function getAvatarDefault() {
        $path = Files::getPath($this->AVATAR_PATH_NAME_DEFAULT) ;
        return [
            'imgName' => $this->AVATAR_DEFAULT, //'people.png' ;
            'url' => $path['url'],
            'dir' => $path['dir'],
        ] ;
    }
    public function getAvatar() {
        if (empty($this->avatar)) {
            return $this->getAvatarDefault() ;
        }
        $path = Files::getPath($this->AVATAR_PATH_NAME,$this->userid) ;
        return [
            'imgName' => $this->avatar,
            'url' => $path['url'],
            'dir' => $path['dir'],

        ] ;
    }
}