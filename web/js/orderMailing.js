/**
 * поддержка страницы "Рассылка заказа исполнителя"
 */
/**
 * вкл/выкл фильтр
 * @param elem(htmlPrefix-opCod)
 */
function dataFilter(elem) {

//    filterNode.show(600) ;
    var arr = elem.split('-') ;
    var contextName = arr[0] ;
    var opCod = arr[arr.length - 1] ;
    opCod = (opCod === undefined) ? 'edit' : opCod ;
    var filterNode = $('#' + contextName +'-filter') ;


    var controller = paramSet.getController(contextName) ;
    switch (opCod) {
        case 'save' :
            filterNode.hide(600) ;
            controller.setFilter() ;
            break ;
        case 'edit' :
            filterNode.show(600) ;
            controller.editFilter() ;
            break ; {

        }
    }

}
/**
 * вкл/выкл настройка
 * @param elem(htmlPrefix-opCod)
 */
function dataSetup(elem) {

//    filterNode.show(600) ;
    var arr = elem.split('-') ;
    var contextName = arr[0] ;
    var opCod = arr[arr.length - 1] ;
    opCod = (opCod === undefined) ? 'edit' : opCod ;
    var setupNode = $('#' + contextName +'-setup') ;


    var controller = paramSet.getController(contextName) ;
    switch (opCod) {
        case 'save' :
            setupNode.hide(600) ;
            controller.setSetup() ;
            break ;
        case 'edit' :
            setupNode.show(600) ;
            controller.editSetup() ;
            break ; {

        }
    }

}
/**
 * вкл/выкл посказка
 * @param elem(htmlPrefix-opCod)
 */
function dataRule(elem) {

//    filterNode.show(600) ;
    var arr = elem.split('-') ;
    var contextName = arr[0] ;
    var opCod = arr[arr.length - 1] ;
    opCod = (opCod === undefined) ? 'open' : opCod ;
    var ruleNode = $('#' + contextName +'-rule-accordion') ;


    switch (opCod) {
        case 'close' :
            ruleNode.hide(600) ;
            break ;
        case 'open' :
            ruleNode.show(600) ;
            break ; {

        }
    }

}

/**
 * выполнить рассылку
 */
function orderMailingGo(elem) {
    var arr = elem.split('-') ;
    var contextName = arr[0] ;
    var controller = paramSet.getController(contextName) ;
    controller.orderMailingGo() ;
}
/**
 * выбран элемент для пересылки
 * @param elem
 */
//function orderSelect(elem) {
//    var arr = elem.split('-') ;
//    var contextName = arr[0] ;
//    var userId = arr[arr.length - 1] ;
//    var controller = paramSet.getController(contextName) ;
//    controller.orderSelect(userId) ;
//
//}
/**
 * объект - рассылка заказов
 * @constructor
 */
function OrderMailing() {
    var contextName ;               // это htmlPrefix для элементов страницы
    var htmlContext ;
    var ajaxExe ;
    var urlPrefix = 'index.php?r=' + 'developer' + '%2F' ;
    var url = {
        profileShow: urlPrefix + 'profile-show',
        setFilter: urlPrefix + 'set-filter',
        getFilter: urlPrefix + 'get-filter',
        orderMAilingGo: urlPrefix + 'send-email',
        //orderSelect: urlPrefix + 'order-select',
        orderToggleStat: urlPrefix + 'order-new-stat',
        orderLock: urlPrefix + 'toggle-order-lock',
        setSetup:  urlPrefix + 'set-setup',
        getSetup:  urlPrefix + 'get-setup'
    } ;
    var lockBt ;   // кнопка lock
    var sendBt ;   // кнопка send
    var lockClass = {
        on: 'fa fa-lock',
        off: 'fa fa-unlock'
    } ;

    var _this = this ;
    //-------------------------------------------//
    this.init = function(ctxtName,context) {
        contextName = ctxtName;
        htmlContext = context['html'];
        htmlContext.init(contextName);
        ajaxExe = new AjaxExecutor(); // собственный исполнитель запроса
    } ;
    this.tabInit = function() {
        //paginationClick(contextName + '-1') ;    // на первую страницу
       _this.setFilter(true) ;
    } ;
    /**
     * переключение блокировки ЗАКАЗА
     * @param id
     */
    this.orderLock = function(id) {
        var opCod = 'orderLock' ;

        var data = {
            opCod : opCod
        } ;
        ajaxExe.setUrl(url.orderLock) ;
        ajaxExe.setData(data) ;
        ajaxExe.setCallback(orderLockRes) ;
        ajaxExe.go() ;

    } ;
    var orderLockRes = function(rr) {
        var success = rr['success'] ;
        if (rr['message'] !== undefined) {
            var message = rr['message'] ;
            var type = (success) ? 'success' : 'error' ;
            //htmlContext.messageClear('filter') ;
            //htmlContext.showMessage('filter',type,message) ;
        }
        if (success) {
            var orderLockFlag  = rr['orderLock'] ;
            if (typeof(orderLockFlag) === 'string') {
                orderLockFlag = (orderLockFlag === 'true') ;
            }
            htmlContext.showLockBt(orderLockFlag) ;
            paginationClick(contextName + '-0') ;    // на текущую страницу
        }

    } ;
    /**
     * сохранить фильтр
     * возможен пустой фильтр
     */
    this.setFilter = function(defaultFlag) {
        var opCod = 'setFilter' ;
        var filterData = false ;
        if (defaultFlag === undefined) {
           filterData = htmlContext.getFilter() ;
        }

        var data = {
            opCod : opCod,
            filter : filterData
        } ;
        ajaxExe.setUrl(url.setFilter) ;
        ajaxExe.setData(data) ;
        ajaxExe.setCallback(setFilterGo) ;
        ajaxExe.go() ;

    } ;
    var setFilterGo = function(rr) {
        var success = rr['success'] ;
        if (rr['message'] !== undefined) {
            var message = rr['message'] ;
            var type = (success) ? 'success' : 'error' ;
            //htmlContext.messageClear('filter') ;
            //htmlContext.showMessage('filter',type,message) ;
        }
        if (success) {
            var orderLockFlag  = rr['orderLock'] ;
            if (typeof(orderLockFlag) === 'string') {
                orderLockFlag = (orderLockFlag === 'true') ;
            }
            htmlContext.showLockBt(orderLockFlag) ;

//            var orderList = rr['orderList'] ;
//            htmlContext.newLeftPart(orderList) ;
            paginationClick(contextName + '-1') ;    // на первую страницу
            //htmlContext.hideFilter() ;
        }

    } ;
    /**
     * редактировать фильтр
     */
    this.editFilter = function() {
        var opCod = 'orderGetFilter' ;
        var filterData = htmlContext.getFilter() ;
        var data = {
            opCod : opCod,
            orderFilter : filterData
        } ;
        ajaxExe.setUrl(url.getFilter) ;
        ajaxExe.setData(data) ;
        ajaxExe.setCallback(getFilterGo) ;
        ajaxExe.go() ;

    } ;
    var getFilterGo = function(rr) {
        var filter = rr['filter'] ;
        htmlContext.showFilter(filter) ;
    } ;

    /**
     * редактировать настройку
     */
    this.editSetup = function() {
        var opCod = 'mailingGetSetup' ;
        var setupData = htmlContext.getSetup() ;
        var data = {
            opCod : opCod,
            orderFilter : setupData
        } ;
        ajaxExe.setUrl(url.getSetup) ;
        ajaxExe.setData(data) ;
        ajaxExe.setCallback(editSetupGo) ;
        ajaxExe.go() ;

    } ;
    var editSetupGo = function(rr) {
        var setup = rr['setup'] ;
        htmlContext.showSetup(setup) ;
    } ;


    /**
     * сохранить настройку
     */
    this.setSetup = function(defaultFlag) {
        var opCod = 'setSetup' ;
        var setupData = false ;
        if (defaultFlag === undefined) {
            setupData = htmlContext.getSetup() ;
        }

        var data = {
            opCod : opCod,
            setup : setupData
        } ;
        ajaxExe.setUrl(url.setSetup) ;
        ajaxExe.setData(data) ;
        ajaxExe.setCallback(setSetupGo) ;
        ajaxExe.go() ;

    } ;
    var setSetupGo = function(rr) {
        var success = rr['success'] ;
        if (rr['message'] !== undefined) {
            var message = rr['message'] ;
            var type = (success) ? 'success' : 'error' ;
            //htmlContext.messageClear('filter') ;
            //htmlContext.showMessage('filter',type,message) ;
        }
        if (success) {

//            var orderList = rr['orderList'] ;
//            htmlContext.newLeftPart(orderList) ;
            paginationClick(contextName + '-0') ;    // на первую страницу
            //htmlContext.hideFilter() ;
        }

    } ;


    /**
     * исполнить рассылку
     */
    this.orderMailingGo = function() {
        var data = {
            opCod : 'mailingGo'
        } ;
        ajaxExe.setUrl(url.orderMAilingGo) ;
        ajaxExe.setData(data) ;
        ajaxExe.setCallback(orderMailingRes) ;
        ajaxExe.go() ;
    } ;
    var orderMailingRes = function(rr) {
        paginationClick(contextName + '-0') ;    // перевывод тек страницы

        var success = rr['success'] ;
        var message = rr['message'] ;
        var title = 'Отправка уведомлений' ;


        showError(message,title) ;

    } ;
    /**
     * переключение состояния
     * @param toggleDirect
     * @param developerId
     */
    this.toggleStat = function(toggleDirect,developerId) {
        var opCod = 'toggleStat' ;
        var data = {
            opCod : opCod,
            toggleDirect: toggleDirect,
            developerId : developerId
        } ;
        ajaxExe.setUrl(url.orderToggleStat) ;
        ajaxExe.setData(data) ;
        ajaxExe.setCallback(orderToggleRes) ;
        ajaxExe.go() ;

    } ;
    /**
     * для текущей страницы - перевывод
     * @param rr
     */
    var orderToggleRes = function(rr) {
        var currentPage = rr['currentPage'] ;
        var elem = contextName + '-' + currentPage ;
        paginationClick(elem) ;
    } ;

}
/**
 * объект - вывод элементов
 * @constructor
 */
function OrderMailingHtml() {
    var htmlPrefix ;
    var filterNode ;
    var fieldWorkRankBt ;
    var fieldGeographyRankBt ;
    var fieldWorkRankUl ;
    var fieldGeographyRankUl ;
    var lockBt ;   // кнопка lock
    var sendBt ;   // кнопка send
    var lockClass = {
        on: 'fa fa-lock',
        off: 'fa fa-unlock'
    } ;
    var setupForm = 'mailingsetupform' ;
    var setupNodes = {
        autoSendFlag: $('#' + setupForm + '-autosendflag'),
        mailingNumberMax: $('#' + setupForm + '-mailingnumbermax'),
        deadline: $('#' + setupForm + '-deadline'),
        deadlineTime: $('#' + setupForm + '-deadlinetime'),
        currentTime : $('#' + setupForm + '-currenttime'),
        randSelectFlag: $('#' + setupForm + '-randselectflag')
    } ;
    //----------------------------------------//
    this.init = function(contextName) {
        htmlPrefix = contextName ;
        filterNode = $('#' + htmlPrefix + '-filter') ;
        fieldWorkRankBt = $('#' + htmlPrefix + '-workRank-bt') ;
        fieldGeographyRankBt = $('#' + htmlPrefix + '-geographyRank-bt') ;
        fieldWorkRankUl = $('#' + htmlPrefix + '-workRank-ul') ;
        fieldGeographyRankUl = $('#' + htmlPrefix + '-geographyRank-ul') ;
        lockBt = $('#' + htmlPrefix + '-lockBt') ;
        sendBt = $('#' + htmlPrefix + '-sendBt') ;

    } ;
    this.getFilter = function() {
        var workRankElem = fieldWorkRankBt.attr('name') ;
        var arr = workRankElem.split('-') ;
        var workRank = arr[arr.length -1] ;
        var geographyRankElem = fieldGeographyRankBt.attr('name') ;
        arr = geographyRankElem.split('-') ;
        var geographyRank = arr[arr.length -1] ;
       return {'workRank': workRank, geographyRank: geographyRank} ;
    } ;
    this.showFilter = function(filter) {
        var workRank = filter['workRank'];
        var geographyRank = filter['geographyRank'];
        var workName = htmlPrefix + '-workRank-' + workRank ;
        var geographyName = htmlPrefix + '-geographyRank-' + geographyRank ;
        var text = '' ;
        var liList = fieldWorkRankUl.children() ;
        changeBtName(fieldWorkRankBt,fieldWorkRankUl,liList,workName) ;
        liList =  fieldGeographyRankUl.children() ;
        changeBtName(fieldGeographyRankBt,fieldGeographyRankUl,liList,geographyName) ;
    } ;


    this.getSetup = function() {
        var autoSendFlagFld = setupNodes.autoSendFlag ;
        var mailingNumberMaxFld = setupNodes.mailingNumberMax ;
        var randSelectFlagFld = setupNodes.randSelectFlag ;
        var deadlineFld = setupNodes.deadline ;
        var deadlineTimeFld = setupNodes.deadlineTime ;
        var currentTimeFld = setupNodes.currentTime ;

        var setup = {
            autoSendFlag: autoSendFlagFld[0].checked,
            mailingNumberMax: mailingNumberMaxFld.val(),
            deadline: deadlineFld.val(),
            deadlineTime: deadlineTimeFld.val(),
            currentTime: currentTimeFld.val(),
            randSelectFlag: randSelectFlagFld[0].checked
        } ;
        return setup ;
    } ;
    this.showSetup = function(setup) {
        var autoSendFlagFld = setupNodes.autoSendFlag ;
        var mailingNumberMaxFld = setupNodes.mailingNumberMax ;
        var randSelectFlagFld = setupNodes.randSelectFlag ;
        var deadlineFld = setupNodes.deadline ;
        var deadlineTimeFld = setupNodes.deadlineTime ;
        var currentTimeFld = setupNodes.currentTime ;

        autoSendFlagFld[0].checked = setup.autoSendFlag ;
        mailingNumberMaxFld.val(setup.mailingNumberMax) ;
        randSelectFlagFld[0].checked = setup.randSelectFlag ;
        deadlineFld.val(setup.deadline) ;
        deadlineTimeFld.val(setup.deadlineTime) ;
        currentTimeFld.val(setup.currentTime) ;
    } ;

    /**
     * показать кнопку OrderLock
     * @param lockFlag
     */
    this.showLockBt = function(orderLockFlag) {
        var lockClassKey = (orderLockFlag) ? 'on' : 'off' ;
        var currentLockClass = lockClass[lockClassKey] ;
        var iNode = lockBt.children() ;
        iNode.attr('class',currentLockClass) ;
        var sendBtNode = sendBt[0] ;
        sendBtNode.disabled = orderLockFlag ;

    } ;
    /**
     * это для фильтра
     * @param bt
     * @param ul
     * @param liList
     * @param newActiveName
     */
    var changeBtName = function(bt,ul,liList,newActiveName) {
        var text = '' ;
        for(var i = 0; i < liList.length; i++) {
            var li = $(liList[i]) ;
            var liName = li.attr('name') ;
            var liCl = li.attr('class') ;
            if (liName === newActiveName) {
                text = li.text() ;
                if (liCl.indexOf('active') < 0) {
                    li.addClass('active') ;
                }
            }else {
                if (liCl.indexOf('active') >= 0) {
                    li.removeClass('active') ;
                }
            }
        }
        var span = bt.children('span') ;
        bt.attr('name',newActiveName) ;
        ul.attr('name',newActiveName) ;
        bt.text(text) ;
        bt.append(span) ;
    } ;

}