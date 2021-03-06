<?php

namespace MyApp;

require_once(__DIR__ . '/../../app/config.php');
require_once(__DIR__ . '/../../app/Utils.php');
require_once(__DIR__ . '/../../app/Database.php');
require_once(__DIR__ . '/../../app/CsrfValid.php');
require_once(__DIR__ . '/../../app/admin/admin_valid.php');
require_once(__DIR__ . '/../../app/admin/admin_utils.php');

use Exception;
use MyApp\Utils;
use MyApp\Database;
use MyApp\CsrfValid;
use MyApp\AdminValid;
use MyApp\AdminUtils;

session_start();
session_regenerate_id(true);
$valid = CsrfValid::validate();
if(!$valid)
{
  echo '<p class="err_msg">ログインされていません。</p>';
  echo '<a href="../admin_login/admin_login.php">ログイン画面へ</a>';
  exit();
}

$admin_id = $_GET['admin_id'];

$page_flag = 0; // 0 : 編集ページへ、1 : 確認ページへ
if(!empty($_POST))
{
  $post = Utils::post_h($_POST);
}

if(!empty($post['btn_confirm']))
{
  $checkSt = true;
  $faceImg = $_FILES['face_img'];
  list($checkSt, $err_msg) = AdminValid::edit_check($post, $faceImg);

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
  <title> 管理者編集 </title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<?php
try
{
  // Adminsテーブルのレコード取得
  $pdo = Database::getInstance();
  $sql = 'SELECT login_id, password, name, email, sex, officer, profile, birth, face_img FROM admins WHERE id = :id';
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

<?php if(1 === $page_flag): ?>
  <!-- 確認ページ -->
  <div>
    <h1>編集内容確認</h1>
    <form action="./admin_edit_done.php" method="post">
      <div class="element_wrap">
        <label for="login_id">ログインID</label>
        <p><?php echo $post['login_id']; ?></p>
      </div>
      <div class="element_wrap">
        <label for="pass">パスワード</label>
        <p><?php echo $post['pass']; ?></p>
      </div>
      <div class="element_wrap">
        <label for="name">名前</label>
        <p><?php echo $post['name']; ?></p>
      </div>
      <div class="element_wrap">
        <label for="email">メールアドレス</label>
        <p><?php echo $post['email']; ?></p>
      </div>
      <div class="element_wrap">
        <label for="sex">性別</label>
        <p><?php echo AdminUtils::sexValueToName($post['sex']); ?></p>
      </div>
      <div class="element_wrap">
        <label for="officer">役職</label>
        <p><?php echo AdminUtils::officerValueToName($post['officer']); ?></p>
      </div>
      <div class="element_wrap">
        <label for="profile">プロフィール</label>
        <p><?php echo nl2br($post['profile']); ?></p>
      </div>
      <div class="element_wrap">
        <label for="birth">生年月日</label>
        <p><?php echo $post['birth']; ?></p>
      </div>
      <div class="element_wrap">
        <label for="face_img">顔写真</label>
        <?php if(!empty($faceImg['name'])): ?>
          <p><img src="<?php echo '../admin/img/' . $faceImg['name']; ?>"></p>
        <?php else: ?>
          <p><img src="<?php echo '../admin/img/' . $post['old_face_img']; ?>"></p>
        <?php endif; ?>
      </div>
      <input type="button" onclick="history.back()" value="戻る" name="btn_back">
      <input type="submit" value="確定" name="btn_edit">
      <input type="hidden" name="admin_id" value="<?php echo $admin_id; ?>">
      <input type="hidden" name="login_id" value="<?php echo $post['login_id']; ?>">
      <input type="hidden" name="name" value="<?php echo $post['name']; ?>">
      <input type="hidden" name="email" value="<?php echo $post['email']; ?>">
      <input type="hidden" name="sex" value="<?php echo $post['sex']; ?>">
      <input type="hidden" name="officer" value="<?php echo $post['officer']; ?>">
      <input type="hidden" name="profile" value="<?php echo $post['profile']; ?>">
      <input type="hidden" name="birth" value="<?php echo $post['birth']; ?>">
      <?php if(!empty($faceImg['name'])): ?>
        <input type="hidden" name="face_img" value="<?php echo $faceImg['name']; ?>">
      <?php else: ?>
        <input type="hidden" name="face_img" value="<?php echo $post['old_face_img']; ?>">
      <?php endif; ?>
    </form>
  </div> 
<?php else: ?>
  <!-- 編集ページ -->
  <div>
    <h1>管理者編集</h1>
    <form action="" method="post" enctype="multipart/form-data">
      <div class="element_wrap">
        <label for="login_id">ログインID</label>
        <input type="text" name="login_id" class="login_id" maxlength="20" value="<?php if(!empty($post['login_id'])){ echo $post['login_id'];} else {echo $admin->login_id;}; ?>">
        <?php if(!empty($err_msg['login_id'])){ echo '<br><p class="err_msg">' . $err_msg['login_id'] .  '</p>'; } ?>
      </div>
      <div class="element_wrap">
        <label for="pass">パスワード</label>
        <input type="password" name="pass" class="password">
        <?php if(!empty($err_msg['pass'])){ echo '<br><p class="err_msg">' . $err_msg['pass'] . '</p>'; } ?>
      </div>
      <div class="element_wrap">
        <label for="name">名前</label>
        <input type="text" name="name" class="name" value="<?php if(!empty($post['name'])){ echo $post['name']; } else { echo $admin->name; }; ?>">
        <?php if(!empty($err_msg['name'])){ echo '<br><p class="err_msg">' . $err_msg['name'] . '</p>'; }; ?>
      </div>
      <div class="element_wrap">
        <label for="email">メールアドレス</label>
        <input type="text" name="email" class="email" style="width: 200px;" value="<?php if(!empty($post['email'])){ echo $post['email'];} else { echo $admin->email;} ?>">
        <?php if(!empty($err_msg['email'])){ echo '<br><p class="err_msg">' . $err_msg['email'] . '/<p>'; } ?>
      </div>
      <div class="element_wrap">
        <label for="sex">性別</label>
        <label for="sex_male"><input type="radio" name="sex" id="sex_male" value="male" <?php if(!empty($post['sex']) && AdminUtils::isSexValueMale($post['sex'])){ echo 'checked'; } elseif(empty($post['sex']) && AdminUtils::isSexDbMale($admin->sex)){ echo 'checked'; }; ?>>男性</label>
        <label for="sex_female"><input type="radio" name="sex" id="sex_female" value="female" <?php if(!empty($post['sex']) && AdminUtils::isSexValueFemale($post['sex'])){ echo 'checked'; } elseif(empty($post['sex']) && AdminUtils::isSexDbFemale($admin->sex)){ echo 'checked'; }; ?>>女性</label>
        <?php if(!empty($err_msg['sex'])){ echo '<br><p class="err_msg">' . $err_msg['sex'] . '</p>'; } ?>
      </div>
      <div class="element_wrap">
        <label for="officer">役職</label>
        <select name="officer">
          <option value="manager" <?php if(!empty($post['officer']) && AdminUtils::isOfficerValueManager($post['officer'])){ echo 'selected'; } elseif(empty($post['officer']) && AdminUtils::isOfficerDbManager($admin->officer)){ echo 'selected'; }; ?>>店長</option>
          <option value="staff" <?php if(!empty($post['officer']) && AdminUtils::isOfficerValueStaff($post['officer'])){ echo 'selected'; } elseif(empty($post['officer']) && AdminUtils::isOfficerDbStaff($admin->officer)){ echo 'selected'; }; ?>>スタッフ</option>
          <option value="doctor" <?php if(!empty($post['officer']) && AdminUtils::isOfficerValueDoctor($post['officer'])){ echo 'selected'; } elseif(empty($post['officer']) && AdminUtils::isOfficerDbDoctor($admin->officer)){ echo 'selected'; }; ?>>医者</option>
        </select>
        <?php if(!empty($err_msg['officer'])){ echo '<br><p class="err_msg">' . $err_msg['officer'] . '</p>'; } ?>
      </div>
      <div class="element_wrap">
        <label for="profile">プロフィール</label>
        <textarea name="profile"><?php if(!empty($post['profile'])){ echo $post['profile']; } else { echo $admin->profile;} ?></textarea>
        <?php if(!empty($err_msg['profile'])){ echo '<br><p class="err_msg">' . $err_msg['profile'] . '</p>'; } ?>
      </div>
      <div class="element_wrap">
        <label for="birth">生年月日</label>
        <input type="date" name="birth" value="<?php if(!empty($post['birth'])){ echo $post['birth']; } else { echo $admin->birth;} ?>">
        <?php if(!empty($err_msg['birth'])){ echo '<br><p class="err_msg">' . $err_msg['birth'] . '</p>'; } ?>
      </div>
      <div class="element_wrap">
        <label for="face_img">顔写真</label>
        <input type="file" name="face_img">
        <p><img src="<?php echo '../admin/img/' . $admin->face_img; ?>"></p>
        <?php if(!empty($err_msg['face_img'])){ echo '<br><p class="err_msg">' . $err_msg['face_img'] . '</p>'; } ?>
      </div>
      <input type="hidden" name="db_pass" value="<?php echo $admin->password; ?>">
      <input type="hidden" name="old_face_img" value="<?php echo $admin->face_img; ?>">
      <input type="button" onclick="history.back()" value="戻る" name="btn_back">
      <input type="submit" value="編集内容を確定する" name="btn_confirm">
    </form>
  </div>
<?php endif; ?>
  
</body>
</html>