<?php

namespace MyApp;

require_once(__DIR__ . '/../../app/valid_check.php');

use MyApp\ValidCheck;

class AdminAddValid
{
  public static function check($params, $faceImg)
  {
    $checkErrMsg = array();
    $checkSt = true;

    // ログインID
    list($checkSt, $err_msg) = ValidCheck::validLoginId($params['login_id']);
    if(!$checkSt)
    {
      $checkErrMsg['login_id'] = $err_msg;
    }

    // パスワード
    list($checkSt, $err_msg) = ValidCheck::validPassword($params['pass']);
    if(!$checkSt)
    {
      $checkErrMsg['pass'] = $err_msg;
    }

    // パスワード(確認用)
    list($checkSt, $err_msg) = ValidCheck::validPasswordConfirm($params['pass'], $params['pass2']);
    if(!$checkSt)
    {
      $checkErrMsg['pass2'] = $err_msg;
    }

    // メールアドレス
    list($checkSt, $err_msg) = ValidCheck::validEmail($params['email']);
    if(!$checkSt)
    {
      $checkErrMsg['email'] = $err_msg;
    }

    // 性別
    list($checkSt, $err_msg) = ValidCheck::validSex($params['sex']);
    if(!$checkSt){
      $checkErrMsg['sex'] = $err_msg;
    }

    // 役職
    list($checkSt, $err_msg) = ValidCheck::validOfficer($params['officer']);
    if(!$checkSt)
    {
      $checkErrMsg['officer'] = $err_msg;
    }

    // プロフィール
    list($checkSt, $err_msg) = ValidCheck::validProfile($params['profile']);
    if(!$checkSt)
    {
      $checkErrMsg['profile'] = $err_msg;
    }

    // 生年月日
    list($checkSt, $err_msg) = ValidCheck::validBirth($params['birth']);
    if(!$checkSt)
    {
      $checkErrMsg['birth'] = $err_msg;
    }

    // 顔写真
    list($checkSt, $err_msg) = ValidCheck::validFaceImg($faceImg);
    if(!$checkSt)
    {
      $checkErrMsg['face_img'] = $err_msg;
    }
    else
    {
      $faceImg = $_FILES['face_img'];
      move_uploaded_file($faceImg['tmp_name'], '../../public/admin/img/' . $faceImg['name']);
    }

    return [$checkSt, $checkErrMsg];
  }
}

?>
