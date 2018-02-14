<?php
/**
 * География работ
 * Time: 10:44
 * @var $tabTitle
 * @var $htmlPrefix
 */

/**
 * 3-х уровневая модель:
 * страна - множество (совокупность стран - совокупность множеств)
 * регион - элемент множества
 * город - компонент(атрибут) элемента множества
 * топология:
 * корень :  ruleTextWidget - подсказка
 *            tooltipsWidget - тексты для атрибута title html - элементов
 * левая панель:
 *           toolbarWidget - панель инструментов
 *           simpleGeographyWidget - выбор множества (страны)
 *           CollapsibleListWidget - список регионов (элементов множества)
 * правая панель:
 *    раздел "Добавить регион" (добавить элеинт множества):
 *              toolbarWidget - панель инструментов
 *              simpleGeographyWidget - выбор нового региона (страна + регион)
 *    раздел "Редактировать регион"
 */
use app\models\WorkCountry;
use app\models\WorkRegion;
use app\models\WorkCity;
use \app\models\Country;
use app\components\GeographySimpleWidget;
use app\components\UserGeography;
use app\components\CollapsibleListWidget;
use app\components\ToolbarWidget;
use app\components\RuleTextWidget;
use app\components\TreeLevelWidget;

//use Yii ;
//use app\service\PageItems ;
?>
<?php
$ug = new UserGeography();
$ownGeography = $ug->getOwnGeography();
//    $userCountry = ['id' => $country->id,'name' => $country->name ] ;
//    $userRegion = ['id' => $region->id,'name' => $region->name ] ;
//    $userCity = ['id' => $city->id,'name' => $city->name ] ;
$htmlPrefix = (isset($htmlPrefix)) ? $htmlPrefix . 'WorkGeography' : 'workGeography';

$userCountry = $ownGeography['userCountry'];
$userRegion = $ownGeography['userRegion'];
$userCity = $ownGeography['userCity'];

$workCountry = new WorkCountry();
$workCountry->userId = Yii::$app->user->identity->getId();
$workCountryList = $workCountry->getList();
// превратить в географию
$wkGCountryList = [];
$wkGCurrentCountry = [];
foreach ($workCountryList as $key => $item) {
    $countryId = $item['country_id'];
    $wkCountryId = $item['id'];
    $name = $item['country']['name'];
    if ($name === 'Россия') {
        $wkGCurrentCountry = ['id' => $countryId, 'name' => $name, 'workCountryId' => $wkCountryId];
    }
    $wkGCountryList[] = ['id' => $countryId, 'name' => $name];
}
$regionList = [];
if (empty($wkGCurrentCountry)) {
    $md = new Country();
    $cur = $md->getByName('Россия');
    $wkGCurrentCountry = ['id' => $cur->id, 'name' => $cur->name];;
} else {
    $workRegion = new WorkRegion();
    $workCity = new WorkCity();
    $workRegion->workCountryId = $wkGCurrentCountry['workCountryId'];
    $wkRegList = $workRegion->getList();
    foreach ($wkRegList as $key => $regItem) {
        $wkRId = $regItem['id'];
        $regionId = $regItem['region_id'];
        $regionName = $regItem['region']['name'];
        $editFlag = true;
        $fullyFlag = ($regItem['fully_flag'] == '1');
        $subItems = [];
        $workCity->workRegionId = $wkRId;
        $wkCityList = $workCity->getList();
        foreach ($wkCityList as $cityKey => $cityItem) {
            $subItems[] = $cityItem['city']['name'];
        }
        $regionList[] = [
            'id' => $regionId,
            'name' => $regionName,
            'fullyFlag' => $fullyFlag,
            'editFlag' => $editFlag,
            'subItems' => $subItems,
        ];
    }

}
$pageItemFile = 'profile/workGeography';
$ruleContentId = 'workGeography-form-collapseOne';
include('workEditLabels.php');     // подписи для  формы
?>
<?php
$tooltipsPar = [
    'tooltips' => [
        'itemFully' => [
            'yes' => $toolTipItemFullyYes,
            'no' => $toolTipItemFullyNo
        ],
        'itemDelete' => [
            'yes' => $toolTipItemDeleteYes,
            'no' => $toolTipItemDeleteNo
        ],
        'subItemInWork' => [
            'yes' => $toolTipSubItemInWorkYes,
            'no' => $toolTipSubItemInWorkNo
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

$geographySetSelectPar = [
    'htmlIdPrefix' => $htmlPrefix, //'workCountrySelect' ,
    'geographyItems' => ['country'],
    'listDirectUp' => false,
    'currentCountry' => $wkGCurrentCountry,
    'currentRegion' => [],
    'currentCity' => [],
    'onClickFunction' => 'switchSet',       //''workRegionChangeCountry',
    'countryList' => $wkGCountryList,
];


$listToolbarPar = [
    'htmlPrefix' => $htmlPrefix,
    'topology' => [
        'title' => 4,
        'buttons' => 2,
        'widget' => 6,
        'pagination' => 0
    ],
    'title' => $partsTitleCurrent,
    'buttons' => [
        'help' => [],
    ],
    'widgetVar' => [
            'name' => 'GeographySimpleWidget',
            'par' => $geographySetSelectPar
    ],
    'pagination' => [],
];

$listRegionPar = [
    'listName' => '',        // например. 'workRegion' - регионы работ
    'pictureClass' => [     // картинки, обозначающие действия (см. defaultPictures)
//                                 'edit' => [],
    ],
    'onClick' => [
        'edit' => 'setItemEdit', //'workRegionEditOnClick',      // реакция на кнопку "редактировать"
    ],
    'htmlPrefix' => $htmlPrefix, //'workRegionItem',     // префикс id для обеспечения уникальнгости
    'btTitle' => $toolTipItemEdit,      // поясняющая подпись для кнопки редактирования
    'listItems' => $regionList,
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
//    'setSelect' => [
//        'name' => 'GeographySimpleWidget',
//        'par' => $geographySetSelectPar
//    ],
//    'html' => [
//        'name' => 'br' ,
//        'par'=> 2,
//    ],
    'listRegion' => [
        'name' => 'CollapsibleListWidget',
        'par' => $listRegionPar
    ],
];

$addRegionToolbarPar = [
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
$addNewRegionPar = [
    'htmlIdPrefix' => $htmlPrefix . 'AddNewWorkRegion',
    'geographyItems' => ['country', 'region'],
    'listDirectUp' => false,
    'currentCountry' => $userCountry,
    'currentRegion' => $userRegion,
    'currentCity' => $userCity,];
$plusButtonPar = [
    'title' => $toolTipItemAdd,
    'onclick' => 'addNewSetItem',//'addWorkGeography',
    'onClickPar' => ''
];

$regionEditToolbarPar = [
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
            'title' => 'только отмеченные',
        ],
    ],
    'pagination' => [],
];

$addPanelHeading = [
    'toolbar' => [
        'name' => 'ToolBarWidget',
        'par' => $addRegionToolbarPar
    ]
];
$addPanelBody = [
    'newSetItem' => [
        'name' => 'GeographySimpleWidget',
        'par' => $addNewRegionPar
    ],
];
$editPanelHeading = [
    'toolbar' => [
        'name' => 'ToolBarWidget',
        'par' => $regionEditToolbarPar
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
]);
?>


