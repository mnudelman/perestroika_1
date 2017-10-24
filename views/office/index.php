<?php
/**
 * Кабинет
 *
 */
use yii\bootstrap\Tabs;
use yii\helpers\Html ;
use yii\helpers\Url ;
use app\models\UserProfile ;
use app\service\PageItems ;
$htmlPrefix = 'office' ;
echo Tabs::widget([
    'options' => ['id' => $htmlPrefix . 'TabHeader'],
    'items' => [
        [
            'label' => 'Я - Заказчик',
            'content' => $this->render('tabItem',
                ['tabTitle' => 'Размещение заказов',
                    'tabContent' => 'officeOrder','htmlPrefix' => $htmlPrefix]),
            'headerOptions' => ['name'=>$htmlPrefix . '-' . 'order' . '-header'],
            'options' => ['name'=>$htmlPrefix . '-' . 'order' . '-content'],
        ],
        [
            'label' => 'Я - Исполнитель',
            'content' => $this->render('tabItem',
                ['tabTitle' => 'Общие сведения',
                    'tabContent' => 'officeDeveloper','htmlPrefix' => $htmlPrefix]),
            'options' => ['name'=>$htmlPrefix . '-' . 'developer' . '-content'],
            'headerOptions' => ['name'=>$htmlPrefix . '-' . 'developer' . '-header'],
        ],
        [
            'label' => 'Мой профиль',
            'content' => $this->render('tabItem',
                ['tabTitle' => 'Профиль пользователя',
                    'tabContent' => 'officeProfile','htmlPrefix' => $htmlPrefix]),
            'options' => ['name'=>$htmlPrefix . '-' . 'profile' . '-content'],
            'headerOptions' => ['name'=>$htmlPrefix . '-' . 'profile' . '-header'],
        ],
        [
            'label' => 'Моя переписка',
            'content' => $this->render('tabItem',
                ['tabTitle' => 'Коммуникация',
                    'tabContent' => 'officeCommunication','htmlPrefix' => $htmlPrefix]),
            'options' => ['name'=>$htmlPrefix . '-' . 'communication' . '-content'],
            'headerOptions' => ['name'=>$htmlPrefix . '-' . 'communication' . '-header'],
        ],
    ]
]);