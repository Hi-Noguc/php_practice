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
    $dbh = new PDO($dsn,$user,$pass,[
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
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
    $result=$stmt->fetchall(PDO::FETCH_ASSOC);
    return $result;
    $dbh=null;
}

$blogData = getAllBlog();


// 関数化③カテゴリ名を表示（カテゴリ番号（数字）からカテゴリ名（文字列）に変換）
function setCategoryName($category){
    if($category ==='1'){return'ブログ';
    }elseif($category ==='2'){return'日常';
    }else{return'その他';
    }
}

?>

<!--VSCODEの場合先頭に「！」＋TABでhtml書式呼び起こし可能  -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ブログ一覧</title>
</head>
<body>
<h2>ブログ一覧</h2>
    <table>
        <tr>
            <th>No.</th>
            <th>タイトル</th>
            <th>カテゴリ</th>
        </tr>

        <!-- endforeach使用時にはforeach文はコロン:とする -->
        <?php foreach($blogData as $column): ?>
        <tr>
            <td><?php echo $column['id']?></td>
            <td><?php echo $column['title']?></td>
            <td><?php echo setCategoryName($column['category'])?></td>
        </tr>
        <?php endforeach;?>

    </table>
    
</body>
</html>
