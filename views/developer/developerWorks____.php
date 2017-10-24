<?php
/**
 * География работ
 * Time: 10:44
 */
use yii\bootstrap\ButtonDropdown;
use yii\bootstrap\Dropdown;
use app\models\WorkCountry;
use app\models\WorkRegion;
use app\models\WorkCity;
use \app\models\Country;
use app\components\GeographySimpleWidget;
use app\components\UserGeography;
use app\components\CollapsibleListWidget;

?>
<?php
?>
<div class="container-fluid">
    <h2> в работе</h2>
<!--    <div class="row">-->
<!--        <div class="col-md-6">-->
<!--            <div class="panel panel-primary">-->
<!--                <div class="panel-heading">-->
<!--                    <h5 class="header-title" style="text-align: left;">-->
<!--                        Включёные направления работ</h5></div>-->
<!--                <div class="panel-body">-->
<!---->
<!--                    <br><br>-->
<!---->
<!--                    --><?php
//                    //                                 [         // список компонентов
//                    //                                [
//                    //                                    'id' => '1123',
//                    //                                    'name' => 'Оренбургская обл.',
//                    //                                    'editFlag' => true,          // можно редактировать
//                    //                                    'fullyFlag' => false,        // флаг - все возможные sumItems включены
//                    //                                    'subItems'  => [             // выпадающий список
//                    //                                        'Оренбург',
//                    //                                        'Орск'
//                    //                                    ]
//                    //
//                    //                                ],
//                    //                             ],
//
//
//                    echo CollapsibleListWidget::widget([
//                        'listName' => '',        // например. 'workRegion' - регионы работ
//                        'pictureClass' => [     // картинки, обозначающие действия (см. defaultPictures)
////                                 'edit' => [],
//                        ],
//                        'onClick' => [
//                            'edit' => 'workDirectionEditOnClick',      // реакция на кнопку "редактировать"
//                        ],
//                        'htmlPrefix' => 'workRegionItem',     // префикс id для обеспечения уникальнгости
//                        'btTitle' => 'click for edit',      // поясняющая подпись для кнопки редактирования
//                        'listItems' =>
//                            [         // список компонентов
//                                [
//                                    'id' => '1123',
//                                    'name' => 'Алмазная резка и бурение .',
//                                    'editFlag' => true,          // можно редактировать
//                                    'fullyFlag' => false,        // флаг - все возможные sumItems включены
//                                    'subItems' => [             // выпадающий список
//                                        'Алмазная резка бетона, железобетона',
//                                        'Алмазная резка проёмов в стенах, перекрытиях',
//                                        'Штробление бетонных полов, стен'
//                                    ]
//
//                                ],
//                            ],
//
//                    ]);
//                    ?>
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--        <div class="col-md-6">-->
<!---->
<!--            <div class="panel panel-primary">-->
<!--                <div class="panel-heading">-->
<!--                    <h5 class="header-title" style="text-align: left;">Добавить выполняемые работы</h5></div>-->
<!--                <div class="panel-body">-->
<!---->
<!---->
<!--                    <div class="row">-->
<!---->
<!--                        --><?php
//                        echo GeographySimpleWidget::widget([
//                            'htmlIdPrefix' => 'addNewWorkDirection',
//                            'geographyItems' => ['country'],
//                            'listDirectUp' => false,
//                            'currentCountry' => ['id'=>'1','name'=>'алмазное бурение'],
//                            'currentRegion' => [],
//                            'currentCity' => [],
//                            'countryList' => [
//                                ['id' => '1',
//                                    'name'=> 'алмазное бурение'],
//                                ['id' => '2',
//                                    'name'=> 'Демонтажные работы'],
//                                ['id' => '3',
//                                    'name'=> 'Строительные работы'],
//                                ['id' => '4',
//                                    'name'=> 'Перепланировка помещений'],
//                            ]
//                        ]);
//                        ?>
<!---->
<!--                        <button class="btn btn-success" role="button"-->
<!--                                onclick="addWorkDirection()"-->
<!--                                title="add new work  direction">-->
<!--                            <span class="glyphicon glyphicon-plus"></span>-->
<!--                        </button>-->
<!---->
<!---->
<!--                    </div>-->
<!---->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="panel panel-primary" id="workRegionEdit-panel">-->
<!--                <div class="panel-heading">-->
<!--                    <h5 class="header-title" style="text-align: left;">Изменения</h5></div>-->
<!--                <div class="panel-body">-->
<!--                    <!--                 <span id="workRegionEdit-placeHolder">Область изменений географии работ</span>-->-->
<!--                    <div  id="workDirection-area">-->
<!--                        <!--                    <ul class="list-group" >-->-->
<!--                        <a class="btn btn-default" role="button" data-toggle="collapse" style="width:82%"-->
<!--                           aria-expanded="true" href="#workDirectionEdit-collapse"-->
<!--                           aria-controls="workDirectionEdit-collapse" id="workRegionEdit-name">-->
<!--                            <span> Алмазное бурениеи сверление.</span><b class="caret"></b>-->
<!--                        </a>-->
<!--                        <a class="btn btn-default" role="button" title="region fully in work geography"-->
<!--                           id="workRegionEdit-fully" onclick="workDirectionStat('fully')">-->
<!--                            <span class="glyphicon glyphicon-share"></span>-->
<!--                        </a>-->
<!--                        <a class="btn btn-default" role="button" title="region removed from work gegraphy"-->
<!--                           id="workRegionEdit-delete" onclick="workDirectionStat('delete')">-->
<!--                            <span class="glyphicon glyphicon-minus"></span>-->
<!--                        </a>-->
<!---->
<!--                        <ul class="list-group collapse.in" id="workRegionEdit-collapse"-->
<!--                            style="overflow:auto; max-height:200px">-->
<!--                            <li class="list-group-item" name="workItem-[item_id]">-->
<!--                                'Алмазная резка бетона, железобетона',-->
<!--                                <a class="btn btn-success btn-sm" role="button" title="city is in work"-->
<!--                                   onclick="workDirectionItemStat(item_id)">-->
<!--                                    <span class="glyphicon glyphicon-ok"></span>-->
<!--                                </a>-->
<!---->
<!--                            </li>-->
<!--                            <li class="list-group-item">-->
<!--                                'Алмазная резка проёмов в стенах, перекрытиях',-->
<!--                                <a class="btn btn-default btn-sm" role="button" title="city not in work">-->
<!--                                    <span class="glyphicon glyphicon-remove"></span>-->
<!--                                </a>-->
<!--                            </li>-->
<!--                        </ul>-->
<!--                        <!--                </ul>-->-->
<!--                        <button class="btn btn-primary" onclick="saveWorkDirection()">save</button>-->
<!--                        <!--                    <button class="btn btn-danger" onclick="restoreWorkGeography()">restore</button>-->-->
<!--                    </div>-->
<!--                </div>-->
<!--                <!--                </div>-->-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
</div>