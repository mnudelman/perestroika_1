/**
 * Управление постраничным выводом
 */
function paginationClick(elem) {
    var arr = elem.split('-') ;
    var htmlPrefix = arr[0] ;
    var page = arr[arr.length -1] ;
    var controllerName = htmlPrefix + '-' + 'pagination' ;
    var controller = paramSet.getObj(controllerName) ;
    if (controller === null) {
        controller = new Pagination() ;
        controller.init(htmlPrefix) ;
        paramSet.putObj(controllerName,controller) ;
    }
    controller.newPage(page) ;
}
function Pagination() {
   var htmlPrefix ;
    var ajaxExe ;
    var currentPage = 1 ;     // текущая страница вывода
    var urlPrefix = {
        orderEdit :'index.php?r=' + 'order' + '%2F',
        orderEditMailing:'index.php?r=' + 'developer' + '%2F',
        officeDeveloperOrders: 'index.php?r=' + 'developer-orders' + '%2F'
    } ;
   var actionDefault = 'new-page' ;
   var action = {      // адреса контроллеров php
       orderEdit: 'new-page',
       orderEditMailing: 'new-page',
       officeDeveloperOrders: 'new-page'
   } ;
   var indexPagesBlock ;       // блок индекса страниц
   var _this = this ;
   //---------------------------------------//
   this.init = function(prefix) {
       htmlPrefix = prefix ;
       indexPagesBlock = $('#' + htmlPrefix +'-' +'pagination') ;
       ajaxExe = new AjaxExecutor() ; // собственный исполнитель запроса
   } ;
    /**
     * перключить на новую страницу
      * @param page -  если empty(page) -> вывод текущей страницы
     */
   this.newPage = function(page) {
       if (page == 0 || page === null || page === undefined) {
           page = currentPage ;
       }
       var opCod = 'newPage' ;
       var data = {
           opCod : opCod,
           page : page
       } ;
       var htmlPrefixAlias = getPrefixAlias() ;
       // var act = (action[htmlPrefix] === undefined) ? actionDefault : action[htmlPrefix] ;
       // var url = urlPrefix[htmlPrefix] + act ;

       var act = (action[htmlPrefixAlias] === undefined) ? actionDefault : action[htmlPrefixAlias] ;
       var url = urlPrefix[htmlPrefixAlias] + act ;


       ajaxExe.setUrl(url) ;
       ajaxExe.setData(data) ;
       ajaxExe.setCallback(newPageShow) ;
       ajaxExe.go() ;
   } ;
   var getPrefixAlias = function() {
       var alias = '' ;
       var htmlPrefixUpper = htmlPrefix.toUpperCase() ;
        for (var key in urlPrefix) {
            if (htmlPrefixUpper.indexOf(key.toUpperCase()) >= 0) {
                if (key.length > alias.length) {
                    alias = key ;
                }
            }
        }
        return alias ;
   } ;
   var newPageShow = function(rr) {
       var html = new WorkDirectionEditHtml() ;
       html.init(htmlPrefix) ;
       html.setItemsClear() ;
       var orderList = rr['orderList'] ;
       var listItems = rr['listItems'] ;
       var indexPages = rr['indexPages'] ;
       var buttons = (rr['buttons'] == undefined) ? undefined : rr['buttons'] ;
       for (var ind in listItems){
           var order = listItems[ind] ;
           var orderForShow = {
               id:order['id'],
               name:order['name'],
               fullyFlag: false,
               editFlag: true
           } ;
           var subItems = order['subItems'] ;
           buttons = (order['buttons'] == undefined) ? undefined : order['buttons'] ;
           html.addSetItem(orderForShow,subItems,buttons) ;
       }
       indexPagesShow(indexPages) ;
   } ;
    /**
     *  структура на входе:
     *'currentPage'  - текущая страница
     *'firstFlag'  - ссылка на первую страницу
     *'*prevFlag'  - ссылка на предшеств  страницу
     *'indexPages' - [pge1,page2,...] -  список номеров страниц для показа
     *'nextFlag'  // ссылка на след  страницу
     *'lastFlag'  // ссылка на последнюю страницу
     * @param indexPages
     <li <?=$active?> name="numPoint"
     onclick="paginationClick('<?=$htmlPrefix?>-<?=$pageIndex?>')">
     <a href="#">
     <?= $pageIndex ?></a></li>

     */
   var indexPagesShow = function(indexPages)  {
        var numberPoints = indexPagesBlock.children('[name="numPoint"]') ;
        numberPoints.remove() ;
//      var firstPoint =  indexPagesBlock.children('[name="firstPoint"') ;
        var pointList = ['first','prev','next','last'] ;
        for (var i = 0; i < pointList.length ; i++) {
            var pointName = pointList[i] + 'Point' ;
            var point = indexPagesBlock.children('[name="' + pointName + '"]') ;
            if (indexPages[pointList[i] + 'Flag']) {
                point.removeAttr('class') ;
            }else {
                point.attr('class','disabled') ;
            }
        }
        var currentPage = indexPages['currentPage'] ;
        var pages = indexPages['indexPages'] ;
        var targetNode = indexPagesBlock.children('[name="nextPoint"]') ;
        for (i = 0; i < pages.length; i++) {
            var page = pages[i] ;
            if (page < 0) {
                continue ;
            }
            var li = $('<li name="numPoint"></li>') ;
            var onclick = "paginationClick('" + htmlPrefix +"-" + page +"')" ;
            li.attr('onclick',onclick) ;
            li.append('<a href="#">' + page + '</a>') ;
            if (currentPage == page) {
                li.attr('class','active') ;
            }
            targetNode.before(li) ;
        }
   } ;

}