<?php

define(BASE_URL, "http://localhost/assessment");

define("SITE", "WebJump");

define(DATABASE, [
  'DRIVE'     => 'mysql',
  'HOST'      => 'localhost',
  'NAME'      => 'desadio',
  'USER'      => 'root',
  'PASS'      => '',
  'CHARSET'   => 'utf8',
  'COLLATION' => 'utf8_unicode_ci',
  'PREFIX'    => ''
]);

define(DEBUG, true);


function url(string $uri = null): string
{
  if ($uri) {
    return BASE_URL . "/{$uri}";
  }
  return BASE_URL;
}
