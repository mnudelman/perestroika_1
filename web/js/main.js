var paramSet ;
$(document).ready(function(){
    paramSet = new ParamSet();
    paramSet.init() ;
    //main = new MainScript() ;
    //main.init() ;

} ) ;
$( window ).load(function() {
    // чистим от несанкционированного подключения jquery-ui
    var bootstrapUiButtons = $('.btn').filter('[class~="ui-button"]') ;
    if (bootstrapUiButtons.length > 0) {
        var item = bootstrapUiButtons[0] ;
        var cl = $(item).attr('class') ;
        var clArr = cl.split(' ') ;
        for (var i = 0; i < clArr.length; i++) {
            var cl_i = clArr[i] ;
            if (cl_i.indexOf('ui-') >= 0) {
                bootstrapUiButtons.removeClass(cl_i) ;
            }
        }
        for (i = 0; i < bootstrapUiButtons.length ; i++) {
            var btItem = $(bootstrapUiButtons[i]) ;
            var uiSpan = btItem.children('[class="ui-button-text"]') ;
            if (uiSpan.length > 0) {
                var text = uiSpan.text() ;
                var caret = uiSpan.children() ;
                btItem.empty() ;
                btItem.append(text + ' ') ;
                btItem.append(caret) ;
            }
        }

    }
});


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

    var showFlag = (filterNode.css('display') !== 'none') ;
    opCod = (opCod === 'edit' && showFlag) ? 'close' : opCod ;


    var controller = paramSet.getController(contextName) ;
    switch (opCod) {
        case 'close' :
            filterNode.hide(600) ;
            break ;
        case 'save' :
            filterNode.hide(600) ;
            controller.setFilter() ;
            break ;
        case 'edit' :
            filterNode.show(600) ;
            controller.editFilter() ;
            break ;


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
    var showFlag = (setupNode.css('display') !== 'none') ;
    opCod = (opCod === 'edit' && showFlag) ? 'close' : opCod ;


    var controller = paramSet.getController(contextName) ;
    switch (opCod) {
        case 'close' :
            setupNode.hide(600) ;
            break ;
        case 'save' :
            setupNode.hide(600) ;
            controller.setSetup() ;
            break ;
        case 'edit' :
            setupNode.show(600) ;
            controller.editSetup() ;
            break ;
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

    var showFlag = (ruleNode.css('display') !== 'none') ;
    opCod = (opCod === 'open' && showFlag) ? 'close' : opCod ;
    switch (opCod) {
        case 'close' :
            ruleNode.hide(600) ;
            break ;
        case 'open' :
             ruleNode.show(600) ;
            break ;


    }

}





function showError(errorText, errorTitle) {
    var errShowContent = $('#errorShowContent');
    errShowContent.empty();
    if (errorTitle !== undefined) {
        $('#errorShowTitle').empty() ;
        $('#errorShowTitle').append('<h2>' + errorTitle + '</h2>');
    }
    errShowContent.append(errorText);
    $('#errorShow').modal('show') ;
}

//
//$( window ).unload(function() {
//    return("goodbye!");
//});
//window.onbeforeunload = function (e) {
//    return 'close window!!' ;
//} ;


/**
 *
 * @param htmlPrefix
 * @param type - {'avatar' | 'gallery'} определяет тип загрузки (1 файл или несколько)
 *                                       и php - контроллер для связи через ajax
 * @param ajaxCallback - внешняя функция для передачи выбранных файлов
 */
function uploadOnClick(htmlPrefix,type,ajaxCallback) {
    var objName = htmlPrefix + '-' + 'uploadController' ;
    var cnt = paramSet.getObj(objName) ;
    if (cnt === null) {
        cnt = new UploadController() ;
        paramSet.putObj(objName,cnt) ;
    }
    cnt.init(htmlPrefix,type,ajaxCallback) ;
    cnt.uploadDo() ;
}
//
/**
 * @constructor
 */
function UploadController() {
    var url = {
        avatar: 'index.php?r=site%2Fupload',
        gallery: 'index.php?r=site%2Fupload'

    };
    var htmlPrefix = '';
    var ajaxExe = null;
    var TYPE_AVATAR = 'avatar';
    var TYPE_GALLERY = 'gallery';
    var currentType;
    var uploadFormSuffix = '-upload-form';
    var avatarSuffix = '-avatar-img';
    var ajaxCallback;
    var _this = this;
    //---------------------------------------------------//
    this.init = function (htmlPref, type, callback) {
        htmlPrefix = htmlPref;
        currentType = type;
        ajaxCallback = callback;
        if (ajaxExe === null) {
            ajaxExe = new AjaxExecutor();
        }
    };
    /**
     * исполрить загрузку файлов на сайт
     */
    this.uploadDo = function () {
        var uploadFormId = htmlPrefix + uploadFormSuffix;
        var imgFile = $('#' + uploadFormId + ' [type="file"').val();
        if (imgFile.length == 0) {               // файл не выбран
            return;
        }
        var formData = new FormData($('#' + uploadFormId)[0]);
        var urlCurrent = url[currentType];
        $.ajax({
            url: urlCurrent,
            type: 'POST',
            // Form data
            data: formData,
            success: function(response) {
                var rr =JSON.parse(response) ;
                uploadedShow(rr) ;
            },
            error: function (event, XMLHttpRequest, ajaxOptions, thrownError) {
                var responseText = event.responseText; // html - page
                showError(responseText);
            },
            //Options to tell jQuery not to process data or worry about content-type.
        cache: false,
        contentType: false,
        processData: false

        });
        // ajaxExe.setUrl(urlCurrent);
        // ajaxExe.setData(formData);
        // ajaxExe.setCallback(uploadedShow);
        // ajaxExe.go();

    };
    /**
     * показать загруженные файлы
     */
    var uploadedShow = function (rr) {
        var imgsUrl = rr['uploadedUrl'];
        var imgsPath = rr['uploadedPath'];
        if (typeof(ajaxCallback) === 'function') {
            ajaxCallback(imgsUrl);
        } else {
            var imgUrl = imgsUrl[0];
            var avatarImgId = htmlPrefix + avatarSuffix;
            $('#' + avatarImgId).attr('src', imgUrl);

        }
    } ;
}
/**
 * ппростой выбор из выпадающего списка
 * имя и id выбранного элемента переносится на клавишу
 * выбранный элемент становится текущим
 * @param elem
 */
function dropDownSelect(elem) {
   var arr = elem.split('-') ;
   var id = arr[arr.length -1] ;    // id элемента
   var groupName = '' ;    // групповое имя объединяет все элементы
    for(var i = 0; i < arr.length -1; i++) {
        groupName += ((groupName.length > 0) ? '-' : '') + arr[i] ;
   }
   var bt = $('#' + groupName + '-bt') ;
    var ul = $('#' + groupName + '-ul') ;
    var item = ul.children('[name$="-'+ id + '"]') ;
    bt.attr('name',elem) ;
    ul.attr('name',elem) ;

    var text = item.text() ;
    var btSpan = bt.children('span') ;

    bt.text(text + ' ') ;
    bt.append(btSpan) ;
    // заменить текущий элемент //
    var items = ul.children() ;
    for(var ind in items) {
        if (isNaN(ind)) {       // последним элементом попадает ind = 'length' ???
            break ;
        }
        item = $(items[ind]) ;
        var name = item.attr('name') ;
        var arr = name.split('-') ;
        var itemId = arr[arr.length -1] ;    // id - последний элемент в составном имени
        var cl = item.attr('class') ;
        var activeFlag = (cl.indexOf('active') > 0 ) ;
        if (id - 0 === itemId - 0) {
            if (!activeFlag) {
                item.addClass('active') ;
            }
        }else {
            if (activeFlag) {
                item.removeClass('active') ;
            }
        }
    }
}

/**
 * вытащить текст из централизованной по странице подсказки
 * подсказки по странице собраны в <div id="$htmlPrefix + '-tooltips'" >
 *  <input name="$tooltipName" data-$variant=text>
 *  ...................    см. TooltipsWidget
 * @param htmlPrefix
 * @param tooltipName
 * @param variant - по умолчанию 'yes'
 */
function getTooltipText(htmlPrefix,tooltipName,variant) {
     variant = (variant === undefined) ? 'yes' : variant ;
     var tooltipsNode = $('#' + htmlPrefix +'-tooltips') ;
     var currentTooltip = tooltipsNode.find('[name="' + tooltipName + '"]') ;
     return currentTooltip.data(variant) ;
}

/**
 * показать имя пользователя и avatar в  topMenu
 */

function avatarShow() {
    var cnt = paramSet.getObj('AvatarShowController') ;
    if (cnt === null) {
        cnt = new AvatarShowController() ;
        paramSet.putObj('AvatarShowController',cnt) ;
    }
    cnt.avatarShow() ;
}

/**
 * объект для вывода имени пользователя
 * @constructor
 */
function AvatarShowController() {
    var url = 'index.php?r=user%2Fget-avatar' ;
    var avatarNode =  $('#topmenu-avatar') ;
    var ajaxExe =  null ;
    var _this = this ;
    //-------------------------------//
    this.avatarShow = function() {
       if (ajaxExe === null) {
           ajaxExe = new AjaxExecutor() ;
       }
       var data = {
           opCod: 'getUserName'
       } ;
       ajaxExe.setUrl(url) ;
       ajaxExe.setData(data) ;
       ajaxExe.setCallback(avatarShowGo) ;
        ajaxExe.go() ;
    } ;
    /**
     *imgName' => $avatar['imgName'],
     'url' => $avatar['url'],

     * @param rr
     */
    var avatarShowGo = function (rr) {
        var success = rr['success'] ;
        var urlAvatar = rr['url'] ;
        var imgAvatar = rr['imgName'] ;
        var src =  urlAvatar + '/' + imgAvatar ;
        avatarNode.attr('src',src) ;
    } ;
}