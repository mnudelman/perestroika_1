<?php
session_start() ;
// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');
$dirInfo = pathinfo($_SERVER['DOCUMENT_ROOT'].$_SERVER['REQUEST_URI']) ;
$dir = $dirInfo['dirname'] ;
$dirProjects = realpath($dir.'/../..') ;
$dirTask = $dirProjects . '/perestroika' ;
//realpath((pathinfo($_SERVER['DOCUMENT_ROOT'].$_SERVER['REQUEST_URI']))['dirname'].'/../..')
//$dirProjects = realpath(__DIR__ . '../../../') ;
require(__DIR__ . '/functions.php') ;
$dirVendor = $dirTask . '/vendor' ;

require($dirVendor . '/autoload.php');
require($dirVendor . '/yiisoft/yii2/Yii.php');


//require(__DIR__ . '/../vendor/autoload.php');
//require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');

//$config = require(__DIR__ . '/../config/web.php');

$config = require($dirTask. '/config/web.php');
$config['vendorPath'] = $dirVendor ;
if (isset($_GET['r']) &&
    isset($config['components']['urlManager']['enablePrettyUrl'])) {
    $config['components']['urlManager']['enablePrettyUrl'] = false ;
}
//(new yii\web\Application($config))->run();
$app = new yii\web\Application($config) ;
if (isset($_SESSION['language'])) {
    $app->language = $_SESSION['language'] ;
}
$app->run() ;
