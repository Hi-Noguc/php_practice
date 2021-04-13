<?php 
/*
外部ファイル読み込みについて
require 読み込み失敗で処理を中止    通例：ロジック系にはrequire_once
include 読み込み失敗でも処理を継続  通例：処理が続行しても問題ないHTML
ともに_onceがつくと再読み込みしない
*/
require_once('blog.php');
ini_set( 'display_errors', "On" );

$blog=new Blog();

$blogData=$blog->getAll();
// htmlspecialcharsを関数化
function h($s){
    return htmlspecialchars($s,ENT_QUOTES,"UTF-8");
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
<p><a href="/form.html">新規作成</a></p>
    <table>
        <tr>
            <th>タイトル</th>
            <th>カテゴリ</th>
            <th>投稿日時</th>
        </tr>

        <!-- endforeach使用時にはforeach文はコロン:とする -->
        <?php foreach($blogData as $column): ?>
        <tr>
            <td><?php echo h($column['title'])?></td>
            <td><?php echo h($blog->setCategoryName($column['category']))?></td>
            <td><?php echo h($column['post_at'])?></td>
            <td><a href="/detail.php?id=<?php echo $column['id']?>">詳細</a></td>
            <td><a href="/update_form.php?id=<?php echo $column['id']?>">編集</a></td>
            <td><a href="/blog_delete.php?id=<?php echo $column['id']?>">削除</a></td>
        </tr>
        <?php endforeach;?>

    </table>
    
</body>
</html>