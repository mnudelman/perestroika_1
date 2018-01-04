<?php
/**
 * Элемент блока подсказок (1 accordion)
 * @var $ruleBlockId
 * @var $headingId
 * @var $contentId
 * @var $ruleTitle
 * @var $ruleContent
 *
 */
?>
    <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="<?=$headingId?>">
            <h4 class="panel-title">
                <a role="button" data-toggle="collapse" data-parent="#<?=$ruleBlockId?>"
                   href="#<?=$contentId?>" aria-expanded="true" aria-controls="<?=$contentId?>">
                    <?= $ruleTitle ?><span class="caret"></span>
                </a>
            </h4>
        </div>
        <div id="<?=$contentId?>" class="panel-collapse collapse  rule-content" role="tabpanel"
             aria-labelledby="<?=$headingId?>">
            <div class="panel-body">
                <?= $ruleContent ?>
            </div>
        </div>
    </div>

