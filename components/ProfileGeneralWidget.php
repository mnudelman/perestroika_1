<?php
/**
 * Главная страница профиля (основные сведения)
 */

namespace app\components;
use yii\base\Widget;
use Yii;
use app\models\MenuPath ;
use yii\helpers\Url ;

class ProfileGeneralWidget extends Widget
{
    public $htmlPrefix;
    public $disabled; // - true - запрет редактирования( только просмотр)
    public $IDFieldsFlag; // показывать или нет поля - идентификаторы (email, tel, site)
    public $content;
    private $contentDefault = ['tooltips' => true, 'rule' => true, 'toolbar' => true,
        'avatar' => true, 'formEdit' => true];

    public function init()
    {
        if (empty($this->content) || sizeof($this->content) === 0 ||
        sizeof($this->content) === 1 && $this->content[0] === '*') {
            $this->content = $this->contentDefault;
        }else {        // если раздел не указан -> его нет
            foreach ($this->contentDefault as $partKey => $partFlag) {
                if (!isset($this->content[$partKey])) {
                    $this->content[$partKey] = false ;
                }
            }
        }
    }

    public function run()
    {
        ob_start();
        $content = $this->content;
        $htmlPrefix = $this->htmlPrefix ;
        $disabled = $this->disabled; // - true - запрет редактирования( только просмотр)
        $IDFieldsFlag = $this->IDFieldsFlag; // показывать или нет поля - идентификаторы (email, tel, site)

        include __DIR__ . '/tpl/profileGeneralTpl.php';
        return ob_get_clean();
    }
}