<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 08.08.17
 * Time: 21:13
 */

namespace app\models;
use yii\db\ActiveRecord ;
use Yii ;
use app\service\PageItems ;
use yii\db\Query ;


class MessageBody extends ActiveRecord {
//-- состояние "переписка прервана(забанена)"
    const STAT_NORMAL = 0 ;     // не установлен (обычное сообщение)
    const STAT_CANCEL = 1 ;      // переписка прервана
    const STAT_REOPEN = 2 ;   // переписка возоблена
    private $captionId ;          // ид заголовка цепочки сообщений
    private $senderId ;       // отправитель сообщения
    private $_filter ;
    private $perBeg ;
    private $perEnd ;
    // атрибуты фильтра -//

    public static function tableName()
    {
        return 'message_body';
    }

    /**
     *id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
     *caption_id INTEGER REFERENCES message_caption(id)  -- заголовок(тема)
     *ON DELETE CASCADE,
     *text TEXT,
     *time_create TIMESTAMP DEFAULT NOW()
     */
    public function attributeLabels()
    {
//        $labelTab = PageItems::getItemText(['user','fields']) ;
//        $pageItemFile = 'order/additional';
//        $fields = PageItems::getItemText([$pageItemFile, 'fields']);
        return [
            'id' => 'id',
            'caption_id' => 'caption_id',
            'text' => 'text',
            'time_create' => 'time_create',
            'sender_id' => 'отправитель сообщения',
            'stat' => 'состояние "переписка прервана" ',
        ];
    }

    public function rules()
    {
        return [
            [['caption_id', 'text'], 'required'],
        ];
    }
    public function setCaptionId($id) {
        $this->captionId = $id ;
        return $this ;
    }
    public function setSenderId($id) {
        $this->senderId = $id ;
        return $this ;
    }
    public function setFilter($filter) {
        $this->_filter= $filter ;
        $this->perBeg = $filter['perBeg'] ;
        $this->perEnd = $filter['perEnd'] ;
        return $this ;
    }
    public function getList($limit=-1,$offset=-1) {
        $query = $this->queryBuild() ;
        $rows = $query->limit($limit)->offset($offset)->all();
        return $rows ;

    }
    private function getCaptionId() {
        return $this->captionId ;
    }
    private function getSenderId() {
        if(empty($this->senderId)) {
            $this->senderId = Yii::$app->user->getId() ;
        }
        return $this->senderId ;
    }

    private function queryBuild() {
        $perBeg = $this->perBeg ;
        $perEnd = $this->perEnd ;

        $captionId = $this->getCaptionId() ;
        return  (new Query())
            ->select('*')
            ->from('message_body')
            ->where(['caption_id' =>
                $captionId])
            ->andWhere(
                ['between','time_create',$perBeg,$perEnd]) ;
    }

    /**
     * последнее сотояние в периоде
     */
    public function getLastStat() {
        $rows = $this->getList() ;
        $lastStat = self::STAT_NORMAL ;
        if (!empty($rows)) {
            $lastRow = $rows[sizeof($rows) -1] ;
            $lastStat = $lastRow['stat'] ;
        }
        return $lastStat ;
    }
    public function isClosed() {
        $lastStat = $this->getLastStat() ;
        return $lastStat === self::STAT_CANCEL ;
    }
    public function addMessage($text,$stat) {
        $captionId = $this->getCaptionId() ;
        $this->sender_id = $this->getSenderId() ;
        $ValidFlag = $this->validate() ;
        if ($ValidFlag) {
            $this->save() ;
        }
        return $this ;
    }
}