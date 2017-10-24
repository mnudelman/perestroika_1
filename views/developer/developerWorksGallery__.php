<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 23.01.17
 * Time: 15:34
 */
?>
<?php
use yii\bootstrap\Carousel ;
use yii\helpers\Html ;
use yii\widgets\ActiveForm ;
use app\models\UploadForm ;
use yii\helpers\Url ;
?>
<?php
$mdUpload = new UploadForm();
$title = 'ProfileEdit';
$urlUpload = Url::to(['site/upload']);
$uploadFormId = "developer-upload-form";
$avatarImgId = 'profile-avatar-img';
$avatarImgName = 'people.png' ;

?>
<div class="container-fluid">
<!--    <div class="col-md-10"-->
    <div class="site-login">

        <!---->
        <?php
//        $img = Html::img('@web/images/avatars/' . $avatarImgName,
//            ['class' => 'img-responsive img-thumbnail', 'alt' => 'this is picture',
//                'width' => '72px', 'id' => $avatarImgId]);
//        echo Html::tag('div', $img);
        ?>

    </div>
        <?php
echo Carousel::widget([
'items' => [
// the item contains only the image
     Html::img('@web/images/developer_pictures/1.jpg',
         ['alt'=>'this is picture','height'=> '800px']),
    Html::img('@web/images/developer_pictures/2.jpg',
        ['alt'=>'this is picture','height'=> '800px']),
    Html::img('@web/images/developer_pictures/3.jpg',
        ['alt'=>'this is picture','height'=> '800px']),
    Html::img('@web/images/developer_pictures/4.jpg',
        ['alt'=>'this is picture','height'=> '800px']),
    Html::img('@web/images/developer_pictures/5.jpg',
        ['alt'=>'this is picture','height'=> '800px']),
    Html::img('@web/images/developer_pictures/6.jpg',
        ['alt'=>'this is picture','height'=> '800px']),
//    Html::img('@web/images/developer_pictures/7.jpg',
//        ['alt'=>'this is picture','height'=> '400px']),
    Html::img('@web/images/developer_pictures/8.jpg',
        ['alt'=>'this is picture','height'=> '800px']),
    Html::img('@web/images/developer_pictures/9.jpg',
        ['alt'=>'this is picture','height'=> '800px']),
    Html::img('@web/images/developer_pictures/10.jpg',
        ['alt'=>'this is picture','height'=> '800px']),
    Html::img('@web/images/developer_pictures/11.jpg',
        ['alt'=>'this is picture','height'=> '800px']),
    Html::img('@web/images/developer_pictures/12.jpg',
        ['alt'=>'this is picture','height'=> '800px']),




]
]);
?>
<!--    </div>-->
</div>