<?php
/**
 * Правила работы с вкладкой "рассылка"
 * @var $htmlPrefix
 */
use app\service\PageItems;
use app\components\RuleTextWidget ;
$pageItemFile = 'order/general';
$ruleTitleTab = PageItems::getItemText([$pageItemFile, 'rules', 'title']);
$ruleTitle = $ruleTitleTab['text'];
$ruleContentTab = PageItems::getItemText([$pageItemFile, 'rules', 'content']);
$ruleContent = $ruleContentTab['text'];
$ruleContentId = 'order-rules-content';

echo RuleTextWidget::widget([
    'htmlPrefix' => $htmlPrefix,
    'ruleTitle' => '"Заказы"',
    'ruleItems' => [
        ['ruleTitle'=>$ruleTitle,
            'ruleContent' => $ruleContent]
    ],
]) ;