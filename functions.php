<?php

function connect_to_db()
{
    // $dbn = 'mysql:dbname=fd7_26_nanori;charset=utf8;port=3306;host=localhost';
    $dbn = 'mysql:dbname=35ec05a42d6bc3c8df0e6aa0a4a2eea3;charset=utf8;port=3306;host=mysql-2.mc.lolipop.lan';
    $user = '35ec05a42d6bc3c8df0e6aa0a4a2eea3';
    $pwd = 'raRori0411gs';

    try {
        // ここでDB接続処理を実行する
        return new PDO($dbn, $user, $pwd);
    } catch (PDOException $e) {
        // DB接続に失敗した場合はここでエラーを出力し，以降の処理を中止する
        echo json_encode(["db error" => "{$e->getMessage()}"]);
        exit();
    }
}

// ログイン状態のチェック関数
function check_session_id()
{
    // 失敗時はログイン画面に戻る
    if (
        !isset($_SESSION['session_id']) || // session_idがない
        $_SESSION['session_id'] != session_id() // idが一致しない
    ) {
        var_dump('ログインNG');
        exit();
        echo "<p>ユーザーID またはパスワードに誤りがあります。または新規登録をお願いします。</p>";
        header('Location: login.php'); // ログイン画面へ移動
    } else {
        // var_dump('ログインOK');
        // exit();
        session_regenerate_id(true); // セッションidの再生成
        $_SESSION['session_id'] = session_id(); // セッション変数上書き
        // ここで exit() を書かない！  まだ後に処理が続くから！！
    }
}
