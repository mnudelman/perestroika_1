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
$ruleTab = PageItems::getItemText([$pageItemFile, 'rules']);
$ruleTitle = $ruleTab['title'];
$ruleContent = $ruleTab['content'];

$ruleItems[] = ['ruleTitle'=>$ruleTitle,
    'ruleContent' => $ruleContent] ;

$pageItemFile = 'order/mailingToolbar';
$ruleTab = PageItems::getItemText([$pageItemFile, 'rules']);
$ruleTitle = $ruleTab['title'];
$ruleContent = $ruleTab['content'];

$ruleItems[] = ['ruleTitle'=>$ruleTitle,
    'ruleContent' => $ruleContent] ;


$pageItemFile = 'order/mailingDeveloperList';
$ruleTab = PageItems::getItemText([$pageItemFile, 'rules']);
$ruleTitle = $ruleTab['title'];
$ruleContent = $ruleTab['content'];

$ruleItems[] = ['ruleTitle'=>$ruleTitle,
    'ruleContent' => $ruleContent] ;

$pageItemFile = 'order/orderPassing';
$ruleTab = PageItems::getItemText([$pageItemFile, 'rules']);
$ruleTitle = $ruleTab['title'];
$ruleContent = $ruleTab['content'];

$ruleItems[] = ['ruleTitle'=>$ruleTitle,
    'ruleContent' => $ruleContent] ;


echo RuleTextWidget::widget([
    'htmlPrefix' => $htmlPrefix,
    'ruleTitle' => 'подсказка',
    'ruleItems' => $ruleItems,
]) ;