<?php
// var_dump($_POST);
// exit();

session_start();
include('functions.php');
// check_session_id();

// var_dump($_POST["submit1"]);
// var_dump($_POST["submit2"]);

$pdo = connect_to_db();
$user_nm = $_POST["user_nm"];
$password = $_POST["password"];
// exit();
// var_dump($user_nm);
// var_dump($password);

// ここから new_account
if (isset($_POST["submit1"])) {
    // var_dump('submit1');
    // ユーザ存在有無確認
    $sql = 'SELECT COUNT(*) FROM users_table WHERE user_nm=:user_nm';

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':user_nm', $user_nm, PDO::PARAM_STR);
    $status = $stmt->execute();

    if ($status == false) {
        // SQL実行に失敗した場合はここでエラーを出力し，以降の処理を中止する
        $error = $stmt->errorInfo();
        echo json_encode(["error_msg" => "{$error[2]}"]);
        exit();
    }

    if ($stmt->fetchColumn() > 0) {
        // user_nmが1件以上該当した場合はエラーを表示して元のページに戻る
        // $count = $stmt->fetchColumn();
        echo "<p>すでに登録されているユーザです．</p>";
        var_dump("すでに登録されているユーザです");
        echo '<a href="login.php">login</a>';
        exit();
    }
    // ユーザ登録SQL作成
    // `created_ad`と`updated_at`には実行時の`sysdate()`関数を用いて実行時の日時を入力する
    $sql = 'INSERT INTO users_table(user_id, user_nm, password, is_admin, created_ad, updated_ad) VALUES(NULL, :user_nm, :password, 0, sysdate(), sysdate())';

    // SQL準備&実行
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':user_nm', $user_nm, PDO::PARAM_STR);
    $stmt->bindValue(':password', $password, PDO::PARAM_STR);
    $status = $stmt->execute();

    // データ登録処理後
    if ($status == false) {
        // SQL実行に失敗した場合はここでエラーを出力し，以降の処理を中止する
        $error = $stmt->errorInfo();
        echo json_encode(["error_msg" => "{$error[2]}"]);
        exit();
    } else {
        // 正常にSQLが実行された場合は入力ページファイルに移動し，入力ページの処理を実行する
        $_SESSION = array();
        $_SESSION["session_id"] = session_id();
        $_SESSION["is_admin"] = $val["is_admin"];
        $_SESSION["user_nm"] = $val["user_nm"];
        $_SESSION["user_id"] = $val["user_id"];
        header("Location:my_page_edit.php");
        exit();
    }
}
//ここまで

// ここから login
if (isset($_POST["submit2"])) {
    // var_dump('submit2');
    // exit();

    $sql = 'SELECT * FROM users_table
        WHERE user_nm = :user_nm
        AND   password = :password';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':user_nm', $user_nm, PDO::PARAM_STR);
    $stmt->bindValue(':password', $password, PDO::PARAM_STR);
    $status = $stmt->execute();

    if ($status == false) {
        $error = $stmt->errorInfo();
        echo json_encode(["error_msg" => "{$error[2]}"]);
        exit();
    }

    $val = $stmt->fetch(PDO::FETCH_ASSOC);
    // var_dump($val);
    // exit();

    if (!$val) {
        echo "<p>ユーザーID またはパスワードに誤りがあります</p>";
        echo '<a href = "login.php">login</a>';
        exit();
    } else {
        $_SESSION = array();
        $_SESSION["session_id"] = session_id();
        $_SESSION["is_admin"] = $val["is_admin"];
        $_SESSION["user_nm"] = $val["user_nm"];
        $_SESSION["user_id"] = $val["user_id"];
        // exit();

        header("Location:my_page.php");
        exit();
    }
}
//ここまで
