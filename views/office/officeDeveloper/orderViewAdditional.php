<?php
/**
 * Переписка - взаимодействие внутрипортала
 * @var $htmlPrefix
 */
?>
<!--Это ЗАКЛАДКА "ДОПОЛНИТЕЛЬНЫЕ МАТЕРИАЛЫ" для выбранного ЗАКАЗА-->
<?php
$baseGalleryEditScel = '/viewParts/galleryView' ;
//$htmlPrefix .= 'Gallery';
$objectType = 'order' ;
?>
<?=$this->render($baseGalleryEditScel,['htmlPrefix'=>$htmlPrefix,
    'objectType'=> $objectType])?>