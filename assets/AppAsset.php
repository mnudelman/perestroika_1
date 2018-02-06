<?php
///**
// * @link http://www.yiiframework.com/
// * @copyright Copyright (c) 2008 Yii Software LLC
// * @license http://www.yiiframework.com/license/
// */
//
//namespace app\assets;
//
//use yii\web\AssetBundle;
//
///**
// * @author Qiang Xue <qiang.xue@gmail.com>
// * @since 2.0
// */
//class AppAsset extends AssetBundle
//{
//    public $basePath = '@webroot';
//    public $baseUrl = '@web';
//    public $css = [
//        'css/site.css',
//    ];
//    public $js = [
//    ];
//    public $depends = [
//        'yii\web\YiiAsset',
//        'yii\bootstrap\BootstrapAsset',
//    ];
//}
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
//        'css/bootstrap.min.css',
        'https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css',
//        'css/font-awesome.min.css',
//        'css/prettyPhoto.css',
//        'css/price-range.css',
//        'css/animate.css',
        'css/main.css',
//        'css/responsive.css',
    ];
    public $js = [
//        'js/jquery.js',
//        'js/bootstrap.min.js',
//        'js/jquery.scrollUp.min.js',
//        'js/price-range.js',
//        'js/jquery.prettyPhoto.js',
//        'js/jquery.cookie.js',
//        'js/jquery.accordion.js',
        'js/main.js',
        'js/geography.js',
        'js/workGeography.js',
        'js/workDirection.js',
        'js/workGallery.js',
        'js/order.js',
        'js/pagination.js',
        'js/orderMailing.js',
        'js/orderMailingProfile.js',
        'js/office.js',
        'js/orderView.js',
        'js/menuPath.js',
        'js/orderStatus.js',
        'js/developerOrders.js',
        'js/profile.js',

    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\jui\JuiAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        'yii\bootstrap\BootstrapThemeAsset',
//        'dosamigos\datepicker\DatePickerLanguageAsset'
    ];
}
