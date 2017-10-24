<?php
/**
 *  Панель инструментов для закладки Я-заказчик. Общее (orderGeneral.php)
 * @var $htmlPrefix
 * @var $indexPagesVect - вектор параметров пагинации
 */

?>
<?php
use app\service\PageItems;
use app\components\PaginationWidget;

$pageItemFile = 'order/mailing';
$partsTitle = PageItems::getItemText([$pageItemFile, 'partsTitle']);
$partsTitleCurrent = $partsTitle['current'];
$partsTitleEdit = $partsTitle['edit'];
$partsTitleCurrent = ' тема:"Заказ № 1525. Строительсво 3 этожного...' ;
//$indexPagesVect = $res['indexPages'] ;

//$indexPagesVect = (new Pagination('order'))->getIndexPages() ;
$indexPagesList = $indexPagesVect['indexPages'];
$currentPage = $indexPagesVect['currentPage'];
$firstClass = ($indexPagesVect['firstFlag']) ? '' : 'class="disabled"';
$prevClass = ($indexPagesVect['prevFlag']) ? '' : 'class="disabled"';
$nextClass = ($indexPagesVect['nextFlag']) ? '' : 'class="disabled"';
$lastClass = ($indexPagesVect['lastFlag']) ? '' : 'class="disabled"';
$currentBanFlag = false ;
$disabled = ($currentBanFlag) ? 'disabled="disabled"' : '' ;
$currentBanClass = ($currentBanFlag) ? 'fa fa-envelope-o' : 'fa fa-ban' ;
$currentBanTitle = ($currentBanFlag) ? 'Возобновить переписку' : 'Закрыть переписку' ;
?>
<div class="row">
    <div class="col-md-6">
        <h5 class="header-title" style="text-align: left;">
            <?= $partsTitleCurrent ?></h5>
    </div>
    <div class="col-md-6">


        <div class="btn-toolbar" role="toolbar" aria-label="lab1">


            <button class="btn btn-primary btn-sm" title="help"
                    onclick="dataRule('<?= $htmlPrefix ?>-open')">
                <i class="fa fa-question"></i>
            </button>

            <button class="btn btn-primary btn-sm" title="ваш корреспондент"
                    onclick="dataRule('<?= $htmlPrefix ?>-open')">
                <i class="fa fa-user-secret"></i>
            </button>


            <button class="btn btn-primary btn-sm" title="новое сообщение"
                    <?=$disabled?>
                    onclick="orderEditClick('<?= $htmlPrefix ?>-create')">
                <i class="fa fa-file-o "></i>
            </button>
            <button class="btn btn-primary btn-sm" title="отправить предложение"
                <?=$disabled?>
                    onclick="orderMailingGo('<?=$htmlPrefix?>')"
                    id="<?=$htmlPrefix?>-sendBt"
                >
                <i class="fa fa-send-o"></i>
            </button>

            <button class="btn btn-primary btn-sm" title="Убрать не отправленное"
                    <?=$disabled?>
                    onclick="orderEditClick('<?= $htmlPrefix ?>-delete')">
                <i class="fa fa-minus-square "></i>
            </button>
            <button class="btn btn-primary btn-sm" title="<?=$currentBanTitle?>"
                    onclick="orderMailingGo('<?=$htmlPrefix?>')"
                    id="<?=$htmlPrefix?>-sendBt"
                >
                <i class="<?=$currentBanClass?>"></i>
            </button>

        </div>










    </div>

<!--    <div class="col-md-4">-->
<!--       ?php -->
<!--//        echo PaginationWidget::widget([-->
<!--//            'htmlPrefix' => $htmlPrefix,-->
<!--//            'indexPages' => [1],-->
<!--//            'currentPage' => 1,-->
<!--//        ]) ;-->
<!--//        ?>-->
<!--    </div>-->
</div>
