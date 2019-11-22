<?php

namespace Core;

use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\RouteCollection;


/**Classe responsavel por tratar as rotas da aplicação */
class Router implements HttpKernelInterface
{

  //** Variaveis  */

  protected $routes = [];


  public function __construct()
  {
    $this->routes = new RouteCollection();
  }

  public function handleRoutes(Request $request, $type = HttpKernelInterface::MASTER_REQUEST, $catch = true)
  {
    $requestContext = (new RequestContext())->fromRequest($request);
    $matcherUrl =  new UrlMatcher($this->routes, $requestContext);
    try {
      $attr = $matcherUrl->match($requestContext->getPathInfo());
      $controller = $attr['controller'];
      unset($attr['controller']);
      $res = call_user_func_array($controller, $attr);
    } catch (ResourceNotFoundException $e) {
      $res = new Response('Page not found.', Response::HTTP_NOT_FOUND);
    }
    return $res;
  }

  public function add($route, $controller)
  {
    $this->routes - add($route, new Router($route, ['controller' => $controller]));
  }
}
