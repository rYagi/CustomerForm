<?php
require_once 'Controller/Response.php';
require_once 'Controller/PreparingForView.php';
require_once 'Exception.php';

class Routing {
  private static $routesGET = [
    '/' => 'form',
  ];

  private static $routesPOST = [
    '/'         => 'postForm',
    '/confirm'  => 'postConfirm',
    '/complete' => 'postComplete'
  ];

  public function getPathInfo() : string {
    $pathInfo = '/';
    if(isset($_SERVER['PATH_INFO'])){
      $pathInfo = $_SERVER['PATH_INFO'];
    } else if(isset($_GET['path-info'])){
      $pathInfo = $_GET['path-info'];
    }
    return $pathInfo;
  }

  public function respond(string $pathInfo, callable $onError) : void {
    try{
      if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $response = $this->getResponse($pathInfo, self::$routesGET);
      } else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $response = $this->getResponse($pathInfo, self::$routesPOST);
      }

      if (isset($response)) {
        $response->send();
      } else {
        throw new Exception404();
      }
    } catch(Exception $e) {
      $onError($e)->send();
    }
  }

  private function getResponse(string $pathInfo, array $callbackMap) : ?Response {
    foreach ($callbackMap as $route => $f) {
      $matches = $this->matchRoute($route, $pathInfo);
      if (isset($matches)) {
        return call_user_func_array(array('PreparingForView', $f), $matches);
      }
    }
    return null;
  }

  private function matchRoute(string $route, string $pathInfo) : ?array {
    $pattern = preg_replace('#:[^/]+#','([^/]+)', $route);
    $matches = [];
    if (preg_match("#^{$pattern}$#", $pathInfo, $matches) === 1) {
      array_shift($matches);
      return $matches;
    } else {
      return null;
    }
  }

  private function onError(\Exception $e) : Response {
    if($e instanceof Exception400) {
      return Response::badRequest('400 Bad Request');
    // 今回は未使用のためコメントアウト
    // } else if($e instanceof Exception403) {
    //   return Response::forbidden('403 Forbidden');
    } else if($e instanceof Exception404) {
      return Response::notFound('404 Not Found');
    }else{
      return Response::internalServerError('500 Internal Server Error');
    }
  }
}
