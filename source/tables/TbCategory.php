<?php

namespace Tables;


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Capsule\Manager as Capsule;

class TbCategory extends Migration
{

  public static function createTable()
  {
    if (!self::verify()) {
      return false;
    }

    Capsule::schema()->Create('category', function ($table) {
      $table->increments('id')->unsigned();
      $table->string('name')->unique();
      $table->timestamps();
    });
  }
}
