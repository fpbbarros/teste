<?php

namespace Tables;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Capsule\Manager as Capsule;

class TbProdCat extends Migration
{

  public static function createTable()
  {
    if (!self::verify()) {
      return false;
    }

    Capsule::schema()->Create('prod_cat', function ($table) {
      $table->increments('id')->unsigned();
      $table->integer('product_id')->unsigned();
      $table->integer('category_id')->unsigned();

      $table->foreign('product_id')->references('id')->on('product')->onDelete('cascade')->onUpdate('cascade');
      $table->foreign('category_id')->references('id')->on('category')->onDelete('cascade')->onUpdate('cascade');          
      $table->timestamps();
    });
  }
}
