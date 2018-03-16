<?php
/**
 * Подготовка изображения для показа состояния ЗАКАЗА
 *
 * Time: 16:24
 */

namespace app\views\viewParts;

use app\models\OrderMailing;

class OrderViewPrepare
{
    // роль пользователя
    const ROLE_CUSTOMER = 'customer' ;        // зказчик
    const ROLE_DEVELOPER = 'developer' ;     // исполнитель
    protected $currentRole ;
    // кнопка переключения состояний
    const BT_CLASS = 'icon-stat';   // css класс для выравнивания по ширине

    protected $orderStat = [
        'notSent' => [         // 0
            'stat' => [OrderMailing::STAT_NO_SENT], // не отправлено предложение
            'pictureClass' => 'fa fa-frown-o ', //'fa fa-envelope-o',
            'btClass' => 'btn btn-primary',
            'btTitle' => 'Состояние заказа.Предложение не сделано',
        ],
        'sentReady' => [    // 5
            'stat' => [OrderMailing::STAT_SENT_READY], // не отправлено предложение
            'pictureClass' => 'fa fa-send-o ', //'fa fa-envelope-o',
            'btClass' => 'btn btn-default',
            'btTitle' => 'Состояние заказа. Предложение сделано, но не отправлено',
        ],

        'sent' => [          // 10
            'stat' => [OrderMailing::STAT_SENT],    // отправлено предложение
            'pictureClass' => 'fa fa-send-o',
            'btClass' => 'btn btn-primary',
            'btTitle' => 'Состояние заказа. Предложение отправлено',
            'roles' => [
                self::ROLE_DEVELOPER => [
                    'btClass' => 'btn btn-default',
                    'btTitle' => 'Состояние заказа.Пришло предложение побороться за заказ',
                ]
            ],
        ],
        'answeredReady' => [      // 15
            'stat' => [
                OrderMailing::STAT_ANSWERED_READY], // согласие на исполнение
            'pictureClass' => 'fa fa-send-o', //'fa fa-check-square-o',
            'btClass' => 'btn btn-primary',
            'btTitle' => 'Состояние заказа. Подготовил согласие, но не отправил',
            'roles' => [
                self::ROLE_CUSTOMER => [
                    'synonym' => 'sent',
                ],
            ],

        ],
        'answered' => [       // 20
            'stat' => [
                OrderMailing::STAT_ANSWERED], // согласие на исполнение
            'pictureClass' => 'fa fa-send-o', //'fa fa-check-square-o',
            'btClass' => 'btn btn-success',
            'btTitle' => 'Состояние заказа. отправил согласие заказчику',
            'roles' => [
                self::ROLE_CUSTOMER => [
                    'btTitle' => 'Состояние заказа.Получено согласие исполнителя участвовить в отборе',
                ],
            ],
        ],
        'selectedReady' => [     // 25
            'stat' => [OrderMailing::STAT_SELECTED_READY],  // выбран исполнителем
            'pictureClass' => 'fa fa-thumbs-o-up',
            'btClass' => 'btn btn-default',
            'btTitle' => 'Выбран исполнителем. Предложение не отправлено',
            'roles' => [
                self::ROLE_DEVELOPER => [
                    'synonym' => 'answered',
                ],
            ],

        ],

        'selected' => [        // 30
            'stat' => [OrderMailing::STAT_SELECTED],  // выбран исполнителем
            'pictureClass' => 'fa fa-thumbs-o-up',
            'btClass' => 'btn btn-primary',
            'btTitle' => 'Выбран исполнителем. Предложение отправлено',
            'roles' => [
                self::ROLE_DEVELOPER => [
                    'btClass' => 'btn btn-default',
                    'btTitle' => 'Состояние заказа.Получено предложения на ВЫПОЛНЕНИЕ ЗАЗКАЗА',
                ],
            ],
        ],
        'selectedAnsweredReady' => [    // 35
            'stat' => [OrderMailing::STAT_SELECTED_ANSWERED_READY],  // выбран исполнителем
            'pictureClass' => 'fa fa-thumbs-o-up',
            'btClass' => 'btn btn-primary',
            'btTitle' => 'Состояние заказа. Согласился на ВЫПОЛНЕНИЕ.Но не отправил подтверждение',

            'roles' => [
                self::ROLE_CUSTOMER => [
                    'synonym' => 'selected',
                ],
            ],

        ],
        'selectedAnswered' => [    // 40
            'stat' => [OrderMailing::STAT_SELECTED_ANSWERED],  // выбран исполнителем
            'pictureClass' => 'fa fa-thumbs-o-up',
            'btClass' => 'btn btn-success',
            'btTitle' => 'Состояние заказа. Согласился на ВЫПОЛНЕНИЕ.Отправил подтверждение',
            'roles' => [
                self::ROLE_CUSTOMER => [
                    'btTitle' => 'Состояние заказа.Получено согласие выбранного ИСПОЛНИТЕЛЯ на выполнение работ по заказу',
                ],
            ],
        ]
    ];


//    // роль пользователя
//    const ROLE_CUSTOMER = 'customer';        // зказчик
//    const ROLE_DEVELOPER = 'developer';     // исполнитель
//    protected $currentRole;
//    // кнопка переключения состояний
//
//    const STAT_NO_SENT = 0;    // не отправлено предложение
//    const STAT_SENT_READY = 5; // Готов к отправке (заказчик)
//    const STAT_SENT = 10;       // отправлено предложение (заказчик)
//    const STAT_ANSWERED_READY = 15;  // подтверждение сделано, но не отправлено(исполнитель)
//    const STAT_ANSWERED = 20;   // получено подтверждение (исполнитель)
//    const STAT_SELECTED_READY = 25;   // выбран исполнитель (заказчик)
//    const STAT_SELECTED = 30;   // выбран исполнитель - отправлено предложение
//    const STAT_SELECTED_ANSWERED_READY = 35;
//    const STAT_SELECTED_ANSWERED = 40; // подтверждение от исполнителя


//STAT_NO_SENT,STAT_ANSWERED
// STAT_SENT,STAT_SELECTED


    protected $toggleStat = [
        'plus' => [
            'rule' => [
                ['role' => self::ROLE_CUSTOMER,
                 'stat' => [OrderMailing::STAT_NO_SENT, OrderMailing::STAT_ANSWERED,]
                ],
                ['role' => self::ROLE_DEVELOPER,
                    'stat' => [OrderMailing::STAT_SENT, OrderMailing::STAT_SELECTED]
                ],
            ],
            'btn' => [
                'pictureClass' => 'fa fa-plus',
                'title' => 'переход к следующему состоянию',
                'onClick' => 'orderStatTogglePlus',
                'disabled' => false
            ]
        ],
        'minus' => [
            'rule' => [
                ['role' => self::ROLE_CUSTOMER,
                    'stat' => [OrderMailing::STAT_SENT_READY, OrderMailing::STAT_SELECTED_READY]
                ],
                ['role' => self::ROLE_DEVELOPER,
                    'stat' => [OrderMailing::STAT_ANSWERED_READY, OrderMailing::STAT_SELECTED_ANSWERED_READY],
                ],
            ],
            'btn' => [
                'pictureClass' => 'fa fa-minus',
                'title' => 'возврат к предыдущему состоянию',
                'onClick' => 'orderStatToggleMinus',
                'disabled' => false
            ]

        ]
    ];
    protected $orderLock = [
        'orderLockYes' => [
            'lock' => true,
            'btTitle' =>
                'Заказ закрыт для изменений',
            'btClass' => 'btn btn-primary',
            'pictureClass' => 'fa fa-lock',

        ],
        'orderLockNo' => [
            'lock' => false,
            'btTitle' =>
                'Заказ открыт для изменений',
            'btClass' => 'btn btn-primary',
            'pictureClass' => 'fa fa-unlock',

        ],

    ];

    // это список обязательных полей в заголовок списка
    protected $defaultItemFields = [
        'id' => [
            'name' => 'Id', 'value' => 'userId'],
        'name' => ['name' => 'имя', 'value' => 'profileCompany'],
        'editFlag' => ['name' => 'возможность редактировать',
            'value' => 'editFlag', 'default' => true],
        'fullyFlag' => ['name' => 'полное включение',
            'value' => 'fullyFlag', 'default' => false],
        'lockFlag' => ['name' => 'Закрыт для редактирования',
            'value' => 'lockFlag', 'default' => false],
        'lockTime' => ['name' => 'Момент закрытия для редактирования',
            'value' => 'lockFlagTime', 'default' => false],
        'deadline_answer' => [
            'name' => 'deadline ответа на предложение участия в конкурсе',
            'value' => 'deadlineAnswer', 'default' => false],
        'deadlineSelect' => ['name' => 'deadline ответа на выбор исполнителем заказа',
            'value' => 'deadlineSelect', 'default' => false],
        'currentOrderStat' => ['name' => 'тек состояние заказа по исполнителю',
            'value' => 'currentOrderStat'],
        'currentOrderLock' => ['name' => 'заказ закрыт для изменений',
            'value' => 'lockFlag', 'default' => false],

    ];

    protected $currentItemFields = [];


    protected $subItemAsIsFlag = false;  // оставить как есть
    // это список полей в раскрывающийся список для вывода:
    // копания {набор конопок-иконок. обозначающих состояние заказа}
    protected $subItemFields = [
        'registrationDate' => [
            'name' => 'регистрация', 'value' => 'userDateFirst'],
        'description' => ['name' => 'описание', 'value' => 'profileInfo'],
        'proposals' => ['name' => 'предложений', 'value' => 'sentCount'],
        'answers' => ['name' => 'подтверждений готовности', 'value' => 'answeredCount'],
        'selections' => ['name' => 'выбран исполнителем', 'value' => 'selectedCount'],
    ];
    protected $btnDefault = [
        'profile' => [
            'btTitle' => 'профиль исполнителя',
            'btClass' => 'btn btn-primary',
            'pictureClass' => 'fa fa-caret-right',
            'onClick' => 'orderMailingProfileClick',
        ],
        'workingRank' => [
            'btTitle' => 'оценка исполняемых работ(%)',
            'btClass' => 'btn btn-primary',
            'pictureClass' => 'fa fa-battery-full',
            'onClick' => '',
            'disabled' => true
        ],
        'geographyRank' => [
            'btTitle' =>
                'оценка географии работ исполнителя(100% - город есть 50% - только регион)',
            'btClass' => 'btn btn-primary',
            'pictureClass' => 'fa fa-battery-full',
            'onClick' => '',
            'disabled' => true
        ],
        'orderStat' => [
            'btTitle' =>
                'состояние заказа',
            'btClass' => 'btn btn-primary',
            'pictureClass' => 'fa fa-frown-o',
            'onClick' => '',
            'disabled' => true
        ],
        'toggleStat' => [
            'btTitle' =>
                'переключение состояния',
            'btClass' => 'btn btn-primary',
            'pictureClass' => 'fa fa-square-o',
            'onClick' => '',
            'disabled' => true
        ],
        'orderLock' => [
            'btTitle' =>
                'Заказ закрыт для изменений',
            'btClass' => 'btn btn-primary',
            'pictureClass' => 'fa fa-lock',
            'onClick' => 'orderLockClick',
            'disabled' => true
        ],
        'orderEdit' => [
            'btTitle' =>
                'Редактировать заказ',
            'btClass' => 'btn btn-primary',
            'pictureClass' => 'glyphicon glyphicon-edit',
            'onClick' => 'orderItemEdit',
            'disabled' => false
        ],


    ];

    protected $btnCurrent = []; // текущий набор кнопок
//    private $rankPicture = [
//        0 => 'fa fa-battery-empty fa-lg',
//        25 => 'fa fa-battery-quarter fa-lg',
//        50 => 'fa fa-battery-half fa-lg',
//        75 => 'fa fa-battery-three-quarters fa-lg',
//        100 => 'fa fa-battery-full fa-lg',
//    ] ;

    protected $rankPicture = [
        0 => ['pictureClass' => 'fa fa-battery-empty',
            'btClass' => 'btn btn-danger',],
        25 => ['pictureClass' => 'fa fa-battery-quarter',
            'btClass' => 'btn btn-danger',],
        50 => ['pictureClass' => 'fa fa-battery-half',
            'btClass' => 'btn btn-danger',],
        75 => ['pictureClass' => 'fa fa-battery-three-quarters',
            'btClass' => 'btn-warning',],
        100 => ['pictureClass' => 'fa fa-battery-full',
            'btClass' => 'btn btn-success',]
        ,
    ];
    private $btList = [
        'profile'=>[],'workingRank'=>[],'geographyRank'=>[],
        'orderStat'=>[],'toggleStat' => []];


//--------------------------------------------------------//
    public function __construct($role = '')
    {
        $this->currentRole = $role;

        $this->setCurrent();
        foreach ($this->btnCurrent as $btKey => $btAttr) {
            $btAttr['btClass'] .= ' ' . self::BT_CLASS;
            $this->btnCurrent[$btKey] = $btAttr;
        }

    }

    /**
     * настройка $this->btnCurrent, $this->subItemFields
     */
    protected function setCurrent()
    {
        if (empty($this->currentRole)) {
            $this->currentRole = self::ROLE_CUSTOMER;
        }
//        $this->btnCurrent = $this->btnDefault;
        $this->btnCurrent = [];
        foreach ($this->btList as $key => $btAttr) {
            $this->btnCurrent[$key] = $this->btnDefault[$key];
            foreach ($btAttr as $attrKey => $attrValue) {
                $this->btnCurrent[$key][$attrKey] = $btAttr[$attrKey];
            }
        }




        $this->currentItemFields = $this->defaultItemFields;
    }

    /**
     * преобразовать формат БД и формат вывода
     * формат вывода для widget CollapsibleListWidget
     * исходный формат
     * item = [
     *'userId' => $item['userid'],
     *'userDateFirst' => $item['user_date_first'],
     *'profileCompany' => $item['profile_company'],
     *'profileInfo' => $item['profile_info'],
     *'profileAvatar' => $item['profile_avatar'],
     *'profileCityId' => $item['profile_city_id'],
     *'profileCityName' => $item['profile_city_name'],
     * 'sentCount' => $item['sent_count'],
     *'answeredCount' => $item['answered_count'],
     *'selectedCount' => $item['selected_count'],
     *'currentOrderStat' => $item['current_order_stat'],
     *'workDirectionRank' => $item['work_direction_rank'],
     *'regionStat' => $item['region_stat'],
     *'cityStat' => $item['city_stat'],
     *'geographyRank' => $item['geography_rank'],
     *
     */
    public function getItemsForShow($dbItems)
    {
        $itemsShow = [
            'buttons' => [],  //  кнопки по умолчанию
            'setItems' => []     // элементы
        ];
        $setItems = [];
        foreach ($dbItems as $index => $dbItem) {
//            $item = [
//                'id' => $dbItem['userId'],
//                'name' => $dbItem['profileCompany'],
//                'editFlag' => true,
//                'fullyFlag' => false
//            ] ;
            $itemLockValue  = false ;
            if (isset($this->currentItemFields['currentOrderLock'])) {
                $key = $this->currentItemFields['currentOrderLock']['value'];
                $default = $this->currentItemFields['currentOrderLock']['default'];
                $itemLockValue = (isset($dbItem[$key])) ? $dbItem[$key] : $default;

            }



            $item = [];
            foreach ($this->currentItemFields as $fieldId => $itemField) {
                $key = $itemField['value'];
                $default = (isset($itemField['default'])) ? $itemField['default'] : false;
                $item[$fieldId] = (isset($dbItem[$key])) ? $dbItem[$key] : $default;
            }
            if ($this->subItemAsIsFlag) {
                $item['subItems'] = $dbItem['subItems'];
            } else {
                $subItems = [];
                foreach ($this->subItemFields as $fieldId => $itemField) {
                    $subItems[] = '<b>' . $itemField['name'] . ': ' . '</b>' .
                        $dbItem[$itemField['value']];

                }
                $item['subItems'] = $subItems;
            }


            $itemButtons = $this->btnCurrent;
//            $statValue = $dbItem['currentOrderStat'] ;
            $key = $this->currentItemFields['currentOrderStat']['value'];
            $statValue = $dbItem[$key];
            $subItemButtons = $this->orderStatBtPrepare($statValue);
            foreach ($subItemButtons as $key => $btAttr) {
                if (isset($itemButtons['orderStat'])) {
                    $itemButtons['orderStat'][$key] = $btAttr;
                }

            }
// для кнопки orderLock
            if (isset($itemButtons['orderLock'])) {
                $key = $this->currentItemFields['currentOrderLock']['value'];
                $default = $this->currentItemFields['currentOrderLock']['default'];
                $lockValue = (isset($dbItem[$key])) ? $dbItem[$key] : $default;

//            $lockValue = $dbItem['currentOrderLock'] ;
                $subItemButtons = $this->orderLockBtPrepare($lockValue);
                foreach ($subItemButtons as $key => $btAttr) {
                    if (isset($itemButtons['orderLock'])) {
                        $itemButtons['orderLock'][$key] = $btAttr;
                    }

                }

            }

            if (isset($itemButtons['workingRank'])) {
                $workingRank = $dbItem['workDirectionRank'];
                if ($workingRank <= 100) {
                    $btWorkingRank = $this->rankBtPrepare($workingRank);
                    $itemButtons['workingRank']['pictureClass'] =
                        $btWorkingRank['pictureClass'];
                    $itemButtons['workingRank']['btClass'] =
                        $btWorkingRank['btClass'];

                }
            }
// переключение состояний //
            if (isset($itemButtons['toggleStat'])) {

                $key = $this->currentItemFields['currentOrderStat']['value'];
                $statValue = $dbItem[$key];

                $toggleBt = $this->togglePrepare($statValue);
                foreach ($toggleBt as $key => $btAttr) {
                    if (isset($itemButtons['toggleStat'])) {
                        $itemButtons['toggleStat'][$key] = $btAttr;
                    }
                }
                if ($itemLockValue) {
                    $itemButtons['toggleStat']['disabled'] = true ;
                }
            }

            if (isset($itemButtons['geographyRank'])) {
                $geographyRank = $dbItem['geographyRank'];
                $btGeographyRank = [];
                if ($geographyRank <= 100) {
                    $btGeographyRank = $this->rankBtPrepare($geographyRank);
                    $itemButtons['geographyRank']['pictureClass'] =
                        $btGeographyRank['pictureClass'];
                    $itemButtons['geographyRank']['btClass'] =
                        $btGeographyRank['btClass'];

                }
            }

            foreach ($itemButtons as $btKey => $btAttr) {
                $btAttr['btClass'] .= ' ' . self::BT_CLASS;
                $itemButtons[$btKey] = $btAttr;
            }


            $item['buttons'] = $itemButtons;
            $setItems[] = $item;
        }
        foreach ($this->btnCurrent as $btKey => $btAttr) {
            $btAttr['btClass'] .= ' ' . self::BT_CLASS;
            $this->btnCurrent[$btKey] = $btAttr;
        }

        $itemsShow['setItems'] = $setItems;
        $itemsShow['buttons'] = $this->btnCurrent;
        return $itemsShow;
    }

    private function rankBtPrepare($rank)
    {
        $keys = array_keys($this->rankPicture);
        $rankBt = [];
        $nMax = sizeof($keys) - 1;
        for ($i = 0; $i <= $nMax; $i++) {
            $cond = false;
            if ($i === $nMax) {
                $cond = $rank >= $keys[$i];
            } else {
                $cond = ($rank >= $keys[$i] && $rank < $keys[$i + 1]);
            }
            if ($cond) {
                $k = $keys[$i];
                $pict = $this->rankPicture[$k]['pictureClass'];
                $btClass = $this->rankPicture[$k]['btClass'];
                $rankBt['pictureClass'] = $pict;
                $rankBt['btClass'] = $btClass;
            }
        }
        return $rankBt;
    }

    /**
     * подготовить атрибуту кнопки для поля orderStat -
     * состояние заказа для исполнителя
     */
    private function orderStatBtPrepare($statValue)
    {
        $statBt = [];
        foreach ($this->orderStat as $statKey => $statAttr) {
            if (false !== array_search($statValue, $statAttr['stat'])) {
                if (isset($statAttr['roles'])) {     // наличие синонима
                    $roles = $statAttr['roles'];
                    if (isset($roles[$this->currentRole]['synonym'])) {
                        $statKey = $roles[$this->currentRole]['synonym'];
                        $statAttr = $this->orderStat[$statKey];
                        array_push($statAttr['stat'], $statValue);
                    }
                }

                foreach ($statAttr as $key => $value) {
//                    if ($key === 'stat' || ) {
                    if (false !== array_search($key, ['stat', 'roles'])) {
                        continue;
                    }
                    $statBt[$key] = $value;
                }
// возможна корректировка по роли (ИСПОЛНИТЕЛЬ || ЗАКАЗЧИК)
                if (isset($statAttr['roles'])) {
                    $roles = $statAttr['roles'];

                    if (isset($roles[$this->currentRole])) {
                        $roleAttr = $roles[$this->currentRole];
                        foreach ($roleAttr as $key => $value) {
                            if ($key === 'synonym') {
                                continue;
                            }
                            $statBt[$key] = $value;
                        }
                    }
                }
            }
        }
        return $statBt;
    }

    private function orderLockBtPrepare($lockValue)
    {
        $lockBt = [];
        foreach ($this->orderLock as $lockKey => $lockAttr) {
            if ($lockValue == $lockAttr['lock']) {
                foreach ($lockAttr as $key => $value) {
                    if ($key === 'lock') {
                        continue;
                    }
                    $lockBt[$key] = $value;
                }
            }
        }
        return $lockBt;
    }
//'plus' => [
//'rule' => [
//['role' => self::ROLE_CUSTOMER,
//'stat' => [OrderMailing::STAT_NO_SENT,OrderMailing::STAT_ANSWERED,OrderMailing::STAT_SELECTED_ANSWERED]
//],
//['role' => self::ROLE_DEVELOPER,
//'stat' => [OrderMailing::STAT_SENT,OrderMailing::STAT_SELECTED]
//],
//],
//'btn' => [
//'pictureClass' => 'fa fa-plus',
//'onClick' => 'orderStatTogglePlus'
//]
//],

    private function togglePrepare($statValue)
    {
        $toggleBt = [];
        $isFind = false;
        foreach ($this->toggleStat as $toggleKey => $toggleAttr) {

            $ruleArr = $toggleAttr['rule'];
            for ($i = 0; $i < sizeof($ruleArr); $i++) {
                $rule = $ruleArr[$i];
                $role = $rule['role'];
                if ($role !== $this->currentRole) {
                    continue;
                }
                $statLst = $rule['stat'];
                if (false !== array_search($statValue, $statLst)) {
                    $isFind = true;
                    break;
                }
            }
            if ($isFind) {
                $btAttr = $toggleAttr['btn'];
                foreach ($btAttr as $key => $value) {
                    $toggleBt[$key] = $value;
                }

                break;
            }


        }
        return $toggleBt;
    }

}