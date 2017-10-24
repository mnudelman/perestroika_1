<?php
/**
 * Правила работы с вкладкой "рассылка"
 * @var $htmlPrefix
 */
use app\service\PageItems;
use app\components\RuleTextWidget ;
//$pageItemFile = 'order/general';
//$ruleTitleTab = PageItems::getItemText([$pageItemFile, 'rules', 'title']);
//$ruleTitle = $ruleTitleTab['text'];
//$ruleContentTab = PageItems::getItemText([$pageItemFile, 'rules', 'content']);
//$ruleContent = $ruleContentTab['text'];
//$ruleContentId = 'order-rules-content';
$ruleItems = [] ;
$pageItemFile = 'order/mailingRule';
$ruleTitleTab = PageItems::getItemText([$pageItemFile, 'rules', 'title']);
$ruleTitle = $ruleTitleTab['text'];
$ruleContentTab = PageItems::getItemText([$pageItemFile, 'rules', 'content']);
$ruleContent = $ruleContentTab['text'];

$ruleItems[] = ['ruleTitle'=>$ruleTitle,
    'ruleContent' => $ruleContent] ;

$pageItemFile = 'order/mailingToolbar';
$ruleTitleTab = PageItems::getItemText([$pageItemFile, 'rules', 'title']);
$ruleTitle = $ruleTitleTab['text'];
$ruleContentTab = PageItems::getItemText([$pageItemFile, 'rules', 'content']);
$ruleContent = $ruleContentTab['text'];

$ruleItems[] = ['ruleTitle'=>$ruleTitle,
    'ruleContent' => $ruleContent] ;


$pageItemFile = 'order/mailingDeveloperList';
$ruleTitleTab = PageItems::getItemText([$pageItemFile, 'rules', 'title']);
$ruleTitle = $ruleTitleTab['text'];
$ruleContentTab = PageItems::getItemText([$pageItemFile, 'rules', 'content']);
$ruleContent = $ruleContentTab['text'];

$ruleItems[] = ['ruleTitle'=>$ruleTitle,
    'ruleContent' => $ruleContent] ;

$pageItemFile = 'order/orderPassing';
$ruleTitleTab = PageItems::getItemText([$pageItemFile, 'rules', 'title']);
$ruleTitle = $ruleTitleTab['text'];
$ruleContentTab = PageItems::getItemText([$pageItemFile, 'rules', 'content']);
$ruleContent = $ruleContentTab['text'];

$ruleItems[] = ['ruleTitle'=>$ruleTitle,
    'ruleContent' => $ruleContent] ;


echo RuleTextWidget::widget([
    'htmlPrefix' => $htmlPrefix,
    'ruleTitle' => 'подсказка',
    'ruleItems' => $ruleItems,
]) ;