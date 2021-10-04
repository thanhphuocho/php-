<?php
    session_start();
    include( "dbconnect.php" );

    if( isset( $_POST["sub"] ) ){
        if( $_POST["name"] != "" && $_POST["pass"] != "" ){
            if( $_POST["name"] == "root" && $_POST["pass"] == "root" ){
                $_SESSION["username"] = $_POST["name"];
                header( "Location: kanri.php" );
                exit();
            }
            else {
                $name = $_POST["name"];
                $pass = $_POST["pass"];

                $sql = "SELECT * FROM users WHERE name = '{$name}'";
                //SQL文を作成 ユーザ名とパスワードが一致するデータをusersテーブルから抽出
                $rst = mysqli_query( $con, $sql );//SQL文を実行 実行結果が変数$rstに代入される

                while( $row = mysqli_fetch_array( $rst ) ){
                    if( $row["name"] === $name &&password_verify( $pass, $row["pass"]) ){
                        $_SESSION["userid"] = $row["id"];
                        $_SESSION["username"] = $row["name"];

                        mysqli_free_result( $rst );
                        mysqli_close( $con );
                        header( "Location: bbs.php" );
                        exit();
                    }
                }
                // if( $row = mysqli_fetch_assoc( $rst ) ){//連想配列にする
                //     $_SESSION["userid"] = $row["id"];//SELECT文で抽出したデータをSESSIONに代入
                //     $_SESSION["username"] = $row["name"];

                //     mysqli_free_result( $rst );//メモリの解放処理
                //     mysqli_close( $con );//DBを閉じる処理

                //     header( "Location: bbs.php" );//指定したファイルへ移動
                //     exit();
                // }
            } 
        }
    }
    mysqli_close( $con );
?> 

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン</title>
</head>
<body>
    <h1>ログイン画面</h1>

    <form method="post" action="">
        <p>ユーザ名：<input type="text" name="name" value=""></p>
        <p>パスワード：<input type="password" name="pass"></p>
        <input type="submit" name="sub" value="ログイン">
    </form>

    <p>新規登録の方は、こちらからどうぞ。</p>
    <p><a href="newuser.php">入会手続き</a></p>
    
</body>
</html>