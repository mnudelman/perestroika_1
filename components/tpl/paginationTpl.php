<?php
/**
 * /**
 * @var $htmlIdPrefix - обеспечивает уникальность
 * @var $indexPages -  nn доступных страниц
 * @var $currentPage
 * @var $firstClass
 * @var $prevClass = '';
 * @var $nextClass = '';
 * @var $lastClass = '';
 */
?>
<nav aria-label="Page navigation">
    <ul class="pagination pagination-sm" id="<?= $htmlPrefix ?>-pagination"
        style="margin-top:1px;margin-bottom:1px;">

        <li <?= $firstClass ?> name="firstPoint"
                               onclick="paginationClick('<?= $htmlPrefix ?>-first')">
            <a href="#" aria-label="first">
                <span aria-hidden="true" class="fa fa-step-backward"></span>
            </a>
        </li>

        <li li <?= $prevClass ?> name="prevPoint"
            onclick="paginationClick('<?= $htmlPrefix ?>-prev')">
            <a href="#" aria-label="previous">
                <span aria-hidden="true" class="fa fa-caret-left"></span>
            </a>
        </li>
        <?php
        foreach ($indexPages as $ind => $pageIndex) {
            if ($pageIndex > 0) {
                $active = ($currentPage === $pageIndex) ?
                    'class="active"' : '';

                ?>
                <li <?= $active ?> name="numPoint"
                                   onclick="paginationClick('<?= $htmlPrefix ?>-<?= $pageIndex ?>')">
                    <a href="#">
                        <?= $pageIndex ?></a></li>
            <?php
            }
        }
        ?>
        <li <?= $nextClass ?> name="nextPoint"
                              onclick="paginationClick('<?= $htmlPrefix ?>-next')">
            <a href="#" aria-label="next">
                <span aria-hidden="true" class="fa fa-caret-right"></span>
            </a>
        </li>
        <li <?= $lastClass ?> name="lastPoint"
                              onclick="paginationClick('<?= $htmlPrefix ?>-last')">
            <a href="#" aria-label="last">
                <span aria-hidden="true" class="fa fa-step-forward"></span>
            </a>
        </li>

    </ul>
</nav>