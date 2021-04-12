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
        $sql='INSERT INTO blog(title,contents,category,publish_status)
        VALUES(:title,:contents,:category,:publish_status)';

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


}
?>