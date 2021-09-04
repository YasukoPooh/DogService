<?php

namespace MyApp;

require_once(__DIR__ . '/../../app/config.php');
require_once(__DIR__ . '/../../app/Utils.php');
require_once(__DIR__ . '/../../app/Database.php');

use Exception;
use MyApp\Utils;
use MyApp\Database;

$admin_id = $_GET['admin_id'];

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title> 管理者参照 </title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>
  
<?php
try
{
  // Adminsテーブルのレコード取得
  $pdo = Database::getInstance();
  $sql = 'SELECT login_id, email, sex, officer, profile, birth, face_img FROM admins WHERE id = :id';
  $stmt = $pdo->prepare($sql);
  $stmt->bindValue('id', $admin_id, \PDO::PARAM_INT);
  $stmt->execute();
  $admin = $stmt->fetch();
  if(empty($admin))
  {
    header('HTTP', true, 404);
    exit();
  }
}
catch (\PDOException $e)
{
  echo $e->getMessage();
  exit();
}
?>

<div>
  <h1>管理者参照</h1>
  <div class="element_wrap">
    <label for="login_id">ログインID</label>
    <p><?php echo $admin->login_id; ?></p>
  </div>
  <div class="element_wrap">
    <label for="email">メールアドレス</label>
    <p><?php echo $admin->email; ?></p>
  </div>
  <div class="element_wrap">
    <label for="sex">性別</label>
    <p><?php if(1 === $admin->sex){ echo '男性'; } else { echo '女性'; }; ?></p>
  </div>
  <div class="element_wrap">
    <label for="officer">役職</label>
    <p><?php if(1 === $admin->officer){ echo '店長'; } elseif(2 === $admin->officer){ echo 'スタッフ'; } elseif(3 === $admin->officer){ echo '医者'; }; ?></p>
  </div>
  <div class="element_wrap">
    <label for="profile">プロフィール</label>
    <p><?php echo $admin->profile; ?></p>
  </div>
  <div class="element_wrap">
    <label for="birth">生年月日</label>
    <p><?php echo $admin->birth; ?></p>
  </div>
  <div class="element_wrap">
    <label for="face_img">顔写真</label>
    <p><img src="<?php echo '../admin/img/' . $admin->face_img; ?>" alt=""></p>
  </div>
  <input type="button" onclick="history.back()" value="戻る" name="btn_back">
</div>

</body>
</html>