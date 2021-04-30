<?php
// ライブラリ読み込み
require_once "phpqrcode/qrlib.php";

// 画像の保存場所
$filepath = 'qr.png';

// QRコードの内容
// $contents = "result.php?data=hogehoge";
// QRコードに入れるテキスト
// $data = $user_id;
// $contents = "qr_result.php?data=" . $data;
$contents = "qr_result.php?data=" . $_GET['data'];

// QRコード画像を出力　※詳しくは公式サイトのマニュアルを確認ください。
QRcode::png($contents, $filepath, QR_ECLEVEL_M, 6);

//このファイルを画像ファイルとして扱う宣言
header('Content-Type: image/png');
readfile('qr.png');
