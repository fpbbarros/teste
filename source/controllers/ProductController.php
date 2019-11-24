<?php

namespace Controllers;

use Helpers\ObjToJson;
use Models\Product;

class ProductController
{
  public static function get(int $id = null)
  {
    return ObjToJson::objToJson(Product::byId($id));
  }

  public static function insert(array $data)
  {
    return Product::insert($data);
  }

  public static function update(array $data)
  {
    return Product::update($data);
  }

  public static function delete(int $data)
  {
    return Product::delete($data);
  }
}
