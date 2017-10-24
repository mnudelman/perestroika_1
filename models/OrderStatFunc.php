<?php
/**
 *  Состояние заказа
 * Time: 15:57
 */

namespace app\models;
use app\models\OrderMailing ;

class OrderStatFunc
{
    private $orderId;
    private $userId;
    private $currentRole;
    private $transferTable = [
        'customer' => [                // роль  - ЗАКАЗЧИК
            [                               // блок состояний
                OrderMailing::STAT_NO_SENT,
                OrderMailing::STAT_SENT_READY,
                OrderMailing::STAT_SENT,
            ],
            [                               // блок состояний
                OrderMailing::STAT_ANSWERED,
                OrderMailing::STAT_SELECTED_READY,
                OrderMailing::STAT_SELECTED,
                OrderMailing::STAT_SELECTED_ANSWERED,
            ]
        ],
        'developer' => [        // роль  - ИСПОЛНИТЕЛЬ
            [                                   // блок состояний
                OrderMailing::STAT_SENT,
                OrderMailing::STAT_ANSWERED_READY,
                OrderMailing::STAT_ANSWERED,
            ],
            [                                    // блок состояний
                OrderMailing::STAT_SELECTED,
                OrderMailing::STAT_SELECTED_ANSWERED_READY,
                OrderMailing::STAT_SELECTED_ANSWERED,
            ]
        ]
    ];
    private $directSign = [
        'plus' => +1,
        'minus' => -1
    ];
    //  промежуточные состояния. при рассылке/подтверждении происходит
    // переход в следующее стационарное состояние
    private $statReady = [
        'customer' => [                // роль  - ЗАКАЗЧИК
            OrderMailing::STAT_SENT_READY =>
                OrderMailing::STAT_SENT,
            OrderMailing::STAT_SELECTED_READY =>
                OrderMailing::STAT_SELECTED,
        ],
        'developer' => [        // роль  - ИСПОЛНИТЕЛЬ
            OrderMailing::STAT_ANSWERED_READY =>
                OrderMailing::STAT_ANSWERED,
            OrderMailing::STAT_SELECTED_ANSWERED_READY =>
                OrderMailing::STAT_SELECTED_ANSWERED,
        ]
    ];

    //----------------------------------------//
    public function setLock($lockFlag)
    {

    }

    public function nextStat($role, $statDirect, $orderStat) {
        $orderStat = (empty($orderStat)) ? OrderMailing::STAT_NO_SENT : $orderStat;
        $newStat = false;
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