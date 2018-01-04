<?php
/**
 * шаблон toolbar
 * @var $htmlPrefix
 * @var $titleWidth
 * @var $buttonsWidth
 * @var $paginationWidth
 * @var $toolbarTitle
 * @var $buttons
 * @var $indexPages    -  массив страниц для вывода [1,2,3]
 * @var $currentPage   - текущая страница
 * @var $firstClass    - разрешение/запрет для терминальных страниц
 * @var $prevClass
 * @var $nextClass
 * @var $lastClass

 */
?>
<?php
use app\components\PaginationWidget;
$buttonClass = "btn btn-primary btn-sm" ;
?>
<div class="row">
    <?php
    if ($titleWidth > 0) {
        ?>

        <div class="col-md-<?= $titleWidth ?>" name="toolBarTitle">
            <h5 class="header-title" style="text-align: left;">
                <?= $toolbarTitle ?></h5>
        </div>
        <?php
    }
    ?>
    <?php

//            <button class="btn btn-primary btn-sm" title="help"
//                    onclick="dataRule($htmlPrefix-open')">
//                <i class="fa fa-question"></i>
//            </button>
    if ($buttonsWidth > 0) {
        ?>

        <div class="col-md-<?= $buttonsWidth ?>" name="toolBarButtons">

        <?php
        foreach ($buttons as $btName => $btItem) {
            $btTitle = $btItem['title'] ;
            $clickFunction = $btItem['clickFunction'] ;
            $clickAction = $btItem['clickAction'] ;
            $clickArg = $htmlPrefix . (($clickAction !== '') ? '-' : '') . $clickAction  ;
            $onClick = $clickFunction . "('". $clickArg ."')" ;
            $iconClass = $btItem['iconClass'] ;
        ?>
            <button class="btn btn-primary btn-sm" title="<?=$btTitle?>"
                    onclick="<?=$onClick?>">
                <i class="<?=$iconClass?>"></i>
            </button>

        <?php
        }
        ?>
        </div>
        <?php
    }
    ?>

    <?php
       if ($paginationWidth > 0){
    ?>
    <div class="col-md-<?=$paginationWidth?>"  name="toolBarPagination">
        <?php
        echo PaginationWidget::widget([
            'htmlPrefix' => $htmlPrefix,
            'indexPages' => $indexPages,
            'currentPage' => $currentPage,
            'firstClass' => $firstClass,
            'prevClass' => $prevClass,
            'nextClass' => $nextClass,
            'lastClass' => $lastClass
        ]) ;
        ?>
    </div>

    <?php
       }
    ?>

</div>

