<?php
// var_dump($_POST);
// exit();

session_start();
include('functions.php');
// check_session_id();
$_SESSION = array();

// var_dump($_POST["submit1"]);
// var_dump($_POST["submit2"]);
// var_dump("route 1");

$pdo = connect_to_db();
$user_nm = $_POST["user_nm"];
$password = $_POST["password"];
$_SESSION["error_msg"] = "";
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
    // var_dump("route 2");

    if ($status == false) {
        // SQL実行に失敗した場合はここでエラーを出力し，以降の処理を中止する
        // var_dump("route 2");
        $error = $stmt->errorInfo();
        echo json_encode(["error_msg" => "{$error[2]}"]);
        $error_msg = '<p>Error:ユーザーID またはパスワードに誤りがあります。(La-1) </p>';
        $_SESSION["error_msg"] = $error_msg;
        header("Location:login_error.php");
        exit();
    }

    if ($stmt->fetchColumn() > 0) {
        // var_dump("route 3");
        // user_nmが1件以上該当した場合はエラーを表示して元のページに戻る
        // $count = $stmt->fetchColumn();
        // echo "<p>すでに登録されているユーザです．</p>";
        // var_dump("すでに登録されているユーザです");
        $error_msg = '<p>Error:すでに登録されているユーザです(Lau-1) </p>';
        $_SESSION["error_msg"] = $error_msg;
        header("Location:login_error.php");
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
        // var_dump("route 4");
        // SQL実行に失敗した場合はここでエラーを出力し，以降の処理を中止する
        $error = $stmt->errorInfo();
        echo json_encode(["error_msg" => "{$error[2]}"]);
        // exit();
        $error_msg = '<p>Error:ユーザーID またはパスワードに誤りがあります。(La-2) </p>';
        $_SESSION["error_msg"] = $error_msg;
        header("Location:login_error.php");
        exit();
    } else {
        // var_dump("route 5");

        // 正常にSQLが実行された場合は入力ページファイルに移動し，入力ページの処理を実行する
        $_SESSION = array();
        $_SESSION["session_id"] = session_id();
        $_SESSION["is_admin"] = $val["is_admin"];
        $_SESSION["user_nm"] = $val["user_nm"];
        $_SESSION["guest_id"] = "";
        $_SESSION["error_msg"] = "";
        $_SESSION["card_image_path"] = "";

        // user_id 取得
        $sql = 'SELECT user_id FROM users_table
        WHERE user_nm = :user_nm
        AND   password = :password';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':user_nm', $user_nm, PDO::PARAM_STR);
        $stmt->bindValue(':password', $password, PDO::PARAM_STR);
        $status = $stmt->execute();

        if ($status == false) {
            // var_dump("route 6");
            $error = $stmt->errorInfo();
            echo json_encode(["error_msg" => "{$error[2]}"]);
            // exit();
            $error_msg = '<p>Error:ユーザーID またはパスワードに誤りがあります。(La-3) </p>';
            $_SESSION["error_msg"] = $error_msg;
            header("Location:login_error.php");
            exit();
        }

        $val = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$val) {
            // var_dump("route 7");
            $error_msg = '<p>Error:ユーザーID またはパスワードに誤りがあります。(La-4) </p>';
            $_SESSION["error_msg"] = $error_msg;
            header("Location:login_error.php");
            exit();
        } else {
            // var_dump("route 8");
            $_SESSION["user_id"] = $val["user_id"];
        }
        // var_dump($_SESSION["user_id"]);
        unset($val);

        header("Location:my_page_edit.php");
        exit();
    }
    //ここまで
} else {
    // ここから login
    // if (isset($_POST["submit2"])) {
    // var_dump('submit2');
    // exit();
    // var_dump("route 9");

    $sql = 'SELECT * FROM users_table
        WHERE user_nm = :user_nm
        AND   password = :password';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':user_nm', $user_nm, PDO::PARAM_STR);
    $stmt->bindValue(':password', $password, PDO::PARAM_STR);
    $status = $stmt->execute();

    if ($status == false) {
        // var_dump("route 10");
        $error = $stmt->errorInfo();
        echo json_encode(["error_msg" => "{$error[2]}"]);
        // exit();
        $error_msg = '<p>Error:登録がありません(La-5) </p>';
        $_SESSION["error_msg"] = $error_msg;
        header("Location:login_error.php");
        exit();
    }

    $val = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$val) {
        // var_dump("route 11");
        $error_msg = '<p>Error:ユーザーID またはパスワードに誤りがあります(Lau-2) </p>';
        $_SESSION["error_msg"] = $error_msg;
        header("Location:login_error.php");
        exit();
        // echo "<p>ユーザーID またはパスワードに誤りがあります</p>";
        // echo '<a href = "login.php">login</a>';
        // exit();
    } else {
        // var_dump("route 12");
        $_SESSION = array();
        $_SESSION["session_id"] = session_id();
        $_SESSION["is_admin"] = $val["is_admin"];
        $_SESSION["user_nm"] = $val["user_nm"];
        $_SESSION["user_id"] = $val["user_id"];
        $_SESSION["guest_id"] = "";
        $_SESSION["error_msg"] = "";
        $_SESSION["card_image_path"] = "";

        header("Location:my_page.php");
        exit();
    }
}
//ここまで
