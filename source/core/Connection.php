<?php

/**Documetation on https://packagist.org/packages/illuminate/database */

namespace Core;

use Illuminate\Container\Container;
use Illuminate\Events\Dispatcher;

class Connection extends Capsule{

  public static function run(Capsule $cap){
    $cap ->addConnection([
      'drive'          =>   DATABASE['DRIVE'],
      'host'           =>   DATABASE['HOST'],
      'database'       =>   DATABASE['DATABASE'],
      'username'       =>   DATABASE['USER'],
      'password'       =>   DATABASE['PASS'],
      'charsert'       =>   DATABASE['CARSET'],
      'collation'      =>   DATABASE['COLLATION'],
      'prefix'         =>   DATABASE['PREFIX'],
      
    ]);

    $cap->setEventDispatcher(new Dispatcher(new Container));
    $cap->setAsGlobal();
    $cap->bootEloquent();
  }

}

