<?php
/**
 * подписи для форм редактирования geographyWorks, developerWorks
*/
use app\service\PageItems ;

$ruleTab = PageItems::getItemText([$pageItemFile, 'rules']);
$ruleTitle = $ruleTab['title'];
$ruleContent = $ruleTab['content'];

$tooltips = PageItems::getItemText([$pageItemFile, 'tooltips']);
$toolTipItemEdit = $tooltips['itemEdit'] ;
$toolTipItemAdd = $tooltips['itemAdd'] ;

//$btSaveTab = PageItems::getItemText([$pageItemFile, 'buttons','save']);
//$btSave = $btSaveTab['text'] ;


$toolTipItemFullyYes = $tooltips['itemFully/yes'];
$toolTipItemFullyNo =  $tooltips['itemFully/no'];
$toolTipItemDeleteYes = $tooltips['itemDelete/yes'];
$toolTipItemDeleteNo = $tooltips['itemDelete/no'];
$toolTipSubItemInWorkYes = $tooltips['subItemInWork/yes'];
$toolTipSubItemInWorkNo = $tooltips['subItemInWork/no'];

$partsTitle = PageItems::getItemText([$pageItemFile, 'partsTitle']);

$partsTitleCurrent = $partsTitle['current'];
$partsTitleAdd = $partsTitle['add'];
$partsTitleEdit = $partsTitle['edit'];
$btSave = PageItems::getItemText([$pageItemFile, 'buttons','save']);
$dirLayoutParts = '../layouts/layoutParts' ;
