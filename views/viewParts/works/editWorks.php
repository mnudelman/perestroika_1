<?php
/**
 * состав работ
 * @var $htmlPrefix
 * @var $objectType = {'user' | 'order'}
 */
//use yii\bootstrap\ButtonDropdown;
//use yii\bootstrap\Dropdown;
//use app\components\CollapsibleListWidget;
//use app\components\RuleTextWidget ;
//use app\components\ToolbarWidget ;
//use yii\helpers\Html;
//use yii\helpers\Url;
use app\components\TreeLevelWidget ;
?>
<?php
include_once __DIR__ . '/editWorksFunction.php';
// это правая часть - изменения
//$htmlPrefix = 'workDirectionEdit';
$type = 'workDirection';
$liList = workDirectionList($htmlPrefix,$type) ;

$picture = $liList[0]['options']['data-img'];
// левая часть - что имееем      ****
$listItems = [] ;
switch ($objectType) {
    case 'user' :                   // profile
        $listItems = developerWorkDirectionList() ;
        break ;
    case 'order' :
        $listItems = orderWorkDirectionList_1() ;
}

$styleDropdown = 'overflow-y:auto;max-height:400px;white-space: normal;';
//$dirLayoutParts = __DIR__ . '../../layouts/layoutParts' ;
//----------- подписи ---//
$pageItemFile = 'profile/workDirection' ;
$ruleContentId = 'workDirection-form-collapseOne' ;
include('workEditLabels.php');     // подписи для  формы
?>

<?php
$tooltipsPar = [
    'htmlPrefix' => $htmlPrefix,
    'tooltips' => [
        'itemFully' => [
            'yes' => $tooltipItemFullyYes,
            'no' => $tooltipItemFullyNo
        ],
        'itemDelete' => [
            'yes' => $tooltipItemDeleteYes,
            'no' => $tooltipItemDeleteNo
        ],
        'subItemInWork' => [
            'yes' => $tooltipSubItemInWorkYes,
            'no' => $tooltipSubItemInWorkNo
        ],
        'coveredEye' => [
            'yes' => $tooltipCoveredEyeYes,
            'no' => $tooltipCoveredEyeNo,
        ],
        'itemEdit' => [
            'yes' => $tooltipItemEdit,
        ],
    ]
];
$ruleTextWidgetPar = [
    'htmlPrefix' => $htmlPrefix,
    'ruleTitle' => '',
    'ruleItems' => [
        ['ruleTitle' => $ruleTitle,
            'ruleContent' => $ruleContent]
    ]
];



$listToolbarPar = [
    'htmlPrefix' => $htmlPrefix,
    'topology' => [
        'title' => 4,
        'buttons' => 2,
        'widget' => 0,
        'pagination' => 0
    ],
    'title' => $partsTitleCurrent,
    'buttons' => [
        'help' => [],
    ],
    'pagination' => [],
];

$listItemsPar = [
    'listName' => '',        // например. 'workRegion' - регионы работ
    'pictureClass' => [     // картинки, обозначающие действия (см. defaultPictures)
//                                 'edit' => [],
    ],
    'onClick' => [
        'edit' => 'setItemEdit', //'workRegionEditOnClick',      // реакция на кнопку "редактировать"
    ],
    'htmlPrefix' => $htmlPrefix, //'workRegionItem',     // префикс id для обеспечения уникальнгости
    'btTitle' => $tooltipItemEdit,      // поясняющая подпись для кнопки редактирования
    'btTooltipName' => 'itemEdit',
    'listItems' => $listItems,
];

$rootPanel = [
    'tooltips' => [
        'name' => 'TooltipsWidget',
        'par' => $tooltipsPar
    ],

    'rule' => [
        'name' => 'RuleTextWidget',
        'par' => $ruleTextWidgetPar
    ],
];
$listPanelHeading = [
    'toolBar' => [
        'name' => 'ToolBarWidget',
        'par' => $listToolbarPar
    ],
];
$listPanelBody = [
    'listRegion' => [
        'name' => 'CollapsibleListWidget',
        'par' => $listItemsPar
    ],
];

$addNewToolbarPar = [
    'htmlPrefix' => $htmlPrefix,
    'topology' => [
        'title' => 12,
        'buttons' => 0,
        'pagination' => 0
    ],
    'title' => $partsTitleAdd,
    'buttons' => [],
    'pagination' => [],
];

$plusButtonPar = [
    'type' => 'button',
    'title' => $tooltipItemAdd,
    'onclick' => 'addNewSetItem',//'addWorkGeography',
    'onClickPar' => ''
];

$editToolbarPar = [
    'htmlPrefix' => $htmlPrefix,
    'topology' => [
        'title' => 6,
        'buttons' => 6,
        'pagination' => 0
    ],
    'title' => $partsTitleEdit,
    'buttons' => [
        'save' => [
            'clickFunction' => 'setItemSave',    //'saveWorkGeography',
        ],
        'coveredEye' => [
            'title' => $tooltipCoveredEyeYes ,
            'clickFunction' => 'setSubItemsShowStat',
            'tooltipName' => 'coveredEye',
        ],
    ],
    'pagination' => [],
];

$addPanelHeading = [
    'toolbar' => [
        'name' => 'ToolBarWidget',
        'par' => $addNewToolbarPar
    ]
];



$btName = $liList[0]['options']['name'];
$id = $htmlPrefix . '-newSetItem-bt';
//echo ButtonDropdown::widget([
    $addNewRegionPar = [
    'label' => $liList[0]['label'],
    'id' => $htmlPrefix . 'NewSetItem-workDirection-bt',     // geography-country-bt
    'options' => [
        'name' => $btName,
        'class' => 'btn-primary',
        'style' => 'white-space: normal;'
    ],
    'dropdown' => [
        'options' => [
            'class' => 'list-group',
            'style' => 'white-space:normal;',
            'id' => $htmlPrefix . 'NewSetItem-workDirection-ul',     // geography-country-ul
            'name' => $btName,
        ],
        'items' => $liList]
];





$addPanelBody = [
    'newSetItem' => [
        'name' => 'ButtonDropdown',
        'par' => $addNewRegionPar
    ],
    'plusButton' => $plusButtonPar,     // кнопка "ДОБАВИТЬ НОВЫЙ"
    'newSetItemImg' => [
        'picture' => $picture,
    ],
];
$editPanelHeading = [
    'toolbar' => [
        'name' => 'ToolBarWidget',
        'par' => $editToolbarPar
    ],
];
$editPanelBody = [
    'fullyButton' => [
        'type' => 'button',
        'title' => $tooltipItemFullyNo,
        'tooltipName' => 'itemFully',
    ],
    'deleteButton' => [
        'type' => 'button',
        'title' => $tooltipItemDeleteNo,
        'tooltipName' => 'itemDelete', // параметр для data-tooltip-name=".."
    ],

];



echo TreeLevelWidget::widget([
    'htmlPrefix' => $htmlPrefix,
    'rootPanel' => $rootPanel,
    'listPanelHeading' => $listPanelHeading,
    'listPanelBody' => $listPanelBody,
    'addPanelHeading' => $addPanelHeading,
    'addPanelBody' => $addPanelBody,
    'editPanelHeading' => $editPanelHeading,
    'editPanelBody' => $editPanelBody,
]);
