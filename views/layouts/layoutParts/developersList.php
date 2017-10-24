<?php
/**
 * Список исполнителей
 */
?>
<h3 class="header-title" style="text-align: left;">Исполнители работ, зарегистрированные на сайте</h3>

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

    <div class="col-md-8 block">
        <table class="table">
            <tr>
                <th>
                    Наименование работ
                </th>
                <th>
                    организация выполняет работу
                </th>
            </tr>
            <tr>
                <td>
                    Алмазное буреие отверстий в бетоне
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


<h5 class="header-title" style="text-align: left;">Список исполнителей по направлению</h5>

<div class="row">
<div class="col-md-12">
    <table class="table">
        <tr>
            <th>
                Организация
            </th>
            <th>
                профиль
            </th>
            <th>
                дата регистрации
            </th>

        </tr>
        <tr>
            <td>
                ООО "Бетон и лазер"
            </td>
            <td>
                <button class="btn btn-primary" type="submit">
                    <span class="glyphicon glyphicon-triangle-right" aria-hidden="true" title="подробнее"></span>
                </button>
            </td>

            <td>
                <input type="date" class="form-control" id="date1" placeholder="dd/mm/yyyy">
            </td>

        </tr>
        <tr>
            <td>
                ЗАО "Резка бетона"
            </td>
            <td>
                <button class="btn btn-primary" type="submit">
                    <span class="glyphicon glyphicon-triangle-right" aria-hidden="true" title="подробнее"></span>
                </button>
            </td>

            <td>
                <input type="date" class="form-control" id="date2" placeholder="dd/mm/yyyy">
            </td>

        </tr>
        <tr>
            <td>
                Алмазная резка и бурение в Оренбурге
            </td>
            <td>
                <a href="http://www.macmep.com/almaznaya-rezka-bureniye-orenburg?yclid=6935773512505230481"
                     target="_blank" title="реальный сайт">
                <button class="btn btn-primary" type="submit">


                    <span class="glyphicon glyphicon-triangle-right" aria-hidden="true" title="подробнее"></span>
                </button>
                </a>
            </td>

            <td>
                <input type="date" class="form-control" id="date2" placeholder="dd/mm/yyyy">
            </td>

        </tr>
        <tr>
            <td>
                Резка бетона в Оренбурге
            </td>
            <td>
                <a href="http://rezkabetona56.ru/index.php/home"
                   target="_blank" title="реальный сайт">
                    <button class="btn btn-primary" type="submit">


                        <span class="glyphicon glyphicon-triangle-right" aria-hidden="true" title="подробнее"></span>
                    </button>
                </a>
            </td>

            <td>
                <input type="date" class="form-control" id="date2" placeholder="dd/mm/yyyy">
            </td>

        </tr>

    </table>
</div>
</div>


