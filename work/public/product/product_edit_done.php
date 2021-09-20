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
  <title> 商品編集完了 </title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<?php

$post = Utils::post_h($_POST);

// ファイル名取得
$imageName = $post['image'];

try
{
  // Productsテーブルのレコード更新
  $pdo = Database::getInstance();
  $sql = 'UPDATE products SET name = :name, price = :price, image = :image, comment = :comment WHERE id = :id';
  $stmt = $pdo->prepare($sql);
  $stmt->bindValue('name', $post['name'], \PDO::PARAM_STR);
  $stmt->bindValue('price', $post['price'], \PDO::PARAM_INT);
  $stmt->bindValue('image', $imageName, \PDO::PARAM_STR);
  $stmt->bindValue('comment', $post['comment'], \PDO::PARAM_STR);
  $stmt->bindValue('id', $post['product_id'], \PDO::PARAM_INT);
  $stmt->execute();

  // echo '編集完了しました。' . PHP_EOL;
}
catch (\PDOException $e)
{
  echo $e->getMessage();
  exit();
}
?>
  
  <p class="message">編集完了しました。</p>
  <a href="product_list.php">戻る</a>
</body>
</html>