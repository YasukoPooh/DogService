<?php

namespace MyApp;

class CsrfValid
{
  const HASH_ALGO = 'sha256';
  private static $token = 0;

  private static function generate()
  {
    if(session_status() === PHP_SESSION_NONE)
    {
      throw new \BadMethodCallException('Session is not active.');
    }
    // $_SESSION['token'] = bin2hex(random_bytes(32)); 
    return hash(self::HASH_ALGO, session_id());
  }

  public static function create($loginId)
  {
    if(session_status() !== PHP_SESSION_NONE)
    {
      if(empty($_SESSION['token']))
      {
        $_SESSION['token'] = self::generate();
        $_SESSION['login_id'] = $loginId;
        self::$token = $_SESSION['token'];
      }
    }
  }

  public static function validate()
  {
    $valid = true;
    // if(empty($_SESSION['token']) ||
    //   $_SESSION['token'] !== filter_input(INPUT_POST, 'token'))
    if(!isset($_SESSION['token']) && self::$token !== $_SESSION['token'])
    {
      $valid = false;
    }
    return $valid;
  }

  public static function destroy()
  {
    $_SESSION = array();
    if(isset($_COOKIE[session_name()]))
    {
      setcookie(session_name(), '', time()-42000, '/');
    }
    self::$token = 0;
  }
}
?>
