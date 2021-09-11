<?php

if(isset($_POST['btn_disp']))
{
  if(!isset($_POST['admin_id']))
  {
    header('Location: admin_ng.php');
    exit();
  }
  $admin_id = $_POST['admin_id'];
  header('Location: admin_disp.php?admin_id=' .$admin_id);
  exit();
}

if(isset($_POST['btn_add']))
{
  header('Location: admin_add.php');
  exit();
}

if(isset($_POST['btn_edit']))
{
  if(!isset($_POST['admin_id']))
  {
    header('Location: admin_ng.php');
    exit();
  }
  $admin_id = $_POST['admin_id'];
  header('Location: admin_edit.php?admin_id=' .$admin_id);
  exit();
}

if(isset($_POST['btn_delete']))
{
  if(!isset($_POST['admin_id']))
  {
    header('Location: admin_ng.php');
    exit();
  }
  $admin_id = $_POST['admin_id'];
  header('Location: admin_delete.php?admin_id=' .$admin_id);
  exit();
}

?>