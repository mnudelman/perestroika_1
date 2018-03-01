<?php
/**
 * подписи для форм редактирования geographyWorks, developerWorks
 * @var $pageItemFile - файл - источник текстовых описаний для страницы
 */
use app\service\PageItems ;


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

//$dirLayoutParts = '../layouts/layoutParts' ;
