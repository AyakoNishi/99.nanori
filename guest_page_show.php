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
$mypage_image = "";

if (isset($_GET['key'])) {
  $guest_id = (int)$_GET['key'];
}


// if ($is_admin != 1) {
//   echo "<p>管理者以外の閲覧は出来ません。</p>";
//   // header('Location: login.php'); // ログイン画面へ移動
// };

//SQL Fact-table
$sql = 'SELECT * FROM mypage_table
        WHERE (user_id = :guest_id) 
        ORDER BY page';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':guest_id', $guest_id, PDO::PARAM_STR);
$status = $stmt->execute(); // SQLを実行

if ($status == false) {
  $error = $stmt->errorInfo();
  echo json_encode(["error_msg" => "{$error[2]}"]);
  exit();
} else {

  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  if (!$result) {
    $output = "";
    $output .= "<tr>";
    $output .= "<th>Name（※必須）</th>";
    $output .= "<td></td>";
    $output .= "</tr>";
    $output .= "<tr>";
    $output .= "<th>よみがな</th>";
    $output .= "<td></td>";
    $output .= "</tr>";
    $output .= "<tr>";
    $output .= "<th>サークル名</th>";
    $output .= "<td></td>";
    $output .= "</tr>";
    $output .= "<tr>";
    $output .= "<th>サークル名よみがな</th>";
    $output .= "<td></td>";
    $output .= "</tr>";
    $output .= "<tr>";
    $output .= "<th>作品名（ジャンル）</th>";
    $output .= "<td></td>";
    $output .= "</tr>";
    $output .= "<tr>";
    $output .= "<th>作品名（ジャンル）よみがな</th>";
    $output .= "<td></td>";
    $output .= "</tr>";
    $output .= "<tr>";
    $output .= "<th>中心キャラ ※1</th>";
    $output .= "<td></td>";
    $output .= "</tr>";
    $output .= "<tr>";
    $output .= "<th>補カップリング ※2</th>";
    $output .= "<td></td>";
    $output .= "</tr>";
    $output .= "<tr>";
    $output .= "<th>地雷</th>";
    $output .= "<td></td>";
    $output .= "</tr>";
    $output .= "<tr>";
    $output .= "<th>補足説明</th>";
    $output .= "<td></td>";
    $output .= "</tr>";
    $output .= "<tr>";
    $output .= "<th>Twitter ID</th>";
    $output .= "<td></td>";
    $output .= "</tr>";
    $output .= "<tr>";
    $output .= "<th>WEB URL（店舗など）</th>";
    $output .= "<td></td>";
    $output .= "</tr>";
    $output .= "<tr>";
    $output .= "<th>Pixiv ID</th>";
    $output .= "<td></td>";
    $output .= "</tr>";
    $output .= "<tr>";
    $output .= "<th>FanBox</th>";
    $output .= "<td></td>";
    $output .= "</tr>";
    $output .= "<tr>";
    $output .= "<th>次の参加予定 ※3</th>";
    $output .= "<td></td>";
    $output .= "</tr>";
    $output .= "<tr>";
    $output .= "<th>次の参加予定(URL)</th>";
    $output .= "<td></td>";
    $output .= "</tr>";

    $mypage_image .= '<img class="my_card_1" src="image/2473170.jpg" alt="my_card_1" width="300px"><br>';
  } else {

    $output = "";
    $mypage_image = "";
    foreach ($result as $record) {
      $output .= "<tr>";
      $output .= "<th>Name（※必須）</th>";
      $output .= "<td>{$record["name"]}</td>";
      $output .= "</tr>";
      $output .= "<tr>";
      $output .= "<th>よみがな</th>";
      $output .= "<td>{$record["name_yomi"]}</td>";
      $output .= "</tr>";
      $output .= "<tr>";
      $output .= "<th>サークル名</th>";
      $output .= "<td>{$record["circle"]}</td>";
      $output .= "</tr>";
      $output .= "<tr>";
      $output .= "<th>サークル名よみがな</th>";
      $output .= "<td>{$record["circle_yomi"]}</td>";
      $output .= "</tr>";
      $output .= "<tr>";
      $output .= "<th>作品名（ジャンル）</th>";
      $output .= "<td>{$record["genre"]}</td>";
      $output .= "</tr>";
      $output .= "<tr>";
      $output .= "<th>作品名（ジャンル）よみがな</th>";
      $output .= "<td>{$record["genre_yomi"]}</td>";
      $output .= "</tr>";
      $output .= "<tr>";
      $output .= "<th>中心キャラ ※1</th>";
      $output .= "<td>{$record["main_chara"]}</td>";
      $output .= "</tr>";
      $output .= "<tr>";
      $output .= "<th>補カップリング ※2</th>";
      $output .= "<td>{$record["couple"]}</td>";
      $output .= "</tr>";
      $output .= "<tr>";
      $output .= "<th>地雷</th>";
      $output .= "<td>{$record["NG_type"]}</td>";
      $output .= "</tr>";
      $output .= "<tr>";
      $output .= "<th>補足説明</th>";
      $output .= "<td>{$record["hosoku"]}</td>";
      $output .= "</tr>";
      $output .= "<tr>";
      $output .= "<th>Twitter ID</th>";
      $output .= "<td>{$record["twitter_id"]}</td>";
      $output .= "</tr>";
      $output .= "<tr>";
      $output .= "<th>WEB URL（店舗など）</th>";
      $output .= "<td>{$record["web_url"]}</td>";
      $output .= "</tr>";
      $output .= "<tr>";
      $output .= "<th>Pixiv ID</th>";
      $output .= "<td>{$record["Pixiv_id"]}</td>";
      $output .= "</tr>";
      $output .= "<tr>";
      $output .= "<th>FanBox</th>";
      $output .= "<td>{$record["FanBox"]}</td>";
      $output .= "</tr>";
      $output .= "<tr>";
      $output .= "<th>次の参加予定 ※3</th>";
      $output .= "<td>{$record["next_eve"]}</td>";
      $output .= "</tr>";
      $output .= "<tr>";
      $output .= "<th>次の参加予定(URL)</th>";
      $output .= "<td>{$record["next_eve_url"]}</td>";
      $output .= "</tr>";

      $mypage_image .= "{$record["image"]}"; // imgタグを設定
      $card_image_show = '<img class="my_card_1" src="' . $mypage_image . '" alt="my_card_1" width="300px"><br>';
    }
    unset($record);
  }

  if ($card_image_show == "") {
    $card_image_show = '<img class="my_card_1" src="image/2473170.jpg" alt="my_card_1" width="300px"><br>';
    // } else {
    //   if (!$card_image_path) {
    //     $card_image_show = '<img class="my_card_1" src="' . $mypage_image . '" alt="my_card_1" width="300px"><br>';
    //   } else {
    //     $card_image_show = '<img class="my_card_1" src="' . $card_image_path . '" alt="my_card_1" width="300px"><br>'; // imgタグを設定
    //   }
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
      <div class="my_page_contents wrapper">
        <!-- 左側   名刺表示部分-->
        <div class="myCard_left">
          <!-- <p>左側</p> -->
          <div class="card_show" alt="my_card_1" width="300px">
            <!-- <img class="my_card_1" src="image/2473170.jpg" alt="my_card_1" width="300px"><br> -->
            <?= $card_image_show ?>
            <br>
          </div>
          <!-- <a href="https://twitter.com"><i class="fab fa-twitter"></i></a> -->
          <button class="guest_button"><a href="guest_page.php">取得名刺一覧に戻る</a></button>
        </div>
        <!-- 右側  リスト -->
        <div class="myCard_right">
          <!-- <p>右側</p> -->
          <div class="guest_page_table wrapper">
            <table>
              <?= $output ?>
            </table>
          </div>
        </div>
    </main>
  </div><!-- /#home-->


  <!-- <footer>フッター</footer> -->
  <footer>
    <p>copyrights 2021 Na-nori All RIghts Reserved.</p>
  </footer>
</body>

</html>