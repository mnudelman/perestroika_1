<?php
/**
 *  Панель инструментов для закладки Я-исполнитель. Список заказов (orders.php)
 * @var $htmlPrefix
 * @var $indexPagesVect - вектор параметров пагинации
 */
?>
<?php
use app\service\PageItems;
use app\components\PaginationWidget;

$pageItemFile = 'order/general';
$partsTitle = PageItems::getItemText([$pageItemFile, 'partsTitle']);
$partsTitleCurrent = $partsTitle['current'];
$partsTitleEdit = $partsTitle['edit'];

//$indexPagesVect = $res['indexPages'] ;

//$indexPagesVect = (new Pagination('order'))->getIndexPages() ;
$indexPagesList = $indexPagesVect['indexPages'];
$currentPage = $indexPagesVect['currentPage'];
$firstClass = ($indexPagesVect['firstFlag']) ? '' : 'class="disabled"';
$prevClass = ($indexPagesVect['prevFlag']) ? '' : 'class="disabled"';
$nextClass = ($indexPagesVect['nextFlag']) ? '' : 'class="disabled"';
$lastClass = ($indexPagesVect['lastFlag']) ? '' : 'class="disabled"';


?>
<div class="row">
    <div class="col-md-3">
        <h5 class="header-title" style="text-align: left;">
            <?= $partsTitleCurrent ?></h5>
    </div>
    <div class="col-md-4">
        <button class="btn btn-primary btn-sm" title="help"
                onclick="dataRule('<?= $htmlPrefix ?>-open')">
            <i class="fa fa-question"></i>
        </button>

        <button class="btn btn-primary btn-sm" title="отправить подтверждение"
                onclick="orderMailingGo('<?=$htmlPrefix?>')"
            >
            <i class="fa fa-send-o"></i>
        </button>

        <button class="btn btn-primary btn-sm" title="filter"
                onclick="dataFilter('<?= $htmlPrefix ?>-edit')">
            <i class="fa fa-filter"></i>
        </button>
    </div>
    <div class="col-md-5">

        <?php
        echo PaginationWidget::widget([
            'htmlPrefix' => $htmlPrefix,
            'indexPages' => $indexPagesList,
            'currentPage' => $currentPage,
            'firstClass' => $firstClass,
            'prevClass' => $prevClass,
            'nextClass' => $nextClass,
            'lastClass' => $lastClass,
        ]) ;
        ?>
    </div>
</div>
