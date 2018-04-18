<?php
/**
 * класс операций по отправке email пользователям
 * Time: 19:26
 */

namespace app\controllers\funcs;


class MialingFunc {
    private $types = [
        'detailsCustomer' =>[    // реквизиты заказчика
            'urlAnswer' => '',
            'tpl' => '',
        ],
        'detailsDeveloper'=>[    // реквизиты исполнителя
            'urlAnswer' => '',
            'tpl' => '',
        ],
        'selectedRequest'=>[     // запрос ИСПОЛНИТЕЛЮ о согласии выполнить заказа
            'urlAnswer' => '',
            'tpl' => '',
        ],
        'readyRequest'=>[        // запрос ИСПОЛНИТЕЛЮ на участие в конкурсе на исполнение заказа
            'urlAnswer' => '',
            'tpl' => '',
        ],
        'registration' => [     // подтверждение регистрации
            'urlAnswer' => '',
            'tpl' => '',

        ],
        'express' => [            // экспресс регистрация
            'urlAnswer' => '',
            'tpl' => '',

        ],
    ] ;

    private $sendId ;


 public function setUser() {

 }
 public function setOrder() {

 }
 public function setType() {

 }
 public function sendDo() {

 }
}