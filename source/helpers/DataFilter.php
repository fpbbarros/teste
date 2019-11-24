<?php

namespace Helpers;

use Interfaces\IDataFilter;

class DataFilter implements IDataFilter
{
  public static function text($data)
  {
    return filter_var($data, FILTER_SANITIZE_STRING);
  }

  public static function float($data)
  {
    return filter_var($data, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
  }

  public static function integer($data)
  {
    return filter_var($data, FILTER_SANITIZE_NUMBER_INT);
  }

  public static function cash($data)
  {
    return filter_var($data, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION, 2, ".", "");
  }
}
