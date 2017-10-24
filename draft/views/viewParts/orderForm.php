<?php
/**
 * Форма регистрации заказа
 * Time: 16:13
 */
?>

<h4 class="header-title" style="text-align: left;">форма заказа</h4>

<form>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="orderNumber">N заказа</label>
                    <input type="text" class="form-control" id="orderNumber" placeholder=""
                           readonly="readonly" value="3456789" title="формируется автоматически">
                </div>
            </div>
            <div class="col-md-9">
                <div class="form-group">
                    <label for="orderName">имя заказа</label>
                    <input type="text" class="form-control" id="orderName" placeholder="имя заказа">
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="orderDescription">описание заказа</label>
                    <textarea class="form-control" rows="7" id="orderDescription"></textarea>
                </div>
            </div>
        </div>
        <h5 class="header-title" style="text-align: left;">место исполнения заказа</h5>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="placeCountry">страна</label>
                    <select class="form-control" id="placeCountry">
                        <option>Россия</option>
                        <option>Беларусь</option>
                        <option>Казахстан</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="placeRegion">регион</label>
                    <select class="form-control" id="placeRegion">
                        <option>Свердловская область</option>
                        <option>Челябинская область</option>
                        <option>Оренбургская область</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="placeTown">город</label>
                    <select class="form-control" id="placeTown">
                        <option>Екаринбург</option>
                        <option>Челябинск</option>
                        <option>Оренбург</option>
                    </select>
                </div>
            </div>

        </div>
        <h5 class="header-title" style="text-align: left;">период исполнения (начало работы)</h5>

        <!--        <form class="form-inline">-->
        <div class="row">
            <div class="col-md-6">
                <div class="radio">
                    <label>
                        <input type="radio" name="optionsRadios" id="periodQuickly" value="option1" checked>
                        Приступить в течении
                    </label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="3" aria-describedby="basic-addon2">
                    <span class="input-group-addon" id="basic-addon2">дней с момента регистрации заказа</span>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="radio">
                    <label>
                        <input type="radio" name="optionsRadios" id="periodBeginEnd" value="option2">
                        Приступить в заданный календарный период
                    </label>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label class="sr-only" for="exampleInputAmount">Amount (in dollars)</label>

                    <div class="input-group">
                        <div class="input-group-addon">начало</div>
                        <input type="text" class="form-control" id="exampleInputAmount" placeholder="dd/mm/yyyy">
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label class="sr-only" for="exampleInput">Amount (in dollars)</label>

                    <div class="input-group">
                        <div class="input-group-addon">конец</div>
                        <input type="text" class="form-control" id="exampleInput" placeholder="dd/mm/yyyy">
                    </div>
                </div>
            </div>
        </div>

        <h5 class="header-title" style="text-align: left;">Состав работ</h5>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="rebuildRoute">Направление работ</label>
                    <select class="form-control" id="rebuildRoute">
                        <option>алмазная резка и бурение</option>
                        <option>Аренда спец автотранспорта</option>
                        <option>Вывоз и утилизация строительного мусора</option>
                        <option>Демонтаж зданий и сооружений</option>
                        <option>Демонтажные работы</option>
                        <option>Защита и восстановление строительных конструкций.jpg</option>
                        <option>Перепланировка помещений</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="rebuildWork">Добавить работу</label>
                    <select class="form-control" id="rebuildWork">
                        <option>Алмазное буреие отверстий в бетоне</option>
                        <option>Алмазная резка бетона, железобетона</option>
                        <option>Алмазная резка проёмов в стенах, перекрытиях</option>
                        <option>Штробление бетонных полов, стен</option>
                    </select>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-md-4">

                <div>
                    <img src="images/алмазная резка и бурение.jpg" class="img-responsive img-thumbnail" alt="">
                </div>

            </div>
            <div class="col-md-8">
                <table class="table">
                    <tr>
                        <th>
                            Наименование
                        </th>
                        <th>
                            delete
                        </th>
                    </tr>
                    <tr>
                        <td>
                            Алмазное буреие отверстий в бетоне
                        </td>
                        <td>
                            <button class="btn btn-primary" type="submit">
                                <span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Алмазная резка бетона, железобетона
                        </td>
                        <td>
                            <button class="btn btn-primary" type="submit">
                                <span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Алмазная резка проёмов в стенах, перекрытиях
                        </td>
                        <td>
                            <button class="btn btn-primary" type="submit">
                                <span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Штробление бетонных полов, стен
                        </td>
                        <td>
                            <button class="btn btn-primary" type="submit">
                                <span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
                            </button>
                        </td>
                    </tr>

                </table>
            </div>

        </div>


        <h5 class="header-title" style="text-align: left;">Дополнительные материалы</h5>

        <div class="row">
            <div class="col-md-6">
                <button class="btn btn-primary" type="submit">
                    Добавить схему, описание, ...
                </button>


            </div>
        </div>
        <div class="row">
            <table class="table">
                <tr>
                    <th>
                        Наименование материала
                    </th>
                    <th>
                        просмотр
                    </th>
                    <th>
                        delete
                    </th>

                </tr>
                <tr>
                    <td>
                        схема1
                    </td>
                    <td>
                        <button class="btn btn-primary" type="submit">
                            <span class="glyphicon glyphicon-triangle-right" aria-hidden="true" title="просмотр"></span>
                        </button>
                    </td>

                    <td>
                        <button class="btn btn-primary" type="submit">
                            <span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
                        </button>
                    </td>

                </tr>
            </table>
        </div>


        <h5 class="header-title" style="text-align: left;">Рассылка заказа</h5>

        <div class="row">
            <div class="col-md-5">
                <div class="input-group">
                    <div class="input-group-addon">Число потенциальных исполнителей</div>
                    <input type="text" class="form-control" id="developerNumber" value="10" placeholder="10"
                           readonly="readonly">
                </div>
            </div>
            <div class="col-md-1">
                <button class="btn btn-primary" type="submit">
                    <span class="glyphicon glyphicon-repeat" aria-hidden="true"></span>
                </button>

            </div>
            <div class="col-md-6">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" value="">
                        Отправить запрос на исполнение всем
                    </label>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="rebuildWork">Добавить исполнителя</label>
                    <select class="form-control" id="developersList">
                        <option>ООО "Бетон и лазер"</option>
                        <option>ЗАО "Резка бетона"</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <table class="table">
                <tr>
                    <th>
                        Организация
                    </th>
                    <th>
                        профиль
                    </th>
                    <th>
                        delete
                    </th>

                </tr>
                <tr>
                    <td>
                        ООО "Бетон и лазер"
                    </td>
                    <td>
                        <button class="btn btn-primary" type="submit">
                            <span class="glyphicon glyphicon-triangle-right" aria-hidden="true"
                                  title="подробнее"></span>
                        </button>
                    </td>

                    <td>
                        <button class="btn btn-primary" type="submit">
                            <span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
                        </button>
                    </td>

                </tr>
                <tr>
                    <td>
                        ЗАО "Резка бетона"
                    </td>
                    <td>
                        <button class="btn btn-primary" type="submit">
                            <span class="glyphicon glyphicon-triangle-right" aria-hidden="true"
                                  title="подробнее"></span>
                        </button>
                    </td>

                    <td>
                        <button class="btn btn-primary" type="submit">
                            <span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
                        </button>
                    </td>

                </tr>

            </table>
        </div>

        <div class="row">
            <button type="button" class="btn btn-success btn-lg">Отправить заказ на исполнение</button>
            <button type="button" class="btn btn-danger btn-lg">отказаться</button>
        </div>
    </div>
    </div>
</form>
