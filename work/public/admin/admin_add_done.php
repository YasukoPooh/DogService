<?php

namespace MyApp;

require_once(__DIR__ . '/../../app/Utils.php');
require_once(__DIR__ . '/../../app/Database.php');
require_once(__DIR__ . '/../../app/CsrfValid.php');
require_once(__DIR__ . '/../../app/admin/admin_utils.php');

use Exception;
use MyApp\Utils;
use MyApp\Database;
use MyApp\CsrfValid;
use MyApp\AdminUtils;

session_start();
session_regenerate_id(true);
$valid = CsrfValid::validate();
if(!$valid)
{
  echo '<p class="err_msg">ログインされていません。</p>';
  echo '<a href="../admin_login/admin_login.php">ログインページへ</a>';
  exit();
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title> 管理者追加完了 </title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<?php

$post = Utils::post_h($_POST);

// テーブル追加用に値を変換
$pass = password_hash($post['pass'], PASSWORD_BCRYPT);
$sex = AdminUtils::sexValueToDb($post['sex']);
$officer = AdminUtils::officerValueToDb($post['officer']);

// ファイル名取得
$faceImgName = $post['face_img'];

try{
  // Adminsテーブルへレコード挿入
  $pdo = Database::getInstance();
  $sql = 'INSERT INTO admins (login_id, password, name, email, sex, officer, profile, birth, face_img) VALUES (:login_id, :password, :name, :email, :sex, :officer, :profile, :birth, :face_img)';
  $stmt = $pdo->prepare($sql);
  $stmt->bindValue('login_id', $post['login_id'], \PDO::PARAM_INT);
  $stmt->bindValue('password', $pass, \PDO::PARAM_STR);
  $stmt->bindValue('name', $post['name'], \PDO::PARAM_STR);
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

  // echo $post['login_id'] . 'さんを追加しました。' . PHP_EOL;
}
catch (\PDOException $e)
{
  echo $e->getMessage();
  exit();
}

?>
  
  <p class="message"><?php echo $post['login_id']; ?>さんを追加しました。</p>
  <a href="admin_list.php">戻る</a>
</body>
</html>