<?php
/**
 *  Редактирование фильтра для списка заказов
 */

namespace app\models;
use Yii;
use yii\base\Model;
use app\models\OrderStatFunc ;
use app\service\PageItems ;
use app\service\TaskStore ;
use app\models\FilterForm ;

class OrderMailingFilterForm  extends FilterForm
{
    protected $FILTER_NAME = 'orderMailingFilter' ;
    public $workRank;
    public $geographyRank ;
    //---------------------------------//
    public function attributeLabels()
    {
//        $labelTab = PageItems::getItemText(['user', 'fields']);

        return [
            'workRank' => 'Min уровень совпадения по работам(%)',
            'geographyRank' => 'Min уровень совпадения по месту(%)',
        ];
    }
    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['workRank', 'geographyRank'],'required'],
        ];
    }
    protected function defaultFilter() {
        $this->workRank = OrderStatFunc::MIN_TOTAL_RANK;
        $this->geographyRank = OrderStatFunc::MIN_GEOGRAPHY_RANK;
        return [
            'workRank' => $this->workRank,
            'geographyRank' => $this->geographyRank,
        ] ;

    }



}