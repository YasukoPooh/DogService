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

if(isset($_POST['btn_disp']))
{
  if(!isset($_POST['product_id']))
  {
    header('Location: product_ng.php');
    exit();
  }
  $product_id = $_POST['product_id'];
  header('Location: product_disp.php?product_id=' . $product_id);
  exit();
}

if(isset($_POST['btn_add']))
{
  header('Location: product_add.php');
  exit();
}

if(isset($_POST['btn_edit']))
{
  if(!isset($_POST['product_id']))
  {
    header('Location: product_ng.php');
    exit();
  }
  $product_id = $_POST['product_id'];
  header('Location: product_edit.php?product_id=' . $product_id);
  exit();
}

if(isset($_POST['btn_delete']))
{
  if(!isset($_POST['product_id']))
  {
    header('Location: product_ng.php');
    exit();
  }
  $product_id = $_POST['product_id'];
  header('Location: product_delete_done.php?product_id=' . $product_id);
  exit();
}

?>