/**
 * Created by michael on 09.01.17.
 */
/**
 * Восстановить компоненты адреса из профиля
 */
function simpleGeographyRestore() {
    var selectedTyp = 'all' ;
    var selectedId = '' ;

    var data = {
        "opcod" : 'restore',
        "type" : 'all',
        "id" : ''
    } ;
    $.ajax({
        url: 'index.php?r=geography%2Findex',
        data: data,
        type: 'POST',
        success: function (res) {
            var rr = JSON.parse(res);
            var success = rr['success'];
            var message = rr['message'];
            if (rr['success'] === true) {
                geographyNewPoint(selectedTyp,selectedId,rr) ;
            } else {
                var a = 1 ;
            }
        },
        error: function (event, XMLHttpRequest, ajaxOptions, thrownError) {
            var responseText = event.responseText; // html - page
        }
    });

}
function simpleGeographyOnClick(elName,refTypes,procFinished) {
    if (elName === undefined) {
        if (typeof(procFinished) === "object" ) {
            procFinished.setReady(true) ;
        }
        return ;
    }
    var nameSeparator = '-' ;    // разделитель в имени элемента
    var arr = elName.split(nameSeparator) ;
    var htmlPrefixId = arr[0] ;
    var ln = arr.length ;
    var selectedTyp = arr[ln - 2] ;
    var selectedId =  arr[ln - 1] ;

    var btId = htmlPrefixId + '-' + selectedTyp + '-bt' ;

    var bt = $('#' + htmlPrefixId + '-' + selectedTyp + '-bt') ;      // кнопка с именем
    var ul = $('#' + htmlPrefixId + '-' + selectedTyp + '-ul') ;      // связанный список





    var ulName = ul.attr('name') ;
    arr = ulName.split('-') ;
    var currentId = arr[1] ;
    if (selectedId === currentId) {     // нет изменений
        if (typeof(procFinished) === "object" ) {
            procFinished.setReady(true) ;
        }
        return ;
    }
 // убрать старую отметку
       dropDownSelect(elName) ;
//     var liPrev = $('#' + htmlPrefixId + '-'+ selectedTyp + '-ul' +
//                                   ' [name="' + htmlPrefixId+'-' + ulName + '"]') ;
//     liPrev.attr('class','list-group-item') ;
//
//     var li = $('#' + htmlPrefixId + '-' + selectedTyp + '-ul' + ' [name="' +  elName + '"]') ;
//     li.attr('class','list-group-item active') ;
//     var li_a = li.children()[0] ;
//     var liNodeName = li_a.textContent ;
// //    var span = bt.find('span .caret') ;
// // новое имя на кнопку
//     bt.empty() ;
//     bt.append(liNodeName +  ' ') ;
//
//     bt.append('<span class="caret"></span>') ;
//
//
//     ul.attr('name',selectedTyp + '-' + selectedId) ;
    var data = {
        "opcod" : 'get',
        "type" : selectedTyp,
        "id" : selectedId
    } ;
    $.ajax({
        url: 'index.php?r=geography%2Findex',
        data: data,
        type: 'POST',
        success: function (res) {
//            showError(res,'res from simpleGeographyOnClick') ;
            var rr = JSON.parse(res);
//  что-бы сохранить позицию экрана  --
            $('#' + btId).focus() ;

            var success = rr['success'];
            var message = rr['message'];
            if (rr['success'] === true) {
               geographyNewPoint(htmlPrefixId,selectedTyp,selectedId,rr,refTypes) ;
                if (typeof(procFinished) === "object" ) {
                    procFinished.setReady(true) ;
                }
            }
        },
        error: function (event, XMLHttpRequest, ajaxOptions, thrownError) {
            var responseText = event.responseText; // html - page
            showError(responseText,'simpleGeographyOnClick') ;

        }
    });
}
/**
 * формирует связанные списки ст екущим типом
 * например, если тек тип country, то переформировываться будут связанные списки: region, city
 * @param selectedTyp - тип компонента адреса (country | region | city)
 * @param selectedId  - ид выбранного элемента
 * @param rr - результат, пришедший от ajax содержит списки компонентов адреса
 * @refTypes - список связанных типов, если нет, то взять из таблицы
 */
function geographyNewPoint(htmlPrefix,selectedTyp,selectedId,rr,refTypes) {
    // связанные типы
    var referTypes = {
        'all' : ['country','region','city'],
        'country' : ['region','city'],
        'region' :  ['city'],
        'city' : [],
        'countryOnly': ['country'],
        'regionOnly': ['region'],
        'cityOnly': ['city']
    } ;
    var referSelected = (refTypes === undefined || refTypes.length == 0) ? referTypes[selectedTyp] : refTypes ;
//    var selectedList = rr[selectedTyp + 'List'] ;
//    geographyNodesBuild(selectedTyp,selectedId,selectedList) ;  // только для списков нижнего уровня
//  перестроить связанные компоненты адреса
    for (var i = 0; i < referSelected.length; i++) {
        var referType = referSelected[i] ;
        var referList =  rr[referType + 'List'] ;
//        var referId = referList[0]['id'] ;
        var referId = rr[referType + '_id'] ;
        geographyNodesBuild(htmlPrefix,referType,referId,referList) ;
    }
}
/**
 * обновить имя на кнопке, пересоздать связанный список
 * @param selectedTyp
 * @param selectedId
 * @param selectedList   [{'id' => ..., 'name' => ...}, ....]
 */
function geographyNodesBuild(htmlPrefix,selectedTyp,selectedId,selectedList) {
    var liOrderClass = 'list-group-item' ;           // класс обычного элемента списка
    var liActiveClass = 'list-group-item active' ;           // класс выделенного элемента списка
    var bt = $('#' + htmlPrefix +'-'+ selectedTyp + '-bt') ;      // кнопка с именем
    var ul = $('#' + htmlPrefix +'-'+ selectedTyp + '-ul') ;      // связанный список
    var functionOnClick = 'simpleGeographyOnClick' ;
    var span = bt.children('span') ;              // это стрелочка рядом с именем
    var btNewName = '' ;      //  новое имя для кнопки

    ul.attr('name',selectedTyp + '-' + selectedId) ;
    ul.empty() ;

    for (var i = 0; i < selectedList.length; i++) {
        var itemId = selectedList[i]['id'] ;
        var itemName = selectedList[i]['name'] ;
        var li = $('<li></li>') ;
        li.attr('name',htmlPrefix + '-' +selectedTyp + '-' + itemId) ;
        var li_a = $('<a href="#" tabindex="-1"></a>') ;
//        li.attr('name',selectedTyp + '-' + itemId) ;

        var arg = htmlPrefix + '-' + selectedTyp + '-' + itemId ;
        var newValue = functionOnClick + '("' + arg + '")' ;
        li.attr('onclick',newValue) ;
        li.attr('class',liOrderClass) ;
        if (selectedId - 0 === itemId - 0) {
            li.attr('class',liActiveClass) ;
            btNewName = itemName ;
        }
        li_a[0].textContent = itemName  ;
        li.append(li_a) ;
        ul.append(li) ;
    }
    bt.empty() ;
    bt.append(btNewName +  ' ') ;
    bt.append('<span class="caret"></span>') ;
}

/**
 * котроллер управления представлением географической точки в
 * форме страна, регион, город
 *  одновременно на одной странице может присуствовать несколько
 *  географических точек. различаться они должны своим htmlPrefix'ом
 *  все операции обмена с backEnd через один контроллер
 * @constructor
 */
function SimpleGeography() {
   var geographyItems = {} ; // список географических точек
   // var currentGeographyItem = {} ;
   var currentHtmlPrefix ;
   var currentType;     // 'country' | 'region' | 'city'
    var referTypes = {           // связанные типы
        'all' : ['country','region','city'],
        'country' : ['region','city'],
        'region' :  ['city'],
        'city' : [],
        'countryOnly': ['country'],
        'regionOnly': ['region'],
        'cityOnly': ['city']
    } ;

    var url = 'index.php?r=geography%2Findex' ;
   var ajaxExe = null ;
   var _this = this ;
//------------------------------------------------//
   this.init = function(htmlPrefix) {
        if (geographyItems[htmlPrefix] === undefined) {
            geographyItems[htmlPrefix] = newGeographyItem() ;
        }
       if (ajaxExe === null) {
           ajaxExe = new AjaxExecutor(); // собственный исполнитель запроса
       }


   } ;
   var newGeographyItem = function() {
       return {
           'country' : {'id':'', 'name':''},
           'region' : {'id':'', 'name':''},
           'city' : {'id':'', 'name':''}} ;
   } ;

    this.simpleGeographyOnClick = function(elName) {
        var nameSeparator = '-' ;    // разделитель в имени элемента
        var arr = elName.split(nameSeparator) ;
        currentHtmlPrefix = arr[0] ;
        var ln = arr.length ;
        var selectedTyp = arr[ln - 2] ;
        var selectedId =  arr[ln - 1] ;
        // var btId = currentHtmlPrefix + '-' + selectedTyp + '-bt' ;
        currentType = selectedTyp ;
        geographyItems[currentHtmlPrefix][selectedTyp]['id'] = selectedId ;

        // var bt = $('#' + currentHtmlPrefix + '-' + selectedTyp + '-bt') ;      // кнопка с именем
        var ul = $('#' + currentHtmlPrefix + '-' + selectedTyp + '-ul') ;      // связанный список





        var ulName = ul.attr('name') ;
        arr = ulName.split('-') ;
        var currentId = arr[1] ;
        if (selectedId === currentId) {     // нет изменений
            return ;
        }
        // заменить отметку
        dropDownSelect(elName) ;
        var data = {
            "opcod" : 'get',
            "type" : selectedTyp,
            "id" : selectedId
        } ;

        ajaxExe.setUrl('url') ;
        ajaxExe.setData(data) ;
        ajaxExe.setCallback(simpleGeographyShow) ;
        ajaxExe.go() ;
    };
    /**
     /**
     * формирует связанные списки с текущим типом
     * например, если тек тип country, то переформировываться будут связанные списки: reg
     * $answ = [     // формат возврта по ajax
     'success' => $this->_success ,
     'country_id' => $this->_params['country'],
     'region_id' => $this->_params['region'],
     'city_id' => $this->_params['city'],
     'countryList' => $this->_countryList,
     'regionList' => $this->_regionList,
     'cityList' => $this->_cityList,
     * @param rr
     */
    var simpleGeographyShow = function(rr) {
        var success = rr['success'];
        if (success !== true) {
            return;
        }
        var referSelected = referTypes[currentType] ;  // ссылка на младшие компоненты
//  перестроить связанные компоненты адреса
        for (var i = 0; i < referSelected.length; i++) {
            var referType = referSelected[i] ;
            var referList =  rr[referType + 'List'] ;
            var referId = rr[referType + '_id'] ;
            geographyNodesBuild(referType,referId,referList) ;
        }

    } ;
    /**
     * обновить имя на кнопке, пересоздать связанный список
     * @param selectedTyp
     * @param selectedId
     * @param selectedList   [{'id' => ..., 'name' => ...}, ....]
     */
    var geographyNodesBuild = function(selectedTyp,selectedId,selectedList) {
        var liOrderClass = 'list-group-item' ;           // класс обычного элемента списка
        var liActiveClass = 'list-group-item active' ;           // класс выделенного элемента списка
        var bt = $('#' + currentHtmlPrefix +'-'+ selectedTyp + '-bt') ;      // кнопка с именем
        var ul = $('#' + currentHtmlPrefix +'-'+ selectedTyp + '-ul') ;      // связанный список
        var functionOnClick = 'simpleGeographyOnClick' ;
        var span = bt.children('span') ;              // это стрелочка рядом с именем
        var btNewName = '' ;      //  новое имя для кнопки

        ul.attr('name',selectedTyp + '-' + selectedId) ;
        ul.empty() ;

        for (var i = 0; i < selectedList.length; i++) {
            var itemId = selectedList[i]['id'] ;
            var itemName = selectedList[i]['name'] ;
            var li = $('<li></li>') ;
            li.attr('name',currentHtmlPrefix + '-' +selectedTyp + '-' + itemId) ;
            var li_a = $('<a href="#" tabindex="-1"></a>') ;
//        li.attr('name',selectedTyp + '-' + itemId) ;

            var arg = currentHtmlPrefix + '-' + selectedTyp + '-' + itemId ;
            var newValue = functionOnClick + '("' + arg + '")' ;
            li.attr('onclick',newValue) ;
            li.attr('class',liOrderClass) ;
            if (selectedId - 0 === itemId - 0) {
                li.attr('class',liActiveClass) ;
                btNewName = itemName ;
            }
            li_a[0].textContent = itemName  ;
            li.append(li_a) ;
            ul.append(li) ;
        }
        bt.empty() ;
        bt.append(btNewName +  ' ') ;
        bt.append('<span class="caret"></span>') ;
    } ;



}