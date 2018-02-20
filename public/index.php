<?php
use Psr\Http\Message\ServerRequestInterface;

use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Diactoros\ServerRequestFactory;
use Zend\Diactoros\Response\SapiEmitter;

require __DIR__ . '/../vendor/autoload.php';
$request = ServerRequestFactory::fromGlobals();

// почти контроллер :)
$path = $request->getUri()->getPath();
$action = null;
if ($path === '/') {
    $action = function (ServerRequestInterface $request) {
        $name = $request->getQueryParams()['name'] ?? 'Guest';
        return new HtmlResponse("Hello {$name}");
    };
} elseif ($path === '/about') {
    $action = function (ServerRequestInterface $request) {
        return new HtmlResponse("About. Simple site.");
    };
} elseif ($path === '/blog') {
    $action = function (ServerRequestInterface $request) {
        return new JsonResponse([
            ['id'=>1, 'title'=>'First post'],
            ['id'=>2, 'title'=>'Second post'],
        ]);
    };
} elseif (preg_match('#^/blog/(?P<id>[0-9]+)$#i', $path, $matches)) {
    $request = $request->withAttribute('id', $matches['id']);
    $action = function (ServerRequestInterface $request) {
        $id = $request->getAttribute('id');
        if ($id) {
            return new JsonResponse(['id'=>$id,'title'=>"Post #{$id}"]);
        }
        return new JsonResponse(['error'=>'Undefined post'], 404);
    };
}

if ($action) {
    $response = $action($request);
} else {
    $response = new JsonResponse(['error'=>'Page not found'], 404);
}

// Post processing
$response = $response->withHeader('X-Engine', 'Simple php framework');
// Sender to
$emitter = new SapiEmitter();
// отправить ответ
$emitter->emit($response);
