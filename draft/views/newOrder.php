<?php
/**
 *    форма для новогоЗаказа
 */
//echo 'Это новый заказ...';
?>
<div class="container fluid">
    <div class="row">
        <div class="col-md-12 block">
            <h3 class="header-title" style="text-align: center;">Оформление заказа</h3>
            <?php
            include __DIR__ . "/viewParts/newOrder_quickRegistration.php";
            ?>
        </div>
    </div>
<!--</div>-->
<!--<div class="container-fluid">-->
    <div class="row">
        <div class="col-md-12 block">
            <?php
            include __DIR__ . "/viewParts/orderForm.php";
            ?>
        </div>
    </div>
</div>

