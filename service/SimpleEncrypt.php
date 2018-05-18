<?php
/**
 * Простое шифрование. Используеся для формирования строки-параметра
 * при передаче по email
 * Time: 19:14
 */

namespace app\service;


class SimpleEncrypt
{
    private $namedEncrypts = [
        'order' => ['start' => 0, 'step' => 2, 'len' => -1],
        'orderSelected' => ['start' => 1, 'step' => 2, 'len' => -1],
    ];
    private $currentEncrypt = ['start' => 0, 'step' => 2, 'len' => -1];

    //--------------------------------------------//

    /**
     * установить ключ шифра
     * @param string $name
     * @param int $start
     * @param int $step
     * @param int $len
     */
    public function setKey($name = 'zz', $start = -1, $step = -1, $len = -1)
    {
        if (isset($this->namedEncrypts[$name])) {
            $this->currentEncrypt = $this->namedEncrypts[$name];
        }
        foreach ($this->currentEncrypt as $key => $value) {
            if ($$key >= 0) {
                $this->currentEncrypt[$key] = $$key;
            }
        }
        return $this ;
//        var_dump($this->currentEncrypt) ;
    }
    public function encryptDo($baseString) {
        $result = '' ;
        $start = $this->currentEncrypt['start'] ;
        $step =  $this->currentEncrypt['step'] ;
        $len =   $this->currentEncrypt['len'] ;
        for ($i = $start ; $i < strlen($baseString); $i += $step) {
            $result .= $baseString[$i] ;
        }
        if ($len > 0 && strlen($result) > $len) {
            $result = substr($result,0,$len) ;
        }
        return $result ;
    }

    /**
     * получить ключ для расшифровки( это и есть цель расшифровки)
     * настройка по двум первым символам $encriytString
     * @param $baseString
     * @param $encryptString
     * @return array - при неудаче  false
     */
    public function getUnencryptKey($baseString, $encryptString) {
        $startSymb = $encryptString[0] ;
        $secondSymb = $encryptString[1] ;
        $start = $this->getStart($baseString,$startSymb) ;
        if (false === $start) {
            return false ;
        }
        $step =  $this->getStep($baseString,$secondSymb,$start) ;
        if (!$step) {
            return false ;
        }

        $this->currentEncrypt['start'] = $start ;
        $this->currentEncrypt['step'] = $step ;
        $this->currentEncrypt['len'] = strlen($encryptString) ;
        $res = $this->encryptDo($baseString) ;
        $res = (strlen($res) > strlen($encryptString)) ?
            substr($res,0,strlen($encryptString)) : $res ;
        $key = false ;
        $len = strlen($encryptString) ;
        if ($res === $encryptString) {
            $key = ['start' => $start, 'step' => $step, 'len' => $len];
        }
        return $key ;
    }
    private function getStart($baseString,$startSymb) {
        $start = false ;
        for ($i=0; $i < strlen($baseString); $i++) {
            if ($baseString[$i] === $startSymb) {
                $start = $i ;
                break ;
            }
        }
        return $start ;
    }
    private function getStep($baseString,$secondSymb,$start) {
        $step = false ;
        for ($i = $start+1; $i < strlen($baseString); $i++) {
            if ($baseString[$i] === $secondSymb) {
                $step = $i - $start ;
                break ;
            }
        }
        return $step ;
    }

}