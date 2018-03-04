<?php
/**
 * подписи для форм редактирования geographyWorks, developerWorks
*/
use app\service\PageItems ;

//$ruleTab = PageItems::getItemText([$pageItemFile, 'rules']);
//$ruleTitle = $ruleTab['title'];
//$ruleContent = $ruleTab['content'];
//
//$tooltips = PageItems::getItemText([$pageItemFile, 'tooltips']);
//$tooltipItemEdit = $tooltips['itemEdit'] ;
//$tooltipItemAdd = $tooltips['itemAdd'] ;
//
////$btSaveTab = PageItems::getItemText([$pageItemFile, 'buttons','save']);
////$btSave = $btSaveTab['text'] ;
//
//
//$tooltipItemFullyYes = $tooltips['itemFully/yes'];
//$tooltipItemFullyNo =  $tooltips['itemFully/no'];
//$tooltipItemDeleteYes = $tooltips['itemDelete/yes'];
//$tooltipItemDeleteNo = $tooltips['itemDelete/no'];
//$tooltipSubItemInWorkYes = $tooltips['subItemInWork/yes'];
//$tooltipSubItemInWorkNo = $tooltips['subItemInWork/no'];
//
//$partsTitle = PageItems::getItemText([$pageItemFile, 'partsTitle']);
//
//$partsTitleCurrent = $partsTitle['current'];
//$partsTitleAdd = $partsTitle['add'];
//$partsTitleEdit = $partsTitle['edit'];
//$btSave = PageItems::getItemText([$pageItemFile, 'buttons','save']);
//$dirLayoutParts = '../layouts/layoutParts' ;




$tooltips = PageItems::getItemText([$pageItemFile, 'tooltips']);
$buttons = PageItems::getItemText([$pageItemFile, 'buttons']);
$rules =  PageItems::getItemText([$pageItemFile, 'rules']);
$partsTitle =  PageItems::getItemText([$pageItemFile, 'partsTitle']);


$ruleTitle = $rules['title'];
$ruleContent = $rules['content'];


$tooltipItemEdit = $tooltips['itemEdit'] ;
$tooltipItemAdd = $tooltips['itemAdd'] ;
$tooltipItevSave = (isset($tooltips['save'])) ? isset($tooltips['save']) : '' ;

$btSave = $buttons['save'] ;

$tooltipItemFullyYes = $tooltips['itemFully/yes'] ;
$tooltipItemFullyNo = $tooltips['itemFully/no'] ;
$tooltipItemDeleteYes = $tooltips['itemDelete/yes'] ;
$tooltipItemDeleteNo = $tooltips['itemDelete/no']  ;
$tooltipSubItemInWorkYes = $tooltips['subItemInWork/yes']  ;
$tooltipSubItemInWorkNo = $tooltips['subItemInWork/no']  ;

$tooltipCoveredEyeYes =  $tooltips['coveredEye/yes']  ;
$tooltipCoveredEyeNo =  $tooltips['coveredEye/no']  ;



$partsTitleCurrent = $partsTitle['current'] ;
$partsTitleAdd = $partsTitle['add'] ;
$partsTitleEdit = $partsTitle['edit'] ;

