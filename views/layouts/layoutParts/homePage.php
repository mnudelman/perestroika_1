<?php
/**
 * контент Главной страницы
 * Time: 17:25
 */
use yii\helpers\Html ;
//use yii\helpers\Url ;
?>
<div class="umb-grid">
    <div class="grid-section">
        <div>
            <div class='container'>
                <div class="row clearfix">
                    <div class="col-md-12 column">
                        <div>


                            <h3 class="header-title" style="text-align: center;">О САЙТЕ</h3>


                            <p>Портал "Перестройка" - это сервис быстрого поиска, объединяющий <b>заказчиков</b>
                                и <b>исполнителей работ</b>, поставщиков оборудования, материалов,
                                специализированной техники, связанных с перепланировкой помещений,
                                реконструкцией зданий и сооружений. </p>

                            <p>В этом проекте, мы сделали отраслевую сегментацию рынка строительных услуг с
                                целью упростить систему поиска, для заказчиков специализированных видов работ,
                                связанных с различными этапами изменения конструкций, окружающего нас жилого,
                                промышленного и социального секторов, зданий и сооружений.</p>

                            <p>Потребность в "Перестройке" существующего пространства, с целью улучшения,
                                оптимизации или функционального изменения, возникает ежедневно.</p>

                            <p>Мы предлагаем вам двенадцать специализированных разделов, включающих <b>алмазную
                                    резку бетона, демонтаж зданий, перепланировку, реконструкцию, проектирование и
                                    другие</b>, в которых вы сможете сделать <a>заказ</a>, или <a>заявить о себе</a>
                                , как профессионал по представленным направлениям. </p>

                            <p><a href="#" title="пошаговый алгоритм оформления заказа">подробнее о работе
                                    сайта...</a></p>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<br/>
<!--</div>-->
<h3 class="header-title" style="text-align: center;">направления работ</h3>
<div class="container">
    <div class="row">
        <div class="col-md-4 block">
        <?php
        $pText = '<strong>алмазная резка и бурение</strong>' ;
        $p = Html::tag('p', Html::encode($pText)) ;
        $img = Html::img('@web/images/алмазная резка и бурение.jpg',
            ['class'=>'img-responsive img-thumbnail','alt'=>'this is picture']) ;
        $div=Html::tag('div',$img);
        $a = Html::a($div,'#',['title'=>'diamond','data-toggle'=>"modal",'data-target'=>"#myModal"]) ;
        echo $a ;
        ?>








<!--            <p><strong>алмазная резка и бурение</strong></p>-->
<!---->
<!--            <div>-->
<!--                <img src="images/алмазная резка и бурение.jpg" class="img-responsive img-thumbnail" alt="">-->
<!--            </div>-->
        </div>
        <div class="col-md-4 block">
            <p><strong>Демонтажные работы</strong></p>

            <div>
                <img src="images/Демонтажные работы.jpg" class="img-responsive img-thumbnail" alt="">
            </div>

        </div>
        <div class="col-md-4 block">
            <p><strong>Демонтаж зданий и сооружений</strong></p>

            <div>
                <img src="images/Демонтаж зданий и сооружений. 2.jpg" class="img-responsive img-thumbnail" alt="">
            </div>


        </div>

    </div>
    <!--2-->
    <div class="row">
        <div class="col-md-4 block">
            <p><strong>Строительные работы</strong></p>

            <div>
                <img src="images/Строительные работы.jpg" class="img-responsive img-thumbnail" alt="">
            </div>
        </div>
        <div class="col-md-4 block">
            <p><strong>Защита и восстановление строительных конструкций</strong></p>

            <div>
                <img src="images/Защита и восстановление строительных конструкций.jpg"
                     class="img-responsive img-thumbnail" alt="">
            </div>

        </div>
        <div class="col-md-4 block">
            <p><strong>Перепланировка помещений</strong></p>

            <div>
                <img src="images/Перепланировка помещений.jpg" class="img-responsive img-thumbnail" alt="">
            </div>


        </div>

    </div>
    <!--3-->
    <div class="row">
        <div class="col-md-4 block">
            <p><strong>Реконструкция зданий и сооружений</strong></p>

            <div>
                <img src="images/Реконструкция зданий и сооружений.jpg" class="img-responsive img-thumbnail" alt="">
            </div>
        </div>
        <div class="col-md-4 block">
            <p><strong>Проектные работы</strong></p>

            <div>
                <img src="images/Проектные работы.jpg" class="img-responsive img-thumbnail" alt="">
            </div>

        </div>
        <div class="col-md-4 block">
            <p><strong>Поставщики оборудования и расходных материалов для алмазной резки и бурения</strong></p>

            <div>
                <img src="images/Поставщики оборудования и расходных материалов для алмазной резки и бурения.jpg"
                     class="img-responsive img-thumbnail" alt="">
            </div>


        </div>

    </div>
    <!--4-->
    <div class="row">
        <div class="col-md-4 block">
            <p><strong>Поставщики специализированных строит. материалов</strong></p>

            <div>
                <img src="images/Поставщики специализированных строит. материалов.jpg"
                     class="img-responsive img-thumbnail" alt="">
            </div>
        </div>
        <div class="col-md-4 block">
            <p><strong>Аренда спец автотранспорта</strong></p>

            <div>
                <img src="images/Аренда спец автотранспорта 2.jpg" class="img-responsive img-thumbnail" alt="">
            </div>

        </div>
        <div class="col-md-4 block">
            <p><strong>Вывоз и утилизация строительного мусора</strong></p>

            <div>
                <img src="images/Вывоз и утилизация строительного мусора.jpg" class="img-responsive img-thumbnail"
                     alt="">
            </div>


        </div>

    </div>

</div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">войти</h4>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="exampleInputName">Имя</label>
                        <input type="text" class="form-control" id="exampleInputName" placeholder="Имя">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">пароль</label>
                        <input type="password" class="form-control" id="exampleInputEmail1" placeholder="пароль">
                    </div>
                    <button type="submit" class="btn btn-default" data-dismiss="modal">войти</button>
                    <button type="submit" class="btn btn-default" data-dismiss="modal">регистрация</button>
                </form>

            </div>
        </div>
    </div>
</div>
