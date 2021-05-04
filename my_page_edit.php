<?php
session_start();
include("functions.php");
// check_session_id();

// DB接続情報
$pdo = connect_to_db();

// SESSION 変数  set
$user_id = (int)$_SESSION["user_id"];
// $page = (int)$_SESSION["page"];
$page = 1;
$card_image_path = $_SESSION["card_image_path"];
$error_msg = $_SESSION["error_msg"];

// 一応select
$sql =
  'SELECT * FROM mypage_table
    WHERE  (user_id = :user_id  and  page = :page)';

// SQL準備 & 実行
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
$stmt->bindValue(':page', $page, PDO::PARAM_STR);
$status = $stmt->execute();

// データ登録処理後
if ($status == false) {
  // SQL実行に失敗した場合はここでエラーを出力し，以降の処理を中止する
  $error = $stmt->errorInfo();
  echo json_encode(["error_msg" => "{$error[2]}"]);
  exit();
}

$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
$name         = "";
$name_yomi    = "";
$circle       = "";
$circle_yomi  = "";
$genre        = "";
$genre_yomi   = "";
$main_chara   = "";
$couple       = "";
$NG_type      = "";
$hosoku       = "";
$twitter_id   = "";
$web_url      = "";
$Pixiv_id     = "";
$FanBox       = "";
$next_eve     = "";
$next_eve_url = "";
$image        = "";

// 編集済みデータがある場合、カラムにデータを表示する
foreach ($result as $record) {
  $name         .= "{$record["name"]}";
  $name_yomi    .= "{$record["name_yomi"]}";
  $circle       .= "{$record["circle"]}";
  $circle_yomi  .= "{$record["circle_yomi"]}";
  $genre        .= "{$record["genre"]}";
  $genre_yomi   .= "{$record["genre_yomi"]}";
  $main_chara   .= "{$record["main_chara"]}";
  $couple       .= "{$record["couple"]}";
  $NG_type      .= "{$record["NG_type"]}";
  $hosoku       .= "{$record["hosoku"]}";
  $twitter_id   .= "{$record["twitter_id"]}";
  $web_url      .= "{$record["web_url"]}";
  $Pixiv_id     .= "{$record["Pixiv_id"]}";
  $FanBox       .= "{$record["FanBox"]}";
  $next_eve     .= "{$record["next_eve"]}";
  $next_eve_url .= "{$record["next_eve_url"]}";
  $image        .= "{$record["image"]}";
}
unset($record);

$card_image_show = "image/2473170.jpg";
// mypage_table にレコードがない場合、card_image にデフォルトの画像を置く
if (!$result) {
  if (!$card_image_path) {
    $card_image_show = '<img class="my_card_1" src="image/2473170.jpg" alt="my_card_1" width="300px"><br>';
    // var_dump("image0");
  } else {
    $card_image_show = '<img class="my_card_1" src="' . $card_image_path . '" alt="my_card_1" width="300px"><br>'; // imgタグを設定
    // var_dump("image4");
  }
} else {
  // 画像アップロードしていない場合も、card_image にデフォルトの画像を置く
  // mypage_table に画像がある場合は、mypage_table の image
  if (!$card_image_path) {
    if (!$image) {
      $card_image_show = '<img class="my_card_1" src="image/2473170.jpg" alt="my_card_1" width="300px"><br>';
      // var_dump("image1");
    } else {
      $card_image_show = '<img class="my_card_1" src="' . $image . '" alt="my_card_1" width="300px"><br>'; // imgタグを設定
      // var_dump("image2");
    }
  } else {
    // 画像アップロードしてる場合、card_image にアップロード画面を置く
    // $card_image_show .= '<img class="my_card_1" src="' . $card_image_path . 'alt="my_card_1" width="300px"><br>'; // imgタグを設定
    $card_image_show = '<img class="my_card_1" src="' . $card_image_path . '" alt="my_card_1" width="300px"><br>'; // imgタグを設定
    // var_dump("image3");
  }
}
// var_dump($card_image_path);
// var_dump($card_image_show);
// exit();

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
          <div class="card_edit">
            <?= $card_image_show ?>
            <!-- <img class="my_card_1" src="image/2473170.jpg" alt="my_card_1" width="300px"><br> -->
            <form action="card_upload.php" method="POST" enctype="multipart/form-data">
              <div>
                <input type="file" name="upfile" accept="image/*" capture="camera">
              </div>
              <?= $error_msg ?>
              <div>
                <button class="file_button">画像をアップロード</button>
              </div>
            </form>
            <a href="https://twitter.com"><i class="fab fa-twitter"></i></a>
          </div>
        </div>
        <!-- 右側  リスト -->
        <div class="myCard_right">
          <!-- <p>右側</p> -->
          <!-- <table class="test">
            <div>
              <th>ラジオ</th>
              <td>
                <input type="radio" name="use" value="1" id="radio1" checked /><label for="radio1">名刺１</label>
                <input type="radio" name="use" value="2" id="radio2" /><label for="radio2">名刺２</label>
                <input type="radio" name="use" value="3" id="radio3" /><label for="radio3">名刺３</label>
              </td>
            </div>
            <tr id="tr1">
              <th>機能</th>
              <td>1111111111</td>
            </div>
            <tr id="tr2">
              <th>機能</th>
              <td>2222222222</td>
            </div>
            <tr id="tr3">
              <th>機能</th>
              <td>3333333333</td>
            </div>
          </table> -->
          <div id="mypage_form" class="form_1_table wrapper">
            <form action="my_page_edit_act.php" method="POST">
              <div class="newdata_button">
                <!-- <p>登録を行います。</p> -->
                <!-- <a class="edit_button" href="my_page_edit_act.php">保存する</a> -->
                <!-- <button class="edit_button"><input type="submit" name="edit_data" />保存する</button> -->
                <button class="edit_button">保存する</button>
              </div>
              <div>
                <label for="name">Name（※必須）</label>
                <!-- <input type="text" id="name" name="name"> -->
                <input type="text" name="name" value="<?php echo $name ?>" required>
              </div>
              <div>
                <label for="name_yomi">よみがな</label>
                <input type="text" name="name_yomi" value=" <?php echo $name_yomi ?>">
              </div>
              <div>
                <label for="circle">サークル名</label>
                <input type="text" name="circle" value="<?php echo $circle ?>">
              </div>
              <div>
                <label for=" circle_yomi">サークル名よみがな</label>
                <input type="text" name="circle_yomi" value="<?php echo $circle_yomi ?>">
              </div>
              <div>
                <label for="genre">作品名（ジャンル）</label>
                <input type="text" name="genre" value="<?php echo $genre ?>">
              </div>
              <div>
                <label for="genre_yomi">作品名（ジャンル）よみがな</label>
                <input type="text" name="genre_yomi" value="<?php echo $genre_yomi ?>">
              </div>
              <div>
                <label for="main_chara">中心キャラ ※1</label>
                <input type="text" name="main_chara" value="<?php echo $main_chara ?>">
              </div>
              <div>
                <label for="couple">カップリング ※2</label>
                <input type="text" name="couple" value="<?php echo $couple ?>">
              </div>
              <div>
                <label for="NG_type">地雷</label>
                <input type="text" name="NG_type" value="<?php echo $NG_type ?>">
              </div>
              <div>
                <label for="hosoku">補足説明</label>
                <input type="text" name="hosoku" value="<?php echo $hosoku ?>">
              </div>
              <div>
                <label for="twitter_id">Twitter ID</label>
                <input type="text" name="twitter_id" value="<?php echo $twitter_id ?>">
              </div>
              <div>
                <label for="web_url">WEB URL（店舗など）</label>
                <input type="text" name="web_url" value="<?php echo $web_url ?>">
              </div>
              <div>
                <label for="Pixiv_id">Pixiv ID</label>
                <input type="text" name="Pixiv_id" value="<?php echo $Pixiv_id ?>">
              </div>
              <div>
                <label for="FanBox">FanBox</label>
                <input type="text" name="FanBox" value="<?php echo $FanBox ?>">
              </div>
              <div>
                <label for="next_eve">次の参加予定 ※3</label>
                <input type="text" name="next_eve" value="<?php echo $next_eve ?>">
              </div>
              <div>
                <label for="next_eve_url">次の参加予定のURL</label>
                <input type="text" name="next_eve_url" value="<?php echo $next_eve_url ?>">
              </div>
            </form>
          </div>
        </div>

      </div>
    </main>
  </div><!-- /#mypage_edit-->

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