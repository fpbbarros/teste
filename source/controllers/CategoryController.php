<?php

namespace Controllers;

use Helpers\ObjToJson;
use Models\Category;

class CategoryController
{
  public static function get(int $id = null)
  {
    return ObjToJson::objToJson(Category::get($id));
  }

  public static function insert(array $data)
  {
    return Category::insert($data);
  }

  public static function delete(int $data)
  {
    return Category::delete($data);
  }

  public static function update(array $data)
  {
    return Category::update($data);
  }
}
