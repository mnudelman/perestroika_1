<?php
/**
 * подсказки
 * Time: 18:01
 * @var $htmlPrefix
 * @var $toolTipName
 * @var $toolTipVariants  [varName => text]
 */
?>
<?php
$htmlText = '<input type="text" hidden="hidden" name="' . $toolTipName .'"' ;
foreach ($toolTipVariants as $variant => $text) {
      $dataItem = ' data-' . $variant . '="' . $text . '"' ;
    $htmlText .= $dataItem ;
   }
   $htmlText .= '>' ;
   echo $htmlText ;
?>
<!--<div id="?//= $htmlPrefix . '-tooltips' ?><!--">-->
<!--    <input type="text" hidden="hidden" name="sendOffer"-->
<!--           data-empty="?//= $toolTipSendOfferEmpty ?><!--"-->
<!--           data-prepare="?//= $toolTipSendOfferPrepare ?><!--"-->
<!--           data-yes="?//= $toolTipSendOfferYes ?><!--"-->
<!--           data-picture-empty="?//= $toolTipEmptyPicture ?><!--"-->
<!--           data-picture-prepare="?//= $toolTipSendOfferPreparePicture ?><!--"-->
<!--           data-picture-yes="?//= $toolTipSendOfferYesPicture ?><!--"-->
<!--    >-->
<!--</div>-->
