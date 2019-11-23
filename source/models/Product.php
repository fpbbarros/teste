<?php

namespace Models;

use Core\Connection;

class Product
{


  public static function getCategories(int $id)
  {
    return Connection::table('product_category as pc')->select('c.*')
      ->join('category as c', 'pc.category_id', '=', 'c.id')
      ->where('pc.product_id', $id)->get();
  }

  public static function get(int $id = null)
  {
    if (!is_null($id)) {
      $product = Connection::table('product')->find($id);
      $prodCats = self::getCategories($product->id);
      foreach ($prodCats as $prodCat) {
        $product->categories[] = (array) $prodCat;
      }
      return $product;
    } else {
      $products = Connection::select('select * from product');
      foreach ($products as $product) {
        $prodCats = self::getCategories($product->id);
        foreach ($prodCats as $prodCat) {
          $product->categories[] = (array) $product;
        }
      }
      return $products;
    }
  }

  public static function bySku(string $sku, int $id = null)
  {
    if (is_null($id)) {
      return Connection::table('product')->select('*')->where('sku', $sku)->get()->count();
    }
    return Connection::table('product')->select('*')->where('sku', $sku)
      ->where('id', '<>', $id)->get()->count();
  }
}
