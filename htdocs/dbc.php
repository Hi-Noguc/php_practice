<?php


$dsn ='mysql:host=localhost;dbname=test_app;charset=utf8';
$user='blog_use';
$pass='testpass';

/* エラーチェック (DBのエラーチェックにはtry~catchを使う)
    try{通常処理}catch(){エラー時の処理}
*/
try{
    $dbh = new PDO($dsn,$user,$pass,[
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);
    echo'接続成功';
    $dbh=nell;
} 
catch(PDOException $e){
    echo'接続失敗'.$e->getMessage();
    exit();
};

/* 接続チェック
var_dump($dbh);
*/




?>