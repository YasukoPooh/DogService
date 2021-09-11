<?php

namespace MyApp;

require_once(__DIR__ . '/../../app/valid_check.php');

use MyApp\ValidCheck;

class ProductValid
{
  public static function add_check($params, $image)
  {
    $checkErrMsg = array();
    $checkSt = true;

    // 商品名
    list($itemCheckSt, $err_msg) = ValidCheck::validProductName($params['name']);
    if(!$itemCheckSt)
    {
      $checkErrMsg['name'] = $err_msg;
      $checkSt = false;
    }

    // 価格
    list($itemCheckSt, $err_msg) = ValidCheck::validPrice($params['price']);
    if(!$itemCheckSt)
    {
      $checkErrMsg['price'] = $err_msg;
      $checkSt = false;
    }

    // コメント
    list($itemCheckSt, $err_msg) = ValidCheck::validComment($params['comment']);
    if(!$itemCheckSt)
    {
      $checkErrMsg['comment'] = $err_msg;
      $checkSt = false;
    }

    // 写真
    list($itemCheckSt, $err_msg) = ValidCheck::validImage($image);
    if(!$itemCheckSt)
    {
      $checkErrMsg['image'] = $err_msg;
      $checkSt = false;
    }
    else
    {
      if($checkSt)
      {
        move_uploaded_file($image['tmp_name'], '../../public/product/img/' . $image['name']);
      }
    }

    return [$checkSt, $checkErrMsg];
  }

  public static function edit_check($params, $image)
  {
    $checkErrMsg = array();
    $checkSt = true;

    // 商品名
    list($itemCheckSt, $err_msg) = ValidCheck::validProductName($params['name']);
    if(!$itemCheckSt)
    {
      $checkErrMsg['name'] = $err_msg;
      $checkSt = false;
    }

    // 価格
    list($itemCheckSt, $err_msg) = ValidCheck::validPrice($params['price']);
    if(!$itemCheckSt)
    {
      $checkErrMsg['price'] = $err_msg;
      $checkSt = false;
    }

    // コメント
    list($itemCheckSt, $err_msg) = ValidCheck::validComment($params['comment']);
    if(!$itemCheckSt)
    {
      $checkErrMsg['comment'] = $err_msg;
      $checkSt = false;
    }

    // 写真
    list($itemCheckSt, $err_msg) = ValidCheck::validEditImage($image);
    if(!$itemCheckSt)
    {
      $checkErrMsg['image'] = $err_msg;
      $checkSt = false;
    }
    if($checkSt && !empty($image['name']) && $params['old_image'] !== $image['name'])
    {
      unlink('../../public/product/img/' . $params['old_image']);
      move_uploaded_file($image['tmp_name'], '../../public/product/img/' . $image['name']);
    }

    return [$checkSt, $checkErrMsg];
  }
}
?>