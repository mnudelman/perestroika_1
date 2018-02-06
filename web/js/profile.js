/**
 * отправить данные редактирования профиля
 * @param restorePrevious - восстанвить последние сохранённые значения профиля
 */
// function profileOnClick(htmlPrefix,restorePrevious) {
// // проверяем автономный контроль
//     restorePrevious = (restorePrevious === undefined ) ? false : restorePrevious ;
//     if (!restorePrevious) {
//         var err = false;
//         var arr = $('#profile-form .help-block');
//         for (var i = 0; i < arr.length; i++) {
//             var item = arr[i];
//             if ((item.textContent).length > 0) {
//                 err = true;
//                 break;
//             }
//         }
//         if (err) {
//             return;
//         }
//
//     }
//     var formId = '#' + htmlPrefix + 'profile-form' ;
//     var email = $('#profile-form [name="UserProfile[email]"]').val() ;
//     var site = $('#profile-form [name="UserProfile[site]"]').val() ;
//     var tel =  $('#profile-form [name="UserProfile[tel]"]').val() ;
//     var company = $('#profile-form [name="UserProfile[company]"]').val() ;
//     var info = $('#profile-form [name="UserProfile[info]"]').val() ;
//     var cityNodeName = $('#geography-city-ul').attr('name') ;     // текущий элемент - город
//     arr = cityNodeName.split('-') ;
//     var cityId = arr[1] ;
//     imgFile = '' ;
//     var imgFilePath = $('#profile-avatar-img').attr('src');
//     if (imgFilePath.length > 0) {
//         var aa =  imgFilePath.split('/') ;
//         var imgFile = aa[aa.length - 1] ;
//     }
//     var opcod = (restorePrevious) ? 'get' : 'save' ;
//     var data = {
//         opcod : opcod,
//         "UserProfile" : {
//             "email" : email,
//             "site" : site,
//             "tel" : tel,
//             "company" : company ,
//             "info" : info,
//             "avatar" : imgFile,
//             "city_id" : cityId
//         }
//     };
//     $('#profile-form [name="form-messages"]').empty();
//     $.ajax({
//         url: 'index.php?r=user%2Fprofile',
//         data: data,
//         type: 'POST',
//         success: function (res) {
//             var rr = JSON.parse(res);
//             opcod = rr['opcod'] ;
//             if (opcod === 'get') {
//                 var attr = rr['oldAttributes'] ;
//                 $('#profile-form [name="UserProfile[email]"]').val(attr['email']) ;
//                 $('#profile-form [name="UserProfile[site]"]').val(attr['site']) ;
//                 $('#profile-form [name="UserProfile[tel]"]').val(attr['tel']) ;
//                 $('#profile-form [name="UserProfile[company]"]').val(attr['company']) ;
//                 $('#profile-form [name="UserProfile[info]"]').val(attr['info']) ;
//                 imgFile = attr['avatar'] ;
//                 $('#profile-avatar-img').attr('src','images/avatars/' + imgFile) ;
// //         для восстановления географии - отдельный контроллер
//                 simpleGeographyRestore() ;
//             }
//             var success = rr['success'];
//             var message = rr['message'];
//             if (rr['success'] === true) {
//                 if (opcod !== 'get') {
//                     $('#topmenu-avatar').attr('src', imgFilePath);
//                     $('#profile-form [name="form-messages"]').empty();
//                     $('#profile-form [name="form-messages"]').append('<strong>-----oK!------</strong>');
//                     var confirmationFlag = rr['attributes']['confirmation_flag'] ;
//                     if (!confirmationFlag) {
//                         showError(rr.confirmationMessage) ;
//                     }
//                 }
//             } else {
//
//                 $('#profile-form [name="form-messages"]').empty();
//                 for (var rule in message) {
//                     var messageText = message[rule];
//                     for (var i = 0; i < messageText.length; i++) {
//                         $('#profile-form [name="form-messages"]').append(messageText[i] + '<br>');
//                     }
//                 }
//             }
//         },
//         error: function (event, XMLHttpRequest, ajaxOptions, thrownError) {
//             var responseText = event.responseText; // html - page
//             showError(responseText);
//         }
//     });
//
// }
function profileOnClick(elem) {
    var arr = elem.split('-') ;
    var htmlPrefix = arr[0] ;
    var opCod = arr[arr.length -1] ;
    var cnt = paramSet.getObj('profileController' + '-' +htmlPrefix) ;
    if (cnt === undefined || cnt == null) {
        cnt = new Profile() ;
        cnt.init(htmlPrefix) ;
        paramSet.putObj('profileController' + '-' +htmlPrefix,cnt) ;
    }
    switch (opCod) {
        case 'save' :
            cnt.save() ;
            break ;
    }

}
/**
 * операции с профилем пользователя
 * @constructor
 */
function Profile() {
    var contextName;
    var htmlPrefix = 'profile';
    var ajaxContext;
    var ajaxExe;
    var url = 'index.php?r=user%2Fprofile';
    // поля формы :
    var formId = '#' + htmlPrefix + 'profile-form';
    var simpleFields = {
        email: {name: "UserProfile[email]"},
        site: {name: "UserProfile[site]"},
        tel: {name: "UserProfile[tel]"},
        company: {name: "UserProfile[company]"},
        info: {name: "UserProfile[info]"}
    };
    var messagesNode = {
        messages: {name: "form-messages"},
        error: {name: "form-messages-error"},
        success : {name: "form-messages-success"}

    } ;
    var cityUl = $('#geography-city-ul');
    var avatarNode = $('#' + htmlPrefix + '-avatar-img');
    // var emailField = $('#profile-form [name="UserProfile[email]"]').val() ;
    // var email = $('#profile-form [name="UserProfile[email]"]').val() ;
    // var site = $('#profile-form [name="UserProfile[site]"]').val() ;
    // var tel =  $('#profile-form [name="UserProfile[tel]"]').val() ;
    // var company = $('#profile-form [name="UserProfile[company]"]').val() ;
    // var info = $('#profile-form [name="UserProfile[info]"]').val() ;
    // var cityNodeName = $('#geography-city-ul').attr('name') ;     // текущий элемент - город

    var _this = this;
//----------------------------------------------//
    this.init = function (htmlContext) {
        htmlPrefix = htmlContext;
        ajaxExe = new AjaxExecutor(); // собственный исполнитель запроса
        formId = '#' + htmlPrefix + '-form';
        cityUl = $('#' + htmlPrefix + '-city-ul');
        avatarNode = $('#' + htmlPrefix + '-avatar-img');
    };
    /**
     * составить id поля формы
     * @param fieldName
     * @returns {Mixed|jQuery|HTMLElement}
     */
    var getSipleField = function (fieldName) {
        var nodeId = formId + ' [name="UserProfile[' + fieldName + ']"]';
        return $(nodeId);

    };
    var getMessageNode = function(messageType) {
        var nodeId = formId +' [name="' + messageType +'"]' ;
        return $(nodeId) ;
    } ;
    var getCityId = function () {
        var cityNodeName = cityUl.attr('name');     // текущий элемент - город
        var arr = cityNodeName.split('-');
        var cityId = arr[arr.length - 1];
        return cityId;

    };
    var getImgFile = function () {
        imgFile = '';
        var imgFilePath = avatarNode.attr('src');
        if (imgFilePath.length > 0) {
            var aa = imgFilePath.split('/');
            var imgFile = aa[aa.length - 1];
            return imgFile;
        }
    };
    this.save = function () {
        var opcod = 'save';
        var email = (getSipleField('email')).val();
        var site = (getSipleField('site')).val();
        var tel = (getSipleField('tel')).val();
        var company = (getSipleField('company')).val();
        var info = (getSipleField('info')).val();
        var cityId = getCityId();
        var imgFile = getImgFile();
        var data = {
            opcod: opcod,
            "UserProfile": {
                "email": email,
                "site": site,
                "tel": tel,
                "company": company,
                "info": info,
                "avatar": imgFile,
                "city_id": cityId
            }
        };
        ajaxExe.setUrl(url) ;
        ajaxExe.setData(data) ;
        ajaxExe.setCallback(profileResult) ;
        ajaxExe.go() ;

    };
    /**
     * $answ = [
     'opcod' => $opcod,
     'success' => $success,
     'message' => $message,
     'confirmationMessage' => $confirmationMessage,    // ссобщение о подтверждении почты
     'attributes' => $userProfile->attributes,
     'oldAttributes' => $oldAttributes,
     'avatarUrl' => $avatarUrl,
     'z_end' => 'end'
     ];
     * @param rr
     */
    var profileResult = function (rr) {
        var success = rr['success'] ;
        var messageNode = getMessageNode('form-messages') ;
        var messageError = getMessageNode('form-messages-error') ;
        var messageSuccess = getMessageNode('form-messages-success') ;
        messageNode.empty() ;
        messageError.empty() ;
        messageSuccess.empty() ;
        var message = rr['message'] ;
        if (success) {
            messageSuccess.append('<strong>-----oK!------</strong>');
        }else {
                for (var rule in message) {
                    var messageText = message[rule];
                    for (var i = 0; i < messageText.length; i++) {
                        messageError.append(messageText[i] + '<br>');
                    }
                }

        }
        var confirmationFlag = rr['attributes']['confirmation_flag'];
        if (!confirmationFlag) {
            showError(rr.confirmationMessage);
        }
    } ;
}