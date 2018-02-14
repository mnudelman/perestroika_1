/**
 * просмотр ЗАКАЗА
 */
/**
 * профиль исполнителя заказа
 */
function orderViewClick(elem) {
    var arr = elem.split('-') ;
    var id = arr[arr.length -1] ;
    var addPrefix = 'orderView' ;
    var htmlPrefix = arr[0] ;
    var block = $('#' +htmlPrefix + '-' + addPrefix) ;
    var title = $('#' +htmlPrefix + '-' +  addPrefix + '-title') ;
    var sourceElem = $('#' + elem) ;
    var elName = (sourceElem.text()).trim() ;
    title.text('заказ:' + elName) ;
    htmlPrefix += 'OrderView' ;
    var cnt = paramSet.getController(htmlPrefix) ;
    cnt.tabInit(id) ;

    block.show() ;
}
/**
 * перехватывает click по ярлыкам закладок
 *
 */
$( function() {
    $('[name$="-header"]').click(function() {
        var name = $(this).attr('name') ;
        var arr = name.split('-') ;
        var  contextName = arr[0] ;
        var lenTot = contextName.length ;
        var pos = contextName.indexOf('OrdersOrderView') ;
        var len1 = 'OrdersOrderView'.length ;
        if ( lenTot === pos + len1 ) {
            var tabName = arr[arr.length - 2];       // закладка имя
            var controller = paramSet.getController(contextName);
            controller.tabSelect(tabName);       ///   orderWorkEdit() ;

        }
    }) ;
}) ;
/**
 * объект - показать заказ
 * @constructor
 */
function OrderView() {
    var contextName ;               // это htmlPrefix (orderEditMailingProfile) для элементов страницы
    var htmlContext ;
    var currentOrderId ;
    var ajaxExe ;
    var urlPrefix = 'index.php?r='  ;
    var orderController = urlPrefix + 'order' +  '%2F' ;
    var orderWorkController = urlPrefix +  'order-work-direction' + '%2F' ;
    var orderGalleryController = urlPrefix + 'order-work-gallery' + '%2F' ;
    var orderMailingController = urlPrefix +  'order-mailing' + '%2F' ;
    var developerController = urlPrefix + 'developer' + '%2F' ;
    var url = {
        setOrder: orderController + 'set-current-order',
        orderGeneral: orderController + 'get-order-general',
        orderWorks: orderWorkController + 'get-fact-work-direction',
        orderAdditional: orderGalleryController + 'get-gallery'
    } ;


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
    this.tabInit = function(id) {
        currentOrderId = id ;
        var data = {
            opCod : 'setOrderId',
            orderId : currentOrderId
        } ;
        ajaxExe.setUrl(url.setOrder) ;
        ajaxExe.setData(data) ;
        ajaxExe.setCallback(orderGeneral) ;
        ajaxExe.go() ;
    } ;

   this.tabSelect = function(tabName) {
       switch (tabName) {
           case 'general' :
               orderGeneral() ;
               break ;
           case 'works' :
               orderWorks() ;
               break ;
           case 'additional' :
               orderAdditional() ;
               break ;
       }
   } ;
    var orderGeneral = function() {
        var orderGeneral = {
            orderId: currentOrderId
        } ;
        var data = {
            opCod : 'getOrderGeneral',
            orderGeneral : orderGeneral
        } ;
        ajaxExe.setUrl(url.orderGeneral) ;
        ajaxExe.setData(data) ;
        ajaxExe.setCallback(orderGeneralShow) ;
        ajaxExe.go() ;
    } ;
    var orderGeneralShow = function(rr) {
        var a = 1 ;
        var general = rr['orderGeneral'] ;
        htmlContext.generalShow(general) ;
    } ;
    var orderWorks = function() {
        //--  переходим в контекст 'orderMailingWorkDirection - профиль исполнителя --//
        var elem = 'officeDeveloperOrdersOrderViewWorks' + '-' + currentOrderId ;
        switchSet(elem);
    } ;
    /**
     * <button id="orderEdit-country-bt" class="btn btn-primary dropdown-toggle"
     * name="country-3159" style="white-space: pre-wrap;" data-toggle="dropdown">
     * Россия <span class="caret"></span></button>

     <ul id="orderEdit-country-ul" class="list-group dropdown-menu"
     name="country-3159" style="overflow-y:auto;max-height:400px;white-space: pre-wrap;">
     <li class="list-group-item" name="orderEdit-country-4"
     onclick="simpleGeographyOnClick(&quot;orderEdit-country-4&quot;)">
     <a href="#" tabindex="-1">Австралия</a></li>

     */
    var orderAdditional = function() {
        var sendData = {
            opCod : 'getGallery'
        } ;
        var ajax = new AjaxExecutor() ;
        ajax.setData(sendData) ;
//    url = 'index.php?r=work-direction%2Fsave-work-direction' ;
        var phpController = 'order-work-gallery' ;
        //ajax.setUrl('index.php?r=work-gallery%2Fget-gallery') ;
        ajax.setUrl('index.php?r=' + phpController + '%2Fget-gallery') ;

        ajax.setCallback(orderAdditionalShow) ;
        ajax.go() ;
    } ;
    var orderAdditionalShow = function(rr) {
        var a = 1 ;
        var galleryUrl = rr['galleryUrl'] ;
        var urlPdfShow = rr['urlPdfShow']  ;
        var galleryItems = rr['orderList'] ;
        paramSet.putObj('urlPdfShow',urlPdfShow) ;
        htmlContext.galleryShow(galleryUrl,galleryItems) ;
    } ;

}


function OrderViewHtml() {
    var htmlPrefix ;   // это htmlPrefix (orderEditMailingProfile) для элементов страницы
    var generalNode ;
    var fieldWorkRankBt ;
    var fieldGeographyRankBt ;
    var fieldWorkRankUl ;
    var fieldGeographyRankUl ;
    var galleryUrl ;
    var GALLERY_ROW_SIZE = 3 ;     // число картинок в строке
    var galleryHtmlPrefix ;
    var galleryDivBlock ;
    var pdfIcon = 'images/pdfIcons/pdf.png' ;    // иконка для pdf файла
    var urlPdfShow ;                             // программа вывода на полный экран
    //----------------------------------------//
    this.init = function(contextName) {
        htmlPrefix = contextName ;
        generalNode = $('[name="' + contextName + '-general-content"]') ;
        galleryHtmlPrefix = htmlPrefix + 'Additional-order' ;
        galleryDivBlock = $('#' + galleryHtmlPrefix) ;
    } ;
    this.generalShow = function(general) {
// закрыть изменения
        (generalNode.find('input')).attr('disabled','disabled') ;
        (generalNode.find('button')).attr('disabled','disabled') ;
        (generalNode.find('textArea')).attr('disabled','disabled') ;
        var a = 1 ;
        (generalNode.find('[name$="[description]"]')).val(general.orderDescription) ;
        (generalNode.find('[name$="[order_name]"]')).val(general.orderName) ;
        (generalNode.find('[name$="[per_beg]"]')).val(general.perBeg) ;
        (generalNode.find('[name$="[per_end]"]')).val(general.perEnd) ;
        var geography = general['orderPlace'] ;
        var countryName = geography['userCountry']['name'] ;
        var countryId  = geography['userCountry']['id'] ;
        var regionName = geography['userRegion']['name'] ;
        var regionId = geography['userRegion']['id'] ;
        var cityName = geography['userCity']['name'] ;
        var cityId = geography['userCity']['id'] ;
        var countryNode = generalNode.find('#' + htmlPrefix + '-country-bt') ;
        countryNode.text(countryName) ;
        countryNode.attr('name','country-' + countryId) ;
        var regionNode = generalNode.find('#' + htmlPrefix + '-region-bt') ;
        regionNode.text(regionName) ;
        var cityNode = generalNode.find('#' + htmlPrefix + '-city-bt') ;
        cityNode.text(cityName) ;

    } ;
    this.galleryShow = function(url,gallaryItems) {
        galleryUrl = url ;
        galleryDivBlock.empty() ;
        var n = gallaryItems.length ;
        var nRow = 0 ;
        var row = createGalleryRow(0) ;
        for (var i = 0; i < n; i++) {
            if (i === (nRow + 1) * GALLERY_ROW_SIZE) {
                galleryDivBlock.append(row) ;
                row = createGalleryRow(nRow++) ;
            }
            var imgElem = createGalleryImgElem(gallaryItems[i]) ;
            row.append(imgElem) ;
        }
        if (n - 1  < (nRow + 1) * GALLERY_ROW_SIZE) {   // последний блок
            galleryDivBlock.append(row) ;
        }

    };
    /**
     *  <div class="row" name="row-0">
     * @param iRow
     */
    var createGalleryRow = function(iRow) {
        var newRow = $('<div class="row"></div>') ;
        newRow.attr('name','row-' + iRow) ;
        return newRow ;

    } ;
    /**
     * <div id="<?=$htmlPrefix?>-order-1" class="col-sm-4 block" style="min-height: 20px;">
     *<div class="orderEditAdditional-order-innerDiv"
     *id="orderEditAdditional-order-1-img"
     *style="width: 100%; height: auto; position: relative;">
     *<img class="img-responsive img-thumbnail" src="/projects/perestroika/web/images/user/u_25/gallery/2_evro_tHRy9.jpg" style="width: 100%;">
     *<p>new picture</p>
     *</div>
     *</div>
     * orderList => ['userid' => ...,'image'=> ...,'title_ru' => ....,'order_n' =>
     * @param imgElem
     */
    var createGalleryImgElem = function(imgElem) {
        var img = imgElem['image'] ;     // файл - изображение
        var title = imgElem['title_ru'] ;  // подпись
        var orderN = imgElem['order_n'] ;  // пор N
        var arr = img.split('.') ;
        var ext = arr[arr.length - 1] ;
        var icon = (ext.toLowerCase() === 'pdf') ? pdfIcon : '' ;  // иконка для избражения pdf файла
        var divMain = $('<div id="<?=$htmlPrefix?>-order-1" class="col-sm-4 block" style="min-height: 20px;">') ;
        var idMain = htmlPrefix + '-order' + orderN ;
        divMain.attr('id',idMain) ;

        var dblClick = 'imgToFullScreen("' + idMain +'")' ;
        divMain.attr('ondblclick',dblClick) ;




        var divMsg = $('<div style="width: 100%; height: auto; position: relative;"></div>') ;
        divMsg.attr('id',htmlPrefix + '-order' + orderN + '-img') ;




        var imgNode = $('<img class="img-responsive img-thumbnail additionalImg" style="width: 100%;">') ;
        var imgFile = galleryUrl +'/' + img ;
        var src = (icon.length === 0) ? imgFile : icon ;
        imgNode.attr('src',src) ;
        if (icon.length > 0) {
            imgNode.data('src',imgFile) ;
        }
        divMsg.append(imgNode) ;
        var pText = $('<p></p>') ;
        pText.append(title) ;
        divMsg.append(pText) ;
        divMain.append(divMsg) ;
        return divMain ;
    }

}
/**
 * jбъект - адаптер
 * @constructor
 */
function OrderViewAjax() {
    var urlController = 'work-geography' ;
    var urlPrefix = 'index.php?r=' + urlController + '%2F' ;
    var url = {
        getSubItems: urlPrefix + 'get-work-city',
        getSetItemsFact: urlPrefix + 'get-work-region',
        getSets: urlPrefix + 'get-country'
    } ;
    var OBJECT_TYPE = 'developer' ;
    var _this = this ;
    //-----------------------------------------------//
    /**
     * настройка на контроллер
     * @param controller
     */
    this.init = function(controller) {
        urlController = controller ;
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
            case 'getSets' :
                res = getSetsGetAjaxParam(params) ;
                break ;

            default :
        }
        return res ;


    };
    /**
     *
     * @param params={setId:id, setName: name}
     * @returns {{opCod: string, url: string, data: {workDirection: *, workItems: *}}}
     */
    var getSetItemsFactAjaxParam = function(params) {
        var urlAddr = url.getSetItemsFact ;
        var opCod = 'getFactWorkRegion' ;
        var data = {
            countryId : params['id'],
            objectType : OBJECT_TYPE
        } ;
        return {
            opCod : opCod,
            url : urlAddr,
            objectType: 'developer',
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
        var urlAddr = url.getSubItems ;
        var opCod = 'getCityList' ;
        var data = {
            countryId: params['setId'],
            regionId : params['id'],
            objectType: OBJECT_TYPE
        } ;
        return {
            opCod : opCod,
            url : urlAddr,
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
                res = getSubItemsParseAjaxRes(rr) ;
                break ;
            case 'saveSetItem' :
                res = saveSetItemParseAjaxRes(rr) ;
                break ;
            case 'getSetItemsFact' :
                res = getSetItemsFactParseAjaxRes(rr) ;
                break ;
            default :
        }
        return res ;
    } ;
    var saveSetItemParseAjaxRes = function(rr) {

    } ;
    var addNewSetParseAjaxRes = function(rr) {
        var success = rr['success'] ;
        return {success: success} ;
    } ;
    /**
     * массив элементов надо привести к виду {id:   , name: ,fullyFlag: }
     * @param rr
     */
    var getSetItemsFactParseAjaxRes = function(rr) {
        var success = rr['success'] ;
        var factWorkDirectionList = rr['workRegionList'] ;
        var setItemList = [] ;
        for (var key in factWorkDirectionList) {
            var item = factWorkDirectionList[key] ;
            var id = item['region_id'] ;
            var fullyFlag = item['fully_flag'] ;
            fullyFlag = (typeof(fullyFlag) === 'string') ?
                (fullyFlag === 'true' || fullyFlag == '1') : fullyFlag ;

            var name = item['region']['name'] ;
            var newElem = {} ;
            newElem['id'] = id ;
            newElem['name'] = name ;
            newElem['fullyFlag'] = fullyFlag ;
            setItemList.push(newElem) ;
        }
        var workCountry = rr['workCountry'] ;
        var countryId = workCountry['country_id'] ;
        return {success: success, setId:countryId,setItemList: setItemList} ;

    } ;
    var getSubItemsParseAjaxRes = function(rr) {
        var success = rr['success'] ;
        var cityList  = rr['workCityList'] ;
        var region = rr['workRegion'] ;
        var fullyFlag = region['fully_flag'] ;
        fullyFlag = (typeof(fullyFlag) === 'string') ?
            (fullyFlag === 'true' || fullyFlag == '1') : fullyFlag ;

        var setItem = {
            id: region['region_id'],
            name: region['region']['name'],
            fullyFlag: fullyFlag
        } ;
        var subItemList = [] ;
        for (var ind in cityList) {
            var city = cityList[ind]['city'] ;
            var subItem = {
                id : city['id'],
                name: city['name'],
                inWorkCurrentFlag: true
            } ;
            subItemList.push(subItem) ;
        }
        return {success:success, setItem: setItem,
            subItemsList: subItemList, subItemsFactList: subItemList,buttons:[]} ;
    } ;


}