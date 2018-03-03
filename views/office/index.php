<?php
/**
 * Кабинет -  меню
 *
 */
use yii\bootstrap\Tabs;
use app\service\PageItems ;
$htmlPrefix = 'office' ;
$officeTabs = PageItems::getItemText(['office/tabs']) ;


echo Tabs::widget([
    'options' => ['id' => $htmlPrefix . 'TabHeader','class' => 'tab-header-1'],
    'items' => [
        [
            'label' => $officeTabs['customer'],             //'Я - Заказчик',
            'content' => $this->render('officeOrder',
                ['tabTitle' => 'Размещение заказов','htmlPrefix' => $htmlPrefix ]),
            'headerOptions' => ['name'=>$htmlPrefix . '-' . 'order' . '-header'],
            'options' => ['name'=>$htmlPrefix . '-' . 'order' . '-content',],
        ],
        [
            'label' => $officeTabs['executor'], //    'Я - Исполнитель',
            'content' => $this->render('officeDeveloper',
                ['tabTitle' => 'Общие сведения','htmlPrefix' => $htmlPrefix]),
            'options' => ['name'=>$htmlPrefix . '-' . 'developer' . '-content'],
            'headerOptions' => ['name'=>$htmlPrefix . '-' . 'developer' . '-header'],
        ],
        [
            'label' => $officeTabs['profile'],      // 'Мой профиль',
            'content' => $this->render('officeProfile',
                ['tabTitle' => 'Профиль пользователя','htmlPrefix' => $htmlPrefix]),
            'options' => ['name'=>$htmlPrefix . '-' . 'profile' . '-content'],
            'headerOptions' => ['name'=>$htmlPrefix . '-' . 'profile' . '-header'],
        ],
        [
            'label' => $officeTabs['correspondence'],   // 'Моя переписка',
            'content' => $this->render('officeCommunication',
                ['tabTitle' => 'Коммуникация','htmlPrefix' => $htmlPrefix]),
            'options' => ['name'=>$htmlPrefix . '-' . 'communication' . '-content'],
            'headerOptions' => ['name'=>$htmlPrefix . '-' . 'communication' . '-header'],
        ],
    ]
]);