<?php

namespace MyApp;

require_once(__DIR__ . '/../../app/config.php');
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
  <title> 管理者一覧 </title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>
  
<?php
try
{
  // Adminsテーブルのレコード取得
  $pdo = Database::getInstance();
  $sql = 'SELECT id, login_id, officer FROM admins';
  $stmt = $pdo->prepare($sql);
  $stmt->execute();
  $admins = $stmt->fetchAll();
}
catch (\PDOException $e)
{
  echo $e->getMessage();
  exit();
}
?>

<div>
  <h1>管理者一覧</h1>
  <form action="admin_branch.php" method="post">
    <div class="admin_list">
      <table class="admin_table admin_fixhead_table">
        <thead>
          <tr>
            <th>操作</th>
            <th>id</th>
            <th>ログインID</th>
            <th>役職</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($admins as $admin): ?>
            <tr>
              <td><input type="checkbox" name="admin_check"></td>
              <td><input type="hidden" name="admin_id"><?php echo Utils::h($admin->id); ?></td>
              <td><?php echo Utils::h($admin->login_id); ?></td>
              <td>
                <?php
                  switch(Utils::h($admin->officer))
                  {
                    case 1:
                      echo '店長';
                      break;
                    case 2:
                      echo 'スタッフ';
                      break;
                    case 3:
                      echo '医者';
                      break;
                    default:
                      echo '不明';
                      break;
                  }
                ?>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <input type="submit" name="btn_disp" value="参照">
    <input type="submit" name="btn_add" value="追加">
    <input type="submit" name="btn_edit" value="編集">
    <input type="submit" name="btn_delete" value="削除">
  </form>
</div>

<br /><br />
<a href="../admin/admin_top.php">トップメニューへ</a>

</body>
</html>