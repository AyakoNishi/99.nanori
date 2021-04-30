<?php

// var_dump($_POST);
// exit();
var_dump("new_account_act in");
// 関数ファイル読み込み
include('functions.php');

// データ受け取り
$user_nm = $_POST["user_nm"];
$password = $_POST["password"];
var_dump($user_nm);
var_dump($password);
exit();

// DB接続関数
$pdo = connect_to_db();

// ユーザ存在有無確認
$sql = 'SELECT COUNT(*) FROM users_table WHERE user_nm=:user_nm';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_nm', $user_nm, PDO::PARAM_STR);
$status = $stmt->execute();

if ($status == false) {
  // SQL実行に失敗した場合はここでエラーを出力し，以降の処理を中止する
  $error = $stmt->errorInfo();
  echo json_encode(["error_msg" => "{$error[2]}"]);
  exit();
}

var_dump("new_account_act");
// exit();

if ($stmt->fetchColumn() > 0) {
  // user_nmが1件以上該当した場合はエラーを表示して元のページに戻る
  // $count = $stmt->fetchColumn();
  echo "<p>すでに登録されているユーザです．</p>";
  echo '<a href="login.php">login</a>';
  exit();
}
// ユーザ登録SQL作成
// `created_ad`と`updated_at`には実行時の`sysdate()`関数を用いて実行時の日時を入力する
$sql = 'INSERT INTO users_table(user_id, user_nm, password, is_admin, created_ad, updated_ad) VALUES(NULL, :user_nm, :password, 0, sysdate(), sysdate())';

// SQL準備&実行
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_nm', $user_nm, PDO::PARAM_STR);
$stmt->bindValue(':password', $password, PDO::PARAM_STR);
$status = $stmt->execute();

// データ登録処理後
if ($status == false) {
  // SQL実行に失敗した場合はここでエラーを出力し，以降の処理を中止する
  $error = $stmt->errorInfo();
  echo json_encode(["error_msg" => "{$error[2]}"]);
  exit();
} else {
  // 正常にSQLが実行された場合は入力ページファイルに移動し，入力ページの処理を実行する
  header("Location:my_page_edit.php");
  exit();
}
