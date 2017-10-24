<?php
/**
 * подвал страницы
 */
use yii\bootstrap\NavBar;
use yii\bootstrap\Nav;
?>
<footer >
    <div class="container-fluid" style="padding-top:5px; padding-bottom:5px;">
        <div class="row">

<!--            <div class="wrap">-->
                <?php
                NavBar::begin([
                    'options' => [
                        'class' => 'navbar-default',
                    ],
                ]);
                echo Nav::widget([
                    'options' => ['class' => 'navbar-nav navbar-left'],
                    'items' => [
                        '<li style="margin-top:13px;color:#ac0812">© Pere-stroika.ru 2016</li>'
                    ],
                ]);
                echo Nav::widget([
                    'options' => ['class' => 'nav-reverse navbar-nav navbar-right'],
                    'items' => [
                        '<li><a href="#"><i class="fa fa-facebook-square fa-lg"></i></a></li>',
                        '<li><a href="#"><i class="fa fa-twitter-square fa-lg"></i></a></li>',
                        '<li><a href="#"><i class="fa fa-odnoklassniki-square fa-lg"></i></a></li>',
                    ],
                ]);
                NavBar::end();
                ?>
<!--            </div>-->
        </div>
    </div>
</footer>


