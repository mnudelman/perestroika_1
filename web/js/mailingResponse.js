/**
 *   обслужимание форм ответов на почтовые извещения
 */
/**
 * изменение статуса заказа
 *
 * @param type  - тип email ответа (см. MailingFunc.php)
 * @param orderId     - заказ
 * @param developerId - исполнитель
 * @param recipientRole - получатель ответа - poль(developer | customer)
 * @param recipientId  -   получатель ответа - Id
 */
function emailOrderStatOkAnswer(type,orderId,developerId,recipientRole,recipientId) {
    var cnt = getEmailAnswerController() ;
    var actionFlag = 1 ;    // выполнить изменение статуса заказа
    cnt.orderStatAnswer(actionFlag,type,orderId,developerId,recipientRole,recipientId) ;
}
/**
 * переход в офис без изменение статуса
 *
 * @param type  - тип email ответа (см. MailingFunc.php)
 * @param orderId     - заказ
 * @param developerId - исполнитель
 * @param recipientRole - получатель ответа - poль(developer | customer)
 * @param recipientId  -   получатель ответа - Id
 */
function emailOrderStatOfficeAnswer(type,orderId,developerId,recipientRole,recipientId) {
    var cnt = getEmailAnswerController() ;
    var actionFlag = 0 ;    // без выполнения изменений статуса заказа
    cnt.orderStatAnswer(actionFlag,type,orderId,developerId,recipientRole,recipientId) ;

}

/**
 * Завершение регистрации
 * @param type
 * @param recipientId
 */
function emailRegistrationAnswer(type,recipientId) {
    var cnt = getEmailAnswerController() ;
    cnt.registrationAnswer(type,recipientId) ;
}
/**
 * ответ в форме подтверждения на изменение состояния заказа
 * в зависимости от ответа ИСПОЛНИТЕЛЯ на запрос ЗАКАЗЧИКА
 * @param answer = {order | orderSelected }-       // имя вопроса
 *                  userId-orderId-
 *                  {yes|no|office}               // варианты ответа
 */
function orderStatAnswer(answer) {
    var arr = answer.split('-');
    var answerName = arr[0];
    var userId = arr[1];
    var orderId = arr[2];
    var answerType = arr[3]; // yes | no | office
    var objName = 'orderAnswerController';
    var cnt = paramSet.getObj(objName);
    if (cnt === null) {
        cnt = new MailingResponse();
        paramSet.putObj(objName, cnt);
    }
    cnt.answerDo(answerName,userId,orderId,answerType) ;
}   
function getEmailAnswerController() {
    var objName = 'emailAnswerController';
    var cnt = paramSet.getObj(objName);
    if (cnt === null) {
        cnt = new emailAnswerController();
        paramSet.putObj(objName, cnt);
        cnt.init() ;
    }
    return cnt ;

}
function emailAnswerController() {
    var ajaxExe = null ;
    var urlPrefix = 'index.php?r=' + 'mailing-response' + '%2F' ;

    var url = {
        order: urlPrefix + 'order-answer',
        registration: urlPrefix + 'regisration-answer'
    };
    var _this = this ;
    //-------------------------------------------------//
    this.init = function (html) {
        ajaxExe = new AjaxExecutor() ;
    } ;
    this.orderStatAnswer = function (actionFlag,type,orderId,developerId,recipientRole,recipientId) {
        var data = {
            actionFlag: actionFlag,
            type: type,
            orderId: orderId,
            developerId: developerId,
            recipientRole: recipientRole,
            recipientId: recipientId
        } ;
        ajaxExe.setUrl(url.order) ;
        ajaxExe.setData(data) ;
        ajaxExe.setCallback(resShow) ;
        ajaxExe.go() ;

    } ;
    this.registrationAnswer = function(type,recipientId) {
        var data = {
            type: type,
            recipientId: recipientId
        } ;
        ajaxExe.setUrl(url.registration) ;
        ajaxExe.setData(data) ;
        ajaxExe.setCallback(resShow) ;
        ajaxExe.go() ;

    } ;
    /**
     * возврат только в случае ошибки
     * @param rr
     */
    var resShow = function (rr) {
        var success = rr['success'] ;
        var message = rr['message'] ;
        // });
        // var href = $('#emailAnswerOfficeButton').attr('href') ;
        // var newWin = window.open(href,'office') ;
    } ;

}