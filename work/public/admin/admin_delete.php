<?php

namespace MyApp;

require_once(__DIR__ . '/../../app/config.php');
require_once(__DIR__ . '/../../app/Utils.php');
require_once(__DIR__ . '/../../app/Database.php');
require_once(__DIR__ . '/../../app/admin/admin_valid.php');

use Exception;
use MyApp\Utils;
use MyApp\Database;
use MyApp\AdminValid;

$admin_id = $_GET['admin_id'];

if (!empty($_POST)) {
  $post = Utils::post_h($_POST);
}

if (!empty($post['btn_confirm'])) {
  $checkSt = true;
  list($checkSt, $err_msg) = AdminValid::delete_check($post);

  if ($checkSt) {
    header('Location: admin_delete_done.php?admin_id=' . $admin_id);
  }
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <title> 管理者削除 </title>
  <link rel="stylesheet" href="../css/style.css">
</head>

<body>

  <?php
  try {
    // Adminsテーブルのレコード取得
    $pdo = Database::getInstance();
    $sql = 'SELECT password, face_img FROM admins WHERE id = :id';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue('id', $admin_id, \PDO::PARAM_INT);
    $stmt->execute();
    $admin = $stmt->fetch();
    if (empty($admin)) {
      header('HTTP', true, 404);
      exit();
    }
  } catch (\PDOException $e) {
    echo $e->getMessage();
    exit();
  }
  ?>

  <div>
    <h1>管理者削除</h1>
    <h2>パスワードを入力してください</h2>
    <form action="" method="post">
      <div class="element_wrap">
        <label for="pass">パスワード</label>
        <input type="password" name="pass" class="password">
        <?php if (!empty($err_msg['pass'])) {
          echo '<br><p class="err_msg">' . $err_msg['pass'] . '</p>';
        }; ?>
      </div>
      <input type="hidden" name="db_pass" value="<?php echo $admin->password; ?>">
      <input type="hidden" name="face_img" value="<?php echo $admin->face_img; ?>">
      <input type="button" onclick="history.back()" value="戻る" name="btn_back">
      <input type="submit" value="削除する" name="btn_confirm">
    </form>
  </div>

</body>

</html>