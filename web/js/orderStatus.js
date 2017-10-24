/**
 * состояние заказа
 */
/**
 * переключить состояние заказа "вперёд"
 * переключение через "свой" контроллер
 * @param elem
 */
function orderStatTogglePlus(elem) {
    //var statController = 'orderStatus' ;
    var arr = elem.split('-') ;
    var prefix = arr[0] ;
    var id = arr[arr.length - 1] ;
    var cnt = paramSet.getController(prefix) ;
    cnt.toggleStat('plus',id) ;
}
/**
 * переключить состояние заказа "назад"
 * переключение через "свой" контроллер
 * @param elem
 */
function orderStatToggleMinus(elem) {
    //var statController = 'orderStatus' ;
    var arr = elem.split('-') ;
    var prefix = arr[0] ;
    var id = arr[arr.length - 1] ;
    var cnt = paramSet.getController(prefix) ;
    cnt.toggleStat('minus',id) ;
}

function orderLockClick(elem) {
    var arr = elem.split('-') ;
    var prefix = arr[0] ;
    var id = arr[arr.length - 1] ;
    var cnt = paramSet.getController(prefix) ;
    cnt.orderLock(id) ;
}
