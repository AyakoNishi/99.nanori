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
            <img class="my_card_1" src="image/2473170.jpg" alt="my_card_1" width="300px"><br>
            <!-- <form action="file_upload.php" method="POST" enctype="multipart/form-data">
              <div>
                <input type="file" name="upfile" accept="image/*" capture="camera">
              </div>
              <div>
                <button>submit</button>
              </div>
            </form> -->
            <form class="file_upload" action="card_upload.php" method="POST" enctype="multipart/form-data">
              <br>
              <div>
                <input type="file" name="upfile" accept="image/*" capture="camera">
              </div>
              <div>
                <button class="file_button">画像をアップロード</button>
              </div>
            </form>
            <!-- <p>名刺の画像をupする</p> -->
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
                <p>登録を行います。</p>
                <!-- <a class="edit_button" href="my_page_edit_act.php">保存する</a> -->
                <!-- <button class="edit_button"><input type="submit" name="edit_data" />保存する</button> -->
                <button class="edit_button">保存する</button>
              </div>
              <div>
                <label for="name">Name（※必須）</label>
                <!-- <input type="text" id="name" name="name"> -->
                <input type="text" name="name">
              </div>
              <div>
                <label for="name_yomi">よみがな</label>
                <input type="text" id="name_yomi" name="name_yomi">
              </div>
              <div>
                <label for="circle">サークル名</label>
                <input type="text" id="circle" name="circle">
              </div>
              <div>
                <label for="circle_yomi">サークル名よみがな</label>
                <input type="text" id="circle_yomi" name="circle_yomi">
              </div>
              <div>
                <label for="genre">作品名（ジャンル）</label>
                <input type="text" id="genre" name="genre">
              </div>
              <div>
                <label for="genre_yomi">作品名（ジャンル）よみがな</label>
                <input type="text" id="genre_yomi" name="genre_yomi">
              </div>
              <div>
                <label for="main_chara">中心キャラ ※1</label>
                <input type="text" id="main_chara" name="main_chara">
              </div>
              <div>
                <label for="couple">カップリング ※2</label>
                <input type="text" id="couple" name="couple">
              </div>
              <div>
                <label for="NG_type">地雷</label>
                <input type="text" id="NG_type" name="NG_type">
              </div>
              <div>
                <label for="hosoku">補足説明</label>
                <input type="text" id="hosoku" name="hosoku">
              </div>
              <div>
                <label for="twitter_id">Twitter ID</label>
                <input type="text" id="twitter_id" name="twitter_id">
              </div>
              <div>
                <label for="web_url">WEB URL（店舗など）</label>
                <input type="text" id="web_url" name="web_url">
              </div>
              <div>
                <label for="Pixiv_id">Pixiv ID</label>
                <input type="text" id="Pixiv_id" name="Pixiv_id">
              </div>
              <div>
                <label for="FanBox">FanBox</label>
                <input type="text" id="FanBox" name="FanBox">
              </div>
              <div>
                <label for="next_eve">次の参加予定 ※3</label>
                <input type="text" id="next_eve" name="next_eve">
              </div>
              <div>
                <label for="next_eve">次の参加予定 ※3</label>
                <input type="text" id="next_eve" name="next_eve">
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