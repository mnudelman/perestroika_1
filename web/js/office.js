/**
 * личный кабинет
 */
/**
 * перехватывает click по ярлыкам закладок
 *
 */
$( function() {
    $('[name$="-header"]').click(function() {
        var name = $(this).attr('name') ;
        var arr = name.split('-') ;
        var  contextName = arr[0] ;


        if (contextName === 'office') {
            var tabName = arr[arr.length -2] ;
            var parentId = ($(this).parent()).attr('id') ;
            var cnt = paramSet.getController('menuPath') ;
            cnt.tabHeaderClick(contextName + '-' + tabName,parentId) ;
            if (tabName === 'developer') {
                var devCnt = paramSet.getController('officeDeveloperOrders') ;
                devCnt.setFilter() ;
            }
        }
    }) ;
}) ;
