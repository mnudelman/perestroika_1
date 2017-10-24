<?php
/**
 * Правила работы с вкладкой "Я -МСПОЛНИТЕЛЬ"
 * @var $htmlPrefix
 */
use app\service\PageItems;
use app\components\RuleTextWidget ;
$ruleItems = [] ;
$pageItemFile = 'developer/rule';
$ruleTitleTab = PageItems::getItemText([$pageItemFile, 'rules', 'title']);
$ruleTitle = $ruleTitleTab['text'];
$ruleContentTab = PageItems::getItemText([$pageItemFile, 'rules', 'content']);
$ruleContent = $ruleContentTab['text'];

$ruleItems[] = ['ruleTitle'=>$ruleTitle,
    'ruleContent' => $ruleContent] ;

$pageItemFile = 'developer/ordersList';
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