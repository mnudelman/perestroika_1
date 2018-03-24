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

}
function MailingResponse() {
    var url = {
        order: '',
        orderSelected: '',
        office: ''
    } ;
    var _this = this ;
    //-------------------------------------------------//
    this.init = function () {

    } ;
    this.goToOffice = function() {

    } ;
}