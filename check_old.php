<?php
    session_start();
    include( "dbconnect.php" );//dbconnect.php内に記述されているプログラムが差し込まれる

    if( !isset( $_SESSION["join"] ) ){//SESSION内のデータがない場合は再入力させる処理
        header("Location: newuser.php" );
    }
    if( isset( $_POST["sub"] ) ){
        //登録処理を行う
        //SQL文を作成する
        $sql = sprintf( 'INSERT INTO users SET name="%s", pass="%s"',
            mysqli_real_escape_string($con, $_SESSION["join"]["name"]),
            mysqli_real_escape_string($con, password_hash( $_SESSION["join"]["pass"], PASSWORD_DEFAULT )));
            //$sql = "INSERT INTO users SET name=$_SESSION["join"]["name"], pass=$_SESSION["join"]["pass"];
        //sprintf()関数は、文字列フォーマットに対し、変数データを差し込み、新たな文字列を作成することが出来る。
        // sprintf("文字列フォーマット", 変数群・・・);
        // 差し込みたい場所に %d ←整数値、%s ← 文字列などを指定する。

        mysqli_query( $con, $sql ); //SQL文を実行する（データベースに登録する）
        unset( $_SESSION["join"] ); //SESSIONを削除
        mysqli_close( $con );//DBを切断する

        header( "Location: thanks.php" );//お礼ページに移動
        exit();
    }

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新規登録内容確認</title>
</head>
<body>
    <h1>新規登録内容確認</h1>

    <form method="post" action="">
        <dl>
            <dt>ユーザ名</dt>
            <dd>
                <?php
                    echo htmlspecialchars( $_SESSION["join"]["name"], ENT_QUOTES, "UTF-8" );
                ?>
            </dd>
            <dt>パスワード</dt>
            <dd>
                [表示させません]
            </dd>
        </dl>
        <p><a href="newuser.php?action=rewrite">変更</a></p>
        <input type="submit" name="sub" value="登録">
    </form>
    
</body>
</html>