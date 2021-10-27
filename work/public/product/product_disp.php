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

$product_id = $_GET['product_id'];

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title> 商品参照 </title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<?php
try
{
  // Productsテーブルのレコード参照
  $pdo = Database::getInstance();
  $sql = 'SELECT name, price, image, comment FROM products WHERE id = :id';
  $stmt = $pdo->prepare($sql);
  $stmt->bindValue('id', $product_id, \PDO::PARAM_INT);
  $stmt->execute();
  $product = $stmt->fetch();
  if(empty($product))
  {
    header('HTTP', true, 404);
    exit();
  }
}
catch (\PDOException $e)
{
  echo $e->getMessage();
  exit();
}
?>

<div>
  <h1>商品参照</h1>
  <div class="element_wrap">
    <label for="name">商品名</label>
    <p><?php echo $product->name; ?></p>
  </div>
  <div class="element_wrap">
    <label for="price">価格(税抜)</label>
    <p><?php echo $product->price; ?></p>
  </div>
  <div class="element_wrap">
    <label for="image">写真</label>
    <p><img src="<?php echo '../product/img/' . $product->image; ?>" alt=""></p>
  </div>
  <div class="element_wrap">
    <label for="comment">コメント</label>
    <p><?php echo nl2br($product->comment); ?></p>
  </div>
  <input type="button" onclick="history.back()" value="戻る" name="btn_back">
</div>
  
</body>
</html>