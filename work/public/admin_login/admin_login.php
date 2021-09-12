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

$page_flag = 0; // 0 : ログインページへ、1 : ログイン完了ページへ

if(!empty($_POST))
{
  $post = Utils::post_h($_POST);
}

if(!empty($_POST['btn_login']))
{
  $checkSt = true;
  $err_msg = array();
  try
  {
    $pdo = Database::getInstance();
    $sql = 'SELECT password FROM admins WHERE login_id = :login_id';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue('login_id', $post['login_id'], \PDO::PARAM_INT);
    $stmt->execute();
    $admin = $stmt->fetch();
    if(empty($admin))
    {
      $err_msg['login_id'] = 'ログインIDが不正です';
      $checkSt = false;
    }
    else
    {
      list($checkSt, $err_msg) = AdminValid::login_check($post);
    }
  }
  catch (\PDOException $e)
  {
    echo $e->getMessage();
    exit();
  }

  if($checkSt)
  {
    $page_flag = 1;
  }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title> 管理者ログイン </title>
  <link rel="stylesheet" href="../css/style.css">
  <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
  <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
</head>
<body>
  <?php if(1 === $page_flag): ?>
    <!-- ログイン完了ページへ -->
    <?php header('Location: admin_top.html'); ?>
  <?php else: ?>
    <!-- ログインページへ -->
    <div class="login">
      <p class="sign" align="center">管理者ログイン</p>
      <form class="admin_login" action="" method="post">
        <?php if(!empty($err_msg['login_id'])){ echo '<br><p class="err_msg">' . $err_msg['login_id'] . '</p>'; }; ?>
        <input class="sign_login_id" type="text" name="login_id" align="center" placeholder="Loginid">
        <br />
        <?php if(!empty($err_msg['pass'])){ echo '<br><p class="err_msg">' . $err_msg['pass'] . '</p>'; }; ?>
        <input class="sign_pass" type="password" name="pass" align="center" placeholder="Password">
        <input type="submit" name="btn_login" value="Sign in">
        <input type="hidden" name="db_pass" value="<?php echo $admin->password; ?>">
      </form>
    </div>
  <?php endif; ?>

</body>
</html>