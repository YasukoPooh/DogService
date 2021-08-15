<?php

namespace MyApp;

require_once(__DIR__ . '/../../app/Utils.php');
require_once(__DIR__ . '/../../app/Database.php');

use Exception;
use MyApp\Utils;
use MyApp\Database;

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title> 管理者追加完了 </title>
</head>
<body>

<?php

$post = Utils::post_h($_POST);

// テーブル追加用に値を変換
$pass = password_hash($post['pass'], PASSWORD_BCRYPT);
if("male" === $post['sex'])
{
  $sex = 1;
}
else
{
  $sex = 2;
}
if("manager" === $post['officer'])
{
  $officer = 1;
}
else if("staff")
{
  $officer = 2;
}
else
{
  $officer = 3;
}

// ファイル名取得
$faceImgName = $post['face_img'];

try{
  // Adminsテーブルへレコード挿入
  $pdo = Database::getInstance();
  $sql = 'INSERT INTO admins (login_id, password, email, sex, officer, profile, birth, face_img) VALUES (:login_id, :password, :email, :sex, :officer, :profile, :birth, :face_img)';
  $stmt = $pdo->prepare($sql);
  $stmt->bindValue('login_id', $post['login_id'], \PDO::PARAM_INT);
  $stmt->bindValue('password', $pass, \PDO::PARAM_STR);
  $stmt->bindValue('email', $post['email'], \PDO::PARAM_STR);
  $stmt->bindValue('sex', $sex, \PDO::PARAM_INT);
  $stmt->bindValue('officer', $officer, \PDO::PARAM_INT);
  $stmt->bindValue('profile', $post['profile'], \PDO::PARAM_STR);
  // $stmt->bindValue('birth', date_format($post['birth'], 'Y-m-d'), \PDO::PARAM_STR);
  $stmt->bindValue('birth', $post['birth'], \PDO::PARAM_STR);
  $stmt->bindValue('face_img', $faceImgName, \PDO::PARAM_STR);
  $stmt->execute();
  
  // Adminsテーブルの id を取得
  $adminId = $pdo->lastInsertId();

  echo $post['login_id'] . 'を追加しました。' . PHP_EOL;
}
catch (\PDOException $e)
{
  echo $e->getMessage();
  exit();
}

?>
  
  <input type="button" onclick="history.back()" value="戻る" name="btn_back">
  <!-- <a href="admin_list.php">戻る</a> -->
</body>
</html>