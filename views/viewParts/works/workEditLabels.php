<?php
/**
 * подписи для форм редактирования geographyWorks, developerWorks
*/
use app\service\PageItems ;

$ruleTitleTab = PageItems::getItemText([$pageItemFile, 'rules', 'title']);
$ruleTitle = $ruleTitleTab['text'];
$ruleContentTab = PageItems::getItemText([$pageItemFile, 'rules', 'content']);
$ruleContent = $ruleContentTab['text'];

$tooltips = PageItems::getItemText([$pageItemFile, 'tooltips']);
$toolTipItemEdit = $tooltips['itemEdit'] ;
$toolTipItemAdd = $tooltips['itemAdd'] ;
$btSaveTab = PageItems::getItemText([$pageItemFile, 'buttons','save']);
$btSave = $btSaveTab['text'] ;
$toolTipItemFullyYes = PageItems::getItemText([$pageItemFile, 'tooltips','itemFully','yes']);
$toolTipItemFullyYes = $toolTipItemFullyYes['text'] ;
$toolTipItemFullyNo = PageItems::getItemText([$pageItemFile, 'tooltips','itemFully','no']);
$toolTipItemFullyNo = $toolTipItemFullyNo['text'] ;
$toolTipItemDeleteYes = PageItems::getItemText([$pageItemFile, 'tooltips','itemDelete','yes']);
$toolTipItemDeleteYes = $toolTipItemDeleteYes['text'] ;
$toolTipItemDeleteNo = PageItems::getItemText([$pageItemFile, 'tooltips','itemDelete','no']);
$toolTipItemDeleteNo = $toolTipItemDeleteNo['text'] ;
$toolTipSubItemInWorkYes = PageItems::getItemText([$pageItemFile, 'tooltips','subItemInWork','yes']);
$toolTipSubItemInWorkYes = $toolTipSubItemInWorkYes['text'] ;
$toolTipSubItemInWorkNo = PageItems::getItemText([$pageItemFile, 'tooltips','subItemInWork','no']);
$toolTipSubItemInWorkNo = $toolTipSubItemInWorkNo['text'] ;
$partsTitleCurrent = PageItems::getItemText([$pageItemFile, 'partsTitle','current']);
$partsTitleCurrent = $partsTitleCurrent['text'] ;
$partsTitleAdd = PageItems::getItemText([$pageItemFile, 'partsTitle','add']);
$partsTitleAdd = $partsTitleAdd['text'] ;
$partsTitleEdit = PageItems::getItemText([$pageItemFile, 'partsTitle','edit']);
$partsTitleEdit = $partsTitleEdit['text'] ;
$btSave = PageItems::getItemText([$pageItemFile, 'buttons','save']);
$btSave = $btSave['text'] ;
$dirLayoutParts = '../layouts/layoutParts' ;
