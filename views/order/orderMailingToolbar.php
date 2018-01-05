<?php
/**
 *  Панель инструментов для закладки Я-заказчик. Общее (orderGeneral.php)
 * @var $htmlPrefix
 * @var $indexPagesVect - вектор параметров пагинации
 */

?>
<?php

use app\service\PageItems;
use app\components\ToolbarWidget;

$pageItemFile = 'order/mailing';
$partsTitle = PageItems::getItemText([$pageItemFile, 'partsTitle']);
$partsTitleCurrent = $partsTitle['current'];
$partsTitleEdit = $partsTitle['edit'];
$partsTitleCurrent = 'Исполнители';
//$indexPagesVect = $res['indexPages'] ;

//$indexPagesVect = (new Pagination('order'))->getIndexPages() ;
$indexPagesList = $indexPagesVect['indexPages'];
$currentPage = $indexPagesVect['currentPage'];
$firstClass = ($indexPagesVect['firstFlag']) ? '' : 'class="disabled"';
$prevClass = ($indexPagesVect['prevFlag']) ? '' : 'class="disabled"';
$nextClass = ($indexPagesVect['nextFlag']) ? '' : 'class="disabled"';
$lastClass = ($indexPagesVect['lastFlag']) ? '' : 'class="disabled"';


?>
    <!--<div class="row">-->
    <!--    <div class="col-md-3">-->
    <!--        <h5 class="header-title" style="text-align: left;">-->
    <!--            //= $partsTitleCurrent --</h5>-->
    <!--    </div>-->
    <!--    <div class="col-md-5">-->
    <!---->
    <!--        <button class="btn btn-primary btn-sm" title="help"-->
    <!--                onclick="dataRule('//= $htmlPrefix ?>//-open')">
    //            <i class="fa fa-question"></i>
    //        </button>
    //
    //
    //        <button class="btn btn-primary btn-sm" title="настройка рассылки"
    //                onclick="dataSetup('//=$htmlPrefix?>//-edit')"
    //                id="<//=$htmlPrefix><!---cogBt"-->
    <!--            >-->
    <!--            <i class="fa fa-cog"></i>-->
    <!--        </button>-->
    <!---->
    <!--        <button class="btn btn-primary btn-sm" title="закрыть для изменеия"-->
    <!--                onclick="orderLockClick('<//=$htmlPrefix?>//')"
    <!--                id="<//=$htmlPrefix?><!---lockBt"-->
    <!--            >-->
    <!--            <i class="fa fa-unlock"></i>-->
    <!--        </button>-->
    <!---->
    <!--        <button class="btn btn-primary btn-sm" title="отправить предложение"-->
    <!--                onclick="orderMailingGo('//=$htmlPrefix?>//')"
    //                id="//=$htmlPrefix?><!---sendBt"-->
    <!--            >-->
    <!--            <i class="fa fa-send-o"></i>-->
    <!--        </button>-->
    <!--        <button class="btn btn-primary btn-sm" title="filter"-->
    <!--                onclick="dataFilter('//=$htmlPrefix//-edit')"
    //            >
    //            <i class="fa fa-filter"></i>
    //        </button>
    //    </div>
    //
    //    <div class="col-md-4">
    //
    //        echo PaginationWidget::widget([
    //            'htmlPrefix' => $htmlPrefix,
    //            'indexPages' => [1],
    //            'currentPage' => 1,
    //        ]) ;
    //        ?>
    <!--    </div>-->
    <!--</div>-->
<?php

echo ToolbarWidget::widget([
    'htmlPrefix' => $htmlPrefix,
    'topology' => [
        'title' => 3,
        'buttons' => 5,
        'pagination' => 4
    ],
    'title' => $partsTitleCurrent,
    'buttons' => [
        'help' => [],
        'filter' => [],
        'lock' => [
            'id' => $htmlPrefix .'-lockBt',
        ],
        'setup' => [
                'id' => $htmlPrefix ."-cogBt",
        ],
        'send' => [
           'clickFunction' => 'orderMailingGo',
            'id' => $htmlPrefix . '-sendBt',
        ],
    ],
    'pagination' => [
        'indexPages' => $indexPagesList,
        'currentPage' => $currentPage,
        'firstClass' => $firstClass,
        'prevClass' => $prevClass,
        'nextClass' => $nextClass,
        'lastClass' => $lastClass,
    ],
]);
