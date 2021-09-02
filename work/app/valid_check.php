<?php

namespace MyApp;

class ValidCheck
{
  public static function validLoginId($loginId)
  {
    $ret = true;
    $err_msg = '';

    if(empty($loginId))
    {
      $ret = false;
      $err_msg = "ログインIDが入力されていません。";
    }
    else if(!ValidCheck::validMaxLen($loginId, 'id'))
    {
      $ret = false;
      $err_msg = 'ログインIDは最大20文字以内で入力してください。';
    }

    return [$ret, $err_msg];
  }

  public static function validPassword($pass)
  {
    $ret = true;
    $err_msg = '';

    if(empty($pass))
    {
      $ret = false;
      $err_msg = 'パスワードが入力されていません。';
    }
    else if(!ValidCheck::validPass($pass))
    {
      $ret = false;
      $err_msg = 'パスワードが不正です。';
    }
    else if(!ValidCheck::validMaxLen($pass, 'pass') || !ValidCheck::validMinLen($pass, 'pass'))
    {
      $ret = false;
      $err_msg = 'パスワードは8文字以上20文字以内で入力してください。';
    }

    return [$ret, $err_msg];
  }

  public static function validPasswordConfirm($pass, $pass2)
  {
    $ret = true;
    $err_msg = '';
    if($pass != $pass2)
    {
      $ret = false;
      $err_msg = 'パスワードが一致しません。';
    }
    
    return [$ret, $err_msg];
  }

  public static function validPasswordMatch($pass, $db_pass)
  {
    $ret = true;
    $err_msg = '';
    if(!password_verify($pass, $db_pass))
    {
      $ret =  false;
      $err_msg = 'パスワードに誤りがあります。';
    }

    return [$ret, $err_msg];
  }

  public static function validEmail($email)
  {
    $ret = true;
    $err_msg = '';

    if(empty($email))
    {
      $ret = false;
      $err_msg = 'メールアドレスが入力されていません。';;
    }
    else if(!ValidCheck::_validEmail($email))
    {
      $ret = false;
      $err_msg = '不正な形式のメールアドレスです。';
    }

    return [$ret, $err_msg];
  }

  public static function validSex($sex)
  {
    $ret = true;
    $err_msg = '';

    if(is_null($sex))
    {
      $ret = false;
      $err_msg = '性別を選択してください。';
    }
    else if('male' !== $sex && 'female' !== $sex)
    {
      $ret = false;
      $err_msg = '性別を選択してください。';
    }

    return [$ret, $err_msg];
  }

  public static function validOfficer($officer)
  {
    $ret = true;
    $err_msg = '';

    if("none" === $officer)
    {
      $ret = false;
      $err_msg = '役職を選択してください。';
    }

    return [$ret, $err_msg];
  }

  public static function validProfile($profile)
  {
    $ret = true;
    $err_msg = '';

    if(empty($profile))
    {
      $ret = false;
      $err_msg = 'プロフィールを入力してください。';
    }
    else if(!ValidCheck::validMaxLen($profile, 'profile'))
    {
      $ret = false;
      $err_msg = 'プロフィールは200文字以内で入力してください。';
    }

    return [$ret, $err_msg];
  }

  public static function validBirth($birth)
  {
    $ret = true;
    $err_msg = '';

    if(empty($birth))
    {
      $ret = false;
      $err_msg = '生年月日を入力してください。';
    }

    return [$ret, $err_msg];
  }

  public static function validFaceImg($faceImg)
  {
    $ret = true;
    $err_msg = '';

    if(empty($faceImg))
    {
      $ret = false;
      $err_msg = '顔写真を選択してください。';
    }
    else if(2000000 < $faceImg['size'])
    {
      $ret = false;
      $err_msg = 'サイズが大きすぎます。';
    }

    return [$ret, $err_msg];
  }

  private static function validPass($pass)
  {
    if(preg_match('/\A(?=.*?[a-z])(?=.*?\d)[a-z\d]{8,100}+\z/i', $pass))
    {
      return true;
    }
    else
    {
      return false;
    }
  }

  private static function _validEmail($email)
  {
    if(filter_var($email, FILTER_VALIDATE_EMAIL))
    {
      return true;
    }
    else
    {
      return false;
    }
  }
  
  private static function validMaxLen($str, $item)
  {
    $ret = true;
  
    switch($item)
    {
      case 'id':
        if(20 < strlen($str))
        {
          $ret = false;
        }
        break;
      
      case 'pass':
        if(16 < strlen($str))
        {
          $ret = false;
        }
        break;

      case 'profile':
        if(200 < strlen($str))
        {
          $ret = false;
        }
        break;
      
      default:
        break;
    }
  
    return $ret;
  }
  
  private static function validMinLen($str, $item)
  {
    $ret = true;
  
    switch($item)
    {
      case 'pass':
        if(8 > strlen($str))
        {
          $ret = false;
        }
        break;
      default:
        break;
    }
  
    return $ret;
  }
}