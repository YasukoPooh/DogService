<?php

namespace MyApp;

require_once(__DIR__ . '/../../app/config.php');
require_once(__DIR__ . '/../../app/Utils.php');
require_once(__DIR__ . '/../../app/CsrfValid.php');
require_once(__DIR__ . '/../../app/Database.php');

use Exception;
use MyApp\Utils;
use MyApp\Database;
use MyApp\CsrfValid;

session_start();
session_regenerate_id(true);
$valid = CsrfValid::validate();
if(!$valid)
{
  echo '<p class="err_msg">ログインされていません。</p>';
  echo '<a href="../admin_login/admin_login.php">ログイン画面へ</a>';
  exit();
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title> 商品一覧 </title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<?php
try
{
  // Productsテーブルのレコード取得
  $pdo = Database::getInstance();
  $sql = 'SELECT id, name, price FROM products';
  $stmt = $pdo->prepare($sql);
  $stmt->execute();
  $products = $stmt->fetchAll();
}
catch (\PDOException $e)
{
  echo $e->getMessage();
  exit();
}
?>

<div>
  <h1>商品一覧</h1>
  <form action="product_branch.php" method="post">
    <div class="product_list">
      <table class="product_table product_fixhead_table">
        <thead>
          <tr>
            <th>操作</th>
            <th>id</th>
            <th>商品名</th>
            <th>価格(税抜)</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($products as $product): ?>
            <tr>
              <td><input type="radio" name="product_id" value="<?php echo $product->id; ?>"></td>
              <td><?php echo Utils::h(($product->id)); ?></td>
              <td><?php echo Utils::h($product->name); ?></td>
              <td><?php echo Utils::h($product->price); ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <input type="submit" name="btn_disp" value="参照">
    <input type="submit" name="btn_add" value="追加">
    <input type="submit" name="btn_edit" value="編集">
    <input type="submit" name="btn_delete" value="削除">
  </form>
</div>
  
<br /><br />
<a href="../admin_login/admin_top.php">トップメニューへ</a>
</body>
</html>