<?php
/**
 * Переписка - взаимодействие внутрипортала
 * @var $htmlPrefix
 */
?>
Это ЗАКЛАДКА "НАПРАВЛЕНИЯ РАБОТ" для выбранного ЗАКАЗА
<?php
    $baseGalleryEditScel = '/viewParts/works/worksView' ;
    $htmlPrefix .= 'Works';
    $objectType = 'order' ;
    ?>
<?=$this->render($baseGalleryEditScel,['htmlPrefix'=>$htmlPrefix,
    'objectType'=> $objectType])?>