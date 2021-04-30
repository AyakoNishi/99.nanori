<?php
var_dump($_POST);
// exit();

session_start();
include('functions.php');
var_dump('function');
// exit();
// check_session_id();
// var_dump('check_session');
// exit();

$pdo = connect_to_db();
$user_nm = $_POST["user_nm"];
$password = $_POST["password"];
var_dump("sqlの前 login_act");
// exit();

$sql = 'SELECT * FROM users_table
        WHERE user_nm = :user_nm
        AND   password = :password';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_nm', $user_nm, PDO::PARAM_STR);
$stmt->bindValue(':password', $password, PDO::PARAM_STR);
$status = $stmt->execute();
var_dump($status);

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
    var_dump($_SESSION["user_id"]);
    var_dump('login_act');
    // exit();

    header("Location:my_page.php");
    // if ($val["is_admin"] == 1) {
    //     // var_dump($val["is_admin"]);
    //     // exit();
    //     header("Location:my_page.php");
    // } else {
    //     header("Location:read_ippan.php");
    // }
    exit();
}
