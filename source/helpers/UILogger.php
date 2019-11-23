<?php

namespace Helpers;

class UILogger implements ILogger
{

  public static function error(string $message)
  {
    return "<h5 style='color:red' >" . $message . "</h5>";
  }

  public static function success(string $message)
  {
    return "<h5 style='color:green' >" . $message . "</h5>";
  }

  public static function in(string $message, int $type)
  {
    $return = "";
    if ($type == 1) {
      $return .= self::success($message);
    } elseif ($type == 2) {
      $return .= self::error($message);
    }

    if (!isset($_SESSION)) {
      session_start();
    }
    if (!empty($_SESSION["LOG"])) {
      $_SESSION["LOG"] = "";
    }
    $_SESSION["LOG"] = $return;
  }

  public static function out()
  {
    if (!isset($_SESSION)) {
      session_start();
    }

    $message = $_SESSION["LOG"] ?? "";
    unset($_SESSION["LOG"]);
    echo $message;
  }
}



/**
 * Documentação 
 */
