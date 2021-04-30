<?php
session_start();
include("functions.php");
check_session_id();

// DB接続情報
$pdo = connect_to_db();

// $is_admin = check_session_id($pdo);
// var_dump($pdo);
// var_dump(check_session_id($pdo));
// var_dump($_SESSION);
// exit();

// ユーザーチェック
$is_admin = $_SESSION["is_admin"];
$user_id = (int)$_SESSION["user_id"];

// if ($is_admin != 1) {
//   echo "<p>管理者以外の閲覧は出来ません。</p>";
//   // header('Location: login.php'); // ログイン画面へ移動
// };

$page = 1;
$_SESSION["user_page"] = $page;

$name = $_POST["name"];
$name_yomi = $_POST["name_yomi"];
$circle = $_POST["circle"];
$circle_yomi = $_POST["circle_yomi"];
$genre = $_POST["genre"];
$genre_yomi = $_POST["genre_yomi"];
$main_chara = $_POST["main_chara"];
$couple = $_POST["couple"];
$NG_type = $_POST["NG_type"];
$hosoku = $_POST["hosoku"];
$twitter_id = $_POST["twitter_id"];
$web_url = $_POST["web_url"];
$Pixiv_id = $_POST["Pixiv_id"];
$FanBox = $_POST["FanBox"];
$next_eve = $_POST["next_eve"];

//SQL mypage-table input
$sql =
  'INSERT INTO mypage_table(user_id, page, name, name_yomi, circle, circle_yomi, 
  genre, genre_yomi, main_chara, couple, NG_type, hosoku, twitter_id, web_url, Pixiv_id, FanBox, next_eve, image, created_ad, updated_ad) 
VALUES(:user_id, :page, :name, :name_yomi, :circle, :circle_yomi, 
  :genre, :genre_yomi, :main_chara, :couple, :NG_type, :hosoku, :twitter_id, :web_url, 
  :Pixiv_id, :FanBox, :next_eve, "", sysdate(), sysdate())';

// SQL準備&実行
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
$stmt->bindValue(':page', $page, PDO::PARAM_STR);
$stmt->bindValue(':name', $name, PDO::PARAM_STR);
$stmt->bindValue(':name_yomi', $name_yomi, PDO::PARAM_STR);
$stmt->bindValue(':circle', $circle, PDO::PARAM_STR);
$stmt->bindValue(':circle_yomi', $circle_yomi, PDO::PARAM_STR);
$stmt->bindValue(':genre', $genre, PDO::PARAM_STR);
$stmt->bindValue(':genre_yomi', $genre_yomi, PDO::PARAM_STR);
$stmt->bindValue(':main_chara', $main_chara, PDO::PARAM_STR);
$stmt->bindValue(':couple', $couple, PDO::PARAM_STR);
$stmt->bindValue(':NG_type', $NG_type, PDO::PARAM_STR);
$stmt->bindValue(':hosoku', $hosoku, PDO::PARAM_STR);
$stmt->bindValue(':twitter_id', $twitter_id, PDO::PARAM_STR);
$stmt->bindValue(':web_url', $web_url, PDO::PARAM_STR);
$stmt->bindValue(':Pixiv_id', $Pixiv_id, PDO::PARAM_STR);
$stmt->bindValue(':FanBox', $FanBox, PDO::PARAM_STR);
$stmt->bindValue(':next_eve', $next_eve, PDO::PARAM_STR);
// $stmt->bindValue(':image', $image, PDO::PARAM_STR);
$status = $stmt->execute();

// データ登録処理後
if ($status == false) {
  // SQL実行に失敗した場合はここでエラーを出力し，以降の処理を中止する
  $error = $stmt->errorInfo();
  echo json_encode(["error_msg" => "{$error[2]}"]);
  exit();
}
header("Location:my_page.php");
exit();
