<?php

namespace MyApp;

require_once(__DIR__ . '/../../app/valid_check.php');

use MyApp\ValidCheck;

class AdminValid
{
  public static function add_check($params, $faceImg)
  {
    $checkErrMsg = array();
    $checkSt = true;

    // ログインID
    list($itemCheckSt, $err_msg) = ValidCheck::validLoginId($params['login_id']);
    if(!$itemCheckSt)
    {
      $checkErrMsg['login_id'] = $err_msg;
      $checkSt = false;
    }

    // パスワード
    list($itemCheckSt, $err_msg) = ValidCheck::validPassword($params['pass']);
    if(!$itemCheckSt)
    {
      $checkErrMsg['pass'] = $err_msg;
      $checkSt = false;
    }

    // パスワード(確認用)
    list($itemCheckSt, $err_msg) = ValidCheck::validPasswordConfirm($params['pass'], $params['pass2']);
    if(!$itemCheckSt)
    {
      $checkErrMsg['pass2'] = $err_msg;
      $checkSt = false;
    }

    // メールアドレス
    list($itemCheckSt, $err_msg) = ValidCheck::validEmail($params['email']);
    if(!$itemCheckSt)
    {
      $checkErrMsg['email'] = $err_msg;
      $checkSt = false;
    }

    // 性別
    list($itemCheckSt, $err_msg) = ValidCheck::validSex($params['sex']);
    if(!$itemCheckSt){
      $checkErrMsg['sex'] = $err_msg;
      $checkSt = false;
    }

    // 役職
    list($itemCheckSt, $err_msg) = ValidCheck::validOfficer($params['officer']);
    if(!$itemCheckSt)
    {
      $checkErrMsg['officer'] = $err_msg;
      $checkSt = false;
    }

    // プロフィール
    list($itemCheckSt, $err_msg) = ValidCheck::validProfile($params['profile']);
    if(!$itemCheckSt)
    {
      $checkErrMsg['profile'] = $err_msg;
      $checkSt = false;
    }

    // 生年月日
    list($itemCheckSt, $err_msg) = ValidCheck::validBirth($params['birth']);
    if(!$itemCheckSt)
    {
      $checkErrMsg['birth'] = $err_msg;
      $checkSt = false;
    }

    // 顔写真
    list($itemCheckSt, $err_msg) = ValidCheck::validFaceImg($faceImg);
    if(!$itemCheckSt)
    {
      $checkErrMsg['face_img'] = $err_msg;
      $checkSt = false;
    }
    else
    {
      // $faceImg = $_FILES['face_img'];
      move_uploaded_file($faceImg['tmp_name'], '../../public/admin/img/' . $faceImg['name']);
    }

    return [$itemCheckSt, $checkErrMsg];
  }

  public static function edit_check($params, $faceImg)
  {
    $checkErrMsg = array();
    $checkSt = true;

    // ログインID
    list($itemCheckSt, $err_msg) = ValidCheck::validLoginId($params['login_id']);
    if(!$itemCheckSt)
    {
      $checkErrMsg['login_id'] = $err_msg;
      $checkSt = false;
    }

    // パスワード
    list($itemCheckSt, $err_msg) = ValidCheck::validPasswordMatch($params['pass'], $params['db_pass']);
    if(!$itemCheckSt)
    {
      $checkErrMsg['pass'] = $err_msg;
      $checkSt = false;
    }

    // メールアドレス
    list($itemCheckSt, $err_msg) = ValidCheck::validEmail($params['email']);
    if(!$itemCheckSt)
    {
      $checkErrMsg['email'] = $err_msg;
      $checkSt = false;
    }

    // 性別
    list($itemCheckSt, $err_msg) = ValidCheck::validSex($params['sex']);
    if(!$itemCheckSt)
    {
      $checkErrMsg['sex'] = $err_msg;
      $checkSt = false;
    }

    // 役職
    list($itemCheckSt, $err_msg) = ValidCheck::validOfficer($params['officer']);
    if(!$itemCheckSt)
    {
      $checkErrMsg['officer'] = $err_msg;
      $checkSt = false;
    }

    // プロフィール
    list($itemCheckSt, $err_msg) = ValidCheck::validProfile($params['profile']);
    if(!$itemCheckSt)
    {
      $checkErrMsg['profile'] = $err_msg;
      $checkSt = false;
    }

    // 生年月日
    list($itemCheckSt, $err_msg) = ValidCheck::validBirth($params['birth']);
    if(!$itemCheckSt)
    {
      $checkErrMsg['birth'] = $err_msg;
      $checkSt = false;
    }

    // 顔写真
    list($itemCheckSt, $err_msg) = ValidCheck::validFaceImg(($faceImg));
    if(!$itemCheckSt)
    {
      $checkErrMsg['face_img'] = $err_msg;
      $checkSt = false;
    }
    // $faceImg = $_FILES['face_img'];
    if(!empty($faceImg['name']) && $params['old_face_img'] !== $faceImg['name'])
    {
      unlink('../../public/admin/img/' . $params['old_face_img']);
      move_uploaded_file($faceImg['tmp_name'], '../../public/admin/img/' . $faceImg['name']);
    }

    return [$checkSt, $checkErrMsg];
  }
}

?>
