<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
<?php

function showPDF($filename) {
    $pdf=fopen($filename,'r');
    $content=fread($pdf,filesize($filename));
    fclose($pdf);
    header('Content-type: application/pdf');
    echo($content);
}
showPDF('ответ-2016-11-26T02:02.pdf') ;
?>


</body>
</html>