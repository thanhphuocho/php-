<?php
    include( "dbconnect.php" );
    include( "img_file_name.php" );
    $m = "";

    //ユーザ名変更開始
    if( isset( $_POST["mvsub"] ) ){
        $old = $_POST["oldname"];
        $new = $_POST["newname"];
        $pass = $_POST["pass"];

        //(1)旧ユーザ名がusersテーブルにあるの処理(2行) SELECT文
        $sql = "SELECT * FROM users WHERE name='{$old}'";
        $rst = mysqli_query( $con, $sql );
        //(2)旧ユーザ名を発見したらusersテーブル内の指定された新ユーザ名に変更する
        //if文の{}を含めて5行UPDATE文
        // if( $row = mysqli_fetch_assoc( $rst ) ){
        //     //usersテーブルのユーザ名を変更する
        //     $id = $row["id"];
        //     $sql = "UPDATE users SET name='{$new}' WHERE id='{$id}'";
        //     $rst = mysqli_query( $con, $sql );
        // }
        while( $row = mysqli_fetch_array( $rst ) ){
            if( $row["name"] === $old && password_verify( $pass, $row["pass"]) ){
                $id = $row["id"];
                $sql = "UPDATE users SET name='{$new}' WHERE id='{$id}'";
                $rst = mysqli_query( $con, $sql );
            }
        }
    }
    //ユーザ名変更終了

    //パスワード変更開始
    if( isset( $_POST["passsub"] ) ){
        $name = $_POST["name"];
        $old = password_hash( $_POST["oldpass"], PASSWORD_DEFAULT );
        $new = password_hash( $_POST["newpass"], PASSWORD_DEFAULT );
        $sql = "SELECT * FROM users WHERE name='{$name}'";
        $rst = mysqli_query( $con, $sql );

        while( $row = mysqli_fetch_array( $rst ) ){
            if( $row["name"] === $name && password_verify( $old, $row["pass"]) ){
                $id = $row["id"];
                $sql = "UPDATE users SET pass='{$new}' WHERE id='{$id}'";
                $rst = mysqli_query( $con, $sql );
            }
        }
    }
    //パスワード変更終了
    

    //ユーザの削除開始
    if( isset( $_POST["delsub"] ) ){
        $name = $_POST["delname"];
        $pass = $_POST["delpass"];

        //(1)削除するユーザをusersテーブルから探すためのSQL文を作成
        $sql = "SELECT * FROM users WHERE name='{$name}' AND pass='{$pass}'";
        $rst = mysqli_query( $con, $sql );//SQL文の実行
        //(2)指定したユーザが見つかったら削除する
        if( $row = mysqli_fetch_assoc( $rst ) ){
            $id = $row["id"];
            print $row["name"];

            //(3)削除したユーザの投稿データを削除する
            $sql = "DELETE FROM bbs WHERE u_id='{$id}'";
            $rst = mysqli_query( $con, $sql );

            //(4)見つかったユーザを削除するSQL文を作成
            $sql = "DELETE FROM users WHERE id='{$id}'";//idが一致するデータを削除
            $rst = mysqli_query( $con, $sql );

        }
    }
    //ユーザの削除終了


    //コメントの編集開始
    if( isset( $_POST["comsub"] ) ){
        $cid = $_POST["comid"];
        $msg = $_POST["msg"];

        //bbsテーブル内のmsgの内容を差し替えるためのSQL文を作成
        $sql = "UPDATE bbs SET msg='{$msg}' WHERE id='{$cid}'";
        $rst = mysqli_query( $con, $sql );
    }
    //コメント編集終了

    //画像差し替え開始
    if( isset( $_POST["imgsub"] ) ){
        $imgid = $_POST["imgid"];
        $img = img_file_name();

        $sql = "UPDATE bbs SET img='{$img}' WHERE id='{$imgid}'";
        $rst = mysqli_query( $con, $sql );
    }
    //画像差し替え終了
    
    //コメント削除開始
    if( isset( $_POST["rmsub"] ) ){
        $rmid = $_POST["rmid"];

        $sql = "DELETE FROM bbs WHERE id='{$rmid}'";
        $rst = mysqli_query( $con, $sql );
    }
    //コメント削除終了

    //掲示板データを表示
    $sql = "SELECT *,bbs.id as b_id, users.name as u_name
        FROM bbs LEFT JOIN users
        ON bbs.u_id = users.id ORDER BY bbs.id DESC";
    $rst = mysqli_query( $con, $sql );

    while( $row = mysqli_fetch_array( $rst ) ){
        $m .= "<p>".$row["b_id"]." ";
        $m .= $row["u_name"]." ";
        $m .= $row["date"]."</p>";
        $m .= "<p>".nl2br( $row["msg"] )."</p>";
        //nl2br()関数は改行文字(\r\n \n)の前に<br>を挿入して返す
        if( $row["img"] != NULL ){
            $m .= "<p><img src='upload/".$row['img']."' width='20%' height='20%'></p>";
        }
    }
    mysqli_free_result( $rst );
    mysqli_close( $con );

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>掲示板管理</title>
</head>
<body>
    <h1>掲示板管理画面</h1>

    <form method="post" action="" enctype="multipart/form-data">
        <h2>ユーザ名変更</h2>
        <p>旧ユーザ名：<input type="text" name="oldname"></p>
        <p>新ユーザ名：<input type="text" name="newname"></p>
        <p>パスワード：<input type="password" name="pass"></p>
        <p><input type="submit" name="mvsub" value="名前変更"></p>

        <h2>パスワード変更</h2>
        <p>ユーザ名：<input type="text" name="name"></p>
        <p>旧パスワード：<input type="password" name="oldpass"></p>
        <p>新パスワード：<input type="password" name="newpass"></p>
        <p><input type="submit" name="passsub" value="パスワード変更"></p>

        <h2>ユーザの削除</h2>
        <p>削除するユーザ名：<input type="text" name="delname"></p>
        <p>削除するユーザのパスワード：<input type="password" name="delpass"></p>
        <p><input type="submit" name="delsub" value="削除"></p>

        <h2>コメント編集</h2>
        <p>編集したいコメントID：<input type="text" name="comid"></p>
        <textarea name="msg" clos="100" rows="5"></textarea>
        <p><input type="submit" name="comsub" value="編集"></p>

        <h2>画像変更</h2>
        <p>編集したいコメントID：<input type="text" name="imgid"></p>
        <p>画像(GIF/JPEG形式、100KB以下)：<input type="file" name="uploadfile" size="40"></p>
        <p><input type="submit" name="imgsub" value="変更">

        <h2>コメントの削除</h2>
        <p>削除コメントID：<input type="text" name="rmid"></p>
        <input type="submit" name="rmsub" value="コメント削除">
    </form>

    <?php print $m; ?>
    
</body>
</html>