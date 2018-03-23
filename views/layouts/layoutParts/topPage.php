<?php
/**
 *  часть шаблона - Верхняя часть страницы
 */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\bootstrap\Modal ;
use yii\widgets\ActiveForm ;
use app\models\LoginForm ;
use app\service\PageItems ;
use app\models\UserProfile ;
use app\service\Files ;
?>
<?php
  $labelTab = PageItems::getItemText(['topMenu']) ;
//  $urlTab = PageItems::getItemAttr('url',['topMenu']) ;
  $langImage = PageItems::getItemText(['topMenu','images','language']) ;      //это иконка текущего языка
  $currentController = Yii::$app->controller->id ;
 $objAction = Yii::$app->controller->action ;
 $currentAction = $objAction->actionMethod ;
  $urlEn = Url::to([$currentController.'/language','ln'=>'en','action'=>$currentAction]) ;
  $urlRu = Url::to([$currentController.'/language','ln'=>'ru','action'=>$currentAction]) ;
  $modalUrl = Url::to([$currentController,'#'=>'myModal']) ;
  $langImages = PageItems::getItemAttr('',['topMenu','images']) ;
//  $LANG_IMAGE_RU = $langImages['images/imgRu'] ;
//  $LANG_IMAGE_EN = $langImages['images/imgEn'] ;
  $LANG_IMAGE_RU = 'images/ru.png' ;
  $LANG_IMAGE_EN = 'images/en.png' ;
  $userIsGuest = Yii::$app->user->isGuest ;
  $guestName =  $labelTab['user-noname'] ;
  $userName = ($userIsGuest) ? $guestName : Yii::$app->user->identity->username ;

$imgAvatarName = '' ;
  $imgAvatarEmpty = 'people.png' ;

$avatarUrl = '' ;
if (!$userIsGuest) {
    $uid = Yii::$app->user->identity->id  ;
    $profile = UserProfile::findOne(['userid' => $uid]) ;
    $imgAvatarName = $profile->avatar ;
}
$imgAvatarName = (empty($imgAvatarName)) ? $imgAvatarEmpty : $imgAvatarName ;
$userid = 'Z' ;
$pathName = 'image' ;
$avatarDir = '' ;
if ($userIsGuest || empty($imgAvatarName)) {

    $imgAvatarName = 'people.png' ;
    $path = Files::getPath('image') ;
    $avatarUrl = $path['url'] ;
    $avatarDir =  $path['dir'] ;
}else {
    $userid = Yii::$app->user->identity->getId() ;
    $pathName = 'userAvatar' ;
    $path = Files::getPath('userAvatar',$userid) ;
    $avatarUrl = $path['url'] ;
    $avatarDir =  $path['dir'] ;
    if (!file_exists($avatarDir . '/' . $imgAvatarName)) {
        $imgAvatarName = 'people.png' ;
        $path = Files::getPath('image') ;
        $avatarUrl = $path['url'] ;
        $avatarDir =  $path['dir'] ;
    }

}
  $imgAvatar = Html::img($avatarUrl .'/' . $imgAvatarName ,
      ['alt'=>'аватар','id' => 'topmenu-avatar','class' => 'topmenu-avatar-image']) ;
// 'class'=>'img-responsive',
?>


<div class="wrap">
    <?php
    NavBar::begin([
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
            'style' => 'color:white; background-color:blue'
        ],
    ]);
      $img = Html::img($langImage ,
          ['class'=>'topmenu-lang-image','alt'=>'выбор языка']) ;
      // заголовок  dropdown
      $a = Html::beginTag('a',
               ['class' => 'dropdown-toggle',
               'data-toggle' => "dropdown", 'href' => "#",
               'role' => "button", 'aria-haspopup' => "true",'aria-expanded'=>"false"])  . $img .
                 '<span class="caret"></span>' . Html::endTag('a') ;
    // тело dropdown
    $imgRu = Html::img($LANG_IMAGE_RU ,['class'=>'img-responsive topmenu-lang-image']) ;
    $imgEn = Html::img($LANG_IMAGE_EN ,['class'=>'img-responsive topmenu-lang-image']) ;

    // li - ru
    $aRu = Html::beginTag('a', ['href' => $urlRu ]) . $imgRu . $labelTab['lang-russian'] . Html::endTag('a') ;
    $liRu = Html::beginTag('li',['class' => "enabled"]) . $aRu . Html::endTag('li') ;
    //
     // li - en
    $aEn = Html::beginTag('a', ['href' => $urlEn ]) . $imgEn . $labelTab['lang-english'] . Html::endTag('a') ;
    $liEn = Html::beginTag('li',['class' => "enabled"]) . $aEn . Html::endTag('li') ;
    //
    $ulDropdownMenu = Html::beginTag('ul',['class' => "dropdown-menu"]) . $liRu . $liEn .Html::endTag('ul') ;
    $liTotalDropdown = Html::beginTag('li',['class' =>"dropdown", 'role' => "presentation"]) . $a . $ulDropdownMenu .
                       Html::endTag('li') ;
    $enable = (!$userIsGuest) ? 'enable' : 'disabled' ;
    $aForum = Html::beginTag('a', ['href' => 'forum/index']) . $labelTab['forum'] . Html::endTag('a') ;
    $liForum = Html::beginTag('li',['class' => $enable, 'id' => 'topmenu-forum']) . $aForum . Html::endTag('li') ;

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-left'],
        'items' => [
            ['label' => $labelTab['home'], 'url' => ['/site/index']],
            ['label' => $labelTab['about'], 'url' => ['/about/index']],
            ['label' => $labelTab['order'], 'url' => ['/order/index']],
            ['label' => $labelTab['developers'], 'url' => ['#']],

            $liForum,
            $liTotalDropdown,
        ],
    ]);

 // сборка  dropdown

    // заголовок  dropdown
    $a = Html::beginTag('a',
            ['class' => 'dropdown-toggle',
                'id' => '',
                'data-toggle' => "dropdown", 'href' => "#",
                'role' => "button", 'aria-haspopup' => "true",'aria-expanded'=>"false"])  .
        $imgAvatar . '<span id="topmenu-username">' . $userName .'</span>' .
        '<span class="caret"></span>' . Html::endTag('a') ;
    // тело dropdown


    // li - logout
    $enable = (!$userIsGuest) ? 'enable' : 'disabled' ;
    $hidden = ($userIsGuest) ? '"hidden",' : null ;
    $aEnter = Html::beginTag('a', ['href' => '#']) .
        $labelTab['logout'] . Html::endTag('a') ;
    $userIsGuestParam = ($userIsGuest) ? '1' : '0' ;
    $liLogout = Html::beginTag('li',['class' => $enable,'id'=> 'topmenu-logout',
            'hidden' => $hidden,
            'onClick' => 'logoutOnClick("'. $guestName . '")']) . $aEnter . Html::endTag('li') ;






    // li - enter
    $enable = ($userIsGuest) ? 'enable' : 'disabled' ;
    $hidden = (!$userIsGuest) ? '"hidden",' : null ;
    $aEnter = Html::beginTag('a', ['href' => '#','data-toggle'=>"modal",'data-target'=>"#enter-form" ]) .
        $labelTab['enter'] . Html::endTag('a') ;
    $userIsGuestParam = ($userIsGuest) ? '1' : '0' ;
    $liEnter = Html::beginTag('li',['class' => $enable,
            'id'=> 'topmenu-enter','hidden' => $hidden,
        'onClick' => 'enterTargetControl(' . $userIsGuestParam . ')']) . $aEnter . Html::endTag('li') ;
    //
    // li - registration
    //'<li role="presentation" class="enabled"><a href="#"dal" data-target="#myModal">'.$labelTab['registration'].'</a></li>' .


    $enable = ($userIsGuest) ? 'enable' : 'disabled' ;
    $hidden = (!$userIsGuest) ? '"hidden",' : null ;
    $aRg = Html::beginTag('a', ['href' => '#','data-toggle'=>"modal",'data-target'=>"#registration-form"  ])  .
        $labelTab['registration'] . Html::endTag('a') ;
    $liRg = Html::beginTag('li',['class' => $enable,
            'id'=> 'topmenu-registration','hidden' => $hidden,
        'onClick' => 'enterTargetControl(' . $userIsGuestParam . ')']) . $aRg . Html::endTag('li') ;
    //

    // li - profile
    $enable = (!$userIsGuest) ? 'enable' : 'disabled' ;
//    $aProfile = Html::beginTag('a', ['href' => '#','data-toggle'=>"modal",'data-target'=>"#profile-form" ]) .
    $hidden = ($userIsGuest) ? '"hidden",' : null ;
    $url = Url::to(['/developer/index']) ;
     $aProfile = Html::beginTag('a', ['href' => $url]) .
        $labelTab['profile'] . Html::endTag('a') ;
    $liProfile = Html::beginTag('li',['class' => $enable,
            'id'=> 'topmenu-profile','hidden' => $hidden]) . $aProfile . Html::endTag('li') ;
    //

    // li - office
    $url = Url::to(['/office/index']) ;
    $hidden = ($userIsGuest) ? '"hidden",' : null ;
    $enable = (!$userIsGuest) ? 'enable' : 'disabled' ;
    $aOffice = Html::beginTag('a', ['href' => $url ]) .  $labelTab['office'] . Html::endTag('a') ;
    $liOffice = Html::beginTag('li',['class' => $enable,
            'id'=> 'topmenu-office','hidden' => $hidden]) . $aOffice . Html::endTag('li') ;
    //

    $ulDropdownMenu = Html::beginTag('ul',['class' => "dropdown-menu"]) .
        $liLogout . $liEnter . $liRg . $liProfile . $liOffice .Html::endTag('ul') ;
    $liTotalDropdown = Html::beginTag('li',['class' =>"dropdown", 'role' => "presentation"]) . $a . $ulDropdownMenu .
        Html::endTag('li') ;







    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [ $liTotalDropdown,
        ],
    ]);
    NavBar::end();
    ?>

    <div>
        <nav class="navbar navbar-default brand-row" >
            <div class="container-fluid">
                <div class="row" >
                    <div class="navbar-header">
                        <a href="site/index">
                            <img alt="Brand" class="image-logo" src="images/logo.jpg">
                        </a>
                    </div>
                </div>
            </div>
        </nav>
    </div>
</div>


