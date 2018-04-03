<?php
/**
 * Простое шифрование. Используеся для формирования строки-параметра
 * при передаче по email
 * Time: 19:14
 */

namespace app\service;


class SimpleEncript
{
    private $namedEncripts = [
        'order' => ['start' => 0, 'step' => 2, 'len' => -1],
        'orderSelected' => ['start' => 1, 'step' => 2, 'len' => -1],
    ];
    private $currentEncript = ['start' => 0, 'step' => 2, 'len' => -1];

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
        if (isset($this->namedEncripts[$name])) {
            $this->currentEncript = $this->namedEncripts[$name];
        }
        foreach ($this->currentEncript as $key => $value) {
            if ($$key >= 0) {
                $this->currentEncript[$key] = $$key;
            }
        }
    }
    public function encriptDo($baseString) {
        $result = '' ;
        $start = $this->currentEncript['start'] ;
        $step =  $this->currentEncript['step'] ;
        $len =   $this->currentEncript['len'] ;
        for ($i = $start ; $i < strlen($baseString); $i += $step) {
            $result .= $baseString[$i] ;
        }
        if ($len > 0 && strlen($result) > $len) {
            $result = substr($result,0,$len) ;
        }
        return $result ;
    }
    public function getKey($baseString,$encriptString) {
        $startSymb = $encriptString[0] ;
        $secondSymb = $encriptString[1] ;
        $start = $this->getStart($baseString,$startSymb) ;
        $step =  $this->getStep($baseString,$secondSymb,$start) ;
        $currentEncript['start'] = $start ;
        $currentEncript['step'] = $step ;
        $currentEncript['len'] = strlen($encriptString) ;
        $res = $this->encriptDo($baseString) ;
        $res = (strlen($res) > strlen($encriptString)) ?
            substr($res,0,strlen($encriptString)) : $res ;
        $key = ['start' => -1, 'step' => -1, 'len' => -1];
        $len = strlen($encriptString) ;
        if ($res === $encriptString) {
            $key = ['start' => $start, 'step' => $step, 'len' => $len];
        }
        return $key ;
    }
    private function getStart($baseString,$startSymb) {
        $start = -1 ;
        for ($i=0; $i < strlen($baseString); $i++) {
            if ($baseString[$i] === $startSymb) {
                $start = $i ;
                break ;
            }
        }
        return $start ;
    }
    private function getStep($baseString,$secondSymb,$start) {
        $step = -1 ;
        for ($i = $start+1; $i < strlen($baseString); $i++) {
            if ($baseString[$i] === $secondSymb) {
                $step = $i - $start ;
                break ;
            }
        }
        return $step ;
    }

}