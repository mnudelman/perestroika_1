$( function() {
    $('.additionalImg').dblclick(function() {
        var node = $(this) ;
    }) ;

}) ;
function imgToFullScreen(elem) {
    var node = $('#' + elem) ;
    var urlPdfShow = paramSet.getObj('urlPdfShow') ;
    var img = node.find('img') ;
    if (img.length > 0) {
        var src = img.attr('src') ;
        var arr = src.split('.') ;
        var ext = arr[arr.length - 1] ;
        if (typeof(img.data('src')) === 'string') {     // есть ссылка на изображение
            src = img.data('src') ;
        }
        var url = urlPdfShow + '?fn=' + src ;
        var win = window.open (url, '_blank');
    }


}
/**
 * профиль исполнителя заказа
 */
function orderMailingProfileClick(elem) {
    var arr = elem.split('-') ;
    var id = arr[arr.length -1] ;
    var htmlPrefix = arr[0] ;
    var block = $('#' +htmlPrefix + '-profile') ;
    var title = $('#' +htmlPrefix + '-profile-title') ;
    var sourceElem = $('#' + elem) ;
    var elName = (sourceElem.text()).trim() ;
    title.text(elName) ;
    htmlPrefix += 'Profile' ;
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
        if (contextName === 'orderEditMailingProfile') {    // отправляем диспетчерезацию в контроллер
            var tabName = arr[arr.length - 2];       // закладка имя
            var controller = paramSet.getController(contextName);
            controller.tabSelect(tabName);       ///   orderWorkEdit() ;
        }
    }) ;
}) ;

/**
 * объект - профиль для мсполнителя заказа
 * @constructor
 */
function OrderMailingProfile() {
    var htmlPrefix ;               // это htmlPrefix (orderEditMailingProfile) для элементов страницы
    var htmlContext ;
    var currentDeveloperId ;
    var ajaxExe ;
    var urlPrefix = 'index.php?r=' + 'developer-profile' + '%2F' ;
    var url = {
        setDeveloper: urlPrefix + 'set-developer',
        profileGeneral: urlPrefix + 'get-profile-general',
        profileWorks: urlPrefix + 'get-profile-works',
        profileGeography: urlPrefix + 'get-profile-geography',
        profileAdditional: urlPrefix + 'get-profile-additional'
    } ;


    var _this = this ;
    //-------------------------------------------//
    /**
     * первый запуск профиля
     * @param ctxtName
     * @param context
     */
    this.init = function(ctxtName,context) {
        htmlPrefix = ctxtName;
        htmlContext = context['html'];
        htmlContext.init(htmlPrefix);
        ajaxExe = new AjaxExecutor(); // собственный исполнитель запроса
    } ;
    this.tabInit = function(id) {
        //paginationClick(contextName + '-1') ;    // на первую страницу
        currentDeveloperId = id ;
        var data = {
            opCod : 'setDeveloperId',
            developerId : currentDeveloperId
        } ;
        ajaxExe.setUrl(url.setDeveloper) ;
        ajaxExe.setData(data) ;
        ajaxExe.setCallback(profileGeneral) ;
        ajaxExe.go() ;
    } ;
    /**
     * запускаются страницы закладок, требующие
     * наличия выбранного заказа
     *             (new OrderLabel()).showLabel('workGalleryEdit') ;
     //            paramSet.putObj('phpGalleryController','order-work-gallery') ;  // меняем контроллер для галлереи
     //            (new GalleryController()).init() ;

     * @param tabName
     */
    this.tabSelect = function(tabName) {
        switch (tabName) {
            case 'general' :        // работы
                profileGeneral() ;
                break ;
            case 'works' :        // работы
                profileWorks() ;
                break ;
            case 'geography' :        // география
                profileGeography() ;
                break ;
            case 'additional' :   // доп материалы
                profileAdditional() ;
                break ;
        }
    } ;



    var profileGeneral = function() {
        var data = {
            opCod : 'getProfileGeneral',
            developerId : currentDeveloperId
        } ;
        ajaxExe.setUrl(url.profileGeneral) ;
        ajaxExe.setData(data) ;
        ajaxExe.setCallback(profileGeneralShow) ;
        ajaxExe.go() ;
    } ;
    var profileGeneralShow = function(rr) {
        var a = 1 ;
        var general = rr['general'] ;
        htmlContext.generalShow(general) ;
    } ;
    var profileWorks = function() {
        //--  переходим в контекст 'orderMailingWorkDirection - профиль исполнителя --//
        var elem = 'orderEditMailingProfileWorks' + '-' + currentDeveloperId ;
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
    var profileGeography = function() {
        var data = {
            opCod : 'getProfileGeography',
            developerId : currentDeveloperId
        } ;
        ajaxExe.setUrl(url.profileGeography) ;
        ajaxExe.setData(data) ;
        ajaxExe.setCallback(profileGeographyShow) ;
        ajaxExe.go() ;
    } ;
    var profileGeographyShow = function(rr) {
        var contextName = 'orderEditMailingProfileGeography' ;
        var context = paramSet.getContext(contextName) ;
        var html = context['html'] ;
        html.init(contextName,'country') ;
        var cnt = paramSet.getController(contextName) ;


        html.setEmpty() ;

        var success = rr['success'] ;
        var setItems = rr['countryList'] ;
        for (var ind in setItems) {
            var item = setItems[ind] ;
            html.addNewSet(item['id'],item['name']) ;
        }
        var currentSetId = setItems[0]['id'] ;
        cnt.switchSet(currentSetId) ;
    } ;
    var profileAdditional = function() {
            var sendData = {
                opCod : 'getGallery'
            } ;
            var ajax = new AjaxExecutor() ;
            ajax.setData(sendData) ;
//    url = 'index.php?r=work-direction%2Fsave-work-direction' ;
            var phpController = 'developer-gallery' ;
            //ajax.setUrl('index.php?r=work-gallery%2Fget-gallery') ;
            ajax.setUrl('index.php?r=' + phpController + '%2Fget-gallery') ;

            ajax.setCallback(profileAdditionalShow) ;
            ajax.go() ;
   } ;
    var profileAdditionalShow = function(rr) {
        var a = 1 ;
        var galleryUrl = rr['galleryUrl'] ;
        var urlPdfShow = rr['urlPdfShow']  ;
        var galleryItems = rr['orderList'] ;
        paramSet.putObj('urlPdfShow',urlPdfShow) ;
        htmlContext.galleryShow(galleryUrl,galleryItems) ;
    } ;

}


function OrderMailingProfileHtml() {
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
        var a = 1 ;
        var company = general['company'] ;
        var info = general['info'] ;
        var geography = general['geography'] ;
        var companyNode = generalNode.find('#userprofile-company') ;
        companyNode.val(company) ;
        var infoNode = generalNode.find('#userprofile-info') ;
        infoNode.val(info) ;
        var avatar = general['avatar'] ;
        var avatarNode = generalNode.find('#profile-avatar-img') ;
        avatarNode.attr('src',avatar) ;
        var countryName = geography['userCountry']['name'] ;
        var regionName = geography['userRegion']['name'] ;
        var cityName = geography['userCity']['name'] ;
        var countryNode = generalNode.find('#geography-country-bt') ;
        countryNode.text(countryName) ;
        var regionNode = generalNode.find('#geography-region-bt') ;
        regionNode.text(regionName) ;
        var cityNode = generalNode.find('#geography-city-bt') ;
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
function OrderMailingProfileAjax() {
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