<?php
/**
 * Список форм проекта
 */
?>
<h2 class="header-title" style="text-align: left;">Эскизы форм проекта</h2>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <p>
                Здесь представлены эскизы форм проекта. Список будет пополняться новыми формами
            </p>
        </div>
    </div>
</div>
<?php

  $dirDraft = realpath(__DIR__ . "/..") ;
  echo $dirDraft ;
?>
<div class="row">
    <table class="table">
        <tr>
            <th>
                Наименование
            </th>
            <th>
                ссылка
            </th>
            <th>
                комментарий
            </th>

        </tr>
        <tr>
            <td>
                Главная(домашняя страница)
            </td>
            <td>
                <a href="homePage.php">
                    <button class="btn btn-primary" type="submit">
                            <span class="glyphicon glyphicon-triangle-right" aria-hidden="true"
                                  title="Домашняя страница"></span>
                    </button>
                </a>

            </td>

            <td>
            </td>

        </tr>
        <tr>
            <td>
                Список исполнителей
            </td>
            <td>
                <a href="developersList.php">
                    <button class="btn btn-primary" type="submit">
                            <span class="glyphicon glyphicon-triangle-right" aria-hidden="true"
                                  title="Домашняя страница"></span>
                    </button>
                </a>

            </td>

            <td>
                последние 2 ссылки на реальные сайты
            </td>

        </tr>
        <tr>
            <td>
                Мои работы
            </td>
            <td>
                <a href="developerWorks.php">
                    <button class="btn btn-primary" type="submit">
                            <span class="glyphicon glyphicon-triangle-right" aria-hidden="true"
                                  title="Домашняя страница"></span>
                    </button>
                </a>

            </td>

            <td>
            </td>

        </tr>
         <tr>
            <td>
                Новый заказ (с экспресс регистрацией)
            </td>
            <td>
                <a href="newOrder.php">
                    <button class="btn btn-primary" type="submit">
                            <span class="glyphicon glyphicon-triangle-right" aria-hidden="true"
                                  title="Новый заказ"></span>
                    </button>
                </a>

            </td>

            <td>
            </td>

        </tr>
        <tr>
            <td>
                Личный кабинет
            </td>
            <td>
                <a href="privateOffice.php">
                    <button class="btn btn-primary" type="submit">
                            <span class="glyphicon glyphicon-triangle-right" aria-hidden="true"
                                  title="Домашняя страница"></span>
                    </button>
                </a>

            </td>

            <td>
                Здесь личный кабинет с вызванной формой заказа
            </td>

        </tr>

    </table>
</div>
