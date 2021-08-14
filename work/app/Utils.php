<?php

namespace MyApp;

class Utils
{
  public static function h($str)
  {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
  }

  public static function post_h($strings)
  {
    foreach($strings as $key => $value)
    {
      $clean[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }

    return $clean;
  }
}