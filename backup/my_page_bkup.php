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
// 管理ユーザでない
$is_admin = $_SESSION["is_admin"];

if ($is_admin != 1) {
  echo "<p>管理者以外の閲覧は出来ません。</p>";
  // header('Location: login.php'); // ログイン画面へ移動
};


//SQL Fact-table
$sql = 'SELECT E.id, A.kind_cd, A.kind_nm, B.coffee_cd, B.coffee_nm, 
C.brend_cd, C.brend_nm, 
D.hot_nm, C.brend_price as unit_price, 
E.count_c, E.count_c *  C.brend_price as price , E.memo
FROM cafe_table E, kind_table A, coffee_table B, brend_table C, hot_table D 
WHERE (E.kind_cd = A.kind_cd) 
AND (E.coffee_cd = B.coffee_cd) 
AND (E.brend_cd = C.brend_cd) 
AND (E.hot_cd = D.hot_cd) 
ORDER BY E.id';
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

if ($status == false) {
  $error = $stmt->errorInfo();
  echo json_encode(["error_msg" => "{$error[2]}"]);
  exit();
} else {
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $output = "";
  foreach ($result as $record) {
    $output .= "<tr>";
    $output .= "<td>{$record["kind_cd"]}</td>";
    $output .= "<td>{$record["kind_nm"]}</td>";
    $output .= "<td>{$record["coffee_cd"]}</td>";
    $output .= "<td>{$record["coffee_nm"]}</td>";
    $output .= "<td>{$record["brend_cd"]}</td>";
    $output .= "<td>{$record["brend_nm"]}</td>";
    $output .= "<td>{$record["hot_nm"]}</td>";
    $output .= "<td>{$record["unit_price"]}</td>";
    $output .= "<td>{$record["count_c"]}</td>";
    $output .= "<td>{$record["price"]}</td>";
    $output .= "<td>{$record["memo"]}</td>";
    // edit deleteリンクを追加
    $output .= "<td><a href='edit.php?id={$record["id"]}'>更新</a></td>";
    $output .= "<td><a href='delete.php?id={$record["id"]}'>削除</a></td>";
    $output .= "</tr>";
  }
  unset($record);
}

//SQL kind-table
$output_k = kind_table_access($pdo);

//SQL coffee-table
$output_c = coffee_table_access($pdo);

//SQL brend-table
$output_b = brend_table_access($pdo);

//SQL hot-table
$output_h = hot_table_access($pdo);

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
  <title>名乗り β</title>
</head>

<body>
  <div id="home" class="my_Page">
    <!-- <header>ヘッダー</header> -->
    <header class="page-header wrapper">
      <a href="index.php"><img src="image/header_logo.png" alt="名乗りロゴ"></a>
      <nav>
        <ul class="navi">
          <li class="nav_box"><a href="#show">名刺を表示する</a></li>
          <li class="nav_box"><a href="#contact">名刺を取得する</a></li>
          <li class="nav_box"><a href="#daatbase">名刺を管理する</a></li>
          <li class="nav_box"><a href="login.php">LOGIN</a></li>
        </ul>
      </nav>
    </header>

    <main>
      <div class="my_page_contents wrapper">
        <!-- 左側   名刺表示部分-->
        <div class="myCard_left">
          <p>左側</p>
          <img class="my_card_1" src="card/PixivFactory_my_card.png" alt="my_card_1" width="300px">
        </div>
        <!-- 右側  リスト -->
        <div class="myCard_right">
          <p>右側</p>
          <table class="list_1_table">
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
          </table>
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