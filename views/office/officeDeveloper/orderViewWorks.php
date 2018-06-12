<?php
/**
 * Переписка - взаимодействие внутрипортала
 * @var $htmlPrefix
 */
?>
<?php
    $baseDir = '/viewParts/works/worksView' ;
    $htmlPrefix .= 'Works';
    $objectType = 'order' ;
    ?>
<?=$this->render($baseDir,['htmlPrefix'=>$htmlPrefix,
    'objectType'=> $objectType])?>