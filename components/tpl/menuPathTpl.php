<?php
/**
 * @var $url
 * @var $name
 * @var $disabled
 * @var $lastItem
 * @var $btnClass
 * @var $menuBlockId
 * @var $onClick
 */
$arrowClass ='fa fa-arrow-right' ;
?>

<a class="<?=$btnClass?>" href="<?=$url?>" role="button" <?=$disabled?>
    data-menu-block="<?=$menuBlockId?>" <?=$onClick?>>
    <?=$name?>
</a>
<?php
  if (!$lastItem) {
      ?>
 <i class="<?=$arrowClass?>"></i>
  <?php
  }
  ?>
