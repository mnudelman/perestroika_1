<?php
/**
 * работы по заказу
 */
?>
<?php
$baseWorksEditScel = '/viewParts/works/editWorks' ;
$htmlPrefix = 'orderEditWorks';
$objectType = 'order' ;
?>
<?=$this->render($baseWorksEditScel,['htmlPrefix'=>$htmlPrefix,'objectType'=>$objectType])?>
