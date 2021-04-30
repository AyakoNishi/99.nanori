<?php
// ライブラリ読み込み
require_once "phpqrcode/qrlib.php";

// URLを定数に設定
$url = 'qr_create.php?data=' . $_GET['data'];
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
    <div class="show-qr">
        <img src="<?php echo $url ?>" style="border: solid 1px; width: 500px;" />
        <!-- <img src="mycard/qr.png" /> -->
        <br>
        <a href="qr_index.html">QRコード入力へ戻る</a><br>
        <a href="my_page.php">マイページへ戻る</a><br>

    </div>

    <!-- <footer>フッター</footer> -->
    <footer>
        <p>copyrights 2021 Na-nori All RIghts Reserved.</p>
    </footer>

</body>

</html>