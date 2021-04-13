<?php
require_once('env.php');
Class Dbc{

    protected $table_name;
    // コンストラクタ__は_×２ 
    // function __construct($table_name){
    //     $this->tabke_name = $table_name

    // 関数化①データベース接続（引数なしで接続結果をリターン）
    protected function dbConect(){
        $host=DB_HOST;//定数の場合は""不要
        $dbname=DB_NAME;
        $user=DB_USER;
        $pass=DB_PASS;
        $dsn ="mysql:host=$host;dbname=$dbname;charset=utf8";

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
     public function getAll(){
        //クラス内のファンクションを利用するときは$this->が必要
        $dbh=$this->dbConect();
        //SQLの準備
        // シングルクォーテーションからダブルクォーテーションにしないと変数が展開できない
        $sql="SELECT*FROM $this->table_name";
        //SQLの実行
        $stmt=$dbh->query($sql);
        //SQLの結果を受け取る
        $result=$stmt->fetchall(PDO::FETCH_ASSOC);
        return $result;
        $dbh=null;
    }



    public function getById($id){
        if(empty($id)){
        exit('IDが不正です');
    }

    $dbh=$this->dbConect();

    //SQL準備
    $stmt = $dbh->prepare("SELECT*FROM $this->table_name Where id=:id");
    $stmt->bindValue(':id',(int)$id,PDO::PARAM_INT);
    //SQLの実行
    $stmt->execute();
    //SQLの結果を受け取る
    $result=$stmt->fetch(PDO::FETCH_ASSOC);

    if(!$result){
        exit('ブログがありません');
    }
    return $result;
    }

    public function delete($id){
        if(empty($id)){
            exit('IDが不正です');
        }
    
        $dbh=$this->dbConect();
    
        //SQL準備
        $stmt = $dbh->prepare("DELETE FROM $this->table_name Where id=:id");
        $stmt->bindValue(':id',(int)$id,PDO::PARAM_INT);
        //SQLの実行
        $stmt->execute();
        echo'ブログを削除しました';
        
        return $result;
    }
        
}
?>