<?php

namespace MyApp;

require_once(__DIR__ . '/../../app/Utils.php');
require_once(__DIR__ . '/../../app/Database.php');
require_once(__DIR__ . '/../../app/admin/admin_utils.php');

use Exception;
use MyApp\Utils;
use MyApp\Database;
use MyApp\AdminUtils;

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title> 管理者削除完了 </title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<?php

$admin_id = $_GET['admin_id'];

try{
  // Adminsテーブルのレコード削除
  $pdo = Database::getInstance();
  $sql = 'DELETE FROM admins WHERE id = :id';
  $stmt = $pdo->prepare($sql);
  $stmt->bindValue('id', $admin_id, \PDO::PARAM_INT);
  $stmt->execute();

  // echo '削除完了しました' . PHP_EOL;
}
catch (\PDOException $e)
{
  echo $e->getMessage();
  exit();
}

?>
  
  <p class="message">削除完了しました。</p>
  <a href="admin_list.php">戻る</a>
</body>
</html>