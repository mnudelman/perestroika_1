<?php
/**
 *  Редактирование фильтра для списка заказов
 */

namespace app\models;
use Yii;
use yii\base\Model;
use app\service\PageItems ;
use app\service\TaskStore ;
use app\models\FilterForm ;
use app\models\OrderStatFunc ;

class DeveloperOrdersFilterForm  extends FilterForm
{
    protected $FILTER_NAME = 'communicationFilter' ;
    public $perBeg;
    public  $perEnd;
    const DEFAULT_PERBEG = '2017-01-01' ;
    const DEFAULT_PEREND = '2050-12-31';
    //---------------------------------//
    public function attributeLabels()
    {
//        $labelTab = PageItems::getItemText(['user', 'fields']);

        return [
            'perBeg' => 'perBeg',
            'perEnd' => 'perEnd',
        ];
    }
    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['perBeg', 'perEnd'],'required'],
            [['perBeg','perEnd'],'validatePeriod'],
        ];
    }
    public function validatePeriod($attribute, $params) {
        $message = 'недопустимые границы интервала.Начала должно быть строго меньше окончания!' ;
        $dateBeg = strtotime($this->perBeg) ;
        $dateEnd = strtotime($this->perEnd) ;
        if ($dateBeg === -1 || $dateEnd === -1 || $dateBeg >= $dateEnd) {
            $this->addError($attribute, $message);
        }
    }
    protected function defaultFilter() {
        $this->perBeg = self::DEFAULT_PERBEG ;
        $this->perEnd = self::DEFAULT_PEREND ;
        return [
            'perBeg' => $this->perBeg,
            'perEnd' => $this->perEnd,
        ] ;

    }
}