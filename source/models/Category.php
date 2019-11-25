<?php

namespace Models;

use Core\Connection;
use Helpers\UILogger;

class Category
{

  //busca
  public static function get(int $id = null, string $code = null)
  {

    
    if (!is_null($code)) {
      return Connection::table('category')->select('*')->where('code', $code)->get();
    }
    if (!is_null($code)) {
      return Connection::table('category')->find($id);
    } else {
      return Connection::select('select * from category');
    }
  }

  public static function byId(int $id)
  {
    if (!is_null($id)) {
      return Connection::table('category')->select('*')->where('id', $id)->get()->count();
    }
  }

  public static function byName(string $name, int $id = null)
  {
    if (empty($id)) {
      return Connection::table('category')->select('*')->where('name', $name)->get()->count();
    } else {
      return Connection::table('category')->select('*')->where('name', $name)->where('id', '<>', $id)->get()->count();
    }
  }

  public static function byCode(string $code, int $id = null)
  {
    if (empty($id)) {
      return Connection::table('category')->select('*')->where('code', $code)->get()->count();
    } else {
      return Connection::table('category')->select('*')->where('code', $code)->where('id', '<>', $id)->get()->count();
    }
  }

  //verificacao
  public static function validate(array $data): bool
  {
    $validation = true;
    if (isset($data['name']) && strlen($data['name']) < 1) {
      UILogger::in('invalid name!', 2);
      $validation = false;
    }
    if (isset($data['code']) && strlen($data['code']) < 1) {
      UILogger::in('invalid code!', 2);
      $validation = false;
    }
    return $validation;
  }


  //crud
  public static function insert(array $data): int
  {
    if (self::byName($data['name']) != 0 || self::byCode($data['code']) != 0) {
      return false;
    }
    if (!self::validate(($data))) {
      return false;
    }
    if ($id = Connection::table('category')->insertGetId(['name' => $data['name'], 'code' => $data['code']])) {
      UILogger::in('Registered category', 1);
      return $id;
    }
    UILogger::in('not registered', 2);
    return false;
  }


  public static function update(array $data): bool
  {
    if (self::byName($data['name'], $data['id']) != 0 && self::byCode($data['code'], $data['id']) != 0) {
      return false;
    }
    if (!self::validate(($data))) {
      return false;
    }
    if (Connection::table('category')->where('id', $data['id'])->update(['name' => $data['name'], 'code' => $data['code']])) {
      UILogger::in('updated category', 1);
      return true;
    }
    UILogger::in('not updated', 2);
    return false;
  }

  public static function delete(int $id): bool
  {
    if (self::byId($id) > 0) {
      if (Connection::table('category')->where('id', $id)->delete()) {
        UILogger::in('deleted category', 2);
        return true;
      }
    }
    UILogger::in('not deleted!', 2);
    return false;
  }
}
