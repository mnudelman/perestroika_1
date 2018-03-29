/**
 *   обслужимание форм ответов на почтовые извещения
 */
/**
 * ответ в форме подтверждения на выполнение заказа
 * @param answer = {0 - no  | 1 - yes | 2 - detail }
 */
function orderSelectedAnswer(answer) {

}

/**
 * ответ в форме подтверждения участия в конкурсе на выполнение работ
 * ответ 2 - detail должен отправить в КАБИНЕТ
 * @param answer = {0 - no  | 1 - yes | 2 - detail }
 */
function orderAnswer(answer) {
var arr = answer.split('-') ;
var userId = arr[0] ;
var orderId = arr[1] ;
var answerType = arr[2] ; // yes | no | office
    
}

/**
 * ответ - подтверждение регистрации
 */
function confirmationAnswer() {

}
function MailingResponse() {
    var htmlPrefix ;               // это htmlPrefix для элементов страницы
    var ajaxExe ;
    var urlPrefix = 'index.php?r=' + 'site' + '%2F' ;

   var url = {
        order: urlPrefix + 'order-answer',
        orderSelected: urlPrefix + 'order-selected-answer',
        office: urlPrefix + 'to-office'
    } ;
    var _this = this ;
    //-------------------------------------------------//
    this.init = function (html) {
        htmlPrefix = html ;
        ajaxExe = new AjaxExecutor() ;

    } ;
    var resShow = function (rr) {

    } ;
    this.goToOffice = function(userId) {
        var data = {
            userId: userId
        } ;
        ajaxExe.setUrl(url.office) ;
        ajaxExe.setData(data) ;
        ajaxExe.setCallback(resShow) ;
        ajaxExe.go() ;


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
        this.orderSelectedAnswer = function (userId,orderId,answerType) {
            var data = {
                orderId:orderId,
                userId: userId,
                answerType: answerType
            } ;
            ajaxExe.setUrl(url.orderSelected) ;
            ajaxExe.setData(data) ;
            ajaxExe.setCallback(resShow) ;
            ajaxExe.go() ;

    } ;
}