<?php
/*
  * Главный шаблон
  */

use yii\helpers\Html;
use app\assets\AppAsset;
use app\components\MenuPathWidget ;

AppAsset::register($this);
$pageNames = [
    'homePage' => 'Перестройка',
    'developersList' => 'исполнители',
    'newOrder' => 'заказ',
    'about' => 'о сайте',
    'registration' => 'регистрация',
    'forum' => 'форум',
    'authorisation' => 'авторизация',
    'languageTrigger' => 'язык',
    'privateOffice' => 'кабинет'
] ;
$PAGE_DEFAULT = 'homePage' ;
$currentPage = (isset($_GET['page'])) ? $_GET['page'] :  $PAGE_DEFAULT ;
$pageName = ( isset($pageNames[$currentPage]) ) ? $pageNames[$currentPage] : 'noName' ;
$prefix = ($currentPage === 'homePage') ? '' : 'Пере...|' ;

$title =  $prefix . $pageName ;
if (isset($_SESSION['lang'])) {
    Yii::$app->language = $_SESSION['lang'] ;
}

?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">

        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($title) ?></title>

        <?php $this->head() ?>

        <link id="page_favicon" href="images/favicon.ico" rel="icon" type="image/x-icon" />
     <style>
         body {
             background: url(images/bg/linen.jpg) ;
         /*background: url(images/bg/bg-light-4865.png)*/
         }
         /*.tab-header-1 {*/
             /*font-weight:500;*/
             /*color:red;*/
             /*border:4px solid;*/
             /*!*padding: 1px;*!*/
         /*}*/

     </style>
    </head>
<body>
<?php $this->beginBody() ?>
<!--обновление CSS в кэше-->
<?=time()?>

<!--<div class="wrap">-->
<?=$this->render('layoutParts/topPage')?>
<!--<div style="width:100%;height:40px;margin-top:-15px" id="menuPath">-->
    <?php
    echo MenuPathWidget::widget();
    ?>
<!--    <p>this is breadcrumps</p>-->
<!--</div>-->

    <div class="container">
        <?= $content ?>
    </div>
<?=$this->render('layoutParts/login') ;?>
<?=$this->render('layoutParts/registration') ;?>
<?=$this->render('layoutParts/profile') ;?>
<?=$this->render('layoutParts/footerPart')?>
<?=$this->render('layoutParts/errorShow')?>

<!--//= Html::script('alert("Привет!");', ['defer' => true]); -->



<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>













