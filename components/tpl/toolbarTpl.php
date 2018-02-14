<?php
/**
 * шаблон toolbar
 * @var $htmlPrefix
 * @var $titleWidth
 * @var $buttonsWidth
 * @var $paginationWidth
 * @var $widgetWidth
 * @var $toolbarTitle
 * @var $buttons
 * @var $widgetVar
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
            $id = (isset($btItem['id'])) ? $btItem['id'] : '' ;
            $attrId = ($id !== '') ? ' id="' . $id . '" ' : '' ;
            $disabledFlag = (isset($btItem['disabled'])) ? $btItem['disabled'] : false ;
            $attrDisabled = ($disabledFlag) ? ' disabled ' : '' ;
        ?>
            <button class="btn btn-primary btn-sm" title="<?=$btTitle?>" <?=$attrId?>
                    <?=$attrDisabled?>
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
    if ($widgetWidth > 0){
    ?>

    <div class="col-md-<?= $widgetWidth ?>" name="toolBarWidget">
        <?php
          $name = $widgetVar['name'] ;
          $par =  $widgetVar['par'] ;
        widgetCase($name,$par) ;
//        echo app\components\GeographySimpleWidget::widget($par);
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

