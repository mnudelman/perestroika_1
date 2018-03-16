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
function simpleGeographyOnClick(elName) {
         var controllerName = 'simpleGeographyController' ;
         var cnt = paramSet.getObj(controllerName) ;
         if (cnt === null) {
             cnt = new SimpleGeography() ;
             paramSet.putObj(controllerName,cnt) ;
          }
          cnt.simpleGeographyOnClick(elName) ;
}

/**
 * асихронный вывод компонентов географии
 * @param htmlPrefix
 * @param place = {country: id, region:id, city:id}
 */
function geographyPlaceShow(htmlPrefix,place) {
    var components = ['country', 'region', 'city'];

    var controllerName = 'simpleGeographyController' ;
    var cnt = paramSet.getObj(controllerName) ;
    if (cnt === null) {
        cnt = new SimpleGeography() ;
        paramSet.putObj(controllerName,cnt) ;
    }

    var iStep = -1 ;
    for (var i = 0; i < components.length; i++) {
        var componentName = components[i] ;
        var componentId = place[componentName] ;
        if (componentId === undefined || componentId === null || componentId === false ||
            (typeof(componentId) === 'string' && componentId.length === 0 ) ) {
            continue ;
        }
        iStep = i ;
        break ;

    }
    if (iStep === -1) {
        return ;
    }
    var iStepMax = components.length - 1 ;
    cnt.setReadyFlag(false) ;
    componentName = components[iStep] ;
    componentId = place[componentName] ;
    var btName = htmlPrefix + '-' + componentName +'-' + componentId ;
    cnt.simpleGeographyOnClick(btName) ;
    var tmpTimer = setInterval(function () {
        if (cnt.getReadyFlag()) {
            if (iStep < iStepMax) {
                iStep ++ ;
                cnt.setReadyFlag(false) ;
                componentName = components[iStep] ;
                componentId = place[componentName] ;
                btName = htmlPrefix + '-' + componentName +'-' + componentId ;
                cnt.simpleGeographyOnClick(btName) ;
            }else {
                clearInterval(tmpTimer) ;
            }
        }
    }, 50);







}


/**
 * переключатель имни региона в области новый
 * @param par = {setBtName: , setItemBtName}
 * перевести выполнение на geographyPlaceShow
 */
function geographySetItemToggle(par) {
    var btSetName = par['newSetBtName'] ;
    var btSetItemName = par['newSetItemBtName'] ;
    var controllerName = 'simpleGeographyController' ;
    var cnt = paramSet.getObj(controllerName) ;
    if (cnt === null) {
        cnt = new SimpleGeography() ;
        paramSet.putObj(controllerName,cnt) ;
    }
    if (btSetName !== null) {
        cnt.setReadyFlag(false) ;
        cnt.simpleGeographyOnClick(btSetName) ;
    }else  {
        cnt.setReadyFlag(true) ;
    }
    var tmpTimer = setTimeout(function () {
        if (cnt.getReadyFlag()) {
            cnt.simpleGeographyOnClick(btSetItemName) ;
            clearTimeout(tmpTimer) ;
        }
    }, 50);
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
   var htmlPrefix ;
   var currentType;     // 'country' | 'region' | 'city'
    var referTypes = {           // связанные подчинённые типы
        'all' : ['country','region','city'],
        'country' : ['region','city'],
        'region' :  ['city'],
        'city' : [],
        'countryOnly': ['country'],
        'regionOnly': ['region'],
        'cityOnly': ['city']
    } ;
   var readyFlag = false ;
   var url = 'index.php?r=geography%2Findex' ;
   var ajaxExe = null ;
   var _this = this ;
//------------------------------------------------//
   this.init = function() {
       ajaxExe = new AjaxExecutor(); // собственный исполнитель запроса
   } ;
   // var newGeographyItem = function() {
   //     return {
   //         'country' : {'id':'', 'name':''},
   //         'region' : {'id':'', 'name':''},
   //         'city' : {'id':'', 'name':''}} ;
   // } ;
    this.setReadyFlag = function(flag) {
       readyFlag = flag ;
    } ;
    this.getReadyFlag = function() {
       return readyFlag ;
    } ;
    this.simpleGeographyOnClick = function(elName) {
        if (ajaxExe === null) {
            _this.init() ;
        }
        var nameSeparator = '-' ;    // разделитель в имени элемента
        var arr = elName.split(nameSeparator) ;

        var ln = arr.length ;
        var selectedTyp = arr[ln - 2] ;
        var selectedId =  arr[ln - 1] ;
        htmlPrefix = arr[0] ;
        //  в  htmlPrefix возможно составной
        for (var i = 1; i < ln - 2; i++) {
            htmlPrefix += nameSeparatorar +arr[i] ;
        }
        currentType = selectedTyp ;
// текущий id хранится в атрибуте name
        var ul = $('#' + htmlPrefix + '-' + selectedTyp + '-ul') ;      // связанный список
        var ulName = ul.attr('name') ;
        arr = ulName.split('-') ;
        var currentId = arr[arr.length -1] ;
        if (selectedId === currentId) {     // нет изменений
            readyFlag = true ;
            return ;
        }
        // заменить отметку на выбранный
        dropDownSelect(elName) ;
// получить связанные элементы
        var data = {
            "opcod" : 'get',
            "type" : selectedTyp,
            "id" : selectedId
        } ;

        ajaxExe.setUrl(url) ;
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
        if (referSelected.length === 0) {

        }else {
            for (var i = 0; i < referSelected.length; i++) {
                referType = referSelected[i] ;
                referList =  rr[referType + 'List'] ;
                referId = rr[referType + '_id'] ;
                geographyNodesBuild(referType,referId,referList) ;
            }
        }

        readyFlag = true ;
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
        var bt = $('#' + htmlPrefix +'-'+ selectedTyp + '-bt') ;      // кнопка с именем
        var ul = $('#' + htmlPrefix +'-'+ selectedTyp + '-ul') ;      // связанный список
        if (bt.length === 0 ) {    // кнопка не существует
            return ;
        }
        var functionOnClick = 'simpleGeographyOnClick' ;
        var span = bt.children('span') ;              // это стрелочка рядом с именем
        var btNewName = '' ;      //  новое имя для кнопки
        ul.attr('name',selectedTyp + '-' + selectedId) ;
        bt.attr('name',selectedTyp + '-' + selectedId) ;
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
    } ;
}