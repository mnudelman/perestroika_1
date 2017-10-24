<?php
/**
 * правила заполнения формы
 */
/**
 *@var $ruleTitle
 *@var $ruleContent
 *@var $ruleContentId
 */
//$ruleContentId = (isset($contentId)) ? $contentId : 'profile-form-collapseOne' ;
?>
<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
    <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="headingOne">
            <h4 class="panel-title">
                <a role="button" data-toggle="collapse" data-parent="#accordion"
                   href="#<?=$ruleContentId?>" aria-expanded="true" aria-controls="collapseOne">
                    <?= $ruleTitle ?><span class="caret"></span>
                </a>
            </h4>
        </div>
        <div id="<?=$ruleContentId?>" class="panel-collapse collapse rule-content"
             role="tabpanel" aria-labelledby="headingOne">
            <div class="panel-body">
                <?= $ruleContent ?>
            </div>
        </div>
    </div>

</div>
