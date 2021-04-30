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
$guest_id = (int)$_SESSION["guest_id"];

// if ($is_admin != 1) {
//   echo "<p>管理者以外の閲覧は出来ません。</p>";
//   // header('Location: login.php'); // ログイン画面へ移動
// };

//SQL Fact-table
$sql = 'SELECT b.* FROM guest_table a, mypage_table b
        WHERE ( a.user_id = :user_id ) and ( a.guest_id = b.user_id ) 
        ORDER BY a.created_ad DESC';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
$status = $stmt->execute(); // SQLを実行

if ($status == false) {
  $error = $stmt->errorInfo();
  echo json_encode(["error_msg" => "{$error[2]}"]);
  exit();
} else {

  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $guest_page_image = "";
  $guest_page_list = "";
  foreach ($result as $record) {
    $guest_page_list .= "<tr>";
    $guest_page_list .= '<td><img src="image/3243048_m.jpg" alt="image" style="width : 200px"></td>';
    $guest_page_list .= "</tr>";
    $guest_page_list .= "<tr>";
    $guest_page_list .= "<th>名前</th>";
    $guest_page_list .= "<td>{$record["name"]}</td>";
    $guest_page_list .= "</tr>";
    $guest_page_list .= "<tr>";
    $guest_page_list .= "<th>サークル名</th>";
    $guest_page_list .= "<td>{$record["circle"]}</td>";
    $guest_page_list .= "</tr>";

    // var_dump($guest_page_list);
    // exit();
  }
  unset($record);
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
          <li class="nav_box"><a href="guest_get.php">名刺を取得する</a></li>
          <li class="nav_box"><a href="guest_page.php">取得名刺一覧</a></li>
          <li class="nav_box"><a href="logout.php">LOGOUT</a></li>
        </ul>
      </nav>
    </header>

    <main>
      <div class="guest_contents wrapper">
        <div class="guest_page_box  wrapper">
          <table>
            <thead>
              <tr>
                <h2>取得した名刺一覧</h2>
              </tr>
            </thead>
            <tbody>
              <div class="guest_image">
                <?= $guest_page_list ?>
              </div>
            </tbody>
          </table>
        </div>
    </main>
  </div><!-- /#home-->

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script>
    $(function() {
      $('input[type=radio]').change(function() {
        $('#tr1,#tr2,#tr3').removeClass('invisible');

        if ($("input:radio[name='use']:checked").val() == "1") {
          $('#tr2,#tr3').addClass('invisible');
        } else if ($("input:radio[name='use']:checked").val() == "2") {
          $('#tr1,#tr3').addClass('invisible');
        } else if ($("input:radio[name='use']:checked").val() == "3") {
          $('#tr1,#tr2').addClass('invisible');
        }
      }).trigger('change'); //←(1)
    });
  </script>

  <!-- <footer>フッター</footer> -->
  <footer>
    <p>copyrights 2021 Na-nori All RIghts Reserved.</p>
  </footer>
</body>

</html>