<?php
use Psr\Http\Message\ServerRequestInterface;

use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Diactoros\ServerRequestFactory;
use Zend\Diactoros\Response\SapiEmitter;
use Framework\Http\Router\RouteCollection;
use Framework\Http\Router\Router;
use Framework\Http\Router\Exception\RouteNotFoundException;
use Framework\Http\Router\Exception\RequestNotMatchedException;

require __DIR__ . '/../vendor/autoload.php';

$RouteCollection = new RouteCollection();

$RouteCollection->get('home', '/', function (ServerRequestInterface $request) {
    $name = $request->getQueryParams()['name'] ?? 'Guest';
    return new HtmlResponse("Hello {$name}");
});

$RouteCollection->get('about', '/about', function () {
    return new HtmlResponse("About. Simple site.");
});

$RouteCollection->get('blog', '/blog', function () {
    return new JsonResponse([
        ['id'=>1, 'title'=>'First post'],
        ['id'=>2, 'title'=>'Second post'],
    ]);
});

$RouteCollection->get('blog_show', '/blog/{id}', function (ServerRequestInterface $request) {
    $id = $request->getAttribute('id');
    if ($id) {
        return new JsonResponse(['id'=>$id,'title'=>"Post #{$id}"]);
    }
    return new JsonResponse(['error'=>'Undefined post'], 404);
}, ['id'=>'\d+']);

$Router = new Router($RouteCollection);
$request = ServerRequestFactory::fromGlobals();

try {
    $res = $Router->match($request);
    foreach ($res->getAttributes() as $attr => $val) {
        $request = $request->withAttribute($attr, $val);
    }
    $action = $res->getHandler();
    $response = $action($request);
} catch (RequestNotMatchedException $e) {
    $response = new JsonResponse(['error'=>'Undefined page'], 404);
}

// Post processing
$response = $response->withHeader('X-Engine', 'Simple php framework');
// Sender to
$emitter = new SapiEmitter();
// отправить ответ
$emitter->emit($response);
