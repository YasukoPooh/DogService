<?php

namespace MyApp;

require_once(__DIR__ . '/../../app/Utils.php');
require_once(__DIR__ . '/../../app/CsrfValid.php');

use MyApp\Utils;
use MyApp\CsrfValid;

session_start();
session_regenerate_id(true);
$valid = CsrfValid::validate();

?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title> 管理者トップページ </title>
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Ubuntu">
  <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
</head>
<body>
  <div class="admin_top">
    <p class="admin_top">管理者トップページ</p>
    <?php if($valid): ?>
      <form action="admin_top_branch.php" method="post">
        <input type="submit" name="btn_admin" value="管理者一覧">
        <input type="submit" name="btn_product" value="商品一覧">
        <br />
        <br />
        <br />
        <input type="submit" name="btn_logout" value="ログアウト">
      </form>
    <?php else: ?>
      <p>ログインされていません。</p>
      <a href="../admin_login/admin_login.php">ログインページ</a>
    <?php endif; ?>
  </div>
</body>
</html>