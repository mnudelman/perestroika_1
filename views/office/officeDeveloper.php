<?php
/**
 * Переписка - взаимодействие внутрипортала
 * @var $htmlPrefix
 */
?>
<!--Это ИСПОЛНИТЕЛЬ ЗАКАЗОВ-->
<?php
$htmlPrefix .= 'Developer' ;
$url = '../office/officeDeveloper/orders'
?>
<?=$this->render($url,['htmlPrefix'=>$htmlPrefix])?>
