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
    var selectedTyp = arr[1] ;
    var selectedId =  arr[2] ;

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

    var liPrev = $('#' + htmlPrefixId + '-'+ selectedTyp + '-ul' +
                                  ' [name="' + htmlPrefixId+'-' + ulName + '"]') ;
    liPrev.attr('class','list-group-item') ;

    var li = $('#' + htmlPrefixId + '-' + selectedTyp + '-ul' + ' [name="' +  elName + '"]') ;
    li.attr('class','list-group-item active') ;
    var li_a = li.children()[0] ;
    var liNodeName = li_a.textContent ;
//    var span = bt.find('span .caret') ;
// новое имя на кнопку
    bt.empty() ;
    bt.append(liNodeName +  ' ') ;

    bt.append('<span class="caret"></span>') ;


    ul.attr('name',selectedTyp + '-' + selectedId) ;
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

