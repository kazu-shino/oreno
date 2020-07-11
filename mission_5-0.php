
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_5-1.php</title>
</head>

<body>

<?php
    //データベース名：データベース名
    //ユーザー名：ユーザ名
    //パスワード: パスワード

    //DB接続設定
    $dsn ='mysql:dbname='データベース名';host=localhost';
    $user ='ユーザ名';
    $password ='パスワード';
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

    //-----テーブル作成-----
    //テーブル名keijibanを指定してテーブルを作成
    $sql = "CREATE TABLE IF NOT EXISTS keijiban" 
    ."("
    ." id INT AUTO_INCREMENT PRIMARY KEY,"
    ."name CHAR(32) NOT NULL,"
    ."comment TEXT NOT NULL,"
    ."password CHAR(32) NOT NULL,"
    ."date DATETIME"
    .");";
	$stmt = $pdo->query($sql);

    //-----MYSQLにデータを書き込む(投稿機能)-----
    if(isset($_POST["name"]) && isset($_POST["comment"]) && isset($_POST["password"]))
        {
            //SQL文
            $sql="INSERT INTO keijiban (name,comment,date,password) VALUES (:name,:comment,:date,:password)";
            $stmt=$pdo->prepare($sql);
		    $stmt->bindParam( ':name', $name, PDO::PARAM_STR );
            $stmt->bindParam( ':comment', $comment, PDO::PARAM_STR );
            $stmt->bindParam( ':date', $date, PDO::PARAM_STR );
		    $stmt->bindParam( ':password', $password, PDO::PARAM_STR );
            //データ入力
            $name = $_POST["name"];
            $comment = $_POST["comment"]; 
            $date = date("Y/m/d H:i:s");
            $password=$_POST["password"];

            $stmt->execute();
            
            /*
            //入力データを表示
            // SELECT文を変数に格納
            $sql = "SELECT * FROM keijiban";
            // SQLステートメントを実行し、結果を変数に格納
            $stmt = $pdo->query($sql);
            $results = $stmt->fetchAll();
            //配列の中身を一行ずつ出力
            foreach ($results as $row)
            {
                //$rowの中にはテーブルのカラム名が入る
                echo $row["id"].",";
                echo $row["name"].",";
                echo $row["comment"].",";
                echo $row["date"].",";
                echo $row["password"]."<br>";
            }
            echo "<hr>";
            */
        }
    
         //-----編集機能-----
    elseif(isset($_POST["name"]) && isset($_POST["comment"]) && isset($_POST["num"]))
    {
        $id = $_POST["editnum"];
        $name = $_POST["name"];
        $comment = $_POST["comment"]; 
        $date = date("Y/m/d H:i:s");
        $password=$_POST["password"];
        //UPDATE文で指定したidを更新
        $sql = 'UPDATE keijiban SET name=:name,comment=:comment,date=:date,password=:password WHERE id=:id';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
        $stmt->bindParam(':date', $date, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);
        //SQLの実行
        $stmt->execute();
        
        
        //SELECT文で全て表示
        // SELECT文を変数に格納
        $sql = "SELECT * FROM keijiban";
        // SQLステートメントを実行し、結果を変数に格納
        $stmt = $pdo->query($sql);
        $results = $stmt->fetchAll();
        //配列の中身を一行ずつ出力
        foreach ($results as $row)
        {
            //$rowの中にはテーブルのカラム名が入る
            echo $row["id"].",";
            echo $row["name"].",";
            echo $row["comment"].",";
            echo $row["date"].",";
            echo $row["password"]."<br>";

            echo "<hr>";
        }

    }

    
    //-----削除機能-----
    if(isset($_POST["delete"]))
    {
        if( isset($_POST["number"]) && isset($_POST["password1"]))
            {
                $id = $_POST["number"];
                $sql = 'delete from keijiban where id=:id';
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->execute();
            }
        elseif( isset($_POST["number"]) && !isset($_POST["password1"]))
            {
                    echo "パスワードが入力されていません。";
            }
    }
    //-----編集対象物をフォームに表示-----
    if(isset($_POST["edit"]))
    {
    if(isset($_POST["editnum"]) && isset($_POST["password2"]))
        {
            //編集番号を変数に入れる//
            $editnum = $_POST["editnum"];
            //パスワードを変数に入れる//
            $password2 = $_POST["password2"];
            $stmt=$pdo->prepare('SELECT * FROM keijiban');
            $stmt->execute();
                
                foreach($stmt as $loop)
                {
                    if($editnum==$loop['id'] && $password2==$loop['password'])
                    {
                        $editnumber=$loop['id'];
                        $editname=$loop['name'];
                        $editcomment=$loop['comment'];
                        $password3=$loop['password'];
                    }
                }
        }
    }
    if(isset($_POST["submit"]))
    {
     //入力データを表示
            // SELECT文を変数に格納
            $sql = "SELECT * FROM keijiban";
            // SQLステートメントを実行し、結果を変数に格納
            $stmt = $pdo->query($sql);
            $results = $stmt->fetchAll();
            //配列の中身を一行ずつ出力
            foreach ($results as $row)
            {
                //$rowの中にはテーブルのカラム名が入る
                echo $row["id"].",";
                echo $row["name"].",";
                echo $row["comment"].",";
                echo $row["date"].",";
                echo $row["password"]."<br>";
            }
            echo "<hr>";
    }
   
?>


<!入力フォーム!>
<!＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿!>
  <!actionでファイルの指定、methodで送信方法指定!>
  <form action="" method="post">
      
      <!nameで入力データが送られる、typeでtextを指定!>
      <input type="hidden" name="num"  value="<?php if(isset($editnumber)) {echo $editnumber;} ?>">
       <input type="text" name="name" placeholder="名前" value="<?php if(isset($editname)) {echo $editname;} ?>">
      <input type="text" name="comment"placeholder="コメント" value="<?php if(isset($editcomment)) {echo $editcomment;} ?>">
      <!パスワード!>
      <input type="text" name="password"placeholder="パスワード入力"value="<?php if(isset($password3)) {echo $password3;} ?>" >
      　　<!typeでsubmitを指定し、送信ボタン表示!>
     　　 <input type="submit"　name="submit">
     　　 <br>
<!＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿!>
<!削除機能フォーム!>
<!actionでファイルの指定、methodで送信方法指定!>
<form action="" method="post">
    
    <!nameで入力データが送られる、typeでnumberを指定!>
    <input type="number" name="number"placeholder="削除対象番号">
     <!パスワード!>
      <input type="text" name="password1"placeholder="パスワード確認" >

    
    <!typeでsubmitを指定し、削除ボタン表示!>
    <input type="submit" name="delete"value="削除">
    <br>
  <!＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿!>
  <!編集番号指定フォーム!>
<!actionでファイルの指定、methodで送信方法指定!>
<form action="" method="post">
    
    <!nameで入力データが送られる、typeでnumberを指定!>
    <input type="number" name="editnum"placeholder="編集番号指定">
     <!パスワード!>
      <input type="text" name="password2"placeholder="パスワード確認">
    
    <!typeでsubmitを指定し、削除ボタン表示!>
    <input type="submit" name="edit"value="編集">

  <!＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿!>

  </body>
