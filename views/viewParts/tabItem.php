<?php
/**
 * элемент tab
 * @var $tabTitle
 * @var $tabContent
 * @var $htmlPrefix
 * @var $currentDir
 */
$htmlPrefix = (!isset($htmlPrefix)) ? '' : $htmlPrefix ;
$dirApp = Yii::getAlias('@app') ;
$dirViews = $dirApp . '/views' ;
$pos = strpos($currentDir,$dirViews) ;
$subDir = false ;
$dirViewsLen = strlen($dirViews) ;
if (false !== $pos) {
    $subDir = substr($currentDir,strlen($dirViews))  ;
}

?>
<div class="panel panel-primary">
    <div class="panel-heading">
        <!--        <h3 class="header-title" style="text-align: left;">//=$tabTitle?><!--</h3>-->
    </div>
    <div class="panel-body">
        <?=$this->render($subDir . '/'.$tabContent,['htmlPrefix'=>$htmlPrefix])?>
    </div>
</div>
