<?php

// 関数化①データベース接続（引数なしで接続結果をリターン）
function dbConect(){
    $dsn ='mysql:host=localhost;dbname=test_app;charset=utf8';
    $user='blog_user';
    $pass='testpass';

    /* エラーチェック (DBのエラーチェックにはtry~catchを使う)
    try{通常処理}catch(){エラー時の処理}
    */
    // PDO(PHP Data Object)についてはHPにて詳細確認
    try{
    $dbh = new \PDO($dsn,$user,$pass,[
        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
    ]);
    } 
    catch(PDOException $e){
    echo'接続失敗'.$e->getMessage();
    exit();
    };
return $dbh;
}

// 関数化②データ取得（DBの入力値を取得）
function getAllBlog(){
    $dbh=dbConect();
    //SQLの準備
    $sql='SELECT*FROM blog';
    //SQLの実行
    $stmt=$dbh->query($sql);
    //SQLの結果を受け取る
    $result=$stmt->fetchall(\PDO::FETCH_ASSOC);
    return $result;
    $dbh=null;
}


// 関数化③カテゴリ名を表示（カテゴリ番号（数字）からカテゴリ名（文字列）に変換）
function setCategoryName($category){
    if($category ==='1'){return'ブログ';
    }elseif($category ==='2'){return'日常';
    }else{return'その他';
    }
}



function getBlog($id){
    if(empty($id)){
    exit('IDが不正です');
}

$dbh=dbConect();

//SQL準備
$stmt = $dbh->prepare('SELECT*FROM blog Where id=:id');
$stmt->bindValue(':id',(int)$id,\PDO::PARAM_INT);
//SQLの実行
$stmt->execute();
//SQLの結果を受け取る
$result=$stmt->fetch(\PDO::FETCH_ASSOC);

if(!$result){
    exit('ブログがありません');
}
return $result;
}
?>