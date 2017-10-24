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
<!--<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">-->
<!--    <div class="panel panel-default">-->
<!--        <div class="panel-heading" role="tab" id="headingOne">-->
<!--            <h4 class="panel-title">-->
<!--                <a role="button" data-toggle="collapse" data-parent="#accordion"-->
<!--                   href="#//ruleContentId<!--" aria-expanded="true" aria-controls="collapseOne">-->
<!--                   ?//= $ruleTitle ?><!--<span class="caret"></span>-->
<!--                </a>-->
<!--            </h4>-->
<!--        </div>-->
<!--        <div id="?//=$ruleContentId?><!--" class="panel-collapse collapse rule-content"-->
<!--             role="tabpanel" aria-labelledby="headingOne">-->
<!--            <div class="panel-body">-->
<!--                ?//= $ruleContent ?>
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->

<!--</div>-->
<!--<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">-->
<!--    <div class="panel panel-default">-->
<!--        <div class="panel-heading" role="tab" id="headingOne">-->
<!--            <h4 class="panel-title">-->
<!--                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">-->
<!--                    Collapsible Group Item #1-->
<!--                </a>-->
<!--            </h4>-->
<!--        </div>-->
<!--        <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">-->
<!--            <div class="panel-body">-->
<!--                Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->

<!--<div class="panel-group" id="?//=$ruleBlockId?><!--accordion" role="tablist" aria-multiselectable="true">-->
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
<!--</div>-->
