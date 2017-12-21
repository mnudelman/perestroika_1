<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 23.07.17
 * Time: 11:57
 */



$begin = new DateTime( '2012-08-01' );
$end = new DateTime( '2012-08-31' );
$end = $end->modify( '+1 day' );

$interval = new DateInterval('P1D');
$daterange = new DatePeriod($begin, $interval ,$end);

foreach($daterange as $date){
    echo $date->format("Ymd") . "<br>";
}
?>