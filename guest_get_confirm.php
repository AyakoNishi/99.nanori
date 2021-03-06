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
$user_id = (int)$_SESSION["user_id"];
// $user_page = (int)$_SESSION["user_page"];
$user_page = 1;
// $guest_id = (int)$_GET["guest_id"];
// $guest_page = 1;

if (isset($_GET['key'])) {
  $guest_id = (int)$_GET['key'];
}
if (isset($_GET['page'])) {
  $guest_page = (int)$_GET['page'];
}
$_SESSION["guest_id"] = $guest_id;
$_SESSION["guest_page"] = $guest_page;

$_SESSION["error_msg"] = "";

//SQL guest page get confirm select
$sql = 'SELECT user_id FROM users_table WHERE user_id = :guest_id';

// SQL準備&実行
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':guest_id', $guest_id, PDO::PARAM_STR);
$status = $stmt->execute();
// var_dump('guest_get_confirm2');

if ($status == false) {
  $error = $stmt->errorInfo();
  echo json_encode(["error_msg" => "{$error[2]}"]);
  exit();
}
// var_dump('guest_get_confirm3');

$val = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$val) {
  // echo "<p>ユーザー情報がありません</p>";
  // echo '<a href = "guest_get.php">ユーザー情報がありません</a>';
  // exit();
  $error_msg = '<p>Error:取得するユーザー情報がありません </p>';
  $_SESSION["error_msg"] = $error_msg;
  header("Location:guest_get.php");
  exit();
} else {
  // var_dump('guest_get_confirm4');
  // $_SESSION["guest_id"] = $guest_id;
  // $_SESSION["guest_page"] = $guest_page;

  //SQL guest page get confirmm
  $sql = 'SELECT * FROM mypage_table 
          WHERE ( user_id = :guest_id AND page = :guest_page )';

  // SQL準備&実行
  $stmt = $pdo->prepare($sql);
  $stmt->bindValue(':guest_id', $guest_id, PDO::PARAM_STR);
  $stmt->bindValue(':guest_page', $guest_page, PDO::PARAM_STR);
  $status = $stmt->execute();
  // var_dump('guest_get_confirm5');

  if ($status == false) {
    $error = $stmt->errorInfo();
    echo json_encode(["error_msg" => "{$error[2]}"]);
    exit();
  }

  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  if (!$result) {
    $guest_name = "";
    $guestpage_image = ""; // imgタグを設定
    $guest_image = '<img class="guest_card_1" src="image/2473170.jpg" alt="guest_card_1" width="300px"><br>';
  } else {
    // var_dump('guest_get_confirm6');
    $guest_image = "";
    foreach ($result as $record) {
      $guest_name = "{$record["name"]}";
      $guestpage_image = "{$record["image"]}"; // imgタグを設定
      // var_dump($guestpage_image);
      $guest_image = '<img class="guest_card_1" src="' . $guestpage_image . '" alt="guest_card_1" width="300px"><br>';
    }
    unset($record);
  }
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="同人専用、オンライン名刺">
  <link href="https://fonts.googleapis.com/css?family=M+PLUS+1p" rel="stylesheet" />
  <link rel="stylesheet" type="text/css" href="css/reset.css" />
  <link rel="stylesheet" type="text/css" href="css/sanitize.css" />
  <link rel="stylesheet" type="text/css" href="css/style.css" />
  <link rel="icon" type="image/png" href="image/nanori_fabi.png">
  <script src="https://kit.fontawesome.com/b37302edff.js" crossorigin="anonymous"></script>
  <title>名乗り β</title>
</head>

<body>
  <div id="home" class="my_Page">
    <!-- <header>ヘッダー</header> -->
    <header class="page-header wrapper">
      <a href="index.html"><img src="image/nanori_logo.png" alt="名乗りロゴ"></a>
      <nav>
        <ul class="navi">
          <li class="nav_box"><a href="my_page.php">マイページ</a></li>
          <li class="nav_box"><a href="my_page_edit.php">名刺を編集する</a></li>
          <li class="nav_box"><a href="qr_index.php">QRコードを表示する</a></li>
          <!-- <li class="nav_box"><a href="guest_get.php">名刺を取得する</a></li> -->
          <li class="nav_box"><a href="guest_page.php">取得名刺一覧</a></li>
          <li class="nav_box"><a href="logout.php">LOGOUT</a></li>
        </ul>
      </nav>
    </header>

    <main>
      <form action="guest_get_act.php" method="POST">
        <div class="guest_get_confirm">
          <div class="guest_confirm">
            <?= $guest_image ?>
            <?= $guest_name ?><br>
            <!-- <img src="image/1529717.jpg" style="width: 300px;"> <br> -->
            <button class="guest_button"><input type="submit" name="guest_get" value="こちらを取得しますか？" /></button>
            <!-- <button class="guest_button"><a href="guest_get.php">キャンセル</a></button> -->
            <button class="guest_button"><a href="guest_page.php">キャンセル</a></button>
          </div>
        </div>
      </form>

    </main>
  </div><!-- /#home-->

  <!-- <footer>フッター</footer> -->
  <footer>
    <p>copyrights 2021 Na-nori All RIghts Reserved.</p>
  </footer>
</body>

</html>