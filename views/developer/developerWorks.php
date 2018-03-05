<?php
/**
 * Направления работ исполнителя
 * Time: 10:44
 */
?>
<?php
$baseWorksEditScel = '/viewParts/works/editWorks' ;
//$htmlPrefix = 'workDirectionEdit';
$htmlPrefix = (isset($htmlPrefix)) ? $htmlPrefix.'WorkDirection' : 'workDirectionEdit';
?>
<?=$this->render($baseWorksEditScel,['htmlPrefix'=>$htmlPrefix,'objectType'=>'user'])?>
