<?php
require __DIR__ . "/../vendor/autoload.php";

use Controllers\CategoryController;
use Controllers\ProductController;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\Request;


$router->add('/product', function () {
  return new Response(ProductController::get());
});

$router->add('/product/one/{id}', function ($id) {
  return new Response(ProductController::get($id));
});

$router->add('/product/insert', function () {
  $request = Request::createFromGlobals();
  ProductController::insert($request->request->get('product'));
  header("Location: " . BASE_URL . "/products.php");
});


$router->add('/product/update', function () {
  $request = Request::createFromGlobals();
  ProductController::update($request->request->get('product'));
  header("Location: " . BASE_URL . "/products.php");
});

$router->add('/product/delete/{id}', function ($id) {
  ProductController::delete($id);
  header("Location: " . BASE_URL . "/produtcs.php");
});

/** Routes Categories */

$router->add('/category', function () {

  return new Response(CategoryController::get());
});

$router->add('/category/one/{id}', function ($id) {
  return new Response(CategoryController::get($id));
});

$router->add('/category/insert', function () {
  $request = Request::createFromGlobals();
  CategoryController::insert($request->require->get('category'));
  header("Location: " . BASE_URL . "/categories.php");
});


$router->add('/category/update', function () {
  $request = Request::createFromGlobals();
  CategoryController::update($request->request->get('category'));
  header("Location: " . BASE_URL . "/categories");
});
