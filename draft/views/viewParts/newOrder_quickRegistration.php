<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 19.11.16
 * Time: 19:00
 */
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <p>
                Вы зашли на <strong>оформление заказа</strong> без регистрации. Для продолжения
                оформления заказа надо
                <a href="#">пройти регистрацию</a> или заполнить поля для автоматической регистрации.
                В этом случае вашим логином будет ваш адрес e-mail, пароль будет сгенерирован и
                отправлен на ваш
                e-mail. В дальнейшем вы сможете сменить пароль войдя в свой профиль.
            </p>
        </div>
    </div>
</div>
<h4 class="header-title" style="text-align: left;">экспресс регистрация</h4>
<form>
    <div class="form-group">
        <label for="exampleInputName">Имя фирмы</label>
        <input type="password" class="form-control" id="exampleInputName" placeholder="Имя фирмы">
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Email адрес</label>
        <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Email">
    </div>
    <div class="form-group">
        <label for="exampleInputTel">телефон</label>
        <input type="text" class="form-control" id="exampleInputTel" placeholder="+7-nnn-nnnnnnn">
    </div>
    <div class="checkbox">
        <label>
            <input type="checkbox" value="true"> Автоматическая регистрация
        </label>
    </div>
    <button type="submit" class="btn btn-default">сохранить</button>
</form><br>
