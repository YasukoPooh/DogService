<?php

namespace MyApp;

require_once(__DIR__ . '/../../app/config.php');
require_once(__DIR__. '/../../app/Utils.php');
require_once(__DIR__ . '/../../app/Database.php');

use Exception;
use MyApp\Utils;
use MyApp\Database;

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title> 商品削除完了 </title>
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

  echo '削除完了しました。' . PHP_EOL;
}
catch (\PDOException $e)
{
  echo $e->getMessage();
  exit();
}
?>

  <a href="product_list.php">戻る</a>
</body>
</html>
