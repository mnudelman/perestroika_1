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
<?php
echo ToolbarWidget::widget([
    'htmlPrefix' => $htmlPrefix,
    'topology' => [
        'title' => 6,
        'buttons' => 6,
        'pagination' => 0
    ],
    'title' => $partsTitleCurrent,
    'buttons' => [
        'help' => [],
        'yourCorrespondent' => [],
        'newFile' => [],
        'send' => [
            'clickFunction' => 'orderMailingGo',
            'id' => $htmlPrefix . '-sendBt',
        ],
        'delete' => [
          'title' => 'убрать не отправленное'
        ],
        'ban' => [
                'title' => $currentBanTitle,
            'iconClass' => $currentBanClass
        ]
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
