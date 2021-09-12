<?php

namespace Myapp;

require_once(__DIR__ . '/../../app/config.php');
require_once(__DIR__ . '/../../app/Utils.php');
require_once(__DIR__ . '/../../app/product/product_valid.php');

use MyApp\Utils;
use MyApp\ProductValid;

$page_flag = 0; // 0 : 入力ページへ、1 : 確認ページへ
if(!empty($_POST))
{
  $post = Utils::post_h($_POST);
}

if(!empty($_POST['btn_confirm']))
{
  $checkSt = true;
  $Image = $_FILES['image'];
  list($checkSt, $err_msg) = ProductValid::add_check($post, $Image);

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
  <title> 商品追加 </title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<?php if(1 === $page_flag): ?>
  <!-- 確認ページ -->
  <div>
    <h1>内容確認</h1>
    <form action="./product_add_done.php" method="post">
      <div class="element_wrap">
        <label for="name">商品名</label>
        <p><?php echo $post['name']; ?></p>
      </div>
      <div class="element_wrap">
        <label for="price">価格(税抜)</label>
        <p><?php echo $post['price']; ?></p>
      </div>
      <div class="element_wrap">
        <label for="image">写真</label>
        <p><img src="<?php echo '../product/img/' . $Image['name']; ?>" alt=""></p>
      </div>
      <div class="element_wrap">
        <label for="comment">コメント</label>
        <p><?php echo nl2br($post['comment']); ?></p>
      </div>
      <input type="button" onclick="history.back()" value="戻る" name="btn_back">
      <input type="submit" value="追加" name="btn_add">
      <input type="hidden" name="name" value="<?php echo $post['name']; ?>">
      <input type="hidden" name="price" value="<?php echo $post['price']; ?>">
      <input type="hidden" name="image" value="<?php echo $Image['name']; ?>">
      <input type="hidden" name="comment" value="<?php echo $post['comment']; ?>">
    </form>
  </div>
<?php else: ?>
  <!-- 入力ページ -->
  <div>
    <h1>商品追加</h1>
    <form action="" method="POST" enctype="multipart/form-data">
      <div class="element_wrap">
        <label for="name">商品名</label>
        <input type="text" name="name" class="name" maxlength="30" value="<?php if(!empty($post['name'])){ echo $post['name']; } ?>">
        <?php if(!empty($err_msg['name'])){ echo '<br><p class="err_msg">' . $err_msg['name'] . '</p>'; }; ?>
      </div>
      <div class="element_wrap">
        <label for="price">価格(税抜)</label>
        <input type="text" name="price" class="price" value="<?php if(!empty($post['price'])){ echo $post['price']; }; ?>">
        <?php if(!empty($err_msg['price'])){ echo '<br><p class="err_msg">' . $err_msg['price'] . '</p>'; }; ?>
      </div>
      <div class="element_wrap">
        <label for="image">写真</label>
        <input type="file" name="image" value="<?php if(!empty($post['image'])){ echo $post['image']; }; ?>">
        <?php if(!empty($err_msg['image'])){ echo '<br><p class="err_msg">' . $err_msg['image'] . '</p>'; }; ?>
      </div>
      <div class="element_wrap">
        <label for="comment">コメント</label>
        <textarea name="comment"><?php if(!empty($post['comment'])){ echo $post['comment']; }; ?></textarea>
        <?php if(!empty($err_msg['comment'])){ echo '<br><p class="err_msg">' . $err_msg['comment'] . '</p>'; }; ?>
      </div>
      <input type="button" onclick="history.back()" value="戻る" name="btn_back">
      <input type="submit" value="入力内容を確認する" name="btn_confirm">
    </form>
  </div>
<?php endif; ?>

</body>
</html>