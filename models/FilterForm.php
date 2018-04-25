<?php
/**
 *  Базовый класс для установки фильтра
 */

namespace app\models;
use Yii;
use yii\base\Model;
use app\controllers\funcs\OrderStatFunc ;
use app\service\PageItems ;
use app\service\TaskStore ;

class FilterForm  extends Model
{
    protected $FILTER_NAME = 'orderMailingFilter' ;
//---  список полей в виде: (это требуется для использования механизма validate()
//  public $field1 ;
    //---------------------------------//
    public function attributeLabels()
    {
//        $labelTab = PageItems::getItemText(['user', 'fields']);

        return [
//            'field1' => 'имя1',
//            'field2' => 'имя2',
        ];
    }
    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
//            [['field1', 'field2'],'required'],
        ];
    }
    public function setFilter($filter) {
      if (is_array($filter)) {
          foreach($filter as $fieldName => $fieldValue) {
//            if (isset($this->$fieldName)) {
              $this->$fieldName = $fieldValue ;
//            }
          }
          if ($this->validate()) {
              TaskStore::putParam($this->FILTER_NAME,$filter) ;
          }
      }
    }
    public function getFilter() {
        $filter = TaskStore::getParam($this->FILTER_NAME) ;
        if (is_null($filter)) {
            $filter = $this->defaultFilter() ;
            TaskStore::putParam($this->FILTER_NAME,$filter) ;
        }
        return $filter ;
    }

    /**
     * фильтр по умолчанию
     * @return array
     */
    protected  function defaultFilter() {
        return [
//            'fld1' => $fld1Default,
//             ......................
        ] ;

    }


}

