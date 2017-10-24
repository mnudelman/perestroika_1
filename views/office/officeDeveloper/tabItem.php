<?php
/**
 * элемент tab
 * @var $tabTitle
 * @var $tabContent
 * @var $htmlPrefix
 */
$htmlPrefix = (!isset($htmlPrefix)) ? '' : $htmlPrefix ;
?>
<div class="panel panel-primary">
    <div class="panel-heading">
        <!--        <h3 class="header-title" style="text-align: left;">//=$tabTitle?><!--</h3>-->
    </div>
    <div class="panel-body">
        <?=$this->render($tabContent,['htmlPrefix'=>$htmlPrefix])?>
    </div>
</div>
