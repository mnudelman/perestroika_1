<?php
/**
 * шаблон письма " //  подтверждение экспресс регистрации"
* @var $user_email
* @var $user_password
*/
$subject = 'экспресс регистрация' ;
$text = 'Для входа на сайт "PERE-STROIKA" используйте<br> ' .
    '<b>имя(login)</b>: ваш  email('.$user_email .')<br>' .
    '<b>пароль</b>:' .$user_password .' <br>' ;
$referText = 'Для завершения регистрации пройдите по ссылке' ;
return [
    'subject' => $subject,
    'bodyText' => $text,
    'referText' => $referText,
] ;
