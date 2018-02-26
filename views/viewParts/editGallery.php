<?php
/**
 * Редактирование галереи - базовый шаблон
 * @var $htmlPrefix
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
//$htmlPrefix = 'workGalleryEdit';
$containerNewId = $htmlPrefix . '-new';
$containerEditId = $htmlPrefix . '-edit';
$containerBinId = $htmlPrefix . '-bin';
$containerHeapId = $htmlPrefix . '-heap';
$containerOrderId = $htmlPrefix . '-order';


$mdUpload = new UploadForm();
$urlUpload = Url::to(['site/upload']);
$uploadFormId = $htmlPrefix . "gallery-upload-form";
//$galleryNewImgId = 'gallery-new-img';
//$galleryNewId_1 = 'gallery-new-1';
$galleryNewImgId = $htmlPrefix . 'gallery-new-1-img';

$pageItemFile = 'profile/workGallery' ;
$ruleContentId = 'workGallery-form-collapseOne' ;

$ruleTab = PageItems::getItemText([$pageItemFile, 'rules']);
$ruleTitle = $ruleTab['title'];
$ruleContent = $ruleTab['content'];


$partsTitle = PageItems::getItemText([$pageItemFile, 'partsTitle']);
$partsTitleAdd = $partsTitle['add'] ;
$partsTitleEdit = $partsTitle['titleEdit'] ;
$partsTitleBin = $partsTitle['bin'] ;
$partsTitleOrder = $partsTitle['order'] ;
$btSave = PageItems::getItemText([$pageItemFile, 'buttons','save']);

$urlPdfShow = Url::to('@web/commands/pdfShow.php') ;
$dirLayoutParts = '../layouts/layoutParts' ;

//$containerNewId_1 = $HTML_PREFIX . '-new-1';
//$containerNewImg = $HTML_PREFIX . '-new-1-img';
?>
<!--   'onclick' => 'uploadOnClick('-->
<!--    . '"' . $uploadFormId . '","' . $urlUpload . '","' . $galleryNewImgId . '")'])-->


<div class="container-fluid">
    <div class="row">
<!--<!--        ?//=$this->render($dirLayoutParts . '/ruleAccordion',-->
<!--//            ['ruleTitle'=>$ruleTitle,'ruleContent'=>$ruleContent,-->
<!--//                'ruleContentId' => $ruleContentId])?> -->-->
        <div class="col-md-4">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <?=$partsTitleAdd?>
                </div>
                <div class="panel-body">
                    <div id="<?= $containerNewId ?>">

                    </div>
                    <?php $form = ActiveForm::begin([
                        'id' => $uploadFormId,
                        'action' => '#',
                        'options' => ['enctype' => 'multipart/form-data']]);
                    ?>
                    <?= $form->field($mdUpload, 'imageFile')->fileInput() ?>
                    <!--                        <div class="form-group">-->
                    <div class="col-lg-11">
                        <?= Html::button('upload',
                            ['type' => 'button', 'class' => 'btn btn-primary', 'name' => 'upload-button',
                                'onclick' => 'newGalleryItemUpload('
                                    . '"' . $uploadFormId . '","' . $urlUpload . '","' . $galleryNewImgId . '")']) ?>


                    </div>
                    <!--                        </div>-->
                    <?php ActiveForm::end() ?><br><br>

                </div>
            </div>
        </div>


        <div class="col-md-4">
            <div class="panel panel-primary">

                <div class="panel-heading">
                    <?=$partsTitleEdit?>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-4">
                            <div id="<?= $containerEditId ?>">
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div name="textArea">
                                <textarea id="<?= $containerEditId ?>-textArea"> </textarea>
                                <button class="btn btn-primary"
                                        onclick="showImageInWindow('<?=$urlPdfShow?>')">просмотр</button>



                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-md-4">

            <div class="panel panel-primary">
                <div class="panel-heading">
                    <?=$partsTitleBin?>
                </div>
                <div class="panel-body">
                    <div id="<?= $containerBinId ?>">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="panel panel-primary" hidden="hidden">
            <div class="panel-heading">
                Не упорядоченные изображения
            </div>
            <div class="panel-body">
                <div id="<?= $containerHeapId ?>">
                </div>
            </div>
        </div>

    </div>
    <div class="panel panel-primary">
        <div class="panel-heading">
            <?=$partsTitleOrder?>
        </div>
        <div class="panel-body">
            <div id="<?= $containerOrderId ?>">
            </div>
        </div>
    </div>
    <button class="btn btn-primary" onclick="gallerySave()">
        <?=$btSave?>
    </button>
</div>
