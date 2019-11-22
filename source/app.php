<?php


require __DIR__ . "/../vendor/autoload.php";
require __DIR__ . "/config.php";

use Core\Router;
use Symfony\Component\HttpFoundation\Request;
use Tables\TbProdCat;
use Tables\TbCategory;
use Tables\TbProduct;

if (DEBUG) {
  ini_set('display_errors', 1);
  ini_set('display_startp_errors', 0);
  error_reporting(E_ALL);
} else {
  ini_set('display_error', 0);
  ini_set('display_error', 0);
  error_reporting(0);
}


/**
 * Inicializacao da base de dados da aplicacao
 */

Database::run(new Capsule);
TbProdCat::createTable();
TbCategory::createTable();
TbProduct::createTable();


$request = Request::createFromGlobals();

/** Rotas */

$router = new Router();
require __DIR__ . "/routes.php";


/**Callback */

$response = $router->handleRoutes($request);
$response->send();