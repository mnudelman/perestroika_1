<?php
/**
 * шаблон письма " //  подтверждение экспресс регистрации"
* @var $email
* @var $password
*/
$subject = 'экспресс регистрация' ;
$text = 'Для входа на сайт "PERE-STROIKA" используйте<br> ' .
    '<b>имя(login)</b>: ваш  email('.$email .')<br>' .
    '<b>пароль</b>:' .$password .' <br>' .
$referText = 'Для завершения регистрации пройдите по ссылке' ;
return [
    'subject' => $subject,
    'bodyText' => $text,
    'referText' => $referText,
] ;
