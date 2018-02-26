<?php
/**
 * подписи для форм редактирования geographyWorks, developerWorks
*/
use app\service\PageItems ;


$tooltips = PageItems::getItemText([$pageItemFile, 'tooltips']);
$partsTitle = PageItems::getItemText([$pageItemFile, 'partsTitle']);
$buttons = PageItems::getItemText([$pageItemFile, 'buttons']);
$rules =  PageItems::getItemText([$pageItemFile, 'rules']);
$parts =  PageItems::getItemText([$pageItemFile, 'partsTitle']);


$ruleTitle = $rules['title'];
$ruleContent = $rules['content'];


$toolTipItemEdit = $tooltips['itemEdit'] ;
$toolTipItemAdd = $tooltips['itemAdd'] ;

$btSave = $buttons['save'] ;

$toolTipItemFullyYes = $tooltips['itemFully/yes'] ;
$toolTipItemFullyNo = $tooltips['itemFully/no'] ;
$toolTipItemDeleteYes = $tooltips['itemDelete/yes'] ;
$toolTipItemDeleteNo = $tooltips['itemDelete/no']  ;
$toolTipSubItemInWorkYes = $tooltips['subItemInWork/yes']  ;
$toolTipSubItemInWorkNo = $tooltips['subItemInWork/no']  ;

$partsTitleCurrent = $parts['current'] ;
$partsTitleAdd = $parts['add'] ;
$partsTitleEdit = $parts['edit'] ;

//$dirLayoutParts = '../layouts/layoutParts' ;
