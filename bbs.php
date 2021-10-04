<?php
    session_start();//セッション開始
    include( "img_file_name.php" );//画像ファイル名を変更する関数が入っている
    include( "dbconnect.php" );
    $m = "";
    $user = $_SESSION["username"];//SESSIONからログインしたユーザ名を取得

    if( isset( $_POST["sub"] ) ){
        $u_id = $_SESSION["userid"];//SESSIONからログインしたユーザIDを取得
        $msg = $_POST["msg"];
        $img = img_file_name();//img_file_name.php内にある関数を呼び出す

        $sql = "INSERT INTO bbs ( u_id, msg, date, img )
                VALUES ( '{$u_id}', '{$msg}', now(), '{$img}')";
                //投稿されたデータをbbsテーブルに挿入するSQL文を作成
        $rst = mysqli_query( $con, $sql );//SQL文を実行する   
    }
    //2つのテーブルを結合させてデータを抽出する
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
    <title>掲示板</title>
</head>
<body>
    <h1>掲示板</h1>

    <?php
        print "<p>投稿者：".$user."</p>";
    ?>
    <form method = "post" action = "" accept-charset="UTF-8" enctype="multipart/form-data">
        <p><textarea name="msg" cols="70" row="5"></textarea></p>
        画像(GIF/JPEG形式、100KB以下)：<input type="file" name="uploadfile" size="40">
        <input type="submit" name="sub" value="投稿">
    </form>

    <?php print $m; ?>
    
</body>
</html>