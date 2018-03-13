<?php
/**
 * Состояние заказов ЗАКАЗЧИКА
 */

namespace app\views\viewParts;

use app\views\viewParts\OrderViewPrepare;

class OrderViewPrepareGeneral extends OrderViewPrepare
{
    private $btList = [
        'orderStat' => [
        ],
        'orderLock' => [
        ],
        'orderEdit' => [
            'btTitle' => 'Редактировать заказ',
            'onClick' => 'orderItemEdit',
        ],
    ];
    protected $subItemFields = [
        'registrationDate' => [
            'name' => 'регистрация', 'value' => 'userDateFirst'],
        'description' => ['name' => 'описание', 'value' => 'profileInfo'],
        'proposals' => ['name' => 'предложений', 'value' => 'sentCount'],
        'answers' => ['name' => 'подтверждений готовности', 'value' => 'answeredCount'],
        'selections' => ['name' => 'выбран исполнителем', 'value' => 'selectedCount'],
    ];


    /**
     * настройка $this->btnCurrent, $this->subItemFields
     */
    protected function setCurrent()
    {
        if (empty($this->currentRole)) {
            $this->currentRole = self::ROLE_CUSTOMER ;
        }

        $this->btnCurrent = [];
        foreach ($this->btList as $key => $btAttr) {
            $this->btnCurrent[$key] = $this->btnDefault[$key];
            foreach ($btAttr as $attrKey => $attrValue) {
                $this->btnCurrent[$key][$attrKey] = $btAttr[$attrKey];
            }
        }
        $this->subItemAsIsFlag = true ;

        $this->currentItemFields = $this->defaultItemFields ;
        $this->currentItemFields['id']['value'] = 'id' ;
        $this->currentItemFields['name']['value'] = 'name' ;
        $this->currentItemFields['currentOrderStat']['value'] = 'mailingStat' ;



    }

}