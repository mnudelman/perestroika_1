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
