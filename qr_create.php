<?php
session_start();
$user_id = (int)$_SESSION["user_id"];
$page = 1;

// ライブラリ読み込み
require_once "phpqrcode/qrlib.php";

// 画像の保存場所
$filepath = 'qr.png';

// QRコードの内容
// $contents = "result.php?data=hogehoge";
// QRコードに入れるテキスト
// $contents = "qr_result.php?data=" . $_GET['data'];
// $contents = "my_page.php?data=" . $_GET['data'];
// $contents = "https://nanori-beta-ver1.lolipop.io/guest_get_confirm.php?data=" . $user_id . "&page=1";
$contents = "https://nanori-beta-ver1.lolipop.io/guest_get_confirm.php?key=$user_id&page=1";
// $contents = "https://nanori-beta-ver1.lolipop.io/index.html";

// QRコード画像を出力　※詳しくは公式サイトのマニュアルを確認ください。
QRcode::png($contents, $filepath, QR_ECLEVEL_M, 6);

//このファイルを画像ファイルとして扱う宣言
header('Content-Type: image/png');
readfile('qr.png');
