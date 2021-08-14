<?php

namespace MyApp;

  require_once(__DIR__ . '/../../app/config.php');
  require_once(__DIR__ . '/../../app/Utils.php');
  require_once(__DIR__ . '/../../app/admin/admin_add_valid.php');

  use MyApp\Utils;
  use MyApp\AdminAddValid;

  $page_flag = 0; // 0 : 入力ページへ、1 : 確認ページへ、2 : 完了ページへ
  if(!empty($_POST)){
    $post = Utils::post_h($_POST);
  }

  if(!empty($_POST['btn_confirm']))
  {
    $checkSt = true;
    list($checkSt, $err_msg) = AdminAddValid::check($post);

    if($checkSt)
    {
      $page_flag = 1;
    }
  }
  else if(!empty($_POST['btn_add']))
  {
    $page_flag = 2;
  }

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title> 管理者追加 </title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>
  
  <?php if(1 === $page_flag): ?>
    <!-- 確認ページ -->
    <div>
      <h1>内容確認</h1>
      <form action="../../app/admin/admin_add_done.php" method="post">
        <div class="element_wrap">
          <label for="login_id">ログインID</label>
          <p><?php echo $post['login_id']; ?></p>
        </div>
        <div class="element_wrap">
          <label for="pass">パスワード</label>
          <p><?php echo $post['pass']; ?></p>
        </div>
        <div class="element_wrap">
          <label for="pass2">パスワード再入力</label>
          <p><?php echo $post['pass2']; ?></p>
        </div>
        <div class="element_wrap">
          <label for="email">メールアドレス</label>
          <p><?php echo $post['email']; ?></p>
        </div>
        <div class="element_wrap">
          <label for="sex">性別</label>
          <p><?php if("male" === $post['sex']){ echo '男性'; } else { echo '女性'; } ?></p>
        </div>
        <div class="element_wrap">
          <label for="officer">役職</label>
          <p><?php if("manager" === $post['officer']){ echo '店長'; }
          elseif("staff" === $post['officer']){ echo 'スタッフ'; }
          elseif("doctor" === $post['officer']){ echo '店長'; } ?></p>
        </div>
        <div class="element_wrap">
          <label for="profile">プロフィール</label>
          <p><?php echo nl2br($post['profile']); ?></p>
        </div>
        <div class="element_wrap">
          <label for="birth">生年月日</label>
          <p><?php echo $post['birth']; ?></p>
        </div>
        <?php if(!empty($post['face_img'])): ?>
          <div class="element_wrap">
            <label for="face_img">顔写真</label>
            <p><img src="<?php echo ADMIN_IMG_DIR.$post['face_img']; ?>"></p>
          </div>
        <?php endif; ?>
        <input type="submit" value="戻る" name="btn_back">
        <input type="submit" value="追加" name="btn_add">
        <input type="hidden" name="login_id" value="<?php echo $post['login_id']; ?>">
        <input type="hidden" name="pass" value="<?php echo $post['pass']; ?>">
        <input type="hidden" name="email" value="<?php echo $post['email']; ?>">
        <input type="hidden" name="sex" value="<?php echo $post['sex'] ?>">
        <input type="hidden" name="officer" value="<?php echo $post['officer']; ?>">
        <input type="hidden" name="profile" value="<?php echo $post['profile']; ?>">
        <input type="hidden" name="birth" value="<?php echo $post['birth']; ?>">
        <?php if(!empty($post['face_img'])): ?>
          <input type="hidden" name="face_img" value="<?php echo $post['face_img']; ?>">
        <?php endif; ?>
      </form>
    </div>
  <?php elseif(2 === $page_flag): ?>
  <!-- 追加実行 -->
  <?php else: ?>
  <!-- 入力ページ -->
    <div>
      <h1>管理者追加</h1>
      <form action="" method="post" enctype="multipart/form-data">
        <!-- <p>※ログインID・パスワードは、半角英数字8文字以上20文字以下で設定してください。</p> -->
        <div class="element_wrap">
          <label for="login_id">ログインID</label>
          <input type="text" name="login_id" class="adminLoginId" maxlength="20" value="<?php if(!empty($post['login_id'])){ echo $post['login_id'];} ?>">
          <?php if(!empty($err_msg['login_id'])){ echo '<br><p class="err_msg">' . $err_msg['login_id'] . '</p>'; } ?>
        </div>
        <div class="element_wrap">
          <label for="pass">パスワード</label>
          <input type="password" name="pass" class="password">
          <?php if(!empty($err_msg['pass'])){ echo '<br><p class="err_msg">' . $err_msg['pass'] . '</p>'; } ?>
        </div>
        <div class="element_wrap">
          <label for="pass2">パスワード再入力</label>
          <input type="password" name="pass2" class="password">
          <?php if(!empty($err_msg['pass2'])){ echo '<br><p class="err_msg">' . $err_msg['pass2'] . '</p>'; } ?>
        </div>
        <div class="element_wrap">
          <label for="email">メールアドレス</label>
          <input type="text" name="email" class="email" style="width: 200px;" value="<?php if(!empty($post['email'])){ echo $post['email'];} ?>">
          <?php if(!empty($err_msg['email'])){ echo '<br><p class="err_msg">' . $err_msg['email'] . '</p>'; } ?>
        </div>
        <div class="element_wrap">
          <label for="sex">性別</label>
          <label for="sex_male"><input type="radio" name="sex" id="sex_male" value="male" <?php if(!empty($post['sex']) && "male" === $post['sex']){ echo 'checked'; } else { echo 'checked'; } ?>>男性</label>
          <label for="sex_female"><input type="radio" name="sex" id="sex_female" value="female" <?php if(!empty($post['sex']) && "female" === $post['sex']){ echo 'checked'; } ?>>女性</label>
          <?php if(!empty($err_msg['sex'])){ echo '<br><p class="err_msg">' . $err_msg['sex'] . '</p>'; } ?>
        </div>
        <div class="element_wrap">
          <label for="officer">役職</label>
          <select name="officer">
            <option value="none">選択してください</option>
            <option value="manager" <?php if(!empty($post['officer']) && "manager" === $post['officer']){ echo 'checked'; } ?>>店長</option>
            <option value="staff" <?php if(!empty($post['officer']) && "staff" === $post['officer']){ echo 'checked'; } ?>>スタッフ</option>
            <option value="doctor" <?php if(!empty($post['officer']) && "doctor" === $post['officer']){ echo 'checked'; } ?>>医者</option>
          </select>
          <?php if(!empty($err_msg['officer'])){ echo '<br><p class="err_msg">' . $err_msg['officer'] . '</p>'; } ?>
        </div>
        <div class="element_wrap">
          <label for="profile">プロフィール</label>
          <textarea name="profile"><?php if(!empty($post['profile'])){ echo $post['profile']; } ?></textarea>
          <?php if(!empty($err_msg['profile'])){ echo '<br><p class="err_msg">' . $err_msg['profile'] . '</p>'; } ?>
        </div>
        <div class="element_wrap">
          <label for="birth">生年月日</label>
          <input type="date" name="birth" value="<?php if(!empty($post['birth'])){ echo $post['birth'];} ?>">
          <?php if(!empty($err_msg['birth'])){ echo '<br><p class="err_msg">' . $err_msg['birth'] . '</p>'; } ?>
        </div>
        <div class="element_wrap">
          <label for="face_img">顔写真</label>
          <input type="file" name="face_img">
          <?php if(!empty($err_msg['face_img'])){ echo '<br><p class="err_msg">' . $err_msg['face_img'] . '</p>'; } ?>
        </div>
        <input type="button" onclick="history.back()" value="戻る" name="btn_back">
        <input type="submit" value="入力内容を確認する" name="btn_confirm">
      </form>
    </div>
  <?php endif; ?>

  <!-- <script src="admin_check.js"></script> -->
</body>
</html>