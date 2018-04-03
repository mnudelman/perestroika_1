/**
 *   обслужимание форм ответов на почтовые извещения
 */

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

/**
 * ответ - подтверждение регистрации
 */
function confirmationAnswer() {

}
function MailingResponse() {
    var ajaxExe = null ;
    var urlPrefix = 'index.php?r=' + 'mailing-response' + '%2F' ;

    var url = urlPrefix + 'order-answer' ;
    var _this = this ;
    //-------------------------------------------------//
    this.init = function (html) {
        htmlPrefix = html ;
        ajaxExe = new AjaxExecutor() ;

    } ;
    this.answerDo = function (answerName,userId,orderId,answerType) {
        if (ajaxExe === null) {
            ajaxExe = new AjaxExecutor() ;
        }
        var data = {
            answerName: answerName,
            userId: userId,
            orderId: orderId,
            answerType: answerType
        } ;
        ajaxExe.setUrl(url) ;
        ajaxExe.setData(data) ;
        ajaxExe.setClallback(resShow) ;
        ajaxExe.go() ;
    } ;
    var resShow = function (rr) {

    } ;
    this.orderAnswer = function (userId,orderId,answerType) {
        var data = {
            orderId:orderId,
            userId: userId,
            answerType: answerType
        } ;
        ajaxExe.setUrl(url.order) ;
        ajaxExe.setData(data) ;
        ajaxExe.setCallback(resShow) ;
        ajaxExe.go() ;

    };
}