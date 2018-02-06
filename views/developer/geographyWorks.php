<?php
/**
 * География работ
 * Time: 10:44
 * @var $tabTitle
 * @var $htmlPrefix
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
        'title' => 6,
        'buttons' => 6,
        'pagination' => 0
    ],
    'title' => $partsTitleCurrent,
    'buttons' => [
        'help' => [],
    ],
    'pagination' => [],
];
$geographySetSelectPar = [
    'htmlIdPrefix' => $htmlPrefix, //'workCountrySelect' ,
    'geographyItems' => ['country'],
    'listDirectUp' => false,
    'currentCountry' => $wkGCurrentCountry,
    'currentRegion' => [],
    'currentCity' => [],
    'onClickFunction' => 'workRegionChangeCountry',
    'countryList' => $wkGCountryList,
];
$listRegionPar = [
    'listName' => '',        // например. 'workRegion' - регионы работ
    'pictureClass' => [     // картинки, обозначающие действия (см. defaultPictures)
//                                 'edit' => [],
    ],
    'onClick' => [
        'edit' => 'workRegionEditOnClick',      // реакция на кнопку "редактировать"
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
    'setSelect' => [
        'name' => 'GEographySimpleWidget',
        'par' => $geographySetSelectPar
    ],
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
    'htmlIdPrefix' => $htmlPrefix . '-addNewWorkRegion',
    'geographyItems' => ['country', 'region'],
    'listDirectUp' => false,
    'currentCountry' => $userCountry,
    'currentRegion' => $userRegion,
    'currentCity' => $userCity,];
$plusButtonPar = [
    'title' => $toolTipItemAdd,
    'onclick' => 'addWorkGeography',
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
            'clickFunction' => 'saveWorkGeography',
        ],
        'coveredEye' => [
            'title' => 'только отмеченные',
        ],
    ],
    'pagination' => [],
];

$addPanelHeading = [
    'toolbar' => [
        'name' => 'ToolbarWidget',
        'par' => $addRegionToolbarPar
    ]
];
$addPanelBody = [
    'newSetItem' => [
        'name' => 'GeographySimpleWidget',
        'par' => $addNewRegionPar
    ],
];
$ediPanelHeading = [
    'toolbar' => [
        'name' => 'ToolbarWidget',
        'par' => $regionEditToolbarPar
    ],
];
echo TreeLevelWidget::widget([
    'rootPanel' => $rootPanel,
    'listPanelHeading' => $listPanelHeading,
    'listPanlBody' => $listPanelBody,
    'addPanelHeading' => $addPanelHeading,
    'addPanelBody' => $addPanelBody,
    'editPanelHeading' => $ediPanelHeading,
]);
?>

?>


<div class="container-fluid">
    <div id="<?= $htmlPrefix . '-tooltips' ?>">
        <input type="text" hidden="hidden" name="itemFully"
               data-yes="<?= $toolTipItemFullyYes ?>" data-no="<?= $toolTipItemFullyNo ?>">
        <input type="text" hidden="hidden" name="itemDelete"
               data-yes="<?= $toolTipItemDeleteYes ?>" data-no="<?= $toolTipItemDeleteNo ?>">
        <input type="text" hidden="hidden" name="subItemInWork"
               data-yes="<?= $toolTipSubItemInWorkYes ?>" data-no="<?= $toolTipSubItemInWorkNo ?>">

    </div>
    <!--     подсказка  -->
    <?= RuleTextWidget::widget([
        'htmlPrefix' => $htmlPrefix,
        'ruleTitle' => '',
        'ruleItems' => [
            ['ruleTitle' => $ruleTitle,
                'ruleContent' => $ruleContent]
        ],
    ]);
    ?>

    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <?= ToolbarWidget::widget([
                        'htmlPrefix' => $htmlPrefix,
                        'topology' => [
                            'title' => 6,
                            'buttons' => 6,
                            'pagination' => 0
                        ],
                        'title' => $partsTitleCurrent,
                        'buttons' => [
                            'help' => [],
                        ],
                        'pagination' => [],
                    ]);
                    ?>


                </div>
                <div class="panel-body">
                    <?php
                    // текущая страна
                    echo GeographySimpleWidget::widget([
                        'htmlIdPrefix' => $htmlPrefix, //'workCountrySelect' ,
                        'geographyItems' => ['country'],
                        'listDirectUp' => false,
                        'currentCountry' => $wkGCurrentCountry,
                        'currentRegion' => [],
                        'currentCity' => [],
                        'onClickFunction' => 'workRegionChangeCountry',
                        'countryList' => $wkGCountryList,

                    ]);
                    ?>
                    <br><br>

                    <?php
                    echo CollapsibleListWidget::widget([
                        'listName' => '',        // например. 'workRegion' - регионы работ
                        'pictureClass' => [     // картинки, обозначающие действия (см. defaultPictures)
//                                 'edit' => [],
                        ],
                        'onClick' => [
                            'edit' => 'workRegionEditOnClick',      // реакция на кнопку "редактировать"
                        ],
                        'htmlPrefix' => $htmlPrefix, //'workRegionItem',     // префикс id для обеспечения уникальнгости
                        'btTitle' => $toolTipItemEdit,      // поясняющая подпись для кнопки редактирования
                        'listItems' => $regionList,
                    ]);
                    ?>
                </div>
            </div>
        </div>
        <div class="col-md-6">

            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h5 class="header-title" style="text-align: left;"><?= $partsTitleAdd ?></h5></div>
                <div class="panel-body">


                    <div class="row">

                        <?php
                        echo GeographySimpleWidget::widget([
                            'htmlIdPrefix' => $htmlPrefix . '-addNewWorkRegion',
                            'geographyItems' => ['country', 'region'],
                            'listDirectUp' => false,
                            'currentCountry' => $userCountry,
                            'currentRegion' => $userRegion,
                            'currentCity' => $userCity,]);
                        ?>

                        <button class="btn btn-success" role="button"
                                onclick="addWorkGeography()"
                                title="<?= $toolTipItemAdd ?>">
                            <span class="glyphicon glyphicon-plus"></span>
                        </button>


                    </div>

                </div>
            </div>
            <div class="panel panel-primary" id="<?= $htmlPrefix ?>-edit-panel">
                <div class="panel-heading">
                    <!--                    <h5 class="header-title" style="text-align: left;">?//=$partsTitleEdit?><!--</h5>-->

                    <?= ToolbarWidget::widget([
                        'htmlPrefix' => $htmlPrefix,
                        'topology' => [
                            'title' => 6,
                            'buttons' => 6,
                            'pagination' => 0
                        ],
                        'title' => $partsTitleEdit,
                        'buttons' => [
                            'save' => [
                                'clickFunction' => 'saveWorkGeography',
                            ],
                            'coveredEye' => [
                                'title' => 'только отмеченные',
                            ],
                        ],
                        'pagination' => [],
                    ]);
                    ?>


                </div>
                <div class="panel-body">
                    <!--                 <span id="workRegionEdit-placeHolder">Область изменений географии работ</span>-->
                    <div hidden="hidden" id="<?= $htmlPrefix ?>-edit-area">
                        <!--                    <ul class="list-group" >-->
                        <a class="btn btn-default" role="button" data-toggle="collapse" style="width:82%"
                           aria-expanded="true" href="#<?= $htmlPrefix ?>-edit-collapse"
                           aria-controls="<?= $htmlPrefix ?>-edit-collapse" id="workRegionEdit-name">
                            <span> Свердловская обл.</span><b class="caret"></b>
                        </a>
                        <a class="btn btn-default" role="button" title="region fully in work geography"
                           id="workRegionEdit-fully" onclick="workRegionStat('fully')">
                            <span class="glyphicon glyphicon-share"></span>
                        </a>
                        <a class="btn btn-default" role="button" title="region removed from work gegraphy"
                           id="workRegionEdit-delete" onclick="workRegionStat('delete')">
                            <span class="glyphicon glyphicon-minus"></span>
                        </a>

                        <ul class="list-group collapse.in" id="<?= $htmlPrefix ?>-edit-collapse"
                            style="overflow:auto; max-height:200px">
                            <li class="list-group-item" name="city-[city_id]">Нижний тагил
                                <a class="btn btn-default btn-sm" role="button" title="city is in work"
                                   onclick="workRegionCityStat(city_id)">
                                    <span class="glyphicon glyphicon-ok"></span>
                                </a>

                            </li>
                            <li class="list-group-item">
                                Екатеринбург
                                <a class="btn btn-default btn-sm" role="button" title="city not in work">
                                    <span class="glyphicon glyphicon-remove"></span>
                                </a>
                            </li>
                        </ul>
                        <!--                </ul>-->
                        <!--                <button class="btn btn-primary" onclick="saveWorkGeography()"-->
                        <!--                        id="workRegionEdit-save">-->
                        <!--                    ?//=$btSave?>
                        <!--                </button>-->
                        <!--                    <button class="btn btn-danger" onclick="restoreWorkGeography()">restore</button>-->
                    </div>
                </div>
                <!--                </div>-->
            </div>
        </div>
    </div>
</div>