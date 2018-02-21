/**
 * Редактирование направлений работ
 */
function ParamSet() {
    var  objMap = {} ;
    var contextMap  = {} ;
    var _this = this ;
 //---------------------------------------------//
    this.init = function() {
        var contextName = 'workDirectionEdit' ;
        var contextItem = newContextItem() ;
        contextItem['context']['html'] = new WorkDirectionEditHtml() ;
        contextItem['context']['ajax'] = new WorkDirectionEditAjax()  ;
        var cnt = new EditDataController(contextName,contextItem['context']) ;
        cnt.init(contextName,contextItem['context']) ;
        contextItem['controller'] = cnt ;
        contextMap[contextName] = contextItem ;

    } ;
    this.getObj = function(objName) {
        if (objMap[objName] === undefined) {
           return null ;
        }
        return objMap[objName] ;
    } ;
    this.putObj = function(objName,object) {
        objMap[objName] = object ;

    } ;
    /**
     * получить объект - контроллер для контекста
     * @param contextName
     * @returns {*}
     */
    this.getController = function(contextName) {
        if (contextMap[contextName] === undefined) {
            makeContext(contextName) ;
        }
        var contextItem = contextMap[contextName] ;
        return contextItem['controller'] ;

    } ;
    /**
     * получить объекты контекста
     * @param contextName
     * @returns {*} {html: вывод на html document , ajax: атрибуты связи с php}
     */
    this.getContext = function(contextName) {
        if (contextMap[contextName] === undefined) {
            makeContext(contextName) ;
        }
        var contextItem = contextMap[contextName] ;
        return contextItem['context'] ;
    } ;
    var makeContext = function(contextName) {
        if (contextMap[contextName] === undefined) {
            var contextItem = newContextItem();

            switch (contextName) {
                case 'workDirectionEdit' :
                    contextItem['context']['html'] = new WorkDirectionEditHtml();
                    contextItem['context']['ajax'] = new WorkDirectionEditAjax();
                    var cnt = new EditDataController(contextName, contextItem['context']);
                    cnt.init(contextName, contextItem['context']);
                    contextItem['controller'] = cnt;
                    contextMap[contextName] = contextItem;

                    break;
                case 'orderEditWorks' :           // работы, включённые в заказ
                    var html = new WorkDirectionEditHtml();
                    var ajax = new WorkDirectionEditAjax();
                    // ------ добавим настройки констант ----- //
                    // html.init('orderWorkDirectionEdit') ;
                    html.init('orderEditWorks');
                    ajax.init('order-work-direction');
                    contextItem['context']['html'] = html;
                    contextItem['context']['ajax'] = ajax;

                    var cnt = new EditDataController();
                    cnt.init(contextName, contextItem['context']);
                    contextItem['controller'] = cnt;
                    contextMap[contextName] = contextItem;
                    // алиас
                    contextMap['orderEditWorks'] = contextItem;
                    break;
                case 'orderEdit' :           // заказ - general
                    var html = new OrderDataEditHtml();
                    var ajax = null;
                    // ------ добавим настройки констант ----- //
                    contextItem['context']['html'] = html;
                    contextItem['context']['ajax'] = ajax;

                    var cnt = new OrderDataEdit();
                    cnt.init(contextName, contextItem['context']);
                    contextItem['controller'] = cnt;
                    contextMap[contextName] = contextItem;
                    break;

                case 'orderEditMailing' :           // рассылка заказа
                    var html = new OrderMailingHtml();
                    var ajax = null;
                    // ------ добавим настройки констант ----- //
                    contextItem['context']['html'] = html;
                    contextItem['context']['ajax'] = ajax;

                    var cnt = new OrderMailing();
                    cnt.init(contextName, contextItem['context']);
                    contextItem['controller'] = cnt;
                    contextMap[contextName] = contextItem;
                    break;

                case 'orderEditMailingProfile' :           // рассылка заказа - профиль заказчика
                    var html = new OrderMailingProfileHtml();
                    var ajax = null;
                    // ------ добавим настройки констант ----- //
                    contextItem['context']['html'] = html;
                    contextItem['context']['ajax'] = ajax;

                    var cnt = new OrderMailingProfile();
                    cnt.init(contextName, contextItem['context']);
                    contextItem['controller'] = cnt;
                    contextMap[contextName] = contextItem;
                    break;
                case 'orderEditMailingProfileGeography' :   // рассылка заказа - профиль заказчика - география работ
                    var html = new WorkDirectionEditHtml();
                    var ajax = new OrderMailingProfileAjax() ;
                    // ------ добавим настройки констант ----- //
                    contextItem['context']['html'] = html;
                    contextItem['context']['ajax'] = ajax;

                    var cnt = new EditDataController();
                    cnt.init(contextName, contextItem['context']);
                    contextItem['controller'] = cnt;
                    contextMap[contextName] = contextItem;
                    break;
                case 'orderEditMailingProfileWorks' :       // рассылка заказа - профиль - работы
                    var html = new WorkDirectionEditHtml();
                    var ajax = new WorkDirectionEditAjax();
                    // ------ добавим настройки констант ----- //
                    // html.init('orderWorkDirectionEdit') ;
                    html.init(contextName);
                    ajax.init('developer-work-direction',[]);  // контроллер
                    contextItem['context']['html'] = html;
                    contextItem['context']['ajax'] = ajax;

                    var cnt = new EditDataController();
                    cnt.init(contextName, contextItem['context']);
                    contextItem['controller'] = cnt;
                    contextMap[contextName] = contextItem;
                    // алиас
//                    contextMap['orderEditWorks'] = contextItem;
                    break;

                case 'officeDeveloperOrdersOrderView' :  // заказ - просмотр
                    var html = new OrderViewHtml();
                    var ajax = new OrderViewAjax();
                    // ------ добавим настройки констант ----- //
                    // html.init('orderWorkDirectionEdit') ;
                    html.init(contextName);
                    ajax.init('developer-work-direction',[]);  // контроллер
                    contextItem['context']['html'] = html;
                    contextItem['context']['ajax'] = ajax;

                    var cnt = new OrderView();
                    cnt.init(contextName, contextItem['context']);
                    contextItem['controller'] = cnt;
                    contextMap[contextName] = contextItem;
                    // алиас
//                    contextMap['orderEditWorks'] = contextItem;
                    break;

                case 'officeDeveloperOrdersOrderViewWorks' :  // заказ - просмотр
                    var html = new WorkDirectionEditHtml();
                    var ajax = new WorkDirectionEditAjax();
                    // ------ добавим настройки констант ----- //
                    // html.init('orderWorkDirectionEdit') ;
                    html.init(contextName);
                    ajax.init('order-work-direction',[]);  // контроллер
                    contextItem['context']['html'] = html;
                    contextItem['context']['ajax'] = ajax;

                    var cnt = new EditDataController();
                    cnt.init(contextName, contextItem['context']);
                    contextItem['controller'] = cnt;
                    contextMap[contextName] = contextItem;
                    // алиас
//                    contextMap['orderEditWorks'] = contextItem;
                    break;

                case 'menuPath' :  // заказ - просмотр
                    var html = new MenuPathHtml();
                    var ajax = null;
                    // ------ добавим настройки констант ----- //
                    // html.init('orderWorkDirectionEdit') ;
                    html.init(contextName);
                    contextItem['context']['html'] = html;
                    contextItem['context']['ajax'] = ajax;

                    var cnt = new MenuPath();
                    cnt.init(contextName, contextItem['context']);
                    contextItem['controller'] = cnt;
                    contextMap[contextName] = contextItem;
                    break;

                case 'officeDeveloperOrders' :  // состояние заказа
                    var html = new DeveloperOrdersHtml();
                    var ajax = null;
                    // ------ добавим настройки констант ----- //
                    // html.init('orderWorkDirectionEdit') ;
                    html.init(contextName);
                    contextItem['context']['html'] = html;
                    contextItem['context']['ajax'] = ajax;

                    var cnt = new DeveloperOrders();
                    cnt.init(contextName, contextItem['context']);
                    contextItem['controller'] = cnt;
                    contextMap[contextName] = contextItem;
                    break;
                case 'officeProfileEditWorkGeography' :  // география работ
                    var html = new WorkDirectionEditHtml();
                    var ajax = new WorkGeographyEditAjax();
                    // ------ добавим настройки констант ----- //
                    // html.init('orderWorkDirectionEdit') ;
                    html.init(contextName,'country');
                   // - внешняя функция смены региона в области новый
                    var extFunc = {
                        'newSetItemToggle' : 'geographySetItemToggle'
                    } ;
                    html.setExtFunctions(extFunc) ;
                    contextItem['context']['html'] = html;
                    contextItem['context']['ajax'] = ajax;

                    var cnt = new EditDataController();
                    cnt.init(contextName, contextItem['context']);
                    contextItem['controller'] = cnt;
                    contextMap[contextName] = contextItem;
                    break;


            }



        }
    } ;
    var newContextItem = function() {
        return {controller: null,context: {ajax: null,html: null} } ;
    } ;

}
//===================AjaxExecutor===========================//
function AjaxExecutor() {
    var url ;
    var data = {} ;
    var callback ;
    var errorCallback ;
    var _this = this ;
    //------------------------------------//
    this.setUrl = function(urlPar) {
        url = urlPar ;
    } ;
    this.setCallback = function(successCall,errorCall) {
        callback = successCall ;
        errorCallback = errorCall ;
    } ;
    this.setData = function(dataPar) {
        data = dataPar ;
    } ;
    this.go = function() {
        $.ajax({
            url: url,
            data: data,
            type: 'POST',
            success: function (res) {
                var rr = JSON.parse(res);
                if (typeof(callback) === "function") {
                    callback(rr);
                }
            },
            error: function (event, XMLHttpRequest, ajaxOptions, thrownError) {
                var responseText = event.responseText; // html - page
                showError(responseText);
                if (typeof errorCallback === "function") {
                    errorCallback(responseText) ;
                }
            }
        });

    } ;
}
//======================EditDataController===================//
/**
 * главвный контроллер
 * получает все обращения от элементов  html document
 * @constructor
 */
function EditDataController() {
    var contextName ;
    var scheme = {
        'setSelector' : null ,
        'itemList' : null ,
        'newItemSelector' : null,
        'editImplement' : null
    } ;
    var _this = this ;
//-------------------------------------------------------//
    this.init = function(ctxtName,contextItem) {
        contextName = ctxtName ;
        var setSelector = new EditDataSetSelector() ;
        setSelector.init(ctxtName,contextItem) ;
        scheme['setSelector'] = setSelector ;
        var editImplement = new EditImplement() ;
        editImplement.init(ctxtName,contextItem) ;
        scheme['editImplement'] = editImplement ;
    } ;
    /**
     * возможна установка внешней схемы
     * @param externalScheme
     */
    this.setSheme = function(externalScheme) {
        for (key in scheme) {
            if (!externalScheme[key]) {
                scheme[key] = externalScheme[key] ;
            }
        }
    } ;
    /**
     * переключить множество
     * @param newSetId
     * @returns {boolean}
     */
    this.switchSet = function(newSetId) {
        var setSelector = scheme['setSelector'] ;
        if(!setSelector.isFind(newSetId)) {  // ?????????
//            return false ;
        }
        setSelector.showCurrentSet(newSetId) ;
    } ;
    /**
     * добавить новое множество
     * @param newSetId
     * @param newSetName
     */
    this.addNewSet = function(newSetId,newSetName) {
        var setSelector = scheme['setSelector'] ;
        setSelector.addNewSet(newSetId,newSetName) ;
    } ;
    /**
     * добавить новый элемент из области "новый"
     * 1.берём текущие атрибуты кнопок, устанавливающих
     * новый элемент
     * 2. запускаем setItemEdit
     */
    this.addNewSetItem = function() {
        var setSelector = scheme['setSelector'] ;
        var setItemSelectorComponents = setSelector.getNewSetItemSelector() ;
        var set = setItemSelectorComponents['set'] ;
        setSelector.setCurrentSet(set['id'],set['name']) ;

        var setItem = setItemSelectorComponents['setItem'] ;

        _this.setItemEdit(setItem['id']) ;
    } ;
    /**
     * редактировать элемент множества
     * например, workDirection
     * найти элемент в левой части и скопировать для редактирования в
     * область редактирования
     * @param setItemId
     */
    this.setItemEdit = function(setItemId) {
        var setSelector = scheme['setSelector'] ;
        var setId = setSelector.getCurrentSetId() ;

        var editImplement = scheme['editImplement'] ;

        editImplement.setItemEdit(setItemId,setId) ;
    };
    /**
     * переключить элемент
     * @param id
     */
    this.setItemToggle = function(id) {
        // var editImplement = scheme['editImplement'] ;
//        editImplement.setItemToggle(id) ;
        var setSelector = scheme['setSelector'] ;
        setSelector.setItemToggle(id) ;
    } ;
    this.setSubItemStat = function(id) {
        var editImplement = scheme['editImplement'] ;
        editImplement.setSubItemStat(id) ;
    } ;
    this.setSubItemsOnlySelectedShow = function() {
        var editImplement = scheme['editImplement'] ;
        editImplement.setSubItemsOnlySelectedShow() ;
    };

    this.setItemStat = function(type) {
        var editImplement = scheme['editImplement'] ;
        editImplement.setItemStat(type) ;
    } ;
    /**
     * сохранить элемент из области изменений
     */
    this.setItemSave = function() {
        var setSelector = scheme['setSelector'] ;
        var currentSet = setSelector.getCurrentSet() ;
        var currentSetId = currentSet['id'] ;
        var isFind = setSelector.isFind(currentSetId) ;
        var factSetId = setSelector.getFactSetId() ;
        if (!isFind) {    // добавить
//            setSelector.addNewSet(currentSet.id,currentSet.name) ;
        }
        if (factSetId !== currentSetId) {   // переключение множества
            _this.switchSet(currentSetId) ;
        }
        var editImplement = scheme['editImplement'] ;
        editImplement.setItemSave(currentSet) ;
    } ;
}
//===================EditDataSetSelector=====================//
/**
 * управление множеством элементов
 * @constructor
 */
function EditDataSetSelector() {
    var contextName ;
    var htmlContext ;
    var ajaxContext ;

    var ajaxExe ;
    var currentSet = {id: null, name: null} ;
    var factSets = {} ; // массив  имеющихся множеств
    var queue = [] ;        // очередь элементов при асихронной обработке
    var queuePushReady = false ;  // для очерёдности обращений к БД
    var _this = this ;
//----------------------------------------------//
    this.init = function(ctxtName,contextItem) {
        contextName = ctxtName ;
        htmlContext = contextItem['html'] ;
        ajaxContext = contextItem['ajax'] ;
        ajaxExe = new AjaxExecutor() ; // собственный исполнитель запроса
        factSets = htmlContext.getFactSets() ;
        currentSet.id = htmlContext.getFactSetId() ;

    } ;
    this.isFind = function(setId) {
        factSets = htmlContext.getFactSets() ;
        return (factSets[setId] !== undefined) ;
    } ;
    this.setItemToggle = function(setItemId) {
        htmlContext.setItemToggle(setItemId,currentSet.id) ;
    } ;
    /**
     * снять имена кнопок, устанавливающих новый элемент
     * @return {set:{id:*, name:*},setItem: {id:*, name:*}}
     */
    this.getNewSetItemSelector = function() {
        return htmlContext.getNewSetItemSelector() ;
    } ;
    /**
     * новое множество добавляется в  html document и в БД
     * @param newSetId
     * @param newSetName
     */
    this.addNewSet = function(newSetId,newSetName) {
        if (!_this.isFind(newSetId)) {
            factSets[newSetId] = newItem(newSetId,newSetName) ;
            htmlContext.addNewSet(newSetId,newSetName) ;
            var sendPar = {id: newSetId, name: newSetName} ;
            var  ajaxPar = ajaxContext.getAjaxParam('addNewSet',sendPar) ;
            ajaxExe.setUrl(ajaxPar['url']) ;
            ajaxExe.setData(ajaxPar['data']) ;
            ajaxExe.setCallback(addNewSetRes) ;

        }
    } ;
    var addNewSetRes = function(rr) {
       var success = rr['success'] ;
       if (success){
           factSets = htmlContext.getFactSets() ;
       }
    } ;
    var newItem = function(id,name) {
        return {id: id, name: name} ;
    } ;
    this.getCurrentSetId = function() {
       return currentSet.id ;
    } ;
    this.getCurrentSet = function() {
        return currentSet ;
    };
    this.getFactSetId = function() {
        return htmlContext.getFactSetId() ;
    } ;
    this.setCurrentSet = function(setId,setName) {
        currentSet.id = setId ;
        currentSet.name = setName ;
    } ;
    /**
     * надо запрашивать список элементов
     * по каждому элементу выбирать подэлементы
     * и всё это добавлять в ulSet
     * @param setId
     */
    this.showCurrentSet = function(setId) {
        if (currentSet['id'] == setId) {
//            return true ;
        }
        currentSet['id'] = setId ;
//        currentSet['name'] = setName ;

        htmlContext.setItemsClear() ;




        htmlContext.showCurrentSet(setId) ; // смена имени на кнопке
        // получить список элементов из БД
        var setName = '' ;
        var sendPar = {id: setId, name: setName} ;
        var  ajaxPar = ajaxContext.getAjaxParam('getSetItemsFact',sendPar) ;
        ajaxExe.setUrl(ajaxPar['url']) ;
        ajaxExe.setData(ajaxPar['data']) ;
        ajaxExe.setCallback(setCurrentSetDo) ;
        ajaxExe.go() ;
    } ;
    /**
     * callBack - для приёма списка
     * rr = {success: success, setItemList: setItemList}
     * запускается 2 процесса: 1. читает БД и пополняет очередь с конца.
     * 2. читает с начала и выводит в html
     * элементы очереди имеют вид: {id:  , name:   , subItems: [{id: ,name:}]}
     */
    var setCurrentSetDo = function(res) {
        queue = [] ;
        var rr = ajaxContext.parseAjaxRes('getSetItemsFact',res) ;
        var setItemList = rr['setItemList'] ;
        var setId = rr['setId'] ;
        queuePush(setItemList,setId) ;
        queueShift() ;
    };
    /**
     * для каждого элемента из БД запрашивает подчинённые
     * и помещает в очередь
     * @param setItemList
     */
    var queuePush = function(setItemList,setId) {
        var i = 0 ;
        queuePushReady = true ;
        var tmpTimer = setInterval(function () {
            if (queuePushReady) {
                if (i === setItemList.length) {
                    var lastElem = {id: 'z_end',name:'',sumItems: []} ;
                    queue.push(lastElem) ;
                    clearInterval(tmpTimer) ;
                }else {
                    var item = setItemList[i] ;
                    var sendPar = {id: item['id'],setId:setId, name: item['name']} ;
                    var  ajaxPar = ajaxContext.getAjaxParam('getSubItems',sendPar) ;
                    ajaxExe.setUrl(ajaxPar['url']) ;
                    ajaxExe.setData(ajaxPar['data']) ;
                    ajaxExe.setCallback(queuePushDo) ;
                    queuePushReady = false ;
                    ajaxExe.go() ;
                    i++ ;
                }

            }
        }, 50);
    } ;

    var queuePushDo = function(res) {
        var rr = ajaxContext.parseAjaxRes('getSubItemsSimple',res) ;
        var elem = {} ;
        var setItem = rr['setItem'] ;
        elem['setItem'] = {
            id : setItem['id'],
            name : setItem['name'] ,
            fullyFlag : setItem['fullyFlag'],
            deleteFlag : false
        } ;
        elem['buttons'] = rr['buttons'] ;
        var factList  = rr['subItemsFactList'] ;
        var subItems = [] ;
        for (var i = 0; i < factList.length; i++) {
            var workItem = factList[i] ;
            var subItem = {} ;
            subItem = {
                id : workItem['id'],
                name: workItem['name'],
                inworkCurrentFlag: true
            } ;
            subItems.push(subItem) ;
        }
        elem['subItems'] = subItems ;

        queue.push(elem) ;
        queuePushReady = true ;

    } ;



    /**
     * брать из очереди - писать в документ
     * item = {id:  , name:   ,fullyFlag:  , subItems: [{id: ,name:}]}
     */
    var queueShift = function() {
        var tmpTimer = setInterval(function () {
            if (queue.length > 0 ) {
                var item = queue.shift() ;
                if (item['id'] == 'z_end') {
                    clearInterval(tmpTimer)
                }else {
                    var setItem = item['setItem'] ;
                    var subItems = item['subItems'] ;
                    var buttons = item['buttons'] ;  // может быть undefined
                    htmlContext.addSetItem(setItem,subItems,buttons) ;
                }
                // html формируем элемент
                // html список связанных
            }
        }, 50);

    };
}

//==================EditImplement==============//
/**
 * контроллер редактирования элемента множества
 */
function EditImplement() {
    var contextName;
    var htmlContext;
    var ajaxContext;

    var ajaxExe;
    var currentSetItem = {       // текущий элемент
        id: null, name: null,fullyFlag:false, deleteFlag: false};
    var currentSubItems = {}; // массив  имеющихся множеств
    var onlySelectedShow =false ; //  показывать только отмеченные
    var _this = this;
//----------------------------------------------//
    this.init = function (ctxtName, contextItem) {
        contextName = ctxtName;
        htmlContext = contextItem['html'];
        ajaxContext = contextItem['ajax'];
        ajaxExe = new AjaxExecutor(); // собственный исполнитель запроса
    };
    /**
     * добавить новый элемент
     * взять id из элемента добавления и
     * песлать в  setItemEdit(id)
     */
    this.addNewSetItem = function() {
        var name = htmlContext.getNewSetElemName() ;
        var arr = name.split('-') ;
        var id = arr[arr.length -1] ;
        _this.setItemEdit(id) ;
        onlySelectedShow = false ;      // сбросить выборочный просмотр
        htmlContext.setSubItemsOnlySelectedShowBt(onlySelectedShow) ;
    } ;
    /**
     * редактировать элемент множества
     * 1. перенести в область редактирования
     * @param setItemid
     */
    this.setItemEdit = function(setItemId,setId) {
        onlySelectedShow = false ;      // сбросить выборочный просмотр
        htmlContext.setSubItemsOnlySelectedShowBt(onlySelectedShow) ;
        htmlContext.setItemHighlight(setItemId) ;
        var sendPar = {id: setItemId,setId:setId} ;
        var  ajaxPar = ajaxContext.getAjaxParam('getSubItems',sendPar) ;
        ajaxExe.setUrl(ajaxPar['url']) ;
        ajaxExe.setData(ajaxPar['data']) ;
        ajaxExe.setCallback(setItemEditDo) ;
        ajaxExe.go() ;
    };

    /**
     * rr = {setItem:{Id:   , name: ,fullyFlag: },
     * subItemsFactList : {id: name }, subItemslist: {id: name:} }
     * @param res
     */
    var setItemEditDo = function(res) {
        htmlContext.setItemEditMessageClear() ;
        var success = res['success'] ;
        if (!success) {
            var message = res['message'] ;
            message['info'] = ['Возможно не выбран заказ на вкладке "общее"'] ;
            htmlContext.setItemEditMessage(message) ;
            return
        }
/////////////////////////////////////////////////////
        var rr = ajaxContext.parseAjaxRes('getSubItemsSimple', res);

/////////////////////////////////////////////////////
//         var rr = ajaxContext.parseAjaxRes('getSubItems', res);
        var setItem = rr['setItem'] ;
        var id = setItem['id'] ;
        // var workDirectionId = setItem['workDirectionId'] ;
        var name = setItem['name'] ;
        var fullyFlag = setItem['fullyFlag'] ;
        var deleteFlag =false ;

        currentSetItem['id'] = id ;  // ссылка на справочник
        currentSetItem['name'] = name ;
        currentSetItem['fullyFlag'] = fullyFlag ;
        currentSetItem['deleteFlag'] = deleteFlag ;

        htmlContext.setItemEditNode(id,name,fullyFlag,deleteFlag) ;

        var subItemsList = rr['subItemsList'] ;
        var subItemsFactList = rr['subItemsFactList'] ;
        var simpleArr = [];
        for (var key in subItemsFactList) {
            var item = subItemsFactList[key];
            simpleArr.push(item['id'] - 0); // ссылка на справочник
        }
        var result = [];
        currentSubItems = {} ;
        // ulEditEmpty()
        for (key in subItemsList) {

            var subItem = subItemsList[key];
             id = subItem.id;
             name = (subItem.name_ru === undefined) ? subItem.name : subItem.name_ru ;
            var inWorkFlag = (simpleArr.indexOf(id - 0) >= 0 );
            var resItem = {id: id,name: name, inWorkCurrent:inWorkFlag} ;
            result.push(resItem) ;
            currentSubItems[id] = resItem ;
        }
        htmlContext.setItemEditUlShow(result) ;

    } ;
    /**
     * переключить из списка
     */
    this.setItemToggle = function(id) {
        htmlContext.setItemToggle(id) ;
    } ;
    /**
     * переключить вхождение в списoк
     * @param id
     */
    this.setSubItemStat = function(id) {
        var flag = currentSubItems[id]['inWorkCurrent'] ;
        currentSubItems[id]['inWorkCurrent'] = !flag ;
        htmlContext.setSubItemStat(id,!flag) ;

    } ;
    /**
     * перекдючить режим показа -
     * полностью или только отмеченные
     */
    this.setSubItemsOnlySelectedShow = function() {
        onlySelectedShow = !onlySelectedShow ;
        htmlContext.setSubItemsOnlySelectedShowBt(onlySelectedShow) ;
        var result = [];
        // ulEditEmpty()
        for (key in currentSubItems) {
            var subItem = currentSubItems[key];
            if (!onlySelectedShow  || onlySelectedShow && subItem['inWorkCurrent']) {
                var resItem = {id: subItem['id'],name: subItem['name'], inWorkCurrent:subItem['inWorkCurrent']} ;
                result.push(resItem) ;
            }
        }
        htmlContext.setItemEditUlShow(result) ;
    } ;
    /**
     * флаги : полное включение элемента | удаление элемента
     * @param type
     */
    this.setItemStat = function(type) {
        if (type === 'fully') {
            currentSetItem['fullyFlag'] = !currentSetItem['fullyFlag'] ;
            htmlContext.setItemEditBtShow('fully',currentSetItem['fullyFlag']) ;
        }else {
            currentSetItem['deleteFlag'] = !currentSetItem['deleteFlag'] ;
            htmlContext.setItemEditBtShow('delete',currentSetItem['deleteFlag']) ;
        }
    } ;
    /**
     * сохранить элемент из области изменений
     * currentSetItem = {       // текущий элемент
     *   id: null, name: null,fullyFlag:false, deleteFlag: false};
     * currentSubItems = {}; // массив  подэлементов
     * @par currentSet = {id: , name: } - текущее множество
     * может понадобиться при необходимости добавить множество
     */
    this.setItemSave = function(currentSet) {
       var subItemsForSend = [] ;      // сделать простой массив из currentSubItems
       for (var key in currentSubItems) {
           var subItem = currentSubItems[key] ;
           subItemsForSend.push(subItem) ;
       }
        var sendPar = {set: currentSet, setItem: currentSetItem, subItems: subItemsForSend} ;
        var  ajaxPar = ajaxContext.getAjaxParam('saveSetItem',sendPar) ;
        ajaxExe.setUrl(ajaxPar['url']) ;
        ajaxExe.setData(ajaxPar['data']) ;
        ajaxExe.setCallback(setItemToLeftPart) ;
        ajaxExe.go() ;

    } ;
    /**
     * показать setItem в левой части -
     * здесь не надо парсить ответ, т.к. всё есть
     */
    var setItemToLeftPart = function(res) {
        var success = res['success'] ;
        if (!success) {
            return ;
        }
        //currentSetItem = {       // текущий элемент
        //    id: null, name: null,fullyFlag:false, deleteFlag: false};
        if (currentSetItem.deleteFlag) {
           htmlContext.delSetItem(currentSetItem.id) ;
        } else {
            var result = [];
            // ulEditEmpty()
            for (key in currentSubItems) {
                var subItem = currentSubItems[key];
                if (subItem['inWorkCurrent']) {
                    var resItem = {id: subItem['id'],name: subItem['name'], inWorkCurrent:subItem['inWorkCurrent']} ;
                    result.push(resItem) ;
                }
            }
            htmlContext.addSetItem(currentSetItem,result) ;
        }

    } ;


}
//======================WorkDirectionHtml===================//
/**
 * панель редавктирования "Напрвления работ" исполнителя -
 * адаптер - исполнитель операций с html document
 */
function WorkDirectionEditHtml() {
    var htmlPrefix = 'workDirectionEdit' ;  // уникальность блока на странице
    var setTyp = 'direct' ;
    var setBt = $('#'+ htmlPrefix + '-set-bt') ; //   перключатель множества
    var setUl = $('#'+ htmlPrefix + '-set-ul') ; //   перключатель множества -  список
    var setItemsUl = $('#'+ htmlPrefix + '-ul') ; // список элементо тек множества
    var newSetBt = null ;                         // кнопка нового множества
    var newSetUl = null ;                         // кнопка нового множества
    var newSetItemBt = $('#'+ htmlPrefix + '-newSetItem-bt')  ; // кнопка нового элемента множества
    var newSetItemUl = $('#'+ htmlPrefix + '-newSetItem-ul')  ; // список нового элемента множества
    var newSetItemImg = $('#'+ htmlPrefix + '-newSetItem-img')  ; // картинка множества
    var addNewSetItemBt = $('#'+ htmlPrefix + 'addNewSetItem-bt')  ;
                                              // кнопка (+) - команда добавить
    var setItemEditBt = $('#'+ htmlPrefix + '-editSetItem-bt') ; // редактируемый элемент множества
    var setItemEditFullyBt = $('#'+ htmlPrefix + '-fully-bt') ;
    var setItemEditDeleteBt = $('#'+ htmlPrefix + '-delete-bt') ;
    var setItemEditUl = $('#'+ htmlPrefix + '-editSetItem-ul') ; // редактируемый элемент множества
    var fullyName = '(полностью)' ;
    var onlySelectedShowGroup = $('#' + htmlPrefix + '-onlySelectedShow') ; // уровень показа

    var setItemEditPanel = $('#'+htmlPrefix + '-edit-panel') ; // вся область редактирования вместе с toolbar    var setItemEditArea = $('#'+htmlPrefix + '-edit-area') ;  // область редактирования вместе с toolbar
    var setItemEditArea = $('#'+htmlPrefix + '-edit-area') ; // область редактирования вместе с toolbar    var setItemEditArea = $('#'+htmlPrefix + '-edit-area') ;  // область редактирования hidden перед редактированием
    var setItemEditMessage = $('#'+htmlPrefix + '-message') ;  // область редактирования hidden перед редактированием
   //-- возможность включать внешние функции
    var extFunctions = {
        newSetItemToggle: null      // преключение элемнта в области добавления
    } ;
    var setLevelNames = {
        'set' : 'country',
        'setItem' : 'region',
        'subSetItem' : 'city'
    } ;
    var _this = this ;
//----------------------------------------------------------------------//
    /**
     * имена html - элементов в зависимости от prefix
     * @param prefix
     * @param setTyp - имя типа, задающего множество (например ,'country')
     */
    this.init = function(prefix,setTyp) {
        htmlPrefix = prefix ; // уникальность блока на странице
        setTyp = (setTyp === undefined) ? 'direct' : setTyp ;

        setBt = $('#'+ htmlPrefix + '-' + setTyp +'-bt') ; //   перключатель множества
        setUl = $('#'+ htmlPrefix + '-' + setTyp +'-ul') ; //   перключатель множества -  список




        setItemsUl = $('#'+ htmlPrefix + '-ul') ; // список элементо тек множества

        // newSetBt = $('#'+ htmlPrefix + '-newSet-bt') ;                         // кнопка нового множества
        // newSetUl = $('#'+ htmlPrefix + '-newSet-ul') ;                         // кнопка нового множества
        //
        //
        // newSetItemBt = $('#'+ htmlPrefix + '-newSetItem-bt')  ; // кнопка нового элемента множества
        // newSetItemUl = $('#'+ htmlPrefix + '-newSetItem-ul')  ; // список нового элемента множества

        newSetBt = $('#'+ htmlPrefix + 'NewSetItem-' + setLevelNames['set'] + '-bt') ;                         // кнопка нового множества
        newSetUl = $('#'+ htmlPrefix  + 'NewSetItem-' +setLevelNames['set'] + '-ul') ;                         // кнопка нового множества


        newSetItemBt = $('#'+ htmlPrefix + 'NewSetItem-' + setLevelNames['setItem'] + '-bt')  ; // кнопка нового элемента множества
        newSetItemUl = $('#'+ htmlPrefix + 'NewSetItem-' + setLevelNames['setItem'] + '-ul')  ; // список нового элемента множества




        newSetItemImg = $('#'+ htmlPrefix + '-newSetItem-img')  ; // картинка множества
        addNewSetItemBt = $('#'+ htmlPrefix + 'addNewSetItem-bt')  ;
        // кнопка (+) - команда добавить
        setItemEditBt = $('#'+ htmlPrefix + '-editSetItem-bt') ; // редактируемый элемент множества
        setItemEditFullyBt = $('#'+ htmlPrefix + '-fully-bt') ;
        setItemEditDeleteBt = $('#'+ htmlPrefix + '-delete-bt') ;
        setItemEditUl = $('#'+ htmlPrefix + '-editSetItem-ul') ; // редактируемый элемент множества
        onlySelectedShowGroup = $('#' + htmlPrefix + '-onlySelectedShow') ; // уровень показа
        setItemEditPanel = $('#'+htmlPrefix + '-edit-panel') ; // вся область редактирования вместе с toolbar
        setItemEditArea = $('#'+htmlPrefix + '-edit-area') ;  // область редактирования hidden перед редактированием
        setItemEditMessage = $('#'+htmlPrefix + '-message') ;  // область редактирования hidden перед редактированием
    } ;
    this.addNewSet = function(setId,setName) {
        var li = newLiSet(setId,setName)  ;
        setUl.append(li) ;

    } ;
    this.setExtFunctions = function(extFunc) {
       for(var funcType in extFunctions) {
           if (extFunc[funcType] !== undefined) {
               extFunctions[funcType] = extFunc[funcType] ;
           }
       }
    } ;
    this.setSetLevelNames = function(levelNames) {

    }
    this.setEmpty = function() {
        setUl.empty() ;
    } ;
    /**
     * получить элементы списка setUl
     */
    this.getFactSets = function() {
        var factSetList = {} ;
        if (setUl.length === 0) {  // наличие кнопки выбора множества
            return {} ;
        }
        var liList = setUl.children('li') ;
        if (liList.length === 0) {
            return null ;
        }
        for(var key in liList) {
            if (isNaN(key)) {
                break ;
            }
            var li = $(liList[key]) ;
            var liName = li.attr('name') ;
            var arr = liName.split('-') ;
            var id = arr[arr.length - 1] ;
            var a = li.children('a') ;
            var name = a.text() ;
            var item = {} ;
            item['id'] = id ;
            item['name'] = name ;
            factSetList[id] = item ;
        }
        return factSetList ;
    } ;
    /**
     * получить Id текущего множества
     * Id - последний компонент в имени setUl
     */
    this.getFactSetId = function() {
        if (setUl.length === 0) {  // наличие кнопки выбора множества
            return null ;
        }
        var name = setUl.attr('name') ;
        var arr = name.split('-') ;
        return arr[arr.length -1] ;
    } ;
    /**
     * создать элемент списка множеств
     * <li class="list-group-item" name="orderEdit-country-4"
     * onclick="simpleGeographyOnClick(&quot;orderEdit-country-4&quot;)">
     */
    var newLiSet = function(setId,setName) {
        var li = $('<li class="list-group-item" name="" onclick=""></li>') ;
        var elName = htmlPrefix + '-'+setTyp+'-' + setId ;
        li.attr('name',elName) ;
        var onclick = 'switchSet("'  + elName +'")' ;
        li.attr('onclick',onclick) ;
        var a = $('<a href="#" tabindex="-1">беларусь</a>') ;
        a.text(setName) ;
        li.append(a) ;
        return li ;
    } ;
    this.showCurrentSet = function(setId) {
        if (setBt.length == 0 || setUl.length == 0) {   // нет кнопки
            return ;
        }
        var setIdNow = getSetIdNow() ;
        if (setId == setIdNow) {
            //return true;
        }
        var liNew = getSetItemById(setId) ;
        var liNow = getSetItemById(setIdNow) ;
        var classNormal = 'list-group-item' ;
        var classActive = 'list-group-item active' ;
        if (liNow.length > 0) {
            liNow.attr('class',classNormal) ;
        }

        liNew.attr('class',classActive) ;
        if (liNew.length > 0) {
            var aa = liNew.children('a') ;
            var newName = aa.text() ;
            // меняем ссылку на тек элемент в setBt,setUl
            var newBtName = setTyp + '-' + setId ;
            setBt.attr('name',newBtName) ;
            setUl.attr('name',newBtName) ;
            //  надпись на кнопке set
            setBt.empty() ;
            setBt.append(newName + ' '+'<span class="caret"></span>')
        }
    } ;
    var getSetItemById = function(id) {
       return setUl.children('[name$="' + '-' + id +'"]') ;
    } ;
    // ид множества сейчас из setUl.name
    var getSetIdNow = function() {
        if(setUl.length === 0) {
            return null ;
        }
        var ulName = setUl.attr('name') ;
        var arr = ulName.split('-') ;
        return arr[arr.length-1] ;
    } ;
    /**
     * взять из
     */
    this.getNewSetElemName = function() {
        return newSetItemBt.attr('name') ;
    } ;
    /**
     * элемент множества - направление работ
     * <a class="btn btn-default" role="button" data-toggle="collapse" style="width:91%"
     id="<?=$htmlId?>" htmlPrefix-setItem-id
     aria-expanded="false" href="#<?=$htmlSubItemId?>" aria-expanded="true"
     aria-controls="<?=$htmlSubItemId?>"> htmlPrefix-subItem-id
     <?=$itemName?><strong><?=$fullyName?></strong><b class="caret"></b>
     </a>
     <button class="btn btn-default" role="button" title="<?=$btTitle?>" onclick="<?=$onClick?>" >
     <span class="<?=$editClass?>"></span>
     </button>
     <!--раскрывающаяся часть -->
     <ul class="list-group collapse" id="<?=$htmlSubItemId?>">
     <?php
     foreach($subItems as $ind => $subItemName) {
            echo '<li class="list-group-item">' . $subItemName . '</li>' ;
        }
     ?>
     </ul>
     * setItem = {id:  , name:   ,fullyFlag:  , subItems: [{id: ,name:}]}
     */
    this.showSetItem = function(setItem) {
        var setItemId = htmlPrefix + '-' +'setItem' + '-' + setItem['id'] ;
        var el = $('#' + setItemId) ;
        var showItem = (el.length > 0) ? el : newSetItem(setItem) ;
        // добавляем subItems
        var subItemsUl = el.children('ul') ;
        subItemsUl.empty() ;
        var subItems = setItem['subItems'] ;
        for (var key in subItems) {
            var subItem = subItems[key] ;
            var subItemId = subItem['id'] ;
            var subItemName = subItem['name'] ;
            var li = newSubItem(subItemId,subItemName) ;
            subItemsUl.append(li) ;
        }
    } ;
    /**
     * подсветка текущего элемента
     */
    this.setItemHighlight = function(setItemId) {
        var li = setItemsUl.find('[role="button"]') ;
        li.removeClass('setItemHighlight') ;
        var currentSetItem = setItemsUl.find('[id$="' + setItemId +'"]') ;
        if (currentSetItem.length > 0 ) {
            currentSetItem.addClass('setItemHighlight') ;
        }








    } ;

    var newSetItem = function(setItem) {
        var setItemId = setItem['id'] ;
        var setItemName = setItem['name'] ;
        var fullyFlag = setItem['fullyFlag'] ;
        fullyFlag = (typeof fullyFlag === "string") ? (fullyFlag == 'true') : fullyFlag ;
        var newId = htmlPrefix +'-' + 'setItem' + '-' + setItemId ;
        newItemLi.attr('id',newId) ;
        var newItemLi = $('<li></li>') ;
        newItemLi.attr('id',newId) ;
        newItemLi.data('fullyFlag',fullyFlag) ; // не видно
//        newItemLi[0].dataset.fullyFlag = fullyFlag ;
        var htmlSubItemId = htmlPrefix +'-' + 'subItem' + '-' + setItemId ;
        var newItemAa = $(
        ' <a class="btn btn-default" role="button"  ' +
        'data-toggle="collapse" style="width:91%" ' +
        'aria-expanded="false" href="#htmlSubItemId" aria-expanded="true" ' +
        'aria-controls="htmlPrefix-subItem-id" ' +
        '</a>') ;
        newItemAa.attr('href','#' + htmlSubItemId) ;
        newItemAa.attr('aria-controls', htmlSubItemId) ;
        var newFullyName = (fullyFlag) ? '<strong>' + fullyName +'</strong>' : '' ;
        newItemAa.append(setItemName + newFullyName +' <b class="caret"></b>') ;


        var newItemBtEdit = $('<button class="btn btn-default" role="button" ' +
        'title="btTitle" onclick="onClick" > ' +
        '</button>') ;
        var btEditOnClick = "setItemEdit('" + newId + "')" ;
        var newItemEditPicture = $('<span class="<?=$editClass?>"></span>') ;
        newItemBtEdit.append(newItemEditPicture) ;
        newItemBtEdit.attr('onclick',btEditOnClick) ;
        var newItemSubItemUl = $(
            '<ul class="list-group collapse" id="htmlSubItemId"></ul>') ;
        newItemSubItemUl.atr('id',htmlSubItemId) ;

        newItemLi.append(newItemAa) ;
        newItemLi.append(newItemBtEdit) ;
        newItemLi.append(newItemSubItemUl) ;
        return newItemLi ;
    } ;
    //------------------операции с setItemEdit - редавктирование эл-та ----//
    this.setItemEditMessage = function(message) {
        setItemEditMessage.empty() ;
        for (var rule in message) {
            var messageText = message[rule];
            for (var i = 0; i < messageText.length; i++) {
                setItemEditMessage.append(messageText[i] + '<br>');
            }
        }

    } ;
    this.setItemEditMessageClear = function(message) {
        setItemEditMessage.empty() ;
    } ;
    /**
     * показать редактируемый элемент
     * * <a class="btn btn-default" role="button" data-toggle="collapse" style="width:82%"
     aria-expanded="true" href="#htmlPrefix + '-editSetItem-collapse"
     aria-controls="htmlPrefix + '-editSetItem-collapse" id="'#'+ htmlPrefix + '-editSetItem-ul'"
      data-fully="false" data-delete="false">
     <span> Свердловская обл.</span><b class="caret"></b>
     </a>
     <a class="btn btn-default" role="button" title="region fully in work geography">
     <span class="glyphicon glyphicon-share" id="htmlPrefix + '-editSetItem-fully"
     onclick="workRegionStat('fully')"></span>
     </a>
     <a class="btn btn-default" role="button" title="region removed from work gegraphy">
     <span class="glyphicon glyphicon-minus" id="htmlPrefix + '-editSetItem-delete"
     onclick="workRegionStat('delete')"></span>
     </a>

      * @param id   - setItemId
     * @param name - setItemName
     * @param fullyFlag - флаг полного включения компонентов
     * @param deleteFlag - флаг удаления
     */
    this.setItemEditNode = function(id,name,fullyFlag,deleteFlag) {
        setItemEditArea.removeAttr('hidden') ;
        var btEdit = setItemEditBt ;
        var ulEdit = setItemEditUl ;
        btEdit.data('fullyFlag',
            (typeof(fullyFlag) !== "string") ? fullyFlag.toString() : fullyFlag) ;
        btEdit.data('deleteFlag',
            (typeof(deleteFlag) !== "string") ? deleteFlag.toString() : deleteFlag) ;
        var span = btEdit.children('span') ;
        span.text(name) ;
        var htmlName = htmlPrefix + '-' + 'workDirection' + '-' + id ;
        btEdit.attr('name',htmlName) ;
        ulEdit.attr('name',htmlName) ;
        _this.setItemEditBtShow('fully',fullyFlag) ;
        _this.setItemEditBtShow('delete',deleteFlag) ;
    };
    /**
     * кнопки редактирования элемента
     */
    this.setItemEditBtShow = function(type, flag) {
        var tooltipFully = $('#' + htmlPrefix + '-tooltips [name="itemFully"]') ;
        var fullyYes = tooltipFully.data('yes') ;
        var fullyNo = tooltipFully.data('no') ;

        var tooltipDelete = $('#' + htmlPrefix + '-tooltips [name="itemDelete"]') ;
        var deleteYes = tooltipDelete.data('yes') ;
        var deleteNo = tooltipDelete.data('no') ;

        var bt = (type === 'fully') ? setItemEditFullyBt : setItemEditDeleteBt ;
        var flagBool = (typeof(flag) == 'string' ) ? (flag === 'true') : flag ;
        var alternate = (flagBool) ? 'yes' : 'no';
        var fullyBt = {
            yes: {
                btClass : 'btn btn-default',
                class: 'glyphicon glyphicon-briefcase',
                title: fullyYes
            },
            no: {
                btClass : 'btn btn-default',
                class: 'glyphicon glyphicon-share',
                title: fullyNo

            }
        };
        var deleteBt = {
            yes: {
                btClass : 'btn btn-danger',
                class: 'glyphicon glyphicon-minus',
                title: deleteYes
            },
            no: {
                btClass : 'btn btn-default',
                class: 'glyphicon glyphicon-plus',
                title: deleteNo
            }
        };
        var currentBt = (type === 'fully') ? fullyBt[alternate] : deleteBt[alternate];
        bt.attr('title', currentBt['title']);
        bt.attr('class', currentBt['btClass']);
        bt.data('toggle',"tooltip") ;
        bt.data('placement',"left") ;
        var span = bt.children('span');
        span.attr('class', currentBt['class']);

    } ;
    /**
     *
     * @param subItems
     */
    this.setItemEditUlShow = function(subItems) {

        var ulEdit = setItemEditUl ;
        ulEdit.empty();
        for (var key in subItems) {
            var subItem = subItems[key];
            var li = newItemEditSubItem(subItem);
            ulEdit.append(li);
        }
        // имя региона с характеристикой data-fully data_delete
        $('#workRegionEdit-area').removeAttr('hidden');
    } ;
    /**
    <li class="list-group-item" name="city-[city_id]" >Нижний тагил
    <a class="btn btn-default btn-sm" role="button" title="city is in work"
    onclick="workRegionCityStat(city_id)">
    <span class="glyphicon glyphicon-ok"></span>
    </a></li>
    */
    var newItemEditSubItem = function(subItem) {

        var tooltipInWork = $('#' + htmlPrefix + '-tooltips [name="subItemInWork"]') ;
        var titleInWork = tooltipInWork.data('yes') ;
        var titleRemove = tooltipInWork.data('no') ;



        var id = subItem['id'];
        var name = subItem['name'];
        var inWorkCurrent = subItem['inWorkCurrent'];
        var inWorkNow = subItem['inWorkNow'];
        var aa = $('<a class="btn btn-default btn-xs" role="button" title="work is active" ' +
        'onclick="setSubItemStat(id)">');
        var spanInWork = '<span class="glyphicon glyphicon-ok"></span>';
        var spanRemove = '<span class="glyphicon glyphicon-remove"></span>';
        inWorkCurrent = (typeof(inWorkCurrent) === 'string' ) ?
            (inWorkCurrent == 'true') : inWorkCurrent ;
        var span = (inWorkCurrent) ? spanInWork : spanRemove;
        if(inWorkCurrent) {
            aa.attr('class','btn btn-success btn-xs') ;
        }
        aa.append(span);
        var onClick = "setSubItemStat('" + htmlPrefix + '-' + id + "')";
        aa.attr('onclick', onClick);
        var title = (inWorkCurrent) ? titleInWork : titleRemove;
        aa.attr('title', title);
        //----------------------------------------------------//
        var li = $('<li class="list-group-item" name="city-[city_id]" ' +
        'style="white-space:normal;overflow:auto"></li>');
        li.attr('name', htmlPrefix + '-' + 'subItem-' + id);
        li.data('inWorkCurrent',inWorkCurrent);
        li.append('<div class="col-md-11">' + name + '</div>');
        li.append(aa);
        return li;
    } ;

    /**
     * статус элемента
     */
    this.setItemEditStat = function() {

    } ;
    /**
     * переключить флаг принадлежности списку
     * @param subItemId
     * @param inWorkFlag
     */
    this.setSubItemStat = function(subItemId,inWorkFlag) {
        var ulEdit = setItemEditUl ;
        var li = ulEdit.children('[name$="' + subItemId +'"]') ;

        li.data('inWorkCurrent',inWorkFlag);
        var aa = li.children('a') ;
        var spanInWorkClass = "glyphicon glyphicon-ok";
        var spanRemoveClass = "glyphicon glyphicon-remove" ;
        var inWorkCurrent = (typeof(inWorkFlag) === 'string' ) ?
            (inWorkFLag == 'true') : inWorkFlag ;
        var spanClass = (inWorkCurrent) ? spanInWorkClass : spanRemoveClass;
        if(inWorkCurrent) {
            aa.attr('class','btn btn-success btn-xs') ;
        }else {
            aa.attr('class','btn btn-default btn-xs') ;
        }
        var span = aa.children('span') ;
        span.attr('class',spanClass) ;


    } ;

    /**
     * замена id в имени элемента
     * id - последняя компонента имени
     * @param name
     * @param newId
     */
    var putInNameNewId = function (name,newId) {
       var arr = name.split('-') ;
       var newName = arr[0] ;
       var ln = arr.length ;
       for (var i = 1; i < ln - 1; i++) {
           newName += '-' + arr[i] ;
       }
       newName += '-' + newId ;
       return newName ;
    } ;
    /**
     * имена на кнопках, устанавливающих новый элемент
     * строится комбинация из атрибутов кнопки id,name
     * @return {set:{id:*, name:*},setItem: {id:*, name:*}}
     */
    this.getNewSetItemSelector = function() {
        var res = {set:{id:null, name:null},setItem: {id:null, name:null} } ;
        var component = {id:null, name:null} ;
        if (newSetBt.length > 0) {
            res.set =  getNewSetItemComponent(newSetBt) ;
        }
        if (newSetItemBt.length > 0) {
            res.setItem =  getNewSetItemComponent(newSetItemBt) ;
        }
        return res ;
    } ;
    var getNewSetItemComponent = function(bt) {
        var componentName = bt.text() ;
        var btName = bt.attr('name') ;
        var arr = (bt.attr('name')).split('-') ;
        var componentId = arr[arr.length -1] ;
        return {id: componentId, name: componentName} ;
    } ;
    /**
     * переключить элементы (id сделать текущим)
     * @param setItemId
     * определяет выбор кнопки и списка, задающих множество(верхний уровень)
     */
    // this.setItemToggle = function(selectedId,newFlag) {
    this.setItemToggle = function(setItemId,setId) {
        if (extFunctions['newSetItemToggle'] !== null &&
            extFunctions['newSetItemToggle'] !== undefined) {
            var par = {newSetBtName: null,
                       newSetItemBtName: null} ;
            var newSetBtName = null ;
            var newSetItemBtName = null ;
            if (newSetBt.length > 0) {
                newSetBtName = putInNameNewId(newSetBt.attr('id'),setId) ;
            }
            if (newSetItemBt.length > 0) {
                newSetItemBtName = putInNameNewId(newSetItemBt.attr('id'),setItemId) ;
            }
            par.newSetBtName = newSetBtName ;
            par.newSetItemBtName = newSetItemBtName ;

            var funcName = extFunctions['newSetItemToggle'] ;
            extFunctionDo(funcName,par) ;
            return ;
        }




        var newFlag = true  ;
        var bt = '';      // кнопка с именем
        var ul = '' ;      // связанный список
        var imgShow = undefined ;    // картинка

        // if (!newFlag) {
        //     bt = setBt;      // кнопка с именем
        //     ul = setUl ;      // связанный список
        // }else {
            bt = newSetItemBt;      // кнопка с именем
            ul = newSetItemUl ;      // связанный список
            imgShow = newSetItemImg;    // картинка

        // }
        //var bt = newSetItemBt;      // кнопка с именем
        //var ul = newSetItemUl ;      // связанный список
        //var imgShow = newSetItemImg;    // картинка

        var ulName = ul.attr('name') ;
        var arr = ulName.split('-') ;
        //var htmlPrefix = arr[0] ;
        var selectedType = arr[arr.length-2] ;
        var currentId = arr[arr.length-1] ;
        if (setItemId === currentId) {     // нет изменений
            return ;
        }
        // убрать старую отметку








        var liPrev = ul.children(
        ' [name$="' +  ulName + '"]') ;
        liPrev.attr('class','list-group-item') ;
        var newName = htmlPrefix + '-' + selectedType + '-' + setItemId ;
        var li = ul.children(' [name="' +  newName + '"]') ;
        li.attr('class','list-group-item active') ;
        var li_a = li.children()[0] ;
        var liNodeName = li_a.textContent ;
        if (imgShow !== undefined) {
            var liImg = li.data('img') ;
            imgShow.attr('src',imgShow.data('dir') + liImg) ;
        }

//        var span = bt.find('span .caret') ;
// новое имя на кнопку
        bt.empty() ;
        bt.append(liNodeName +  ' ') ;
        bt.append('<span class="caret"></span>') ;
        bt.attr('name',newName) ;
        ul.attr('name',newName) ;

    };
    var extFunctionDo = function (funcName,par) {
       switch (funcName) {
           case 'geographySetItemToggle' :
               geographySetItemToggle(par) ;
               break ;
       }
    } ;
    /**
     * кнопка переключения уровня показа: только отмеченные / все
     * @param onlySelectedShow
     */
    this.setSubItemsOnlySelectedShowBt = function(onlySelectedShow) {

        var rootNode = setItemEditPanel ;
        var bt = rootNode.find('[name="toolbar-coveredEye"]') ;
        if (bt.length === 0) {
            return ;
        }

        var pictClass = (onlySelectedShow) ? bt.data('imgYes') : bt.data('imgNo') ;
        var pictNode = $('<i class=""></i>') ;
        pictNode.addClass(pictClass) ;
        bt.empty() ;
        bt.append(pictNode) ;
    };
    this.setItemsClear = function() {
        setItemsUl.empty() ;
    } ;
    /**
     * удалить элемент в список имеющихся
     */
    this.delSetItem = function(setitemId) {
        var ul = setItemsUl ;
        var setItem = $('#' + htmlPrefix + '-' + setitemId) ;
        if (setItem.length > 0) {
            setItem.remove() ;
        }
        var subItems = $('#' +  htmlPrefix + '-' + setitemId + '-subitems') ;
        if (subItems.length > 0) {
            subItems.remove() ;
        }
        var btEdit = $('#' + htmlPrefix + '-' + setitemId + '-edit-bt') ;
        if (btEdit.length > 0) {
            btEdit.remove() ;
        }
    } ;
    /**
     * добавить элемент в список имеющихся
     * <!--Голова списка-->
     <a class="btn btn-default" role="button" data-toggle="collapse" style="width:91%;white-space:normal"
     id="<?=$htmlId?>"
     aria-expanded="false" href="#<?=$htmlSubItemId?>" aria-expanded="true"
     aria-controls="<?=$htmlSubItemId?>">
     <?=$itemName?><strong><?=$fullyName?></strong><b class="caret"></b>
     </a>
     <button class="btn btn-default" role="button" title="<?=$btTitle?>" onclick="<?=$onClick?>"
     id="<?=$htmlId . '-edit-bt'?>">
     <span class="<?=$editClass?>"></span>
     </button>
     <!--раскрывающаяся часть -->
     <ul class="list-group collapse" id="<?=$htmlSubItemId?>">
     <?php
     if (sizeof($subItems) >0) {
        foreach($subItems as $ind => $subItemName) {
            echo '<li class="list-group-item" style="white-space:normal">' . $subItemName . '</li>' ;
        }
    }
     ?>
     </ul>
     * @par setItem - {id:   , name:  , fullyFlag: }
     * @par subItems
     * @par buttons - список кнопок, выводимых рядом с элементов
     * если buttons == undefined, то по умолчанию кнопка edit
     */
    this.addSetItem = function(setItem,subItems,buttons) {
        var nodeId = htmlPrefix + '-' + setItem['id'] ;
        var setItemNode = $('#' + nodeId) ;
        var newItem = (setItemNode.length == 0) ;
        var setItemDiv = '' ;
        if (setItemNode.length == 0) {
            setItemDiv = $('<div class="row"></div>') ;
            setItemNode = $(
                '<a class="btn btn-default" role="button" data-toggle="collapse" ' +
                'style="width:90%;white-space:normal" ' +
                'id="<?=$htmlId?>"  ' +
                'aria-expanded="false" href="#<?=$htmlSubItemId?>" aria-expanded="true" ' +
                'aria-controls="<?=$htmlSubItemId?>"> ' +
                '<?=$itemName?><strong><?=$fullyName?></strong><b class="caret"></b> ' +
                '</a>'
            ) ;
            setItemNode.attr('id',nodeId) ;
            var subItemsId = nodeId + '-subitems' ;
            setItemNode.attr('href','#' + subItemsId) ;
            setItemNode.attr('aria-controls',subItemsId) ;
            setItemDiv.append(setItemNode) ;
            //setItemDiv.append('&nbsp;') ;
            //setItemDiv.append(editBt) ;

            if (buttons === undefined) {
                buttons = {
                    edit: {
                        pictureClass: 'glyphicon glyphicon-edit',
                        onClick: 'setItemEdit',
                        btnClass: 'btn-default',
                        btTitle: 'click for edit',
                        btClass: 'btn-primary'
                    }
                } ;
            }
            var len = (Object.keys(buttons)).length ;
            var w = 100 - 8 * len -1 ;

            setItemNode.css('width',w  + '%') ;   // эмперическая формула
            for (var btKey in buttons) {
                var bt = setItemButtonBuild(btKey,buttons[btKey],nodeId) ;
                setItemDiv.append('&nbsp;') ;
                setItemDiv.append(bt) ;
            }


            //var editBt = $(
            //    '<button class="btn btn-default" role="button" title="click for edit" ' +
            //    'onclick="<?=$onClick?>"  ' +
            //    ' id="$htmlId . edit-bt">  ' +
            //    '<span class="glyphicon glyphicon-edit"></span> ' +
            //    '</button>'
            //) ;
            //editBt.attr('id',nodeId + '-edit-bt') ;
            //var onclick = "setItemEdit('" + nodeId + "')" ;
            //editBt.attr('onclick',onclick) ;

// смотри здесь !!!!!!!!!!!!!!!


            setItemsUl.append(setItemDiv) ;
            //setItemsUl.append(setItemNode) ;
            //setItemsUl.append('&nbsp;') ;
            //setItemsUl.append(editBt) ;


        }

        var nodeText = setItem['name'] +
            ((setItem['fullyFlag']) ? '<strong>(полностью)</strong>' : '') +
            '<b class="caret"></b>' ;
        setItemNode.empty() ;
        setItemNode.append(nodeText) ;

        var subItemsNode = $('#' + nodeId + '-subitems') ;
        if (subItemsNode.length == 0) {
            subItemsNode = $('' +
            '<ul class="list-group collapse" id="<?=$htmlSubItemId?>">') ;
            subItemsNode.attr('id',nodeId + '-subitems') ;
        }
        subItemsNode.empty() ;
        for (var ind in subItems) {
            var subItem = subItems[ind] ;
            var li = $('<li class="list-group-item" style="white-space:normal"></li>') ;
            name = (typeof(subItem) === "object" ) ? subItem['name'] : subItem ;
            li.append(name) ;
            subItemsNode.append(li) ;
        }
        var subId = subItemsNode.attr('id') ;



        if ((setItemsUl.find('#'+subId)).length === 0 ) {
//            setItemsUl.append(subItemsNode) ;
            setItemDiv.append(subItemsNode) ;

        }


    } ;
    /**
     * сформировать группу кнопок рядом с элементом
     * @param buttonDes =
     * {
     *                   pictureClass: 'glyphicon glyphicon-edit',
     *                   onClick: 'setItemEdit',
     *                   btnClass: 'btn-default',
     *                   title: 'click for edit'
     *   }
     * @param setItemNodeId
     */
    var setItemButtonBuild = function(btKey,buttonDes,setItemNodeId) {

        var pictureClass = buttonDes.pictureClass;
        var onClick = buttonDes.onClick;
        var btClass = buttonDes.btClass;
        var title = buttonDes.btTitle;
        var disabledFlag = (buttonDes['disabled'] === undefined) ? false : buttonDes['disabled'] ;
        if (typeof(disabledFlag) === 'string') {
            disabledFlag = (disabledFlag === 'true') ;
        }
        var span = $('<span></span>') ;
        span.addClass(pictureClass) ;
        var bt = $(
            '<button class="btn" role="button" title="click for edit" ' +
            'onclick="<?=$onClick?>"  ' +
            ' id="$htmlId . edit-bt">  ' +
            '</button>'
        ) ;
        bt.addClass(btClass) ;
        var onclick = onClick + "('" +setItemNodeId + "')" ;
        bt.attr('onclick',onclick) ;
        bt.attr('title',title) ;
        bt.attr('id',setItemNodeId + '-' + btKey + '-bt' ) ;
        if (disabledFlag) {
            bt.attr('disabled','disabled') ;
        }
        bt.append(span) ;
        return bt ;
    } ;
  }


//====================workDirectionAjax=====================//
/**
 * Взаимодействие с БД. подготовка, отправление и приём сообщений
 */
function WorkDirectionEditAjax() {
    var urlController = 'work-direction' ;
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
     * @param params
     */

    var addNewSetAjaxParam = function(params)  {

    };
    /**
     *
     * @param params={setId:id, setName: name}
     * @returns {{opCod: string, url: string, data: {workDirection: *, workItems: *}}}
     */
     var getSetItemsFactAjaxParam = function(params) {
         var url = 'index.php?r=' + urlController + '%2Fget-fact-work-direction' ;
         var opCod = 'getFactWorkDirection' ;
         var data = {
             workDirectionId : params['setId']
         } ;
         return {
             opCod : opCod,
             url : url,
             data: data
         } ;

     } ;
    /**
     *
     * @param params = {setItem: currentSetItem, subItems: subItemsForSend}
     */
    var saveSetItemGetAjaxParam = function(params) {
//        var url = 'index.php?r=work-direction%2Fsave-work-direction' ;
        var url = 'index.php?r=' + urlController + '%2Fsave-work-direction' ;
        var opCod = 'saveWorkDirection' ;
        var data = {
            workDirection : params['setItem'],
            workItems: params['subItems']
        } ;
        return {
            opCod : opCod,
            url : url,
            data: data
        } ;

    } ;
    /**
     * получить список связанных элементов
     * @param params = {id:..}
     */
    var getSubItemsGetAjaxParam = function(params) {
//        var url = 'index.php?r=work-direction%2Fget-work-items' ;
        var url = 'index.php?r=' + urlController + '%2Fget-work-items' ;
        var opCod = 'getWorkItems' ;
        var data = {
            workDirectionId : params['id']
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
     * массив элементов надо привести к виду {id:   , name: ,fullyFlag: }
     * @param rr
     */
    var getSetItemsFactParseAjaxRes = function(rr) {
        var success = rr['success'] ;
        var factWorkDirectionList = rr['factWorkDirectionList'] ;
        var setItemList = [] ;
        for (var key in factWorkDirectionList) {
            var item = factWorkDirectionList[key] ;
            var id = item['work_direction_id'] ;
            var fullyFlag = item['fully_flag'] ;
            fullyFlag = (typeof(fullyFlag) === 'string') ?
                 (fullyFlag === 'true' || fullyFlag == '1') : fullyFlag ;

            var name = item['workDirection']['name_ru'] ;
            var newElem = {} ;
            newElem['id'] = id ;
            newElem['name'] = name ;
            newElem['fullyFlag'] = fullyFlag ;
            setItemList.push(newElem) ;
        }
        return {success: success, setItemList: setItemList} ;

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

    var getSubItemsSimpleParseAjaxRes = function(rr) {
        var success = rr['success'] ;
        var dWorkDirection = rr['developerWorkDirection'] ;
        var wdItemName = dWorkDirection['workDirection']['name_ru'] ;
        var fullyFlag  = (dWorkDirection['fully_flag'] === '1') ;
        var wdItem = {
            //workDirectionId: dWorkDirection['work_direction_id'],
            //id: dWorkDirection['id'],
            id: dWorkDirection['work_direction_id'],
            fullyFlag: fullyFlag,
            name: wdItemName
        } ;
        var workList = rr['workItemList'] ;     // полный список по направлению
        var workListFact = rr['developerWorkItemList'] ; // фактический список по направлению
        var subItemsFact = [] ;
        for (var ind in workListFact) {
            var workItem = workListFact[ind]['workItem'] ;
            var subItem = {
                id: workItem['id'],
                name: workItem['name_ru']
            } ;
            subItemsFact.push(subItem) ;
        }

        var buttons = buttonsForSubItems ;


        return {success:success, setItem: wdItem,
            subItemsList: workList, subItemsFactList: subItemsFact, buttons:buttons} ;
    } ;

}
//=========================================================//
//==========действия от элементов html document============//
// все действия переадресуются  контроллеру //
function getIdFromElemName(elem) {
    var arr = elem.split('-') ;
    var res = {id: null , topology : null} ;
    if ((arr.length > 0)) {
        res['id'] = arr[arr.length -1] ;
        res['context'] = arr[0] ;
    }
    return res;
}
/**
 * переключить множество
 * @param elem
 */
function switchSet(elem) {
    var r = getIdFromElemName(elem) ;
    var id = r['id'] ;
    var contextName = r['context'] ;
    var controller = paramSet.getController(contextName) ;
    controller.switchSet(id) ;
}
/**
 * редавктировать элемент множества
 * @param elem
 */
function setItemEdit(elem) {
    newSetItemToggle(elem) ;                    // перключаем для однозначности
    var r = getIdFromElemName(elem) ;
    var id = r['id'] ;
    var contextName = r['context'] ;
    var controller = paramSet.getController(contextName) ;
    controller.setItemEdit(id) ;

}
/**
 * переключить элемент из списка
 * текущий элемент
 * кнопка с именем newSetItemBt,
 * список значений  newSetItemUl
 * @param elem = htmlPrefix - ... - id
 */
function newSetItemToggle(elem) {
    // newFlag = (newFlag === undefined) ? true : newFlag ;
    var r = getIdFromElemName(elem) ;
    var id = r['id'] ;
    var contextName = r['context'] ;
    var controller = paramSet.getController(contextName) ;
    controller.setItemToggle(id) ;

}
/**
 * добавить ноый элемент - кнопка + в правой части
 */
function addNewSetItem(contextName) {
    var controller = paramSet.getController(contextName) ;
    controller.addNewSetItem() ;
}
/**
 * изменить статус (fully, delete)
 * @param statName
 */
function setItemStat(elem) {
    var r = getIdFromElemName(elem) ;
    var type = r['id'] ;
    var contextName = r['context'] ;
    var controller = paramSet.getController(contextName) ;
    controller.setItemStat(type) ;

}
/**
 * изменить статус (включено/выключено)
 * @param statName
 */
function setSubItemStat(elem) {
    var r = getIdFromElemName(elem) ;
    var id = r['id'] ;
    var contextName = r['context'] ;
    var controller = paramSet.getController(contextName) ;
    controller.setSubItemStat(id) ;
}
/**
 * режим отображения : все или отмеченные
 * @param elem
 */
function setSubItemsShowStat(elem) {
    var r = getIdFromElemName(elem) ;
    var contextName = r['context'] ;
    var controller = paramSet.getController(contextName) ;
    controller.setSubItemsOnlySelectedShow() ;
}
/**
 * сохранить изменения в setItem
 * изменения касаются списка отмеченных подэлементов
 * кнопка save
 * @param elem
 */
function setItemSave(elem) {
    var r = getIdFromElemName(elem) ;
    var contextName = r['context'] ;
    var controller = paramSet.getController(contextName) ;
    controller.setItemSave() ;
}
/**
 * выбор через картинку
 * @param elem
 */
function newSetItemPictureToggle(elem) {
    var tmpTimer = setTimeout(function () {
        $('#' + elem).click() ;
        clearTimeout(tmpTimer) ;
    }, 50);
}