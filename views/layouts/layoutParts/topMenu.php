<?php
/**
 * Голова страницы
 */
?>
<div class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid  ">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div class="navbar-collapse collapse">

            <ul class="nav navbar-nav">

                <li>
                    <a href="?page=homePage">ГЛАВНАЯ</a>
                </li>
                <li>
                    <a href="?page=newOrder">
                        СДЕЛАТЬ ЗАКАЗ
                    </a>
                </li>
                <li>
                    <a href="?page=developersList">
                        ИСПОЛНИТЕЛИ РАБОТ
                    </a>
                </li>

                <li class="current">
                    <a href="?page=about">
                        О САЙТЕ
                    </a>
                </li>


                <li>
                    <a href="?page=forum">
                        ФОРУМ
                    </a>
                </li>

                <li>
                    <a href="?page=registration">
                        РЕГИСТРАЦИЯ
                    </a>
                </li>

                <li>


                    <button type="button" class="btn btn-default btn-lg" data-toggle="modal" data-target="#myModal"
                            style="background-color: rgba(0,0,0,0); border: none; font-size: 14px; padding-top: 17px;">
                        ВОЙТИ
                    </button>
                </li>


                <li><a href="?page=languageTrigger">
                        <img src="images/ru.png" class="img-responsive" alt="russian language"
                             title="переключение языка">
                    </a>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">

                <li>
                    <a href="?page=privateOffice" class="change-locaton" title="личный кабинет">
                        <i class="fa fa-map-marker">minkin&Ko</i>
                    </a>
                </li>

            </ul>

        </div>
    </div>
</div>
<div>
    <nav class="navbar navbar-default" style="margin-top:30px">
        <div class="container-fluid">
            <div class="row" style="background-color: white;">
                <div class="navbar-header">
                    <a href="#">
                        <img alt="Brand" class="image-logo" src="images/logo.jpg">
                    </a>
                </div>
            </div>
        </div>
    </nav>
</div>

<!-- Modal -->
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