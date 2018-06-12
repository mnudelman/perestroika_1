<?php
/**
 * Состояние заказов исполнителя
 */

namespace app\views\viewParts;

use app\views\viewParts\OrderViewPrepare;

class OrderViewPrepareByOrder extends OrderViewPrepare
{
    private $btList = [
        'profile' => [
            'btTitle' => 'заказ просмотр',
            'onClick' => 'orderViewClick',
        ],
        'orderStat' => [
        ],
        'toggleStat' => [
        ],
        'orderLock' => [
        ],

    ];
    /**
     * настройка $this->btnCurrent, $this->subItemFields
     */
    protected function setCurrent()
    {
        if (empty($this->currentRole)) {
            $this->currentRole = self::ROLE_DEVELOPER ;
        }

        $this->btnCurrent = [];
        foreach ($this->btList as $key => $btAttr) {
            $this->btnCurrent[$key] = $this->btnDefault[$key];
            foreach ($btAttr as $attrKey => $attrValue) {
                $this->btnCurrent[$key][$attrKey] = $btAttr[$attrKey];
            }
        }
        $this->subItemAsIsFlag = true;

        $this->currentItemFields = $this->defaultItemFields ;
        $this->currentItemFields['id']['value'] = 'id' ;
        $this->currentItemFields['name']['value'] = 'name' ;
        $this->currentItemFields['currentOrderStat']['value'] = 'mailingStat' ;



    }

}