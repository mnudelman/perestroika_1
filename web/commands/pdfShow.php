<?php
function showPDF($filename) {
 $pdf=fopen($filename,'r');
 $content=fread($pdf,filesize($filename));
 fclose($pdf);
 header('Content-type: application/pdf');
 print($content);
}
$fnUrl = $_GET['fn'] ;
$pathInfo = pathinfo($fnUrl) ;
$ext = $pathInfo['extension'] ;
if ($ext === 'pdf') {
//    $a = Yii::getAlias('@app') ;
    $fn = $_SERVER['DOCUMENT_ROOT'] . $fnUrl ;
    showPdf($fn) ;
} else {
    $tagImg = '<img src="' . $fnUrl . '">' ;
    echo $tagImg ;
}

//$fn = __DIR__ .'/orderScheme.pdf' ;
//showPdf($fn) ;
