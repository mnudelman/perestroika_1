<?php
/**
 * География работ исполнителя
 * Time: 20:31
 * @var $htmlPrefix
 */
use app\models\WorkCountry ;
use app\models\WorkRegion ;
use app\models\WorkCity ;
use \app\models\Country ;
use app\components\UserGeography ;
use app\components\CollapsibleListWidget ;
use \app\components\ToolbarWidget ;
?>
<?php
$ug = new UserGeography() ;
$ownGeography = $ug->getOwnGeography() ;
$htmlPrefix .= 'Geography';
$userCountry = $ownGeography['userCountry'] ;
$userRegion = $ownGeography['userRegion'] ;
$userCity =  $ownGeography['userCity'] ;

$workCountry = new WorkCountry() ;
$workCountry->userId =  25 ; //Yii::$app->user->identity->getId() ;
$workCountryList = $workCountry->getList() ;
// превратить в географию
$wkGCountryList = [] ;
$wkGCurrentCountry = [] ;
foreach ($workCountryList as $key => $item) {
    $countryId = $item['country_id'] ;
    $wkCountryId = $item['id'] ;
    $name = $item['country']['name'] ;
    if ($name === 'Россия') {
        $wkGCurrentCountry = ['id' => $countryId, 'name' => $name, 'workCountryId' => $wkCountryId] ;
    }
    $wkGCountryList[] =  ['id' => $countryId, 'name' => $name] ;
}
$regionList = [] ;
if (empty($wkGCurrentCountry)) {
    $md = new Country() ;
    $cur = $md->getByName('Россия') ;
    $wkGCurrentCountry = ['id' => $cur->id, 'name' => $cur->name] ; ;
}else {
    $workRegion = new WorkRegion() ;
    $workCity = new WorkCity() ;
    $workRegion->workCountryId = $wkGCurrentCountry['workCountryId'] ;
    $wkRegList = $workRegion->getList() ;
    foreach ($wkRegList as $key => $regItem) {
        $wkRId = $regItem['id'] ;
        $regionId = $regItem['region_id'] ;
        $regionName = $regItem['region']['name'] ;
        $editFlag = true ;
        $fullyFlag = ($regItem['fully_flag'] == '1') ;
        $subItems = [] ;
        $workCity->workRegionId = $wkRId ;
        $wkCityList = $workCity->getList() ;
        foreach ($wkCityList as $cityKey => $cityItem) {
            $subItems[] = $cityItem['city']['name'] ;
        }
        $regionList[] = [
            'id' => $regionId,
            'name' => $regionName,
            'fullyFlag' => $fullyFlag,
            'editFlag' => $editFlag,
            'subItems' => $subItems,
        ] ;
    }

}
$pageItemFile = 'profile/workGeography' ;
$ruleContentId = 'workGeography-form-collapseOne' ;
include('workEditLabels.php') ;     // подписи для  формы
?>
<div class="container-fluid">

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <?php
                    $geographySetSelectPar = [
                        'htmlIdPrefix' => $htmlPrefix ,
                        'geographyItems' => ['country'],
                        'listDirectUp' => false,
                        'currentCountry' => $wkGCurrentCountry,
                        'currentRegion' => [],
                        'currentCity' => [],
                        'onClickFunction' => 'workRegionChangeCountry',
                        'countryList' => $wkGCountryList,
                    ];

                    echo ToolbarWidget::widget([
                        'htmlPrefix' => $htmlPrefix,
                        'topology' => [
                            'title' => 4,
                            'buttons' => 2,
                            'widget' => 6,
                            'pagination' => 0
                        ],
                        'title' => $partsTitleCurrent,
                        'buttons' => [],
                        'widgetVar' => [
                            'name' => 'GeographySimpleWidget',
                            'par' => $geographySetSelectPar
                        ],
                        'pagination' => [],
                    ]);

                    ?>
                </div>
                <div class="panel-body">

                    <?php
                    echo CollapsibleListWidget::widget([
                        'listName'  => '' ,        // например. 'workRegion' - регионы работ
                        'pictureClass' => [     // картинки, обозначающие действия (см. defaultPictures)
//                                 'edit' => [],
                        ] ,
                        'buttons' => [
                            'null' => []
                        ],
                        'onClick' => [],
                        'htmlPrefix' => $htmlPrefix,     // префикс id для обеспечения уникальнгости
                        'btTitle' =>$tooltipItemEdit,      // поясняющая подпись для кнопки редактирования
                        'listItems' => $regionList,
                    ]) ;
                    ?>
                </div>
            </div>
        </div>

    </div>
</div>