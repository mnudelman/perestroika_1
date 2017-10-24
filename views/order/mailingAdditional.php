<?php
/**
 * проектирование личной галереи
 * Time: 19:28
 */
?>
<?php
use yii\bootstrap\Carousel;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\UploadForm;
use yii\helpers\Url;
use app\service\PageItems ;
?>
<?php
//$mdUpload = new UploadForm();
//$urlUpload = Url::to(['site/upload']);
//$uploadFormId = "gallery-upload-form";
//$galleryNewImgId = 'gallery-new-img';
//$galleryNewId_1 = 'gallery-new-1';
//$galleryNewImgId = 'gallery-new-1-img';
//$HTML_PREFIX = 'workGalleryEdit';
//$containerNewId = $HTML_PREFIX . '-new';
//$containerEditId = $HTML_PREFIX . '-edit';
//$containerBinId = $HTML_PREFIX . '-bin';
//$containerHeapId = $HTML_PREFIX . '-heap';
//$containerOrderId = $HTML_PREFIX . '-order';
//
//$pageItemFile = 'profile/workGallery' ;
//$ruleContentId = 'workGallery-form-collapseOne' ;
//
//$ruleTitleTab = PageItems::getItemText([$pageItemFile, 'rules', 'title']);
//$ruleTitle = $ruleTitleTab['text'];
//$ruleContentTab = PageItems::getItemText([$pageItemFile, 'rules', 'content']);
//$ruleContent = $ruleContentTab['text'];
//
//$partsTitleAdd = PageItems::getItemText([$pageItemFile, 'partsTitle','add']);
//$partsTitleAdd = $partsTitleAdd['text'] ;
//$partsTitleEdit = PageItems::getItemText([$pageItemFile, 'partsTitle','titleEdit']);
//$partsTitleEdit = $partsTitleEdit['text'] ;
//$partsTitleBin = PageItems::getItemText([$pageItemFile, 'partsTitle','bin']);
//$partsTitleBin = $partsTitleBin['text'] ;
//$partsTitleOrder = PageItems::getItemText([$pageItemFile, 'partsTitle','order']);
//$partsTitleOrder = $partsTitleOrder['text'] ;
//$btSave = PageItems::getItemText([$pageItemFile, 'buttons','save']);
//$btSave = $btSave['text'] ;
$htmlPrefix .= 'Additional' ;

?>

<div class="container-fluid">
    <div class="panel panel-primary">
        <div class="panel-heading">
        </div>
        <div class="panel-body">
<!--            <div id="//= $containerOrderId ?><!--">-->

<!--            border: 2px solid blue;-->

                <div id="<?=$htmlPrefix?>-order">
                    <div class="row" name="row-0">
                        <div id="<?=$htmlPrefix?>-order-1" class="col-sm-4 block" style="min-height: 20px;">
                            <div class="orderEditAdditional-order-innerDiv"
                                 id="orderEditAdditional-order-1-img"
                                 style="width: 100%; height: auto; position: relative;">
                                <img class="img-responsive img-thumbnail" src="/projects/perestroika/web/images/user/u_25/gallery/2_evro_tHRy9.jpg" style="width: 100%;">
                                <p>new picture</p>
                            </div>
                        </div>


                        <div id="<?=$htmlPrefix?>-order-2" class="col-sm-4 block" style="min-height: 20px;">
                            <div class="orderEditAdditional-order-innerDiv ui-draggable ui-draggable-handle" id="orderEditAdditional-order-1-img" style="width: 100%; height: auto; position: relative;">
                                <img class="img-responsive img-thumbnail" src="/projects/perestroika/web/images/user/u_25/gallery/2_evro_tHRy9.jpg" style="width: 100%;">
                                <p>new picture</p>
                            </div>
                        </div>


                        <div id="<?=$htmlPrefix?>-order-3" class="col-sm-4 block" style="min-height: 20px;">
                            <div class="orderEditAdditional-order-innerDiv ui-draggable ui-draggable-handle" id="orderEditAdditional-order-1-img" style="width: 100%; height: auto; position: relative;">
                                <img class="img-responsive img-thumbnail" src="/projects/perestroika/web/images/user/u_25/gallery/2_evro_tHRy9.jpg" style="width: 100%;">
                                <p>new picture</p>
                            </div>
                        </div>






                    </div>
                </div>





<!--            </div>-->
        </div>
    </div>
</div>
