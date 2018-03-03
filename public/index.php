<?php
/**
 * Simple PHP PSR-7 Framework
 */

use Zend\Diactoros\ServerRequestFactory;
use Zend\Diactoros\Response\SapiEmitter;
use Zend\Diactoros\Response\JsonResponse;

use Framework\Http\Router\RouteCollection;
use Framework\Http\Router\SimpleRouter;
use Framework\Http\Router\Exception\RouteNotFoundException;
use Framework\Http\Router\Exception\RequestNotMatchedException;
use Framework\Http\ActionResolver;

use App\Http\Action;


require __DIR__ . '/../vendor/autoload.php';

$RouteCollection = new RouteCollection();

$RouteCollection->get('home', '/', Action\HelloAction::class);
$RouteCollection->get('about', '/about', Action\AboutAction::class);
$RouteCollection->get('blog', '/blog', Action\Blog\IndexAction::class);
$RouteCollection->get('blog_show', '/blog/{id}', Action\Blog\ShowAction::class, ['id'=>'\d+']);

$Router = new SimpleRouter($RouteCollection);
$Resolver = new ActionResolver();

$request = ServerRequestFactory::fromGlobals();

try {
    $res = $Router->match($request);
    foreach ($res->getAttributes() as $attr => $val) {
        $request = $request->withAttribute($attr, $val);
    }
    $handler = $res->getHandler();
    $action = $Resolver->resolve($handler);
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
