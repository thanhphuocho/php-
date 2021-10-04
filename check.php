<?php
    session_start();
    include("dbconnect.php");

    if( !isset( $_SESSION['join']) ){ // SESSION内にデータがない場合は再入力させる処理
        header( 'Location: newuser.php' );
        exit();
    }
    if( isset( $_POST['sub'] ) ){
        //会員登録処理を行う
        $sql = sprintf('INSERT INTO users SET name="%s", pass="%s"',
            mysqli_real_escape_string( $con, $_SESSION['join']['name']),
            mysqli_real_escape_string( $con, password_hash( $_SESSION['join']['pass'], PASSWORD_DEFAULT))
        ); //SQL文を作成
        mysqli_query( $con, $sql ); //SQL文を実行
        unset( $_SESSION['join'] ); //SESSIONを削除

        header( 'Location: thanks.php' ); //お礼ページに移動
        exit();
    }
    mysqli_close( $con );
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>登録内容確認</title>
</head>
<body>
    <h1>新規登録内容確認</h1>

    <form method="post" action="">
        <dl>
            <dt>ユーザー名</dt>
            <dd>
                <?php 
                    echo htmlspecialchars( $_SESSION['join']['name'], ENT_QUOTES, 'UTF-8');
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