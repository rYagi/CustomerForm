<?php

class Response {
  public $statusCode;
  public $statusText;
  public $httpHeaders;
  public $content;

  function __construct(int $statusCode, string $statusText, array $httpHeaders, string $content) {
    $this->statusCode = $statusCode;
    $this->statusText = $statusText;
    $this->httpHeaders = $httpHeaders;
    $this->content = $content;
  }

  function send() : void {
    header("HTTP/1.1 {$this->statusCode} {$this->statusText}");
    foreach ($this->httpHeaders as $name => $value) {
      header("{$name}: {$value}");
    }
    echo $this->content;
  }

  public static function ok(string $content) : Response {
    return new Response(200, 'OK', [], $content);
  }
  // 今回は未使用のためコメントアウト
  // public static function redirect(string $pathInfo) : Response {
  //   $protocol = ($_SERVER['HTTPS'] ?? '') === 'on' ? 'https://' : 'http://';
  //   $url= $protocol . $_SERVER['HTTP_HOST'] . $pathInfo;
  //   return new Response(302, 'Found', [ 'Location' => $url], '');
  // }
  public static function badRequest(string $content) : Response {
    return new Response(400, 'Bad Request', [], $content);
  }
  // 今回は未使用のためコメントアウト
  // public static function forbidden(string $content) : Response {
  //   return new Response(403, 'Forbidden', [], $content);
  // }
  public static function notFound(string $content) : Response {
    return new Response(404, 'Not Found', [], $content);
  }
  public static function internalServerError(string $content) : Response {
    return new Response(500, 'Internal Server Error', [], $content);
  }
}

