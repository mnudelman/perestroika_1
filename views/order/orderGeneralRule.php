<?php
/**
 * Правила работы с вкладкой "рассылка"
 * @var $htmlPrefix
 */
use app\service\PageItems;
use app\components\RuleTextWidget ;
$pageItemFile = 'order/general';
$ruleTab = PageItems::getItemText([$pageItemFile, 'rules']);
$ruleTitle = $ruleTab['title'];
$ruleContent = $ruleTab['content'];

echo RuleTextWidget::widget([
    'htmlPrefix' => $htmlPrefix,
    'ruleTitle' => '"Заказы"',
    'ruleItems' => [
        ['ruleTitle'=>$ruleTitle,
            'ruleContent' => $ruleContent]
    ],
]) ;