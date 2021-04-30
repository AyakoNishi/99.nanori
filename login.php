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
  <header class="page-header wrapper">
    <a href="index.html"><img src="image/nanori_logo.png" alt="名乗りロゴ"></a>
    <nav>
      <ul class="navi">
        <!-- <li class="nav_box"><a href="#show">名刺を表示する</a></li>
        <li class="nav_box"><a href="#contact">名刺を取得する</a></li>
        <li class="nav_box"><a href="#daatbase">名刺を管理する</a></li> -->
        <!-- <li class="nav_box"><a href="login.php">LOGIN</a></li> -->
      </ul>
    </nav>
  </header>

  <form action="login_act.php" method="POST">
    <div class="login_page">
      <h2>同人専用オンライン名刺『Na-nori』ログイン画面</h2>
      <div>
        ログインID: <input type="text" name="user_nm" style="border: solid 1px;">
      </div>
      <div>
        パスワード: <input type="text" name="password" style="border: solid 1px;">
      </div>
      <div class="login_button">
        <!-- <button class="top_button_n"><a href="new_account_act.php">新規登録</a></button> -->
        <!-- <button class="top_button_l">ログイン</button> -->
        <button class="top_button_n"><input type="submit" name="submit1" value="新規登録" /></button>
        <button class="top_button_l"><input type="submit" name="submit2" value="ログイン" /></button>
      </div>
    </div>
  </form>

  <footer>
    <p>copyrights 2021 Na-nori All RIghts Reserved.</p>
  </footer>
</body>

</html>