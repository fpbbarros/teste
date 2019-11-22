<?php

namespace Tables;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Capsule\Manager as Capsule;

class TbProduct extends Migration
{

  public static function createTable()
  {
    if (!self::verify()) {
      return false;
    }

    Capsule::schema()->Create('product', function ($table) {
      $table->increments('id')->unsigned();
      $table->string('sku')->unique();
      $table->string('name');
      $table->string('description');
      $table->integer('quantity');
      $table->unsignedDecimal('price', 10, 2);
      $table->timestamps();
    });
  }
}
