<?php
/**
 * Работы, выполняемые исполнителем
 *
 */
?>
<h3 class="header-title" style="text-align: left;">Мои работы/услуги</h3>

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
    <div class="col-md-4">
        <div>
            <img src="images/алмазная резка и бурение.jpg" class="img-responsive img-thumbnail" alt="">
        </div>
    </div>
</div>
<div class="row">

    <div class="col-md-8">
        <table class="table">
            <tr>
                <th>
                    Наименование работ/услуг
                </th>
                <th>
                    организация выполняет работу
                </th>
            </tr>
            <tr>
                <td>
                    Алмазное бурение отверстий в бетоне
                </td>
                <td>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" checked="checked">
                        </label>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    Алмазная резка бетона, железобетона
                </td>
                <td>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" checked="checked">
                        </label>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    Алмазная резка проёмов в стенах, перекрытиях
                </td>
                <td>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" checked="checked">
                        </label>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    Штробление бетонных полов, стен
                </td>
                <td>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" checked="checked">
                        </label>
                    </div>
                </td>
            </tr>

        </table>
    </div>

</div>

<h5 class="header-title" style="text-align: left;">Города, где выполняются работы по направлению</h5>

<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label for="placeCountry">страна</label>
            <select class="form-control" id="placeCountry">
                <option>Россия</option>
                <option>Беларусь</option>
                <option>Казахстан</option>
            </select>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="placeRegion">регион</label>
            <select class="form-control" id="placeRegion">
                <option>Свердловская область</option>
                <option>Челябинская область</option>
                <option>Оренбургская область</option>
            </select>
        </div>
    </div>
    <div class="col-md-3">
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
<div class="row">
    <div class="col-md-2">
        <button type="button" class="btn btn-primary ">Добавить город</button>
    </div>
</div> <br>

<div class="row">

    <div class="col-md-8">
        <table class="table">
            <tr>
                <th>
                    Страна
                </th>
                <th>
                    Регион
                </th>
                <th>
                    Город
                </th>
                <th>
                    delete
                </th>

            </tr>
            <tr>
                <td>
                    Россия
                </td>
                <td>
                    Свердловская обл
                </td>
                <td>
                    Екатиринбург
                </td>
                <td>
                    <button class="btn btn-primary" type="submit">
                        <span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
                    </button>
                </td>
            </tr>
            <tr>
                <td>
                    Россия
                </td>
                <td>
                    Свердловская обл
                </td>
                <td>
                    Нижний тагил
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
<br>

<h5 class="header-title" style="text-align: left;">Дополнительные материалы</h5>

<div class="row">
    <div class="col-md-6">
        <button class="btn btn-primary" type="submit">
            Добавить фото, рисунок,сертификат ... характеризующую организацию (до 10 файлов)
        </button>
    </div>
</div>
<div class="row">
    <div class="col-md-4">

        <div>
            <img src="images/строительство и ремонт 1 480x363.jpg" class="img-responsive img-thumbnail" alt="">
        </div>

    </div>
</div>

<div class="row">
    <div class="col-md-12">
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
</div>




<button type="button" class="btn btn-success btn-lg">Сохранить</button>
<!--<button type="button" class="btn btn-danger btn-lg">отказаться</button>-->