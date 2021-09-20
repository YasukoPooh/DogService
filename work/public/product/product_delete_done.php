<?php

namespace MyApp;

require_once(__DIR__ . '/../../app/config.php');
require_once(__DIR__. '/../../app/Utils.php');
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
  <title> 商品削除完了 </title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>
  
<?php

$product_id = $_GET['product_id'];

try
{
  // imageをローカルから削除する
  $pdo = Database::getInstance();
  $sql = 'SELECT image FROM products WHERE id = :id';
  $stmt = $pdo->prepare($sql);
  $stmt->bindValue('id', $product_id, \PDO::PARAM_INT);
  $stmt->execute();
  $product = $stmt->fetch();
  if(empty($product))
  {
    header('HTTP', true, 404);
    exit();
  }

  unlink('../product/img/' . $product->image);

  // Productsテーブルのレコード削除
  $sql = 'DELETE FROM products WHERE id = :id';
  $stmt = $pdo->prepare($sql);
  $stmt->bindValue('id', $product_id, \PDO::PARAM_INT);
  $stmt->execute();

  // echo '削除完了しました。' . PHP_EOL;
}
catch (\PDOException $e)
{
  echo $e->getMessage();
  exit();
}
?>

  <p class="message">削除完了しました。</p>
  <a href="product_list.php">戻る</a>
</body>
</html>
