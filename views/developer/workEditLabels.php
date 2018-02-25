<?php
/**
 * подписи для форм редактирования geographyWorks, developerWorks
*/
use app\service\PageItems ;


$tooltips = PageItems::getItemText([$pageItemFile, 'tooltips']);
$partsTitle = PageItems::getItemText([$pageItemFile, 'partsTitle']);
$buttons = PageItems::getItemText([$pageItemFile, 'buttons']);
$rules =  PageItems::getItemText([$pageItemFile, 'rules']);



$ruleTitle = $rules['rules/title'];
$ruleContent = $rules['rules/content'];


$toolTipItemEdit = $tooltips['tooltips/itemEdit'] ;
$toolTipItemAdd = $tooltips['tooltips/itemAdd'] ;

$btSave = $buttons['buttons/save'] ;

$toolTipItemFullyYes = $tooltips['tooltips/itemFully/yes'] ;
$toolTipItemFullyNo = $tooltips['tooltips/itemFully/no'] ;
$toolTipItemDeleteYes = $tooltips['tooltips/itemDelete/yes'] ;
$toolTipItemDeleteNo = $tooltips['tooltips/itemDelete/no']  ;
$toolTipSubItemInWorkYes = $tooltips['tooltips/subItemInWork/yes']  ;
$toolTipSubItemInWorkNo = $tooltips['tooltips/subItemInWork/no']  ;
$partsTitleCurrent = $parts['parts/current'] ;
$partsTitleAdd = $parts['parts/add'] ;
$partsTitleEdit = $parts['parts/edit'] ;

$dirLayoutParts = '../layouts/layoutParts' ;
