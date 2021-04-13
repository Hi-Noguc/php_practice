<?php
require_once('dbc.php');

// 継承はextends
Class Blog extends Dbc{

    protected $table_name ='blog';

    // 関数化③カテゴリ名を表示（カテゴリ番号（数字）からカテゴリ名（文字列）に変換）
    public function setCategoryName($category){
        if($category ==='1'){return'日常';
        }elseif($category ==='2'){return'プログラミング';
        }else{return'その他';
        }
    }

    public function blogCreate($blogs){
        $sql="INSERT INTO $this->table_name(title,contents,category,publish_status)
        VALUES(:title,:contents,:category,:publish_status)";

        $dbh = $this->dbConect();
        $dbh->beginTransaction();

        try{
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':title',$blogs['title'],PDO::PARAM_STR);
        $stmt->bindValue(':contents',$blogs['contents'],PDO::PARAM_STR);
        $stmt->bindValue(':category',$blogs['category'],PDO::PARAM_INT);
        $stmt->bindValue(':publish_status',$blogs['publish_status'],PDO::PARAM_INT); 
        $stmt->execute();
        $dbh->commit();
        echo'ブログを投稿しました';
        } 
        catch(PDOException $e)
        {
        $dbh->rollBack();
        exit($e);
        }
    }
    public function blogUpdate($blogs){
        $sql="UPDATE $this->table_name SET 
        title=:title,contents=:contents,category=:category,publish_status=:publish_status
        WHERE id=:id";

        $dbh = $this->dbConect();
        $dbh->beginTransaction();

        try{
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':title',$blogs['title'],PDO::PARAM_STR);
        $stmt->bindValue(':contents',$blogs['contents'],PDO::PARAM_STR);
        $stmt->bindValue(':category',$blogs['category'],PDO::PARAM_INT);
        $stmt->bindValue(':publish_status',$blogs['publish_status'],PDO::PARAM_INT); 
        $stmt->bindValue(':id',$blogs['id'],PDO::PARAM_INT); 
        $stmt->execute();
        $dbh->commit();
        echo'ブログを更新しました';
        } 
        catch(PDOException $e)
        {
        $dbh->rollBack();
        exit($e);
        }
    }

    //ブログのバリデーション
    public function blogValidate($blogs){
        if(empty($blogs['title'])){
            exit('タイトルを入力してください');
        }
        if(empty($blogs['contents'])){
            exit('本文を入力してください');
        }
        if(mb_strlen($blogs['title'])>191){
            exit('タイトルは191文字以下にしてください');
        }
        if(empty($blogs['category'])){
            exit('カテゴリは必須です');
        }
        if(empty($blogs['publish_status'])){
            exit('公開ステータスは必須です');
        }
    }

}
?>