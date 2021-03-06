function listCollapseOnClick(elName) {
    var a = 1;
}
/**
 * География работ
 */
/**
 * Добавить новый регион в географию работ
 * реакция на кнопку "добавить Регион"
 */
function addWorkGeography(addWorkReady) {
    //alert('i\'amm addWorkRegion!!') ;
    var countryUlName = $('#addNewWorkRegion-country-ul').attr('name');
    var regionUlName = $('#addNewWorkRegion-region-ul').attr('name');
    var regionBt = $('#addNewWorkRegion-region-bt');
    var arr = countryUlName.split('-');
    var countryId = arr[1];
    arr = regionUlName.split('-');
    var regionId = arr[1];
    var data = {
        "opCod": "addRegion",
        "countryId": countryId,
        "regionId": regionId
    };
    $.ajax({
        url: 'index.php?r=work-geography%2Fadd-work-region',
        data: data,
        type: 'POST',
        success: function (res) {
            var rr = JSON.parse(res);
            var success = rr['success'];
            var message = rr['message'];
            if (rr['success'] === true) {
                workRegionEdit(rr);
                if (typeof(addWorkReady) == "object") {
                    addWorkReady.setReady(true);
                }
            } else {
                var a = 1;
            }
        },
        error: function (event, XMLHttpRequest, ajaxOptions, thrownError) {
            var responseText = event.responseText; // html - page
            showError(responseText);
        }
    });

}
/**
 * Редактировать регион
 * @param rr  - результат запроса
 *    rr = [
 'success' => $success,
 'workCountryId' => $workCountry->id ,
 'workRegionId' => $workRegion->id,
 'workCityList' => $workCityList,
 'cityList' => $cityList,
 'z-end' => 'end'
 ] ;
 *
 */
function workRegionEdit(rr) {
    workRegionEditRegionNode(rr['workRegion']);    //  узел - имя региона
    var cityList = prepareCityListForEdit(rr['workCityList'], rr['cityList']);
    var ul = $('#workRegionEdit-collapse');
    ul.empty();
    for (var key in cityList) {
        var cityItem = cityList[key];
        var li = newListItemForRegionEdit(cityItem);
        ul.append(li);
    }
    // имя региона с характеристикой data-fully data_delete
    $('#workRegionEdit-area').removeAttr('hidden');
}
/**
 * <a class="btn btn-default" role="button" data-toggle="collapse" style="width:82%"
 aria-expanded="true" href="#workRegionEdit-collapse"
 aria-controls="workRegionEdit-collapse" id="workRegionEdit-name">
 <span> Свердловская обл.</span><b class="caret"></b>
 </a>
 <a class="btn btn-default" role="button" title="region fully in work geography">
 <span class="glyphicon glyphicon-share" id="workRegionEdit-fully"
 onclick="workRegionStat('fully')"></span>
 </a>
 <a class="btn btn-default" role="button" title="region removed from work gegraphy">
 <span class="glyphicon glyphicon-minus" id="workRegionEdit-delete"
 onclick="workRegionStat('delete')"></span>
 </a>

 */
function workRegionEditRegionNode($workRegion) {
    var aa = $('#workRegionEdit-name');
    var regionId = $workRegion['region_id'];
    var regionName = $workRegion['region']['name'];
    var span = aa.children('span');
    span.empty();
    span.append(regionName);
    var fullyFlag = $workRegion['fully_flag'];
    fullyFlag = (fullyFlag == '0') ? false : true;
    var nodeName = 'region-' + regionId;
    aa.attr('name', nodeName);
    var deleteFlag = false;
    aa[0].dataset.fullyFlag = fullyFlag;
    aa[0].dataset.deleteFlag = deleteFlag;
    // кнопка - регион полностью
    var bt = $('#workRegionEdit-fully');
    workRegionEditBtShow(bt, 'fully', fullyFlag);
    bt = $('#workRegionEdit-delete');
    workRegionEditBtShow(bt, 'delete', deleteFlag);
}
function workRegionStat(type) {
    var aa = $('#workRegionEdit-name');
    var fullyFlag = aa[0].dataset.fullyFlag;
    var deleteFlag = aa[0].dataset.deleteFlag;
    fullyFlag = (fullyFlag === 'true') ? true : false;
    deleteFlag = (deleteFlag === 'true') ? true : false;
    if (type == 'fully') {
        fullyFlag = !fullyFlag;
        aa[0].dataset.fullyFlag = fullyFlag;
        var bt = $('#workRegionEdit-fully');
        workRegionEditBtShow(bt, 'fully', fullyFlag);
    } else {
        deleteFlag = !deleteFlag;
        aa[0].dataset.deleteFlag = deleteFlag;
        var bt = $('#workRegionEdit-delete');
        workRegionEditBtShow(bt, 'delete', deleteFlag);

    }
}
function workRegionEditBtShow(bt, type, flag) {
    var htmlPrefix = 'workGeographyEdit';
    var tooltipFully = $('#' + htmlPrefix + '-tooltips [name="itemFully"]') ;
    var fullyYes = tooltipFully.data('yes') ;
    var fullyNo = tooltipFully.data('no') ;

    var tooltipDelete = $('#' + htmlPrefix + '-tooltips [name="itemDelete"]') ;
    var deleteYes = tooltipDelete.data('yes') ;
    var deleteNo = tooltipDelete.data('no') ;


    var alternate = (flag) ? 'yes' : 'no';
    var fullyBt = {
        yes: {
            class: 'glyphicon glyphicon-briefcase',
            title: fullyYes
        },
        no: {
            class: 'glyphicon glyphicon-share',
            title: fullyNo

        }
    };
    var deleteBt = {
        yes: {
            class: 'glyphicon glyphicon-minus',
            title: deleteYes
        },
        no: {
            class: 'glyphicon glyphicon-plus',
            title: deleteNo
        }
    };
    var currentBt = (type === 'fully') ? fullyBt[alternate] : deleteBt[alternate];
    bt.attr('title', currentBt['title']);
    var span = bt.children('span');
    span.attr('class', currentBt['class']);

}
/**
 <span class="glyphicon glyphicon-remove"></span>

 <li class="list-group-item" name="city-[city_id]" >Нижний тагил
 <a class="btn btn-default btn-sm" role="button" title="city is in work"
 onclick="workRegionCityStat(city_id)">
 <span class="glyphicon glyphicon-ok"></span>
 </a></li>
 */
function newListItemForRegionEdit(cityItem) {

    var htmlPrefix = 'workGeographyEdit';
    var tooltipInWork = $('#' + htmlPrefix + '-tooltips [name="subItemInWork"]') ;
    var titleInWork = tooltipInWork.data('yes') ;
    var titleRemove = tooltipInWork.data('no') ;


    var cityId = cityItem['city_id'];
    var cityName = cityItem['name'];
    var inWorkCurrent = cityItem['inWorkCurrent'];
    var inWorkNow = cityItem['inWorkNow'];
    var aa = $('<a class="btn btn-default btn-xs" role="button" title="city is in work" ' +
    'onclick="workRegionCityStat(city_id)">');
    var spanInWork = '<span class="glyphicon glyphicon-ok"></span>';
    var spanRemove = '<span class="glyphicon glyphicon-remove"></span>';
    var span = (inWorkCurrent) ? spanInWork : spanRemove;
    if(inWorkCurrent) {
        aa.attr('class','btn btn-success btn-xs') ;
    }
    aa.append(span);
    var onClick = "workRegionCityStat('" + cityId + "')";
    aa.attr('onclick', onClick);







    var title = (inWorkCurrent) ? titleInWork : titleRemove;
    aa.attr('title', title);
    //----------------------------------------------------//
    var li = $('<li class="list-group-item" name="city-[city_id]" ></li>');
    li.attr('name', 'city-' + cityId);
    li[0].dataset.inWorkCurrent = inWorkCurrent;
    li[0].dataset.inWorkNow = inWorkNow;
    li.append('<div class="col-md-11">' + cityName + '</div>');
    li.append(aa);
    return li;
}
/**
 * сменить статус элемента
 * @param city_id
 */
function workRegionCityStat(city_id) {

    var htmlPrefix = 'workGeographyEdit';
    var tooltipInWork = $('#' + htmlPrefix + '-tooltips [name="subItemInWork"]') ;
    var inWorkYes = tooltipInWork.data('yes') ;
    var inWorkNo = tooltipInWork.data('no') ;



    var inWorkClass = "glyphicon glyphicon-ok";
    var removeClass = "glyphicon glyphicon-remove";
    var a = 1;
    var li = $('#workRegionEdit-collapse [name="city-' + city_id + '"]');
    var inWorkCurrent = li[0].dataset.inWorkCurrent;
    var newVal = !(inWorkCurrent === "true");
    var spanClass = (newVal) ? inWorkClass : removeClass;
    var aa = li.children('a');

    var title = (newVal) ? inWorkYes : inWorkNo;

    aa.attr('title', title);
    var btClass =  (newVal) ? 'btn btn-success btn-xs' : 'btn btn-default btn-xs' ;
    aa.attr('class',btClass)     ;


    var span = aa.children('span');
    span.attr('class', spanClass);
    li[0].dataset.inWorkCurrent = newVal;
}
/**
 * из общего списка городов проверяем наличие в списке
 * включённых в географию работ
 */
function prepareCityListForEdit(workCityList, cityList) {
// простой массив из workCityList
    var simpleArr = [];
    for (var key in workCityList) {
        var item = workCityList[key];
        simpleArr.push(item['city_id'] - 0);
    }
    var result = [];
    for (key in cityList) {
        var cityItem = cityList[key];
        var id = cityItem.id;
        var name = cityItem.name;
        var inWorkFlag = (simpleArr.indexOf(id - 0) >= 0 );
        var resItem = {
            city_id: id,
            name: name,
            inWorkCurrent: inWorkFlag,               // текущее изменение
            inWorkNow: inWorkFlag                     // сейчас (до сохранения) в работе
        };
        result.push(resItem);
    }
    return result;
}
/**
 * собрать страну, регион, города
 *     var li = $('<li class="list-group-item" name="city-[city_id]" ></li>') ;
 li.attr('name','city-' + cityId) ;
 li[0].dataset.inWorkCurrent = inWorkCurrent ;
 li[0].dataset.inWorkNow = inWorkNow ;
 */
/**
 *
 * @param procReady  - ссылка на объект, контролирующий запуск/окончание процесса
 * @param noNewCountry - заперет на обработку ситуации "новая страна" - это
 * сделано для вызова из changeCountry для избежания бесконечного цикла
 */
function saveWorkGeography(procReady,noNewCountry) {
    noNewCountry = (noNewCountry === undefined) ? false : noNewCountry ;
    if (typeof(procReady) === "object") {
        procReady.setStarted(true);
    }
    var countryNodeName = $('#addNewWorkRegion-country-ul').attr('name');
    var regionNodeName = $('#addNewWorkRegion-region-ul').attr('name');
    var regionBt = $('#addNewWorkRegion-region-bt');
    var countryBt = $('#addNewWorkRegion-country-bt');
    var countryName = countryBt[0].textContent;
    var arr = countryNodeName.split('-');
    var countryId = arr[1];
    arr = regionNodeName.split('-');
    var regionId = arr[1];

    // проверить смену страны //
    var leftCountryBt = $('#workCountrySelect-country-bt') ;
    var leftNodeName = leftCountryBt.attr('name') ;
    arr =  leftNodeName.split('-') ;
    var leftCountryId = arr[arr.length - 1] ;
    var newCountryFlag = ( !noNewCountry && (leftCountryId !== countryId) ) ;
    if (newCountryFlag) {
        var newName = countryBt[0].textContent ;
        workCountryInsertNewCountry(countryId,newName) ;
    }

    var aa = $('#workRegionEdit-name');
    var span = aa.children('span');
    var regionName = span[0].textContent;
    var fullyFlag = aa[0].dataset.fullyFlag;
    var deleteFlag = aa[0].dataset.deleteFlag;
    fullyFlag = (fullyFlag === 'true') ? true : false;
    deleteFlag = (deleteFlag === 'true') ? true : false;


    var ul = $('#workRegionEdit-collapse');
    var liList = ul.children('li');
    var cityList = [];
    for (var i = 0; i < liList.length; i++) {
        var li = $(liList[i]);

        var liName = li.attr('name');
        var arr = liName.split('-');
        var cityId = arr[1];
        var inWorkCurrent = li[0].dataset.inWorkCurrent;
        var inWorkNow = li[0].dataset.inWorkNow;
        var newCity = {};
        newCity['city_id'] = cityId;
        newCity['inWorkCurrent'] = (inWorkCurrent == 'true');
        newCity['inWorkNow'] = (inWorkNow == 'true');
        cityList.push(newCity);

    }
    var data = {
        country: {
            countryId: countryId,
            name: countryName
        },
        region: {
            regionId: regionId,
            name: regionName,
            fullyFlag: fullyFlag,
            deleteFlag: deleteFlag
        },
        cityList: cityList
    };
    $.ajax({
        url: 'index.php?r=work-geography%2Fadd-work-city',
        data: data,
        type: 'POST',
        success: function (res) {
            var rr = JSON.parse(res);
            var success = rr['success'];
            var message = rr['message'];
            if (rr['success'] === true) {
                //$('#workRegionEdit-area').attr('hidden','hidden') ;
                if (newCountryFlag) {
                   var newElName = 'workCountrySelect-country-' + countryId ;
                   workRegionChangeCountry(newElName) ;
                }else {
                    workRegionShow(rr);      // показать в левой половине
                }

                if (typeof(procReady) === "object") {
                    procReady.setReady(true);
                }

            } else {
                var a = 1;
            }
        },
        error: function (event, XMLHttpRequest, ajaxOptions, thrownError) {
            var responseText = event.responseText; // html - page
            showError(responseText);
        }
    });


}
/**
 * новую страну в левую часть
 * @param countryId
 * @param newName
 */
function workCountryInsertNewCountry(newId,newName) {
    var ul = $('#workCountrySelect-country-ul') ;
    var newFlag = true ;
    var liList = ul.children('li') ;
    for(var i = 0; i < liList.length; i++) {
        var liItem = liList[i] ;
        var liName= $(liItem).attr('name') ;
        var arr = liName.split('-') ;
        var liId = arr[arr.length -1] ;
        if (liId == newId ) {
            newFlag = false ;
            break ;
        }
    }
    if (newFlag) {
        var prefix = 'workCountrySelect' ;
        var li = liList[0] ;
        var newLi = $(li).clone() ;
        var newNodeName = prefix + '-' + 'country-' + newId ;
        newLi.attr('name',newNodeName) ;
        var onClick = "workRegionChangeCountry('" + newNodeName + "')" ;
        newLi.attr('onclick',onClick) ;
        var newLiAa = newLi.children('a') ;
        newLiAa[0].textContent = newName ;
        ul.append(newLi) ;
    }
}
/**
 * <a class="btn btn-default" role="button" data-toggle="collapse" style="width:91%"
 aria-expanded="false" href="#<?=$htmlSubItemId?>" aria-expanded="true"
 aria-controls="<?=$htmlSubItemId?>">
 <?=$itemName?><strong><?=$fullyName?></strong><b class="caret"></b>
 </a>
 <button class="btn btn-default" role="button" title="<?=$btTitle?>" onclick="<?=$onClick?>" >
 <span class="<?=$editClass?>"></span>
 </button>

 */

function workRegionShow(rr) {
    var div = $('<div></div>');
    var workRegion = rr['workRegion'];
    var regionId = workRegion['region_id'];
    var regionName = workRegion['region']['name'];
    var fullyFlag = workRegion['fullyFlag'];
    fullyFlag = (fullyFlag === 'true' || fullyFlag === '1');
    var aaRegion = leftRegionName(regionId, regionName, fullyFlag);
    var btEdit = leftRegionNameBtEdit(regionId);
    var workCityList = rr['workCityList'];
    if (!fullyFlag) {
        var ul = leftRegionNameSubitems(regionId, workCityList);
        ul.attr('class', 'list-group collapse');
    }

    var htmlId = getLeftRegionNameId(regionId);
    var aR = $('#' + htmlId);
    var newNode = (aR[0] == null);
    if (newNode) {
        div.append(aaRegion);
        div.append('&nbsp;');
        div.append(btEdit);
        div.append(ul);
        $('#workRegionItem-ul').prepend(div);
    }
}
function getLeftRegionNameId(regionId) {
    var htmlPrefix = 'workRegionItem';
    return htmlPrefix + '-' + regionId;
}
/**
 * кнопка с именем региона на левой панели
 * <a class="btn btn-default" role="button" data-toggle="collapse" style="width:91%"
 aria-expanded="false" href="#<?=$htmlSubItemId?>" aria-expanded="true"
 aria-controls="<?=$htmlSubItemId?>">
 <?=$itemName?><strong><?=$fullyName?></strong><b class="caret"></b>
 </a>
 <button class="btn btn-default" role="button" title="<?=$btTitle?>" onclick="<?=$onClick?>" >
 <span class="<?=$editClass?>"></span>
 </button>
 */
/**
 *
 * @param regionId
 * @param regionName
 * @param fullyFlag    - признак "регион полностью"
 */
function leftRegionName(regionId, regionName, fullyFlag) {
    var htmlId = getLeftRegionNameId(regionId);
    var aaRegion = $('#' + htmlId);
    var newNode = (aaRegion[0] == null);
    if (newNode) {
        aaRegion = $(
            '<a class="btn btn-default" role="button" data-toggle="collapse" style="width:91%" ' +
            'aria-expanded="false" href="#var-htmlSubItemId"  aria-expanded="true" ' +
            ' aria-controls="var-htmlSubItemId"> ' +
            'itemName-strong-fullyName-</strong><b class="caret"></b>' +
            '</a>');

    }
    var classCaret = '<b class="caret"></b>';    // стрелочка-указатель dropdown
    // подстановки надо делать на href и area-controls
    var subItemsId = leftGetRegionSubItemsId(regionId);
    aaRegion.attr('id', htmlId);
    aaRegion.attr('href', '#' + subItemsId);
    aaRegion.attr('area-controls', subItemsId);
    var txt = regionName + ((fullyFlag) ? '<strong> (полностью)</strong>' : '');
    aaRegion.empty();
    aaRegion.append(txt);
    if (!fullyFlag) {
        aaRegion.append(classCaret);
    }
    return aaRegion;
}
/**
 * кнопка редактирования региона
 *<button class="btn btn-default" role="button" title="<?=$btTitle?>" onclick="<?=$onClick?>" >
 <span class="<?=$editClass?>"></span>
 </button>
 */
function leftRegionNameBtEdit(reginId) {
    var htmlPrefix = 'workRegionItem';
    var onClickArg = htmlPrefix + '-' + reginId;
    var onClick = "workRegionEditOnClick('" + onClickArg + "')";
    var editClass = 'glyphicon glyphicon-edit'; // bootstrap - шрифты
    var titleText = 'region edit';
    var bt = $(
        '<button class="btn btn-default" role="button" title="<?=$btTitle?>" ' +
        'onclick="<?=$onClick?>" > ' +
        '<span class="<?=$editClass?>"></span> ' +
        '</button>');
    bt.attr('title', titleText);
    bt.attr('onclick', onClick);
    var span = bt.children('span');
    span.attr('class', editClass);
    return bt;
}
/**
 * список городов региона
 * <!--раскрывающаяся часть -->
 <ul class="list-group collapse" id="<?=$htmlSubItemId?>">
 foreach($subItems as $ind => $subItemName) {
            echo '<li class="list-group-item">' . $subItemName . '</li>' ;
        }
 </ul>
 */
function leftRegionNameSubitems(regionId, workCityList) {
    var ulId = leftGetRegionSubItemsId(regionId);
    var ul = $('#' + ulId);
    if (ul[0] == null) {
        ul = $('<ul class="list-group collapse" id="<?=$htmlSubItemId?>">');
    }
    ul.empty();
    ul.attr('id', ulId);
    for (var i = 0; i < workCityList.length; i++) {
        var WorkCity = workCityList[i];
        var name = WorkCity['city']['name'];
        var li = $('<li class="list-group-item">' + name + '</li>');
        ul.append(li);
    }
    return ul;

}
/**
 * ид списка городов для ссылки из "имени региона"
 * @param regionId
 * @returns {string}
 */
function leftGetRegionSubItemsId(regionId) {
    var htmlPrefix = 'workRegionItem';
    return htmlPrefix + '-' + regionId + '-subitems';
}
/**
 * Редактировать регион
 * перенос в правую часть и включение редактирования
 * @param elName
 */
function workRegionEditOnClick(elName, editReady) {
    var htmlPrefixRight = 'addNewWorkRegion';
    var arrReg = elName.split('-');
    var regionId = arrReg[arrReg.length - 1];
    var leftCountryUl = $('#workCountrySelect-country-ul');
    var arrCountry = (leftCountryUl.attr('name')).split('-');
    var countryId = arrCountry[arrCountry.length - 1];
    //  новый elName для country
    var countryReady = new processExecute();
    var regionReady = new processExecute();
    var addWorkReady = new processExecute();

    var newCountryElName = htmlPrefixRight + '-' + 'country' + '-' + countryId;
    var newRegionElName = htmlPrefixRight + '-' + 'region' + '-' + regionId;
    simpleGeographyOnClick(newCountryElName, ['region'], countryReady);
    var iStep = 0;
    var tmpTimer = setInterval(function () {
        var answ = countryReady.getReady();
        if (answ) {
            if (!regionReady.getStarted()) {
                regionReady.setStarted(true);
                simpleGeographyOnClick(newRegionElName, [], regionReady);
            }
        }
        if (regionReady.getReady) {
            if (!addWorkReady.getStarted()) {
                addWorkReady.setStarted(true);
                addWorkGeography(addWorkReady);
            }
        }

        var answ1 = regionReady.getReady();
        var answ2 = addWorkReady.getReady();
        if (answ && answ1 && answ2) {
            clearInterval(tmpTimer);
            if (typeof(editReady) === "object") {
                editReady.setReady(true);
            }
            if (iStep++ > 20) {
                clearInterval(tmpTimer);
            }
        }
    }, 50);
}
function workRegionChangeCountry(elName) {
    simpleGeographyOnClick(elName, []);
    var arr = elName.split('-');
    var countryId = arr[arr.length - 1];
    var data = {
        opCod: 'getRegions',
        countryId: countryId
    };
    $.ajax({
        url: 'index.php?r=work-geography%2Fget-work-region',
        data: data,
        type: 'POST',
        success: function (res) {
            var rr = JSON.parse(res);
            var success = rr['success'];
            var message = rr['message'];
            if (rr['success'] === true) {
                workRegionNewCounryShow(rr);
            } else {
                var a = 1;
            }
        },
        error: function (event, XMLHttpRequest, ajaxOptions, thrownError) {
            var responseText = event.responseText; // html - page
            showError(responseText, 'from workRegionChangeCountry');
        }
    });

}
/**
 * вывести регионы для новой страны
 * @param rr
 */
function workRegionNewCounryShow(rr) {
    var workCountry = rr['workCountry'];
    var countryId = workCountry['country_id'];
    var workRegionList = rr['workRegionList'];
    var ul = $('#workRegionItem-ul');
    ul.empty();
    var i = 0;
    var editReady = new processExecute();
    var saveReady = new processExecute();
    var btSave = $('#workRegionEdit-save') ;
    btSave.attr('disabled','disabled') ;
    btSave.append('<i class="fa fa-spinner fa-pulse"></i>') ;

    //for (var key in workRegionList) {
    var iStep = 0;
    var tmpTimer = setInterval(function () {
        var newItemFlag = (iStep == 0 || editReady.getReady() && saveReady.getReady() &&
         i < workRegionList.length ) ;
        if (newItemFlag) {
            var itemRegion = workRegionList[i];
            var regionId = itemRegion['region_id'];
            var elName = 'addNewWorkRegion-' + regionId;


            editReady.setReady(false);
            editReady.setStarted(false);
            saveReady.setStarted(false);
            saveReady.setReady(false);

            workRegionEditOnClick(elName, editReady);
            i++ ;
        }
        if (i <= workRegionList.length) {
            var answ = editReady.getReady();
            if (answ) {
                if (!saveReady.getStarted()) {
                    saveReady.setStarted(true);
                    var noNewCountry = true ;     // запрет обработки новой страны
                    saveWorkGeography(saveReady,noNewCountry);
                }
            }
        }
        if (i === workRegionList.length && editReady.getReady() && saveReady.getReady() ) {
            clearInterval(tmpTimer);
           btSave.removeAttr('disabled') ;
           var btPulse = btSave.children('i') ;
            btPulse.remove() ;

        }
        iStep++ ;
    },300);


}
function processExecute(processName) {
    var ready = false;
    var started = false;
    var _this = this;
    this.setReady = function (isReady) {
        ready = isReady;
    };
    this.getReady = function () {
        return ready;
    };
    this.setStarted = function (flag) {
        flag = (flag === undefined) ? true : flag;
        started = flag ;
    };
    this.getStarted = function () {
        return started
    };


}

//====================workDirectionAjax=====================//
/**
 * Взаимодействие с БД. подготовка, отправление и приём сообщений
 */
function WorkGeographyEditAjax() {
    var urlController = 'work-geography' ;
    var buttonsForSubItems ;    //  если будет [], то небудет кнопки редактиования
    var _this = this ;
    //-----------------------------------------------//
    /**
     * настройка на контроллер
     * @param controller
     */
    this.init = function(controller,buttons) {
        urlController = controller ;
        buttonsForSubItems = buttons ;
    } ;
    /**
     * подготовить параметры для передачи в БД
     * @param sendName - имя(ид) передачи
     * @param params   - параметры
     * @returns {*} {url: url, data: data};
     */
    this.getAjaxParam = function (sendName, params) {
        var func = sendName + 'GetAjaxParam' ;
        var res = null ;
        switch (sendName) {
            case 'getSubItems' :
                res = getSubItemsGetAjaxParam(params) ;
                break ;
            case 'saveSetItem' :
                res = saveSetItemGetAjaxParam(params) ;
                break ;
            case 'getSetItemsFact' :
                res = getSetItemsFactAjaxParam(params) ;
                break ;
            case 'addNewSet' :           // новое множество
                res = addNewSetAjaxParam(params) ;
                break ;
            default :
        }
        return res ;


    };
    /**
     * Добавиить новое множество
     * это может быть страна (для географии)
     * в случае с направлением работ - множество единственное(
     * заказ или пользователь, в зависимости от задачи)
     * @param params = {id:*, name: *}
     */

    var addNewSetAjaxParam = function(params)  {
        var url = 'index.php?r=' + urlController + '%2Fget-work-region' ;
        var opCod = 'add' ;
        var data = {
            countryId : params['id'],
            objectType : 'user'
        } ;
        return {
            opCod : opCod,
            url : url,
            data: data
        } ;

    };
    /**
     *
     * @param params={setId:id, setName: name}
     * @returns {{opCod: string, url: string, data: {workDirection: *, workItems: *}}}
     */
    var getSetItemsFactAjaxParam = function(params) {
        var url = 'index.php?r=' + urlController + '%2Fget-work-region' ;
        var opCod = 'get' ;
        var data = {
            countryId : params['id'],
            objectType : 'user'
        } ;
        return {
            opCod : opCod,
            url : url,
            data: data
        } ;

    } ;
    /**
     *
     * @param params = {set: currentSet,setItem: currentSetItem, subItems: subItemsForSend}
     */
    var saveSetItemGetAjaxParam = function(params) {
        var url = 'index.php?r=' + urlController + '%2Fadd-work-city' ;
        var opCod = 'save' ;
        var country = params['set'] ;
        var region =  params['setItem'] ;
        var subItems = params['subItems'] ;
        var cityList = [] ;
        for (var i = 0; i < subItems.length; i++) {
            var subItem = subItems[i] ;
            var city = {city_id: subItem['id'],
                city_name:  subItem['name'],
                inWorkCurrent: subItem['inWorkCurrent'] } ;
            cityList.push(city) ;
        }
        var data = {
            country :{countryId:country['id']},
            region: {regionId: region['id'],
                fullyFlag: region['fullyFlag'],
                deleteFlag: region['deleteFlag'],
                regionName:region['name']},
            cityList: cityList
        } ;
        return {
            opCod : opCod,
            url : url,
            data: data
        } ;

    } ;
    /**
     * получить список связанных элементов
     *
     * @param params = {id: item['id'],setId:setId, name: item['name']} ;
     */
    var getSubItemsGetAjaxParam = function(params) {
//        var url = 'index.php?r=work-direction%2Fget-work-items' ;
        var url = 'index.php?r=' + urlController + '%2Fget-work-city' ;
        var opCod = 'get' ;
        var data = {
            countryId : params['setId'],
            regionId :  params['id']
        } ;
        return {
            opCod : opCod,
            url : url,
            data: data
        } ;
    } ;
    /**
     * результат обращения к БД привести в стандартную форму
     * @param sendName
     * @param rr
     */
    this.parseAjaxRes = function(sendName,rr) {
        var func = sendName + 'ParseAjaxRes' ;
        var res = null ;
        switch (sendName) {
            case 'getSubItems' :
                res = getSubItemsParseAjaxRes(rr) ;
                break ;
            case 'getSubItemsSimple' :
                res = getSubItemsSimpleParseAjaxRes(rr) ;
                break ;

            case 'saveSetItem' :
                res = saveSetItemParseAjaxRes(rr) ;
                break ;
            case 'getSetItemsFact' :
                res = getSetItemsFactParseAjaxRes(rr) ;
                break ;
            case 'addNewSet' :
                res = addNewSetParseAjaxRes(rr) ;
                break ;
            default :
        }
        return res ;
    } ;

    var saveSetItemParseAjaxRes = function(rr) {

    } ;
    var addNewSetParseAjaxRes = function(rr) {
        var success = rr['success'] ;
        return {success: success,message: rr['message']} ;
    } ;
    /**
     *        $answ = [
     'success' => $success,
     'workCountry' => $wCountry ,
     'workRegionList' => $wRegionList,
     'z-end' => 'end'
     * 'workRegionList[i] = {... fully_flag: '0', region:{id: , name: } }
     * workCountry.country{id: , name: }
     * @param rr
     * @return {success: success, setItemList: setItemList}
     */
    var getSetItemsFactParseAjaxRes = function(rr) {
        var success = rr['success'] ;
        var factList = rr['workRegionList'] ;
        var set = rr['workCountry']['country'] ;
        var setId = set['id'] ;
        var setName = set['name'] ;
        var setItemList = [] ;
        for (var key in factList) {
            var item = factList[key] ;
            var reg = item.region ;
            var id = reg['id'] ;
            var name = reg['name'] ;
            var fullyFlag = item['fully_flag'] ;
            fullyFlag = (typeof(fullyFlag) === 'string') ?
                (fullyFlag === 'true' || fullyFlag == '1') : fullyFlag ;

            var newElem = {} ;
            newElem['id'] = id ;
            newElem['name'] = name ;
            newElem['fullyFlag'] = fullyFlag ;
            setItemList.push(newElem) ;
        }
        return {success: success, setId: setId,setName: setName,setItemList: setItemList} ;

    } ;
    var getSubItemsParseAjaxRes = function(rr) {
        var success = rr['success'] ;
        var dWorkDirection = rr['developerWorkDirection'] ;
        var wdItemName = dWorkDirection['workDirection']['name_ru'] ;
        var fullyFlag  = (dWorkDirection['fully_flag'] === '1') ;
        var wdItem = {
            workDirectionId: dWorkDirection['work_direction_id'],
            id: dWorkDirection['id'],
            fullyFlag: fullyFlag,
            name: wdItemName
        } ;
        var workList = rr['workItemList'] ;     // полный список по направлению
        var workListFact = rr['developerWorkItemList'] ; // фактический список по направлению
        var buttons = buttonsForSubItems ;
        return {success:success, setItem: wdItem,
            subItemsList: workList, subItemsFactList: workListFact, buttons: buttons} ;
    } ;
    /**
     * $answ = [
     'success' => $success,
     'message' => [],
     'workCountry' => $wCountry ,
     'workRegion' => $wRegion,
     'workCityList' => $workCityList,
     'cityList' => $cityList,
     'z-end' => 'end'
     * @param rr
     * @return {{success: *, setItem: {id: *, fullyFlag: boolean, name: *}, subItemsList: *, subItemsFactList: Array, buttons: *}}
     */
    var getSubItemsSimpleParseAjaxRes = function(rr) {
        var success = rr['success'] ;
        var workRegion = rr['workRegion'] ;
        var itemName = workRegion['region']['name'] ;
        var itemId = workRegion['region']['id'] ;
        var fullyFlag  = (workRegion['fully_flag'] === '1') ;
        var setItem = {
            //workDirectionId: dWorkDirection['work_direction_id'],
            //id: dWorkDirection['id'],
            id: itemId,
            fullyFlag: fullyFlag,
            name: itemName
        } ;
        var subItemsList = rr['cityList'] ;     // полный список по направлению
        var workCityList = rr['workCityList'] ; // фактический список по направлению
        var subItemsFact = [] ;
        for (var ind in workCityList) {
            if (isNaN(ind)) {
                break ;
            }
            var workCity = workCityList[ind]['city'] ;
            var subItem = {
                id: workCity['id'],
                name: workCity['name']
            } ;
            subItemsFact.push(subItem) ;
        }

        var buttons = buttonsForSubItems ;


        return {success:success, setItem: setItem,
            subItemsList: subItemsList, subItemsFactList: subItemsFact, buttons:buttons} ;
    } ;

}
//=========================================================//
