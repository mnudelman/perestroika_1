<?php
/**
 * Исполнители
 *
 */
use yii\bootstrap\Tabs;
use yii\helpers\Html ;
use yii\helpers\Url ;
use app\service\PageItems ;
?>
<?php
$tabItemName = PageItems::getItemText(['profile/tabs']);
$htmlPrefix = 'profileEdit' ;

//$path = Url::to(['@app/views/layouts/layoutParts/developerWorks.php']) ;
echo Tabs::widget([
    'items' => [
        [
            'label' => $tabItemName['general'],     // 'Общее',
//            'content' => $this->render('profile'),
            'content' => $this->render('tabItem',['tabTitle' => 'Это профиль','tabContent' => 'profile']),
            'headerOptions' => ['name'=>$htmlPrefix . '-' . 'general' . '-header'],
            'active' => true
        ],
        [
            'label' => $tabItemName['geography'], //'География',
            'content' => $this->render('tabItem',['tabTitle' => 'География работ','tabContent' => 'geographyWorks']),
            'headerOptions' => ['name'=>$htmlPrefix . '-' . 'geography' . '-header'],
        ],
        [
            'label' => $tabItemName['works'], //'работы/услуги',
            'content' => $this->render('tabItem',['tabTitle' => 'Работы/услуги','tabContent' => 'developerWorks']),
            'headerOptions' => ['name'=>$htmlPrefix . '-' . 'works' . '-header'],
        ],
        [
            'label' => $tabItemName['gallery'], //'галерея',
//            'options' => ['name' => 'workGalleryEdit'],
//            'content' => $this->render('developerWorksGallery'),
            'content' => $this->render('tabItem',['tabTitle' => 'Галерея',
                'tabContent' => 'developerWorksGallery','name' => 'workGalleryEdit']),
            'headerOptions' => ['name'=>$htmlPrefix . '-' . 'gallery' . '-header'],
        ],

    ]
]);