<?php
/**
 * Личный кабинет
 * Time: 12:37
 */
$ACTION_DEFAULT = "newOrderSimple" ;
if (isset($_GET['act'])) {
    $action = $_GET['act'] ;
}else {
    $action = $ACTION_DEFAULT ;
}
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2 block">
            <ul class="nav nav-pills nav-stacked">
                <li>
                    <a href="privateOffice.php?act=newOrderSimple" class="list-group-item">Новый заказ</a>
                </li>
                <li>
                    <a href="privateOffice.php?act=ordersPlaced" class="list-group-item">Мои размещённые заказы</a>
                </li>
                <li>
                    <a href="privateOffice.php?act=developerWorks" class="list-group-item">Мои работы/услуги</a>
                </li>
                <li>
                    <a href="privateOffice.php?act=initialConsent" class="list-group-item">Заказы, ждущие первичного согласия на испонение</a>
                </li>

                <li>
                    <a href="privateOffice.php?act=ordersTransmitted" class="list-group-item">Заказы, в которых я выбран исполнителем</a>
                </li>

            </ul>


         </div>
         <div class="col-md-10 block">
            <div class="row">
                <?php
                if (empty($action)) {
                    echo '<br> Не выбрано действие ' ;
                }else {
                    include __DIR__ . "/".$action.'.php' ;
                }

//                include __DIR__ . "/newOrderSimple.php";
//                include __DIR__ . "/newOrder.php";
//                  include __DIR__ . "/developersList.php";
//                  include __DIR__ . "/developerWorks.php";


                ?>
            </div>
        </div>
    </div>
</div>