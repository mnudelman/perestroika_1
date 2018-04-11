<?php
use app\service\SimpleEncrypt ;
//$baseString = '1234567890ABCDEF' ;
$baseString = substr(\Yii::$app->security->generateRandomString(),-20) ;
echo 'baseStr:' . $baseString . '<br>' ;

$encript = new SimpleEncrypt() ;
echo 'Test-1:order'. '<br>' ;
$encript->setKey('order') ;
$testStr = $encript->encryptDo($baseString) ;
$key = $encript->getUnencryptKey($baseString,$testStr) ;
echo 'baseStr:' . $baseString . '<br>' ;
echo 'testStr:' . $testStr . '<br>' ;

var_dump($key) ;
echo 'Test-2:orderSelected'. '<br>' ;
$encript->setKey('orderSelected') ;
$testStr = $encript->encryptDo($baseString) ;
$key = $encript->getUnencryptKey($baseString,$testStr) ;
echo 'baseStr:' . $baseString . '<br>' ;
echo 'testStr:' . $testStr . '<br>' ;

var_dump($key) ;

echo 'Test-3:byHand.start:5,step:3'. '<br>' ;
$encript->setKey('new',5,3) ;
$testStr = $encript->encryptDo($baseString) ;
$key = $encript->getUnencryptKey($baseString,$testStr) ;
echo 'baseStr:' . $baseString . '<br>' ;
echo 'testStr:' . $testStr . '<br>' ;

var_dump($key) ;

echo 'Test-4:error.start:5,step:3'. '<br>' ;
$encript->setKey('new',5,3) ;
$testStr = $encript->encryptDo($baseString) ;
echo 'testStr:' . $testStr . '<br>' ;
$testStr = strtoupper($testStr) ;
$key = $encript->getUnencryptKey($baseString,$testStr) ;
echo 'baseStr:' . $baseString . '<br>' ;
echo 'testStr:' . $testStr . '<br>' ;

var_dump($key) ;
