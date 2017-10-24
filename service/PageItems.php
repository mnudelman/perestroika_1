<?php
/**
 * Используется для загрузки текстовых элементов web - страниц
 * из имени элемента формируется имя php - файла, из  которого извлекается
 * таблица вида [itemName => ['ru'=> ruText, 'en' => enText] ], из этой таблицы
 * формируется map в зависимости от текущего языка [itemName => value]
 * требуемый элемент задаётся массивом [itemName,itemPartName], где
 * itemPartName - id раздела (может отсутствовать)
 */
namespace app\service ;
use yii\helpers\ArrayHelper ;
use Yii ;
use app\service\TaskStore ;
class PageItems {
    private static $_pageItemPath ;
    private static $instance = null ;
    private static $_currentItemName = null ;
    private static $_currentItemTab = [] ;
    private function __construct() {
        self::$_pageItemPath = Yii::$app->basePath .'/appData/pageItems' ;

    }
    public static function getPageItemPath() {
        return self::$_pageItemPath ;
    }
    /*
     * Загрузка таблицы $_currentItemTab из php - файла
     * с именем '$itemName'.php
     */
    private static function uploadItemTab($itemName) {
        if (is_null(self::$instance)) {
            self::$instance = new self() ;
        }
        if (empty(self::$_currentItemName) || ! ($itemName === self::$_currentItemName)) {
            self::$_currentItemTab = [] ;
            self::$_currentItemTab = include  self::$_pageItemPath . '/' . $itemName .'.php' ;
            self::$_currentItemName = $itemName ;
        }
    }
    /*
     * метод, связанный с выдачей тектовых элементов в соответствии с
     * текущим языком приложения
     */
    public static function getItemText(array $itemPath) {
        $itemName = $itemPath[0] ;
        self::uploadItemTab($itemName) ;
        $pageItemTab = self::$_currentItemTab ;
        $sourceTab = $pageItemTab ;
        for ($i = 1; $i < count($itemPath); $i++) {
            $partName = $itemPath[$i] ;
            if (isset($sourceTab[$partName])) {
                $sourceTab = $sourceTab[$partName] ;
            }
        }
        $lang = self::getLang() ;
        return self::getMap($sourceTab,'text',$lang) ;
    }
    private static function getMap($sourceTab,$attrKey,$lang = null) {
        $result = [] ;
        foreach ($sourceTab as $key => $attrValue) {
            if (empty($attrKey)) {
                $result[$key] = $attrValue ;
            } elseif (isset($attrValue[$attrKey])) {
                $val = (is_null($lang)) ? $attrValue[$attrKey] : $attrValue[$attrKey][$lang] ;
                if (!is_null($val)) {
                    $result[$key] = $val ;
                }
            }elseif (!is_null($lang) && isset($attrValue[$lang])) {
                $val = $attrValue[$lang] ;
                if (!is_null($val)) {
                    $result[$key] = $val ;
                }
            }
        }
        return $result ;
    }
    private static function getLang() {
        $ln = TaskStore::getParam('currentLanguage') ;

        if (empty($ln)) {
            $ln = 'ru' ;
//          Yii::$app->language = $_SESSION['lang'] ;
            $arr = explode('-',Yii::$app->language) ;
        }
        return $ln ;
    }
    /**
     * получить атрибут из таблицы $_currentItemTab, не связаный с языком,
     * например, url
     */
    public static function getItemAttr($attrKey,array $itemPath,$langFlag = false) {
        $itemName = $itemPath[0] ;
        self::uploadItemTab($itemName) ;
        $partName = ( isset($itemPath[1]) ) ? $itemPath[1] : false ;
        $pageItemTab = self::$_currentItemTab ;
        $sourceTab = (false === $partName) ? $pageItemTab : $pageItemTab[$partName]  ;

        $lang = ($langFlag) ? self::getLang() : null ;

        return self::getMap($sourceTab,$attrKey,$lang) ;
    }
}