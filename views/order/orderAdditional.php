<?php
/**
 * Добавление картинок в описании заказа
 * Time: 19:28
 */
?>
<?php
$baseGalleryEditScel = '/viewParts/editGallery' ;
$htmlPrefix = 'orderEditAdditional';
?>
<?=$this->render($baseGalleryEditScel,['htmlPrefix'=>$htmlPrefix])?>