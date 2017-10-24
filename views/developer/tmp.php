<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 18.01.17
 * Time: 14:32
 */
?>
<div class="panel panel-primary" id="workRegionEdit-panel">
    <div class="panel-heading">
        <h5 class="header-title" style="text-align: left;">Изменения</h5></div>
    <div class="panel-body">
        <span id="workRegionEdit-placeHolder">Область изменений географии работ</span>
        <div  hidden="hidden" id="workRegionEdit-area">
            <!--                    <ul class="list-group" >-->
            <a class="btn btn-default" role="button" data-toggle="collapse" style="width:82%"
               aria-expanded="true" href="#workRegionEdit-collapse"
               aria-controls="workRegionEdit-collapse">
                <span id="workRegionEdit-name"> Свердловская обл.</span><b class="caret"></b>
            </a>
            <a class="btn btn-default" role="button" title="region fully in work geography">
                        <span class="glyphicon glyphicon-share" id="workRegionEdit-fully"
                              onclick="workRegionStat('fully')"></span>
            </a>
            <a class="btn btn-default" role="button" title="region removed from work gegraphy">
                        <span class="glyphicon glyphicon-minus" id="workRegionEdit-delete"
                              onclick="workRegionStat('delete')"></span>
            </a>

            <ul class="list-group collapse.in" id="workRegionEdit-collapse">
                <li class="list-group-item" name="city-[city_id]" >Нижний тагил
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
            <button class="btn btn-primary">save</button>
            <button class="btn btn-danger">restore</button>
        </div>
    </div>
    <!--                </div>-->
</div>
</div>
