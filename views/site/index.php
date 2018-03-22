<?php
/**
 * контент Главной страницы
 * Time: 17:25
 */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\service\PageItems ;
use yii\bootstrap\Modal ;

?>
<?php
$introTab = PageItems::getItemText(['home-introduction']) ;
$introTitle = $introTab['title'] ;
$introContent = $introTab['content'];
// по направлениям работ
//  список из wd-list
$wdTab = PageItems::getItemText(['wd-list']) ;
$wdTitle = $wdTab['title'] ;
$wdItems = PageItems::getItemText(['wd-list','content']) ;
$wdImages = PageItems::getItemAttr('img',['wd-list','content']) ;
$wdCommandLabel = PageItems::getItemText(['wd-list','commands']) ;
$wdUrl = PageItems::getItemAttr('',['wd-list','url']) ;



//$wdTitle = PageItems::getItemText(['wd-list','title']) ;
//$wdItems = PageItems::getItemText(['wd-list','content']) ;
//$wdImages = PageItems::getItemAttr('img',['wd-list','content']) ;
//$wdCommandLabel = PageItems::getItemText(['wd-list','commands']) ;
//$wdUrl = PageItems::getItemAttr('',['wd-list','url']) ;
//$i = 1 ;
?>
<!--<div class="umb-grid">-->
<!--    <div class="grid-section">-->
<!--        <div>-->
            <div class='container'>
                <div class="row clearfix">
                    <div class="col-md-12 column">
                        <div class="text-description">
                            <h3 class="header-title" ><?=$introTitle?></h3>
                            <?=$introContent?>
                        </div>
                    </div>
                </div>
            </div>
<!--        </div>-->
<!--    </div>-->
<!--</div>-->


<br/>
<!--</div>-->
<h3 class="header-title page-title" > <?=$wdTitle?> </h3>
<div class="container">
<?php
/**
 * формирует блок напраления работ
 * по клику выводится модальная форма (wd-description)- полное описание
 * @param $wdId - ид направления работ
 * @param $wdCap - заголовк
 * @param $wdImg - картинка
 * @param $wdTextPiece  - кусок описания (под картинкой)
 * @return string
 */
  function wdItemBuild($wdId,$wdCap,$wdImg,$wdTextPiece) {
      $pTitle =  $wdCap ;
      $p = Html::tag('p', $pTitle,['class' => 'wd-text-title']) ;
      $img = Html::img('@web/images/' . $wdImg ,
          ['class'=>'img-responsive img-thumbnail','alt'=>'this is picture']) ;
      $div=Html::tag('div',$img);

      $p1 = Html::tag('p', $wdTextPiece,['class' => 'wd-text']) ;
      $div1 = Html::beginTag('div') . $p .$img . $p1 . Html::endTag('div') ;
      $a = Html::beginTag('a',['href'=>'#','title'=>'this is refer',
              'onclick' => 'wdOnClick("'. $wdId . '")','data-toggle'=>"modal",'data-target'=>"#wd-description"])
                     .$div1 . Html::endTag('a') ;

      return $a ;
  }
  $totalText = '' ;
  $count = 0 ;
  $block = '' ;
  foreach ($wdItems as $wdId => $wdCap) {
      if ($count % 3 == 0) {
          if ($count) {    // закрыть div - row
              $totalText .= $block . Html::endTag('div') ;
          }
           $block = Html::beginTag('div', ['class' => 'row']) ;

      }
      $wdImg = $wdImages[$wdId]  ;
      $wdTextPiece = PageItems::getItemText(['wd-' . $wdId,'pieceText']) ; ;
//      $a = wdItemBuild($wdId,$wdCap,$wdImg,$wdTextPiece['text']) ;
      $a = wdItemBuild($wdId,$wdCap,$wdImg,$wdTextPiece) ;
      $block .= Html::beginTag('div',['class' => "col-md-4 block"]) .$a . Html::endTag('div')  ;
      $count++ ;
  }
// закрываем div - col-md-4 block и  div - row
$totalText .= $block . Html::endTag('div') ;  // последний блок
$totalText .= Html::endTag('div') ;
echo $totalText ;
?>

</div>
<!-- модальная форма вывода описания направления работ id="wd-description"  -->
<div class="modal fade" id="wd-description" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="wd-description-title" name="description-title">войти</h4>
            </div>
            <div class="modal-body" id="modal-body">
                <div id="wd-description-content" class="wd-text" name="description-content">
<!--  здесь вставка текста описания -->
                 </div>
            </div>
            <div class="modal-footer">
            <p>
<!--                <button type="button" class="btn btn-default" data-dismiss="modal">Заказ</button>-->
<!--                <a class="btn btn-default" href="?//=$wdUrl['order']?><!--" role="button" data-dismiss="modal" >?//=$wdCommandLabel['order'] ?<!--</a>-->
<!--                <a class="btn btn-default" href="?//=$wdUrl['developer']?><!--" role="button" data-dismiss="modal">?//=$wdCommandLabel['developer'] ?<!--</a>-->
                <a class="btn btn-default" href="#" role="button" data-dismiss="modal"><?=$wdCommandLabel['exit'] ?></a>
            </p>
            </div>
        </div>
    </div>
</div>

