<?php
    session_start();//セッション開始
    $error["name"] = "";
    $error["pass"] = "";

    if( !empty( $_POST ) ){//empty関数→（）内に指定された変数内が空かを確認
        //入力エラーの確認
        if( $_POST["name"] == "" )
            $error["name"] = "blank";
        if( $_POST["pass"] == "" )
            $error["pass"] = "blank";
        if( strlen( $_POST["pass"] ) < 6 ) //strlen()は配列内の文字数を返す
            $error["pass"] = "length";
        
        $judge = array_filter( $error );//$error配列を確認する。
        if( empty( $judge ) ){ // エラーが無かったら{}内の処理を行う
            $_SESSION["join"] = $_POST; //$_POST全体をSESSIONに代入する
            // $_SESSION["join"]["name"] ← 入力したユーザ名を確認することが出来る
            // $_SESSION["join"]["pass"] ← 入力したパスワードを確認することが出来る
            header( "Location: check.php" );//check.phpファイルへ移動
            exit();
        }
    }
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新規会員登録</title>
</head>
<body>
    <h1>新規会員登録</h1>

    <p>必要事項を入力してください。</p>

    <form method="post" action="">
        <dl>
            <dt>ユーザ名</dt>
            <dd>
                <input type="text" name="name">
                <?php
                    if( $error["name"] == "blank" ):
                ?>
                    <p>ユーザ名を入力してください。</p>
                <?php endif; ?>
            </dd>
            <dt>パスワード</dt>
            <dd>
                <input type="password" name="pass">
                <?php
                    if( $error["pass"] == "blank" ):
                ?>
                    <p>パスワードを入力してください。</p>
                <?php endif; ?>
                <?php
                    if( $error["pass"] == "length" ):
                ?>
                    <p>パスワードは6文字以上で入力してください。</p>
                <?php endif; ?>
            </dd>
        </dl>
        <input type="submit" name="sub" value="入力確認">
    </form>
</body>
</html>