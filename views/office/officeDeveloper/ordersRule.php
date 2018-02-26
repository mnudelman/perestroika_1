<?php
/**
 * Правила работы с вкладкой "Я -МСПОЛНИТЕЛЬ"
 * @var $htmlPrefix
 */
use app\service\PageItems;
use app\components\RuleTextWidget ;
$ruleItems = [] ;
$pageItemFile = 'developer/rule';
$ruleTab = PageItems::getItemText([$pageItemFile, 'rules']);
$ruleTitle = $ruleTab['title'];
$ruleContent = $ruleTab['content'];

$ruleItems[] = ['ruleTitle'=>$ruleTitle,
    'ruleContent' => $ruleContent] ;

$pageItemFile = 'developer/ordersList';
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