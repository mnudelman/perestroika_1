<?php
/**
 * шаблон ответа на письмо " //  подтверждение экспресс регистрации"
*/
$title = 'экспресс регистрация' ;
$bodyText = 'Для завершения регистрации нажмите "oK!' ;
$buttons = ['registration'] ;
return compact(['bodyText','title','buttons']) ;
