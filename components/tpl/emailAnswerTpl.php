<?php
/**
 * ответ пользователя на email
 * @var $title
 * @var $bodyText
 * @var $buttons
 * @var $buttonStyle
 * @var $parmString
 */
?>
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title"><?=$title?></h3>
    </div>
    <div class="panel-body">
        <?=$bodyText?>
       <div class="row">
           <?php
           foreach ($buttons as $BtName => $button ) {
               $text = $button['text'] ;
               $onclick = $button['onclick'] ;
               $onclick = $onclick . '(' .$parmString . ')' ;
               $class = $button['class'] ;
           ?>
           <button class="<?=$class?>" style="<?=$buttonStyle?>"
                   onclick="<?=$onclick?>"
           >
               <?=$text?>

           </button>
           <?php
           }
           ?>
       </div>
    </div>
</div>