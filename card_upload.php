<?php
session_start();
include("functions.php");
// check_session_id();

// DB接続情報
$pdo = connect_to_db();

// var_dump($_FILES);
// exit();

$user_id = (int)$_SESSION["user_id"];
// $page = (int)$_SESSION["page"];
$page = 1;

// コード
if (!isset($_FILES['upfile']) && $_FILES['upfile']['error'] != 0) {
  // 送られていない，エラーが発生，などの場合
  exit('Error:画像が送信されていません');
} else {
  $uploaded_file_name = $_FILES['upfile']['name'];  //ファイル名の取得
  $temp_path = $_FILES['upfile']['tmp_name']; //tmpフォルダの場所
  // $directory_path = 'upload/'; //アップロード先フォルダ
  $directory_path = 'mycard/'; //アップロード先フォルダ
  // var_dump($uploaded_file_name);
  // var_dump($temp_path);
  // var_dump($directory_path);
  // exit();

  $extension = pathinfo($uploaded_file_name, PATHINFO_EXTENSION);
  // $unique_name = date('YmdHis') . md5(session_id()) . "." . $extension;
  $unique_name = $user_id . $page . $uploaded_file_name . "." . $extension;
  $filename_to_save = $directory_path . $unique_name;
  // var_dump($filename_to_save);
  // exit();

  $img = '';
  if (!is_uploaded_file($temp_path)) {
    exit('Error:画像がありません'); // tmpフォルダにデータがない
  } else { // ↓ここでtmpファイルを移動する
    if (!move_uploaded_file($temp_path, $filename_to_save)) {
      exit('Error:アップロードできませんでした'); // 画像の保存に失敗
    } else {
      chmod($filename_to_save, 0644); // 権限の変更
      $img = '<img src="' . $filename_to_save . '" >'; // imgタグを設定
    }
  }

  // upload したファイルを、mypage_table に入れる
  $sql =
    'UPDATE mypage_table set image = :filename_to_save
    WHERE  (user_id = :user_id  and  page = :page)';

  // SQL準備&実行
  $stmt = $pdo->prepare($sql);
  $stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
  $stmt->bindValue(':page', $page, PDO::PARAM_STR);
  $stmt->bindValue(':image', $filename_to_save, PDO::PARAM_STR);
  $status = $stmt->execute();

  // データ登録処理後
  if ($status == false) {
    // SQL実行に失敗した場合はここでエラーを出力し，以降の処理を中止する
    $error = $stmt->errorInfo();
    echo json_encode(["error_msg" => "{$error[2]}"]);
    exit();
  }
  // header("Location:my_page_.php");
  // exit();


}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>file_upload</title>
</head>

<body>
  <?= $img ?>
</body>

</html>