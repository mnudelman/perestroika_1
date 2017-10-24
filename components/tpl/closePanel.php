<?php
/**
 * Панель закрытия области
 * @var $htmlPrefix
 * @var $title
 */
?>
<div class="row" style="margin-top:-10px;margin-left:1px">
    <div style="text-align: left">
      <button class="btn btn-default btn-sm" style="margin-right:10px" title="закрыть подсказку"
          onclick="dataRule('<?=$htmlPrefix?>-close')">
          <i class="fa fa-close"></i>
      </button>
        <?=$title?>
    </div>
</div>