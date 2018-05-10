<?php
/**
 *  Состояние заказа
 * константы сотояния и взаимосвязь сотояний
 */

namespace app\controllers\funcs;

class OrderStatFunc
{
    const STAT_NO_SENT = 0 ;    // не отправлено предложение
    const STAT_SENT_READY = 5 ; // Готов к отправке (заказчик)
    const STAT_SENT = 10 ;       // отправлено предложение (заказчик)
    const STAT_ANSWERED_READY = 15 ;  // подтверждение сделано, но не отправлено(исполнитель)
    const STAT_ANSWERED = 20 ;   // получено подтверждение (исполнитель)
    const STAT_SELECTED_READY = 25 ;   // выбран исполнитель (заказчик)
    const STAT_SELECTED = 30 ;   // выбран исполнитель - отправлено предложение
    const STAT_SELECTED_ANSWERED_READY = 35 ;
    const STAT_SELECTED_ANSWERED = 40 ; // подтверждение от исполнителя
    const MIN_TOTAL_RANK = 50 ; // min суммарная оценка(%) для добавления в order_mailing
    const MIN_GEOGRAPHY_RANK = 50 ; // min оценка(%) географии для добавления в order_mailing
    //-- роль пользователя
    const USER_ROLE_CUSTOMER = 'customer' ;   // заказчик
    const USER_ROLE_DEVELOPER = 'developer' ; // исполнитель
    const USER_ROLE_USER = 'user' ; // посто пользователь
    private $orderId;
    private $userId;
    private $currentRole;
    private $transferTable = [
        self::USER_ROLE_CUSTOMER => [                // роль  - ЗАКАЗЧИК
            [                               // блок состояний
                self::STAT_NO_SENT,
                self::STAT_SENT_READY,
                self::STAT_SENT,
            ],
            [                               // блок состояний
                self::STAT_ANSWERED,
                self::STAT_SELECTED_READY,
                self::STAT_SELECTED,
                self::STAT_SELECTED_ANSWERED,
            ]
        ],
        self::USER_ROLE_DEVELOPER => [        // роль  - ИСПОЛНИТЕЛЬ
            [                                   // блок состояний
                self::STAT_SENT,
                self::STAT_ANSWERED_READY,
                self::STAT_ANSWERED,
            ],
            [                                    // блок состояний
                self::STAT_SELECTED,
                self::STAT_SELECTED_ANSWERED_READY,
                self::STAT_SELECTED_ANSWERED,
            ]
        ]
    ];
    private $directSign = [
        'plus' => +1,
        'minus' => -1
    ];
    // состояния, для которых надо фиксировать deadline
    private $isTimeDeadlineStat = [self::STAT_SENT,self::STAT_SELECTED,] ;
    // состояния, для которых надо фиксировать время ответа исполнителя
    private $isTimeAnsweredStat = [self::STAT_ANSWERED,self::STAT_SELECTED_ANSWERED,] ;
    // состояния, для которых надо фиксировать время отправления запроса
    private $isTimeSendStat = [self::STAT_SENT,self::STAT_SELECTED] ;
    //  промежуточные состояния. при рассылке/подтверждении происходит
    // переход в следующее стационарное состояние
    private $statReady = [
        self::USER_ROLE_CUSTOMER => [                // роль  - ЗАКАЗЧИК
            self::STAT_SENT_READY =>
                self::STAT_SENT,
            self::STAT_SELECTED_READY =>
                self::STAT_SELECTED,
        ],
        self::USER_ROLE_DEVELOPER => [        // роль  - ИСПОЛНИТЕЛЬ
            self::STAT_ANSWERED_READY =>
                self::STAT_ANSWERED,
            self::STAT_SELECTED_ANSWERED_READY =>
                self::STAT_SELECTED_ANSWERED,
        ]
    ];

    //----------------------------------------//
    public function setLock($lockFlag)
    {

    }

    /**
     * допустим ли для состояния атрибут  time_deadline
     * @param $stat
     * @return bool
     */
    public function isDeadlineStat($stat) {
        return in_array($stat,$this->isTimeDeadlineStat) ;
    }
    /**
     * допустим ли для состояния атрибут  time_send
     * @param $stat
     * @return bool
     */
    public function isSendStat($stat) {
        return in_array($stat,$this->isTimeSendStat) ;
    }
    /**
     * допустим ли для состояния атрибут  time_answer
     * @param $stat
     * @return bool
     */
    public function isAnswerStat($stat) {
        return in_array($stat,$this->isTimeAnsweredStat) ;
    }

    public function nextStat($role, $statDirect, $orderStat) {
        $orderStat = (empty($orderStat)) ? self::STAT_NO_SENT : $orderStat;
        $newStat = false;
        if (is_numeric($statDirect)) {
            $statDirect = ($statDirect - 0 > 0) ? 'plus' : 'minus' ;
        }
        $sign = $this->directSign[$statDirect];
        $transferTable = $this->transferTable[$role];
        foreach ($transferTable as $key => $blockStates) {
            $ind = array_search($orderStat, $blockStates);
            if (false !== $ind) {
                $newInd = $ind + $sign;
                $newInd = max(0, $newInd);
                $newInd = min($newInd, sizeof($blockStates));
                $newStat = $blockStates[$newInd];
                break;
            }
        }
        return $newStat;
    }

    /**
     * таблица перехода из промежуточных состояний
     */
    public function getStatReadyTable($userRole) {
        $readyTable = false;
        if (isset($this->statReady[$userRole])) {
            $readyTable = $this->statReady[$userRole];
        }
        return $readyTable;
    }

    /**
     * получить список исходных состояний в виде строки
     * @param $userRole
     */
    public function getStatReadyList($userRole) {
        $readyTable = $this->getStatReadyTable($userRole) ;
        $keys = array_keys($readyTable) ;
        return implode(",", $keys);
    }
    public function getStatTable($userRole) {
        $statTable = false;
        if (isset($this->transferTable[$userRole])) {
            $statTable = $this->transferTable[$userRole];
        }
        return $statTable;
    }
    public function getStatList($userRole) {
        $transferTable = $this->transferTable[$userRole];
        $statList = '' ;
        foreach ($transferTable as $key => $blockStates) {
            $statList .= ((empty($statList))? '' : ',') . implode(',',$blockStates)  ;
        }
        return $statList ;

    }
}