<?php

namespace MyApp;

require_once(__DIR__ . '/../../app/config.php');
require_once(__DIR__ . '/../../app/Utils.php');
require_once(__DIR__ . '/../../app/Database.php');
require_once(__DIR__ . '/../../app/product/product_valid.php');

use Exception;
use MyApp\Utils;
use MyApp\Database;
use MyApp\ProductValid;

$product_id = $_GET['product_id'];

$page_flag = 0; // 0 : 編集ページへ、1 : 確認ページへ
if(!empty($_POST))
{
  $post = Utils::post_h($_POST);
}

if(!empty($post['btn_confirm']))
{
  $checkSt = true;
  $image = $_FILES['image'];
  list($checkSt, $err_msg) = ProductValid::edit_check($post, $image);

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
  <title> 商品編集 </title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<?php
try
{
  // Productsテーブルのレコード取得
  $pdo = Database::getInstance();
  $sql = 'SELECT name, price, image, comment FROM products WHERE id = :id';
  $stmt = $pdo->prepare($sql);
  $stmt->bindValue('id', $product_id, \PDO::PARAM_INT);
  $stmt->execute();
  $product = $stmt->fetch();
  if(empty($product))
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
    <form action="./product_edit_done.php" method="post">
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
        <?php if(!empty($image['name'])): ?>
          <p><img src="<?php echo '../product/img/' . $image['name']; ?>"></p>
        <?php else: ?>
          <p><img src="<?php echo '../product/img/' . $post['old_image']; ?>"></p>
        <?php endif; ?>
      </div>
      <div class="element_wrap">
        <label for="comment">コメント</label>
        <p><?php echo nl2br($post['comment']); ?></p>
      </div>
      <input type="button" onclick="history.back()" value="戻る" name="btn_back">
      <input type="submit" value="確定" name="btn_edit">
      <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
      <input type="hidden" name="name" value="<?php echo $post['name']; ?>">
      <input type="hidden" name="price" value="<?php echo $post['price']; ?>">
      <?php if(!empty($image['name'])): ?>
        <input type="hidden" name="image" value="<?php echo $image['name']; ?>">
      <?php else: ?>
        <input type="hidden" name="image" value="<?php echo $post['old_image']; ?>">
      <?php endif; ?>
      <input type="hidden" name="comment" value="<?php echo $post['comment']; ?>">
    </form>
  </div>
<?php else: ?>
  <!-- 編集ページ -->
  <div>
    <h1>商品編集</h1>
    <form action="" method="post" enctype="multipart/form-data">
      <div class="element_wrap">
        <label for="name">商品名</label>
        <input type="text" name="name" class="productName" maxlength="30" value="<?php if(!empty($post['name'])){ echo $post['name'];} else { echo $product->name; }; ?>">
        <?php if(!empty($err_msg['name'])){ echo '<br><p class="err_msg">' . $err_msg['name'] . '</p>'; }; ?>
      </div>
      <div class="element_wrap">
        <label for="price">価格(税抜)</label>
        <input type="text" name="price" class="price" value="<?php if(!empty($post['price'])){ echo $post['price']; } else { echo $product->price;}; ?>">
        <?php if(!empty($err_msg['price'])){ echo '<br><p class="err_msg">' . $err_msg['price'] . '</p>'; }; ?>
      </div>
      <div class="element_wrap">
        <label for="image">写真</label>
        <input type="file" name="image">
        <p><img src="<?php echo '../product/img/' . $product->image; ?>"></p>
        <?php if(!empty($err_msg['image'])){ echo '<br><p class="err_msg">' . $err_msg['image'] . '</p>'; }; ?>
      </div>
      <div class="element_wrap">
        <label for="comment">コメント</label>
        <textarea name="comment"><?php if(!empty($post['comment'])){ echo $post['comment']; } else { echo $product->comment; }; ?></textarea>
        <?php if(!empty($err_msg['comment'])){ echo '<br><p class="err_msg">' . $err_msg['comment'] . '</p>'; }; ?>
      </div>
      <input type="hidden" name="old_image" value="<?php echo $product->image; ?>">
      <input type="button" onclick="history.back()" value="戻る" name="btn_back">
      <input type="submit" value="編集内容を確定する" name="btn_confirm">
    </form>
  </div>
<?php endif; ?>

</body>
</html>