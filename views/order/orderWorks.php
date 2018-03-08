<?php
/**
 * работы по заказу
 */
?>
<?php
$baseWorksEditScel = '/viewParts/works/editWorks' ;
//$htmlPrefix = $htmlPrefix . 'Works';
$objectType = 'order' ;
?>
<?=$this->render($baseWorksEditScel,['htmlPrefix'=>$htmlPrefix,'objectType'=>$objectType])?>
