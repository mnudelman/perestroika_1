<?php
/**
 * Направления работ исполнителя
 * Time: 10:44
 */
?>
<?php
$baseWorksEditScel = '/viewParts/editWorks' ;
$htmlPrefix = 'workDirectionEdit';
?>
<?=$this->render($baseWorksEditScel,['htmlPrefix'=>$htmlPrefix,'objectType'=>'user'])?>
