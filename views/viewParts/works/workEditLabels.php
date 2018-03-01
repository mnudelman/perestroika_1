<?php
/**
 * подписи для форм редактирования geographyWorks, developerWorks
*/
use app\service\PageItems ;

$ruleTab = PageItems::getItemText([$pageItemFile, 'rules']);
$ruleTitle = $ruleTab['title'];
$ruleContent = $ruleTab['content'];

$tooltips = PageItems::getItemText([$pageItemFile, 'tooltips']);
$tooltipItemEdit = $tooltips['itemEdit'] ;
$tooltipItemAdd = $tooltips['itemAdd'] ;

//$btSaveTab = PageItems::getItemText([$pageItemFile, 'buttons','save']);
//$btSave = $btSaveTab['text'] ;


$tooltipItemFullyYes = $tooltips['itemFully/yes'];
$tooltipItemFullyNo =  $tooltips['itemFully/no'];
$tooltipItemDeleteYes = $tooltips['itemDelete/yes'];
$tooltipItemDeleteNo = $tooltips['itemDelete/no'];
$tooltipSubItemInWorkYes = $tooltips['subItemInWork/yes'];
$tooltipSubItemInWorkNo = $tooltips['subItemInWork/no'];

$partsTitle = PageItems::getItemText([$pageItemFile, 'partsTitle']);

$partsTitleCurrent = $partsTitle['current'];
$partsTitleAdd = $partsTitle['add'];
$partsTitleEdit = $partsTitle['edit'];
$btSave = PageItems::getItemText([$pageItemFile, 'buttons','save']);
$dirLayoutParts = '../layouts/layoutParts' ;
