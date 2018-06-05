<?php
/**
 * Кабинет -  меню
 *
 */
use yii\bootstrap\Tabs;
use app\service\PageItems ;
use app\service\TaskStore ;
use app\controllers\funcs\OrderStatFunc ;
$htmlPrefix = 'office' ;
$officeTabs = PageItems::getItemText(['office/tabs']) ;
$developerRole = OrderStatFunc::USER_ROLE_DEVELOPER ;
$customerRole = OrderStatFunc::USER_ROLE_CUSTOMER ;
$userRole = OrderStatFunc::USER_ROLE_USER;
$currentRole = TaskStore::getParam('currentUserRole') ;
$currentRole = (empty($currentRole)) ? $customerRole : $currentRole ;


echo Tabs::widget([
    'options' => ['id' => $htmlPrefix . 'TabHeader','class' => 'tab-header-1'],
    'items' => [
        [
            'label' => $officeTabs['customer'],             //'Я - Заказчик',
            'active' => $currentRole === $customerRole,
            'content' => $this->render('officeOrder',
                ['tabTitle' => 'Размещение заказов','htmlPrefix' => $htmlPrefix ]),
            'headerOptions' => ['name'=>$htmlPrefix . '-' . 'order' . '-header'],
            'options' => ['name'=>$htmlPrefix . '-' . 'order' . '-content',],
        ],
        [
            'label' => $officeTabs['executor'], //    'Я - Исполнитель',
            'active' => $currentRole === $developerRole,
            'content' => $this->render('officeDeveloper',
                ['tabTitle' => 'Общие сведения','htmlPrefix' => $htmlPrefix]),
            'options' => ['name'=>$htmlPrefix . '-' . 'developer' . '-content'],
            'headerOptions' => ['name'=>$htmlPrefix . '-' . 'developer' . '-header'],
        ],
        [
            'label' => $officeTabs['profile'],      // 'Мой профиль',
            'active' => $currentRole === $userRole,
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