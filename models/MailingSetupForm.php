<?php
/**
 *  Редактирование НАСТРОЙКА РАСЫЛКИ ПРЕДЛОЖЕНИЙ
 */

namespace app\models;
use Yii;
use yii\base\Model;
use app\service\PageItems ;
use app\service\TaskStore ;
use app\models\FilterForm ;
use DateTime ;
use DateInterval ;
class MailingSetupForm  extends FilterForm
{
    protected $FILTER_NAME = 'mailingSetup' ;
    public $currentTime ;
    public $autoSendFlag;
    public  $mailingNumberMax;
    public $deadline ;
    public $deadlineTime ;
    public $randSelectFlag ;
    private $timeItems = [       // точность определения времени
        0 => '00:00 MSK',
        8 => '08:00 MSK',
        9 => '09:00 MSK',
        10 => '10:00 MSK',
        11 => '11:00 MSK',
        12 => '12:00 MSK',
        13 => '13:00 MSK',
        14 => '14:00 MSK',
        15 => '15:00 MSK',
        16 => '16:00 MSK',
        17 => '17:00 MSK',
        18 => '18:00 MSK',
        19 => '19:00 MSK',
        20 => '20:00 MSK',
        21 => '21:00 MSK',
        22 => '22:00 MSK',
        23 => '23:00 MSK'
    ] ;
// мах число рссылок
    private $mailingNumberMaxItems = [
        5 => '5',
        10 => '10',
        20 => '20',
        30 => '30',
        40 => '40',
        50 => '50',
        100 => '100',
    ] ;
    //---------------------------------//
    public function attributeLabels()
    {
//        $labelTab = PageItems::getItemText(['user', 'fields']);

        return [
            'autoSendFlag' => 'автоматическая рассылка предложений',
            'mailingNumberMax' => 'Мах число рассылок',
            'deadline' => 'Предельный срок ответа',
            'randSelectFlag' => 'Вкл случайный выбор исполнителей',
            'currentTime' => 'Текущее время',
            'deadlineTime' => '',
        ];
    }
    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['deadline'],'validatePeriod'],
        ];
    }
    public function validatePeriod($attribute, $params) {
        $message = 'недопустимый срок ответа!' ;
        $deadlineTime = strtotime($this->deadline) ;
        if ($deadlineTime === -1) {
            $this->addError($attribute, $message);
        }
    }

    /**
     * поправляем текущее время
     */
    public function getFilter() {
        $setup = parent::getFilter() ;
        $this->currentTime = date('d M Y H:00 T',time()) ;
        $setup['currentTime'] = $this->currentTime ;
        return $setup ;
    }
    public function getTimeItems() {
        return $this->timeItems ;
    }
    public function getMailingNumberMaxItems() {
        return $this->mailingNumberMaxItems ;
    }
    private function getRoundTime($tm) {
        $keys = array_keys($this->timeItems) ;
        $time = $tm - 0 ;
        $resTime = 0 ;
        $keyMax = 24 ;
        $iMax = sizeof($keys) - 1 ;
        for ($i = 0; $i <= $iMax ; $i++) {
            $key = $keys[$i] ;
            $keyNext = ($i < $iMax) ? $keys[$i+1] : $keyMax ;
            if ($time >= $key && $time < $keyNext) {
                $resTime = $key ;
                break ;
            }

        }
        return $resTime ;
    }
    protected function defaultFilter() {
        $this->autoSendFlag = false ;
        $this->mailingNumberMax = 100 ;
        $tm = time()  + 86400 ;
        $this->deadline = date('Y-m-d',$tm) ;
        $this->deadlineTime = $this->getRoundTime(date('H',$tm)) ;

        $this->currentTime = date('d M Y H:00 T',time()) ;
        $this->randSelectFlag = false ;
        return [
            'autoSendFlag' => $this->autoSendFlag,
            'mailingNumberMax' => $this->mailingNumberMax,
            'deadline' => $this->deadline,
            'deadlineTime' => $this->deadlineTime,
            'randSelectFlag' => $this->randSelectFlag,
            'currentTime' => $this->currentTime,
        ] ;

    }


}