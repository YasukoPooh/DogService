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
  <title> 管理者編集完了 </title>
</head>
<body>

<?php

$post = Utils::post_h($_POST);

// テーブル更新用に値を置換
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
else if("staff" === $post['officer'])
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
  // Adminsテーブルのレコード更新
  $pdo = Database::getInstance();
  $sql = 'UPDATE admins SET login_id = :login_id, email = :email, sex = :sex, officer = :officer, profile = :profile, birth = :birth, face_img = :face_img WHERE id = :id';
  $stmt = $pdo->prepare($sql);
  $stmt->bindValue('login_id', $post['login_id'], \PDO::PARAM_INT);
  $stmt->bindValue('email', $post['email'], \PDO::PARAM_STR);
  $stmt->bindValue('sex', $sex, \PDO::PARAM_INT);
  $stmt->bindValue('officer', $officer, \PDO::PARAM_INT);
  $stmt->bindValue('profile', $post['profile'], \PDO::PARAM_STR);
  $stmt->bindValue('birth', $post['birth'], \PDO::PARAM_STR);
  $stmt->bindValue('face_img', $faceImgName, \PDO::PARAM_STR);
  $stmt->bindValue('id', $post['admin_id'], \PDO::PARAM_INT);
  $stmt->execute();

  echo '編集完了しました' . PHP_EOL;
}
catch (\PDOException $e)
{
  echo $e->getMessage();
  exit();
}

?>
  
  <a href="admin_list.php">戻る</a>
</body>
</html>