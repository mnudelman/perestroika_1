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
use app\controllers\funcs\OrderStatFunc;

class DeveloperOrdersFilterForm  extends FilterForm
{
    protected $FILTER_NAME = 'developerOrdersFilter' ;
    public $perBeg;
    public  $perEnd;
    public $responseStat ;  // только заказы, требующие ответа
    public $responseStatList ;            // список состояний, определяемый  $onlyResponse
    public $statList ;            // все сотояния для роли "Я_ГСПОЛНИТЕЛЬ"
    private $USER_ROLE = 'developer' ;
    const DEFAULT_PERBEG = '2017-01-01' ;
    const DEFAULT_PEREND = '2050-12-31';
    //---------------------------------//
    public function attributeLabels()
    {
//        $labelTab = PageItems::getItemText(['user', 'fields']);

        return [
            'perBeg' => 'perBeg',
            'perEnd' => 'perEnd',
            'odersResponse' => 'только заказы, требующие ответа',
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
        $this->responseStat = false ; // по умолчанию все
        $this->getOrderFuncStatList() ;    // списки состояний
        return [
            'perBeg' => $this->perBeg,
            'perEnd' => $this->perEnd,
            'responseStat' => $this->responseStat,
            'responseStatList' => $this->responseStatList,
            'statList' => $this->statList,
        ] ;

    }
    private function getOrderFuncStatList() {
        $orderFunc = new OrderStatFunc() ;
        $userRole = $this->USER_ROLE ;
        $this->responseStatList = $orderFunc->getStatReadyList($userRole) ;
        $this->statList = $orderFunc->getStatList($userRole) ;

    }
    public function setFilter($filter) {
// добавить поля responseStatList, statList
        $this->getOrderFuncStatList() ;    // списки состояний
        $filter['responseStatList'] =  $this->responseStatList ;
        $filter['statList'] =  $this->statList ;
        $responseStatSource = $filter['responseStat'] ;
        $responseStat = false ;
        if (is_string($responseStatSource)) {
            $responseStat = ($responseStatSource === 'true') ;
        }else {
            $responseStat = $responseStatSource ;
        }
        $filter['responseStat'] = $responseStat ;
        parent::setFilter($filter);

    }

    public function setResponseStat($responseFlag = true) {
        $filter = $this->getFilter() ;
        $this->responseStat = $responseFlag ;
        $filter['responseStat'] = $this->responseStat ;
        $this->setFilter($filter) ;
        return $filter ;
    }
}