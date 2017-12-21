$(function () {
    $('#orderwork_per_beg').change(function (event) {
        var i = 1;
    });
    $('#orderwork_per_beg').on('blur', function () {
        var i = 1;
    });

});
/**
 * перехватывает click по ярлыкам закладок
 *
 */
$(function () {
    $('[name$="-header"]').click(function () {
        var name = $(this).attr('name');
        var arr = name.split('-');
        var contextName = arr[0];
        if (contextName === 'orderEdit') {    // отправляем диспетчерезацию в контроллер
            var tabName = arr[1];       // закладка имя
            var tabNames = ['works', 'additional', 'mailing']; // список диспетчерезуемых разделов
            if (tabNames.indexOf(tabName) >= 0) {
                var contextName = 'orderEdit';
                var controller = paramSet.getController(contextName);
                controller.tabInit(tabName);       ///   orderWorkEdit() ;
            }
        }
    });
});

/**
 * информационная строка о № текущего заказа
 * @constructor
 */
function OrderLabel() {
    var generalHtmlPrefix = 'orderEdit';
    var currentHtmlPrefix = '';
    var orderLabelNode = $('#' + 'htmlPrefix' + '-order-label');
    var generalOrderLabelNode = $('#' + generalHtmlPrefix + '-order-label');
    var generalOrderNameField = $('#orderwork-order_name');
    this.init = function (htmlPrefix) {
        currentHtmlPrefix = htmlPrefix;
    };
    this.showLabel = function (htmlPrefix) {
        var label = makeLabel();
        var firstLetter = (htmlPrefix.substr(0, 1)).toUpperCase();
        var tail = htmlPrefix.substr(1);
        var currentPart = firstLetter + tail;
        orderLabelNode = $('#' + generalHtmlPrefix + currentPart + '-order-label');
        var p = orderLabelNode.children('p');
        p.empty();
        p.append(label);

    };
    var makeLabel = function () {
        var p = generalOrderLabelNode.children('p');
        var orderNumber = p.text();
        var name = generalOrderNameField.val();
        var label = orderNumber + ' - ' + name;
        return label;
    };
}

/**
 * Created by michael on 17.02.17.
 */
function expressRegistration(opCod) {
    if (opCod === 'registration') {
        $("#registration-form").modal('show');
    }
    if (opCod === 'login') {
        $("#enter-form").modal('show');

    }
    if (opCod === 'continue') {
        expressRegistrationContinue();

    }


    //$("#registration-form").on('hidden.bs.modal',expressHide) ;
    $("#enter-form").on('hidden.bs.modal', expressHide);

}

function expressRegistrationContinue() {
    var formFields = $('#express-registration-form').find('[name^="UserProfile["]');
    var expressForm = {};
    for (var i = 0; i < formFields.length; i++) {
        var item = $(formFields[i]);
        var id = item.attr('id');
        var arr = id.split('-');
        var name = arr[1];
        expressForm[name] = item.val();

    }
    var ajaxExe = new AjaxExecutor(); // собственный исполнитель запроса
    var url = 'index.php?r=' + 'user' + '%2Fexpress-registration';
    var opCod = 'expressRegistration';
    var data = {
        opCod: opCod,
        expressForm: expressForm
    };
    ajaxExe.setUrl(url);
    ajaxExe.setData(data);
    ajaxExe.setCallback(expressRegistrationContinueResult);
    ajaxExe.go();


}

/**
 * $answ = [
 'opcod' => 'expressRegistration',
 'success' => $success,
 'message' => $message,
 'confirmationMessage' => $confirmationMessage,    // ссобщение о подтверждении почты
 'userProfile' => $userProfile->attributes,
 'userIsGuest' => true|false
 'z_end' => 'end'
 ];
 * @param rr
 */
function expressRegistrationContinueResult(rr) {
    var formMessage = $('#express-registration-form').find('[name="form-messages-success"]');
    if (rr['success'] === true) {
        formMessage.empty();
        formMessage.append('<strong>-----oK!------</strong>');
        var confirmationFlag = rr['userProfile']['confirmation_flag'];
        if (!confirmationFlag) {
            showError(rr.confirmationMessage);
        }
        var userIsGuest = rr['userIsGuest'];
        if (!userIsGuest) {
            paramSet.putObj('login', rr['userLogin']);
            paramSet.putObj('profile', rr['userProfile']);
            registrationShow();
            if (!confirmationFlag) {
                showError(rr.confirmationMessage);
            } else {
                $('[name^="order-express"]').hide();
                $('[name^="order-general"]').attr('class', 'active');
            }
        }
    } else {
        formMessage = $('#express-registration-form').find('[name="form-messages-error"]');
        var message = rr['message'];
        formMessage.empty();
        for (var rule in message) {
            var messageText = message[rule];
            for (var i = 0; i < messageText.length; i++) {
                formMessage.append(messageText[i] + '<br>');
            }
        }
    }

}

/**
 * при успешной регистрации вывести имя и переопределить поля главвного меню
 */
function registrationShow() {
    var login = paramSet.getObj('login');
    var userName = login.username;
    $('#topmenu-logout').removeAttr('hidden');
    $('#topmenu-logout')[0].className = 'enable';
    $('#topmenu-enter').attr('hidden', 'hidden');
    $('#topmenu-registration').attr('hidden', 'hidden');
    $('#topmenu-forum')[0].className = 'enable';

    $('#topmenu-forum')[0].className = 'enable';
    $('#topmenu-profile')[0].className = 'enable';
    $('#topmenu-office')[0].className = 'enable';
    $('#topmenu-username').text(userName);

    $('#userregistration-username').attr('readonly', 'readonly');
    $('#userregistration-enterpassword').attr('readonly', 'readonly');
    $('#userregistration-enterpassword_repeat').attr('readonly', 'readonly');

}

function expressHide() {
    var loginObj = paramSet.getObj('login');
    var userId = loginObj['userId'];
    var isGuest = loginObj['userIsGuest'];
    if (!isGuest) {
        var profile = paramSet.getObj('profile');
        var confirmationFlag = false; //profile['confirmation_flag'] ;

        if (confirmationFlag) {
            $('[name^="order-express"]').hide();
            $('[name^="order-general"]').attr('class', 'active');
        } else {     // постановка полей из profile
            var formFields = $('#express-registration-form').find('[name^="UserProfile["]');
            var expressForm = {};
            for (var i = 0; i < formFields.length; i++) {
                var item = $(formFields[i]);
                var id = item.attr('id');
                var arr = id.split('-');
                var name = arr[1];
                item.val(profile[name]);

            }

        }

    }

}

$('[href^="#w0-tab"]').click(function () {
    var elem = $(this);
    var li = elem.parent('li');
    var href = elem.attr('href');
});

function expressShow() {
    var expressGroup = $('[name^="order-express"]');
    if (expressGroup.length > 0) {
        var loginObj = paramSet.getObj('login');
        var userId = loginObj['userId'];
        var isGuest = loginObj['userIsGuest'];
        if (isGuest) {
            $('[name^="order-express"]').show();
        }

    }
}

/**
 * объект "Редактирование заказа"
 */
function OrderDataEdit() {
    var contextName;               // это htmlPrefix для элементов страницы
    var htmlContext;
    var ajaxExe;
    var urlPrefix = 'index.php?r=' + 'order' + '%2F';
    var url = {
        orderCreate: urlPrefix + 'create-order',
        orderSave: urlPrefix + 'save-order',
        orderCopy: urlPrefix + 'copy-order',
        orderDelete: urlPrefix + 'delete-order',
        orderItemEdit: urlPrefix + 'edit-order',
        orderSetFilter: urlPrefix + 'set-filter-order',
        orderGetFilter: urlPrefix + 'get-filter-order'
    };


    var _this = this;
    //-------------------------------------------//
    this.init = function (ctxtName, context) {
        contextName = ctxtName;
        htmlContext = context['html'];
        htmlContext.init(contextName);
        ajaxExe = new AjaxExecutor(); // собственный исполнитель запроса
    };
    this.orderEdit = function (opCod) {
        switch (opCod) {
            case 'create' :
                orderCreate();
                break;
            case 'copy' :
                orderCreateByCopy();
                break;
            case 'save' :
                orderSave();
                break;
            case 'delete' :
                orderDelete();
                break;
            case 'setFilter' :
                _this.orderSetFilter();
        }
    };
    /**
     * создать заказ
     */
    var orderCreate = function () {
        var opCod = 'orderCreate';
        var generalData = htmlContext.getGeneral();
        var data = {
            opCod: opCod
        };
        ajaxExe.setUrl(url.orderCreate);
        ajaxExe.setData(data);
        ajaxExe.setCallback(resultShow);
        ajaxExe.go();

    };
    var resultShow = function (rr) {
        var success = rr['success'];
        if (success) {
            if (rr['currentOrder'] !== undefined) {
                var currentOrder = rr['currentOrder'];
                paramSet.putObj('currentOrder', currentOrder);
            }

        }
        if (rr['message'] !== undefined) {
            var message = rr['message'];
            var type = (success) ? 'success' : 'error';
            htmlContext.messageClear('general');
            htmlContext.showMessage('general', type, message);
        }
        if (rr['orderGeneral'] !== undefined) {
            var orderGeneral = rr['orderGeneral'];
            var name = orderGeneral['orderName'];
            var id = orderGeneral['orderId'];
            var timeCreate = orderGeneral['timeCreate'];
            htmlContext.orderLabelShow(id, timeCreate);
            htmlContext.showGeneral(orderGeneral);
        }
        // элемент множества для отображения в правой части
        if (rr['orderSetItem'] !== undefined) {
            var orderSetItem = rr['orderSetItem'];
            //    return [
            //        'id' => $id,
            //        'name' => $fullName,
            //        'fullyFlag' => false,
            //        'editFlag' => true,
            //        'subItems' => $subItems,
            //];
            currentOrder = {
                id: orderSetItem['id'],
                name: orderSetItem['name'],
                fullyFlag: false,
                editFlag: true
            };
            var subItems = orderSetItem['subItems'];
            htmlContext.addOrderToLeftPart(currentOrder, subItems);
        }
        if (rr['opCod'] !== undefined) {
            if (rr['opCod'] === 'orderDelete') {
                var orderId = rr['orderId'];
                htmlContext.deleteOrderFromLeftPart(orderId);
            }
        }

    };
    /**
     * создать копированием текущего
     */
    var orderCreateByCopy = function () {
        var opCod = 'orderCopy';
        var generalData = htmlContext.getGeneral();
        var data = {
            opCod: opCod
        };
        ajaxExe.setUrl(url.orderCopy);
        ajaxExe.setData(data);
        ajaxExe.setCallback(resultShow);
        ajaxExe.go();

    };
    /**
     * сохранить текущий
     */
    var orderSave = function () {
        var opCod = 'orderSave';
        var generalData = htmlContext.getGeneral();
        var data = {
            opCod: opCod,
            orderGeneral: generalData
        };
        ajaxExe.setUrl(url.orderSave);
        ajaxExe.setData(data);
        ajaxExe.setCallback(resultShow);
        ajaxExe.go();


    };
    /**
     * удалить заказ
     */
    var orderDelete = function () {
        var opCod = 'orderDelete';
        var generalData = htmlContext.getGeneral();
        var data = {
            opCod: opCod,
            orderGeneral: generalData
        };
        ajaxExe.setUrl(url.orderDelete);
        ajaxExe.setData(data);
        ajaxExe.setCallback(resultShow);
        ajaxExe.go();

    };
    /**
     * адаптер -  заглушка
     * @param id
     */
    this.setItemToggle = function (id) {
        var a = 1;
    };
    /**
     * адаптер для сответствия workDirection
     * @param idhttp://localhost/projects/perestroika/web/index.php#
     */
    this.setItemEdit = function (id) {
        _this.orderItemEdit(id);
    };

    /**
     * перенести для редактирования из левой части
     * @param orderId
     */
    this.orderItemEdit = function (orderId) {
        var opCod = 'orderSave';
        var generalData = {
            orderId: orderId
        };
        var data = {
            opCod: opCod,
            orderGeneral: generalData
        };
        ajaxExe.setUrl(url.orderItemEdit);
        ajaxExe.setData(data);
        ajaxExe.setCallback(resultShow);
        ajaxExe.go();

    };
    /**
     * запускаются страницы закладок, требующие
     * наличия выбранного заказа
     *             (new OrderLabel()).showLabel('workGalleryEdit') ;
     //            paramSet.putObj('phpGalleryController','order-work-gallery') ;  // меняем контроллер для галлереи
     //            (new GalleryController()).init() ;

     * @param tabName
     */
    this.tabInit = function (tabName) {
        (new OrderLabel()).showLabel(tabName);   // № и имя заказа
        var currentOrder = paramSet.getObj('currentOrder');
        var orderId = null;
        if ((currentOrder === null) || (orderId = currentOrder['orderId']) === null) { // сообщение
            var text = 'Не определён текущий заказ.<br>' +
                'Перейдите в закладку "общие" и определите заказ';
            showError(text);

            return;
        }


        switch (tabName) {
            case 'works' :        // работы
                _this.orderWorkEdit();
                break;
            case 'additional' :   // доп материалы
                paramSet.putObj('phpGalleryController', 'order-work-gallery');  // меняем контроллер для галлереи
                (new GalleryController()).init('orderEditAdditional');
                break;
            case 'mailing' :      // рассылка
                var cnt = paramSet.getController('orderEditMailing');
                cnt.tabInit();
                break;
        }
    };


    /**
     * преход на закладку редактирование работ
     */
    this.orderWorkEdit = function () {
        var $order = paramSet.getObj('currentOrder');


//        htmlContext.orderWorksLabelShow() ;   // сейчас не надо см. tabInit

        //--  переходим в контекст 'orderWorkDirectionEdit --//
        var currentOrder = paramSet.getObj('currentOrder');
        var orderId = null;
        if (currentOrder !== null && currentOrder !== undefined) {
            orderId = currentOrder['orderId'];
            if (orderId === null) {
                orderId = currentOrder['copyFromId'];
            }
        }
        if (orderId !== null) {
            //var elem = 'orderWorkDirectionEdit' + '-' + orderId ;
            var elem = 'orderEditWorks' + '-' + orderId;
            switchItemsSet(elem);
        } else {    // ссобщение с переходом на вкладку general
            var elem = 'orderEditWorks' + '-' + 'NULL';
            switchItemsSet(elem);

        }


    };
    /**
     * сохранить фильтр
     */
    this.orderSetFilter = function () {
        var opCod = 'orderSetFilter';
        var filterData = htmlContext.getFilter();
        var data = {
            opCod: opCod,
            orderFilter: filterData
        };
        ajaxExe.setUrl(url.orderSetFilter);
        ajaxExe.setData(data);
        ajaxExe.setCallback(setFilterGo);
        ajaxExe.go();

    };
    var setFilterGo = function (rr) {
        var success = rr['success'];
        if (rr['message'] !== undefined) {
            var message = rr['message'];
            var type = (success) ? 'success' : 'error';
            htmlContext.messageClear('filter');
            htmlContext.showMessage('filter', type, message);
        }
        if (success) {
            var orderList = rr['orderList'];
//            htmlContext.newLeftPart(orderList) ;
            paginationClick('orderEdit-1');
            htmlContext.hideFilter();
        }

    };
    /**
     * редактировать фильтр
     */
    this.orderEditFilter = function () {
        var opCod = 'orderGetFilter';
        var filterData = htmlContext.getFilter();
        var data = {
            opCod: opCod,
            orderFilter: filterData
        };
        ajaxExe.setUrl(url.orderGetFilter);
        ajaxExe.setData(data);
        ajaxExe.setCallback(getFilterGo);
        ajaxExe.go();

    };
    var getFilterGo = function (rr) {
        var orderFilter = rr['orderFilter'];
        htmlContext.showFilter(orderFilter);
    };

}

/**
 * расположение элементов на странице
 * @constructor
 */
function OrderDataEditHtml() {
    var htmlPrefix;
    var htmlPrefixOrderWorks = 'orderEditWorks';    //    'orderWorkDirectionEdit' ;
    var orderFormName = 'orderwork';
    var orderFormId = 'work-order-form';
    var general = {};
    var _this = this;
    var orderLabelNode;      // метка заказа
    var orderWorksLabelNode = $('#' + htmlPrefixOrderWorks + '-order-label');
    var filterNode = $('#' + htmlPrefix + '-filter');

    var filterFormPrefix = 'orderfilterform';
    var filterFormId = 'work-order-filter-form';
    var orderFilterNodes = {
        perBeg: $('#' + filterFormPrefix + '-perbeg'),
        perEnd: $('#' + filterFormPrefix + '-perend')
    };
    var messageDiv = {
        general: {
            success: $('#' + orderFormId).find('[name="form-messages-success"]'),
            error: $('#' + orderFormId).find('[name="form-messages-error"]')
        },
        filter: {
            success: $('#' + filterFormId).find('[name="form-messages-success"]'),
            error: $('#' + filterFormId).find('[name="form-messages-error"]')
        }
    };

    //----------------------------------------------------------//
    this.init = function (contextName) {
        htmlPrefix = contextName;
        general = {
            orderName: orderFormName + '-' + 'order_name',
            orderDescription: orderFormName + '-' + 'description',
            perBeg: orderFormName + '-' + 'per_beg',
            perEnd: orderFormName + '-' + 'per_end',
            cityId: htmlPrefix + '-' + 'city-ul'
        };
        orderLabelNode = $('#' + htmlPrefix + '-order-label');
        filterNode = $('#' + htmlPrefix + '-filter');

    };
    this.getGeneral = function () {
// это иллюстрация того, как сохранять(усли нужно) среду
        var oF = orderFormName;
        var html = htmlPrefix;
// -----------------------------------
        var result = {};
        for (var key in general) {
            var node = general[key];
            if (key === 'cityId') {
                var nodeName = $('#' + node).attr('name');
                var arr = nodeName.split('-');
                var cityId = arr[arr.length - 1];
                result[key] = cityId;
            } else {
                var value = $('#' + node).val();
                result[key] = value;
            }

        }
        return result;
    };
    /**
     * асинхроннность при выводе страны, региона, города
     * @param generalData
     */
    this.showGeneral = function (generalData) {
        for (var key in generalData) {
            var node = general[key];
            if (key === 'orderPlace') {
                var countryReady = new processExecute();
                var regionReady = new processExecute();
                var cityReady = new processExecute();
                //for (var key in workRegionList) {
                var iStep = 0;
                var placeComponents = ['country', 'region', 'city'];
                var componentsReady = {
                    country: countryReady,
                    region: regionReady,
                    city: cityReady
                };
                iStep = 0;
                var orderPlace = generalData['orderPlace'];
                var tmpTimer = setInterval(function () {
                    var stepName = placeComponents[iStep];
                    var readyObj = componentsReady[stepName];
                    var startFlag = readyObj.getStarted();
                    if (!startFlag) {
                        readyObj.setStarted();
                        var userStep = 'user' + (stepName[0]).toUpperCase() + stepName.substr(1);
                        var elem = orderPlace[userStep];
                        var elName = htmlPrefix + '-' + stepName + '-' + elem['id'];
                        simpleGeographyOnClick(elName, '', readyObj);
                    }
                    if (readyObj.getReady()) {
                        iStep++;
                        if (iStep >= placeComponents.length) {
                            clearInterval(tmpTimer);
                        }
                    }
                }, 300);
            } else {
                var value = generalData[key];
                $('#' + node).val(value);
            }
        }
    };
    this.messageClear = function (formName) {
        var msgDiv = messageDiv[formName];
        for (var key in msgDiv) {
            var message = msgDiv[key];
            message.empty();
        }
    };
    this.showMessage = function (formName, messageType, messages) {
        var msgDiv = messageDiv[formName];
        var msgDiv = messageDiv[formName][messageType];
        msgDiv.empty();
        for (var key in messages) {
            var messageText = messages[key];
            var text = '<b>' + key + ':</b>' + ' ' + messageText + '<br>';
            msgDiv.append(text);
        }
    };
    this.orderLabelShow = function (orderId, orderTimeCreate) {
        var $text = ((orderId === undefined || orderId.length === 0)) ? '№ xxxx <strong>(new)</strong>' :
            '№ ' + orderId + ' от ' + orderTimeCreate;
        var p = orderLabelNode.children('p');
        p.empty();
        p.append($text);

    };
    this.getGeneralOrderLabel = function () {
        var p = orderLabelNode.children('p');
        return p.text();
    };
    this.orderWorksLabelShow = function () {
        (new OrderLabel()).showLabel(htmlPrefixOrderWorks);
        //var p = orderWorksLabelNode.children('p') ;
        //p.empty() ;
        //p.append(label) ;

    };
    /**
     * очистить саписок существующих заказов
     * вывести заново
     */
    this.newLeftPart = function (orderList) {
        var html = new WorkDirectionEditHtml();
        html.init(htmlPrefix);
        html.setItemsClear();
        for (var ind in orderList) {
            var order = orderList[ind];
            var orderForShow = {
                id: order['id'],
                name: order['name'],
                fullyFlag: false,
                editFlag: true
            };
            var subItems = order['sumItems'];
            html.addSetItem(orderForShow, subItems);
        }
    };
    /**
     *
     * @param order             - заказ
     * @param orderAtrrributes  - атрибуты
     */
    this.addOrderToLeftPart = function (order, orderAtrrributes) {
        var html = new WorkDirectionEditHtml();
        html.init(htmlPrefix);
        html.addSetItem(order, orderAtrrributes);
    };
    this.deleteOrderFromLeftPart = function (orderId) {
        var html = new WorkDirectionEditHtml();
        html.init(htmlPrefix);
        html.delSetItem(orderId);
    };
    this.getFilter = function () {
        var perBegNode = orderFilterNodes.perBeg;
        var perEndNode = orderFilterNodes.perEnd;
        return {
            perBeg: perBegNode.val(),
            perEnd: perEndNode.val()
        };
    };
    this.showFilter = function (filter) {
        filterNode.show(500);
        var perBeg = filter['perBeg'];
        var perEnd = filter['perEnd'];
        var perBegNode = orderFilterNodes.perBeg;
        var perEndNode = orderFilterNodes.perEnd;
        perBegNode.val(perBeg);
        perEndNode.val(perEnd);

    };
    this.hideFilter = function () {
        filterNode.hide(500);
    }
}

/**
 * кнопки toolbar
 * @param opCod = {create| copy|save|delete}
 */
function orderEditClick(elem) {
    var arr = elem.split('-');
    var contextName = arr[0];
    var opCod = arr[arr.length - 1];
    var controller = paramSet.getController(contextName);
    controller.orderEdit(opCod);
}

/**
 * редактировать существующий заказ -
 * пренос из левой половины в правую
 */
function orderItemEdit(elem) {
    var arr = elem.split('-');
    var contextName = arr[0];
    var id = arr[arr.length - 1];
    var controller = paramSet.getController(contextName);
    controller.orderItemEdit(id);
}

/**
 * вкл/выкл фильтр orderGeneral
 * @param elem(htmlPrefix-opCod)
 */
function orderEditFilter(elem) {
    var filterNode = $('#orderEdit-filter');
//    filterNode.show(600) ;
    var arr = elem.split('-');
    var contextName = arr[0];
    var opCod = arr[arr.length - 1];
    opCod = (opCod === undefined) ? 'edit' : opCod;
    var controller = paramSet.getController(contextName);
    switch (opCod) {
        case 'save' :
            controller.orderSetFilter(opCod);
            break;
        case 'edit' :
            controller.orderEditFilter(opCod);
            break;
        {

        }
    }

}