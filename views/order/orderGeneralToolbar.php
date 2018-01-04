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

echo ToolbarWidget::widget([
        'htmlPrefix' => $htmlPrefix,
        'topology' => [
                'title' => 4,
                'buttons' => 3,
                'pagination' => 5
        ],
        'title' => $partsTitleCurrent,
        'buttons' => [
                'help'=> [],
                'filter' => []
        ],
        'pagination' => [
            'indexPages' => $indexPagesList,
            'currentPage' => $currentPage,
            'firstClass' => $firstClass,
            'prevClass' => $prevClass,
            'nextClass' => $nextClass,
            'lastClass' => $lastClass,
        ],
]) ;
?>
