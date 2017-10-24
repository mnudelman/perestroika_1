/**
 * Последовательность пунктов меню - аналог breadCrumbs
 */
//$( function() {
//    $('.menuPath').click(function() {
//        var cnt = paramSet.getController('menuPath') ;
//        cnt.menuPathClick(this) ;
//    }) ;
//}) ;
function menuPathClick(menuBlockId) {
    $('#' + menuBlockId).show(500) ;

}
function makeCamel(elem) {
    var arr = elem.split('-') ;
    var name = (arr[0]).toLowerCase() ;
    for (var i = 1; i < arr.length; i++) {
        var nameItem = arr[i] ;
        var firstLetter = (nameItem.substr(0,1)).toUpperCase() ;
        var tail = (nameItem.substr(1)).toLowerCase() ;
        name += firstLetter + tail ;
    }
    return name ;
}
/**
 *
 * @constructor
 */
function MenuPath() {
    var contextName ;               // это htmlPrefix
    var htmlContext ;               // объект для вывода на экран
    var ajaxExe ;
    var urlPrefix = 'index.php?r='  ;
    var phpController = urlPrefix + 'menu-path' +  '%2F' ;
    var url = {
        addMenuItem: phpController + 'add-menu-item',
        getMenuPath: phpController + 'get-menu-path'
    } ;
    var tabHeaderBlocks = [
        'officeTabHeader'
    ] ;
    var currentMenuPath = {} ;
    var _this = this ;
    //-------------------------------------------//
    /**
     * первый запуск профиля
     * @param ctxtName
     * @param context
     */
    this.init = function(ctxtName,context) {
        contextName = ctxtName;
        htmlContext = context['html'];
        htmlContext.init(contextName);
        ajaxExe = new AjaxExecutor(); // собственный исполнитель запроса
    } ;
    /**
     * передать выбранное действие как элемент-пункт меню
     * скрыть  tabHeader,
     * отправить через phpController
     */
    this.tabHeaderClick = function(tabName,parentBlockId) {

        if (tabHeaderBlocks.indexOf(parentBlockId) < 0) {
            return
        }
        if (tabName.indexOf('-') >= 0)  {
            tabName = makeCamel(tabName) ;
        }
        $('#' + parentBlockId).hide(400);
        var opCod = 'addMenuItem' ;
        var data = {
            opCod : opCod,
            menuItemId : tabName
        } ;
        ajaxExe.setUrl(url.addMenuItem) ;
        ajaxExe.setData(data) ;
        ajaxExe.setCallback(menuPathShow) ;
        ajaxExe.go() ;


    } ;
    this.menuPathClick = function(menuElem) {
        var item = $(menuElem) ;
        var menuBlockId = item.data('menuBlock') ;
        if (menuBlockId.length > 0) {
            $('#' + menuBlockId).show(1600) ;
        }
    } ;
    var menuPathShow = function(rr) {
       currentMenuPath = rr['menuPath'] ;
        htmlContext.menuPathShow(currentMenuPath) ;
       var a = 1 ;

    } ;
 }
function MenuPathHtml() {
    var htmlPrefix;
    var menuPathNode = $('#menuPath') ;
    var btnClass = {
        ordinary: 'btn btn-primary',
        last: 'btn btn-success'
    } ;
    var arrowClass ='fa fa-arrow-right' ;
    //-----------------------------------------//
    this.init = function (contextName) {
        htmlPrefix = contextName;
    };
    this.menuPathShow = function(mP) {
        menuPathNode.empty() ;
        for (var i = 0; i < mP.length; i++ ) {
            var lastFlag = (i === mP.length -1) ;
            var menuItem = menuItemBuild(mP[i],lastFlag) ;
            menuPathNode.append(menuItem) ;
            if (!lastFlag) {
                var arrow = $('<i></i>') ;
                arrow.addClass(arrowClass) ;
                menuPathNode.append(arrow) ;
            }
        }

    } ;
    /**
     *
    *$arrowClass ='fa fa-arrow-right' ;

     *<a class="<?=$btnClass?>" href="<?=$url?>" role="button" <?=$disabled?>
     *  data-menu-block="<?=$menuBlockId?>">
     *<?=$name?>
     *</a>
    <?php
    if (!$lastItem) {
        ?>
    <i class="<?=$arrowClass?>"></i>
        <?php
    }
    ?>

     * @param menuItem
     * @param lastFlag
     */
    var menuItemBuild = function(menuItem,lastFlag) {
        var bt = $('<a  href="" role="button"  data-menu-block=""></a>') ;
        var name = menuItem['name'] ;
        var href = menuItem['url'] ;
        var menuBlockId = menuItem['menuBlockId'] ;
        var btClass = (lastFlag) ? btnClass.last : btnClass.ordinary ;
        bt.addClass(btClass) ;
        bt.addClass('menuPath') ;
        bt.attr('href',href) ;
        bt.data('menuBlock',menuBlockId) ;
        if (lastFlag) {
            bt.attr('disabled','disabled') ;
        }
        if (menuBlockId.length > 0) {
            var onClick = 'menuPathClick("' + menuBlockId + '")' ;
            bt.attr('onclick',onClick) ;
        }
        bt.text(name) ;
        return bt ;
    } ;
}