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

?>
<div style="border: 3px solid">
<?php
echo Tabs::widget([
    'items' => [
        [
            'label' => $tabItemName['general'],     // 'Общее',
//            'content' => $this->render('profile'),
            'content' => $this->render('profile',['tabTitle' => 'Это профиль']),
            'headerOptions' => ['name'=>$htmlPrefix . '-' . 'general' . '-header'],
            'active' => true
        ],
        [
            'label' => $tabItemName['geography'], //'География',
            'content' => $this->render('geographyWorks',['tabTitle' => 'География работ']),
            'headerOptions' => ['name'=>$htmlPrefix . '-' . 'geography' . '-header'],
        ],
        [
            'label' => $tabItemName['works'], //'работы/услуги',
            'content' => $this->render('developerWorks',['tabTitle' => 'Работы/услуги']),
            'headerOptions' => ['name'=>$htmlPrefix . '-' . 'works' . '-header'],
        ],
        [
            'label' => $tabItemName['gallery'], //'галерея',
//            'options' => ['name' => 'workGalleryEdit'],
//            'content' => $this->render('developerWorksGallery'),
            'content' => $this->render('developerWorksGallery',['tabTitle' => 'Галерея','name' => 'workGalleryEdit']),
            'headerOptions' => ['name'=>$htmlPrefix . '-' . 'gallery' . '-header'],
        ],

    ]
]);
?>
</div>
