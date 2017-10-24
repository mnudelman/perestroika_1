<?php
/**
 * Заказы, переданные мне на исполнение
 * Time: 18:40
 */
?>
<div class="container-fluid">
    <h2 class="header-title" style="text-align: left;">Заказы, в которых выбран исполнителем</h2>
    <div class="row">
        <div class="table-responsive">
        <table class="table">
            <tr>
                <th>
                    N заказа
                </th>
                <th>
                    Наименование
                </th>
                <th>
                    дата размещения
                </th>
                <th>
                    описание заказа
                </th>
                <th>
                    согласен исполнить
                </th>

            </tr>
            <tr>
                <td>
                    12356790
                </td>
                <td>
                    сверление отверстий в бетоне под коммуникации
                </td>
                <td>
                    <input type="date" class="form-control" id="orderDate_1" value="10.12.2016" >
                </td>
                <td>
                    <a href="#">
                        <button class="btn btn-primary" type="submit">
                            <span class="glyphicon glyphicon-triangle-right" aria-hidden="true"
                                  title="описание заказа"></span>
                        </button>
                    </a>

                </td>

                <td>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" checked="checked">

                        </label>
                    </div>
                </td>
            <tr>

        </table>
       </div>
    </div>
</div>