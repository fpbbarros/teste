<?php 

namespace Interfaces;

interface IDataFilter {
  public static function text($data);
  public static function float($data);
  public static function integer($data);
  public static function cash($data);
}