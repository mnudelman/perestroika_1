/**
 * ИСПОЛНИТЕЛЬ ЗАКАЗА
 * по аналогии с orderMailing
 */
/**
 * объект - ИСПОЛНИТЕЛЬ ЗАКАЗОВ
 * @constructor
 */
function DeveloperOrders() {
    var contextName ;               // это htmlPrefix для элементов страницы
    var htmlContext ;
    var ajaxExe ;
    var urlPrefix = 'index.php?r=' + 'developer-orders' + '%2F' ;
    var url = {
        setFilter: urlPrefix + 'set-filter',
        getFilter: urlPrefix + 'get-filter',
        orderMAilingGo: urlPrefix + 'send-email',
        orderToggleStat: urlPrefix + 'order-new-stat'
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
            htmlContext.messageClear('filter') ;
            htmlContext.showMessage('filter',type,message) ;
        }
        if (success) {
            var orderList = rr['orderList'] ;
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
     * поставить/отменить ИСПОЛНИТЕЛЯ_ЗАКАЗА
     * @param developerId
     */
    //this.orderSelect = function(developerId) {
    //    var opCod = 'orderSelect' ;
    //    var data = {
    //        opCod : opCod,
    //        developerId : developerId
    //    } ;
    //    ajaxExe.setUrl(url.orderSelect) ;
    //    ajaxExe.setData(data) ;
    //    ajaxExe.setCallback(orderSelectedRes) ;
    //    ajaxExe.go() ;
    //
    //} ;
    /**
     * переключение состояния заказа
     * @param toggleDirect
     * @param orderId
     */
    this.toggleStat = function(toggleDirect,orderId) {
        var opCod = 'toggleStat' ;
        var data = {
            opCod : opCod,
            toggleDirect: toggleDirect,
            orderId : orderId
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
    }
}
/**
 * объект - вывод элементов
 * @constructor
 */
function DeveloperOrdersHtml() {
    var htmlPrefix ;
    var formName = 'orderwork' ;
    var orderFormId = 'developer-orders-filter-form' ;
    var _this = this ;
    var filterNode = $('#' + htmlPrefix + '-filter') ;

    var filterFormPrefix = 'developerordersfilterform' ;
    var filterFormId = 'work-order-filter-form' ;
    var orderFilterNodes = {
        perBeg: $('#' + filterFormPrefix + '-perbeg'),
        perEnd: $('#' + filterFormPrefix + '-perend'),
        responseStat: $('#' + filterFormPrefix + '-responsestat')
    } ;
    var messageDiv = {
        filter: {
            success: $('#' + filterFormId).find('[name="form-messages-success"]'),
            error : $('#' + filterFormId).find('[name="form-messages-error"]')
        }
    } ;

    //----------------------------------------//
    this.init = function (contextName) {
        htmlPrefix = contextName ;
        filterNode = $('#' + htmlPrefix + '-filter') ;

    };
    this.getFilter = function() {
        var perBegNode = orderFilterNodes.perBeg ;
        var perEndNode = orderFilterNodes.perEnd ;
        var responseStatNode = orderFilterNodes.responseStat;
        return {
            perBeg: perBegNode.val(),
            perEnd: perEndNode.val(),
            responseStat: (responseStatNode[0]).checked
        } ;
    } ;
    this.showFilter = function(filter) {
        filterNode.show(500) ;
        var perBeg = filter['perBeg'] ;
        var perEnd = filter['perEnd'] ;
        var responseStat = filter['responseStat'] ;
        var perBegNode = orderFilterNodes.perBeg ;
        var perEndNode = orderFilterNodes.perEnd ;
        var responseStatNode = orderFilterNodes.responseStat ;
        perBegNode.val(perBeg) ;
        perEndNode.val(perEnd) ;
        responseStatNode[0].checked = responseStat ;

    } ;
    this.hideFilter = function() {
        filterNode.hide(500) ;
    } ;

    this.messageClear = function(formName) {

        var msgDiv = messageDiv[formName] ;

        for (var key in msgDiv) {
            var message = msgDiv[key] ;
            message.empty() ;
        }
    } ;
    this.showMessage = function(formName,messageType,messages) {
        var msgDiv = messageDiv[formName] ;
        var msgDiv = messageDiv[formName][messageType] ;
        msgDiv.empty() ;
        for (var key in messages) {
            var messageText = messages[key] ;
            var text = '<b>' + key + ':</b>' + ' ' + messageText + '<br>';
            msgDiv.append(text) ;
        }
    } ;
    /**
     * очистить саписок существующих заказов
     * вывести заново
     */
    this.newLeftPart = function(orderList) {
        var html = new WorkDirectionEditHtml() ;
        html.init(htmlPrefix) ;
        html.setItemsClear() ;
        for (var ind in orderList){
            var order = orderList[ind] ;
            var orderForShow = {
                id:order['id'],
                name:order['name'],
                fullyFlag: false,
                editFlag: true
            } ;
            var subItems = order['sumItems'] ;
            html.addSetItem(orderForShow,subItems) ;
        }
    } ;

}
