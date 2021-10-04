<?php
//ファイルアップロード用関数
//使用例　$img=img_file_name();
function img_file_name(){//$fはフォーム投稿した時のinputタグ名。$dは保存するディレクトリ名
    $f="uploadfile";
    $d="upload/";
    $img="";//アップロードしたファイルのサーバ側でのファイル名が入る。

    //以下のif文は、アップロードのファイルが無い場合、空文字をreturnしている。
    if($_FILES[$f]['name']=="") return $img;

    //拡張子の決定
    $ext="";
    if($_FILES[$f]['type']=="image/gif") $ext="gif";
    else if($_FILES[$f]['type']=="image/pjpeg" || $_FILES[$f]['type']=="image/jpeg") $ext="jpg"; //image/pjpegはIE対策

    if($ext==""){
        exit("GIF/JPEG形式以外の画像ファイルは登録できません。");
    }else {
        $imgname=date("Ymd-His")."-".rand(1000,9999).".".$ext;//重複名にならないように現在時刻から命名
        if(move_uploaded_file($_FILES[$f]['tmp_name'], $d.$imgname)){
            $img=$imgname;
        }else{
            exit("画像ファイルのアップロードに失敗しました。");
        }
    }
    return $img;
}
function img_file_name2(){//$fはフォーム投稿した時のinputタグ名。$dは保存するディレクトリ名
    $f="uploadfile2";
    $d="upload/";
    $img="";//アップロードしたファイルのサーバ側でのファイル名が入る。

    //以下のif文は、アップロードのファイルが無い場合、空文字をreturnしている。
    if($_FILES[$f]['name']=="") return $img;

    //拡張子の決定
    $ext="";
    if($_FILES[$f]['type']=="image/gif") $ext="gif";
    else if($_FILES[$f]['type']=="image/pjpeg" || $_FILES[$f]['type']=="image/jpeg") $ext="jpg"; //image/pjpegはIE対策

    if($ext==""){
        exit("GIF/JPEG形式以外の画像ファイルは登録できません。");
    }else {
        $imgname=date("Ymd-His")."-".rand(1000,9999).".".$ext;//重複名にならないように現在時刻から命名
        if(move_uploaded_file($_FILES[$f]['tmp_name'], $d.$imgname)){
            $img=$imgname;
        }else{
            exit("画像ファイルのアップロードに失敗しました。");
        }
    }
    return $img;
}
?>
