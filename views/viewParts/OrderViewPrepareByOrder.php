<?php
/**
 * Состояние заказов исполнителя
 */

namespace app\views\viewParts;

use app\views\viewParts\OrderViewPrepare;

class OrderViewPrepareByOrder extends OrderViewPrepare
{
//    protected $btnDefault = [
//        'profile' => [
//            'btTitle' => 'профиль исполнителя',
//            'btClass' => 'btn-primary',
//            'pictureClass' => 'fa fa-caret-right fa-lg',
//            'onClick' => 'orderMailingProfileClick',
//        ],
//        'workingRank' => [
//            'btTitle' => 'оценка исполняемых работ(%)',
//            'btClass' => 'btn-primary',
//            'pictureClass' => 'fa fa-battery-full fa-lg',
//            'onClick' => '',
//            'disabled' => true
//        ],
//        'geographyRank' => [
//            'btTitle' =>
//                'оценка географии работ исполнителя(100% - город есть 50% - только регион)',
//            'btClass' => 'btn-primary',
//            'pictureClass' => 'fa fa-battery-full fa-lg',
//            'onClick' => '',
//            'disabled' => true
//        ],
//        'orderStat' => [
//            'btTitle' =>
//                'состояние заказа',
//            'btClass' => 'btn-primary',
//            'pictureClass' => 'fa fa-envelope-o fa-lg',
//            'onClick' => '',
//            'disabled' => true
//        ],
//        'selected' => [
//            'btTitle' =>
//                'не выбран исполнителем заказа',
//            'btClass' => 'btn-primary',
//            'pictureClass' => 'fa fa-square-o fa-lg',
//            'onClick' => 'orderSelect',
//        ],
//        'orderLock' => [
//            'btTitle' =>
//                'Заказ закрыт для изменений',
//            'btClass' => 'btn-primary',
//            'pictureClass' => 'fa fa-lock',
//            'onClick' => 'orderLock',
//
//        ],
//        'orderUnLock' => [
//            'btTitle' =>
//                'Заказ открыт для изменений',
//            'btClass' => 'btn-primary',
//            'pictureClass' => 'fa fa-unlock',
//            'onClick' => 'orderLock',
//
//        ],
//
//    ] ;
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
//    protected $defaultItemFields = [
//        'id' => [
//            'name' => 'Id', 'value' => 'userId'],
//        'name' => ['name' => 'имя', 'value' => 'profileCompany'],
//        'editFlag' => ['name' => 'возможность редактировать',
//            'value' => 'editFlag', 'default' => true],
//        'fullyFlag' => ['name' => 'полное включение',
//            'value' => 'fullyFlag', 'default' => false],
//        'lockFlag' => ['name' => 'Закрыт для редактирования',
//            'value' => 'lockFlag', 'default' => false],
//        'lockTime' => ['name' => 'Момент закрытия для редактирования',
//            'value' => 'lockFlagTime', 'default' => false],
//        'deadline_answer' => [
//            'name' => 'deadline ответа на предложение участия в конкурсе',
//            'value' => 'deadlineAnswer', 'default' => false],
//        'deadlineSelect' => ['name' => 'deadline ответа на выбор исполнителем заказа',
//            'value' => 'deadlineSelect', 'default' => false],
//    ];

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