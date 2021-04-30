<?php
// 関数ファイル読み込み処理を記述（認証関連は省略でOK）
include("functions.php");

// DB接続の処理を記述
$search_word = $_GET["searchword"]; // GETのデータ受け取り

// DB接続
$pdo = connect_to_db();

// SQL実行の処理を記述
$sql = "SELECT * FROM todo_table
WHERE todo LIKE '%{$search_word}%'"; // LIKEを使って検索
// SQL準備&実行
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

if ($status == false) {
    // エラー処理を記述
} else {
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($result); // JSON形式にして出力
    exit();
}
