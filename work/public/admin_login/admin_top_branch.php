<?php

require_once(__DIR__ . '/../../app/CsrfValid.php');

use MyApp\CsrfValid;

session_start();
session_regenerate_id(true);
var_dump($_SESSION);
$valid = CsrfValid::validate();
if(!$valid)
{
  echo '<p class="err_msg">ログインされていません。</p>';
  echo '<a href="../admin_login/admin_login.php">ログイン画面へ</a>';
  exit();
}

if(isset($_POST['btn_admin']))
{
  header('Location: ../admin/admin_list.php');
  exit();
}

if(isset($_POST['btn_product']))
{
  header('Location: ../product/product_list.php');
  exit();
}

if(isset($_POST['btn_logout']))
{
  header('Location: admin_logout.php');
  exit();
}
?>