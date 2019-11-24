<?php

namespace Models;

use Core\Connection;
use Exception;
use Helpers\DataFilter;
use Helpers\UILogger;

class Product
{
  public static function validate(array $data): bool
  {
    $response = true;

    if (self::bySku($data['sku'], (isset($data['id'])) ? $data['id'] : null) > 0) {
      UILogger::in('already exists', 2);
      $response = false;
    }

    if (empty(DataFilter::text($data['sku']))) {
      UILogger::in('please inform sku', 2);
      $response = false;
    }

    if (empty(DataFilter::text($data['name']))) {
      UILogger::in('Please inform Name', 2);
      $response = false;
    }

    if (empty(DataFilter::integer($data['quantity']))) {
      UILogger::in('Plase inform quantity', 2);
      $response = false;
    }

    if (empty(DataFilter::text($data['description']))) {
      UILogger::in('Plase inform description', 2);
      $response = false;
    }

    if (empty(DataFilter::cash($data['price']))) {
      UILogger::in('Plase inform price', 2);
      $response = false;
    }
    return $response;
  }

  public static function getCategories(int $id)
  {
    return Connection::table('prod_cat as pc')->select('c.*')
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

  public static function byId(int $id)
  {
    return Database::table('product')->select('*')->where('id', $id)->get()->count();
  }
  public static function insert(array $data)
  {
    if (!self::validate($data)) {
      return false;
    }
    Connection::beginTransaction();
    $response = true;

    try {
      if ($product_id = Database::table('product')
        ->insertGetId(['sku' => $data['sku'], 'name' => $data['name'], 'description' => $data['description'], 'quantity' => $data['quantity'], 'price' => $data['price'], 'created_at' => date("Y-m-d H:i:s")])
      ) {
        foreach ($data['categories'] as $category) {
          if (!Connection::table('prod_cat')->insertGetID(['produto_id' => $product_id, 'category_id' => $category])) {
            $response = false;
          }
        }
      }
      if ($response) {
        UILogger::in('Product registred', 1);
        Connection::commit();
        return true;
      }
    } catch (Exception $e) {
      Connection::rollback();
      UILogger::in('Not registred', 2);
      return false;
    }
    UILogger::in('not registred', 2);
    return false;
  }

  public static function update(array $data): bool
  {
    if (!self::validate($data)) {
      return false;
    }
    Database::beginTransaction();
    $response = true;

    try {
      if (!Connection::table('prod_cat')->where('product_id', $data['id'])->delete()) {
        $response = false;
      }

      if ($product_id = Connection::table('product')->where('id', $data['id'])->update([
        'sku'         => $data['sku'],
        'name'        => $data['name'],
        'description' => $data['description'],
        'quantity'    => $data['quantity'],
        'price'       => $data['price']

      ])) {
        foreach ($data['categories'] as $category) {
          if (!Connection::table('prod_cat')->insertGetId(['product_id' => $product_id, 'category_id' => $category])) {
            $response = false;
          }
        }
      }
      if ($response) {
        UILogger::in('updated Product', 1);
        Connection::commit();
        return true;
      }
    } catch (Exception $e) {
      UILogger::in('Erro', 2);
      Connection::rollback();
      return false;
    }

    UILogger::in('not updated', 2);
    return false;
  }

  public static function delete(int $id): bool
  {

    if (self::byId($id) > 0) {
      if (Connection::table('product')->where('id', $id)->delete()) {
        UILogger::in('deleted product', 1);
        return true;
      }
    }
    UILogger::in('Not deletet', 2);
    return false;
  }
}
