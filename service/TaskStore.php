<?php
/**
 * Сохраняет параметры задачи
 * Параметры должны быть из списка $paramList
 */

namespace app\service;


class TaskStore {
    private static $prefix = 'perestroika' ;
    private static $paramList = [
        'currentOrder',                    // текущий заказ
        'currentLanguage',                 // язык 'en' | 'ru'
        'currentDeveloper',                 // тек исполнитель
        'orderFilter',                      // фильтр отбора заказов (напр, по дате)
        'orderMailingFilter',               // фильтр отбора исполнителей заказа(по уровню соответствия)
        'developerOrdersFilter',            // фильтр ЗАКАЗОВ для ИСПОЛНИТЕЛЯ
        'menuPath',                         // путь меню от корня до тек пункта
        'timeZone',                          // временной пояс
        'mailingSetup',                      // настройка рассылки
    ] ;
    //-------------------------------------------------//
    public static function putParam($paramName,$value) {
        $prefix = self::$prefix ;
        $res = false ;
        $search = array_search($paramName,self::$paramList) ;
        if (false !== $search && $search >= 0) {
           $_SESSION[$prefix . '_' . $paramName] = $value ;
           $res = true ;
        }
        return $res ;
    }
    public static function getParam($paramName) {
        $prefix = self::$prefix ;
        $value = null ;
        $search = array_search($paramName,self::$paramList) ;
        if ($search !== false && isset($_SESSION[$prefix . '_' . $paramName])) {
            $value = $_SESSION[$prefix . '_' . $paramName]  ;
        }
        return $value ;
    }
}