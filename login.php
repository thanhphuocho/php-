<?php
  session_start();
  include( "dbconnect.php" );

  if( isset( $_POST["sub"] ) ){
      if( $_POST["name"] != "" && $_POST["pass"] != "" ){
          if( $_POST["name"] == "root" && $_POST["pass"] == "root" ){
              $_SESSION["username"] = $_POST["name"];
              header('Location: kanri.php' );
              exit();
          }
          else {
            $name = $_POST["name"];
            $pass = $_POST["pass"];
            //$sql = "SELECT * FROM users WHERE name = '{$name}' AND pass = '{$pass}'"; //SQL文の作成
            $sql = "SELECT * FROM users WHERE name = '{$name}'";
            $rst = mysqli_query( $con, $sql ); //SQL文の実行

            while( $row = mysqli_fetch_array( $rst ) ){
                if( $row["name"] === $name && password_verify($pass, $row["pass"]) ){
                    $_SESSION['userid'] = $row["id"];
                    $_SESSION['username'] = $row["name"];
                    
                    header( 'Location: bbs.php' );
                    exit();
                }
            }
            // if( $row = mysqli_fetch_assoc( $rst ) ){// 連想配列の取得
            //     $_SESSION['userid'] = $row["id"];
            //     $_SESSION['username'] = $row["name"];

            //     header( 'Location: bbs.php' ); //指定したファイルへ移動
            //     exit();
            // }
            mysqli_free_result( $rst ); //メモリの解放する処理
            mysqli_close( $con ); //DBを閉じる処理
          }
      }
  }
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
    <h1>ログイン</h1>

    <form method="post" action="">
        <p>ユーザ名：<input type="text" name="name" value=""></p>
        <p>パスワード：<input type="password" name="pass"></p>
        <input type="submit" name="sub" value="ログイン">
    </form>

    <p>新規登録の方は、こちらからどうぞ。</p>
    <p><a href="newuser.php">入会手続き</a></p>
    
</body>
</html>