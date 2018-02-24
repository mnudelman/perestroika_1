<?php
/**
 * подсказки
 * Time: 18:01
 * @var $htmlPrefix
 * @var $tooltipName
 * @var $toolTipVariants  [varName => text]
 */
?>
<?php
$htmlText = '<input type="text" hidden="hidden" name="' . $tooltipName .'"' ;
foreach ($toolTipVariants as $variant => $text) {
      $dataItem = ' data-' . $variant . '="' . $text . '"' ;
    $htmlText .= $dataItem ;
   }
   $htmlText .= '>' ;
   echo $htmlText ;
?>

