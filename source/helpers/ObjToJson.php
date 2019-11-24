<?php

namespace Helpers;

use Interfaces\IObjToJson;

class ObjToJson implements IObjToJson
{
  public static function objToJson($data)
  {
    return json_decode($data);
  }
}
