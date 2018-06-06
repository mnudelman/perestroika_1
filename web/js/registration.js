/**
 * при регистрации требуется "возврат" в поле password для
 * проверки совпадения с полем "повторного ввода пароля"
 * если этого не делать остаётся сообщение о несовпадении полей
 */
$('#userregistration-enterpassword_repeat').on('blur',function() {
    $('#userregistration-enterpassword').blur() ;
}) ;
/**
 * Набор функций для подключения и регистрации
 */
function Registration() {
    var url = {
        login: 'index.php?r=site%2Flogin',
        logout: 'index.php?r=site%2Flogout',
        wDShow: 'index.php?r=site%2Fwork-direct-get',     // показать описатель направления работ
        registration: 'index.php?r=user%2Fregistration'
    };
    var wdBlock = {      // блок-описатель направления работ
        title: '#wd-description-title',
        content:'#wd-description-content'
    };
    var guestUsetName = 'гость'; // имя для вывода в topmenu (при смене языка будет guest)
    var guestAvatarImg = 'images/avatars/people.png'; // фото для гостя
    var userName = '' ;   //имя для вывода в  topmenu
    var ajaxExe;
    var _this = this;
    this.init = function () {
        ajaxExe = new AjaxExecutor();
    };
    /**
     * показать описатель направления работ wdId
     * @param wdId
     */
    this.wDShow = function (wdId) {
        var data = {wdId: wdId};
        ajaxExe.setUrl(url.wDShow);
        ajaxExe.setData(data);
        ajaxExe.setCallback(wdShowDo);
        ajaxExe.go();
    };
    var wdShowDo = function (rr) {
        var title = rr['title'];
        var content = rr['content'];
        var titleBlock = $(wdBlock.title);
        var contentBlock =$( wdBlock.content);
        // titleBlock.empty();
        titleBlock.text(title);
        // contentBlock.empty();
        contentBlock.text(content);
    };
    /**
     * отключение пользователя
     * @param guestName
     */
    this.logout = function (guestName) {
        guestUsetName = guestName;
        var data = '';
        ajaxExe.setUrl(url.logout);
        ajaxExe.setData(data);
        ajaxExe.setCallback(logoutRes);
        ajaxExe.go();
    };
    var logoutRes = function (rr) {
        var success = rr['success'];
        var message = rr['message'];
        if (rr['success'] === true) {
            logoutSuccess() ;
//             ---- отключение   -----             ///
            var login = paramSet.getObj('login');
            login = (login === null) ? {} : login;
            login['userId'] = null;
            login['userIsGuest'] = true;

            paramSet.putObj('login', login);
            // expressShow() ;  // доступ к эспресс регистрации - лишнее
        }

    };
    /**
     *  подключение пользователя
     */
    this.login = function () {
        var err = false;
        var arr = $('#login-form .help-block');
        for (var i = 0; i < arr.length; i++) {
            var item = arr[i];
            if ((item.textContent).length > 0) {
                err = true;
                break;
            }
        }
        if (err) {
            return;
        }
        $('#login-form [name="form-messages-success"]').empty();
        $('#login-form [name="form-messages-error"]').empty();

        userName = $('#loginform-username').val();
        var password = $('#loginform-password').val();
        var data = {
            "LoginForm": {
                "username": userName,
                "password": password
            }
        };
        ajaxExe.setUrl(url.login);
        ajaxExe.setData(data);
        ajaxExe.setCallback(loginRes);
        ajaxExe.go();
    };
    var loginRes = function (rr) {
        var success = rr['success'];
        var message = rr['message'];
        if (success) {
//      ---- сохранить в paramSet -----------    //
            var loginObj = {
                'userId': rr['userId'],
                'userIsGuest': rr['userIsGuest'],
                'avatar': rr['avatar']
            };
            paramSet.putObj('login', loginObj);
            var profile = rr['profile'];
            paramSet.putObj('profile', profile);
//       ------------------------------------------   //

             loginSuccess() ;

            var avatar = rr['avatar'];
            if (avatar.length > 0) {
                var urlAvatar = rr['urlAvatar'];
                var avatarPath = urlAvatar + '/' + avatar;
                $('#topmenu-avatar').attr('src', avatarPath);
            }
            $('#enter-form').modal('hide');     // закрыть форму
        } else {

            for (var rule in message) {
                var messageText = message[rule];
                for (var i = 0; i < messageText.length; i++) {
                    $('#login-form [name="form-messages-error"]').append(messageText[i] + '<br>');
                }
            }
        }
    };
    /**
     * регистрация пользователя
     */
    this.registration = function() {
        // собщения автономного контроля
        var err = false;
        var arr = $('#registration-form .help-block');
        for (var i = 0; i < arr.length; i++) {
            var item = arr[i];
            if ((item.textContent).length > 0) {
                err = true;
                break;
            }
        }
        if (err) {
            return;
        }

        userName = $('#userregistration-username').val();
        var password = $('#userregistration-enterpassword').val();
        var password_repeat = $('#userregistration-enterpassword_repeat').val();
        imgFile = '';
        var data = {
            "UserRegistration": {
                "username": userName,
                "enterPassword": password,
                'enterPassword_repeat': password_repeat
            }
        };
        $('#registration-form [name="form-messages-success"]').empty();
        $('#registration-form [name="form-messages-error"]').empty();
        ajaxExe.setUrl(url.registration);
        ajaxExe.setData(data);
        ajaxExe.setCallback(registrationRes);
        ajaxExe.go();
    } ;
    /**
     * расстановка атрибутов при удачном подключении
     */
    var loginSuccess = function() {
        $('#topmenu-logout').removeAttr('hidden') ;
        $('#topmenu-logout')[0].className = 'enable';
        $('#topmenu-enter').attr('hidden','hidden') ;
        $('#topmenu-registration').attr('hidden','hidden') ;
        $('#topmenu-forum')[0].className = 'enable';
        $('#topmenu-forum').removeAttr('hidden') ;
        $('#topmenu-profile')[0].className = 'enable';
        $('#topmenu-profile').removeAttr('hidden') ;
        $('#topmenu-office')[0].className = 'enable';
        $('#topmenu-office').removeAttr('hidden') ;
        $('#topmenu-username').text(userName);
    } ;
    var logoutSuccess = function() {
        $('#topmenu-logout').attr('hidden', 'hidden');
        $('#topmenu-enter').removeAttr('hidden');
        $('#topmenu-registration').removeAttr('hidden');
        $('#topmenu-forum')[0].className = 'disabled';
        $('#topmenu-forum').attr('hidden', 'hidden');
        $('#topmenu-enter')[0].className = 'enable';
        $('#topmenu-registration')[0].className = 'enable';
        $('#topmenu-registration').removeAttr('hidden');
        $('#topmenu-profile')[0].className = 'disabled';
        $('#topmenu-profile').attr('hidden', 'hidden');
        $('#topmenu-office')[0].className = 'disabled';
        $('#topmenu-office').attr('hidden', 'hidden');
        $('#topmenu-username').text(guestUsetName);
        $('#topmenu-avatar').attr('src', guestAvatarImg);

    } ;
    /**
     * отправить данные регистрации
     * данные непосредственно регистрации (username, password)
     */
    var registrationRes = function(rr) {
        var success = rr['success'];
        var message = rr['message'];
        if (rr['successUser'] === true) {               // регистрация выполнена
            loginSuccess() ;

            $('#userregistration-username').attr('readonly','readonly');
            $('#userregistration-enterpassword').attr('readonly','readonly');
            $('#userregistration-enterpassword_repeat').attr('readonly','readonly');

            $('#registration-form [name="form-messages-success"]').
            append(rr['messageRegistration'] + '<br>');
            var login = rr['login'] ;
            paramSet.putObj('login',login) ;
        }else {
            $('#registration-form [name="form-messages-error"]').
            append(rr['messageRegistration'] + '<br>');
        }
        if (!success) {

            for (var rule in message) {
                var messageText = message[rule];
                for (var i = 0; i < messageText.length; i++) {
                    $('#registration-form [name="form-messages-error"]').append(messageText[i] + '<br>');
                }
            }
        }

    } ;
}

/**
 * загрузка контроллера
 */
function registrationLoad() {
    var cnt = paramSet.getObj('registrationController') ;
    if (cnt === null) {
        cnt = new Registration() ;
        cnt.init() ;
        paramSet.putObj('registrationController',cnt) ;
    }
    return cnt ;
}
/**
 * определяет доступность пунктов главного меню,
 * открывает/зарывает возможность вывода форм :
 * подключения(login), регистрации(registration), редактир профиля(profile)
 * критерием является роль пользователя : гость(guest) | пользователь(user)
 * вызывается по onclick перед вызовом формы
 * определяется по состоянию эл-та списка - пункта меню "войти" (login)
 * если className = "enable" - значит пользователь-гость
 * нужна ли ????
 * @param isGuest
 */
function enterTargetControl(isGuest) {
    isGuest = (isGuest === undefined ) ? false : isGuest;
    var el = $('#topmenu-enter');
    var cl  = el[0].className ;
    isGuest = (cl === 'enable') ;
    var a = el.children('a')[0];
    a.dataset.target = (isGuest) ? '#enter-form' : '#';
// для кнопки registration тоже самое
    el = $('#topmenu-registration');
    a = el.children('a')[0];
    a.dataset.target = (isGuest) ? '#registration-form' : '#';
// для формы регистрации, попутно, открыть возможность редактирования
    if (isGuest) {   // очиститть поля от пред использования
        $('#userregistration-username').removeAttr('readonly');
        $('#userregistration-enterpassword').removeAttr('readonly');
        $('#userregistration-enterpassword_repeat').removeAttr('readonly');
        $('#registration-form [name="form-messages-success"]').empty() ;
        $('#registration-form [name="form-messages-error"]').empty() ;
    }
}

/**
 * показать описание направления работ
 * @param wdId
 */
function wdOnClick(wdId) {
    var cnt = registrationLoad() ;
    cnt.wDShow(wdId) ;
}
/**
 * отключить текущего пользователя от сайта
 * после этого сайт открыт для нового подключения/регистрации
 * @param guestName - имя пользователя - гость
 */
function logoutOnClick(guestName) {
    var cnt = registrationLoad() ;
    cnt.logout(guestName) ;
}
/**
 * отправить данные для login
 */
function loginOnClick() {
    var cnt = registrationLoad() ;
    cnt.login() ;
}

/**
 * форма регистрации
 */
function registrationOnClick() {
    var cnt = registrationLoad();
    cnt.registration();
}
