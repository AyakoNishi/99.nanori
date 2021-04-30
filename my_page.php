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

//SQL Fact-table
$sql = 'SELECT * FROM mypage_table
        WHERE (user_id = :user_id) 
        ORDER BY page';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
$status = $stmt->execute(); // SQLを実行

if ($status == false) {
  $error = $stmt->errorInfo();
  echo json_encode(["error_msg" => "{$error[2]}"]);
  exit();
} else {

  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $output = "";
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

    $image = '<img src="{$record["image"]}" >'; // imgタグを設定
    // var_dump($image);
    // exit();

    // var_dump($output);
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
      <div class="my_page_contents wrapper">
        <!-- 左側   名刺表示部分-->
        <div class="myCard_left">
          <!-- <p>左側</p> -->
          <div class="card_show" alt="my_card_1" width="300px">
            <img class="my_card_1" src="image/2473170.jpg" alt="my_card_1" width="300px"><br>
            <!-- <?= $image ?> -->
            <br>
          </div>
          <form action="card_update.php" method="POST" enctype="multipart/form-data">
            <input type="file" name="upfile" accept="image/*" capture="camera">
          </form>
          <!-- <p>名刺の画像をupする</p> -->
          <a href="https://twitter.com"><i class="fab fa-twitter"></i></a>
        </div>
        <!-- 右側  リスト -->
        <div class="myCard_right">
          <!-- <p>右側</p> -->
          <!-- <table class="test">
            <tr>
              <th>ラジオ</th>
              <td>
                <input type="radio" name="use" value="1" id="radio1" checked /><label for="radio1">名刺１</label>
                <input type="radio" name="use" value="2" id="radio2" /><label for="radio2">名刺２</label>
                <input type="radio" name="use" value="3" id="radio3" /><label for="radio3">名刺３</label>
              </td>
            </tr>
            <tr id="tr1">
              <th>機能</th>
              <td>1111111111</td>
            </tr>
            <tr id="tr2">
              <th>機能</th>
              <td>2222222222</td>
            </tr>
            <tr id="tr3">
              <th>機能</th>
              <td>3333333333</td>
            </tr>
          </table> -->
          <div class="list_1_table wrapper">
            <table>
              <?= $output ?>
              <!-- <tr>
                <th>P.N.（必須）</th>
                <td>名前</td>
              </tr>
              <tr>
                <th>ペンネームよみがな</th>
                <td>なまえ</td>
              </tr>
              <tr>
                <th>サークル名</th>
                <td>サークル１</td>
              </tr>
              <tr>
                <th>サークル名よみがな</th>
                <td>さーくる１</td>
              </tr>
              <tr>
                <th>作品名（ジャンル）</th>
                <td>BASARA</td>
              </tr>
              <tr>
                <th>作品名（ジャンル）よみがな</th>
                <td>ばさら</td>
              </tr>
              <tr>
                <th>中心キャラ ※1</th>
                <td>政宗様</td>
              </tr>
              <tr>
                <th>カップリング ※2</th>
                <td>さなだて</td>
              </tr>
              <tr>
                <th>地雷</th>
                <td>女体化</td>
              </tr>
              <tr>
                <th>補足説明</th>
                <td>ほのぼの</td>
              </tr>
              <tr>
                <th>Twitter ID</th>
                <td>@xxxx</td>
              </tr>
              <tr>
                <th>WEB URL（店舗など）</th>
                <td>https://aaa.aaa</td>
              </tr>
              <tr>
                <th>Pixiv ID</th>
                <td>99999999</td>
              </tr>
              <tr>
                <th>FanBox</th>
                <td>https://aaa/bbb</td>
              </tr>
              <tr>
                <th>次の参加予定 ※3</th>
                <td>エアブー</td>
              </tr> -->
            </table>
          </div>
        </div>

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