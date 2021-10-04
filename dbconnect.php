<?php
    $con = mysqli_connect( "localhost", "root", "", "ssp2" );
    //DB接続
    // mysqli_connect( "ホスト名", "DBユーザ名", "DBパスワード", "DB名")
    mysqli_set_charset( $con, "UTF8" );
    //文字コードを変更する
