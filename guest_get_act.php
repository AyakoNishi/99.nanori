<?php
session_start();
include('functions.php');
check_session_id();

$pdo = connect_to_db();
// exit();
$user_id = (int)$_SESSION["user_id"];
$user_page = 1;
$guest_id = (int)$_SESSION["guest_id"];
$guest_page = (int)$_SESSION["guest_page"];

// var_dump('guest_get_act');
// var_dump($user_id);
// var_dump($guest_id);


// guest 登録SQL作成
$sql = 'INSERT INTO guest_table(user_id, user_page, guest_id, guest_page, created_ad) 
          VALUES(:user_id, :user_page, :guest_id, :guest_page, sysdate())';

// SQL準備&実行
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
$stmt->bindValue(':user_page', $user_page, PDO::PARAM_STR);
$stmt->bindValue(':guest_id', $guest_id, PDO::PARAM_STR);
$stmt->bindValue(':guest_page', $guest_page, PDO::PARAM_STR);
$status = $stmt->execute();
// var_dump('guest_get_act2');

// データ登録処理後
// if ($status == false) {
//   // SQL実行に失敗した場合はここでエラーを出力し，以降の処理を中止する
//   $error = $stmt->errorInfo();
//   echo json_encode(["error_msg" => "{$error[2]}"]);
//   exit();
// } else {
//   // var_dump('guest_get_act3');
//   header("Location:guest_page.php");
//   exit();
// }
if ($status == false) {
  // SQL実行に失敗した場合はここでエラーを出力し，以降の処理を中止する
  header("Location:guest_page.php");
  exit();
} else {
  // var_dump('guest_get_act3');
  header("Location:guest_page.php");
  exit();
}
