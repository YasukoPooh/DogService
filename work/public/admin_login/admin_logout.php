<?php

namespace MyApp;

require_once(__DIR__ . '/../../app/CsrfValid.php');

use MyApp\CsrfValid;

session_start();
CsrfValid::destroy();
session_destroy();

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title> 管理者ログアウト </title>
  <link rel="stylesheet" href="../css/style.css">
  <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
  <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
</head>
<body>
  <div class="login">
    <p class="sign" align="center">管理者ログアウト</p>
    <p>ログアウトしました。</p>
    <a href="../admin_login/admin_login.php">ログインページへ</a>
  </div>
  
</body>
</html>