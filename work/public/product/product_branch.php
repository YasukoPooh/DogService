<?php

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