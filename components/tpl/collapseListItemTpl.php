<?php
/**
 *    шаблон вывода элемента раскрывающегося списка
 */
/**
 * @var  $itemName - имя элемента списка
 * @var $editFlag -  можно редактировать
 * @var $editClass - класс изображения на кнопке редактирования
 * @var $htmlId - ид элемента
 * @var $htmlSubItemId - ид раскрывающегося подсписка
 * @var $onClick
 * @var $fullyName - ($fullyFlag) ? '(полностью)' : '' ;
 * @var $btTitle -  title для кнопки редалтирования
 * @var $btTooltipName -  ссылка на tooltips раздел
 * @var $subItems - выпадающий список
 * @var $buttons -  набор кнопок
 * @var $currentItemFlag - текущий элемент
 * @var $currentItemClass - класс для выделения текущего элемента
 */
 $width = 100 - sizeof($buttons) * 8  - 1;
?>
<div class="row">
    <!--Голова списка-->
    <?php
    $highLightClass = ($currentItemFlag && !empty($currentItemClass)) ?
        $currentItemClass : '' ;
    ?>

    <a class="btn btn-default <?=$highLightClass?>" role="button" data-toggle="collapse"
       style="width:<?=$width?>%;white-space:normal"
       id="<?= $htmlId ?>"
       aria-expanded="false" href="#<?= $htmlSubItemId ?>" aria-expanded="true"
       aria-controls="<?= $htmlSubItemId ?>">
        <?= $itemName ?><strong><?= $fullyName ?></strong><b class="caret"></b>
    </a>


    <?php
    foreach ($buttons as $key=>$btItem) {
        if ($key === 'null') {
            continue ;
        }
//        $btItem = $buttons[$i];
        $pictureClass = $btItem['pictureClass']; //- класс изображения на кнопке редактирования
        $onClick = $btItem['onClick'];
        $btTitle = $btItem['btTitle']; // -  title для кнопки редалтирования
        $btTooltipName = (isset($btItem['btTooltipName'])) ?$btItem['btTooltipName'] : false ;
        $btDisabled = (isset($btItem['disabled'])) ? $btItem['disabled'] : false ;
        $disableText = ($btDisabled) ? 'disabled="disabled"' : '' ;
        $btClass = $btItem['btClass'];
        ?>
        <button class="btn <?=$btClass?>" role="button" title="<?= $btTitle ?>" onclick="<?= $onClick ?>"
                id="<?= $htmlId . '-' . $key .'-bt' ?>"   <?=$disableText?>
        <?php
           if (!empty($btTooltipName)) {
               echo 'data-tooltip-name="' .$btTooltipName .'"' ;
           }
        ?>
        >
            <span class="<?= $pictureClass ?>"></span>
        </button>
    <?php
    }
    ?>

    <!--раскрывающаяся часть -->
    <ul class="list-group collapse" id="<?= $htmlSubItemId ?>">
        <?php
        if (sizeof($subItems) > 0) {
            foreach ($subItems as $ind => $subItemName) {
                echo '<li class="list-group-item" style="white-space:normal">' . $subItemName . '</li>';
            }
        }
        ?>
    </ul>
</div>