<?php
/**
 * класс - обработка ответа по email
 * Time: 15:57
 */

namespace app\controllers\funcs;
use app\controllers\funcs\MailingFunc ;

class EmailResponseFunc extends MailingFunc
{
    public function responseDo($mailId) {
        $mailVect = $this->unencriptMailId($mailId) ;
        $this->currentType = $mailVect['type'] ;
    }
}