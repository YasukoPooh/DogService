<?php

namespace MyApp;

require_once(__DIR__ . '/../../app/Utils.php');
require_once(__DIR__ . '/../../app/Database.php');
require_once(__DIR__ . '/../../app/CsrfValid.php');

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
  <title> 商品追加完了 </title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>
  
<?php

$post = Utils::post_h($_POST);

// ファイル名取得
$imageName = $post['image'];

try
{
  // Productsテーブルへレコード挿入
  $pdo = Database::getInstance();
  $sql = 'INSERT INTO products (name, price, image, comment) VALUES (:name, :price, :image, :comment)';
  $stmt = $pdo->prepare($sql);
  $stmt->bindValue('name', $post['name'], \PDO::PARAM_STR);
  $stmt->bindValue('price', $post['price'], \PDO::PARAM_INT);
  $stmt->bindValue('image', $imageName, \PDO::PARAM_STR);
  $stmt->bindValue('comment', $post['comment'], \PDO::PARAM_STR);
  $stmt->execute();

  // Productsテーブルの id を取得
  $productId = $pdo->lastInsertId();

  // echo $post['name'] . 'を追加しました。' . PHP_EOL;
}
catch (\PDOException $e)
{
  echo $e->getMessage();
  exit();
}

?>

  <p class="message"><?php echo $post['name']; ?>を追加しました。</p>
  <a href="product_list.php">戻る</a>
</body>
</html>