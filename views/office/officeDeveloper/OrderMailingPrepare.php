<?php
/**
 * Подготовка формата вывода для страницы orderMailing.php - рассылка заказа
 * исполнителям
 * Time: 22:09
 */
namespace app\views\order;
use app\models\OrderMailing ;

class OrderMailingPrepare
{
    private $orderMailingStat = [
        'notSent' => [
            'stat' => [OrderMailing::STAT_NO_SENT], // не отправлено предложение
            'pictureClass' => 'fa fa-envelope-o fa-lg',
            'btTitle' => 'Состояние заказа. Предложение не отправлено',
        ],
        'sent' => [
                'stat' => [OrderMailing::STAT_SENT],    // отправлено предложение
                'pictureClass' => 'fa fa-send-o fa-lg',
                'btTitle' => 'Состояние заказа. Предложение отправлено',
        ],
        'answered' => [
            'stat' => [
                OrderMailing::STAT_ANSWERED, // согласие на исполнение
                OrderMailing::STAT_SELECTED],
            'pictureClass' =>'fa fa-check-square-o fa-lg',
            'btTitle' => 'Состояние заказа. Получено подтверждение от исполнителя',
        ],
        'selected' => [
            'stat' => [OrderMailing::STAT_SELECTED],  // выбран исполнителем
            'pictureClass' => 'fa fa-thumbs-o-up fa-lg',
            'btTitle' => 'Выбран исполнителем',
        ],
    ];
    private $subItemFields = [
        'registrationDate' => [
            'name' => 'регистрация','value' => 'userDateFirst'],
        'description' => ['name' => 'описание','value' => 'profileInfo'],
        'proposals' =>  ['name' => 'предложений', 'value' => 'sentCount'],
        'answers' => ['name' => 'подтверждений готовности', 'value' => 'answeredCount'],
        'selections' => ['name' => 'выбран исполнителем', 'value' => 'selectedCount']
     ] ;
    private $btnDefault = [
        'profile' => [
            'btTitle' => 'профиль исполнителя',
            'btClass' => 'btn-primary',
            'pictureClass' => 'fa fa-caret-right fa-lg',
            'onClick' => 'orderMailingProfileClick',
        ],
        'workingRank' => [
            'btTitle' => 'оценка исполняемых работ(%)',
            'btClass' => 'btn-primary',
            'pictureClass' => 'fa fa-battery-full fa-lg',
            'onClick' => '',
            'disabled' => true
        ],
        'geographyRank' => [
            'btTitle' =>
                'оценка географии работ исполнителя(100% - город есть 50% - только регион)',
            'btClass' => 'btn-primary',
            'pictureClass' => 'fa fa-battery-full fa-lg',
            'onClick' => '',
            'disabled' => true
        ],
        'orderStat' => [
            'btTitle' =>
                'состояние заказа',
            'btClass' => 'btn-primary',
            'pictureClass' => 'fa fa-envelope-o fa-lg',
            'onClick' => '',
            'disabled' => true
        ],
        'selected' => [
            'btTitle' =>
                'не выбран исполнителем заказа',
            'btClass' => 'btn-primary',
            'pictureClass' => 'fa fa-square-o fa-lg',
            'onClick' => 'orderSelect',
        ],
    ] ;
    private $rankPicture = [
        0 => 'fa fa-battery-empty fa-lg',
        25 => 'fa fa-battery-quarter fa-lg',
        50 => 'fa fa-battery-half fa-lg',
        75 => 'fa fa-battery-three-quarters fa-lg',
        100 => 'fa fa-battery-full fa-lg',
    ] ;


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
        $setItems = [] ;
        foreach($dbItems as $index => $dbItem) {
            $item = [
                'id' => $dbItem['userId'],
                'name' => $dbItem['profileCompany'],
                'editFlag' => true,
                'fullyFlag' => false
            ] ;
            $subItems = [] ;
            foreach($this->subItemFields as $fieldId => $itemField) {
                $subItems[] =  '<b>' . $itemField['name'] . ': ' .'</b>' .
                    $dbItem[$itemField['value']] ;

            }
            $item['subItems'] = $subItems ;

            $itemButtons = $this->btnDefault ;
            $statValue = $dbItem['currentOrderStat'] ;
            $subItemButtons = $this->orderStatBtPrepare($statValue) ;
            foreach ($subItemButtons as $key => $btAttr) {
                $itemButtons['orderStat'][$key] = $btAttr ;
             }
// для кнопки selected отдельно
            $selectedStat = $this->orderMailingStat['selected']['stat'] ;
            if (false !== array_search($statValue,$selectedStat)) {
                $statAttr = $this->orderMailingStat['selected'] ;
                foreach($statAttr as $key => $value) {
                    if ($key === 'stat') {
                        continue ;
                    }
                    $itemButtons['selected'][$key] = $value  ;
//                    $this->orderMailingStat['selected'][$key] = $value ;
                }
            }

            $workingRank = $dbItem['workDirectionRank'] ;
            if ( $workingRank < 100) {
                $btWorkingRank =  $this->rankBtPrepare($workingRank) ;
                $itemButtons['workingRank']['pictureClass'] =
                    $btWorkingRank['pictureClass'];
            }
            $geographyRank = $dbItem['geographyRank'] ;
            $btGeographyRank = [] ;
            if ( $geographyRank < 100) {
                $btGeographyRank =  $this->rankBtPrepare($geographyRank) ;
                $itemButtons['geographyRank']['pictureClass'] =
                    $btGeographyRank['pictureClass'];
            }
            $item['buttons'] = $itemButtons ;
            $setItems[] = $item ;
        }
        $itemsShow['setItems'] = $setItems ;
        $itemsShow['buttons'] = $this->btnDefault ;
        return $itemsShow ;
    }
    private function rankBtPrepare($rank) {
       $keys = array_keys($this->rankPicture) ;
       $rankBt = [] ;
       for ($i = 0; $i < sizeof($keys) - 2; $i++) {
           if ($rank >= $keys[$i] && $rank < $keys[$i+1]) {
               $rankBt['pictureClass'] = $this->rankPicture[$keys[$i]] ;
           }
       }
       return $rankBt ;
    }
    /**
     * подготовить атрибуту кнопки для поля orderStat -
     * состояние заказа для исполнителя
     */
    private function orderStatBtPrepare($statValue) {
        $statBt = [] ;
        foreach($this->orderMailingStat as $statKey => $statAttr) {
            if($statKey === 'selected') {
                continue ;
            }
            if (false !== array_search($statValue,$statAttr['stat'])) {
                foreach($statAttr as $key => $value) {
                    if ($key === 'stat') {
                        continue ;
                    }
                    $statBt[$key] =  $value ;
                }
            }
        }
        return $statBt;
    }
}