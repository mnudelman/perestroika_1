<?php
/**
 * вывод форм ответа пользователя на email запрос
 * Time: 13:37
 */

namespace app\components;

use yii\base\Widget;

class EmailAnswerWidget extends Widget
{
    public $title;
    public $bodyText;
    public $buttons;
    public $clickParms = [] ;             // параметры для onclick

    private $titlePrefix = 'ответ на email запрос: ';
    private $buttonsList = [
        'oK' => [
            'text' => 'oK!',
            'class' => 'btn-primary',
            'onclick' => 'emailOrderStatOkAnswer',
        ],
        'office' => [
            'text' => 'кабинет',
            'class' => 'btn btn-primary',
            'onclick' => 'emailOrderStatOfficeAnswer',

        ],
        'home' => [
            'text' => 'на главную',
            'class' => 'btn btn-primary',
            'onclick' => 'emailHomeAnswer',
        ],
        'registration' => [
            'text' => 'oK!',
            'class' => 'btn btn-primary',
            'onclick' => 'emailRegistrationAnswer',
        ],
    ];
    private $currentButtons = [];
    private $buttonStyle = "margin-left:13px;border-radius:5px"; // смещение между кнопками (px)

    public function init()
    {
        $this->currentButtons = [];
        for ($i = 0; $i < sizeof($this->buttons); $i++) {
            $btKey = $this->buttons[$i];
            $this->currentButtons[$btKey] = $this->buttonsList[$btKey];
        }
    }
    private function clickParmsDef() {
        $parmString = '' ;
        foreach ($this->clickParms as $parName => $parValue) {
            $sep = (empty($parmString)) ? '' : ',' ;
            $parValue = (is_string($parValue)) ?
                "'" . trim($parValue) . "'" : $parValue ;
            $parmString .= $sep . $parValue ;
        }
        return $parmString ;
    }
    public function run()
    {
        ob_start();
        $title = $this->titlePrefix . $this->title;
        $bodyText = $this->bodyText;
        $buttons = $this->currentButtons;
        $buttonStyle = $this->buttonStyle;
        $parmString = $this->clickParmsDef() ;
        include __DIR__ . '/tpl/emailAnswerTpl.php';
        return ob_get_clean();


    }


}