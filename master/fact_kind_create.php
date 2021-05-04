<?php
session_start();
include("../functions.php");
check_session_id();

// DB接続情報
$pdo = connect_to_db();

// var_dump($_POST);
// exit();
// $id = $_GET['id'];
if (
  !isset($_POST['kind_cd']) || $_POST['kind_cd'] == '' ||
  !isset($_POST['kind_nm']) || $_POST['kind_nm'] == ''
) {
  exit('ParamError');
}
$kind_cd = $_POST['kind_cd'];
$kind_nm = $_POST['kind_nm'];


// DB接続情報
$pdo = connect_to_db();

//SQL
$sql = 'INSERT INTO  kind_table 
VALUES(NULL, :kind_cd, :kind_nm)';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':kind_cd', $kind_cd, PDO::PARAM_STR);
$stmt->bindValue(':kind_nm', $kind_nm, PDO::PARAM_STR);
$status = $stmt->execute(); // SQLを実行

// 失敗時にエラーを出力し，成功時は登録画面に戻る
if ($status == false) {
  $error = $stmt->errorInfo();
  // データ登録失敗次にエラーを表示
  exit('sqlError:' . $error[2]);
} else {
  // 登録ページへ移動
  // header('Location:fact_input.php');
  header('Location:../fact_mast_edit.php');
}

// master_read($pdo);
//SQL kind-table
$output_k = kind_table_access($pdo);

//SQL coffee-table
$output_c = coffee_table_access($pdo);

//SQL brend-table
$output_b = brend_table_access($pdo);

//SQL hot-table
$output_h = hot_table_access($pdo);

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/style.css">
  <title>カフェ売り上げ実績（ファクトテーブル実践）</title>
</head>

<body>
  <form action="fact_update.php" method="POST">
    <div class="head-title">
      <h1>カフェ売り上げ実績（ファクトテーブル実践）</h1>
    </div>
    <div class="button_area">
      <button><a href="fact_input.php">入力画面</a></button>
      <button><a href="login/fact_logout.php">ログアウト</a></button>
    </div>
    <div class="tab">
      <ul class="tab_menu">
        <li class="current"><a href="fact_read.php">実績表示</a></li>
        <li><a href="fact_input.php">実績入力</a></li>
        <li><a href="fact_mast_edit.php">マスタ修正</a></li>
        <li><a href="fact_sum.php">集計</a></li>
      </ul>
    </div>

    <h2> マスター修正中・・・</h2>
    <!-- <div class="mast_buttons">
      <button class="mast_button"><a href="master/fact_mast_kind.php">種類 修正</a></button>
      <button class="mast_button"><a href="master/fact_mast_coffee.php">メニュー 修正</a></button>
      <button class="mast_button"><a href="master/fact_mast_brend.php">アイテム 修正</a></button>
      <button class="mast_button"><a href="master/fact_mast_hot.php">hot/ice 修正</a></button>
    </div>
 -->
    <div>
      <div class="mast_k">
        <br>
        <label for="kind_list" class="textfield_label">種類:</label>
        <input type="text" name="kind_cd" placeholder="ID(1)">
        <input type="text" name="kind_nm" placeholder="名前(ドリンク）">
        <button class="kind_button"><a href="master/fact_kind_create.php">追加</a></button>
        <button class="kind_button"><a href="master/fact_kind_update.php">修正</a></button>
        <button class="kind_button"><a href="master/fact_kind_delete.php">削除</a></button>
      </div>
      <div class="coffee_k">
        <br>
        <label for="coffee_list" class="textfield_label">メニュー:</label>
        <input type="text" name="coffee_cd" placeholder="ID(D1)">
        <input type="text" name="coffee_nm" placeholder="名前(珈琲）">
        <button class="coffee_button"><a href="master/fact_coffee_create.php">追加</a></button>
        <button class="coffee_button"><a href="master/fact_coffee_update.php">修正</a></button>
        <button class="coffee_button"><a href="master/fact_coffee_delete.php">削除</a></button>
      </div>
      <div class="brend_k">
        <br>
        <label for="brend_list" class="textfield_label">アイテム:</label>
        <input type="text" name="brend_cd" placeholder="ID(D1001)">
        <input type="text" name="brend_nm" placeholder="名前(ブレンド）">
        <input type="text" name="brend_price" placeholder="単価(350）">
        <button class="brend_button"><a href="master/fact_brend_create.php">追加</a></button>
        <button class="brend_button"><a href="master/fact_brend_update.php">修正</a></button>
        <button class="brend_button"><a href="master/fact_brend_delete.php">削除</a></button>
      </div>
      <div class="hot_k">
        <br>
        <label for="hot_list" class="textfield_label">HOT/ICE:</label>
        <input type="text" name="hot_cd" placeholder="ID(1)">
        <input type="text" name="hot_nm" placeholder="名前(hot）">
        <button class="hot_button"><a href="master/fact_hot_create.php">追加</a></button>
        <button class="hot_button"><a href="master/fact_hot_update.php">修正</a></button>
        <button class="hot_button"><a href="master/fact_hot_delete.php">削除</a></button>
      </div>
      <div>
        <input type="hidden" name="id" value="<?= $record_edit['id'] ?>">
      </div>
      <br>
    </div>
  </form>

  <div class="master">
    <div class="kind_t">
      <table>
        <thead>
          <tr>
            <th colspan="2">種類</th>
          </tr>
        </thead>
        <tbody>
          <?= $output_k ?>
        </tbody>
      </table>
    </div>
    <div class="coffee_t">
      <table>
        <thead>
          <tr>
            <th colspan="2">メニュー名</th>
          </tr>
        </thead>
        <tbody>
          <?= $output_c ?>
        </tbody>
      </table>
    </div>
    <div class="brend_t">
      <table>
        <thead>
          <tr>
            <th colspan="2">アイテム名</th>
            <th>単価</th>
          </tr>
        </thead>
        <tbody>
          <?= $output_b ?>
        </tbody>
      </table>
    </div>
    <div class="hot_t">
      <table>
        <thead>
          <tr>
            <th colspan="2">HOT/ICE</th>
          </tr>
        </thead>
        <tbody>
          <?= $output_h ?>
        </tbody>
      </table>
    </div>
  </div>

</body>

</html>