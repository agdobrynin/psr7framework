<?php
/**
 * Simple PHP PSR-7 Framework
 */

use Zend\Diactoros\ServerRequestFactory;
use Zend\Diactoros\Response\SapiEmitter;
use Zend\Diactoros\Response\JsonResponse;

use Framework\Http\Router\RouteCollection;
use Framework\Http\Router\Router;

use Framework\Http\Router\Exception\RouteNotFoundException;
use Framework\Http\Router\Exception\RequestNotMatchedException;
use App\Http\Action;

require __DIR__ . '/../vendor/autoload.php';

$RouteCollection = new RouteCollection();

$RouteCollection->get('home', '/', new Action\HelloAction());
$RouteCollection->get('about', '/about', new Action\AboutAction());
$RouteCollection->get('blog', '/blog', new Action\Blog\IndexAction());
$RouteCollection->get('blog_show', '/blog/{id}', new Action\Blog\ShowAction(), ['id'=>'\d+']);

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
