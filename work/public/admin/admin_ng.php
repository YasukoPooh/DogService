<?php

namespace MyApp;

require_once(__DIR__ . '/../../app/CsrfValid.php');

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
  <title> 管理者一覧 </title>
</head>
<body>

  管理者が選択されていません。<br />
  <a href="admin_list.php">戻る</a>
  
</body>
</html>