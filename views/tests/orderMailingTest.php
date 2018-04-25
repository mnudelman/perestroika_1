<?php
use app\models\OrderMailing ;
$rec = OrderMailing::findOne(1) ;
var_dump($rec) ;
$a = 1 ;