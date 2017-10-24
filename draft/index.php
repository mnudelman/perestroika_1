<?php
/*
  * Главный шаблон
  */
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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    include __DIR__ . "/views/headPart.php";

    ?>
    <title><?= $title ?></title>
</head>
<body>
<?php include __DIR__ . "/views/topMenu.php" ?>
<div class="container body-content">

    <?php
    include __DIR__ . '/views/'.$currentPage.'.php' ;
    ?>


</div>
<?php
include __DIR__ . "/views/footerPart.php" ;
?>


</body>
</html>